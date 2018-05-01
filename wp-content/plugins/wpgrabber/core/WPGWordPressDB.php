<?php

  class WPGWordPressDB {

    public static function isField($table, $field, $ch = true) {
      global $wpdb;
      static $cache;
      if ($table !== '' and $field !== '') {
        if (!isset($chache[$table]) or !$ch) {
          $chache[$table] = array();
          $sql = 'SHOW COLUMNS FROM `'.esc_sql($table).'`';
          $fields = $wpdb->get_results($sql, ARRAY_A);
          if ($wpdb->last_error != '') {
            WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
          }
          if (!empty($fields)) {
            foreach ($fields as $f) {
              if (isset($f['Field'])) {
                $chache[$table][] = $f['Field'];
              }
            }
          }
        }
        return in_array($field, $chache[$table]);
      }
      return false;
    }
  }