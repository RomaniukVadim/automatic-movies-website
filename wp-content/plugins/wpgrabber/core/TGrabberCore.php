<?php
/**
* TGrabberCore
*
* @version 1.1
* @author Top-Bit <info@top-bit.ru>
* @copyright 2009-2016 Top-Bit
* @link http://top-bit.ru
*/

class TGrabberCore
{
    
    var $config;

    var $feed;
    
    var $content;
    
    var $currentUrl;

    var $picToIntro;
    
    var $introPicOn;
    
    var $testOn;
    
    var $titles;
    
    var $baseHrefs;
    
    var $onLog;
    
    var $imageDir = '';
    
    var $db;
    
    var $introTexts;
    
    var $currentTitle;
    
    var $imagesContent = array();
    
    var $requestMethod;
    
    var $rssDescs;
    
    var $imagesContentNoSave;
    
    var $filterWordsSave;
    
    var $updateFeedData = array();
    
    var $rootPath;
    
    var $textNoTranslate = array();
    
    var $titleNoTranslate = array();

    protected $_is_transaction_model = false;

    protected $_start_import = false;

    protected $_current_link = null;

    protected $_links_list = array();

    // режим автообновления
    var $autoUpdateMode = 0;

    function __construct()
    {
        if ((int)$this->config->get('phpTimeLimit')) set_time_limit($this->config->get('phpTimeLimit'));
    }

    public function setTransactionModel() {
      $this->_is_transaction_model = true;
    }

    protected function _isTransactionModel() {
      return $this->_is_transaction_model;
    }

    public function __sleep() {
      return array_keys(get_object_vars($this));
    }

    public function __wakeup() {

    }

    /**
    * Test mode On
    *
    */
    function setTest()
    {
        $this->testOn = 1;
    }
    
    /**
    * Display messages off
    * 
    */
    function onLog()
    {
        $this->onLog = 1;
    }

    /** 
    * Display message
    * 
    * @param mixed $mess
    */
    function _echo($mess)
    {
    }
    
    /**
    * Charset convert
    * 
    * @param mixed $out
    * @param mixed $inCharset
    * @param mixed $outCharset
    * @return string
    */
    function utf($out, $inCharset, $outCharset = 'UTF-8')
    {
        if ($inCharset == 'исходная') return $out;
        return iconv($inCharset, $outCharset, $out);
    }

    public function cp1251_to_uft8($v) {
      return $this->utf($v, 'CP1251');
    }
    
    /**
    * Get content for URL
    * 
    * @param mixed $url
    * @return mixed
    */
/*    function getContent($url)
    {
        if ($this->requestMethod) {
            $this->currentUrl = $url;
            $out = file_get_contents($this->_rawurlencode($url));
        }
        else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->_rawurlencode($url));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            if ($this->config->get('requestTime')) curl_setopt($ch, CURLOPT_TIMEOUT, $this->config->get('requestTime'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if (!$this->config->get('curlRedirectOn') && ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
            $out = curl_exec($ch);
            $this->currentUrl = $this->_rawurldecode(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
            curl_close($ch);
        }
        return $out;
    }*/
    
    /**
    * Получение контента ссылке с помощью fsockopen() 
    * 
    * @param mixed $url
    * @return mixed
    */
    private function getContentUrlSockOpen($url) {
        $urlParse = parse_url($url);
        $requestUrl = trim(str_replace($urlParse['scheme']. '://' . $urlParse['host'], '', $url));
        $requestUrl = $requestUrl=='' ? '/' : $requestUrl;
        $fp = fsockopen($urlParse['host'], 80, $errno, $errstr, 30);
        if (!$fp) return false;
        $headers = "GET " . $requestUrl . " HTTP/1.1\r\n";
        $headers .= "Host: " . $urlParse['host'] . "\r\n";
        $headers .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
        $headers .= "Connection: close\r\n\r\n";
        fwrite($fp, $headers);
        $out='';
        while (!feof($fp)) {
            $out .= fgets($fp, 4096);
        }
        $out = preg_replace("|.*?\r\n\r\n|is", '', $out, 1);
        return $out;
    }
    
