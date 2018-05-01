<?php
/**
@package WPGrabber
Plugin Name: WPGrabber Top-Bit Edition
Plugin URI: http://top-bit.ru
Description: WPGrabber Top-Bit Edition plugin
Version: 3.0 Top-Bit Edition (01.02.2016)
Author: Top-Bit
Author URI: http://top-bit.ru
*/
  if (defined('WPGRABBER_VERSION')) {
    die('На сайте активирован плагин WPGrabber версии '.WPGRABBER_VERSION.'. Пожалуйста, деактивируйте его перед активацией данного плагина.');
  }
  define('WPGRABBER_VERSION', '3.0 Top-Bit Edition');

  define('WPGRABBER_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
  define('WPGRABBER_PLUGIN_URL', plugin_dir_url( __FILE__ ));
  define('WPGRABBER_PLUGIN_FILE', __FILE__);

  require WPGRABBER_PLUGIN_DIR.'init.php';
?>