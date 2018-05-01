<?php
class tdx_api_plugin {

    private static $plugins_list = array();

    public static function add($plugin_instance) {
        self::$plugins_list[get_class($plugin_instance)]['instance'] = $plugin_instance;
    }
}