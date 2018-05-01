<?php
/**
* WPGHelper
* 
* @version 1.1
* @author Top-Bit <info@top-bit.ru>
* @copyright 2009-2016 Top-Bit
* @link http://top-bit.ru
*/
  class WPGHelper {

    public static function yesNoRadioList($name, $selected, $atrr = null, $yes = 'Да', $no = 'Нет') {
      $out = '<input type="radio" name="'.WPGTools::esc($name).'" value="1"' . $atrr[0];
      if ($selected) {
        $out .= ' checked="checked"';
      }
      $out .= '>&nbsp;'.$yes;
      $out .= '&nbsp;&nbsp;<input type="radio" name="'.WPGTools::esc($name).'" value="0"' . $atrr[1];
      if (!$selected) {
        $out .= ' checked="checked"';
      }
      $out .= '>&nbsp;'.$no;
      return $out;
    }

    public static function selectList() {
      list($name, $values, $select, $assoc, $properties) = func_get_args();
      if (empty($values)) {
        return null;
      }
      $out = '<select name="'.WPGTools::esc($name).'"';
      if (trim($properties) != '') {
        $out .= ' '.$properties.'>';
      } else {
        $out .= '>';
      }
      if (!is_array($values)) {
        $values = explode(',', (string)$values);
      }
      if (!is_array($select)) {
        $select = !empty($select) ? explode(',', $select) : array();
      }
      foreach ($values as $key => $val) {
        if ($assoc) {
          $value = $key;
          $option = $val;
        } else {
          $value = $val;
          $option = $val;
        }
        if (in_array($value, $select)) {
          $out .= '<option value="'.WPGTools::esc($value).'" selected="selected">'.WPGTools::esc($option).'</option>';
        } else {
          $out .= '<option value="'.WPGTools::esc($value).'">'.WPGTools::esc($option).'</option>';
        }
      }
      $out .= '</select>';
      return $out;
    }

    public static function charsetList() {
      return array('исходная', 'WINDOWS-1251', 'UTF-8', 'KOI8-R', 'ISO-8859-1');
    }

    public static function getAuthors($id = false) {
      global $wpdb;
      static $buff;
      if (!isset($buff)) {
        $rows = $wpdb->get_results("SELECT id, user_login, user_nicename FROM $wpdb->users", 'ARRAY_A');
        if (count($rows)) {
          foreach ($rows as $row) {
            $buff[$row['id']] = $row['user_login'] . ' (' . $row['user_nicename'] . ')';
          }
        }
      }
      if ($id === false) {
        return $buff;
      } else {
        $id = intval($id);
        return isset($buff[$id]) ? $buff[$id] : null;
      }
    }

    public static function getPostTypes() {
      static $out;
      if (!isset($out)) {
        $types = get_post_types($args, $output);
        foreach ($types as $key => $type) {
          $out[$key] = $type->labels->singular_name;
        }
      }
      return $out;
    }

    public static function getCategoriesList($name, $values) {
      if (!is_array($values)) {
        $values = ($values !== '') ? (array)$values : array();
      }
      $categories = get_categories(array('get' => 'all'));
      $list = array();
      foreach ($categories as $c) {
        $list[$c->category_parent][] = $c;
      }
      $out = '';
      if (!empty($list[0])) {
        $out .= '<div class="categorydiv"><div class="tabs-panel">';
        $out .= self::_recursiveGetCategoriesListLevel($list[0], $list, $name, $values);
        $out .= '</div></div>';
      }
      return $out;
    }

    protected static function _recursiveGetCategoriesListLevel($list, &$all_items, &$name, &$values, $level = 0) {
      $out = '<ul class="'.($level == 0 ? 'categorychecklist' : 'children').'">';
      foreach ($list as $c) {
        $out .= '<li>';
        $out .= '<label class="selectit">';
        $out .= '<input value="'.(int)$c->cat_ID.'" name="'.WPGTools::esc($name).'[]" type="checkbox"'.(in_array($c->cat_ID, $values) ? ' checked="checked"' : '').' /> '.WPGTools::esc($c->cat_name);
        $out .= '</label>';
        if (isset($c->cat_ID) and $c->cat_ID !== '' and !empty($all_items[$c->cat_ID])) {
          $level++;
          $out .= self::_recursiveGetCategoriesListLevel($all_items[$c->cat_ID], $all_items, $name, $values, $level);
        }
        $out .= '</li>';
      }
      $out .= '</ul>';
      return $out;
    }

    public static function getListPostStatus() {
      return array('publish' => 'Опубликовано', 'draft' => 'Черновик');
    }

    public static function translateProvidersList() {
      $list[0] = 'API Яндекс.Перевода';
      //$list[1] = 'API Bing Переводчика';
      return $list;
    }

    public static function translateLangsList($provider) {
      $langs = array(
        // API Яндекс.Перевода
        0 => array(
          'en' => 'английский',
          'be' => 'белорусский',
          'bg' => 'болгарский',
          'nl' => 'голландский',
          'da' => 'датский',
          'es' => 'испанский',
          'it' => 'итальянский',
          'de' => 'немецкий',
          'pl' => 'польский',
          'pt' => 'португальский',
          'ro' => 'румынский',
          'ru' => 'русский',
          'sr' => 'сербский',
          'tr' => 'турецкий',
          'uk' => 'украинский',
          'fr' => 'французский',
          'hr' => 'хорватский',
          'cs' => 'чешский',
          'sv' => 'шведский',
        ),
        //API Bing Переводчика
        1 => array(
          'en' => 'английский',
          'ar' => 'арабский',
          'bg' => 'болгарский',
          'cy' => 'валлийский',
          'hu' => 'венгерский',
          'vi' => 'вьетнамский',
          'ht' => 'гаитянский креольский',
          'nl' => 'голландский',
          'el' => 'греческий',
          'da' => 'датский',
          'he' => 'иврит',
          'id' => 'индонезийский',
          'es' => 'испанский',
          'it' => 'итальянский',
          'ca' => 'каталанский',
          'zh_cht' => 'китайский традиционный',
          'zh_chs' => 'китайский упрощенный',
          'tlh' => 'клингонский',
          'tlh_qaak' => 'клингонский (piqad)',
          'ko' => 'корейский',
          'lv' => 'латышский',
          'lt' => 'литовский',
          'ms' => 'малайский',
          'mt' => 'мальтийский',
          'de' => 'немецкий',
          'no' => 'норвежский',
          'fa' => 'персидский',
          'pl' => 'польский',
          'pt' => 'португальский',
          'ro' => 'румынский',
          'ru' => 'русский',
          'sk' => 'словацкий',
          'sl' => 'словенский',
          'th' => 'тайский',
          'tr' => 'турецкий',
          'uk' => 'украинский',
          'ur' => 'урду',
          'fi' => 'финский',
          'fr' => 'французский',
          'hi' => 'хинди',
          'mww' => 'хмонг дау',
          'cs' => 'чешский',
          'sv' => 'шведский',
          'et' => 'эстонский',
          'ja' => 'японский',
        ),
      );
      $provider = intval($provider);
      
      if ($provider==0) { // Яндекс.Перевод
          $list = json_decode(get_option("wpg_yandexTransLangs"), true);
      } else {
          $list = array();
          if (!empty($langs[$provider])) {
            foreach ($langs[$provider] as $lform => $dfrom) {
              foreach ($langs[$provider] as $lto => $dto) {
                if ($lform != $lto) {
                  $list[$lform.'-'.$lto] = $dfrom.' > '.$dto;
                }
              }
            }
          }
      }
      if (empty($list)) {
        $list[0] = 'не задано';
      } else {
        $first = array();
        if (isset($list['en-ru'])) {
          $first['en-ru'] = $list['en-ru'];
          unset($list['en-ru']);
        }
        if (isset($list['ru-en'])) {
          $first['ru-en'] = $list['ru-en'];
          unset($list['ru-en']);
        }
        $list = array_merge($first, $list);
      }
      return $list;
    }

    // Вынести в Tools
    function escape($value) {
      if (is_array($value) and count($value)) {
        foreach ($value as $k => $v) {
          $value[$k] = mysql_real_escape_string($v);
        }
      } else {
        $value = mysql_real_escape_string($value);
      }
      return $value;
    }

    function strips($value) {
      if (is_array($value) and count($value)) {
        foreach ($value as $k => $v) {
          if (is_array($v)) {
            $value[$k] = self::strips($v);
          } else {
            $value[$k] = stripslashes($v);
          }
        }
      } else {
        $value = stripslashes($value);
      }
      return $value;
    }
  }
