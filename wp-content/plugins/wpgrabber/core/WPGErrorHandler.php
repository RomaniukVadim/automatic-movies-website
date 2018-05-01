<?php
/**
* WPGErrorHandler
* 
* @version 1.0.1
* @author Top-Bit <info@top-bit.ru>
* @copyright 2009-2016 Top-Bit
* @link http://top-bit.ru
*/
  
class WPGErrorHandler {

  // Критическое кол-во ошибок для отправки
  private static $MAX_ERRORS_COUNT_TO_SEND = 10;

  // Критическое кол-во ошибок для очистки базы
  private static $MAX_ERRORS_COUNT_TO_CLEAR = 1000;

  // Критический период для отправки (30 дней)
  private static $MAX_PERIOD_TO_SEND = 2592000;

  public static function add($message, $file, $line) {
    global $wpdb;
    if (get_option('wpg_logErrors')) {
      $file = $file.':'.$line;
      if (strlen($file) > 250) {
        $file = '...'.substr($file, -250);
      }
      if (strlen($message) > 250) {
        $message = substr($message, 0, 250).'...';
      }
      $sql = 'INSERT IGNORE INTO `'.$wpdb->prefix.'wpgrabber_errors`
        SET
          date_add = '.time().',
          file = \''.esc_sql($file).'\',
          message = \''.esc_sql($message).'\'';
      if ($wpdb->query($sql) !== false) {
        if (wpgIsDebug()) {
          echo '<span style="color: red;">'.$message.' ['.$file.']</span>';
        }
        return true;
      }
    }
    return false;
  }

  public static function getTxtLog($rows = null) {
    global $wpdb;

    $log = array();

    $info = 'HOST: '.$_SERVER['HTTP_HOST']."\r\n";
    $info .= 'PHP: '.phpversion()."\r\n";
    $info .= 'MySQL: '.mysql_get_client_info();
    $log[] = $info;

    if ($rows === null) {
      $sql = 'SELECT * FROM `'.$wpdb->prefix.'wpgrabber_errors`
        ORDER BY date_add';
      $rows = $wpdb->get_results($sql, ARRAY_A);
      if ($wpdb->last_error != '') {
        self::add($wpdb->last_error, __FILE__, __LINE__);
      }
    }
    if (!empty($rows)) {
      foreach ($rows as $r) {
        $l = date('d.m.Y H:i', $r['date_add'])."\r\n";
        $l .= $r['message']."\r\n";
        $l .= $r['file'];
        if ($r['date_send']) {
          $l .= "\r\n".'SEND:'.date('d.m.Y H:i', $r['date_send']);
        }
        $log[] = $l;
      }
    }
    $log = implode("\r\n".str_repeat('-', 20)."\r\n", $log);
    return $log;
  }

  public static function initPhpErrors() {
    global $wpdb;
    static $is_init;
    if (get_option('wpg_logErrors') and !isset($is_init)) {
      set_error_handler(array('WPGErrorHandler', 'phpErrorHandler'));
      register_shutdown_function(array('WPGErrorHandler', 'phpFatalErrorHandler'));
      $is_init = true;

      // Очистка и отправка
      $all_errors = 0;
      $first_error_date = 0;
      $to_send_errors = 0;
      $sql = 'SELECT
        MIN(date_add) AS `mda`, COUNT(id_error) AS `ce`, IF(date_send > 0, 1, 0) AS `types`
        FROM `'.$wpdb->prefix.'wpgrabber_errors`
        GROUP BY `types`';
      $result = $wpdb->get_results($sql, ARRAY_A);
      if (!empty($result)) {
        foreach ($result as $r) {
          $all_errors += $r['ce'];
          if ($r['types'] == 0) {
            $first_error_date = $r['mda'];
            $to_send_errors = $r['ce'];
          }
        }
        if ($all_errors > 0) {
          if ($to_send_errors > 0) {
            if ($to_send_errors >= self::$MAX_ERRORS_COUNT_TO_SEND or $first_error_date <= (time() - self::$MAX_PERIOD_TO_SEND)) {
              if (get_option('wpg_sendErrors')) {
                self::sendErrorLog();
              }
            }
          }
          if ($all_errors >= self::$MAX_ERRORS_COUNT_TO_CLEAR) {
            $sql = 'DELETE FROM `'.$wpdb->prefix.'wpgrabber_errors`
              ORDER BY date_add
              LIMIT '.($all_errors - round(self::$MAX_ERRORS_COUNT_TO_CLEAR * 0.8));
            $wpdb->query($sql);
            if ($wpdb->last_error != '') {
              self::add($wpdb->last_error, __FILE__, __LINE__);
            }
          }
        }
      } else {
        if ($wpdb->last_error != '') {
          self::add($wpdb->last_error, __FILE__, __LINE__);
        }
      }
    }
  }

