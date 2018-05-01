<?php
/**
* TGrabberWordPress
*
* @version 1.1.6
* @author Top-Bit <info@top-bit.ru>
* @copyright 2009-2016 Top-Bit
* @link http://top-bit.ru
*/
  
class TGrabberWordPress extends TGrabberCore
{
    
    var $attachImages = array();
    
    var $uploadMediaOn = true;

    protected $_log = array();
  
    function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->config = new TGrabberWPOptions();
        $this->rootPath = rtrim(ABSPATH, '/');
        $this->config->set('imgPath', $this->config->get('imgPath') ? $this->config->get('imgPath') : '/wp-content/uploads/');
        $this->onLog = true;
        parent::__construct();
    }

    public function __sleep() {
      $this->db = null;
      $this->_log = array();
      return parent::__sleep();
    }

    public function __wakeup() {
      global $wpdb;
      $this->db = $wpdb;
    }
    
    function setTest()
    {
        parent::setTest();
        $this->config->set('imgPath', $this->config->get('testPath') ? $this->config->get('testPath') : '/wp-content/wpgrabber_tmp/');
        $test_path = $this->rootPath . $this->config->get('imgPath');
        if (!file_exists($test_path)) mkdir($test_path, 0777);
        if (!is_writeable($test_path)) chmod($test_path, 0777);
        $files = glob("$test_path*.*");
        if (count($files) > 100) {
            foreach ($files as $file) {
                @unlink($file);
            }
        }
    }
    
    function _echo($mess)
    {
        if (!$this->onLog) return;
        $this->_log[] = $mess;
        /*if (WPGRABBER_DEBUG) {
          $sql = 'INSERT INTO `'.$this->db->prefix.'wpgrabber_log`
            SET
              id_feed = '.(isset($this->feed['id']) ? (int)$this->feed['id'] : 0).',
              date_add = \''.date('Y-m-d H:i:s').'\',
              log = \''.esc_sql($mess).'\'';
          $this->db->query($sql);
          if ($this->db->last_error != '') {
            WPGErrorHandler::add($this->db->last_error, __FILE__, __LINE__);
          }
        }*/
    }

    public function getLog() {
      $log = implode('', $this->_log);
      $this->_log = array();
      return $log;
    }
    
    function getLinks($links, $exists=null) {
      $sql_where[] = '`feed_id` = '.(int)$this->feed['id'];
      if (!$this->feed['params']['skip_error_urls']) {
        $sql_where[] = '`content_id` > 0';
      }
      $sql = 'SELECT `url`
        FROM `'.$this->db->prefix.'wpgrabber_content`
        WHERE '.implode(' AND ', $sql_where);
      $exists = $this->db->get_col($sql);
      if ($this->db->last_error != '') {
        WPGErrorHandler::add($this->db->last_error, __FILE__, __LINE__);
      }
      return parent::getLinks($links, $exists);
    }

    function saveContentRecord($id, $url) {
      if (count($this->imagesContent)) {
        $images = @implode(',', $this->imagesContent);
      }
	  $images="";
      $result = $this->db->insert(
        $this->db->prefix.'wpgrabber_content',
        array(
          'feed_id' => $this->feed['id'],
          'content_id' => $id,
          'url' => $url,
          'images' => $images
        )
      );
      if ($result) {
        $this->imagesContent = array();
        return true;
      }
      if ($this->db->last_error != '') {
        WPGErrorHandler::add($this->db->last_error, __FILE__, __LINE__);
      }
      return false;
    }

    protected function _saveEmptyRecord($url) {
      if ($this->feed['params']['skip_error_urls'] and !$this->testOn) {
        $this->imagesContent = array();
        return $this->saveContentRecord(0, $url);
      }
      return true;
    }

    /** 
    * Поиск заголовка материала в базе
    * Рубрики работают только для постов
    * 
    * @param mixed $title
    * @return mixed
    */
    function isTitle($title) {
      static $titles;
      if (!isset($titles)) {
        $sql_where = array();
        $sql_join = array();

        $sql_where[] = 'p.post_type = \''.esc_sql($this->feed['params']['postType']).'\'';
        $sql_where[] = 'p.post_title <> \'\'';
        if($this->feed['params']['postType'] == 'post') {
          $sql_join[] = 'LEFT JOIN `'.$this->db->prefix.'term_relationships` AS tr ON tr.object_id = p.ID';
          $sql_join[] = 'LEFT JOIN `'.$this->db->prefix.'term_taxonomy` AS tt ON (
            tt.term_taxonomy_id = tr.term_taxonomy_id AND
            tt.taxonomy = \'category\')';
          $catid = $this->_getValidCatIdArray();
          if (!empty($catid)) {
            $sql_where[] = 'tt.term_id IN ('.implode(', ', $catid).')';
          }
        }
        $sql = 'SELECT DISTINCT p.post_title
          FROM `'.$this->db->prefix.'posts` AS p
          '.(!empty($sql_join) ? implode(' ', $sql_join) : '').'
          '.(!empty($sql_where) ? 'WHERE '.implode(' AND ', $sql_where) : '');
        $rows = $this->db->get_results($sql, ARRAY_A);
        if ($this->db->last_error != '') {
          WPGErrorHandler::add($this->db->last_error, __FILE__, __LINE__);
        } else {
          $titles = array();
          if (count($rows)) {
            foreach ($rows as $row) {
              $titles[$row['post_title']] = $row['post_title'];
            }
          }
        }
      }
      return isset($titles[$title]);
    }
    
    function getAlias($alias, $created)
    {
         $alias = $this->translit($alias); 
         if ($this->feed['params']['aliasSize']) $alias = mb_substr($alias, 0, $this->feed['params']['aliasSize'], 'utf-8');
         $alias = mb_strtolower($alias);
         //if ($this->feed['params']['aliasMethod']) $alias = $this->getUniqueAlias($alias);
         return $alias;
    }
    
