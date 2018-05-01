<?php

  class WPGTools {

    public static function getValue($key, $default = '') {
      if(isset($_POST[$key])) {
        return $_POST[$key];
      } elseif (isset($_GET[$key])) {
        return $_GET[$key];
      } else {
        return $default;
      }
    }

    public static function isSubmit($key) {
      if (isset($_POST[$key]) or isset($_GET[$key])) {
        return true;
      }
      return false;
    }

    public static function redirect($url, $code = null) {
      if ($code) {
        header('Location: '.$url, true, $code);
        exit();
      }
      header('Location: '.$url);
      exit();
    }

    public static function addSuccess($text) {

    }

    public static function addError($text) {

    }

    public static function addLog($text) {

    }

    public static function esc($text) {
      return htmlentities($text, ENT_COMPAT, 'utf-8');
    }

  }
