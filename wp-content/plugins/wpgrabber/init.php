<?php

  define('WPGRABBER_CORE_VERSION', '3.0.3');

  define('WPGRABBER_PLUGIN_INSTALL_DIR', WPGRABBER_PLUGIN_DIR.'install'.DIRECTORY_SEPARATOR);
  define('WPGRABBER_PLUGIN_CORE_DIR', WPGRABBER_PLUGIN_DIR.'core'.DIRECTORY_SEPARATOR);
  define('WPGRABBER_PLUGIN_LITE_DIR', WPGRABBER_PLUGIN_DIR.'core_lite'.DIRECTORY_SEPARATOR);
  define('WPGRABBER_PLUGIN_STANDARD_DIR', WPGRABBER_PLUGIN_DIR.'core_standard'.DIRECTORY_SEPARATOR);
  define('WPGRABBER_PLUGIN_PRO_DIR', WPGRABBER_PLUGIN_DIR.'core_pro'.DIRECTORY_SEPARATOR);
  define('WPGRABBER_PLUGIN_TPL_DIR', WPGRABBER_PLUGIN_DIR.'tmpl'.DIRECTORY_SEPARATOR);

  if (!session_id()) {
    session_start();
  }

  function wpgIsDemo() {
    return ($_SERVER['HTTP_HOST'] == 'demo.wpgrabber.ru');
  }

  function wpgIsDebug() {
    return is_file(WPGRABBER_PLUGIN_DIR.'debug');
  }

  if (wpgIsDebug()) {
    ini_set('display_errors', true);
    error_reporting(E_ALL ^ E_NOTICE);
  }

  function wpgIsPro() {
    if (defined('WPGRABBER_VERSION')) {
      $v = explode(' ', WPGRABBER_VERSION);
      return (isset($v[1]) and $v[1] == 'Professional');
    }
    return false;
  }

  function wpgIsStandard() {
    if (wpgIsPro()) {
      return true;
    }
    if (defined('WPGRABBER_VERSION')) {
      $v = explode(' ', WPGRABBER_VERSION);
      return (isset($v[1]) and $v[1] == 'Standard');
    }
    return false;
  }

  function wpgIsLite() {
    if (wpgIsStandard()) {
      return true;
    }
    if (defined('WPGRABBER_VERSION')) {
      $v = explode(' ', WPGRABBER_VERSION);
      return (isset($v[1]) and $v[1] == 'Lite');
    }
    return false;
  }

  function wpgPlugin() {
    if (wpgIsPro()) {
      return 'WPGPluginPro';
    } elseif (wpgIsStandard()) {
      return 'WPGPluginStandard';
    } elseif (wpgIsLite()) {
      return 'WPGPluginLite';
    } else {
      return 'WPGPlugin';
    }
  }

  require_once (WPGRABBER_PLUGIN_CORE_DIR.'WPGPlugin.php');
  require_once (WPGRABBER_PLUGIN_CORE_DIR.'WPGErrorHandler.php');
  require_once (WPGRABBER_PLUGIN_CORE_DIR.'WPGHelper.php');
  require_once (WPGRABBER_PLUGIN_CORE_DIR.'WPGTable.php');
  require_once (WPGRABBER_PLUGIN_CORE_DIR.'WPGTools.php');
  require_once (WPGRABBER_PLUGIN_CORE_DIR.'WPGWordPressDB.php');
  require_once (WPGRABBER_PLUGIN_CORE_DIR.'TGrabberCore.php');
  require_once (WPGRABBER_PLUGIN_CORE_DIR.'TGrabberWordPress.php');
  require_once (WPGRABBER_PLUGIN_CORE_DIR.'TGrabberWPOptions.php');
  if (wpgIsLite()) {
    require_once (WPGRABBER_PLUGIN_LITE_DIR.'WPGPluginLite.php');
    require_once (WPGRABBER_PLUGIN_LITE_DIR.'TGrabberCoreLite.php');
    require_once (WPGRABBER_PLUGIN_LITE_DIR.'TGrabberWordPressLite.php');
  }
  if (wpgIsStandard()) {
    require_once (WPGRABBER_PLUGIN_STANDARD_DIR.'WPGPluginStandard.php');
    require_once (WPGRABBER_PLUGIN_STANDARD_DIR.'TGrabberCoreStandard.php');
    require_once (WPGRABBER_PLUGIN_STANDARD_DIR.'TGrabberWordPressStandard.php');
  }
  if (wpgIsPro()) {
    require_once (WPGRABBER_PLUGIN_PRO_DIR.'WPGPluginPro.php');
    require_once (WPGRABBER_PLUGIN_PRO_DIR.'TGrabberCorePro.php');
    require_once (WPGRABBER_PLUGIN_PRO_DIR.'TGrabberWordPressPro.php');
  }
  call_user_func(array(wpgPlugin(), 'load'));
?>