/*    function getUniqueAlias($alias)
    {
        $this->db->setQuery("SELECT COUNT(*) FROM `#__content` WHERE `alias` = '$alias'");
        if ($this->db->loadResult()) {
            return $this->getUniqueAlias($alias . mt_rand(10, 99));
        } else {
            return $alias;
        }
    }*/
    
    function save($url)
    {
        $this->attachImages = array();
        
        $result = parent::save($url);

        if (!$result) {
          return $result;
        }
        $record =& $this->content[$url];

        $created = current_time('mysql');
        
        if ($this->feed['params']['autoIntroOn'] == 1) {
            $record['text'] = str_replace('{{{MORE}}}', '<!--more-->', $record['text']);
        } elseif ($this->feed['params']['post_more_on']) {
            $record['text'] = $this->insertMore($record['text']);
        }
        
        // обработка шаблона материала
        if ($this->feed['params']['template_on']) {
            $templates = array(
                '%TITLE%' => $record['title'],
                //'%INTRO_TEXT%' => $introtext,
                '%FULL_TEXT%' => $record['text'],
                '%INTRO_PIC%' => '',
                '%FEED%' => $this->feed['name'],
                '%FEED_URL%' => $this->feed['url'],
                '%SOURCE_URL%' => $url,
                '%SOURCE_SITE%' => parse_url($url, PHP_URL_HOST),
                '%TITLE_SOURCE%' => $this->titleNoTranslate[$url],             
                '%TEXT_SOURCE%' => $this->textNoTranslate[$url],    
                '%NOW_DATE%' => date('d.m.Y', current_time( 'timestamp', 0 )),
                '%NOW_TIME%' => date('H:i', current_time( 'timestamp', 0 )),         
            );
            $record['title'] = strtr($this->feed['params']['template_title'], $templates);
            //$introtext = strtr($this->feed['params']['template_intro_text'], $templates);
            $record['text'] = strtr($this->feed['params']['template_full_text'], $templates);
        }

        if (empty($record['title'])) {
          $this->_echo('<br /><i>Материл не сохранен по причине отсутствия заголовка</i>');
          return null;
        }
        
        // если тестовый режим   
        if ($this->testOn) {
            $record['text'] = str_replace('<!--more-->', '<div style="font-size:10px;background:#cacaca;color:#333333;width:95%;padding-left:5px;margin-top:10px;margin-bottom:10px;">далее (more) ...</div>', $record['text']);
            $this->_echo("<br /><table celpadding='5' border='1'><tr><th valign='top' align='left'>Заголовок</th><td>{$record['title']}</td></tr><tr><th valign='top' align='left'>Текст</th><td>{$record['text']}</td></tr></table>");
            return true;
        }

        // механизм соблюдения уникальных заголовков
        if ($this->feed['params']['titleUniqueOn']) {
          if ($this->isTitle($record['title'])) {
            $this->_echo('<br><br /><b>Неуникальный заголовок: "'.$record['title'].'" в заданной категории!</b>');
            return null;
          }
        }

        $postAlias = '';
        if ($this->feed['params']['postSlugOn']) {
            if (!$this->feed['params']['aliasMethod']) {
                $postAlias = $this->getAlias($record['title'], $created);
            }
        }

        $post = array(
            //'ID'             => [ <post id> ] //Are you updating an existing post?
            //'menu_order'     => [ <order> ] //If new post is a page, it sets the order in which it should appear in the tabs.
            //'comment_status' => [ 'closed' | 'open' ] // 'closed' means no comments.
            //'ping_status'    => [ 'closed' | 'open' ] // 'closed' means pingbacks or trackbacks turned off
            //'pinged'         => [ ? ] //?
            'post_author'    => $this->feed['params']['user_id'], //The user ID number of the author.
            'post_category'  => $this->_getValidCatIdArray(), //post_category no longer exists, try wp_set_post_terms() for setting a post's categories
            'post_content'   => $record['text'], //The full text of the post.
            'post_date'      => $created, //The time post was made.
            'post_date_gmt'  => get_gmt_from_date($created), //The time post was made, in GMT.
            //'post_excerpt'   => [ <an excerpt> ] //For all your post excerpt needs.
            'post_name'      => $postAlias, // The name (slug) for your post
            //'post_parent'    => [ <post ID> ] //Sets the parent of the new post.
            //'post_password'  => [ ? ] //password for post?
            'post_status'    => $this->feed['params']['post_status'], //[ 'draft' | 'publish' | 'pending'| 'future' | 'private' | 'custom_registered_status' ] //Set the status of the new post.
            'post_title'     => $record['title'], //The title of your post.
            'post_type'      => $this->feed['params']['postType'], // [ 'post' | 'page' | 'link' | 'nav_menu_item' | 'custom_post_type' ] //You may want to insert a regular post, page, link, a menu item or some custom post type
            'post_thumbnail' => $this->picToIntro,
            //'tags_input'     => [ '<tag>, <tag>, <...>' ] //For tags.
            //'to_ping'        => [ ? ] //?
            //'tax_input'      => [ array( 'taxonomy_name' => array( 'term', 'term2', 'term3' ) ) ] // support for custom taxonomies. 
        );

        $current_user = wp_get_current_user();
        $current_user_id = isset($current_user->ID) ? $current_user->ID : 0;
        wp_set_current_user($this->feed['params']['user_id']);

        $postID = wp_insert_post($post, $wp_error);
        if ($postID) {
          if($this->saveContentRecord($postID, $url)) {
            $this->_echo("<br>Запись с заголовком: <b>{$record['title']}</b> - успешно сохранена!");
            $this->saveAttachments($postID);
            wp_set_current_user($current_user_id);
            return true;
          }
          wp_delete_post($postID, true);
        }
        wp_set_current_user($current_user_id);
        $this->_echo('<br><span style="color: red;">Ошибка сохранения записи с заголовком: <b>'.$record['title'].'</b></span>', 2);
        return false;
    }

    private function _getValidCatIdArray() {
      $catid = array();
      if (isset($this->feed['params']['catid']) and is_array($this->feed['params']['catid'])) {
        $catid = array_filter($this->feed['params']['catid']);
      }
      if (empty($catid) and $this->feed['params']['postType'] == 'post' and $this->feed['params']['post_status'] != 'auto-draft') {
        $catid = array(get_option('default_category'));
      }
      return $catid;
    }
    
    function saveAttachments($post_id)
    {
        if (!$this->uploadMediaOn) return false;
        static $thumbnail = false;
        if (!count($this->attachImages)) return;
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        foreach ($this->attachImages as $filename) {
            $wp_filetype = wp_check_filetype(basename($filename), null );
              $attachment = array(
                 'post_mime_type' => $wp_filetype['type'],
                 'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                 'post_content' => '',
                 'post_status' => 'inherit',
                 'post_parent' => $post_id
              );

              $attach_id = wp_insert_attachment( $attachment, $filename, $post_id );

              $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
              wp_update_attachment_metadata( $attach_id, $attach_data );
              
              if (!$thumbnail and $this->feed['params']['post_thumb_on']) set_post_thumbnail( $post_id, $attach_id );
              $thumbnail = true;
        }
        $thumbnail = false;
        $this->attachImages = array();
        return true;
    }

    protected function _getFeed($id) {
      $sql = 'SELECT * FROM `'.$this->db->prefix.'wpgrabber`
        WHERE id = '.(int)$id.'
        LIMIT 1';
      $row = $this->db->get_row($sql, ARRAY_A);
      if ($this->db->last_error != '') {
        WPGErrorHandler::add($this->db->last_error, __FILE__, __LINE__);
      }
      return $row;
    }
    
     protected function _beforeExecute($id) {
         if (!$this->config->get('offFeedsModeOn')) { // обычный режим
             $this->db->update($this->db->prefix.'wpgrabber',
                  array(
                    'last_update' => '',
                  ),
                  array('id' => $id)
             );  
         } else { // режим отключения неработающих лент
             if ($this->autoUpdateMode) {
                 $this->db->update($this->db->prefix.'wpgrabber',
                  array(
                    'published' => '0',
                    'last_update' => '',
                  ),
                  array('id' => $id)
                );  
             }
         }
        parent::_beforeExecute($id);
     }

    protected function _afterExecute($id) {
      parent::_afterExecute($id);
      if ($this->testOn) {

      } else {
        foreach ($this->updateFeedData as $key => $value) {
          $sql[] = '`'.$key.'` = \''.esc_sql($value).'\'';
        }
        $sql = 'UPDATE `'.$this->db->prefix.'wpgrabber`
          SET
            '.implode(',', $sql).'
          WHERE id = '.(int)$id;
        $this->db->query($sql);
        if ($this->db->last_error != '') {
          WPGErrorHandler::add($this->db->last_error, __FILE__, __LINE__);
        }
        $this->updateFeedData = array();
        $this->_echo('<br /><b>Импорт ленты: <a target="_blank" href="' . $this->feed['url'] . '">' . $this->feed['name'] . '</a> успешно завершен! - ' . date('H:i:s Y-m-d') . '</b><br />');
      }
    }
    
    function insertMore($text)
    {
        $introSymbolEnd = trim($this->feed['params']['introSymbolEnd']) == '' ? ' ' : $this->feed['params']['introSymbolEnd'];
        $introtext = preg_replace('|<.*?>|', ' $0 ', $text);
        $introtext = str_replace(array("\n", "\r", "\t", "\0", "\x0B"), '', trim(strip_tags($introtext)));
        $introtext = str_replace('&nbsp;', ' ', $introtext);
        $substr = strripos(substr($introtext, 0, $this->feed['params']['intro_size']), $introSymbolEnd);
        $introtext = substr($introtext, 0, $substr);
        preg_match('|(\S{1,})\s{1,}(\S{1,})\s{1,}(\S{1,})\s{0,}$|is', $introtext, $buff);
        preg_match('|.*?'.$buff[1].'.*?'.$buff[2].'.*?'.$buff[3].'|is', $text, $buff);
        $text1 = $buff[0];
        $text = str_replace($text1, "$text1<!--more-->", $text);
        $text = preg_replace('|(<a .*?>.*?)<!--more-->(.*?</a>)|is', '$1$2<!--more-->', $text);
        $text = preg_replace('|<!--more-->(' . $introSymbolEnd . ')|is', '$1<!--more-->', $text);
        return $text;
    }
    
    /**
    * Create a directory for images
    *
    */
    function mkImageDir()
    {
        $buff = wp_upload_dir();    
        if (trim($this->config->get('imgPath')) != (str_replace(get_bloginfo('wpurl'), '', $buff['baseurl']) . '/')) {
            $this->uploadMediaOn = false;
        }
        
        if (!file_exists($this->rootPath . $this->config->get('imgPath'))) mkdir($this->rootPath . $this->config->get('imgPath'), 0777);
        
        if ($this->uploadMediaOn and get_option('uploads_use_yearmonth_folders')) {
            $this->imageDir = date('Y') . '/';
            $imageDirPath = $this->rootPath . $this->config->get('imgPath') . $this->imageDir;
            if (!file_exists($this->imageDir)) mkdir($this->imageDir, 0777);
            
            $this->imageDir = $this->imageDir . date('m') . '/';
            if (!file_exists($this->imageDir)) mkdir($this->imageDir, 0777);
        }
        return true;
    }
    
    function copyUrlFile($source, $dest)
    {
        $result = parent::copyUrlFile($source, $dest);
        if ($result) $this->attachImages[] = $dest;
        return $result;
    }
    
}