    /**
    * Получение контента по ссылке
    * 
    * @param mixed $url
    * @return mixed
    */
    function getContent($url)
    {
        $this->currentUrl = $url;
        if (!$this->requestMethod) { // CURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->_rawurlencode($url));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            if ($this->config->get('requestTime')) curl_setopt($ch, CURLOPT_TIMEOUT, $this->config->get('requestTime'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if (!$this->config->get('curlRedirectOn') && ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
            $out = curl_exec($ch);
            $this->currentUrl = $this->_rawurldecode(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
            curl_close($ch);
        } elseif($this->requestMethod == 1) { // file_get_contents
            $out = file_get_contents($this->_rawurlencode($url));
        } else { // fsockopen
            $out = $this->getContentUrlSockOpen($this->_rawurlencode($url));
        }
        return $out;
    }
    
    /**
    * Download file
    * 
    * @param mixed $source
    * @param mixed $dest
    * @return bool
    */
/*    function copyUrlFile($source, $dest)
    {
        if (substr_count($source, 'https://')) {
            $ch = curl_init($source);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $file = curl_exec($ch);
            curl_close($ch);
            if (file_exists($dest)) @unlink($dest);
            $fp = fopen($dest,'x');
            fwrite($fp, $file);
            fclose($fp);
            return strlen($file);
        } else {
            return copy($source, $dest);           
        }
    }*/
    
    /**
    * Скачивание файла по URL-ссылке
    * 
    * @param mixed $url
    * @param mixed $file
    * @return bool
    */
    function copyUrlFile($url, $file)
    {
        // если файл по пути сохранения уже существует, то удаляем его
        if (is_file($file)) @unlink($file);
        
        // для файлов доступных по https-протоколу или если выбран метод CURL
        if (substr_count($url, 'https://') or $this->config->get('saveFileUrlMethod') == '1') {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $contentFile = curl_exec($ch);
            curl_close($ch);
            $fp = fopen($file,'x');
            fwrite($fp, $contentFile);
            fclose($fp);
        } elseif ($this->config->get('saveFileUrlMethod')=='2') { // file_get_contents + file_put_contents
            $contentFile = file_get_contents($url);
            file_put_contents($file, $contentFile);
        } else {
            if (!@copy($url, $file)) {
                // способ 2: сохранение при помощи file_get_contents/file_put_contents
                $contentFile = file_get_contents($url);
                file_put_contents($file, $contentFile);
            }
        }
        return is_file($file);
    }

    /**
    * Get array new links
    * 
    * @param array $links
    * @return array
    */
    function getLinks($links, $exists)
    {
        if (!$this->testOn) $links = array_diff($links, $exists);
        if (!$this->feed['params']['start_top']) $links = array_reverse($links);
        if ($this->feed['params']['start_link']) $links = array_slice($links, $this->feed['params']['start_link']);
        if ($this->feed['params']['max_items']) $links = array_slice($links, 0, $this->feed['params']['max_items']);
        return $links;
    }
    
    /**
    * Get URL
    * 
    * @param mixed $url
    * @return string
    */
    function getUrl($url) {
      if (!substr_count($url, 'http://') and !substr_count($url, 'https://')) {
        $page = $this->currentUrl;
        if ($this->baseHrefs[$page]) {
          $url = rtrim($this->baseHrefs[$page], '/') . '/' .  ltrim($url, '/');
        } else {
          $page = 'http://'.parse_url($page, PHP_URL_HOST);
          $url = rtrim($page, '/') . '/' . ltrim($url, '/');
        }
      }
      $url = html_entity_decode($url);
      return $url;
    }

    // Кодирует русские символы и пробел  согласно RFC 3986
    private function _rawurlencode($url) {
      static $search, $replace;
      if (!isset($search, $replace)) {
        $search = range(chr(192),chr(255));
        $search[] = chr(184);
        $search[] = chr(168);
        $search[] = ' ';
        $search = array_map(array($this, 'cp1251_to_uft8'), $search);
        $replace = array_map('rawurlencode', $search);
      }
      $url = str_replace($search, $replace, $url);
      return $url;
    }

    // Обратная функция для _rawurlencode()
    private function _rawurldecode($url) {
      static $search, $replace;
      if (!isset($search, $replace)) {
        $search = range(chr(192),chr(255));
        $search[] = chr(184);
        $search[] = chr(168);
        $search[] = ' ';
        $search = array_map(array($this, 'cp1251_to_uft8'), $search);
        $replace = array_map('rawurlencode', $search);
      }
      $url = str_replace($replace, $search, $url);
      return $url;
    }

    
    /**
    * Get URL for pictures
    * 
    * @param mixed $url
    * @return string
    */
    function getImageUrl($url)
    {
        if (substr_count($url, 'http://') or substr_count($url, 'https://')) {
            //
        } else {
            $page = $this->currentUrl;
            if ($this->baseHrefs[$page]) {
                $page = rtrim($this->baseHrefs[$page], '/');
            }
            else {
                $page = dirname($page);
            }
            if (!substr_count($url, '/')) return $page . '/' . $url;
            $page = 'http://' . parse_url($page, PHP_URL_HOST);
            $url = $page . '/' . ltrim($url, '/');
        }
        $url =  html_entity_decode($url);
        $url = str_replace(' ', '%20', $url);
        return $url;
    }
    
    
    /**
    * Search base tag on page
    * 
    * @param mixed $url
    * @param mixed $source
    */
    function setBaseHref($url, $source)
    {
        if (preg_match_all('|<base[^>]*href[\s]*=[\s\'\"]*(.*?)[\'\"\s>]|is', $html, $matches, 0, 1)) {
            $this->baseHrefs[$url] = $matches[1][0];
        }
    }
    
    /**
    * Main process import
    * 
    */
    private function _import()
    {
        if ($this->_isTransactionModel() and $this->_current_link !== null) {
          $result = $this->_saveLink($this->_links_list[$this->_current_link]);
          if ($result === null) {
            $this->_saveEmptyRecord($this->_links_list[$this->_current_link]);
          }
          $this->_current_link++;
          if (isset($this->_links_list[$this->_current_link])) {
            return $this;
          } else {
            return true;
          }
        }

        $index = $this->getContent(urldecode($this->feed['url']));

        if (trim($index) == '') {
            $this->_echo('Пустой контент RSS-ленты или индексной HTML-страницы): ' . $this->feed['url'], 2);
            return true;
        }        
        
        $encoding = $this->feed['type'] == 'html' ? $this->feed['html_encoding'] : $this->feed['rss_encoding'];
        
        // html импорт
        if ($this->feed['type'] == 'html') {
            
            $index = $this->utf($index, $encoding);
            
            // обработка пользовательскими шаблонами
            $index = $this->userReplace('index', $index);
        
            $this->setBaseHref($this->feed['url'], $index);
            $this->currentUrl = $this->feed['url'];
            
            // поиск ссылок
            if ($this->feed['params']['autoIntroOn'] == 1) {
                // ручной поиск ссылок и анонсов в тексте индексной страницы
                preg_match_all($this->feed['params']['introLinkTempl'], $index, $matches, PREG_SET_ORDER);
                if (!count($matches)) {
                    $this->_echo('Ссылки не найдены!', 1);
                    return true;
                }
                if ($this->feed['params']['orderLinkIntro']) { // порядок: анонс, ссылка
                    for ($k = 0; $k < count($matches); $k++) {
                        $this->introTexts[$this->getUrl($matches[$k][2])] = $matches[$k][1];
                    } 
                    $numArray = 2;          
                } else { // порядок: ссылка, анонс
                    for ($k = 0; $k < count($matches); $k++) {
                        $this->introTexts[$this->getUrl($matches[$k][1])] = $matches[$k][2];
                    }
                    $numArray = 1;          
                } 
            } else {
                preg_match_all('~' . $this->feed['links'] . '~is', $index, $matches, PREG_SET_ORDER);
                $numArray = 0;
            }

            if (!count($matches)) {
                $this->_echo('Найдено ссылок: 0', 2);
                return true;
            }
            // + удаляются дубли
            foreach ($matches as $v) {
                $__url = $this->getUrl($v[$numArray]);
                $links[$__url] = $__url;
            }
            $this->_echo('Найдено ссылок: <b>' . count($links) . '</b><br />' . implode('<br />', $links) . '<br />');
            $this->feed['link_count'] = count($links);
            $links = $this->getLinks($links);
            $this->_echo('Из них ссылок для текущего импорта: <b>' . count($links) . '</b><br />' . implode('<br />', $links) . '<br />');
        }
        elseif ($this->feed['type'] == 'rss') { // rss
            $index = $this->userReplace('index', $index);
            $xml = simplexml_load_string($index);
            foreach ($xml->channel->item as $item) {
                $title = $this->utf((string) $item->title, $this->feed['rss_encoding']);
                $link = $this->utf((string) $item->link, $this->feed['rss_encoding']);
                $this->rssDescs[$link] = $this->utf((string) $item->description, $this->feed['rss_encoding']);
                $links[$link] = $link;
                $this->titles[$link] = $title;
            }
            $this->_echo('Найдено ссылок: <b>' . count($links) . '</b><br />' . implode('<br />', $links) . '<br />');
            $this->feed['link_count'] = count($links);
            $links = $this->getLinks($links);
            $this->_echo('Из них ссылок для текущего импорта: <b>' . count($links) . '</b><br />' . implode('<br />', $links) . '<br />');
        }
        elseif ($this->feed['type'] == 'vk') { // vk
            $index = $this->utf($index, 'windows-1251');
            
            // обработка пользовательскими шаблонами
            $index = $this->userReplace('index', $index);
            
            preg_match_all('|<div id="(post-\d{1,}_\d{1,})".*?<div class="wall_text">(.*?)<div class="post_full_like_wrap sm fl_r">|is', $index, $matches);
            if (!count($matches)) {
                $this->_echo('Найдено постов: 0', 2);
                return true;
            }
            foreach ($matches[1] as $_k => $v) {
                $__url = $this->feed['url'] . '#' . $v;
                $links[$__url] = $__url;
                $_buffVK[$__url] = $matches[2][$_k];
            }
            $this->_echo('Найдено постов: <b>' . count($links) . '</b><br />' . implode('<br />', $links) . '<br />');
            $this->feed['link_count'] = count($links);
            $links = $this->getLinks($links);
            $this->_echo('Из них постов для текущего импорта: <b>' . count($links) . '</b><br />' . implode('<br />', $links) . '<br />');
            foreach ($links as $link) {
                $this->content[$link]['text'] = $_buffVK[$link];
                $this->content[$link]['text'] = preg_replace('|<span style="display: none">|is', '<span>', $this->content[$link]['text']);
                $this->content[$link]['text'] = preg_replace('|<div class="media_desc">.*?</div>|is', '', $this->content[$link]['text']);
                $this->content[$link]['text'] = preg_replace('|<div class="page_post_queue_wide">.*?</div>|is', '', $this->content[$link]['text']);
                $this->content[$link]['text'] = preg_replace('|<a  onclick="return showPhoto.*?base&quot;:&quot;(.*?)&quot;,&quot;x_&quot;:\[&quot;(.*?)&quot;.*?><img.*?></a>|is', '<img src="$1$2.jpg" />', $this->content[$link]['text']);
                $this->content[$link]['text'] = preg_replace('|<a  href=".*?" onclick="return showPhoto.*?base:&quot;(.*?)&quot;,x_:\[&quot;(.*?)&quot;.*?><img.*?></a>|is', '<img src="$1$2.jpg" />', $this->content[$link]['text']);
                $this->content[$link]['text'] = preg_replace('|<a class="author".*?</a>|is', '', $this->content[$link]['text']);
                $this->content[$link]['text'] = preg_replace('|<div class="wall_signed">.*?</div>|is', '', $this->content[$link]['text']);
                $this->content[$link]['text'] = preg_replace('|<a class="wall_post_more" onclick="hide.*?</a>|is', '', $this->content[$link]['text']);
                //$this->content[$link]['title'] = $this->feed['title'];
                 
                if (trim($this->feed['title'])!='') {
                    if (preg_match('~' . $this->feed['title'] . '~is', $this->content[$link]['text'], $buff)) {
                        if (count($buff) == 2) {
                            $this->content[$link]['title'] = $buff[1];
                        } elseif (count($buff) == 1) {
                            $this->content[$link]['title'] = $buff[0];
                        } else {
                            $this->content[$link]['title'] = $this->getTitleFromVKText($this->content[$link]['text']);
                        }
                    } else {
                        $this->content[$link]['title'] = $this->getTitleFromVKText($this->content[$link]['text']);
                    }
                } else {
                    $this->content[$link]['title'] = $this->getTitleFromVKText($this->content[$link]['text']);
                }
                $this->content[$link]['title'] = strip_tags($this->content[$link]['title']);
                
                // И сразу сохраняем
                $this->beforeSaveLoop($link);
                $result = $this->save($link);
                if (!$result) {
                  $this->cleanImages();
                  $this->content[$link] = null;
                  if ($result === null) {
                    $this->_saveEmptyRecord($link);
                  }
                }
            }
            return true;
        }
        if (count($links) > 0) {
          $this->_echo('<b>Загрузка страниц:</b>');
          if ($this->_isTransactionModel()) {
            $this->_current_link = 0;
            $this->_links_list = array_values($links);
            return $this;
          } else {
            foreach ($links as $link) {
              $result = $this->_saveLink($link);
              if ($result === null) {
                $this->_saveEmptyRecord($link);
              }
            }
          }
        }
        return true;
    }
    /**
    * Парсит данные по отдельной ссылке и сохраняет в БД
    * Возращает
    * True - если успешно сохранено
    * False - если не удалось сохранить
    * Null - если не найден контент для сохранения
    * @param string $link
    */
    protected function _saveLink($link) {
      if ($this->feed['type'] == 'rss' && $this->feed['params']['rss_textmod']) {
          $this->_echo('<br />RSS description tag');
          $page = $this->rssDescs[$link];
      } else {
          $this->_echo('<br /><a target="_blank" href="' . $link . '">' . $link . '</a>');
          $page = $this->getContent($link);
          $page = $this->userReplace('page', $page);
          $this->content[$link]['location'] = $this->currentUrl;
          $page = $this->utf($page, $this->feed['html_encoding']);
      }
      if (trim($page) == '') {
          $this->_echo('<font color="red"> пустая страница!</font>');
          return null;
      } else {
          $this->_echo(' <font color="green">(' . mb_strlen($page, 'utf-8') . ' Байт)</font>');
      }
      //$this->currentUrl = $link;
      $this->setBaseHref($this->currentUrl, $page);
      if ($this->feed['type'] == 'rss' and trim($this->titles[$link]) != '') {
          $this->content[$link]['title'] = $this->titles[$link];
      }
      else {
          // поиск заголовка
          preg_match('~' . $this->feed['title'] . '~is', $page, $title_matches);
          if (count($title_matches) == 0) {
              $this->_echo('<font color="red"> Заголовок не найден! </font>');
              return null;
          }
          $this->content[$link]['title'] = $title_matches[1];
      }
      if ($this->feed['type'] == 'rss' && $this->feed['params']['rss_textmod']) {
          $text_matches[1] = $this->rssDescs[$link];
      } else {
          // поиск текста
          preg_match('~' . addcslashes($this->feed['text_start'], '&|') . '(.*?)' .  addcslashes($this->feed['text_end'], '&|')  . '~is', $page, $text_matches);
          if (count($text_matches) == 0) {
              $this->_echo('<font color="red"> текст не найден!</font>');
              return null;
          }
      }
      $this->content[$link]['text'] = $text_matches[1];

      // И сразу сохраняем
      $this->beforeSaveLoop($link);
      $result = $this->save($link);
      if (!$result) {
        $this->cleanImages();
        $this->content[$link] = null;
        return $result;
      }
      return true;
    }

    protected function _saveEmptyRecord($url) {
      return true;
    }
    
    /**
    * Get unique name for file in folder
    *
    * @param mixed $file
    */
    function getMDNameFile($file)
    {
        static $ext = false;
        if (!$ext) $ext = preg_replace('|\?.*?|is', '', pathinfo($file, PATHINFO_EXTENSION));
        $file = $this->rootPath . $this->config->get('imgPath') . $this->imageDir . md5(microtime() + mt_rand(1, 100)) . ".$ext";
        if (is_file($file)) return $this->getMDNameFile($file);
        return $file;    
    }
    
    /** 
    * Resize image
    * 
    * @param mixed $input
    * @param mixed $output
    * @param mixed $width
    * @param mixed $height
    * @param mixed $quality
    */
    function imageResize($input, $output, $width, $height = 0, $quality = 100)
    {
        $input_size = getimagesize($input);
        // only width
        if ($height == 0) {
            $input_ratio = $input_size[0] / $input_size[1];
            $height = $width / $input_ratio;
            if ($input_size[0] < $width) {
                if ($input != $output) copy($input, $output);
                return true;
            }
        }
        else {
            $input_ratio = $input_size[0] / $input_size[1];
            $ratio = $width / $height;
            if ($ratio < $input_ratio) {
                $height = $width / $input_ratio;
            }
            else {
                $width = $height * $input_ratio;
            }
            if (($input_size[0] < $width) && ($input_size[1] < $height)) {
                if ($input != $output) copy($input, $output);
                return true;
            }
        }
        // create empty picture
        $dest_image = imagecreatetruecolor($width, $height);
        if ($input_size[2] == 1) $i_image = imagecreatefromgif($input);
        if ($input_size[2] == 2) $i_image = imagecreatefromjpeg($input);
        if ($input_size[2] == 3) $i_image = imagecreatefrompng($input);
    
        if (!imagecopyresampled($dest_image, $i_image, 0, 0, 0, 0, $width, $height, $input_size[0], $input_size[1])) {
             return false;
        }
        if (file_exists($output)) unlink($output);
        if ($input_size[2] == 1) imagegif($dest_image, $output);
        if ($input_size[2] == 2) imagejpeg($dest_image, $output, $quality);
        if ($input_size[2] == 3) imagepng($dest_image, $output);
        imagedestroy($dest_image);
        imagedestroy($i_image);
        return true;
    }
    
    /**
    * Crop image
    * 
    * @param mixed $input
    * @param mixed $output
    * @param mixed $width
    * @param mixed $height
    * @param mixed $quality
    */
    function imageCrop($input, $output, $width, $height, $quality=100) 
    {    
        $input_size = getimagesize($input);
        if ($input_size[2] == 1) $image = imagecreatefromgif($input);
        if ($input_size[2] == 2) $image = imagecreatefromjpeg($input);
        if ($input_size[2] == 3) $image = imagecreatefrompng($input); 
        $image_width = imagesx($image);
        $image_height = imagesy($image);
        if ($image_width / $image_height > $width / $height) {
            $thumb_width = $image_width * ($height / $image_height);
            $thumb_height = $height;
        } else {
            $thumb_width = $width;
            $thumb_height = $image_height * ($width / $image_width);
        }

        $thumb_image = imagecreatetruecolor($thumb_width, $thumb_height);
        imagecopyresampled($thumb_image, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);
        $crop_image = imagecreatetruecolor($width, $height);
        imagecopy($crop_image, $thumb_image, 0, 0, intval(($thumb_width - $width) / 2), intval(($thumb_height - $height) / 2), $width, $height);
        if (is_file($output)) unlink($output);
        if ($input_size[2] == 1) imagegif($crop_image, $output);
        if ($input_size[2] == 2) imagejpeg($crop_image, $output, $quality);
        if ($input_size[2] == 3) imagepng($crop_image, $output);
        imagedestroy($crop_image);
        imagedestroy($image);
        return true;
    }
    
    /**
    * Generate img tag for images
    * 
    * @param mixed $image
    * @param mixed $width
    * @param mixed $height
    * @param mixed $attr
    */
    function getImageResize($image, $width, $height = 0, $adds)
    {
        $imageinfo = getimagesize($image);
        if (!$imageinfo[0] and !$imageinfo[1]) {
            // TO DO***** copy file to server, get size, than delete...
        }
        $out['w'] = $imageinfo[0];
        $out['h'] = $imageinfo[1];        
        if ($height == 0) {
            $input_ratio = $imageinfo[0] / $imageinfo[1];
            $height = $width / $input_ratio;
            if ($imageinfo[0] < $width) {
                $width = $imageinfo[0];
                $height = $imageinfo[1];
            }
        }
        else {
            $input_ratio = $imageinfo[0] / $imageinfo[1];
            $ratio = $width / $height;
            if ($ratio < $input_ratio) {
                $height = $width / $input_ratio;
            }
            else {
                $width = $height * $input_ratio;
            }
            if (($imageinfo[0] < $width) && ($imageinfo[1] < $height)) {
                $width = $imageinfo[0];
                $height = $imageinfo[1];
            }
        }
        $attr = ' height="' . floor($height) . '" width="' . floor($width) . '"';
        return $this->imageHtmlCode($image, $adds, $attr);
    }
    
    /**
    *  processing of images from a template
    * 
    */
    function imageHtmlCode($url, $adds = '', $attr = '')
    {
        $this->imagesContentNoSave = false;
        if (!$this->testOn && ($this->feed['params']['image_save'] || $this->feed['params']['img_path_method'])) {
            if ($this->feed['params']['img_path_method']=='1') $url = ltrim($url, '/');
            if ($this->feed['params']['img_path_method']=='2') $url = rtrim(site_url(), '/') . $url;
            
        } 
        return strtr($this->feed['params']['imageHtmlCode'], array('%TITLE%' => htmlentities($this->currentTitle, ENT_COMPAT, 'UTF-8'), '%PATH%' => $url, '%ADDS%' => $adds, '%ATTR%' => $attr));                             
    }
    
    
    /**
    * process the first picture in the anounce
    * 
    */
    function introPicOn($file, $save = 0, $adds = '')
    {
        $this->introPicOn = 0;
        // saving images on the server
        if ($save) {
            $imageFileInto = $this->getMDNameFile(basename($file)); 
            if ($this->copyUrlFile($file, $imageFileInto)) {
                $this->picToIntro = $this->imageHtmlCode($this->config->get('imgPath') . $this->imageDir . basename($imageFileInto), $adds);
                $this->imagesContent[] = $this->config->get('imgPath') . $this->imageDir . basename($imageFileInto);
                if ($this->feed['params']['image_resize']) { // resizing
                    if ($this->feed['params']['img_intro_crop']) {
                        $this->imageCrop($imageFileInto, $imageFileInto, $this->feed['params']['intro_pic_width'], $this->feed['params']['intro_pic_height'], $this->feed['params']['intro_pic_quality']);
                    } else {
                        $this->imageResize($imageFileInto, $imageFileInto, $this->feed['params']['intro_pic_width'], $this->feed['params']['intro_pic_height'], $this->feed['params']['intro_pic_quality']);
                    }                               
                }  
            }                                                   
        } else { // without saving
            if ($this->feed['params']['image_resize']) { // resizing
                $this->picToIntro = $this->getImageResize($file, $this->feed['params']['intro_pic_width'], $this->feed['params']['intro_pic_height'], $adds);
            } else {
                $this->picToIntro = $this->imageHtmlCode($file, $adds);   
            }
        } 
    }
    
    /**
    * Parsing images in the text
    * 
    * @param string $matches
    * @return mixed
    */
    function imageParser($matches) 
    {
        $matches[3] = $this->getImageUrl($matches[3]);
        $this->_echo('<br /><a target="_blank" href="' . $matches[3] . '">' . $matches[3] . '</a> ');        
        // image processing
        if ($this->feed['params']['image_save']) { // saving images on the server
            $imageFile = $this->getMDNameFile(basename($matches[3])); 
            if ($this->copyUrlFile($matches[3], $imageFile)) {
                // the first picture in the preview
                if ($this->introPicOn and ($this->feed['params']['intro_pic_on'] or $this->feed['params']['image_intro_on'])) $this->introPicOn($imageFile, 1, "{$matches[1]} {$matches[4]}");
                $matches[3] = $this->config->get('imgPath') . $this->imageDir . basename($imageFile);
                $this->imagesContent[] = $matches[3];
                $this->_echo(' - <a href="/' . $matches[3] . '" style="color:green; font-weight: bold">OK</a>');
                // resizing
                if ($this->feed['params']['image_resize']) $this->imageResize($imageFile, $imageFile, $this->feed['params']['text_pic_width'], $this->feed['params']['text_pic_height'], $this->feed['params']['text_pic_quality']);   
                return $this->imageHtmlCode($matches[3], "{$matches[1]} {$matches[4]}");                     
            }
            else {
                $this->_echo(' - <b style="color:red">Ошибка сохранения файла картинки!</b>');
            }
        }
        else { // without saving
            if ($this->feed['params']['image_resize']) { // resizing
                if ($this->introPicOn and $this->feed['params']['intro_pic_on']) $this->introPicOn($matches[3], 0, "{$matches[1]} {$matches[4]}"); 
                return $this->getImageResize($matches[3], $this->feed['params']['text_pic_width'], $this->feed['params']['text_pic_height'], "{$matches[1]} {$matches[4]}");
            } else { // without resizing
                if ($this->introPicOn and $this->feed['params']['intro_pic_on']) $this->introPicOn($matches[3], 0, "{$matches[1]} {$matches[4]}"); 
                return $this->imageHtmlCode($matches[3], "{$matches[1]} {$matches[4]}");                
            }
        }
    }       
    
    /**
    * Search for images in the text
    * 
    * @param mixed $text
    * @return mixed
    */
    function imageProcessor($text)
    {
        $this->images = array();
        // если включена обработка пробелов в путях картинок
        if ($this->feed['params']['image_space_on']) {
            $text = preg_replace_callback('|<img(.*?)src(.*?)=[\s\'\"]*(.*?)[\'\"](.*?)>|is', array(&$this, 'imageParser'), $text);
        } else {
            $text = preg_replace_callback('|<img(.*?)src(.*?)=[\s\'\"]*(.*?)[\'\"\s](.*?)>|is', array(&$this, 'imageParser'), $text);
        }
        return $text;
    }
    
    
    /**
    * Create a directory for images
    *
    */
    function mkImageDir()
    {
        $this->imageDir = date('Ymd') . '/';
        $imageDirPath = $this->rootPath . $this->config->get('imgPath') . $this->imageDir;
        if (file_exists($imageDirPath)) return;
        if (!file_exists($this->rootPath . $this->config->get('imgPath'))) mkdir($this->rootPath . $this->config->get('imgPath'), 0777);
        mkdir($imageDirPath, 0777);
    }
    
    /**
    * 
    * 
    * @param mixed $id
    * @param mixed $url
    */
    function saveContentRecord($id, $url)
    {
    }

    
    function getTitleFromVKText($text)
    {
        $text = strip_tags($text);
        $__introtext = preg_replace('/\s{2,}/', ' ', trim($text));
        $__introtext = explode(' ', $__introtext);
        $__introtext = array_slice($__introtext, 0, $this->feed['params']['title_words_count']);
        return implode(' ', $__introtext);
    }
    
    /**
    * Saving content
    * Возращает
    * True - если успешно сохранено
    * False - если не удалось сохранить
    * Null - если не найден контент для сохранения
    * @param mixed $url
    */
    function save($url)
    {
        $record =& $this->content[$url];
        
        // если определение анонса в ручную:
        if ($this->feed['params']['autoIntroOn'] == 1) {
            $this->introTexts[$url] = $this->userReplace('intro', $this->introTexts[$url]);
            $record['text'] = $this->introTexts[$url] . '{{{MORE}}}' . $record['text'];
        }
        
        $this->_echo('<br /><br /><a target="blank" href="' . $url . '">' . $record['title'] . '</a>');
        
        // обработка фильтр-слов
        if ($this->feed['params']['filter_words_on']) {
            if ($this->feed['params']['filter_words_where']=='title') {
                $filter_words_text = $record['title'];
            } elseif ($this->feed['params']['filter_words_where']=='text') {
                $filter_words_text = $record['text'];
            } elseif ($this->feed['params']['filter_words_where']=='title+text') {
                $filter_words_text = "{$record['title']} {$record['text']}";
            }

            preg_match_all("/(" . $this->filterWordsSave . ")/is", $filter_words_text, $_word_search);
            // не сохранять материалы
            if ($this->feed['params']['filter_words_save']) { 
                if (count($_word_search[1])) {
                    $this->_echo('<br /><i>Материал будет не сохранен по причине наличия следующих фильтр-слов в нем: ' . implode(', ', $_word_search[1]) . '</i>');
                    return null;
                } else {
                    $this->_echo('<br /><i>Материал будет сохранен по причине отсутствия фильтр-слов в нем' . '</i>');
                }
            } elseif (!$this->feed['params']['filter_words_save']) {
                if (count($_word_search[1])) {
                    $this->_echo('<br /><i>Материал будет сохранен по причине наличия следующих фильтр-слов в нем: ' . implode(', ', $_word_search[1]) . '</i>');
                } else {
                    $this->_echo('<br /><i>Материал будет не сохранен по причине отсутствия фильтр-слов в нем' . '</i>');
                    return null;
                }
            } 
        }
        
        // отображает то что был редирект
        //if ($url != $record['location']) $this->_echo(" redirect to --> <a href=\"{$record['location']}\">{$record['location']}</a>");
        $this->currentUrl = $record['location'];
        
        // удаление script и style
        
        
        if (!$this->feed['params']['js_script_no_del'])
            $record['text'] = preg_replace('|<script.*?</script>|is','', $record['text']);
        
        if (!$this->feed['params']['css_no_del'])    
            $record['text'] = preg_replace('|<style.*?</style>|is','', $record['text']);       
        
        // обработка пользовательскими шаблонами текста страницы
        $record['text'] = $this->userReplace('text', $record['text']);

             
        
/*        if ($this->feed['type']=='vk') {
            $__introtext = strip_tags($record['text'], '<br><br/>');
            if (trim($__introtext)!='' and $this->feed['params']['title_words_count']) {
                $__introtext = preg_replace('/\s{2,}/', ' ', trim($__introtext));
                $__introtext = explode(' ', $__introtext);
                $__introtext = array_slice($__introtext, 0, $this->feed['params']['title_words_count']);
                $record['title'] = implode(' ', $__introtext);
         //if (mb_strlen($__introtext, 'utf-8') > 100) {
           //                 $_substr = strripos(substr($__introtext, 0, 100), ' ');
             //               $record['title'] = substr($__introtext, 0, $_substr);
               //         } else {
                 //           $record['title'] = $__introtext;
                   //     }
            } else {
                $record['title'] = $this->feed['title'] . ' ' . mt_rand(10,100);
            }
            $record['title'] = $this->userReplace('title', $record['title']);
            $record['title'] = str_replace(array('<br>', '&#33;', "\r\n", "\r", "\n", "\t", '<br/>'), ' ', $record['title']);
            $record['title'] = strip_tags(html_entity_decode($record['title'], ENT_QUOTES, 'utf-8'));
            $record['title'] = trim($record['title']);
        }
        
*/        

        // обработка пользовательскими шаблонами заголовка
        $record['title'] = $this->userReplace('title', $record['title']);
        
        // удаление HTML тегов из заголовка
        $record['title'] = strip_tags(html_entity_decode($record['title'], ENT_QUOTES, 'utf-8')); 
        
        
        $this->currentTitle = $record['title'];
        
        // удаление HTML тегов из текста
        if ($this->feed['params']['strip_tags']) {
            $record['text'] = trim(strip_tags($record['text'], $this->feed['params']['allowed_tags']));
        }
        
        // Обработка изображений
        $this->_echo('<br /><b>Обработка изображений в тексте:</b>');
        $this->introPicOn = 1;
        if (!$this->testOn and $this->feed['params']['image_save']) $this->mkImageDir();
        $record['text'] = $this->imageProcessor($record['text']); 
        
        if ($this->imagesContentNoSave) {
            $this->_echo("<br>Материл не будет сохранен по причине отсутсвия в нем картинок! (см. опцию: Не сохранять материал без картинок)");
            return null;
        }

        $this->_pluginTranslate($record);

        $this->_pluginSynonymize($record);

        if (empty($record['text'])) {
          $this->_echo('<br /><i>Материл не будет сохранен по причине отсутствия в нем контента</i>');
          return null;
        }
        return true;
    }
    
    /**
    * Processing of user templates
    * 
    * @param mixed $key
    * @param mixed $text
    * @return mixed
    */
    function userReplace($key, $text) {
        if (!$this->feed['params']['user_replace_on']) return $text;
        if (!is_array($this->feed['params']['replace'])) return $text;
        if (count($this->feed['params']['replace'][$key])) {
            foreach ($this->feed['params']['replace'][$key] as $v) {
                if ($v['limit'] == '') $v['limit'] = -1;
                $text = preg_replace($v['search'], $v['replace'], $text, $v['limit']);
            }
        }
        return $text;
    }
    
    /**
    * Clearing the text
    * 
    * @param mixed $text
    * @return string
    */
    function textClean($text)
    {
        $text = preg_replace('|<script[^>]*?>.*?</script>|si', ' ', $text);
        $text = preg_replace('|<style[^>]*?>.*?</style>|si', ' ', $text);
        $cleanSymbol = array("\n", "\r", "\t", '`', '"', '>', '<');
        $text = html_entity_decode($text);
        $text = str_replace($cleanSymbol, ' ', strip_tags($text));
        //$text = preg_replace('|[\s]{1,}|si', ' ', $text);
        return trim($text);
    }    
    
    /**
    * Transliteration of text
    * 
    * @param mixed $str
    * @return string
    */
    function translit($str) {
        $trans = array('а'=>'a', 'А'=>'A', 'б'=>'b', 'Б'=>'B', 'в'=>'v', 'В'=>'V', 'г'=>'g', 'Г'=>'G', 'д'=>'d', 'Д'=>'D', 'е'=>'e', 'Е'=>'E', 'ё'=>'e', 'Ё'=>'E', 'ж'=>'j', 'Ж'=>'J', 'з'=>'z', 'З'=>'Z', 'и'=>'i', 'И'=>'I', 'й'=>'i', 'Й'=>'I', 'к'=>'k', 'К'=>'K', 'л'=>'l', 'Л'=>'L', 'м'=>'m', 'М'=>'M', 'н'=>'n', 'Н'=>'N', 'о'=>'o', 'О'=>'O', 'п'=>'p', 'П'=>'P', 'р'=>'r', 'Р'=>'R', 'с'=>'s', 'С'=>'S', 'т'=>'t', 'Т'=>'T', 'у'=>'y', 'У'=>'Y', 'ф'=>'f', 'Ф'=>'F', 'х'=>'h', 'Х'=>'H', 'ц'=>'c', 'Ц'=>'C', 'ч'=>'ch', 'Ч'=>'CH', 'ш'=>'sh', 'Ш'=>'SH', 'щ'=>'sh', 'Щ'=>'SH', 'ъ'=>'', 'Ъ'=>'', 'ы'=>'y', 'Ы'=>'Y', 'ь'=>'', 'Ь'=>'', 'э'=>'e', 'Э'=>'E', 'ю'=>'u', 'Ю'=>'U', 'я'=>'ia', 'Я'=>'IA', ' '=>'-');
        return strtr($str, $trans);
    }
    
    /**
    * Generate keywords
    * 
    * @param string $content
    * @return string
    */
    function genTagKeywords($content)
    {
        $content = $this->textClean($content); 
        if (function_exists('mb_strtolower')) {
            $content = mb_strtolower($content, 'utf-8');
        } else {
            $content = strtolower($content);            
        }
        preg_match_all('|[a-zA-Zа-яА-Я]{3,}|ui', $content, $buff);
        $buff = $buff[0];
        if (!count($buff)) return '';
        array_unique($buff);
        $words = array_count_values($buff);
        $words = array_keys($words);
        $keyWordsStopList = str_replace(array("\t", "\n", "\r"), '', $this->feed['params']['metaKeysStopList']);
        $keyWordsStopList = str_replace(array(', ', ' ,'), ',', $keyWordsStopList);
        $keyWordsStopList = explode(',', $keyWordsStopList);
        if (count($keyWordsStopList)) $words = array_diff($words, $keyWordsStopList);
        $words = array_slice($words, 0, $this->feed['params']['metaKeysSize']);   
        if (count($words) > 0) {
            return implode(', ', $words);
        } 
    }
    
    /**
    * Generate description
    * 
    * @param string $content
    * @return string
    */
    function genTagDescription($content)
    {
        $content = $this->textClean($content); 
        if (function_exists('mb_substr')) {
            $length = strripos(mb_substr($content, 0, $this->feed['params']['metaDescSize'], 'utf-8'), ' ');
            return mb_substr($content, 0, $length, 'utf-8');
        }
        else {
            $length = strripos(substr($content, 0, $this->feed['params']['metaDescSize']), ' ');
            return substr($content, 0, $length);
        }
    }
    
    /**
    * put your comment there...
    * 
    */
    function cleanImages()
    {
        if (!count($this->imagesContent)) return true;
        $this->_echo('<br>Очистка не используемых файлов картинок...');
        foreach ($this->imagesContent as $file) {
            @unlink($this->rootPath.$file);
        }
    }
    
    /**
    * put your comment there...
    * 
    */
    function beforeSaveLoop()
    {
    }
    
    /**
    * Основной процесс граббинга ленты с ID = $id
    * При транзакционной модели вернет объект если импорт не завершен,
    * true - когда завершен, false - в случае ошибки
    * @param mixed $id
    */
    final public function execute($id)
    {
        if ($this->_start_import === false) {
          $this->feed = $this->_getFeed($id);
          if (empty($this->feed)) {
            $this->_echo('<b>Лента ID'.$id.' не найдена</b><br />');
          }
          $this->_beforeExecute($id);
        }

        $result = $this->_import();

        if ($this->_isTransactionModel() and $result !== true) {
          return $result;
        }

        $this->_afterExecute($id);

        return true;
    }

    protected function _getFeed($id) {
      return array();
    }

    protected function _beforeExecute($id) {  
      $this->_start_import = time();

      $this->_echo('<b>Импорт ленты: <a target="_blank" href="' . $this->feed['url'] . '">' . $this->feed['name'] . '</a> - ' . date('H:i:s Y-m-d', $this->_start_import) . '</b><br />');
      $this->feed['params'] = unserialize( base64_decode( $this->feed['params'] ) );

      if (trim($this->feed['params']['imageHtmlCode']) == '') $this->feed['params']['imageHtmlCode'] = '<img src="%PATH%" %ATTR% />';

      
      $this->requestMethod = $this->feed['params']['requestMethod'] == '0' ? $this->config->get('getContentMethod') : (int) ($this->feed['params']['requestMethod']-1);


      if ($this->feed['params']['image_path'] and !$this->testOn) {
          $this->config->set('imgPath', $this->feed['params']['image_path']);
      }

      if ($this->feed['params']['filter_words_on']) {
          $this->filterWordsSave = '';
          $filter_words_list = @explode(',', $this->feed['params']['filter_words_list']);
          if (count($filter_words_list)) {
              array_walk($filter_words_list, create_function('&$val', '$val = trim($val);'));
              $filter_words_list = array_filter($filter_words_list);
              $this->filterWordsSave = implode('|', $filter_words_list);
          }
          if (trim($this->filterWordsSave)=='') {
              $this->feed['params']['filter_words_on'] = 0;
              $this->_echo('<br /><br><b>Список фильтр-слов пуст! Обработка фильтр слов отключена для данного процесса импорта.</b><br />');
          }
      }
      $this->imagesContentNoSave = $this->feed['params']['no_save_without_pic'] ? true : false;
    }

    protected function _afterExecute($id) {
      $last_count = count($this->content);

      if ($last_count > 0) {
        $this->updateFeedData['last_url'] = "'" . (key($this->content)) . "'";
      }
      if ($this->testOn) {
        $this->_echo('<br /><br><b>Тестовый импорт ленты: <a target="_blank" href="' . $this->feed['url'] . '">' . $this->feed['name'] . '</a> - ' . date('H:i:s Y-m-d') . ' - завершен!</b><br /><br />');
      } else {
        $end = time() - $this->_start_import;
        $this->updateFeedData['last_update'] = (int) time();
        $this->updateFeedData['work_time'] = (int) $end;
        $this->updateFeedData['last_count'] = (int) $last_count;
        $this->updateFeedData['link_count'] = (int) $this->feed['link_count'];
        // режим отключения неработающих лент
        if ($this->config->get('offFeedsModeOn')) $this->updateFeedData['published'] = 1;
      }
      $this->_start_import = false;
    }

    protected function _pluginSynonymize(&$record) {
      return null;
    }

    protected function _pluginTranslate(&$record) {
      $errors = array();
      if ($this->feed['params']['translate_on']) {
        $provider = (int)$this->feed['params']['translate_method'];
        $params = array();
        if ($provider == 0) {
          // API Яндекс.Перевода
          $provider = 'Yandex';
          $params['lang'] = $this->feed['params']['translate_lang'];
          $params['key'] = !empty($this->feed['params']['yandex_api_key']) ? $this->feed['params']['yandex_api_key'] : $this->config->get('yandexApiKey');
        } elseif ($provider == 1) {
          //API Bing Переводчика
          $provider = 'Bing';
          $lang = explode('-', $this->feed['params']['translate_lang']);
          $params['from'] = str_replace('_', '-', $lang[0]);
          $params['to'] = isset($lang[1]) ? str_replace('_', '-', $lang[1]) : $lang[1];
          $params['key'] = $this->config->get('bingApiKey');
        } else {
          $errors[] = 'Ошибка первого перевода. Неправильно указана система перевода.';
        }
        if (!sizeof($errors)) {
            $this->textNoTranslate[$this->currentUrl] = $record['text'];
            // первый перевод текста
            if (($text = $this->_translate($record['text'], $provider, $params, $e)) !== false) {
                // не сохранять запись если не перевели текст
                if ($this->feed['params']['nosave_if_not_translate']) {
                    if (md5($text) == md5($record['text'])) {
                        $record['text'] = '';
                        $errors[] = 'Текст не был переведен! Включена опция не сохранять записи без перевода!';
                    } else {
                        $record['text'] = $text;
                    }
                } else { // сохранять даже если не перевели текст
                    $record['text'] = $text;
                }
              } else {
                $errors[] = 'Ошибка первого перевода текста. '.current($e);
                // не сохранять запись если не перевели текст
                if ($this->feed['params']['nosave_if_not_translate']) {
                    $record['text'] = '';
                    $errors[] = 'Текст не был переведен! Включена опция не сохранять записи без перевода!';
                } 
            }
          
          $this->titleNoTranslate[$this->currentUrl] = $record['title'];
          // первый перевод заголовка
          if (($title = $this->_translate($record['title'], $provider, $params, $e)) !== false) {
              // не сохранять запись если не перевели заголовок
              if ($this->feed['params']['nosave_if_not_translate']) {
                if (md5($title) == md5($record['title'])) {
                    $record['title'] = '';
                    $errors[] = 'Заголовок не был переведен! Включена опция не сохранять записи без перевода!';
                } else { // сохрянить запись, даже если не перевели заголовок
                    $record['title'] = $title;
                }      
              } else {
                  $record['title'] = $title;
              }
          } else {
            $errors[] = 'Ошибка первого перевода заголовка. '.current($e);
            // не сохранять запись если не перевели заголовок
            if ($this->feed['params']['nosave_if_not_translate']) {
                $record['title'] = '';
                $errors[] = 'Заголовок не был переведен! Включена опция не сохранять записи без перевода!';
            } 
          }
        }
      }
      if (!sizeof($errors)) {
        if ($this->feed['params']['translate2_on']) {
          $provider = (int)$this->feed['params']['translate2_method'];
          $params = array();
          if ($provider == 0) {
            // API Яндекс.Перевода
            $provider = 'Yandex';
            $params['lang'] = $this->feed['params']['translate2_lang'];
            $params['key'] = !empty($this->feed['params']['yandex_api_key2']) ? $this->feed['params']['yandex_api_key2'] : $this->config->get('yandexApiKey');
          } elseif ($provider == 1) {
            //API Bing Переводчика
            $provider = 'Bing';
            $lang = explode('-', $this->feed['params']['translate2_lang']);
            $params['from'] = str_replace('_', '-', $lang[0]);
            $params['to'] = isset($lang[1]) ? str_replace('_', '-', $lang[1]) : $lang[1];
            $params['key'] = $this->config->get('bingApiKey');
          } else {
            $errors[] = 'Ошибка второго перевода. Неправильно указана система перевода.';
          }
          if (!sizeof($errors)) {
              
            // второй перевод текста
            if (($text = $this->_translate($record['text'], $provider, $params, $e)) !== false) {
                // не сохранять запись если не перевели текст
                if ($this->feed['params']['nosave_if_not_translate']) {
                    if (md5($text) == md5($record['text'])) {
                        $record['text'] = '';
                        $errors[] = 'Текст не был переведен во втором переводе! Включена опция не сохранять записи без перевода!';
                    } else {
                        $record['text'] = $text;
                    }
                } else { // сохранять даже если не перевели текст
                    $record['text'] = $text;
                }
            } else {
              $errors[] = 'Ошибка второго перевода текста. '.current($e);
                // не сохранять запись если не перевели текст
                if ($this->feed['params']['nosave_if_not_translate']) {
                    $record['text'] = '';
                    $errors[] = 'Текст не был переведен во втором переводе! Включена опция не сохранять записи без перевода!';
                } 
            }
            
            // второй перевод заголовка
            if (($title = $this->_translate($record['title'], $provider, $params, $e)) !== false) {
              // не сохранять запись если не перевели заголовок
              if ($this->feed['params']['nosave_if_not_translate']) {
                if (md5($title) == md5($record['title'])) {
                    $record['title'] = '';
                    $errors[] = 'Заголовок не был переведен! Включена опция не сохранять записи без перевода!';
                } else { // сохрянить запись, даже если не перевели заголовок
                    $record['title'] = $title;
                }      
              } else {
                  $record['title'] = $title;
              }
            } else {
              $errors[] = 'Ошибка второго перевода заголовка. '.current($e);
              if ($this->feed['params']['nosave_if_not_translate']) {
                $record['title'] = '';
                $errors[] = 'Заголовок не был переведен во втором переводе! Включена опция не сохранять записи без перевода!';
              } 
            }
          }
        }
      }
      if (sizeof($errors)) {
        foreach ($errors as $e) {
          $this->_echo('<br /><i>'.$e.'</i>');
        }
      }
    }

    protected function _translate($text, $provider, $params, &$errors) {
      if ($provider !== '') {
        $method = '_translate'.$provider;
        if (method_exists($this, $method)) {
          return $this->$method($text, $params, $errors);
        }
      }
      $errors[] = 'Система перевода не найдена.';
      return false;
    }

    protected function _translateYandex($text, $params, &$errors) {
      if (empty($text)) {
        $errors[] = 'Нет данных для перевода';
      }
      if (empty($params['lang'])) {
        $errors[] = 'Не задан язык перевода';
      }
      if (empty($params['key'])) {
        $errors[] = 'Не задан API-ключ Yandex';
      }
      if (!sizeof($errors)) {
        $post_data['text'] = $text;
        $post_data['lang'] = $params['lang'];
        $post_data['format'] = 'html';
        $post_data['key'] = $params['key'];
        $query = http_build_query($post_data);
        $url = 'https://translate.yandex.net/api/v1.5/tr/translate';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $out = curl_exec($ch);
        $result = curl_getinfo($ch);
        curl_close($ch);
        if ($result['http_code'] == 200) {
          if (preg_match('|<Translation code="200" lang="'.$post_data['lang'].'"><text>(.*?)</text></Translation>|is', $out, $buff)) {
            if (!empty($buff[1])) {
              return html_entity_decode($buff[1], ENT_COMPAT, 'utf-8');
            } else {
                $errors[] = 'Перевод отсутсвует!';
            }    
          }
        } else {
            $errors[] = 'Ошибочный ответ сервер Яндекс.Перевод: ' . $result['http_code'];
        }
      }
      $errors[] = 'Сбой сервиса';
      return false;
    }

    // Не работает с длинными текстами

    // http://msdn.microsoft.com/en-us/library/ff512387.aspx
    // http://blogs.msdn.com/b/translation/p/phptranslator.aspx
    // http://blogs.msdn.com/b/translation/p/gettingstarted1.aspx
    // http://maarkus.ru/perevodchik-dlya-sajta-bing-translator-api/
    // https://code.google.com/p/micrsoft-translator-php-wrapper/
    // http://social.msdn.microsoft.com/Forums/en-US/b504dab2-75a9-4e5c-a7ea-27add00e32fe/how-to-post-large-data-using-http-interface-for-translate-method-in-microsoft-translate-api-v2?forum=microsofttranslator
    protected function _translateBing($text, $params, &$errors) {
      if (empty($text)) {
        $errors[] = 'Нет данных для перевода';
      }
      if (empty($params['from'])) {
        $errors[] = 'Не задан язык перевода';
      }
      if (empty($params['to'])) {
        $errors[] = 'Не задан язык перевода';
      }
      if (empty($params['key'])) {
        $errors[] = 'Не задан ключ АПИ';
      }
      if (!sizeof($errors)) {
        $url = 'https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Translate';
        $query['Text'] = "'".$text."'";
        $query['From'] = "'".$params['from']."'";
        $query['To'] = "'".$params['to']."'";
        $query['$format'] = 'Raw';
        $url .= '?'.http_build_query($query);
        $query = 'Text='."'".urlencode($text)."'";
        $headers = array(
          'Authorization: Basic '.base64_encode($params['key'].':'.$params['key'])
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $out = curl_exec($ch);
        $result = curl_getinfo($ch);
        curl_close($ch);
        if ($result['http_code'] == 200) {
          if (preg_match('|<string[^>]*?>(.*?)<\/string>|is', $out, $buff)) {
            if (!empty($buff[1])) {
              return html_entity_decode($buff[1], ENT_COMPAT, 'utf-8');
            }
          }
        }
      }
      $errors[] = 'Сбой сервиса';
      return false;
    }
}