  public static function sendErrorLog() {
    global $wpdb;
    $sql = 'SELECT * FROM `'.$wpdb->prefix.'wpgrabber_errors`
      WHERE date_send = 0
      ORDER BY date_add';
    $rows = $wpdb->get_results($sql, ARRAY_A);
    if ($wpdb->last_error != '') {
      self::add($wpdb->last_error, __FILE__, __LINE__);
    }
    if (!empty($rows)) {
      $update_limit = count($rows);
      $log = self::getTxtLog($rows);
      if(wp_mail('demo@top-bit.ru', 'WPGrabber error log from site '.$_SERVER['HTTP_HOST'], $log)) {
        $sql = 'UPDATE `'.$wpdb->prefix.'wpgrabber_errors`
          SET date_send = '.time().'
          WHERE date_send = 0
          ORDER BY date_add
          LIMIT '.(int)$update_limit;
        $wpdb->query($sql);
        if ($wpdb->last_error != '') {
          self::add($wpdb->last_error, __FILE__, __LINE__);
        }
      }
    }
  }

  public static function phpErrorHandler($errno, $errstr, $errfile, $errline) {
    if (in_array($errno, array(E_ERROR, E_WARNING, E_PARSE))) {
      $errstr = self::_friendlyErrorType($errno).':'.$errstr;
      return self::add($errstr, $errfile, $errline);
    }
    return false;
  }

  public static function phpFatalErrorHandler() {
    $e = error_get_last();
    if (!empty($e) and in_array($e['type'], array(E_ERROR, E_WARNING, E_PARSE))) {
      $e['message'] = self::_friendlyErrorType($e['type']).':'.$e['message'];
      return self::add($e['message'], $e['file'], $e['line']);
    }
    return false;
  }

  private static function _friendlyErrorType($type) {
    switch($type) {
      case E_ERROR: // 1 //
        return 'E_ERROR';
      case E_WARNING: // 2 //
        return 'E_WARNING';
      case E_PARSE: // 4 //
        return 'E_PARSE';
      case E_NOTICE: // 8 //
        return 'E_NOTICE';
      case E_CORE_ERROR: // 16 //
        return 'E_CORE_ERROR';
      case E_CORE_WARNING: // 32 //
        return 'E_CORE_WARNING';
      case E_CORE_ERROR: // 64 //
        return 'E_COMPILE_ERROR';
      case E_CORE_WARNING: // 128 //
        return 'E_COMPILE_WARNING';
      case E_USER_ERROR: // 256 //
        return 'E_USER_ERROR';
      case E_USER_WARNING: // 512 //
        return 'E_USER_WARNING';
      case E_USER_NOTICE: // 1024 //
        return 'E_USER_NOTICE';
      case E_STRICT: // 2048 //
        return 'E_STRICT';
      case E_RECOVERABLE_ERROR: // 4096 //
        return 'E_RECOVERABLE_ERROR';
      case E_DEPRECATED: // 8192 //
        return 'E_DEPRECATED';
      case E_USER_DEPRECATED: // 16384 //
        return 'E_USER_DEPRECATED';
      }
      return 'E_UNKNOWN';
    }
  }
