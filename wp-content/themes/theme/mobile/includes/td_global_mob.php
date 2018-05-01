<?php
/**
 * Created by ra.
 * Date: 10/23/2015
 */

/**
 * the js files that the theme uses on the front end (file_id - filename) @see td_wp_booster_config
 * @see td_wp_booster_hooks
 * @var array
 */
static $js_files = array();

class td_global_mob {
	static $get_parent_template_directory = '';
	static $get_parent_template_directory_uri = '';
}

td_global_mob::$get_parent_template_directory = get_template_directory() . '..';
td_global_mob::$get_parent_template_directory_uri = td_mobile_theme::$main_uri_path;