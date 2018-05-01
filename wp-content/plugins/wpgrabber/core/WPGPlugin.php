<?php
  class WPGPlugin {

    protected static function _init() {
      // Добавить во все публичные методы,
      // инициализировать лог ошибок тут
    }

    protected static function _destroy() {

    }

    public static function load() {
      register_activation_hook(WPGRABBER_PLUGIN_FILE, array(wpgPlugin(), 'install'));
      register_deactivation_hook(WPGRABBER_PLUGIN_FILE, array(wpgPlugin(), 'uninstall'));

      add_action('wpgrabber_cron',  array(wpgPlugin(), 'wpCron'));
      add_filter('cron_schedules', array(wpgPlugin(), 'wpCronInterval'));
      
      add_filter( 'plugin_action_links', array(wpgPlugin(), 'addSettingsLink'), 10, 4 );

      add_action('admin_enqueue_scripts',  array(wpgPlugin(), 'js'));
      add_action('admin_menu', array(wpgPlugin(), 'menu'));

      add_action('before_delete_post',  array(wpgPlugin(), 'deletePost'));

      add_filter('set-screen-option',  array(wpgPlugin(), 'setListOptions'), 10, 3);

      if (wpgIsDemo()) {
        add_filter('login_redirect', array(wpgPlugin(), 'adminDefaultPage'));
      }

      add_action('wp_ajax_wpgrabberAjaxExec', array(wpgPlugin(), 'ajaxExec'));

      if (WPGTools::isSubmit('wpgrabberGetErrorLogFile')) {
        add_action('wp_loaded',  array(wpgPlugin(), 'getErrorLogFile'));
      }
      if (WPGTools::isSubmit('wpgrabberDeactivateAndClear')) {
        add_action('admin_init', array(wpgPlugin(), 'deactivateAndClear'));
      }
      if (WPGTools::getValue('action') == 'export') {
        add_action('plugins_loaded', array(wpgPlugin(), 'export'));
      }
      if (WPGTools::getValue('wpgrun')) {
        add_action('wp_loaded',  array(wpgPlugin(), 'serverCron'));
      }
    }
    
    function addSettingsLink( $links,  $plugin_file, $plugin_data, $context )
    {
        if (strpos($plugin_file, 'wpgrabber/')===false) return $links;
        if (is_plugin_inactive( 'wpgrabber/wpgrabber-lite.php')) return $links;
        $mylinks = array(
            "<a title=\"Сбросить настройки плагина, удалить все ленты и таблицы плагина\" onclick=\"return confirm('Вы дейстительно хотите удалить все настроенные ленты, таблицы плагина, а также сбросить все параметры и деактировать плагин WPGrabber?');\" href=\"" . admin_url( '/admin.php?page=wpgrabber-settings&wpgrabberDeactivateAndClear' ) . '">Сбросить?</a>',
        );
        return array_merge( $links, $mylinks );
    }

    public static function install() {
      require_once(WPGRABBER_PLUGIN_INSTALL_DIR.DIRECTORY_SEPARATOR.'install.php');
      self::_wpCronOn();
    }

    public static function uninstall() {
      self::_wpCronOff();
    }

    protected static function _wpCronOn() {
      if (!wp_next_scheduled('wpgrabber_cron')) {
        wp_schedule_event(time(), 'wpgmin', 'wpgrabber_cron');
      }
    }

    protected static function _wpCronOff() {
      wp_clear_scheduled_hook('wpgrabber_cron');
    }

    public static function wpCronInterval($schedules) {
      $interval = get_option('wpg_cronInterval') ? get_option('wpg_cronInterval') : 60;
      $schedules['wpgmin'] = array(
        'interval' => $interval,
        'display' => 'Через каждые '.$interval.' минут',
      );
      return $schedules;
    }



    public static function serverCron() {
      //if (get_option('wpg_cronOn') && get_option('wpg_methodUpdate')) {
      if (get_option('wpg_cronOn')) {
        self::_cron();
        exit();
      }
      return false;
    }

    public static function wpCron() {
      if (get_option('wpg_cronOn') && !get_option('wpg_methodUpdate')) {
        self::_cron();
        exit();
      }
      return false;
    }

    protected static function _cron() {
      global $wpdb;
            
      WPGErrorHandler::initPhpErrors();

      $limit = (int)get_option('wpg_countUpdateFeeds') ? (int)get_option('wpg_countUpdateFeeds') : 1;

      $feeds = array();
      
      if ($_GET['feeds']) { // обновление по запросу из адресной строки ?wpgrun=1&feeds=N
          if (is_numeric($_GET['feeds'])) {
              $_idSelect = "id = " . (int) $_GET['feeds'];
          } elseif (stripos($_GET['feeds'], '-')!==false) {
              list ($_min, $_max) = explode('-', $_GET['feeds']);
              $_idSelect = "id BETWEEN $_min AND $_max";
          } elseif (stripos($_GET['feeds'], ',')!==false) {
              $_GET['feeds'] = @explode(',', $_GET['feeds']);
              if (is_array($_GET['feeds']) and count($_GET['feeds'])) {
                $in = implode(',', $_GET['feeds']);
                $_idSelect = "id IN ($in)";
              } else {
                  $in = 'id = 0';
              }
          }            
        $sql = 'SELECT id
          FROM `'.$wpdb->prefix.'wpgrabber`
          WHERE ' . $_idSelect;
        $feeds = $wpdb->get_col($sql);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        } 
      } elseif (get_option('wpg_methodUpdateSort')) {
        $sql = 'SELECT id
          FROM `'.$wpdb->prefix.'wpgrabber`
          WHERE UNIX_TIMESTAMP() > (`last_update` + `interval`)
          AND `published` = 1
          LIMIT '.(int)$limit;
        $feeds = $wpdb->get_col($sql);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        }
      } else { // on order
        $interval = (int)get_option('wpg_cronInterval') ? (int)get_option('wpg_cronInterval') : 60;
        $sql = 'SELECT COUNT(*)
          FROM `'.$wpdb->prefix.'wpgrabber`
          WHERE `published` = 1';
        $count = (int)$wpdb->get_var($sql);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        } elseif ($count > 0) {
          //$allTime = ($count / $limit) * $interval * 60;
          $timeUpdate = (int) $interval * 60;
          $sql = 'SELECT id
            FROM `'.$wpdb->prefix.'wpgrabber`
            WHERE `published` = 1
            AND UNIX_TIMESTAMP() > (`last_update` + '.$timeUpdate.')
            ORDER BY `last_update` ASC
            LIMIT '.(int)$limit;
          $feeds = $wpdb->get_col($sql);
          if ($wpdb->last_error != '') {
            WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
          }
        }
      }
      if (count($feeds) > 0) {
        foreach ($feeds as $id) {
          $grabber = self::_getTGrabber();
          $grabber->autoUpdateMode = 1;
          $grabber->execute($id);
          /*if (wpgIsDebug()) {*/
            echo '<br /><br /><div id="echo-box" style="border: 1px solid #cacaca; padding: 10px; background:#e5e5e5; margin-right: 20px;">';
            echo $grabber->getLog();
            echo '</div>';
          /*}*/
          $grabber = null;
        }
      }
    }


    public static function js(){
      wp_enqueue_script('jQuery_ScrollTo_js', WPGRABBER_PLUGIN_URL.'/js/jquery.scrollTo-1.4.12.min.js', array('jquery'));
    }

    public static function menu() {
      if (function_exists('add_menu_page')) {
        $hook = add_menu_page('WPGrabber', 'WPGrabber', self::_getUserLevel(), 'wpgrabber-index', array(wpgPlugin(), 'index'));
        add_action('load-'.$hook, array(wpgPlugin(), 'addListOptions'));
      }
      if (function_exists('add_submenu_page')) {
        add_submenu_page('wpgrabber-index', 'Список лент', 'Список лент', self::_getUserLevel(), 'wpgrabber-index', array(wpgPlugin(), 'index'));
        add_submenu_page('wpgrabber-index', 'Новая лента', 'Новая лента', self::_getUserLevel(), 'wpgrabber-edit', array(wpgPlugin(), 'edit'));
        add_submenu_page('wpgrabber-index', 'Импорт лент', 'Импорт лент', self::_getUserLevel(), 'wpgrabber-import', array(wpgPlugin(), 'import'));
        add_submenu_page('wpgrabber-index', 'Настройки', 'Настройки', self::_getUserLevel(), 'wpgrabber-settings', array(wpgPlugin(), 'settings'));
      }
    }

    public static function addListOptions() {
      $option = 'per_page';
      $args = array(
        'label' => 'Кол-во лент на странице',
        'default' => 10,
        'option' => 'wpgrabber_feeds_per_page'
      );
      add_screen_option($option, $args);
      require_once (WPGRABBER_PLUGIN_CORE_DIR.DIRECTORY_SEPARATOR.'WPGTable.php');
      $wpgrabberTable = new WPGTable();
    }

    public static function index() {
      $_POST['rows'] = isset($_POST['rows']) ? $_POST['rows'] : null;
      $_REQUEST['action'] = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
      $_GET['paged'] = isset($_GET['paged']) ? $_GET['paged'] : null;

      if ($_POST['rows']) {
        if ($_REQUEST['action'] == '-1') $_REQUEST['action'] = $_REQUEST['action2'];
      }
      if ($_REQUEST['action'] == 'export') {
        add_action('plugins_loaded', array(wpgPlugin(), 'export'));
      }
      if (isset($_POST['cat'])) {
        $_SESSION['wpgrabberCategoryFilter'] = $_POST['cat'];
      }
      if (!$_GET['paged']) {
        if ($_REQUEST['action'] == 'test') {
          wpgrabberTest($_GET['id']);
        } elseif ($_REQUEST['action'] == 'exec') {
          wpgrabberExec($_GET['id']);
        } elseif (!empty($_REQUEST['action']) && $_REQUEST['action'] != '-1') {
          if (method_exists(wpgPlugin(), $_REQUEST['action'])) {
            call_user_func(array(wpgPlugin(), $_REQUEST['action']));
          }
        }
      }
      self::_header();
      require_once (WPGRABBER_PLUGIN_CORE_DIR.'WPGTable.php');
      $wpgrabberTable = new WPGTable();
      $wpgrabberTable->prepare_items();
      include_once (WPGRABBER_PLUGIN_TPL_DIR.'list.php');
      self::_footer();
    }

    protected static function _header() {
      include_once (WPGRABBER_PLUGIN_TPL_DIR.'header.php');
    }

    protected static function _footer() {
      echo '<div style="text-align: left; padding-top: 20px; margin-top: 30px; font-size: 16px;">&copy 2013-'.date('Y').' WPGrabber '.
        WPGRABBER_VERSION.' - <a target="_blank" href="http://top-bit.ru/">Top-Bit</a>.</div>';
    }

    public static function edit() {
      global $wpdb;
      $id = (int)WPGTools::getValue('id');
      if ($id) {
        $sql = 'SELECT * FROM `'.$wpdb->prefix.'wpgrabber`
          WHERE id = '.(int)$_GET['id'];
        $data = $wpdb->get_row($sql, ARRAY_A);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        }
        if (empty($data)) {
          WPGTools::redirect();
        }
        $row['params'] = unserialize(base64_decode($row['params']));
        if (trim(@$row['params']['imageHtmlCode']) == '') {
          $row['params']['imageHtmlCode'] = '<img src="%PATH%" />';
        }
        if (!@$row['params']['metaDescSize']) {
          $row['params']['metaDescSize'] = '400';
        }
        if(!@$row['params']['metaKeysSize']) {
          $row['params']['metaKeysSize'] = '50';
        }
      }
      $_GET['act'] = isset($_GET['act']) ? $_GET['act'] : null;
      switch ($_GET['act']) {
        case 'apply':
          $_GET['id'] = self::save();
          break;
        case 'exec':
          self::exec($_GET['id']);
          break;
        case 'test':
          self::test($_GET['id']);
          break;
      }
      if ($_GET['id']) {
        global $wpdb;
        $sql = 'SELECT * FROM `'.$wpdb->prefix.'wpgrabber`
          WHERE id = '.(int)$_GET['id'];
        $row = $wpdb->get_row($sql, ARRAY_A);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        }
        $row['params'] = unserialize(base64_decode($row['params']));
        if (trim(@$row['params']['imageHtmlCode']) == '') {
          $row['params']['imageHtmlCode'] = '<img src="%PATH%" />';
        }
        if (!@$row['params']['metaDescSize']) {
          $row['params']['metaDescSize'] = '400';
        }
        if(!@$row['params']['metaKeysSize']) {
          $row['params']['metaKeysSize'] = '50';
        }
      } else {
        $row['published'] = 1;
        $row['interval'] = 180;
        $row['params']['rss_textmod'] = '1';
        $row['params']['max_items'] = 0;
        $row['params']['intro_size'] = 500;
        $row['params']['frontpage'] = 1;
        $row['params']['dontPublished'] = 0;
        $row['params']['intro_pic_on'] = 1;
        $row['params']['image_path'] = get_option('wpg_imgPath') ? get_option('wpg_imgPath') : '/wp-content/uploads/';
        $row['params']['image_space_on'] = 0;
        $row['params']['intro_pic_width'] = 150;
        $row['params']['intro_pic_height'] = 150;
        $row['params']['intro_pic_quality'] = 100;
        $row['params']['text_pic_width'] = 600;
        $row['params']['text_pic_height'] = 600;
        $row['params']['text_pic_quality'] = 100;
        $row['params']['strip_tags'] = 1;
        $row['params']['allowed_tags'] = '<img><b><a><i><u><object><embed><param><p><strong><br><ul><li><iframe>';
        $row['params']['template_on'] = 1;
        $row['params']['template_title'] = '%TITLE%';
        $row['params']['template_intro_text'] = '%INTRO_TEXT%';
        $row['params']['template_full_text'] = '%FULL_TEXT%';
        $row['params']['imageHtmlCode'] = '<img src="%PATH%" %ATTR% />';
        $row['params']['metaDescSize'] = '400';
        $row['params']['metaKeysSize'] = '50';
        $row['params']['title_words_count'] = '5';
        $row['type'] = 'html';
        $isNew = true;
      }
      $tab = (isset($_REQUEST['tab']) and in_array($_REQUEST['tab'], array(1,2,3,4,6,7,8))) ? $_REQUEST['tab'] : 1;
      self::_header();
      include_once (WPGRABBER_PLUGIN_TPL_DIR.'edit.php');
      self::_footer();
    }
    
    private function translateYandexUpdate()
    {
        if (!get_option('wpg_'.'yandexApiKey')) {
            self::_adminNotice('API-ключ Яндекс не задан!');
        } elseif(function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr/getLangs?key=' . get_option('wpg_'.'yandexApiKey')  . '&ui=ru');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
            $xml = curl_exec($ch);
            curl_close($ch);
            
            if (trim($xml)=='') return false;
            
            $xml = simplexml_load_string($xml);
            
            if (count($xml->dirs->string)) {
                foreach ($xml->dirs->string as $string) {
                    $string = (string) $string;
                    $dirs[$string] = $string;
                }
            }
            
            if (count($xml->langs->Item)) {
                foreach ($xml->langs->Item as $item) {
                    $langs[(string) $item['key']] = (string) $item['value'];
                }
            }
            
            if (count($dirs)) {
                foreach ($dirs as $key => $dir) {
                    list($from, $to) = explode('-', $key);
                    $dirs[$key] = "{$langs[$from]} > {$langs[$to]}";
                }
            }
            
            if (count($dirs)) {
                if (get_option("wpg_yandexTransLangs")) {
                    update_option("wpg_yandexTransLangs", json_encode($dirs));
                } else {
                    add_option("wpg_yandexTransLangs", json_encode($dirs), ' ', 'no');
                }
            }
            
            return true;
        }
    }

    public static function settings()    {
      WPGErrorHandler::initPhpErrors();
      
        if ($_GET['translate_yandex']=='update') {
            if (self::translateYandexUpdate())
                self::_adminNotice('База переводов сервиса Яндекс.Перевод успешно обновлена!');
        }

        if (is_array($_POST['options'])) {
            foreach ($_POST['options'] as $name => $value) {
                if (get_option("wpg_$name") != $value) {
                    update_option("wpg_$name", $value);
                } else {
                    add_option("wpg_$name", $value, ' ', 'no');
                }
            }            
            if (isset($_POST['saveButton'])) {
                
                if (get_option('wpg_yandexApiKey') and !get_option('wpg_yandexTransLangs')) {
                    WPGPlugin::translateYandexUpdate();
                }
                
                self::_adminNotice('Настройки успешно сохранены');
            } else {
                return ;
            }
        }

        include_once (WPGRABBER_PLUGIN_TPL_DIR.'settings.php');
        self::_footer();
    }

    public static function adminDefaultPage() {
      return '/wp-admin/admin.php?page=wpgrabber-index';
    }

    protected static function _getUserLevel() {
      return wpgIsDemo() ? 0 : 8;
    }

    protected static function _ifDemo($ids) {
      if ($user->roles[0]=='administrator') return false;
      $demoIds = array('90', '91', '92', '93', '94');
      if (!wpgIsDemo()) return false;
      if (is_array($ids)) {
        $search = array_intersect($ids, $demoIds);
        if (!count($search)) {
          return false;
        }
      } else {
        if (!in_array($ids, array('90', '91', '92', '93', '94'))) {
          return false;
        }
      }
      self::_adminNotice('Тестовые ленты не возможно редактировать и удалять в demo-режиме! Если Вам нужно изменить ленту, скопируйте ее и меняейте настройки в копии ленты!');
      return true;
    }

    public static function setListOptions($status, $option, $value) {
      if ($option == 'wpgrabber_feeds_per_page') {
        $value = intval($value);
        return $value ? $value : 10;
      }
      return $value;
    }

    protected static function _adminNotice($text, $class = 'updated') {
      ?><div class="<?php echo $class; ?>"><p><?php echo $text; ?></p></div><?php
    }

    public static function deletePost($id) {
      global $wpdb;

      WPGErrorHandler::initPhpErrors();

      $sql = 'SELECT *
        FROM `'.$wpdb->prefix.'wpgrabber_content`
        WHERE `content_id` = '.(int)$id;
      $rows = $wpdb->get_results($sql, ARRAY_A);
      if ($wpdb->last_error != '') {
        WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
      } else {
        if (count($rows)) {
          foreach ($rows as $row) {
            $imgList = $rows['images'];
            if (trim($imgList) == '') {
              continue;
            }
            $imgList = explode(',', $imgList);
            if (count($imgList)) {
              foreach ($imgList as $img) {
                @unlink(ABSPATH.$img);
              }
            }
          }
          $sql = 'DELETE FROM `'.$wpdb->prefix.'wpgrabber_content`
            WHERE `content_id` = '.(int)$id;
          $wpdb->query($sql);
          if ($wpdb->last_error != '') {
            WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
          } else {
            $attachments = get_posts(
              array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_status' => null,
                'post_parent' => $id
              )
            );
            if (!empty($attachments)) {
              foreach ($attachments as $attachment) {
                wp_delete_attachment($attachment->ID);
              }
            }
          }
        }
      }
    }

    public static function clear() {
      global $wpdb;

      WPGErrorHandler::initPhpErrors();

      if (empty($_POST['rows'])) {
        return false;
      }
      $rows = array_map('intval', $_POST['rows']);
      $sql = 'SELECT `content_id`
        FROM `'.$wpdb->prefix.'wpgrabber_content`
        WHERE `feed_id` IN ('.implode(',', $rows).')
        AND `content_id` > 0';
      $posts = $wpdb->get_col($sql);
      if ($wpdb->last_error != '') {
        WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
      } else {
        if (count($posts)) {
          foreach ($posts as $post_id) {
            wp_delete_post($post_id, true);
          }
        }
        $sql = 'DELETE FROM `'.$wpdb->prefix.'wpgrabber_content`
          WHERE `feed_id` IN ('.implode(',', $rows).')
          AND `content_id` = 0';
        $wpdb->query($sql);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        }
        self::_adminNotice('Успешно удалено записей: '.(int)count($posts));
      }
    }

    public static function exec($id, $is_test = false) {

      WPGErrorHandler::initPhpErrors();

      $grabber = self::_getTGrabber();
      if ($is_test) {
        $grabber->setTest();
      }
      $grabber->execute($id);
      echo '<br /><br /><div id="echo-box" style="border: 1px solid #cacaca; padding: 10px; background:#e5e5e5; margin-right: 20px;">';
      echo $grabber->getLog();
      echo '</div>';
    }

    public static function test($id) {
      self::exec($id, true);
    }

    private static function _getTGrabber() {
      if (wpgIsPro()) {
        $class = 'TGrabberWordPressPro';
      } elseif (wpgIsStandard()) {
        $class = 'TGrabberWordPressStandard';
      } elseif (wpgIsLite()) {
        $class = 'TGrabberWordPressLite';
      } else {
        $class = 'TGrabberWordPress';
      }
      $obj = new $class();
      return $obj;
    }

    public static function save() {
      global $wpdb;

      WPGErrorHandler::initPhpErrors();

      $row = $_POST['row'];

      $params = $_POST['params'];

      // формирование массивов шаблонов
      if (count($params['usrepl'])) {
        foreach ($params['usrepl'] as $value) {
          if (!$value['type']) {
            continue;
          }
          $params['replace'][$value['type']][] = $value;
        }
      }

      $params = WPGHelper::strips($params);

      //file_put_contents(ABSPATH.'PARAMS.TXT', var_export($params, true));

      $row = WPGHelper::strips($row);

      $row['params'] = base64_encode(serialize($params));

      $row['id'] = intval($row['id']);
      if ($row['id']) {
        if (self::_ifDemo($row['id'])) {
          return null;
        }
        $result = $wpdb->update(
          $wpdb->prefix.'wpgrabber',
          array(
            'name' => $row['name'],
            'type' => $row['type'],
            'url' => $row['url'],
            'links' => $row['links'],
            'title' => $row['title'],
            'text_start' => $row['text_start'],
            'text_end' => $row['text_end'],
            'rss_encoding' => $row['rss_encoding'],
            'html_encoding' => $row['html_encoding'],
            'published' => $row['published'],
            'params' => $row['params'],
            'interval' => $row['interval']
          ),
          array(
            'id' => $row['id']
          )
        );
        if ($result > 0) {
          self::_adminNotice('Лента успешно обновлена');
        } else {
          if ($wpdb->last_error != '') {
            WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
          }
          self::_adminNotice('Ошибка сохранения изменений в ленте!', 'error');
        }
        return $row['id'];
      } else {
	$row['interval']="";
        $result = $wpdb->insert(
          $wpdb->prefix.'wpgrabber',
          array(
            'name' => $row['name'],
            'type' => $row['type'],
            'url' => $row['url'],
            'links' => $row['links'],
            'title' => $row['title'],
            'text_start' => $row['text_start'],
            'text_end' => $row['text_end'],
            'rss_encoding' => $row['rss_encoding'],
            'html_encoding' => $row['html_encoding'],
            'published' => $row['published'],
            'params' => $row['params'],
            'interval' => $row['interval']
          )
        );
        if ($result > 0) {
          self::_adminNotice('Лента успешно добавлена');
          return $wpdb->insert_id;
        } else {
          if ($wpdb->last_error != '') {
            WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
          }
          self::_adminNotice('Ошибка сохранения ленты!', 'error');
        }
      }
    }

    public static function del() {
      global $wpdb;

      WPGErrorHandler::initPhpErrors();

      if (empty($_POST['rows'])) {
        return false;
      }
      if (self::_ifDemo($_POST['rows'])) {
        return null;
      }
      $rows = array_map('intval', $_POST['rows']);
      $sql = 'DELETE FROM `'.$wpdb->prefix.'wpgrabber`
        WHERE id IN ('.implode(',', $rows).')';
      $result = $wpdb->query($sql);
      if ($result > 0) {
        self::_adminNotice('Выбранные ленты успешно удалены!');
      } else {
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        }
        self::_adminNotice('Ошибка удаления лент!', 'error');
      }
    }



    public static function copy() {
      global $wpdb;

      WPGErrorHandler::initPhpErrors();

      if (empty($_REQUEST['rows'])) {
        self::_adminNotice('Не выбранны ленты для копирования', 'error');
        return false;
      }
      $rows = array_map('intval', $_REQUEST['rows']);
      $sql = 'SELECT `name`, `type`, `url`, `links`, `title`, `text_start`,
          `text_end`, `rss_encoding`, `html_encoding`, `published`,
          `params`, `interval`
        FROM `'.$wpdb->prefix.'wpgrabber`
        WHERE id IN ('.implode(',', $rows).')';
      $rows = $wpdb->get_results($sql, 'ARRAY_A');
      if ($wpdb->last_error != '') {
        WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
      }
      if (!count($rows) and !is_array($rows)) {
        self::_adminNotice('Ошибка выборки списка лент из базы', 'error');
      }
      $suc = $err = 0;
      foreach ($rows as $row) {
        $fields = array();
        $values = array();
        $row['name'] = 'Копия '.$row['name'];
        $result = $wpdb->insert($wpdb->prefix.'wpgrabber', $row);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        }
        if ($result > 0) {
          $suc++;
        } else {
          $err++;
        }
      }
      self::_adminNotice('Скопировано лент: '.(int)$suc.', ошибок: '.(int)$err);
    }

    public function export() {
      global $wpdb;

      if (isset($_REQUEST['action']) and $_REQUEST['action'] != 'export') {
        return false;
      }
      if (isset($_POST['rows']) and $_POST['rows']) {
        if (isset($_REQUEST['action']) and $_REQUEST['action'] == '-1') {
          $_REQUEST['action'] = $_REQUEST['action2'];
        }
      }
      if (empty($_POST['rows'])) {
        return false;
      }

      WPGErrorHandler::initPhpErrors();

      $rows = array_map('intval', $_POST['rows']);
      $sql = 'SELECT `name`, `type`, `url`, `links`, `title`,
          `text_start`, `text_end`, `rss_encoding`, `html_encoding`,
          `published`, `params`, `interval`
        FROM `'.$wpdb->prefix.'wpgrabber`
        WHERE id IN ('.implode(',', $rows).')';
      $rows = $wpdb->get_results($sql, ARRAY_A);
      if ($wpdb->last_error != '') {
        WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
      }
      if (is_array($rows) and count($rows)) {
        $feeds = array();
        foreach ($rows as $row) {
          if (count($row)) {
            $feedXML = '';
            //$row['dhsuf'] = 'fdf';
            foreach ($row as $name => $value) {
              $feedXML .= "\t\t<$name><![CDATA[$value]]></$name>\n";
            }
            $feeds[] = $feedXML;
          }
        }
        if (!count($feeds)) {
          self::_adminNotice('Ошибка сбора лент', 'error');
          return;
        }
        foreach ($feeds as $feed) {
          $xml .= "\t<feed>\n$feed\t</feed>\n";
        }
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n<feeds wpgcore=\"".WPGRABBER_CORE_VERSION."\">\n$xml</feeds>";
        header('Content-type: text/xml');
        header("Content-Disposition: attachment; filename=export.xml");
        echo $xml;
        self::_destroy();
        exit();
      } else {
        self::_adminNotice('Ошибка выборки списка лент из базы', 'error');
        return false;
      }
    }

    public static function import() {
      global $wpdb;

      WPGErrorHandler::initPhpErrors();

      if ($_FILES['file']) {
        $xmlContent = file_get_contents($_FILES['file']['tmp_name']);
        if (trim($xmlContent) == '') {
          self::_adminNotice('Пустой XML-файл', 'error');
          return;
        }
        $xml = simplexml_load_string($xmlContent);
        $wpg_core_version = isset($xml['wpgcore']) ? (string)$xml['wpgcore'] : '3.0.1';
        if (!count($xml->feed)) {
          self::_adminNotice('Данных для импорта лент в XML-файле не обнаружено', 'error');
          return;
        }
        foreach ($xml->feed as $feed) {
          $buff = array();
          foreach ($feed->children() as $child) {
            $name = $child->getName();
            if ($name !== '' and WPGWordPressDB::isField($wpdb->prefix.'wpgrabber', $name)) {
              $buff[$name] = (string)$feed->$name;
            }
          }
          if (!empty($buff)) {
            $feeds[] = $buff;
          }
        }
        if (!count($feeds)) {
          self::_adminNotice('Данных для импорта лент в XML-файле не обнаружено', 'error');
          return;
        }
        foreach ($feeds as $feed) {
          $result = $wpdb->insert($wpdb->prefix.'wpgrabber', $feed);
          if ($wpdb->last_error != '') {
            WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
          }
          if ($result > 0) {
            $sucess++;
          } else {
            $errors++;
          }
        }
        self::_adminNotice('Успешно импортировано: '.(int)$sucess.' лент, выявлено ошибок: '.(int)$errors);
      }
      include_once (WPGRABBER_PLUGIN_TPL_DIR.'import.php');
      self::_footer();
    }

    public static function on() {
      global $wpdb;

      WPGErrorHandler::initPhpErrors();

      if (isset($_REQUEST['rows'])) {
        $rows = array_map('intval', $_REQUEST['rows']);
        $sql = 'UPDATE `'.$wpdb->prefix.'wpgrabber`
          SET published = 1
          WHERE id IN ('.implode(',', $rows).')';
        $result = $wpdb->query($sql);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        }
        if ($result > 0) {
          self::_adminNotice('Выбранные ленты успешно включены');
          return true;
        }
      }
      self::_adminNotice('Ошибка включения выбранных лент!', 'error');
      return false;
    }

    public static function off() {
      global $wpdb;

      WPGErrorHandler::initPhpErrors();

      if (isset($_REQUEST['rows'])) {
        $rows = array_map('intval', $_REQUEST['rows']);
        $sql = 'UPDATE `'.$wpdb->prefix.'wpgrabber`
          SET published = 0
          WHERE id IN ('.implode(',', $rows).')';
        $result = $wpdb->query($sql);
        if ($wpdb->last_error != '') {
          WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
        }
        if ($result > 0) {
          self::_adminNotice('Выбранные ленты успешно выключены');
          return true;
        }
      }
      self::_adminNotice('Ошибка выключения выбранных лент!', 'error');
      return false;
    }

    public static function ajaxExec() {
      ob_start();

      WPGErrorHandler::initPhpErrors();

      $result = array('pid' => '', 'status' => 0, 'error' => '', 'log' => '');
      $id = !empty($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
      $pid = !empty($_REQUEST['pid']) ? $_REQUEST['pid'] : null;
      $test = !empty($_REQUEST['test']);
      if (get_option('wpg_useTransactionModel')) {
        if (!session_id()) {
          session_start();
        }
        if ($pid === null) {
          $pid = md5(microtime(true).rand(0,100));
          while (isset($_SESSION[$pid])) {
            $pid = md5(microtime(true).rand(0,100));
          }
          $_SESSION[$pid]['date_add'] = time();
          $grabber = self::_getTGrabber();
          if ($test) {
            $grabber->setTest();
          }
          $grabber->setTransactionModel();
          $res = $grabber->execute($id);
          $result['log'] = $grabber->getLog();
        } else {
          $res = false;
          if (isset($_SESSION[$pid]['grabber'])) {
            $grabber = @unserialize($_SESSION[$pid]['grabber']);
            if(is_object($grabber)) {
              $res = $grabber->execute($id);
              $result['log'] = $grabber->getLog();
            }
          }
        }
        if (is_object($res)) {
          $result['pid'] = $pid;
          $_SESSION[$pid]['grabber'] = serialize($res);
        } else {
          if ($res === true) {
            $result['status'] = 1;
          } else {
            $result['status'] = 2;
            $result['error'] = 'Сбой сервера';
          }
          unset($_SESSION[$pid]);
        }
      } else {
        $grabber = self::_getTGrabber();
        if ($test) {
          $grabber->setTest();
        }
        $grabber->execute($id);
        $result['log'] = $grabber->getLog();
        $result['status'] = 1;
      }
      $debug = ob_get_clean();
      if ($debug) {
        $result['log'] .= '<p style="color: red;">'.$debug.'</p>';
      }
      echo json_encode($result);
      exit();
    }

    public static function getErrorLogFile() {

      WPGErrorHandler::initPhpErrors();

      $filename = 'wpg_error_log.txt';
      $file = WPGErrorHandler::getTxtLog();
      header('Content-type: text/plain');
      header('Content-Length: '.strlen($file));
      header('Cache-Control: no-cache, must-revalidate');
      header('Pragma: no-cache');
      header('Content-Disposition: attachment; filename="'.$filename.'"');
      echo $file;
      exit();
    }

    public static function deactivateAndClear() {
      global $wpdb;
      deactivate_plugins(plugin_basename(WPGRABBER_PLUGIN_FILE));
      $sqls[] = 'DROP TABLE '.$wpdb->prefix.'wpgrabber';
      $sqls[] = 'DROP TABLE '.$wpdb->prefix.'wpgrabber_content';
      $sqls[] = 'DROP TABLE '.$wpdb->prefix.'wpgrabber_errors';
      $sqls[] = 'DELETE FROM '.$wpdb->prefix.'options WHERE option_name LIKE \'wpg_%\'';
      foreach ($sqls as $sql) {
        $wpdb->query($sql);
      }
      wp_redirect(admin_url('plugins.php'));
    }

  }
?>