<?php
/*
Plugin Name: Automatic Post Tagger
Plugin URI: https://wordpress.org/plugins/automatic-post-tagger/
Description: Adds relevant taxonomy terms to posts using a keyword list provided by the user.
Version: 1.8.2
Author: Devtard
Author URI: http://devtard.com
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/*
Copyright (C) 2012-2015  Devtard (gmail.com ID: devtard)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

defined('ABSPATH') or exit; //prevents direct access to the file

## =========================================================================
## ### GLOBAL VARIABLES
## =========================================================================

global $wpdb, $pagenow, $apt_default_settings_array, $apt_default_keyword_sets_array, $apt_default_groups_array; //variables used in the activation and uninstall function have to be declared as global (http://codex.wordpress.org/Function_Reference/register_activation_hook#A_Note_on_Variable_Scope); $pagenow is loaded because of the publish_post/save_post/wp_insert_post hooks

//$wpdb->show_errors(); //for debugging

$apt_settings = get_option('automatic_post_tagger');
$apt_plugin_url = WP_PLUGIN_URL . "/" . basename(dirname(__FILE__)) . "/";
$apt_plugin_dir = WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/";
$apt_plugin_basename = plugin_basename(__FILE__); //automatic-post-tagger/automatic-post-tagger.php

$apt_backup_file_name_prefix_plugin_settings = 'apt-plugin-settings';
$apt_backup_file_name_prefix_keyword_sets = 'apt-keyword-sets';
$apt_backup_file_name_prefix_configuration_groups = 'apt-configuration-groups';
$apt_backup_file_name_json_suffix = '.json';
$apt_backup_file_name_csv_suffix = '.csv';
$apt_backup_dir_rel_path = $apt_plugin_dir .'backup/'; //relative path
$apt_backup_dir_abs_path = $apt_plugin_url .'backup/'; //absolute path

$apt_message_html_prefix_updated = '<div id="message" class="updated"><p>';
$apt_message_html_prefix_error = '<div id="message" class="error"><p>';
$apt_message_html_prefix_warning = '<div id="message" class="updated warning"><p>';
$apt_message_html_prefix_note = '<div id="message" class="updated note"><p>';
$apt_message_html_suffix = '</p></div>';
$apt_invalid_nonce_message = $apt_message_html_prefix_error .'<strong>Error:</strong> Sorry, your nonce did not verify, your request couldn\'t be executed. Please try again.'. $apt_message_html_suffix;
$apt_max_input_vars_value = @ini_get('max_input_vars');

$apt_default_settings_array = array(
	'apt_plugin_version' => apt_get_plugin_version(),
	'apt_admin_notice_install' => '1',
	'apt_admin_notice_update' => '0',
	'apt_hidden_widgets' => array(),
	'apt_configuration_groups_total' => '1',
	'apt_highest_configuration_group_id' => '1', //since a default group is automatically created, the ID has to be 1
	'apt_keyword_sets_total' => '0',
	'apt_highest_keyword_set_id' => '0',
	'apt_title' => '1',
	'apt_content' => '1',
	'apt_excerpt' => '0',
	'apt_search_for_term_name' => '1',
	'apt_search_for_related_keywords' => '1',
	'apt_taxonomy_term_limit' => '25',
	'apt_run_apt_publish_post' => '1',
	'apt_run_apt_save_post' => '0',
	'apt_run_apt_wp_insert_post' => '1',
	'apt_old_terms_handling' => '1',
	'apt_old_terms_handling_2_remove_old_terms' => '0',
	'apt_word_separators' => array('.','&#44;',' ','?','!',':',';','\'','"','\\','|','/','(',')','[',']','{','}','_','+','=','-','<','>','~','@','#','$','%','^','&','*'),
	'apt_ignore_case' => '1',
	'apt_decode_html_entities_word_separators' => '1',
	'apt_decode_html_entities_analyzed_content' => '0',
	'apt_decode_html_entities_related_keywords' => '0',
	'apt_strip_tags' => '1',
	'apt_replace_whitespaces' => '1',
	'apt_replace_nonalphanumeric' => '0',
	'apt_dont_replace_wildcards' => '1',
	'apt_substring_analysis' => '0',
	'apt_substring_analysis_length' => '1000',
	'apt_substring_analysis_start' => '0',
	'apt_wildcards' => '1',
	'apt_post_types' => array('post'),
	'apt_post_statuses' => array('publish'),
	'apt_taxonomies' => array('post_tag'),
	'apt_wildcard_character' => '*',
	'apt_string_separator' => ',',
	'apt_input_correction' => '1',
	'apt_export_plugin_data_before_update' => '1',
	'apt_export_plugin_data_after_update' => '1',
	'apt_backup_limit' => '30',
	'apt_wildcard_regex' => '(.*)',
	'apt_item_editor_mode' => '1',
	'apt_hide_warning_messages' => '0',
	'apt_hide_update_messages' => '0',
	'apt_default_group' => '1',
	'apt_nonexistent_groups_handling' => '1',
	'apt_bulk_tagging_posts_per_batch' => '15',
	'apt_bulk_tagging_delay' => '3',
	'apt_bulk_tagging_queue' => array(),
	'apt_bulk_tagging_event_recurrence' => '24',
	'apt_bulk_tagging_event_unscheduling' => '1',
	'apt_bulk_tagging_range_lower_bound' => '2',
	'apt_bulk_tagging_range_upper_bound' => '1',
	'apt_bulk_tagging_range_custom_lower_bound' => '0',
	'apt_bulk_tagging_range_custom_upper_bound' => '0',
	'apt_bulk_tagging_range_custom_lower_bound_update' => '1',
	'apt_bulk_tagging_range' => array()
);
$apt_default_keyword_sets_array = array();
$apt_default_groups_array = array(array('1', 'Default group', '0', '1', '25', array('post_tag')));

## =========================================================================
## ### HOOKS
## =========================================================================

### install and uninstall hooks
register_activation_hook(__FILE__, 'apt_install_plugin_data');
register_deactivation_hook(__FILE__, 'apt_unschedule_bulk_tagging_event');
register_uninstall_hook(__FILE__, 'apt_uninstall_plugin_data');

/**
 * Various actions and filters
 */
function apt_admin_init_actions(){
	global $pagenow,
	$apt_plugin_basename;

	if($pagenow == 'plugins.php'){
		add_filter('plugin_action_links_'. $apt_plugin_basename, 'apt_plugin_action_links', 10, 1);
		add_filter('plugin_row_meta', 'apt_plugin_meta_links', 10, 2);
	}
	if($pagenow == 'options-general.php' and isset($_GET['page']) and $_GET['page'] == 'automatic-post-tagger'){
		add_action('admin_print_scripts', 'apt_insert_ajax_nonce_options_page');
		add_action('admin_enqueue_scripts', 'apt_load_options_page_scripts');
	}
	if(in_array($pagenow, array('post.php', 'post-new.php'))){
		add_action('admin_print_scripts', 'apt_insert_ajax_nonce_meta_box');
		add_action('admin_enqueue_scripts', 'apt_load_meta_box_scripts');
		add_action('add_meta_boxes', 'apt_meta_box_add');
	}
}

if(is_admin()){ //only if the admin panel is being displayed
	add_action('admin_menu', 'apt_menu_link');
	add_action('admin_notices', 'apt_plugin_admin_notices', 20);
	add_action('admin_init', 'apt_admin_init_actions');
	add_action('wp_ajax_apt_meta_box_create_new_keyword_set', 'apt_meta_box_create_new_keyword_set');
	add_action('wp_ajax_apt_set_widget_visibility', 'apt_set_widget_visibility');

	if(isset($pagenow)){
		if(in_array($pagenow, array('plugins.php', 'update-core.php', 'update.php')) or ($pagenow == 'options-general.php' and isset($_GET['page']) and $_GET['page'] == 'automatic-post-tagger')){ //the options page, or update-core.php or plugins.php or update.php are being displayed
			add_action('plugins_loaded', 'apt_update_plugin');
		}
	}
	else{
		add_action('plugins_loaded', 'apt_update_plugin'); //load the update function anyway
	}
} //-is_admin

### when the tagging function should be executed
if(@$apt_settings['apt_run_apt_publish_post'] == 1 and isset($pagenow) and in_array($pagenow, array('post.php', 'post-new.php')) and @$apt_settings['apt_run_apt_save_post'] != 1){ //this hook IS fired when the post editor is displayed; the function is triggered only once (if tagging posts is allowed when posts are being saved)
	add_action('publish_post','apt_single_post_tagging'); //executes the tagging function when publishing posts
}
if(@$apt_settings['apt_run_apt_wp_insert_post'] == 1 and isset($pagenow) and !in_array($pagenow, array('post.php', 'post-new.php', 'edit.php'))){ //this hook IS NOT fired when the post editor is displayed (this would result in posts saved via the post editor always being processed by APT)
	add_action('wp_insert_post','apt_single_post_tagging'); //executes the tagging function when importing posts
}
if(@$apt_settings['apt_run_apt_save_post'] == 1 and isset($pagenow) and in_array($pagenow, array('post.php', 'post-new.php')) and ((isset($_GET['action']) and $_GET['action'] != 'trash') or !isset($_GET['action']))){ //this hook IS fired when the post editor is being displayed and the post is not being trashed
	add_action('save_post','apt_single_post_tagging'); //executes the tagging function when saving posts
}

### scheduled events
add_action('apt_bulk_tagging_event', 'apt_scheduled_bulk_tagging');
add_action('apt_bulk_tagging_event_single_batch', 'apt_scheduled_bulk_tagging');

## ===================================
## ### GET PLUGIN VERSION
## ===================================

/**
 * Returns the plugin version
 * @return	string
 */
function apt_get_plugin_version(){
	if(!function_exists('get_plugin_data')){
		require_once(ABSPATH .'wp-admin/includes/plugin.php');
	}

	$apt_plugin_data = get_plugin_data( __FILE__, false, false);
	$apt_plugin_version = $apt_plugin_data['Version'];
	return $apt_plugin_version;
}

## ===================================
## ### INSTALL FUNCTION
## ===================================

/**
 * Creates default plugin data. Runs after the activation of the plugin; also used for restoring default data and fixing corrupted data
 */
function apt_install_plugin_data(){
	$apt_settings = get_option('automatic_post_tagger');
	$apt_kw_sets = get_option('automatic_post_tagger_keywords');
	$apt_groups = get_option('automatic_post_tagger_groups');

	if($apt_settings === false){
		global $apt_default_settings_array;
		add_option('automatic_post_tagger', $apt_default_settings_array, '', 'no');
	}
	elseif(empty($apt_settings)){
		global $apt_default_settings_array;
		update_option('automatic_post_tagger', $apt_default_settings_array);
		$apt_settings = $apt_default_settings_array; //recreate the settings variable

		//update item highest ID + count
		apt_set_plugin_settings_information(1, 1);
		apt_set_plugin_settings_information(1, 2);
		apt_set_plugin_settings_information(2, 1);
		apt_set_plugin_settings_information(2, 2);
		apt_set_plugin_settings_information(3, apt_get_group_info($apt_default_settings_array['apt_default_group'], 2)); //select the new default group (this is here to suppress the "the previously used default group no longer exists" note, which is BS when importing plugin settings)
	}

	if($apt_kw_sets === false){
		global $apt_default_keyword_sets_array;
		add_option('automatic_post_tagger_keywords', $apt_default_keyword_sets_array, '', 'no');
	}
	elseif(empty($apt_kw_sets) and !is_array($apt_kw_sets)){ //the !is_array condition is required here, since the keyword sets option can be an empty array
		global $apt_default_keyword_sets_array;
		update_option('automatic_post_tagger_keywords', $apt_default_keyword_sets_array);

		//update item highest ID + count, keyword set count
		apt_set_plugin_settings_information(1, 1);
		apt_set_plugin_settings_information(1, 2);
		apt_set_group_keyword_set_count(0, 3);
	}

	if($apt_groups === false){
		global $apt_default_groups_array;
		add_option('automatic_post_tagger_groups', $apt_default_groups_array, '', 'no');
	}
	elseif(empty($apt_groups)){
		global $apt_default_groups_array;
		update_option('automatic_post_tagger_groups', $apt_default_groups_array);

		//update item highest ID + count, keyword set count, reset groups in keyword sets
		apt_set_plugin_settings_information(2, 1);
		apt_set_plugin_settings_information(2, 2);
		apt_set_plugin_settings_information(3);
		apt_nonexistent_groups_handling();
		apt_set_group_keyword_set_count(0, 3);
	}
}

## ===================================
## ### UPDATE FUNCTIONS
## ===================================

/**
 * Updates the satabase structure every time a new version is available
 */
function apt_update_plugin(){ //update function - runs when all plugins are loaded
	$apt_settings = get_option('automatic_post_tagger');

	if(current_user_can('manage_options')){
		$apt_current_version = apt_get_plugin_version();

		//if the user uses a very old version, we have to include all DB changes that are included in the following version checks; we must not forget to include new changes in conditions for all previous versions - versions are always being updated to the newest DB structure

		#### now comes everything that must be changed in the new version
		if(isset($apt_settings['apt_plugin_version'])){ //if the variable exists (since v1.5)
			if($apt_settings['apt_plugin_version'] != $apt_current_version){ //check whether the saved version isn't equal to the current version
				########################################################
				### creates automatic backups before updating; aborts the update if exports fail
				$apt_backup_error = 0;

				if(version_compare($apt_settings['apt_plugin_version'], '1.8', '>=')){ //v1.8 and newer
					if($apt_settings['apt_export_plugin_data_before_update'] == 1){ //only if backups before updating are enabled
						//export settings to JSON
						if(apt_export_plugin_data(1, 1, 0) === false){
							$apt_backup_error = 1;
						}
						//export keyword sets to JSON
						if(apt_export_plugin_data(2, 1, 0) === false and $apt_settings['apt_keyword_sets_total'] != 0){
							$apt_backup_error = 1;
						}
						//export groups to JSON
						if(apt_export_plugin_data(3, 1, 0) === false){
							$apt_backup_error = 1;
						}
					} //-if backups enabled
				} //-if v1.8 and newer
				elseif(version_compare($apt_settings['apt_plugin_version'], '1.8', '<') and version_compare($apt_settings['apt_plugin_version'], '1.5', '>=')){ //v1.5 to v1.8 (not included)
					//we need to provide the option name and backup limit, because the older versions have different (sub)option names
					if(apt_export_plugin_data(1, 1, 0, 'automatic_post_tagger', $apt_settings['apt_stored_backups']) === false){
						$apt_backup_error = 1;
					}
					if(apt_export_plugin_data(2, 1, 0, 'automatic_post_tagger_keywords', $apt_settings['apt_stored_backups']) === false){
						$apt_backup_error = 1;
					}
				} //-elseif v1.5 to v1.7

				### update failure override
				if(isset($_GET['update-failure-override']) and $_GET['update-failure-override'] == 1){
					if(check_admin_referer('apt_update_failure_override_nonce')){
						$apt_backup_error = 0; //ensures that the update failure error won't be displayed again
					} //-nonce check
				}

				if($apt_backup_error == 1){
					global $apt_message_html_prefix_error, $apt_message_html_suffix;
					echo $apt_message_html_prefix_error .'<strong>Error:</strong> Automatic Post Tagger was unable back up its data; the update process has been aborted. Just to make sure that you don\'t lose any data during the update, please create your own backup before continuing. <a href="'. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&update-failure-override=1'), 'apt_update_failure_override_nonce') .'">Resume the update to v'. apt_get_plugin_version() .' &raquo;</a>'. $apt_message_html_suffix;
					return;
				}
				########################################################

				### update from 1.5 to the newest version
				if($apt_settings['apt_plugin_version'] == '1.5' or $apt_settings['apt_plugin_version'] == '1.5.1'){ //update from 1.5 to the newest version
					### copy values of old suboptions to new suboptions
					$apt_settings['apt_dont_replace_wildcards'] = $apt_settings['apt_ignore_wildcards'];

					$apt_settings['apt_taxonomy_term_limit'] = $apt_settings['apt_tag_limit'];
					$apt_settings['apt_backup_limit'] = $apt_settings['apt_stored_backups'];
					$apt_settings['apt_old_terms_handling'] = $apt_settings['apt_handling_current_tags'];
					$apt_settings['apt_keyword_sets_total'] = $apt_settings['apt_stats_current_tags'];
					$apt_settings['apt_highest_keyword_set_id'] = $apt_settings['apt_last_keyword_id'];
					$apt_settings['apt_search_for_term_name'] = $apt_settings['apt_search_for_keyword_names'];
					$apt_settings['apt_bulk_tagging_posts_per_batch'] = $apt_settings['apt_bulk_tagging_posts_per_cycle'];

					### new suboptions
					$apt_settings['apt_run_apt_wp_insert_post'] = '1';
					$apt_settings['apt_configuration_groups_total'] = '1';
					$apt_settings['apt_highest_configuration_group_id'] = '1';
					$apt_settings['apt_default_group'] = '1';
					$apt_settings['apt_nonexistent_groups_handling'] = '1';
					$apt_settings['apt_taxonomies'] = array('post_tag');
					$apt_settings['apt_old_terms_handling_2_remove_old_terms'] = '0';
					$apt_settings['apt_hide_update_messages'] = '0';
					$apt_settings['apt_export_plugin_data_before_update'] = '1';
					$apt_settings['apt_export_plugin_data_after_update'] = '1';

					$apt_settings['apt_bulk_tagging_event_unscheduling'] = '1';
					$apt_settings['apt_bulk_tagging_event_recurrence'] = '24';
					$apt_settings['apt_bulk_tagging_range_lower_bound'] = '2';
					$apt_settings['apt_bulk_tagging_range_upper_bound'] = '1';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_upper_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] = '1';
					$apt_settings['apt_bulk_tagging_range'] = array();

					if($apt_settings['apt_warning_messages'] == 1){ 
						$apt_settings['apt_hide_warning_messages'] = '0';
					}
					else{
						$apt_settings['apt_hide_warning_messages'] = '1';
					}

					if($apt_settings['apt_tagging_hook_type'] == 1){ 
						$apt_settings['apt_run_apt_publish_post'] = '1';
						$apt_settings['apt_run_apt_save_post'] = '0';
					}
					else{ //trigger tagging when saving the post
						$apt_settings['apt_run_apt_save_post'] = '1';
						$apt_settings['apt_run_apt_publish_post'] = '0';
					}

					$apt_settings['apt_post_types'] = array('post');
					$apt_settings['apt_taxonomies'] = array('post_tag');
					$apt_settings['apt_post_statuses'] = array('publish');
					$apt_settings['apt_search_for_term_name'] = '1';
					$apt_settings['apt_search_for_related_keywords'] = '1';
					$apt_settings['apt_input_correction'] = '1';
					$apt_settings['apt_export_plugin_data_after_update'] = '1';
					$apt_settings['apt_wildcard_regex'] = '(.*)';
					$apt_settings['apt_item_editor_mode'] = '1';
					$apt_settings['apt_highest_keyword_set_id'] = '0';
					$apt_settings['apt_bulk_tagging_delay'] = '1';
					$apt_settings['apt_decode_html_entities_word_separators'] = '1';
					$apt_settings['apt_decode_html_entities_analyzed_content'] = '0';
					$apt_settings['apt_decode_html_entities_related_keywords'] = '0';

					### reset values/change variables to arrays
					$apt_settings['apt_word_separators'] = array('.','&#44;',' ','?','!',':',';','\'','"','\\','|','/','(',')','[',']','{','}','_','+','=','-','<','>','~','@','#','$','%','^','&','*');
					$apt_settings['apt_hidden_widgets'] = array();
					$apt_settings['apt_bulk_tagging_queue'] = array();

					### new options
					if(get_option('automatic_post_tagger_groups') === false){ //create the option only if it doesn't exist yet
						add_option('automatic_post_tagger_groups', array(array('1', 'Default group', $apt_settings['apt_keywords_total'], '1', $apt_settings['apt_taxonomy_term_limit'], $apt_settings['apt_taxonomies'])), '', 'no'); //default values: id, name, number of keywords, status, term limit, taxonomy
					}

					### removing suboptions
					unset($apt_settings['apt_admin_notice_prompt']);
					unset($apt_settings['apt_stats_install_date']);
					unset($apt_settings['apt_stats_current_tags']);
					unset($apt_settings['apt_convert_diacritic']);
					unset($apt_settings['apt_ignore_wildcards']);
					unset($apt_settings['apt_wildcards_alphanumeric_only']);
					unset($apt_settings['apt_tagging_hook_type']);
					unset($apt_settings['apt_tag_limit']);
					unset($apt_settings['apt_stored_backups']);
					unset($apt_settings['apt_handling_current_tags']);
					unset($apt_settings['apt_warning_messages']);
					unset($apt_settings['apt_bulk_tagging_statuses']);
					unset($apt_settings['apt_keywords_total']);
					unset($apt_settings['apt_last_keyword_id']);
					unset($apt_settings['apt_bulk_tagging_posts_per_cycle']);

					update_option('automatic_post_tagger', $apt_settings); //save settings because of the following function apt_move_keyword_sets_from_table_to_option();
					apt_move_keyword_sets_from_table_to_option();
				} //update from 1.5 and 1.5.1

				### update from 1.6 to the newest version
				if($apt_settings['apt_plugin_version'] == '1.6'){
					### change the keyword structure - assign the default category + turn rel. words into arrays
					$apt_kw_sets = get_option('automatic_post_tagger_keywords');
					$apt_kw_sets_new = array();

					foreach($apt_kw_sets as $apt_keyword_set){
						//adding the old ID, name and related keywords turned into an array, with the group ID, to the new keyword array
						if($apt_keyword_set[2] == ''){
							$apt_keyword_set_new = array($apt_keyword_set[0], $apt_keyword_set[1], array(), '1');
						}
						else{
							$apt_keyword_set_new = array($apt_keyword_set[0], $apt_keyword_set[1], explode($apt_settings['apt_string_separator'], $apt_keyword_set[2]), '1');
						}

						array_push($apt_kw_sets_new, $apt_keyword_set_new);
						unset($apt_keyword_set_new);
					}

					update_option('automatic_post_tagger_keywords', $apt_kw_sets_new);

					### new options
					if(get_option('automatic_post_tagger_groups') === false){ //create the option only if it doesn't exist yet
						add_option('automatic_post_tagger_groups', array(array('1', 'Default group', $apt_settings['apt_keywords_total'], '1', $apt_settings['apt_tag_limit'], array($apt_settings['apt_taxonomy_name']))), '', 'no'); //default values: id, name, number of keyword sets, status, term limit, taxonomy
					}

					### new suboptions
					$apt_settings['apt_configuration_groups_total'] = '1';
					$apt_settings['apt_highest_configuration_group_id'] = '1'; //since a default group is automatically created, the ID has to be 1
					$apt_settings['apt_default_group'] = '1';
					$apt_settings['apt_nonexistent_groups_handling'] = '1';
					$apt_settings['apt_hide_update_messages'] = '0';
					$apt_settings['apt_export_plugin_data_before_update'] = '1';

					if($apt_settings['apt_warning_messages'] == 1){ 
						$apt_settings['apt_hide_warning_messages'] = '0';
					}
					else{
						$apt_settings['apt_hide_warning_messages'] = '1';
					}

					$apt_settings['apt_run_apt_wp_insert_post'] = '1';
					$apt_settings['apt_bulk_tagging_delay'] = '1';
					$apt_settings['apt_post_statuses'] = array('publish');
					$apt_settings['apt_decode_html_entities_word_separators'] = '1';
					$apt_settings['apt_decode_html_entities_analyzed_content'] = '0';
					$apt_settings['apt_decode_html_entities_related_keywords'] = '0';

					$apt_settings['apt_bulk_tagging_event_unscheduling'] = '1';
					$apt_settings['apt_bulk_tagging_event_recurrence'] = '24';
					$apt_settings['apt_bulk_tagging_range_lower_bound'] = '2';
					$apt_settings['apt_bulk_tagging_range_upper_bound'] = '1';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_upper_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] = '1';
					$apt_settings['apt_bulk_tagging_range'] = array();

					### copy values of old suboptions to new suboptions
					$apt_settings['apt_taxonomies'] = array($apt_settings['apt_taxonomy_name']);
					$apt_settings['apt_taxonomy_term_limit'] = $apt_settings['apt_tag_limit'];
					$apt_settings['apt_backup_limit'] = $apt_settings['apt_stored_backups'];
					$apt_settings['apt_old_terms_handling'] = $apt_settings['apt_handling_current_tags'];
					$apt_settings['apt_old_terms_handling_2_remove_old_terms'] = $apt_settings['apt_handling_current_tags_2_remove_old_tags'];
					$apt_settings['apt_item_editor_mode'] = $apt_settings['apt_keyword_management_mode'];
					$apt_settings['apt_export_plugin_data_after_update'] = $apt_settings['apt_create_backup_when_updating'];
					$apt_settings['apt_keyword_sets_total'] = $apt_settings['apt_keywords_total'];
					$apt_settings['apt_highest_keyword_set_id'] = $apt_settings['apt_last_keyword_id'];
					$apt_settings['apt_search_for_term_name'] = $apt_settings['apt_search_for_keyword_names'];
					$apt_settings['apt_search_for_related_keywords'] = $apt_settings['apt_search_for_related_words'];
					$apt_settings['apt_bulk_tagging_posts_per_batch'] = $apt_settings['apt_bulk_tagging_posts_per_cycle'];

					if($apt_settings['apt_tagging_hook_type'] == 1){ 
						$apt_settings['apt_run_apt_publish_post'] = '1';
						$apt_settings['apt_run_apt_save_post'] = '0';
					}
					else{ //trigger tagging when saving the post
						$apt_settings['apt_run_apt_save_post'] = '1';
						$apt_settings['apt_run_apt_publish_post'] = '0';
					}

					### removing suboptions
					unset($apt_settings['apt_tagging_hook_type']);
					unset($apt_settings['apt_bulk_tagging_statuses']);
					unset($apt_settings['apt_handling_current_tags']);
					unset($apt_settings['apt_handling_current_tags_2_remove_old_tags']);
					unset($apt_settings['apt_keyword_management_mode']);
					unset($apt_settings['apt_warning_messages']);
					unset($apt_settings['apt_create_backup_when_updating']);
					unset($apt_settings['apt_taxonomy_name']);
					unset($apt_settings['apt_tag_limit']);
					unset($apt_settings['apt_stored_backups']);
					unset($apt_settings['apt_keywords_total']);
					unset($apt_settings['apt_last_keyword_id']);
					unset($apt_settings['apt_search_for_keyword_names']);
					unset($apt_settings['apt_search_for_related_words']);
					unset($apt_settings['apt_bulk_tagging_posts_per_cycle']);
				}

				### update from 1.7 to the newest version
				if($apt_settings['apt_plugin_version'] == '1.7'){
					### change the keyword set structure - assign the default category + turn related keywords into arrays
					$apt_kw_sets = get_option('automatic_post_tagger_keywords');
					$apt_kw_sets_new = array();

					foreach($apt_kw_sets as $apt_keyword_set){
						//adding the old ID, name and related keywords turned into an array, with the group ID, to the new keyword array
						if($apt_keyword_set[2] == ''){
							$apt_keyword_set_new = array($apt_keyword_set[0], $apt_keyword_set[1], array(), '1');
						}
						else{
							$apt_keyword_set_new = array($apt_keyword_set[0], $apt_keyword_set[1], explode($apt_settings['apt_string_separator'], $apt_keyword_set[2]), '1');
						}

						array_push($apt_kw_sets_new, $apt_keyword_set_new);
						unset($apt_keyword_set_new);
					}

					update_option('automatic_post_tagger_keywords', $apt_kw_sets_new);

					### new options
					if(get_option('automatic_post_tagger_groups') === false){ //create the option only if it doesn't exist yet
						add_option('automatic_post_tagger_groups', array(array('1', 'Default group', $apt_settings['apt_keywords_total'], '1', $apt_settings['apt_tag_limit'], array($apt_settings['apt_taxonomy_name']))), '', 'no'); //default values: id, name, number of keywords, status, term limit, taxonomy
					}

					### new suboptions
					$apt_settings['apt_configuration_groups_total'] = '1';
					$apt_settings['apt_highest_configuration_group_id'] = '1'; //since a default group is automatically created, the ID has to be 1
					$apt_settings['apt_default_group'] = '1';
					$apt_settings['apt_nonexistent_groups_handling'] = '1';
					$apt_settings['apt_hide_update_messages'] = '0';
					$apt_settings['apt_export_plugin_data_before_update'] = '1';

					$apt_settings['apt_bulk_tagging_event_unscheduling'] = '1';
					$apt_settings['apt_bulk_tagging_event_recurrence'] = '24';
					$apt_settings['apt_bulk_tagging_range_lower_bound'] = '2';
					$apt_settings['apt_bulk_tagging_range_upper_bound'] = '1';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_upper_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] = '1';
					$apt_settings['apt_bulk_tagging_range'] = array();

					if($apt_settings['apt_warning_messages'] == 1){ 
						$apt_settings['apt_hide_warning_messages'] = '0';
					}
					else{
						$apt_settings['apt_hide_warning_messages'] = '1';
					}

					### copy values of old suboptions to new suboptions
					$apt_settings['apt_taxonomies'] = array($apt_settings['apt_taxonomy_name']);
					$apt_settings['apt_taxonomy_term_limit'] = $apt_settings['apt_tag_limit'];
					$apt_settings['apt_backup_limit'] = $apt_settings['apt_stored_backups'];
					$apt_settings['apt_old_terms_handling'] = $apt_settings['apt_old_tags_handling'];
					$apt_settings['apt_old_terms_handling_2_remove_old_terms'] = $apt_settings['apt_old_tags_handling_2_remove_old_tags'];
					$apt_settings['apt_export_plugin_data_after_update'] = $apt_settings['apt_create_backup_when_updating'];
					$apt_settings['apt_item_editor_mode'] = $apt_settings['apt_keyword_editor_mode'];
					$apt_settings['apt_keyword_sets_total'] = $apt_settings['apt_keywords_total'];
					$apt_settings['apt_highest_keyword_set_id'] = $apt_settings['apt_last_keyword_id'];
					$apt_settings['apt_search_for_term_name'] = $apt_settings['apt_search_for_keyword_names'];
					$apt_settings['apt_search_for_related_keywords'] = $apt_settings['apt_search_for_related_words'];
					$apt_settings['apt_decode_html_entities_related_keywords'] = $apt_settings['apt_decode_html_entities_related_words'];
					$apt_settings['apt_bulk_tagging_posts_per_batch'] = $apt_settings['apt_bulk_tagging_posts_per_cycle'];

					### removing suboptions
					unset($apt_settings['apt_warning_messages']);
					unset($apt_settings['apt_taxonomy_name']);
					unset($apt_settings['apt_tag_limit']);
					unset($apt_settings['apt_stored_backups']);
					unset($apt_settings['apt_old_tags_handling']);
					unset($apt_settings['apt_old_tags_handling_2_remove_old_tags']);
					unset($apt_settings['apt_create_backup_when_updating']);
					unset($apt_settings['apt_keyword_editor_mode']);
					unset($apt_settings['apt_keywords_total']);
					unset($apt_settings['apt_last_keyword_id']);
					unset($apt_settings['apt_search_for_keyword_names']);
					unset($apt_settings['apt_search_for_related_words']);
					unset($apt_settings['apt_decode_html_entities_related_words']);
					unset($apt_settings['apt_post_term_limit']);
					unset($apt_settings['apt_bulk_tagging_posts_per_cycle']);
				}
				if($apt_settings['apt_plugin_version'] == '1.7.1.1'){
					### copy values of old suboptions to new suboptions
					$apt_settings['apt_backup_limit'] = $apt_settings['apt_stored_backups'];
					$apt_settings['apt_configuration_groups_total'] = $apt_settings['apt_groups_total'];
					$apt_settings['apt_highest_configuration_group_id'] = $apt_settings['apt_last_group_id'];
					$apt_settings['apt_keyword_sets_total'] = $apt_settings['apt_keywords_total'];
					$apt_settings['apt_highest_keyword_set_id'] = $apt_settings['apt_last_keyword_id'];
					$apt_settings['apt_search_for_term_name'] = $apt_settings['apt_search_for_keyword_names'];
					$apt_settings['apt_search_for_related_keywords'] = $apt_settings['apt_search_for_related_words'];
					$apt_settings['apt_taxonomy_term_limit'] = $apt_settings['apt_tag_limit'];
					$apt_settings['apt_decode_html_entities_related_keywords'] = $apt_settings['apt_decode_html_entities_related_words'];
					$apt_settings['apt_item_editor_mode'] = $apt_settings['apt_keyword_editor_mode'];
					$apt_settings['apt_nonexistent_groups_handling'] = $apt_settings['apt_group_deletion_mode'];
					$apt_settings['apt_bulk_tagging_posts_per_batch'] = $apt_settings['apt_bulk_tagging_posts_per_cycle'];
					$apt_settings['apt_export_plugin_data_after_update'] = $apt_settings['apt_create_backup_when_updating'];
					$apt_settings['apt_old_terms_handling'] = $apt_settings['apt_old_tags_handling'];
					$apt_settings['apt_old_terms_handling_2_remove_old_terms'] = $apt_settings['apt_old_tags_handling_2_remove_old_tags'];

					### new suboptions
					$apt_settings['apt_export_plugin_data_before_update'] = '1';
					$apt_settings['apt_bulk_tagging_event_unscheduling'] = '1';
					$apt_settings['apt_bulk_tagging_event_recurrence'] = '24';
					$apt_settings['apt_bulk_tagging_range_lower_bound'] = '2';
					$apt_settings['apt_bulk_tagging_range_upper_bound'] = '1';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_upper_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] = '1';
					$apt_settings['apt_bulk_tagging_range'] = array();

					### removing suboptions
					unset($apt_settings['apt_groups_total']);
					unset($apt_settings['apt_last_group_id']);
					unset($apt_settings['apt_keywords_total']);
					unset($apt_settings['apt_last_keyword_id']);
					unset($apt_settings['apt_search_for_keyword_names']);
					unset($apt_settings['apt_search_for_related_words']);
					unset($apt_settings['apt_decode_html_entities_related_words']);
					unset($apt_settings['apt_keyword_editor_mode']);
					unset($apt_settings['apt_group_deletion_mode']);
					unset($apt_settings['apt_bulk_tagging_posts_per_cycle']);
					unset($apt_settings['apt_create_backup_when_updating']);
					unset($apt_settings['apt_stored_backups']);
					unset($apt_settings['apt_old_tags_handling']);
					unset($apt_settings['apt_old_tags_handling_2_remove_old_tags']);

					### move keyword sets to a new format (related keyword weren't in arrays)
					$apt_kw_sets = get_option('automatic_post_tagger_keywords');
					$apt_kw_sets_new = array();

					foreach($apt_kw_sets as $apt_keyword_set){
						//adding the old ID, name and related keywords turned into an array, with the group ID, to the new keyword array
						if($apt_keyword_set[2] == ''){
							$apt_keyword_set_new = array($apt_keyword_set[0], $apt_keyword_set[1], array(), $apt_keyword_set[3]);
						}
						else{
							$apt_keyword_set_new = array($apt_keyword_set[0], $apt_keyword_set[1], explode($apt_settings['apt_string_separator'], $apt_keyword_set[2]), $apt_keyword_set[3]);
						}

						array_push($apt_kw_sets_new, $apt_keyword_set_new);
						unset($apt_keyword_set_new);
					}

					update_option('automatic_post_tagger_keywords', $apt_kw_sets_new);


					### move groups to a new format
					$apt_groups = get_option('automatic_post_tagger_groups');
					$apt_groups_new = array();

					//former format: [0] => Array ( [0] => 1 [1] => group name [2] => taxonomy1,taxonomy2 ) ) 
					foreach($apt_groups as $apt_group){
						array_push($apt_groups_new, array($apt_group[0], $apt_group[1], '0', '1', $apt_settings['apt_taxonomy_term_limit'], explode($apt_settings['apt_string_separator'], $apt_group[2])));
					}

					update_option('automatic_post_tagger_groups', $apt_groups_new);
					apt_set_group_keyword_set_count(0, 3);
				}
				if($apt_settings['apt_plugin_version'] == '1.7.9'){
					### copy values of old suboptions to new suboptions
					$apt_settings['apt_configuration_groups_total'] = $apt_settings['apt_groups_total'];
					$apt_settings['apt_highest_configuration_group_id'] = $apt_settings['apt_last_group_id'];
					$apt_settings['apt_keyword_sets_total'] = $apt_settings['apt_keywords_total'];
					$apt_settings['apt_highest_keyword_set_id'] = $apt_settings['apt_last_keyword_id'];
					$apt_settings['apt_search_for_term_name'] = $apt_settings['apt_search_for_keyword_names'];
					$apt_settings['apt_search_for_related_keywords'] = $apt_settings['apt_search_for_related_words'];
					$apt_settings['apt_taxonomy_term_limit'] = $apt_settings['apt_post_term_limit'];
					$apt_settings['apt_decode_html_entities_related_keywords'] = $apt_settings['apt_decode_html_entities_related_words'];
					$apt_settings['apt_item_editor_mode'] = $apt_settings['apt_keyword_editor_mode'];
					$apt_settings['apt_nonexistent_groups_handling'] = $apt_settings['apt_group_deletion_mode'];
					$apt_settings['apt_bulk_tagging_posts_per_batch'] = $apt_settings['apt_bulk_tagging_posts_per_cycle'];

					### new suboptions
					$apt_settings['apt_bulk_tagging_event_unscheduling'] = '1';
					$apt_settings['apt_bulk_tagging_event_recurrence'] = '24';
					$apt_settings['apt_bulk_tagging_range_lower_bound'] = '2';
					$apt_settings['apt_bulk_tagging_range_upper_bound'] = '1';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_upper_bound'] = '0';
					$apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] = '1';
					$apt_settings['apt_bulk_tagging_range'] = array();

					### removing suboptions
					unset($apt_settings['apt_groups_total']);
					unset($apt_settings['apt_last_group_id']);
					unset($apt_settings['apt_keywords_total']);
					unset($apt_settings['apt_last_keyword_id']);
					unset($apt_settings['apt_search_for_keyword_names']);
					unset($apt_settings['apt_search_for_related_words']);
					unset($apt_settings['apt_post_term_limit']);
					unset($apt_settings['apt_decode_html_entities_related_words']);
					unset($apt_settings['apt_keyword_editor_mode']);
					unset($apt_settings['apt_group_deletion_mode']);
					unset($apt_settings['apt_bulk_tagging_posts_per_cycle']);
				}

				### update from 1.8 to the newest version
				if($apt_settings['apt_plugin_version'] == '1.8'){
					$apt_kw_sets = get_option('automatic_post_tagger_keywords');

					### remove blank elements from related keywords
					foreach($apt_kw_sets as $apt_key => $apt_keyword_set){
						//remove blank element from related keywords
						foreach($apt_keyword_set[2] as $apt_key2 => $apt_value){
							if($apt_value == ''){
								unset($apt_kw_sets[$apt_key][2][$apt_key2]);
							}
						}
					}

					update_option('automatic_post_tagger_keywords', $apt_kw_sets);
				}


/* TODO
				### update from 1.8.1 to the newest version
				if($apt_settings['apt_plugin_version'] == '1.8.3'){
				}
*/
				########################################################
				### modify settings
				$apt_settings['apt_admin_notice_update'] = 1; //we want to show the admin notice after updating
				$apt_settings['apt_plugin_version'] = $apt_current_version; //update plugin version
				update_option('automatic_post_tagger', $apt_settings);

				apt_set_missing_suboptions(); //in case we've forgotten to add some suboptions during the update, add them now from the default settings array
				//TODO - remove redundant suboptions

				### create an automatic backup after updating
				if($apt_settings['apt_export_plugin_data_after_update'] == 1){
					apt_export_plugin_data(1, 1, 0); //export settings to JSON
					apt_export_plugin_data(2, 2, 0); //export keyword sets to CSV
					apt_export_plugin_data(3, 2, 0); //export groups to CSV
				}
				########################################################
			} //-version equality check
		} //-if new suboption with the plugin version exists
		else{ //if the variable doesn't exist try to retrieve it from the old DB format
			if(get_option('apt_plugin_version')){
				if(get_option('apt_plugin_version') != $apt_current_version){ //check whether the saved version isn't equal to the current version

					### update from 1.0, 1.1, 1.2, 1.3, 1.4 to the newest version
					if(version_compare(get_option('apt_plugin_version'), '1.4', '<=')){ //v1.4 and older
						apt_install_plugin_data();
						apt_move_keyword_sets_from_table_to_option();

						### delete old options
						delete_option('apt_plugin_version');
						delete_option('apt_admin_notice_install');
						delete_option('apt_admin_notice_update');
						delete_option('apt_admin_notice_donate');
						delete_option('apt_hidden_widgets');
						delete_option('apt_stats_current_tags');
						delete_option('apt_stats_assigned_tags');
						delete_option('apt_stats_install_date');
						delete_option('apt_post_analysis_title');
						delete_option('apt_post_analysis_content');
						delete_option('apt_post_analysis_excerpt');
						delete_option('apt_handling_current_tags');
						delete_option('apt_string_manipulation_convert_diacritic');
						delete_option('apt_string_manipulation_lowercase');
						delete_option('apt_string_manipulation_strip_tags');
						delete_option('apt_string_manipulation_replace_whitespaces');
						delete_option('apt_string_manipulation_replace_nonalphanumeric');
						delete_option('apt_string_manipulation_ignore_asterisks');
						delete_option('apt_word_recognition_separators');
						delete_option('apt_miscellaneous_tag_maximum');
						delete_option('apt_miscellaneous_tagging_occasion');
						delete_option('apt_miscellaneous_substring_analysis');
						delete_option('apt_miscellaneous_substring_analysis_length');
						delete_option('apt_miscellaneous_substring_analysis_start');
						delete_option('apt_miscellaneous_wildcards');
						delete_option('apt_bulk_tagging_posts_per_cycle');
						delete_option('apt_bulk_tagging_range');
						delete_option('apt_bulk_tagging_statuses');
					}
				} //-version equality check
			} //-else new suboption with the plugin version exists
		} //-new DB version not detected
	} //-if current user can
}

/**
 * Moves keyword sets from the DB table to a new option (for v1.4 and previous versions) and create a backup
 */
function apt_move_keyword_sets_from_table_to_option(){
	global $wpdb, 
	$apt_message_html_prefix_error,
	$apt_message_html_suffix,
	$apt_backup_dir_rel_path;

	$apt_settings = get_option('automatic_post_tagger');

	### copy keyword sets from $apt_table to the new option "automatic_post_tagger_keywords"
	$apt_kw_sets_new = array();
	$apt_table = $wpdb->prefix .'apt_tags'; //table for storing keyword sets and related keywords
	$apt_select_keyword_set_sql = "SELECT tag, related_keywords FROM $apt_table";
	$apt_select_keyword_set_results = $wpdb->get_results($apt_select_keyword_set_sql, ARRAY_N); //get keyword sets and related keywords from the DB
	$apt_select_keyword_set_results_count = count($apt_select_keyword_set_results);
	$apt_keyword_sets_moved_to_option_error = 0; //variable for checking whether an error occurred during copying keyword sets to their new option

	### move keyword sets to the new DB option and create a backup of keyword sets before deleting the old table
	if($apt_select_keyword_set_results_count > 0){ //export tags only if table isn't empty
		$apt_new_keyword_set_id = $apt_settings['apt_highest_keyword_set_id']; //the id value MUST NOT be increased here - it is increased in the loop
		$apt_new_backup_file_name = apt_get_backup_file_name(2, 2);
		$apt_new_backup_file_rel_path = $apt_backup_dir_rel_path . $apt_new_backup_file_name;
		$apt_backup_file_fopen = fopen($apt_new_backup_file_rel_path, 'w');

		foreach($apt_select_keyword_set_results as $apt_row){ //loop handling every row in the table
			$apt_new_keyword_set_id++; //the ID must be increased to avoid adding multiple keyword sets with the same ID
			//adding the old ID, name and related keywords turned into an array, with the group ID, to the new keyword array

			if($apt_row[1] == ''){
				$apt_keyword_new = array($apt_new_keyword_set_id, $apt_row[0], array(), '1');
			}
			else{
				$apt_keyword_new = array($apt_new_keyword_set_id, $apt_row[0], explode($apt_settings['apt_string_separator'], $apt_row[1]), '1');
			}

			@array_push($apt_kw_sets_new, $apt_keyword_new);
			@fputcsv($apt_backup_file_fopen, $apt_row); //add each row from the table to the backup file; the @ character should suppress warnings if the fopen function returns false
			unset($apt_keyword_new);
		} //-foreach
		fclose($apt_backup_file_fopen);

		### single option for storing keyword sets - save all copied keyword sets to this option - already existing option will be overwitten
		if(get_option('automatic_post_tagger_keywords') === false){
			add_option('automatic_post_tagger_keywords', $apt_kw_sets_new, '', 'no');
		}
		else{
			update_option('automatic_post_tagger_keywords', $apt_kw_sets_new);
		}

		$apt_settings['apt_keyword_sets_total'] = $apt_select_keyword_set_results_count; //update keyword stats

		### check whether the number of copied keyword sets is equal to the number of table rows
		if($apt_settings['apt_keyword_sets_total'] != $apt_select_keyword_set_results_count){
			$apt_keyword_sets_moved_to_option_error = 1;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The number of items copied to the option "automatic_post_tagger_keywords" is not the same as the number of keyword sets in the table "'. $apt_table .'".'. $apt_message_html_suffix;
		}
	} //-export tags only if table isn't empty
	else{ //table is empty
		if(get_option('automatic_post_tagger_keywords') === false){ //create the option only if it doesn't exist yet
			add_option('automatic_post_tagger_keywords', $apt_kw_sets_new, '', 'no'); //save empty array
		}
	} //-else

	if($apt_keyword_sets_moved_to_option_error == 0){ //delete table if no errors occurred
		$wpdb->query('DROP TABLE '. $apt_table);
	} //-delete table
	else{ //some errors occurred
		echo $apt_message_html_prefix_error .'<strong>Error:</strong> The DB table "'. $apt_table .'" was not automatically deleted, because all its data wasn\'t successfully copied to the option "automatic_post_tagger_keywords".'. $apt_message_html_suffix;
	} //-else no errors occurred

	update_option('automatic_post_tagger', $apt_settings); //save settings with the keyword count
}

/**
 * Adds default suboptions to the settings array if they're missing (executed after plugin updates to make sure that the plugin will work even if some suboptions weren't added during the update)
 *
 * @return	int	$apt_missing_suboptions Number of missing suboptions
 */
function apt_set_missing_suboptions(){
	global $apt_default_settings_array;

	$apt_settings = get_option('automatic_post_tagger');
	$apt_missing_suboptions = 0;

	foreach($apt_default_settings_array as $apt_default_suboption_name => $apt_default_suboption_value){
		if(array_key_exists($apt_default_suboption_name, $apt_settings)){
			continue;
		}
		else{
			$apt_missing_suboptions++;
			$apt_settings[$apt_default_suboption_name] = $apt_default_suboption_value;
		}
	}

	if($apt_missing_suboptions > 0){
		update_option('automatic_post_tagger', $apt_settings); //save settings
	}

	return $apt_missing_suboptions;
}

## ===================================
## ### UNINSTALL FUNCTION
## ===================================

/**
 * Removes plugin settings from the database - also used for restoring settings
 */
function apt_uninstall_plugin_data(){
	delete_option('automatic_post_tagger');
	delete_option('automatic_post_tagger_groups');
	delete_option('automatic_post_tagger_keywords');
}

## ===================================
## ### ACTION + META LINKS
## ===================================

/**
 * Adds the Settings link to plugin action links
 * @param	array	$apt_action_links
 */
function apt_plugin_action_links($apt_action_links){
   $apt_action_links[] = '<a href="'. admin_url('options-general.php?page=automatic-post-tagger') .'">'. __('Settings') .'</a>';
   return $apt_action_links;
}
/**
 * Adds various links to meta links
 * @param	array	$apt_meta_links
 * @param	string	$apt_file
 */
function apt_plugin_meta_links($apt_meta_links, $apt_file){
	global $apt_plugin_basename;

	if($apt_file == $apt_plugin_basename){
		$apt_meta_links[] = '<a href="https://wordpress.org/support/plugin/automatic-post-tagger">Support forum</a>';
		$apt_meta_links[] = '<a href="https://wordpress.org/plugins/automatic-post-tagger/faq">FAQ</a>';
		$apt_meta_links[] = '<a href="http://devtard.com/donate">Donate</a> / <a href="https://www.patreon.com/devtard">Become a patron</a>';
	}
	return $apt_meta_links;
}

## ===================================
## ### MENU LINK
## ===================================

/**
 * Adds a link to the plugin options page to the main menu
 */
function apt_menu_link(){
	add_options_page('Automatic Post Tagger', 'Automatic Post Tagger', 'manage_options', 'automatic-post-tagger', 'apt_options_page');
}

## ===================================
## ### ADMIN NOTICES
## ===================================

/**
 * Displays various messages
 */
function apt_plugin_admin_notices(){
	if(current_user_can('manage_options')){
		global $pagenow,
		$apt_message_html_prefix_updated,
		$apt_message_html_prefix_warning,
		$apt_message_html_prefix_note,
		$apt_message_html_suffix;

		$apt_settings = get_option('automatic_post_tagger');

		if($pagenow == 'options-general.php' and isset($_GET['page']) and $_GET['page'] == 'automatic-post-tagger'){ //check whether the user is on page options-general.php?page=automatic-post-tagger
			## ===================================
			## ### GET BASED ACTIONS
			## ===================================

			### the following must be executed before other conditions; isset checks are required
			if($apt_settings['apt_admin_notice_install'] == 1){ //install note will appear after clicking the link or visiting the options page
				$apt_settings['apt_admin_notice_install'] = 0; //hide activation notice
				update_option('automatic_post_tagger', $apt_settings); //save settings

				echo $apt_message_html_prefix_note .'<strong>Note:</strong> Now you need to create or import <em>Keyword sets</em> which will be used by the plugin to automatically tag posts when they are published, imported or saved.
					<ul class="apt_custom_list">
						<li><em>Term names</em> represent taxonomy terms (e.g. <strong>tags</strong> by default) which will be added to posts when they or the keyword set\'s <em>Related keywords</em> are found. Keyword sets can be categorized into different <em>Configuration groups</em>, each with unique group-specific settings.</li>
						<li><strong>By default only newly published/imported posts are automatically tagged.</strong> If you want to see the plugin in action when writing new posts or editing drafts, enable the option "Run APT when posts are: <em>Saved</em>" and add the post status "draft" to the option "Allowed post statuses".</li>
						<li>You can also use the <em>Bulk tagging tool</em> to process all of your already existing posts.</li>
					</ul>'. $apt_message_html_suffix; //display quick info for beginners
			}

			### TODO: each version must have a unique update notice
			if($apt_settings['apt_admin_notice_update'] == 1){ //update note will appear after clicking the link or visiting the options page
				$apt_settings['apt_admin_notice_update'] = 0; //hide update notice
				update_option('automatic_post_tagger', $apt_settings); //save settings

				echo $apt_message_html_prefix_note .'<strong>What\'s new in APT v'. $apt_settings['apt_plugin_version'] .'?</strong>
					<br />This minor version fixes bugs related to post types saving and automatic term deletion.'. $apt_message_html_suffix;
			} //-update notice
		} //-options page check

		## ===================================
		## ### OPTIONS BASED ACTIONS
		## ===================================
		if($apt_settings['apt_admin_notice_install'] == 1){ //show link to the setting page after installing
			echo $apt_message_html_prefix_note .'<strong>Automatic Post Tagger</strong> has been installed. <a href="'. admin_url('options-general.php?page=automatic-post-tagger') .'">Set up the plugin &raquo;</a>'. $apt_message_html_suffix;
		}
		if($apt_settings['apt_admin_notice_update'] == 1 and $apt_settings['apt_hide_update_messages'] == 0){ //show link to the setting page after updating
			echo $apt_message_html_prefix_note .'<strong>Automatic Post Tagger</strong> has been updated to version <strong>'. $apt_settings['apt_plugin_version'] .'</strong>. <a href="'. admin_url('options-general.php?page=automatic-post-tagger') .'">Find out what\'s new &raquo;</a>'. $apt_message_html_suffix;
		}
	} //-if can manage options check
}

## ===================================
## ### JAVASCRIPT & CSS
## ===================================

/**
 * Loads JS and CSS scripts on the edit.php page
 */
function apt_load_meta_box_scripts(){
	global $apt_plugin_url;
	wp_enqueue_style('apt_style', $apt_plugin_url .'css/apt-style.css', false, apt_get_plugin_version()); //load CSS
	wp_enqueue_script('apt_meta_box_js', $apt_plugin_url . 'js/apt-meta-box.js', array('jquery'), apt_get_plugin_version()); //load JS (adding new keyword sets)
}

/**
 * Loads JS and CSS scripts on the options page
 */
function apt_load_options_page_scripts(){
	global $apt_plugin_url;
	wp_enqueue_style('apt_style', $apt_plugin_url .'css/apt-style.css', false, apt_get_plugin_version()); //load CSS
	wp_enqueue_script('apt_options_page_js', $apt_plugin_url . 'js/apt-options-page.js', array('jquery'), apt_get_plugin_version()); //load JS (changing the background, toggling widgets)
}

/**
 * Generates an AJAX nonce for the editor meta box
 */
function apt_insert_ajax_nonce_meta_box(){
	$apt_meta_box_nonce = wp_create_nonce('apt_meta_box_nonce');
	?>

	<!-- Automatic Post Tagger -->
	<script type="text/javascript">
		var apt_meta_box_nonce = {
			security: '<?php echo $apt_meta_box_nonce; ?>'
		}
	</script>
	<!-- //-Automatic Post Tagger -->

	<?php
}

/**
 * Generates an AJAX nonce for the options page
 */
function apt_insert_ajax_nonce_options_page(){
	$apt_options_page_nonce = wp_create_nonce('apt_options_page_nonce');
?>
<!-- Automatic Post Tagger -->
<script type="text/javascript">
	var apt_options_page_nonce = {
		security: '<?php echo $apt_options_page_nonce; ?>'
	}
</script>
<!-- //-Automatic Post Tagger -->
<?php
}

## ===================================
## ### WIDGETS + META BOX
## ===================================

/**
 * Returns HTML code hiding widgets
 */
function apt_get_widget_visibility($apt_widget_id){
	$apt_settings = get_option('automatic_post_tagger');

	if(in_array($apt_widget_id, $apt_settings['apt_hidden_widgets'])){
		return 'style="display: none;"';
	}
	else{
		return 'style="display: block;"';
	}
}

/**
 * Updates widgets' visibility via AJAX
 */
function apt_set_widget_visibility(){
	$apt_settings = get_option('automatic_post_tagger');
	check_ajax_referer('apt_options_page_nonce', 'security');

	if(in_array($_POST['apt_widget_id'], $apt_settings['apt_hidden_widgets'])){ //is the widget ID in the array?
		unset($apt_settings['apt_hidden_widgets'][array_search($_POST['apt_widget_id'], $apt_settings['apt_hidden_widgets'])]); //the ID was found, remove it (that array_serach thing is there to determine which array key is assigned to the value)
		update_option('automatic_post_tagger', $apt_settings); //save settings
	}
	else{
 		array_push($apt_settings['apt_hidden_widgets'], $_POST['apt_widget_id']); //add the ID at the end of the array
		update_option('automatic_post_tagger', $apt_settings); //save settings
	}
	die; //the AJAX script has to die, otherwise it will return exit(0)
}

/**
 * Saves keyword sets created via the meta box
 */
function apt_meta_box_create_new_keyword_set(){
	check_ajax_referer('apt_meta_box_nonce', 'security');
	apt_create_new_keyword_set($_POST['apt_meta_box_term_name'], $_POST['apt_meta_box_related_keywords'], $_POST['apt_meta_box_configuration_group']);
	die; //the AJAX script has to die, otherwise it will return exit(0)
}

/**
 * Adds the meta box next to the post editor
 */
function apt_meta_box_add(){
	$apt_settings = get_option('automatic_post_tagger');
	$apt_allowed_post_types = $apt_settings['apt_post_types'];

	foreach($apt_allowed_post_types as $apt_single_post_type){
		add_meta_box('apt_meta_box', 'Automatic Post Tagger', 'apt_meta_box_content', $apt_single_post_type, 'side');
	}
}

/**
 * The meta box content
 */
function apt_meta_box_content(){
	$apt_settings = get_option('automatic_post_tagger');
	$apt_groups = get_option('automatic_post_tagger_groups');
	?>

	<p>
		Term name: <span class="apt_help" title="Term names represent taxonomy terms that will be added to posts when they or the keyword set's related keywords are found. Example: &quot;cats&quot;">i</span>
		<input onkeypress="return apt_enter_submit(event);" type="text" id="apt_meta_box_term_name" name="apt_meta_box_term_name" value="" maxlength="5000" />
	</p>
	<p>
		Related keywords <span class="apt_small">(separated by "<strong><?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?></strong>")</span>: <span class="apt_help" title="<?php echo 'Related keywords are optional. Example: &quot;cat'. $apt_settings['apt_string_separator'] .'kitty'. $apt_settings['apt_string_separator'] .'meo'. $apt_settings['apt_wildcard_character'] .'w&quot;.'; ?>">i</span>
		<input onkeypress="return apt_enter_submit(event);" type="text" id="apt_meta_box_related_keywords" name="apt_meta_box_related_keywords" value="" maxlength="5000" />
	</p>
	<p>
		Configuration group: <span class="apt_help" title="Keyword sets can be categorized into different configuration groups, each with unique group-specific settings.">i</span>
		<select onkeypress="return apt_enter_submit(event);" id="apt_meta_box_configuration_group" name="apt_meta_box_configuration_group">
			<?php apt_display_group_option_list($apt_settings['apt_default_group']); ?>
		</select>
	</p>
	<p>
		<input class="button" type="button" id="apt_meta_box_create_new_keyword_set_button" value=" Create keyword set ">
	</p>
	<div id="apt_meta_box_message"></div>

	<?php
}

## =========================================================================
## ### KEYWORD SET & CONFIGURATION GROUP MANAGEMENT
## =========================================================================

/**
 * Creates a new keyword set
 *
 * @param	string	$apt_raw_term_name
 * @param	string	$apt_raw_related_keywords
 * @param	int		$apt_raw_group_id
 */
function apt_create_new_keyword_set($apt_raw_term_name, $apt_raw_related_keywords, $apt_raw_group_id){
	global $wpdb,
	$apt_message_html_prefix_updated,
	$apt_message_html_prefix_error,
	$apt_message_html_prefix_warning,
	$apt_message_html_suffix;

	$apt_settings = get_option('automatic_post_tagger');
	$apt_groups = get_option('automatic_post_tagger_groups');
	$apt_kw_sets_new = get_option('automatic_post_tagger_keywords');

	$apt_empty_term_name = 0;
	$apt_related_keywords_extra_spaces_warning = 0;
	$apt_related_keywords_wildcard_warning = 0;

	//make sure that the group id is always saved, even if an invalid value is provided
	if(empty($apt_raw_group_id) or apt_get_group_info($apt_raw_group_id, 2) === false){
		$apt_raw_group_id = $apt_settings['apt_default_group']; //save the default group id if none or a nonexistent ID is submitted
	}

	if(empty($apt_raw_term_name)){ //checking if the value of the term name is empty
		$apt_empty_term_name = 1;
	}
	else{
		### removing slashes and replacement of whitespace characters from beginning and end
		//input correction
		if($apt_settings['apt_input_correction'] == 1){
			$apt_new_keyword = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $apt_raw_term_name); //replacing multiple whitespace characters with a space  (if there were, say two spaces between words, this will convert them to one)
			$apt_new_keyword = trim(stripslashes($apt_new_keyword)); //trimming slashes and whitespace characters
			if(trim($apt_new_keyword) == ''){
				$apt_empty_term_name = 1;
			}
		} //-input correction
		else{
			$apt_new_keyword = stripslashes($apt_raw_term_name);
		} //-else input correction


		if($apt_empty_term_name == 0){
			### check whether the keyword already exists
			if(apt_get_keyword_info($apt_new_keyword, 1) != false){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> New keyword set couldn\'t be created, because the term name "<strong>'. htmlspecialchars($apt_new_keyword) .'</strong>" already exists.'. $apt_message_html_suffix;
			}
			else{ //if the keyword doesn't exist, create one
				$apt_new_keyword_id = $apt_settings['apt_highest_keyword_set_id']+1;
				$apt_new_related_keywords_array = array(); //if related keywords are empty, an empty array will be saved

				if(!empty($apt_raw_related_keywords)){
					$apt_raw_related_keywords_array = explode($apt_settings['apt_string_separator'], $apt_raw_related_keywords);

					foreach($apt_raw_related_keywords_array as $apt_raw_related_keyword){
						//input correction
						if($apt_settings['apt_input_correction'] == 1){
							$apt_new_related_keyword = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $apt_raw_related_keyword); //replacing multiple whitespace characters with a space  (if there were, say two spaces between words, this will convert them to one)
							$apt_new_related_keyword = preg_replace('/'. preg_quote($apt_settings['apt_string_separator'], '/') .'{2,}/', $apt_settings['apt_string_separator'], $apt_new_related_keyword); //replacing multiple separators with one
							$apt_new_related_keyword = preg_replace('/'. preg_quote($apt_settings['apt_wildcard_character'], '/') .'{2,}/', $apt_settings['apt_wildcard_character'], $apt_new_related_keyword); //replacing multiple wildcards with one
							$apt_new_related_keyword = trim(stripslashes($apt_new_related_keyword)); //removing slashes, trimming whitespace characters from the beginning and the end
						} //-input correction
						else{
							$apt_new_related_keyword = stripslashes($apt_raw_related_keyword); //removing slashes

							### generate warnings
							if(substr($apt_new_related_keyword, 0, 1) == ' ' or substr($apt_new_related_keyword, -1, 1) == ' '){
								$apt_related_keywords_extra_spaces_warning = 1;
							}
						} //-else input correction

						### generate warnings
						if($apt_related_keywords_wildcard_warning == 0 and strstr($apt_new_related_keyword, $apt_settings['apt_wildcard_character']) and $apt_settings['apt_wildcards'] == 0){
							$apt_related_keywords_wildcard_warning = 1;
						}

						//add the item only if it's not empty
						if(!empty($apt_new_related_keyword)){
							array_push($apt_new_related_keywords_array, $apt_new_related_keyword);
						} //-if related keywords not empty
					} //-foreach
				} //-if empty related keywords check

				array_push($apt_kw_sets_new, array($apt_new_keyword_id, $apt_new_keyword, $apt_new_related_keywords_array, $apt_raw_group_id)); //add id + the keyword + related keywords + group at the end of the array
				update_option('automatic_post_tagger_keywords', $apt_kw_sets_new); //save keyword sets - this line must be placed before the count function in order to display correct stats
				apt_set_group_keyword_set_count($apt_raw_group_id, 3); //this line has to be placed after the group/keyword array update to ensure correct stats are generated!

				$apt_settings['apt_highest_keyword_set_id'] = $apt_new_keyword_id;
				$apt_settings['apt_keyword_sets_total'] = count($apt_kw_sets_new); //update stats
				update_option('automatic_post_tagger', $apt_settings); //save settings

				$apt_new_related_keywords_array_count = count($apt_new_related_keywords_array);

				echo $apt_message_html_prefix_updated .'New keyword set with the term name "<strong>'. htmlspecialchars($apt_new_keyword) .'</strong>" has been created.'. $apt_message_html_suffix;


				if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
					if(!empty($apt_new_related_keywords_array)){
						if($apt_related_keywords_extra_spaces_warning == 1){ //mistake scenario
							echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Related keywords "<strong>'. htmlspecialchars(implode($apt_settings['apt_string_separator'], $apt_new_related_keywords_array)) .'</strong>" contain a space near string separators.'. $apt_message_html_suffix;
						}
						if($apt_related_keywords_wildcard_warning == 1){ //mistake scenario
							echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Related keywords "<strong>'. htmlspecialchars(implode($apt_settings['apt_string_separator'], $apt_new_related_keywords_array)) .'</strong>" contain a wildcard character, but wildcard support is currently disabled!'. $apt_message_html_suffix;
						}
					} //-if related keywords not empty
				} //-if warnings allowed
			} //-else - keyword doesn't exist
		} //-if $apt_empty_term_name = 0
	} //-else - empty check

	if($apt_empty_term_name == 1){
		echo $apt_message_html_prefix_error .'<strong>Error:</strong> New keyword set couldn\'t be created, because the submitted term name was empty.'. $apt_message_html_suffix;
	} //-if empty or spaces only
}

/**
 * Creates a new configuration group
 *
 * @param	string	$apt_raw_group_name			Group name
 * @param	int		$apt_raw_group_status		Group status
 * @param	int		$apt_raw_group_term_limit	Group term limit
 * @param	string	$apt_raw_group_taxonomies	Group taxonomies
 */
function apt_create_new_group($apt_raw_group_name, $apt_raw_group_status, $apt_raw_group_term_limit, $apt_raw_group_taxonomies){
	global $wpdb,
	$apt_message_html_prefix_updated,
	$apt_message_html_prefix_error,
	$apt_message_html_prefix_warning,
	$apt_message_html_suffix;

	$apt_errors_array = array();
	$apt_warnings_array = array();
	$apt_new_group_status = $apt_raw_group_status;

	### generate errors
	if(empty($apt_raw_group_name) or trim($apt_raw_group_name) == ''){
		array_push($apt_errors_array, '<strong>Error:</strong> The submitted group name was empty.');
	}
	if(!($apt_raw_group_status == 0 or $apt_raw_group_status == 1)){
		array_push($apt_errors_array, '<strong>Error:</strong> The submitted group status was invalid.');
	}
	if(!preg_match('/^[1-9][0-9]*$/', $apt_raw_group_term_limit)){ //positive integers only
		array_push($apt_errors_array, '<strong>Error:</strong> The submitted group term limit wasn\'t a positive integer.');
	}

	//if there are no input errors, continue
	if(empty($apt_errors_array)){
		$apt_settings = get_option('automatic_post_tagger');
		$apt_groups_new = get_option('automatic_post_tagger_groups');

		### input correction
		if($apt_settings['apt_input_correction'] == 1){
		//removing slashes and replacement of whitespace characters from beginning and end
			$apt_new_group_name = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $apt_raw_group_name); //replacing multiple whitespace characters with a space (if there were, say two spaces between words, this will convert them to one)
			$apt_new_group_name = trim(stripslashes($apt_new_group_name)); //trimming slashes and whitespace characters
		} //-input correction
		else{
			$apt_new_group_name = stripslashes($apt_raw_group_name);
		} //-else input correction

		### duplicity check
		if(apt_get_group_info($apt_new_group_name, 1) != false){
			array_push($apt_errors_array, '<strong>Error:</strong> The group name "<strong>'. htmlspecialchars($apt_new_group_name) .'</strong>" already exists');
		}
		else{ //continue only if the group name doesn't exist
			$apt_new_group_name_id = $apt_settings['apt_highest_configuration_group_id']+1;
			$apt_new_group_taxonomies_array = array();

			if(!empty($apt_raw_group_taxonomies)){ //the submitted value is NOT empty
				$apt_raw_group_taxonomies_array = explode($apt_settings['apt_string_separator'], $apt_raw_group_taxonomies);

				foreach($apt_raw_group_taxonomies_array as $apt_raw_group_taxonomy){
					//input correction
					if($apt_settings['apt_input_correction'] == 1){
						$apt_new_group_taxonomy = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $apt_raw_group_taxonomy); //replacing multiple whitespace characters with a space  (if there were, say two spaces between words, this will convert them to one)
						$apt_new_group_taxonomy = preg_replace('/'. preg_quote($apt_settings['apt_string_separator'], '/') .'{2,}/', $apt_settings['apt_string_separator'], $apt_new_group_taxonomy); //replacing multiple separators with one
						$apt_new_group_taxonomy = preg_replace('/'. preg_quote($apt_settings['apt_wildcard_character'], '/') .'{2,}/', $apt_settings['apt_wildcard_character'], $apt_new_group_taxonomy); //replacing multiple wildcards with one
						$apt_new_group_taxonomy = trim(stripslashes($apt_new_group_taxonomy)); //removing slashes, trimming whitespace characters from the beginning and the end //TODO no need to trim separators - this should be used the same way in the create new keyword set function as well
					} //-input correction
					else{
						$apt_new_group_taxonomy = stripslashes($apt_raw_taxonomy); //removing slashes
					} //-else input correction

					//add the item only if it's not empty
					if(!empty($apt_new_group_taxonomy)){
						array_push($apt_new_group_taxonomies_array, $apt_new_group_taxonomy);

						if($apt_settings['apt_input_correction'] == 1){
							if(!taxonomy_exists($apt_new_group_taxonomy)){
								$apt_new_group_status = 0; //if the taxonomy is invalid, disable the group
								array_push($apt_warnings_array, '<strong>Warning:</strong> The taxonomy "<strong>'. htmlspecialchars($apt_new_group_taxonomy) .'</strong>" isn\'t registered.');
							}
						} //-input correction
					} //-if
				} //-foreach
			} //-if empty taxonomies check
			else{
				array_push($apt_warnings_array, '<strong>Warning:</strong> The configuration group "<strong>'. htmlspecialchars($apt_new_group_name) .'</strong>" doesn\'t have any taxonomies.');

				if($apt_settings['apt_input_correction'] == 1){
					$apt_new_group_status = 0; //if taxonomies are missing, disable the group
				} //-input correction
			}

			array_push($apt_groups_new, array($apt_new_group_name_id, $apt_new_group_name, '0', $apt_new_group_status, $apt_raw_group_term_limit, $apt_new_group_taxonomies_array)); //add the group id, name, keyword count = 0, status, term limit, taxonomies at the end of the array

			update_option('automatic_post_tagger_groups', $apt_groups_new); //save groups - this line must be placed before the count function in order to display correct stats
			$apt_settings['apt_highest_configuration_group_id'] = $apt_new_group_name_id;
			$apt_settings['apt_configuration_groups_total'] = count($apt_groups_new); //update stats
			update_option('automatic_post_tagger', $apt_settings); //save settings

			echo $apt_message_html_prefix_updated .'New configuration group "<strong>'. htmlspecialchars($apt_new_group_name) .'</strong>" has been created.'. $apt_message_html_suffix; //confirmation message displaying taxonomies if available

			if($apt_settings['apt_hide_warning_messages'] == 0){
				### generate warnings
				if($apt_new_group_status == 0 and $apt_raw_group_status == 1){ //if the raw status was 1 but was changed to 0, print the warning
					array_push($apt_warnings_array, '<strong>Warning:</strong> The configuration group "<strong>'. htmlspecialchars($apt_new_group_name) .'</strong>" has been disabled.');
				}

				### display warnings
				if(!empty($apt_warnings_array)){
						foreach($apt_warnings_array as $apt_single_warning){
							echo $apt_message_html_prefix_warning . $apt_single_warning . $apt_message_html_suffix;
						}
				} //-if warnings exist
			} //-if warnings allowed
		} //-else group name doesn't exist
	} //-if no errors exist

	### display errors
	if(!empty($apt_errors_array)){
		foreach($apt_errors_array as $apt_single_error){
			echo $apt_message_html_prefix_error . $apt_single_error . $apt_message_html_suffix;
		}
	} //-if errors exist
}

## ===================================
## ### PLUGIN DATA EXPORT
## ===================================

/**
 * Exports plugin data to a file
 *
 * @param	int		$apt_data_type			Data type (1: settings|2: keyword sets|3: groups)
 * @param	int		$apt_file_format		Export type (1: JSON|2: CSV)
 * @param	int		$apt_display_messages	Display messages (optional, displayed by default)
 * @param	string	$apt_option_name		Option name (optional)
 * @param	int		$apt_backup_limit		Backup limit (optional)
 * @return	bool							Export result (true|false)
 */
function apt_export_plugin_data($apt_data_type, $apt_file_format, $apt_display_messages = 1, $apt_option_name = false, $apt_backup_limit = false){
	global $apt_message_html_prefix_error,
	$apt_message_html_prefix_updated,
	$apt_message_html_suffix,
	$apt_backup_dir_rel_path,
	$apt_backup_dir_abs_path,
	$apt_backup_file_name_prefix_plugin_settings,
	$apt_backup_file_name_prefix_keyword_sets,
	$apt_backup_file_name_prefix_configuration_groups,
	$apt_backup_file_name_csv_suffix,
	$apt_backup_file_name_json_suffix;

	$apt_settings = get_option('automatic_post_tagger');

	### mistake checks
	if((!isset($apt_data_type) or !in_array($apt_data_type, array(1, 2, 3))) or (!isset($apt_file_format) or !in_array($apt_file_format, array(1, 2))) or ($apt_option_name !== false and get_option($apt_option_name) === false) or ($apt_backup_limit !== false and $apt_backup_limit <= 0)){
		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The backup file couldn\'t be created, because provided function arguments were invalid. <span class="apt_help" title="Submitted arguments: &quot;'. $apt_data_type .'&quot;, &quot;'. $apt_file_format .'&quot;, &quot;'. $apt_display_messages .'&quot;, &quot;'. $apt_option_name .'&quot;, &quot;'. $apt_backup_limit .'&quot;">i</span>'. $apt_message_html_suffix;
		}

		return false;
	}

	### argument-specific actions
	if($apt_data_type == 1){
		$apt_data_type_name = 'Plugin settings';
		$apt_new_backup_file_name = apt_get_backup_file_name(1, $apt_file_format);
		$apt_backup_file_name_prefix = $apt_backup_file_name_prefix_plugin_settings;

		### if no option name is provided, load data from options in the current version, otherwise use options from older versions
		if($apt_option_name === false){
			$apt_export_data_array = $apt_settings;
		}
		else{
			$apt_settings = get_option($apt_option_name); //since we are loading the data from an older option, we must redefine the $apt_settings['apt_backup_limit'] variable a few lines below
			$apt_export_data_array = $apt_settings;
		}
	}
	if($apt_data_type == 2){
		$apt_data_type_name = 'Keyword sets';
		$apt_new_backup_file_name = apt_get_backup_file_name(2, $apt_file_format);
		$apt_backup_file_name_prefix = $apt_backup_file_name_prefix_keyword_sets;

		### if no option name is provided, load data from options in the current version, otherwise use options from older versions
		if($apt_option_name === false){
			$apt_export_data_array = get_option('automatic_post_tagger_keywords');
		}
		else{
			$apt_export_data_array = get_option($apt_option_name);
		}
	}
	if($apt_data_type == 3){
		$apt_data_type_name = 'Configuration groups';
		$apt_new_backup_file_name = apt_get_backup_file_name(3, $apt_file_format);
		$apt_backup_file_name_prefix = $apt_backup_file_name_prefix_configuration_groups;

		### if no option name is provided, load data from options in the current version, otherwise use options from older versions
		if($apt_option_name === false){
			$apt_export_data_array = get_option('automatic_post_tagger_groups');
		}
		else{
			$apt_export_data_array = get_option($apt_option_name);
		}
	}

	### stop if we the data source array is empty (e.g. no keyword sets have been created yet)
	if($apt_option_name === false and is_array($apt_export_data_array) and empty($apt_export_data_array)){ //the first mistake check filteres out the case when $apt_option_name !== false
		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The backup file couldn\'t be created, because the data source was empty.'. $apt_message_html_suffix;
		}
		return false; //if the keyword set array is empty and false is returned when updating, the update must not be aborted
	}

	### if the backup limit argument is provided, assign a new value to the settings variable (it isn't defined in older versions) 
	if($apt_backup_limit !== false){
		$apt_settings['apt_backup_limit'] = $apt_backup_limit; //this must be placed here, after defining the variable $apt_export_data_array, in case the older settings option is passed as an argument
	}

	### determine the file format
	if($apt_file_format == 1){
		$apt_backup_file_name_suffix = $apt_backup_file_name_json_suffix;
	}
	if($apt_file_format == 2){
		$apt_backup_file_name_suffix = $apt_backup_file_name_csv_suffix;
	}

	if($apt_new_backup_file_name !== false){ //continue only if the new name was successfully generated
		$apt_new_backup_file_rel_path = $apt_backup_dir_rel_path . $apt_new_backup_file_name;
		$apt_new_backup_file_abs_path = $apt_backup_dir_abs_path . $apt_new_backup_file_name;

		### JSON export
		if($apt_file_format == 1){
			//put the serialized data source array into the file
			file_put_contents($apt_new_backup_file_rel_path, json_encode($apt_export_data_array));
		}

		### CSV export
		if($apt_file_format == 2){
			if($apt_data_type == 2 or $apt_data_type == 3){
				//continue only if the file can be created
				if(!fopen($apt_new_backup_file_rel_path, 'w')){
					if($apt_display_messages == 1){
						echo $apt_message_html_prefix_error .'<strong>Error:</strong> The backup file couldn\'t be created because of insufficient permissions (preventing the plugin from creating the file).'. $apt_message_html_suffix;
					}
					return false;
				}

				usort($apt_export_data_array, 'apt_sort_items'); //sort items by their name
				$apt_backup_file_fopen = fopen($apt_new_backup_file_rel_path, 'w');
				$apt_exported_row = array();
			} //-if data type 2 or 3

			if($apt_data_type == 2){ //keyword sets
				foreach($apt_export_data_array as $apt_export_data_array_single){
					$apt_exported_row[0] = $apt_export_data_array_single[1];
					$apt_exported_row[1] = implode($apt_settings['apt_string_separator'], $apt_export_data_array_single[2]); //convert the related keywords array to a string
					$apt_exported_row[2] = apt_get_group_info($apt_export_data_array_single[3], 2); //replace the group ID with the group name
					fputcsv($apt_backup_file_fopen, $apt_exported_row);
				}
				fclose($apt_backup_file_fopen);
			} //-if
			if($apt_data_type == 3){ //groups
				foreach($apt_export_data_array as $apt_export_data_array_single){
					$apt_exported_row[0] = $apt_export_data_array_single[1];
					$apt_exported_row[1] = $apt_export_data_array_single[3];
					$apt_exported_row[2] = $apt_export_data_array_single[4];
					$apt_exported_row[3] = implode($apt_settings['apt_string_separator'], $apt_export_data_array_single[5]); //convert the taxonomies array to a string
					fputcsv($apt_backup_file_fopen, $apt_exported_row);
				}
				fclose($apt_backup_file_fopen);
			} //-if
		} //-if export type = 2

		### DELETION of BACKUPS - if the number of generated backups is higher than a specified amount, delete the old one(s)
		chdir($apt_backup_dir_rel_path); //change directory to the backup directory
		$apt_existing_backup_files = glob($apt_backup_file_name_prefix .'*'. $apt_backup_file_name_suffix); //find files with the specified prefix and suffix

		if(count($apt_existing_backup_files) > $apt_settings['apt_backup_limit']){ //continue if there are more backups than the specified backup limit
			//sort the array of files drom the oldest one
			array_multisort(array_map('filemtime', $apt_existing_backup_files), SORT_NUMERIC, SORT_ASC, $apt_existing_backup_files);

			//calculate the number of extra files in the directory
			$apt_redundant_old_files_number = count($apt_existing_backup_files) - $apt_settings['apt_backup_limit'];

			//this loop will remove all redundant old files
			for($i = 0; $apt_redundant_old_files_number != 0; $i++){
				//delete the item which should be the oldest one
				unlink($apt_backup_dir_rel_path . $apt_existing_backup_files[$i]);

				//decrease the number of redundant old files by 1
				$apt_redundant_old_files_number--;
			} //-for
		} //-if

		if(file_exists($apt_new_backup_file_rel_path)){ //check whether the created backup file actually exists
			if($apt_display_messages == 1){
				echo $apt_message_html_prefix_updated . $apt_data_type_name .' export complete. <a href="'. $apt_new_backup_file_abs_path .'">Download the backup file &raquo;</a> <span class="apt_help" title="Your backup files are accessible to anyone who can guess their URL. You may want to restrict access to the backup directory via the .htaccess file for example.">i</span>'. $apt_message_html_suffix;
			}
			return true;
		}
		else{
			if($apt_display_messages == 1){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> The backup file that should have been created doesn\'t exist.'. $apt_message_html_suffix;
			}
			return false;
		}
	} //-backup file name can be generated
	else{ //backup file name can't be generated
		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The backup file couldn\'t be created because of insufficient permissions (preventing the plugin from generating a new name for the file).'. $apt_message_html_suffix;
			return false;
		}
	} //-else
}

/**
 * Exports items to textarea in CSV format
 * @param	int		$apt_data_type	1: keyword sets|2: configuration groups
 * @return	string
 */
function apt_export_items_to_textarea($apt_data_type){
	$apt_settings = get_option('automatic_post_tagger');

	if($apt_data_type == 1){
		$apt_data_array = get_option('automatic_post_tagger_keywords');
	}
	if($apt_data_type == 2){
		$apt_data_array = get_option('automatic_post_tagger_groups');
	}

	usort($apt_data_array, 'apt_sort_items'); //sort items by their name
    ob_start(); //turn on buffering
    $apt_csv_output = fopen('php://output', 'w');
	$apt_exported_row = array();

	foreach($apt_data_array as $apt_data_single_array){
		$apt_exported_row[0] = $apt_data_single_array[1];

		if($apt_data_type == 1){
			$apt_exported_row[1] = implode($apt_settings['apt_string_separator'], $apt_data_single_array[2]); //convert the related keywords array to a string
			$apt_exported_row[2] = apt_get_group_info($apt_data_single_array[3], 2); //replace the group ID with the group name
		}
		if($apt_data_type == 2){
			$apt_exported_row[1] = $apt_data_single_array[3];
			$apt_exported_row[2] = $apt_data_single_array[4];
			$apt_exported_row[3] = implode($apt_settings['apt_string_separator'], $apt_data_single_array[5]); //convert the taxonomies array to a string
		}

		fputcsv($apt_csv_output, $apt_exported_row);
	}

	fclose($apt_csv_output);
	return htmlspecialchars(ob_get_clean()); //return htmlspecialcharsed buffer content
}

## ===================================
## ### PLUGIN DATA IMPORT
## ===================================

/**
 * Imports taxonomy terms from the database
 *
 * @param	array	$apt_imported_taxonomies_array
 * @param	string	$apt_keyword_set_column
 */
function apt_import_terms_from_taxonomies($apt_imported_taxonomies_array, $apt_keyword_set_column){
	global $apt_message_html_prefix_updated,
	$apt_message_html_suffix,
	$apt_message_html_prefix_note;

	$apt_settings = get_option('automatic_post_tagger');
	$apt_kw_sets = get_option('automatic_post_tagger_keywords');

	$apt_kw_sets_new = $apt_kw_sets; //all keyword sets will be saved into this variable which also includes old keywords
	$apt_imported_keyword_set_count_total = 0;

	foreach($apt_imported_taxonomies_array as $apt_single_taxonomy){
		$apt_retrieve_taxonomy = get_terms($apt_single_taxonomy);
		$apt_currently_imported_keywords = 0; //this will be used to determine how many terms were imported
		$apt_new_keyword_id = $apt_settings['apt_highest_keyword_set_id']; //the id value MUST NOT be increased here - it is increased in the loop

		foreach($apt_retrieve_taxonomy as $apt_taxonomy_object){ //retrieve taxonomy items
			$apt_to_be_created_keyword_already_exists = 0; //variable for determining whether the taxonomy item exists
			foreach($apt_kw_sets_new as $apt_key){ //process all elements of the array
				//duplicity check
				if($apt_keyword_set_column == 1){
					if(strtolower($apt_key[1]) == strtolower($apt_taxonomy_object->name)){ //checking whether the strtolowered term already exists in the DB
						$apt_to_be_created_keyword_already_exists = 1;
						break; //stop the loop
					}
				}
				else{
					if(strtolower($apt_key[1]) == $apt_taxonomy_object->term_id){ //checking whether the term ID already exists in the DB
						$apt_to_be_created_keyword_already_exists = 1;
						break; //stop the loop
					}
				} //-else duplicity check
			} //-foreach

			//adding terms from taxonomy as term names
			if($apt_keyword_set_column == 1){
				if($apt_to_be_created_keyword_already_exists == 0){ //add the taxonomy item only if it doesn't exist yet
					$apt_new_keyword_id++; //increase the id value
					array_push($apt_kw_sets_new, array($apt_new_keyword_id, $apt_taxonomy_object->name, array(), $apt_settings['apt_default_group'])); //we are inserting related keywords as empty arrays
					$apt_currently_imported_keywords++;
				} //if-add as terms
			}
			else{ //adding terms from taxonomy as related keywords
				if($apt_to_be_created_keyword_already_exists == 0){ //add the taxonomy item only if it doesn't exist yet
					$apt_new_keyword_id++; //increase the id value
					array_push($apt_kw_sets_new, array($apt_new_keyword_id, $apt_taxonomy_object->term_id, array($apt_taxonomy_object->name), $apt_settings['apt_default_group'])); //we are importing term names as related keywords and their IDs as term names
					$apt_currently_imported_keywords++;
				} //if-add as related keywords
			} //-else
		} //-foreach - retrieving taxonomy items


		if($apt_currently_imported_keywords != 0){ //we have imported something from ONE taxonomy
			update_option('automatic_post_tagger_keywords', $apt_kw_sets_new); //save keyword sets - this line must be placed before the count function in order to display correct stats
			$apt_settings['apt_highest_keyword_set_id'] = $apt_new_keyword_id; //save newest last id value
			$apt_settings['apt_keyword_sets_total'] = count($apt_kw_sets_new); //update stats
			update_option('automatic_post_tagger', $apt_settings); //save settings
		} //-if

		$apt_imported_keyword_set_count_total = $apt_imported_keyword_set_count_total + $apt_currently_imported_keywords; 
	} //-foreach - all taxonomies


	### update group keyword set count if terms have been imported
	if($apt_imported_keyword_set_count_total != 0){
		apt_set_group_keyword_set_count(0, 3);
	} //-if

	$apt_taxonomies_count = count($apt_imported_taxonomies_array);

	if($apt_imported_keyword_set_count_total != 0){ //we have imported something from all taxonomies
		echo $apt_message_html_prefix_updated .'Import complete. <strong>'. $apt_imported_keyword_set_count_total .'</strong> '. apt_get_grammatical_number($apt_imported_keyword_set_count_total, 1, 2) .' from '. apt_get_grammatical_number($apt_taxonomies_count, 1, 5) .' '. apt_get_grammatical_number($apt_imported_keyword_set_count_total, 2, 2) .' been imported.'. $apt_message_html_suffix;
	}
	else{
		echo $apt_message_html_prefix_note .'<strong>Note:</strong> No new (unique) terms have been imported.'. $apt_message_html_suffix;
	}
}

/**
 * Imports items from CSV format
 *
 * @param	array	$apt_csv_data_array
 * @param	int		$apt_csv_data_type	1: keyword sets|2: configuration groups
 */
function apt_import_items_from_csv($apt_csv_data_array, $apt_csv_data_type){
	$apt_settings = get_option('automatic_post_tagger');

	$apt_invalid_taxonomies = 0;

	if($apt_csv_data_type == 1){
		$apt_highest_item_id = $apt_settings['apt_highest_keyword_set_id']; //the id value MUST NOT be increased here - it is increased in the loop
	} //-when importing keyword sets
	if($apt_csv_data_type == 2){
		$apt_highest_item_id = $apt_settings['apt_highest_configuration_group_id']; //the id value MUST NOT be increased here - it is increased in the loop
	} //-when importing configuration groups

	$apt_import_information = array($apt_highest_item_id, '0', '0', '0', '0', '0'); //[0] highest item id, [1] number of currently imported items, [2] row structure invalid error, [3] related keywords|taxonomies a space warning, [4] related keywords wildcard warning, [5] name a space warning
	$apt_items_array = array(); //all items will be saved into this variable

	foreach($apt_csv_data_array as $apt_csv_row){
		$apt_csv_row = str_getcsv($apt_csv_row);
		$apt_csv_row_elements_count = count($apt_csv_row);

		//skip empty rows
		if($apt_csv_row[0] === null){
			continue;
		}

		### import only if we have a valid row structure; otherwise skip the row (taxonomies and related keywords are optional); keyword sets: check whether the name isn't empty and whether the number of row elements is higher or equal to 1 and lower or equal to 3; groups: check whether the name isn't empty and whether the number of row elements is higher or equal to 3 and lower or equal to 4, whether the status is 1 or 0, whether the term limits is a positive integer
		if(($apt_csv_data_type == 1 and (isset($apt_csv_row[0]) and $apt_csv_row[0] !== '') and $apt_csv_row_elements_count >= 1 and $apt_csv_row_elements_count <= 3) or ($apt_csv_data_type == 2 and (isset($apt_csv_row[0]) and $apt_csv_row[0] !== '') and $apt_csv_row_elements_count >= 3 and $apt_csv_row_elements_count <= 4 and (isset($apt_csv_row[1]) and ($apt_csv_row[1] == '1' or $apt_csv_row[1] == '0')) and (isset($apt_csv_row[2]) and preg_match('/^[1-9][0-9]*$/', $apt_csv_row[2])))){
			### check whether the item name already exists
			if(apt_array_item_check($apt_items_array, $apt_csv_row[0]) === false){ //continue only if the item name doesn't exist yet
				$apt_import_information[0]++; //increase the id value
				$apt_import_information[1]++; //increase the number of currently imported items
				$apt_new_imported_subitems_array = array(); //subitems will be saved as an empty array if none are submitted

				if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
					if(substr($apt_csv_row[0], 0, 1) == ' ' or substr($apt_csv_row[0], -1, 1) == ' '){
						$apt_import_information[5]++; //name a space warning
					}
				} //-if warnings allowed

				if($apt_csv_data_type == 1){
					$apt_subitem_array = @$apt_csv_row[1]; //related keywords
				} //-when importing keyword sets
				if($apt_csv_data_type == 2){
					$apt_subitem_array = @$apt_csv_row[3]; //taxonomies
				} //-when importing configuration groups

				if(!empty($apt_subitem_array)){ //only if subitems exist
					$apt_raw_imported_subitems_array = explode($apt_settings['apt_string_separator'], $apt_subitem_array);

					foreach($apt_raw_imported_subitems_array as $apt_raw_imported_subitems_single_string){
						if($apt_csv_data_type == 2){
							if(!taxonomy_exists($apt_raw_imported_subitems_single_string) and $apt_csv_row[1] != 0){
								$apt_invalid_taxonomies++;

								if($apt_settings['apt_input_correction'] == 1){
										$apt_csv_row[1] = '0'; //disable the group if submitted taxonomies aren't registered and the group isn't disabled already
								} //-input correction
							}
						} //-when importing configuration groups

						//add the item only if it's not empty
						if(!empty($apt_raw_imported_subitems_single_string)){
							array_push($apt_new_imported_subitems_array, $apt_raw_imported_subitems_single_string);
						} //-if item exists

						if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
							if(substr($apt_raw_imported_subitems_single_string, 0, 1) == ' ' or substr($apt_raw_imported_subitems_single_string, -1, 1) == ' '){
								$apt_import_information[3]++; //subitems a space warning
							}

							if($apt_csv_data_type == 1){
								if(strstr($apt_raw_imported_subitems_single_string, $apt_settings['apt_wildcard_character']) and ($apt_settings['apt_wildcards'] == 0)){
									$apt_import_information[4]++; //related keywords wildcards warning
								}
							} //-when importing keyword sets
						} //-if warnings allowed
					} //-foreach
				} //-if submitems not empty
				elseif($apt_csv_data_type == 2){
					if($apt_csv_row[1] != 0){
						$apt_invalid_taxonomies++;

						if($apt_settings['apt_input_correction'] == 1){
							$apt_csv_row[1] = '0'; //disable the group if taxonomies aren't submitted and the group isn't disabled already
						} //-input correction
					}
				} //-when importing configuration groups


				if($apt_csv_data_type == 1){
					if(!isset($apt_csv_row[2]) or $apt_csv_row[2] == '' or apt_get_group_info($apt_csv_row[2], 1) === false){
						$apt_csv_row[2] = apt_get_group_info($apt_settings['apt_default_group'], 2); //save the default group name if none or a nonexistent group is submitted
					} 

					$apt_item_array_new = array($apt_import_information[0], $apt_csv_row[0], $apt_new_imported_subitems_array, apt_get_group_info($apt_csv_row[2], 1));
				} //-when importing keyword sets

				if($apt_csv_data_type == 2){
					$apt_item_array_new = array($apt_import_information[0], $apt_csv_row[0], 'n/a', $apt_csv_row[1], $apt_csv_row[2], $apt_new_imported_subitems_array);
				} //-when importing configuration groups

				array_push($apt_items_array, $apt_item_array_new);
			} //-if item doesn't exist in the array
		} //-if correct structure
		else{
			$apt_import_information[2]++; //invalid structure
		}
	} //-foreach

	if($apt_invalid_taxonomies > 0){
		global $apt_message_html_prefix_warning, $apt_message_html_suffix;

		if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
			if($apt_settings['apt_input_correction'] == 1){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_invalid_taxonomies .' '. apt_get_grammatical_number($apt_invalid_taxonomies, 1, 1) .' without registered taxonomies '. apt_get_grammatical_number($apt_invalid_taxonomies, 2, 1) .' been disabled.'. $apt_message_html_suffix;
			}
			else{
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Configuration groups without registered taxonomies couldn\'t be disabled. Enable the option "Input correction" to prevent this from happening in the future.'. $apt_message_html_suffix;
			}
		}
	} //-if errors occured

	return array($apt_items_array, $apt_import_information);
}

/**
 * Imports items from a textarea
 *
 * @param	string	$apt_data_string
 * @param	int		$apt_data_type	1: keyword sets|2: groups
 */
function apt_import_items_from_textarea($apt_data_string, $apt_data_type){
	global $apt_message_html_prefix_updated,
	$apt_message_html_suffix,
	$apt_message_html_prefix_error,
	$apt_message_html_prefix_warning;

	$apt_settings = get_option('automatic_post_tagger');
	$apt_imported_data_array = str_getcsv(stripslashes($apt_data_string), "\n"); //remove backslashes and turn the string into an array; we are using str_getcsv instead of explode - it's better according to the manual

	if($apt_data_type == 1){
		$apt_import_result_array = apt_import_items_from_csv($apt_imported_data_array, 1);
		$apt_imported_data_type_label = 'Keyword sets ';
		$apt_imported_data_type_label_2 = apt_get_grammatical_number($apt_import_result_array[1][3], 1, 7);
		$apt_imported_data_type_label_3 = apt_get_grammatical_number($apt_import_result_array[1][4], 1, 7);
		$apt_imported_data_type_label_4 = 'term '. apt_get_grammatical_number($apt_import_result_array[1][5], 1, 10);

		$apt_settings['apt_highest_keyword_set_id'] = $apt_import_result_array[1][0]; //save the highest id value
		$apt_settings['apt_keyword_sets_total'] = count($apt_import_result_array[0]); //save the current number of keyword sets
		update_option('automatic_post_tagger_keywords', $apt_import_result_array[0]); //save keyword sets
		update_option('automatic_post_tagger', $apt_settings); //save settings
	}

	if($apt_data_type == 2){
		$apt_import_result_array = apt_import_items_from_csv($apt_imported_data_array, 2);
		$apt_imported_data_type_label = 'Configuration groups ';
		$apt_imported_data_type_label_2 = apt_get_grammatical_number($apt_import_result_array[1][3], 1, 6);
		$apt_imported_data_type_label_4 = 'group '. apt_get_grammatical_number($apt_import_result_array[1][5], 1, 10);

		$apt_old_default_group_name = apt_get_group_info($apt_settings['apt_default_group'], 2);
		$apt_old_groups_array = get_option('automatic_post_tagger_groups');

		$apt_imported_items = count($apt_import_result_array[0]);

		### make sure that the default group is saved even if no groups were imported
		if($apt_imported_items == 0){
			global $apt_default_groups_array;
			$apt_settings['apt_highest_configuration_group_id'] = 1; //save the highest id value
			$apt_settings['apt_configuration_groups_total'] = 1; //save the current number of groups
			update_option('automatic_post_tagger_groups', $apt_default_groups_array); //save groups
			update_option('automatic_post_tagger', $apt_settings); //settings must be saved now, otherwise the data saved by the function apt_set_plugin_settings_information(3, ) will be overwritten
		}
		else{
			$apt_settings['apt_highest_configuration_group_id'] = $apt_import_result_array[1][0]; //save the highest id value
			$apt_settings['apt_configuration_groups_total'] = count($apt_import_result_array[0]); //save the current number of groups
			update_option('automatic_post_tagger_groups', $apt_import_result_array[0]); //save groups
			update_option('automatic_post_tagger', $apt_settings); //settings must be saved now, otherwise the data saved by the function apt_set_plugin_settings_information(3, ) will be overwritten
		}
		apt_set_plugin_settings_information(3, $apt_old_default_group_name); //check whether the default group exists, if not, select a new default group
		apt_nonexistent_groups_handling($apt_old_groups_array); //assign old group names to keyword sets with invalid (old) group IDs, if current groups with new IDs have the same old names - this function must be placed after "apt_set_plugin_settings_information(3,)"
	}

	apt_set_group_keyword_set_count(0, 3);

	//mistake warnings/errors
	if($apt_import_result_array[1][2] > 0){
		echo $apt_message_html_prefix_error .'<strong>Error:</strong> '. $apt_import_result_array[1][2] .' '. apt_get_grammatical_number($apt_import_result_array[1][2], 1, 8) .' couldn\'t be imported, because the CSV row structure was invalid.'. $apt_message_html_suffix;
	}

	echo $apt_message_html_prefix_updated . $apt_imported_data_type_label .' have been saved.'. $apt_message_html_suffix;

	if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
		if(isset($apt_import_result_array[1][3]) and $apt_import_result_array[1][3] > 0){
			echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_import_result_array[1][3] .' '. $apt_imported_data_type_label_2 .' '. apt_get_grammatical_number($apt_import_result_array[1][3], 3) .' a space at the beginning or the end of the string.'. $apt_message_html_suffix;
		}
		if(isset($apt_import_result_array[1][4]) and $apt_import_result_array[1][4] > 0){
			echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_import_result_array[1][4] .' '. $apt_imported_data_type_label_3 .' '. apt_get_grammatical_number($apt_import_result_array[1][4], 3) .' the wildcard character, but wildcard support is currently disabled!'. $apt_message_html_suffix;
		}
		if(isset($apt_import_result_array[1][5]) and $apt_import_result_array[1][5] > 0){
			echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_import_result_array[1][5] .' '. $apt_imported_data_type_label_4 .' '. apt_get_grammatical_number($apt_import_result_array[1][5], 3) .' a space at the beginning or the end of the string.'. $apt_message_html_suffix;
		}
	} //-if warnings allowed
}

/**
 * Imports plugin data from a file
 *
 * @param	string	$apt_imported_file		Imported file data
 * @param	string	$apt_imported_data_type	Plugin settings|keyword sets|configuration groups
 */
function apt_import_plugin_data_from_file($apt_imported_file, $apt_imported_data_type){
	global $apt_message_html_prefix_error,
	$apt_message_html_prefix_updated,
	$apt_message_html_prefix_note,
	$apt_message_html_suffix,
	$apt_message_html_prefix_warning,
	$apt_backup_dir_rel_path,
	$apt_backup_file_name_csv_suffix,
	$apt_backup_file_name_json_suffix;

	$apt_settings = get_option('automatic_post_tagger');

	if(is_uploaded_file($apt_imported_file['tmp_name'])){ //file has been uploaded
		if(strstr($apt_imported_file['name'], $apt_backup_file_name_csv_suffix) or strstr($apt_imported_file['name'], $apt_backup_file_name_json_suffix)){ //checks if the name of uploaded file contains the suffix ".csv" or ".json"
			### determine the file format if we are importing keyword sets and groups
			if($apt_imported_data_type == 1){
				$apt_file_format = 1;
			}
			elseif($apt_imported_data_type == 2 or $apt_imported_data_type == 3){
				if(strstr($apt_imported_file['name'], $apt_backup_file_name_json_suffix)){
					$apt_file_format = 1;
				}
				if(strstr($apt_imported_file['name'], $apt_backup_file_name_csv_suffix)){
					$apt_file_format = 2;
				}
			} //-if

			$apt_imported_file_stream = fopen($apt_imported_file['tmp_name'], 'r');
			$apt_imported_file_string = stream_get_contents($apt_imported_file_stream);

			if($apt_imported_data_type == 1){ //settings
				$apt_imported_data_type_label = 'Plugin settings have';

				//continue only if the JSON file is valid
				if(json_decode($apt_imported_file_string, true) !== null){
					update_option('automatic_post_tagger', json_decode($apt_imported_file_string, true)); //save keyword sets
					apt_set_plugin_settings_information(1, 1);
					apt_set_plugin_settings_information(1, 2);
					apt_set_plugin_settings_information(2, 1);
					apt_set_plugin_settings_information(2, 2);
					apt_set_missing_suboptions();
					//TODO - remove redundant suboptions

					$apt_settings = get_option('automatic_post_tagger');
					apt_set_plugin_settings_information(3, apt_get_group_info($apt_settings['apt_default_group'], 2)); //select the new default group (this is here to suppress the "the previously used default group no longer exists" note, which is BS when importing plugin settings)

					echo $apt_message_html_prefix_updated .'Import complete. '. $apt_imported_data_type_label .' been overwritten with data from the imported file.'. $apt_message_html_suffix;
				}
				else{
					echo $apt_message_html_prefix_error .'<strong>Error:</strong> Import failed, because the imported JSON file was corrupted.'. $apt_message_html_suffix;
				}
			} //-if imported data type = 1

			if($apt_imported_data_type == 2){ //keyword sets
				$apt_items_array_new = get_option('automatic_post_tagger_keywords');
				$apt_imported_data_type_label = 'Keyword sets have';

				### overwite database option with imported data
				if($apt_file_format == 1){ //JSON
					//continue only if the JSON file is valid
					if(json_decode($apt_imported_file_string, true) !== null){
						update_option('automatic_post_tagger_keywords', json_decode($apt_imported_file_string, true)); //save keyword sets
						apt_set_plugin_settings_information(1, 1);
						apt_set_plugin_settings_information(1, 2);
						apt_nonexistent_groups_handling();
						apt_set_group_keyword_set_count(0, 3);

						echo $apt_message_html_prefix_updated .'Import complete. '. $apt_imported_data_type_label .' been overwritten with data from the imported file.'. $apt_message_html_suffix;
					}
					else{
						echo $apt_message_html_prefix_error .'<strong>Error:</strong> Import failed, because the imported JSON file was corrupted.'. $apt_message_html_suffix;
					}
				} //-if file export type = 1

				if($apt_file_format == 2){ //CSV
					$apt_imported_data_array = str_getcsv(stripslashes($apt_imported_file_string), "\n"); //remove backslashes and turn the string into an array; we are using str_getcsv instead of explode - it's better according to the manual
					$apt_import_result_array = apt_import_items_from_csv($apt_imported_data_array, 1);

					foreach($apt_import_result_array[0] as $apt_import_result_single_array){
						if(apt_array_item_check($apt_items_array_new, $apt_import_result_single_array[1]) === false){ //continue only if the item name doesn't exist yet
							array_push($apt_items_array_new, $apt_import_result_single_array);
						}
					} //-foreach

					$apt_imported_unique_items_number = count($apt_items_array_new) - $apt_settings['apt_keyword_sets_total']; //calculate the number of imported unique items

					if($apt_imported_unique_items_number > 0){ //we have imported something!
						update_option('automatic_post_tagger_keywords', $apt_items_array_new); //save keyword sets - this line must be placed before the count function in order to display correct stats
						apt_set_plugin_settings_information(1, 1);
						apt_set_plugin_settings_information(1, 2);
						apt_set_group_keyword_set_count(0, 3);

						echo $apt_message_html_prefix_updated .'Import complete. <strong>'. $apt_imported_unique_items_number .'</strong> '. apt_get_grammatical_number($apt_imported_unique_items_number, 1, 2) .' '. apt_get_grammatical_number($apt_imported_unique_items_number, 2) .' been imported.'. $apt_message_html_suffix;
					}
					else{
						echo $apt_message_html_prefix_note .'<strong>Note:</strong> No keyword sets with new (unique) term names have been imported.'. $apt_message_html_suffix;
					} //-else no keyword were imported

					//mistake warnings/errors
					if($apt_import_result_array[1][2] > 0){
						echo $apt_message_html_prefix_error .'<strong>Error:</strong> '. $apt_import_result_array[1][2] .' '. apt_get_grammatical_number($apt_import_result_array[1][2], 1, 8) .' couldn\'t be imported, because the CSV row structure was invalid.'. $apt_message_html_suffix;
					}

					if($apt_settings['apt_hide_warning_messages'] == 0 and $apt_imported_unique_items_number > 0){ //if warnings allowed and we have imported something
						if($apt_import_result_array[1][3] > 0){
							echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_import_result_array[1][3] .' '. apt_get_grammatical_number($apt_import_result_array[1][3], 1, 7) .' '. apt_get_grammatical_number($apt_import_result_array[1][4], 3) .' a space at the beginning or the end of the string.'. $apt_message_html_suffix;
						}
						if($apt_import_result_array[1][4] > 0){
							echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_import_result_array[1][4] .' '. apt_get_grammatical_number($apt_import_result_array[1][4], 1, 7) .' '. apt_get_grammatical_number($apt_import_result_array[1][4], 3) .' the wildcard character, but wildcard support is currently disabled!'. $apt_message_html_suffix;
						}
						if($apt_import_result_array[1][5] > 0){
							echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_import_result_array[1][5] .' '. 'term '. apt_get_grammatical_number($apt_import_result_array[1][5], 1, 10) .' '. apt_get_grammatical_number($apt_import_result_array[1][5], 3) .' a space at the beginning or the end of the string.'. $apt_message_html_suffix;
						}
					} //-if warnings allowed
				} //-if imported file format = 2
			} //-if imported data type = 2

			if($apt_imported_data_type == 3){ //groups
				$apt_items_array_new = get_option('automatic_post_tagger_groups');
				$apt_imported_data_type_label = 'Configuration groups sets have';

				### overwite database option with imported data
				if($apt_file_format == 1){ //JSON
					//continue only if the JSON file is valid
					if(json_decode($apt_imported_file_string, true) !== null){
						update_option('automatic_post_tagger_groups', json_decode($apt_imported_file_string, true)); //save configuration groups
						apt_set_plugin_settings_information(2, 1);
						apt_set_plugin_settings_information(2, 2);
						apt_set_plugin_settings_information(3); //check whether the default group exists, if not, select a new default group
						apt_nonexistent_groups_handling();
						apt_set_group_keyword_set_count(0, 3);

						echo $apt_message_html_prefix_updated .'Import complete. '. $apt_imported_data_type_label .' been overwritten with data from the imported file.'. $apt_message_html_suffix;
					}
					else{
						echo $apt_message_html_prefix_error .'<strong>Error:</strong> Import failed, because the imported JSON file was corrupted.'. $apt_message_html_suffix;
					}
				} //-if file export type = 1

				if($apt_file_format == 2){ //CSV
					$apt_imported_data_array = str_getcsv(stripslashes($apt_imported_file_string), "\n"); //remove backslashes and turn the string into an array; we are using str_getcsv instead of explode - it's better according to the manual
					$apt_import_result_array = apt_import_items_from_csv($apt_imported_data_array, 2);

					foreach($apt_import_result_array[0] as $apt_import_result_single_array){
						if(apt_array_item_check($apt_items_array_new, $apt_import_result_single_array[1]) === false){ //continue only if the item name doesn't exist yet
							array_push($apt_items_array_new, $apt_import_result_single_array);
						}
					} //-foreach

					$apt_imported_unique_items_number = count($apt_items_array_new) - $apt_settings['apt_configuration_groups_total']; //calculate the number of imported unique items

					if($apt_imported_unique_items_number > 0){ //we have imported something!
						update_option('automatic_post_tagger_groups', $apt_items_array_new); //save configuration groups - this line must be placed before the count function in order to display correct stats
						apt_set_plugin_settings_information(2, 1);
						apt_set_plugin_settings_information(2, 2);
						apt_set_group_keyword_set_count(0, 3);

						echo $apt_message_html_prefix_updated .'Import complete. <strong>'. $apt_imported_unique_items_number .'</strong> '. apt_get_grammatical_number($apt_imported_unique_items_number, 1, 1) .' '. apt_get_grammatical_number($apt_imported_unique_items_number, 2) .' been imported.'. $apt_message_html_suffix;
					}
					else{
						echo $apt_message_html_prefix_note .'<strong>Note:</strong> No configuration groups with new (unique) names have been imported.'. $apt_message_html_suffix;
					} //-else no group were imported

					//mistake warnings/errors
					if($apt_import_result_array[1][2] > 0){
						echo $apt_message_html_prefix_error .'<strong>Error:</strong> '. $apt_import_result_array[1][2] .' '. apt_get_grammatical_number($apt_import_result_array[1][2], 1, 8) .' couldn\'t be imported, because the CSV row structure was invalid.'. $apt_message_html_suffix;
					}

					if($apt_settings['apt_hide_warning_messages'] == 0 and $apt_imported_unique_items_number > 0){ //if warnings allowed and we have imported something
						if($apt_import_result_array[1][3] > 0){
							echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_import_result_array[1][3] .' '. apt_get_grammatical_number($apt_import_result_array[1][2], 1, 6) .' '. apt_get_grammatical_number($apt_import_result_array[1][2], 3) .' a space at the beginning or the end of the string.'. $apt_message_html_suffix;
						}
						if($apt_import_result_array[1][5] > 0){
							echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_import_result_array[1][5] .' '. 'group '. apt_get_grammatical_number($apt_import_result_array[1][5], 1, 10) .' '. apt_get_grammatical_number($apt_import_result_array[1][5], 3) .' a space at the beginning or the end of the string.'. $apt_message_html_suffix;
						}
					} //-if warnings allowed

				} //-if imported file format = 2
			} //-if imported data type = 3


			fclose($apt_imported_file_stream); //close the file
			unlink($apt_imported_file['tmp_name']); //remove the file from the directory
		} //-if
		else{ //the file name is invalid
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The name of the imported file must have the suffix "<strong>'. $apt_backup_file_name_csv_suffix .'</strong>" or "<strong>'. $apt_backup_file_name_json_suffix .'</strong>".'. $apt_message_html_suffix;
		} //-else
	}
	else{ //file can't be uploaded
		echo $apt_message_html_prefix_error .'<strong>Error:</strong> The file couldn\'t be uploaded.'. $apt_message_html_suffix;
	} //-else
}

## ===================================
## ### MISCELLANEOUS
## ===================================

/**
 * Case insensitive string comparison of sub-array elements - used for sorting keywords
 *
 * @param	string	$a
 * @param	string	$b
 * @return	int
 */
function apt_sort_items($a, $b){
	return strnatcasecmp($a[1], $b[1]);
}

/**
 * Determines whether an item exists in an array (case-insensitive search)
 *
 * @param	string	$apt_haystack_array
 * @param	string	$apt_needle
 * @return	bool
 */
function apt_array_item_check($apt_haystack_array, $apt_needle){
	$apt_item_exists = false;

	foreach($apt_haystack_array as $apt_haystack_single){ //process all elements of the array
		if(strtolower($apt_haystack_single[1]) == strtolower($apt_needle)){ //check whether the strtolowered item already exists in the array
			$apt_item_exists = true;
			break; //stop the loop
		}
	} //-foreach

	return $apt_item_exists;
}

/**
 * Returns the correct grammatical number (e.g. "XYZ *groups* *have* been deleted")
 *
 * @param 	false|int|string	$apt_integer		Number of items
 * @param 	int					$apt_word_type		Noun or a verb with its correct grammatical number
 * @param 	false|int			$apt_noun			ID of the specific noun
 * @return	string	
 */
function apt_get_grammatical_number($apt_integer = false, $apt_word_type, $apt_noun = false){
	### determine which noun should be returned
	if($apt_noun == 1){
		$apt_grammatical_number_noun_singular = 'configuration group';
		$apt_grammatical_number_noun_plural = 'configuration groups';
	}
	elseif($apt_noun == 2){
		$apt_grammatical_number_noun_singular = 'keyword set';
		$apt_grammatical_number_noun_plural = 'keyword sets';
	}
	elseif($apt_noun == 3){
		$apt_grammatical_number_noun_singular = 'set';
		$apt_grammatical_number_noun_plural = 'sets';
	}
	elseif($apt_noun == 4){
		$apt_grammatical_number_noun_singular = 'term';
		$apt_grammatical_number_noun_plural = 'terms';
	}
	elseif($apt_noun == 5){
		$apt_settings = get_option('automatic_post_tagger');

		$apt_grammatical_number_noun_singular = 'the taxonomy "<strong>'. implode($apt_settings['apt_string_separator'], $apt_settings['apt_taxonomies']) .'</strong>"';
		$apt_grammatical_number_noun_plural = 'taxonomies "<strong>'. implode('</strong>&quot;'. $apt_settings['apt_string_separator'] .' &quot;<strong>', $apt_settings['apt_taxonomies']) .'</strong>"';
	}
	elseif($apt_noun == 6){
		$apt_grammatical_number_noun_singular = 'taxonomy';
		$apt_grammatical_number_noun_plural = 'taxonomies';
	}
	elseif($apt_noun == 7){
		$apt_grammatical_number_noun_singular = 'related keyword';
		$apt_grammatical_number_noun_plural = 'related keywords';
	}
	elseif($apt_noun == 8){
		$apt_grammatical_number_noun_singular = 'item';
		$apt_grammatical_number_noun_plural = 'items';
	}
	elseif($apt_noun == 9){
		$apt_grammatical_number_noun_singular = 'group';
		$apt_grammatical_number_noun_plural = 'groups';
	}
	elseif($apt_noun == 10){
		$apt_grammatical_number_noun_singular = 'name';
		$apt_grammatical_number_noun_plural = 'names';
	}
	elseif($apt_noun == 11){
		$apt_grammatical_number_noun_singular = 'hour';
		$apt_grammatical_number_noun_plural = 'hours';
	}
	elseif($apt_noun == 12){
		$apt_grammatical_number_noun_singular = 'second';
		$apt_grammatical_number_noun_plural = 'seconds';
	}

	### return a noun
	if($apt_word_type == 1 and $apt_noun !== false){
		if($apt_integer > 1 or $apt_integer == 0){ //plural form
			return $apt_grammatical_number_noun_plural;
		}
		else{ //singular form
			return $apt_grammatical_number_noun_singular;
		}
	} //-if

	### return a verb
	elseif($apt_integer > 1 or $apt_integer == 0){ //plural form
		if($apt_word_type == 2){
			return 'have';
		}
		if($apt_word_type == 3){
			return 'contain';
		}
	}
	elseif($apt_integer == 1){ //singular form
		if($apt_word_type == 2){
			return 'has';
		}
		if($apt_word_type == 3){
			return 'contains';
		}
	}
	else{
		return '<strong>n/a</strong>';
	}
}

/**
 * Prints a part of a SQL command that is used for retrieving post IDs for bulk tagging (the SQL command returns IDs of posts with specified post statuses and post types)
 *
 * @return	string
 */
function apt_get_allowed_post_types_statuses_sql(){
	global $wpdb;

	$apt_settings = get_option('automatic_post_tagger');

	//if no post statuses are set, don't add them to the SQL query
	if(empty($apt_settings['apt_post_statuses'])){
		return '1=0'; //disable any further changes, as there are no allowed post types.
	}
	else{
		$apt_post_statuses_escaped = ''; //this is here to prevent the notice "Undefined variable"

		//adding all post statuses to a variable
		foreach($apt_settings['apt_post_statuses'] as $apt_post_status){
			$apt_post_statuses_escaped .= $wpdb->prepare('%s', $apt_post_status) . ','; //add array values to a string and separate them by a comma
		}

		//now we need to remove the last "," part from the end of the string
		$apt_post_statuses_escaped_sql = substr($apt_post_statuses_escaped, 0, -1);
	}

	//if no post types are set, don't add them to the SQL query
	if(empty($apt_settings['apt_post_types'])){
		return '1=0'; //disable any further changes, as there are no allowed post types.
	}
	else{
		$apt_post_types_escaped = ''; //this is here to prevent the notice "Undefined variable"

		//adding all post types to a variable
		foreach($apt_settings['apt_post_types'] as $apt_post_type){
			$apt_post_types_escaped .= $wpdb->prepare('%s', $apt_post_type) . ','; //add array values to a string and separate them by a comma
		}

		//now we need to remove the last "," part from the end of the string
		$apt_post_types_escaped_sql = substr($apt_post_types_escaped, 0, -1);
	}

	return 'post_type IN ('. $apt_post_types_escaped_sql .') and post_status IN ('. $apt_post_statuses_escaped_sql .')';
}

/**
 * Returns a unique name of a new backup file
 *
 * @param	int			$apt_data_type		1: json|2: csv
 * @param	int			$apt_file_format	1: settings|2: keyword sets|3: groups
 * @return	string|bool
 */
function apt_get_backup_file_name($apt_data_type, $apt_file_format){
	global $apt_backup_file_name_csv_suffix,
	$apt_backup_file_name_json_suffix,
	$apt_backup_dir_rel_path;

	if((!isset($apt_data_type) and !in_array($apt_data_type, array(1, 2, 3))) or (!isset($apt_file_format) and !in_array($apt_file_format, array(1, 2)))){
		return;
	}

	if($apt_file_format == 1){
		$apt_backup_file_name_suffix = $apt_backup_file_name_json_suffix;
	}
	if($apt_file_format == 2){
		$apt_backup_file_name_suffix = $apt_backup_file_name_csv_suffix;
	}

	### load the backup file prefix according to its type
	if($apt_data_type == 1){
		global $apt_backup_file_name_prefix_plugin_settings;
		$apt_backup_file_prefix = $apt_backup_file_name_prefix_plugin_settings;
	}
	if($apt_data_type == 2){
		global $apt_backup_file_name_prefix_keyword_sets;
		$apt_backup_file_prefix = $apt_backup_file_name_prefix_keyword_sets;
	}
	if($apt_data_type == 3){
		global $apt_backup_file_name_prefix_configuration_groups;
		$apt_backup_file_prefix = $apt_backup_file_name_prefix_configuration_groups;
	}

	//check whether the backup directory exists
	if(is_dir($apt_backup_dir_rel_path)){
		$apt_file_permissions = intval(substr(sprintf('%o', fileperms($apt_backup_dir_rel_path)), -4));
		if($apt_file_permissions != 755){ //check whether the directory permissions aren't 755
			@chmod($apt_backup_dir_rel_path, 0755); //change permissions
		} //permissions lower than X
	} //directory exists
	else{ //directory doesn't exist
		@mkdir($apt_backup_dir_rel_path, 0755); //create the directory
	}

	if(chdir($apt_backup_dir_rel_path)){ //continue only if the current directory can be changed to the backup directory
		$apt_existing_backup_files = glob($apt_backup_file_prefix .'-*_v*'. $apt_backup_file_name_suffix); //if the file name structure is changed, this has to be changed as well
		$apt_existing_backup_files_count = count($apt_existing_backup_files);

		//check only if some backup files exist
		if($apt_existing_backup_files_count > 0){
			$apt_existing_file_ids = array();
			//extract the number from the file name and push it to an array
			foreach($apt_existing_backup_files as $apt_backup_file_name){
				if(preg_match('/apt-.+-(\d+)_v.+/', $apt_backup_file_name, $apt_current_file_id)){ //extract the numeric ID from a file if it exists - "(\d+)" is the capturing group  //if the file name structure is changed, this has to be changed as well
					$apt_existing_file_ids[] = $apt_current_file_id[1]; //add the captured ID to the array
				}
			} //-foreach

			//assign the [0] index to the the highest ID
			array_multisort($apt_existing_file_ids, SORT_NUMERIC, SORT_DESC);

			//generate new id
			$apt_new_file_id = $apt_existing_file_ids[0]+1;
		} //-some backup files currently exist
		else{ 
			$apt_new_file_id = 1; //the ID of the new backup file is 1
		}

		$apt_new_backup_file_name = $apt_backup_file_prefix .'-'. $apt_new_file_id .'_v'. str_replace('.', '-', apt_get_plugin_version()) .'_'. time() . $apt_backup_file_name_suffix; //if the file name structure is changed, this has to be changed as well

		return $apt_new_backup_file_name;
	} //-directory can be changed
	else{
		return false; //if the directory can't be changed, return false
	}
}

/**
 * Returns various information about keyword sets (case-insensitive name search)
 *
 * @param	int|string	$apt_function_input		Keyword id or name
 * @param	int			$apt_information_type	Information type
 * @return	int|bool	$apt_result
 */
function apt_get_keyword_info($apt_function_input, $apt_information_type){
	$apt_kw_sets = get_option('automatic_post_tagger_keywords');
	$apt_result = false; //false will be returned if the keyword doesn't exist

	if(isset($apt_function_input) and in_array($apt_information_type, array(1, 2))){
		foreach($apt_kw_sets as $apt_keyword){
			if($apt_information_type == 1 and strtolower($apt_function_input) == strtolower($apt_keyword[1])){ ///accept the term name, return the id
				$apt_result = $apt_keyword[0];
				break;
			}
			if($apt_information_type == 2 and $apt_function_input == $apt_keyword[0]){ //accept the keyword id, return the name
				$apt_result = $apt_keyword[1];
				break;
			}
		} //-foreach
	} //-if FM = 1
	else{
		$apt_result = 'n/a'; //if the function mode is invalid
	}

	return $apt_result;
}

/**
 * Updates various information in the plugin settings option
 *
 * @param	int					$apt_data_type			Data type (1: keyword sets|2: configuration groups|3: default group)
 * @param	int|bool|string		$apt_information_type	Information type (1: update item count|2: update highest item ID |false: randomly select the default group|string: update the default group based on the provided old group name)
 */
function apt_set_plugin_settings_information($apt_data_type, $apt_information_type = false){
	$apt_settings = get_option('automatic_post_tagger');

	if($apt_data_type == 1){
		$apt_data_array = get_option('automatic_post_tagger_keywords');
	} //-if
	if($apt_data_type == 2 or $apt_data_type == 3){
		$apt_data_array = get_option('automatic_post_tagger_groups');
	} //-if

	### update item count
	if($apt_information_type == 1){
		$apt_item_count = count($apt_data_array);

		if($apt_data_type == 1){
			$apt_settings['apt_keyword_sets_total'] = $apt_item_count;
		} //-if
		if($apt_data_type == 2){
			$apt_settings['apt_configuration_groups_total'] = $apt_item_count;
		} //-if

		update_option('automatic_post_tagger', $apt_settings); //save settings
	} //-if

	### update highest item ID
	if($apt_information_type == 2){
		$apt_items_ids_array = array('0'); //if no data array items exist, the highest ID will be a zero

		//add item IDs to an array
		foreach($apt_data_array as $apt_data_single_array){
			array_push($apt_items_ids_array, $apt_data_single_array[0]);
		}

		if($apt_data_type == 1){
			$apt_settings['apt_highest_keyword_set_id'] = max($apt_items_ids_array);
		} //-if
		if($apt_data_type == 2){
			$apt_settings['apt_highest_configuration_group_id'] = max($apt_items_ids_array);
		} //-if

		update_option('automatic_post_tagger', $apt_settings); //save settings
	} //-if

	### update the default group
	if($apt_data_type == 3){
		global $apt_message_html_suffix, $apt_message_html_prefix_note, $apt_message_html_prefix_warning;

		### get the old group id from its name; if the group isn't provided (= false), the old id will be "false"
		if($apt_information_type !== false){
			$apt_old_default_group_new_id = apt_get_group_info($apt_information_type, 1);
		}
		else{
			$apt_old_default_group_new_id = false;
		}

		if($apt_old_default_group_new_id === false){ //check whether the id of the old default group is valid
			$apt_random_array_key = array_rand($apt_data_array, 1); //get the random group array key
			$apt_settings['apt_default_group'] = $apt_data_array[$apt_random_array_key][0]; //get the id of the randomly picked group
			update_option('automatic_post_tagger', $apt_settings); //save settings

			echo $apt_message_html_prefix_note .'<strong>Note:</strong> The configuration group "<strong>'. $apt_data_array[$apt_random_array_key][1] .'</strong>" has been randomly selected to serve as the default group, because the previously used one no longer exists.'. $apt_message_html_suffix;
		}
		else{
			$apt_settings['apt_default_group'] = $apt_old_default_group_new_id; //get the id of old group and retain it as the new default group id - this is necessary, otherwise the id won't be automatically changed when importing
			update_option('automatic_post_tagger', $apt_settings); //save settings
		} //-else group id invalid
	} //-if
}

/**
 * Returns various information about groups (case-insensitive name search)
 *
 * @param	int|string	$apt_function_input		Group id|name
 * @param	int			$apt_information_type	Information type (1|2|3|4|5|6)
 * @return	int|bool	$apt_result
 */
function apt_get_group_info($apt_function_input, $apt_information_type){
	$apt_groups = get_option('automatic_post_tagger_groups');
	$apt_result = false; //false will be returned if the group doesn't exist

	if(isset($apt_function_input) and in_array($apt_information_type, array(1, 2, 3, 4, 5, 6))){
		foreach($apt_groups as $apt_group){
			if($apt_information_type == 1 and strtolower($apt_function_input) == strtolower($apt_group[1])){ //accept the group name, return the id
				$apt_result = $apt_group[0];
				break;
			}
			if($apt_information_type == 2 and $apt_function_input == $apt_group[0]){ //accept the group id, return the name
				$apt_result = $apt_group[1];
				break;
			}
			if($apt_information_type == 3 and $apt_function_input == $apt_group[0]){ //accept the group id, return the keyword count
				$apt_result = $apt_group[2];
				break;
			}
			if($apt_information_type == 4 and $apt_function_input == $apt_group[0]){ //accept the group id, return the group status
				$apt_result = $apt_group[3];
				break;
			}
			if($apt_information_type == 5 and $apt_function_input == $apt_group[0]){ //accept the group id, return the term limit
				$apt_result = $apt_group[4];
				break;
			}
			if($apt_information_type == 6 and $apt_function_input == $apt_group[0]){ //accept the group id, return taxonomies
				$apt_result = $apt_group[5];
				break;
			}
		} //-foreach
	}

	return $apt_result;
}

/**
 * Moves keyword sets to the default group or deletes them if their group doesn't exist
 *
 * @param	array	$apt_old_groups_array	Old group array with old IDs, generated before new IDs were assigned (used to assign groups to keyword sets according to their old group names that now have new group IDs)
 */
function apt_nonexistent_groups_handling($apt_old_groups_array = array()){
	global $apt_message_html_prefix_note,
	$apt_message_html_suffix;

	$apt_settings = get_option('automatic_post_tagger');

	if($apt_settings['apt_keyword_sets_total'] > 0){ //continue only if there are keyword sets
		$apt_kw_sets = get_option('automatic_post_tagger_keywords');
		$apt_groups = get_option('automatic_post_tagger_groups');

		$apt_groups_count1 = count($apt_old_groups_array);
		$apt_groups_count2 = count($apt_groups);
		$apt_processed_kw_sets = 0;

		foreach($apt_kw_sets as $apt_key => $apt_keyword_sets_single_array){
			$apt_keyword_set_current_group_id = $apt_keyword_sets_single_array[3];
			$apt_keyword_set_current_name = $apt_keyword_sets_single_array[1];

			//continue only if the current group ID is invalid
			if(apt_get_group_info($apt_keyword_set_current_group_id, 2) === false){

				//continue only if we have the array with old groups
				if(!empty($apt_old_groups_array)){
					$apt_array_iteration1 = 0;
					foreach($apt_old_groups_array as $apt_old_group_single_array){
						$apt_array_iteration1++;

						$apt_old_group_id = $apt_old_group_single_array[0];
						$apt_old_group_name = $apt_old_group_single_array[1];

						$apt_array_iteration2 = 0;
						foreach($apt_groups as $apt_groups_single_array){
							$apt_array_iteration2++;
							$apt_current_group_id = $apt_groups_single_array[0];
							$apt_current_group_name = $apt_groups_single_array[1];

//print("KW name: <b>". $apt_keyword_set_current_name  ."</b> KW group id: ". $apt_keyword_set_current_group_id); //for debugging
//print(" | OLD group ARRAY name: ". $apt_old_group_name . " current ARRAY group name: ". $apt_current_group_name ."<br>"); //for debugging

							//try to find the group name in the new group array 
							if($apt_old_group_name == $apt_current_group_name and $apt_old_group_id == $apt_keyword_set_current_group_id){
//print("--- NAME changed to $apt_old_group_name <br>"); //for debugging
								$apt_kw_sets[$apt_key][3] = apt_get_group_info($apt_old_group_name, 1); //assign the new group id to the keyword based on the name from the old group array
								break 2;
							}

							if($apt_groups_count2 == $apt_array_iteration2){
//print("--- LAST current group array item, no old group name found, going to the next old group name<br>"); //for debugging
								break;
							}
						} //-foreach - current groups

						if($apt_groups_count1 == $apt_array_iteration1){
								if($apt_settings['apt_nonexistent_groups_handling'] == 1){
//print("--- LAST old group array item, no old group name found, assigning default group name<br>"); //for debugging
									$apt_kw_sets[$apt_key][3] = $apt_settings['apt_default_group']; //assign default group id
								}
								else{
//print("--- kw set deleted<br>"); //for debugging
									unset($apt_kw_sets[$apt_key]); //delete keyword set
								}

							$apt_processed_kw_sets++;
							break;
						}
					} //-foreach - old groups
				}
				else{
					if($apt_settings['apt_nonexistent_groups_handling'] == 1){
//print("--- old group array empty, assigning default group name<br>"); //for debugging
						$apt_kw_sets[$apt_key][3] = $apt_settings['apt_default_group']; //assign default group id
					}
					else{
//print("--- kw set deleted<br>"); //for debugging
						unset($apt_kw_sets[$apt_key]); //delete keyword set
					}

					$apt_processed_kw_sets++;
				} //-else
			} //-if group id invalid
		} //-foreach

		update_option('automatic_post_tagger_keywords', $apt_kw_sets);

		### confirmation messages if keywords were processed
		if($apt_processed_kw_sets > 0){
			if($apt_settings['apt_nonexistent_groups_handling'] == 1){
				echo $apt_message_html_prefix_note .'<strong>Note: '. $apt_processed_kw_sets .'</strong> '. apt_get_grammatical_number($apt_processed_kw_sets, 1, 2) .' belonging to nonexistent '. apt_get_grammatical_number($apt_processed_kw_sets, 1, 1) .' '. apt_get_grammatical_number($apt_processed_kw_sets, 2) .' been moved to the default group "<strong>'. apt_get_group_info($apt_settings['apt_default_group'], 2) .'</strong>".'. $apt_message_html_suffix;
			}
			else{
				apt_set_plugin_settings_information(1, 1);
				echo $apt_message_html_prefix_note .'<strong>Note: '. $apt_processed_kw_sets .'</strong> '. apt_get_grammatical_number($apt_processed_kw_sets, 1, 2) .' belonging to nonexistent '. apt_get_grammatical_number($apt_processed_kw_sets, 1, 1) .' '. apt_get_grammatical_number($apt_processed_kw_sets, 2) .' been deleted. <span class="apt_help" title="If you don\'t want the plugin to automatically remove keyword sets belonging to nonexistent groups, change the option &quot;Nonexistent groups handling&quot;.">i</span>'. $apt_message_html_suffix;
			}
		} //-if keyword sets were processed
	} //-if there are keyword sets
}

/**
 * Updates keyword set count in groups
 *
 * @param	int	$apt_group_id			Group id
 * @param	int	$apt_information_type	Information type (1|2|3|4)
 */
function apt_set_group_keyword_set_count($apt_group_id, $apt_information_type){
	$apt_groups_new = get_option('automatic_post_tagger_groups');

	### if the group ID is 0, all groups will be processed
	if($apt_group_id == 0){
		$apt_group_id_queue = array();

		foreach($apt_groups_new as $apt_group){
			array_push($apt_group_id_queue, $apt_group[0]); //push the group ID to the queue
		} //-foreach
	}
	else{
		$apt_group_id_queue = array($apt_group_id);
	} //-else only one group

	### loop handling all group IDs in the queue
	foreach($apt_group_id_queue as $apt_single_group_id){
		### the keyword set count will be incremented
		if($apt_information_type == 1){
			foreach($apt_groups_new as $apt_group => $apt_group_data){
				if($apt_single_group_id == $apt_group_data[0]){
					$apt_groups_new[$apt_group][2]++;
					break;
				}
			} //-foreach
		} //-if

		### the keyword set count will be decremented
		if($apt_information_type == 2){
			foreach($apt_groups_new as $apt_group => $apt_group_data){
				if($apt_single_group_id == $apt_group_data[0]){
					$apt_groups_new[$apt_group][2]--;
					break;
				}
			} //-foreach
		} //-if

		### the keyword set count will be recounted
		if($apt_information_type == 3){
			$apt_kw_sets = get_option('automatic_post_tagger_keywords');
			$apt_group_keyword_set_count = 0;

			//increase the variable for every keyword in the particular group
			foreach($apt_kw_sets as $apt_keyword){
				if($apt_keyword[3] == $apt_single_group_id){
					$apt_group_keyword_set_count++;
				}
			} //-foreach

			foreach($apt_groups_new as $apt_group => $apt_group_data){
				if($apt_single_group_id == $apt_group_data[0]){
					$apt_groups_new[$apt_group][2] = $apt_group_keyword_set_count;
					break;
				}
			} //-foreach
		} //-if

		### the keyword set count will be reset to 0
		if($apt_information_type == 4){
			foreach($apt_groups_new as $apt_group => $apt_group_data){
				if($apt_single_group_id == $apt_group_data[0]){
					$apt_groups_new[$apt_group][2] = 0;
					break;
				}
			} //-foreach
		} //-if
	} //-foreach group id queue

	update_option('automatic_post_tagger_groups', $apt_groups_new);
}

/**
 * Prints the <option> elements for groups
 *
 * @param	int	$apt_group_id	Group ID
 */
function apt_display_group_option_list($apt_group_id){
	$apt_groups = get_option('automatic_post_tagger_groups');

	foreach($apt_groups as $apt_group){
		echo '<option value="'. $apt_group[0] .'"';
			if($apt_group[0] == $apt_group_id){
				echo ' selected="selected"';
			}
		echo '>'. $apt_group[1] .'</option>';
	} //-foreach
}

/**
 * Returns the number of errors preventing the plugin from tagging posts
 *
 * @param 	int	$apt_display_messages
 * @return	int	$apt_bulk_tagging_errors
 */
function apt_get_tagging_errors($apt_display_messages = 1){
	global $wpdb,
	$apt_message_html_prefix_error,
	$apt_message_html_suffix;

	$apt_settings = get_option('automatic_post_tagger');
	$apt_groups = get_option('automatic_post_tagger_groups');
	$apt_bulk_tagging_errors = 0;

	//this doesn't have to be run in the apt_single_post_tagging function //TODO?
	if($wpdb->get_var('SELECT COUNT(ID) FROM '. $wpdb->posts .' WHERE '. apt_get_allowed_post_types_statuses_sql()) == 0){
		$apt_bulk_tagging_errors++;

		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> There aren\'t any processable posts. <span class="apt_help" title="Your current settings and/or the lack of processable posts prevent the tagging tool from being run.">i</span>'. $apt_message_html_suffix;
		}
	}
	if($apt_settings['apt_keyword_sets_total'] == 0){
		$apt_bulk_tagging_errors++;

		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> There are no keyword sets.'. $apt_message_html_suffix;
		}
	}
	if(!preg_match('/^[1-9][0-9]*$/', $apt_settings['apt_taxonomy_term_limit'])){ //positive integers only
		$apt_bulk_tagging_errors++;

		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The post term limit must be a positive integer.'. $apt_message_html_suffix;
		}
	}
	if(($apt_settings['apt_title'] == 0 and $apt_settings['apt_content'] == 0 and $apt_settings['apt_excerpt'] == 0) or ($apt_settings['apt_substring_analysis'] == 1 and $apt_settings['apt_substring_analysis_length'] == 0)){
		$apt_bulk_tagging_errors++;

		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The plugin isn\'t allowed to analyze any content.'. $apt_message_html_suffix;
		}
	}
	if($apt_settings['apt_search_for_term_name'] == 0 and $apt_settings['apt_search_for_related_keywords'] == 0){
		$apt_bulk_tagging_errors++;

		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The plugin isn\'t allowed to search for any keyword set items.'. $apt_message_html_suffix;
		}
	}

	### calculate the number of groups that can be used for tagging
	$apt_number_of_valid_groups = 0;
	foreach($apt_groups as $apt_group){
		//if the group has keywords, is enabled, the term limit is higher than 0, and has taxonomies (they don't have to be valid, this will be checked in the apt_single_post_tagging function)
		if($apt_group[2] > 0 and $apt_group[3] == 1 and $apt_group[4] > 0 and !empty($apt_group[5])){
			$apt_number_of_valid_groups = 1;
			break; //no need to continue, at least one valid group exists 
		}
	} //-foreach

	if($apt_number_of_valid_groups == 0){
		$apt_bulk_tagging_errors++;

		if($apt_display_messages == 1){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> There are no configuration groups which keyword sets can be used for tagging.'. $apt_message_html_suffix;
		}
	}

	return $apt_bulk_tagging_errors;
}

## =========================================================================
## ### TAGGING FUNCTIONS
## =========================================================================

/**
 * Adds terms to a post
 *
 * @param	int	$apt_post_id		Post id
 * @param	int	$apt_mistake_checks	Check mistake scenarios
 * @param	int	$apt_return_stats	Return the number of terms added to a post
 * @return	void|int				Returns void or the number of terms added to a post
 */
function apt_single_post_tagging($apt_post_id, $apt_mistake_checks = 1, $apt_return_stats = 0){
	global $wpdb;

	$apt_settings = get_option('automatic_post_tagger');

	#################################################################
	### stopping execution to prevent the function from doing unuseful job PART 1
	//we do not have the ID of the post, stop!
	if ($apt_post_id === false or $apt_post_id == null){
		return;
	}
	//the current post type isn't allowed, stop!
	if(!in_array(get_post_type($apt_post_id), $apt_settings['apt_post_types'])){
		return;
	}
	//the current post status isn't allowed, stop!
	if(!in_array(get_post_status($apt_post_id), $apt_settings['apt_post_statuses'])){
		return;
	}

	//if the second argument == 0, don't check mistake scenarios again - useful when we are using the bulk tagging tool; check whether other errors occurred
	if($apt_mistake_checks == 1 and apt_get_tagging_errors(0) > 0){
		return;
	}
	#################################################################

	### variables
	$apt_groups = get_option('automatic_post_tagger_groups');
	$apt_selected_groups_data_array = array();
	$apt_taxonomies_with_found_terms_array = array();
	$apt_found_term_names_array_global = array(); //used for checking whether a keyword set has been already found
	$apt_number_of_added_terms_total = 0;
	$apt_number_of_tagging_loop_iterations = 0; //if OTH = 2, we need to make sure terms are replaced only in the first iteration of the loop
//$apt_search_iterations = 0; //for debugging

	### fill the array with group data and another array with taxonomies
	foreach($apt_groups as $apt_group){
		### load taxonomies only if the group has keywords, is enabled, the term limit is higher than 0, and has taxonomies
		if($apt_group[2] > 0 and $apt_group[3] == 1 and $apt_group[4] > 0 and !empty($apt_group[5])){
			foreach($apt_group[5] as $apt_single_taxonomy){
				array_push($apt_selected_groups_data_array, array($apt_group[0], $apt_group[4], $apt_single_taxonomy)); //group id, group term limit, taxonomy name

				### add all taxonomies to an extra array, so that the terms can be added to posts at once
				if(empty($apt_taxonomies_with_found_terms_array)){ //the array is still empty, add the first item
					array_push($apt_taxonomies_with_found_terms_array, array($apt_single_taxonomy, array()));
				}
				else{ //array is not empty, we need to make sure only unique values are added
					$apt_foreach_iteration = 0;
					foreach($apt_taxonomies_with_found_terms_array as $apt_single_taxonomy_with_found_terms_array){
						$apt_foreach_iteration++;

						 //if the taxonomy already exists in the array, no need to continue; if it doesn't, continue to the next iteration
						if($apt_single_taxonomy == $apt_single_taxonomy_with_found_terms_array[0]){
							break;
						}

						//if this is the last foreach iteration and the taxonomy still isn't in the array, add it there
						if(count($apt_taxonomies_with_found_terms_array) == $apt_foreach_iteration){
							array_push($apt_taxonomies_with_found_terms_array, array($apt_single_taxonomy, array()));
						} //-if
					} //-foreach
				} //-else
			} //-foreach
		} //-if
	} //-foreach

//die(print_r($apt_taxonomies_with_found_terms_array)); //for debugging

	if(empty($apt_selected_groups_data_array)){
		return; //no group data could be retrieved, end the execution
	}

	### prepare analyzed content
	$apt_haystack_string = '';

	//we need to find out what APT should analyze
	if($apt_settings['apt_title'] == 1){ //include title
		$apt_post_title = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE ID = $apt_post_id LIMIT 1");
		$apt_haystack_string = $apt_haystack_string .' '. $apt_post_title;
	}
	if($apt_settings['apt_content'] == 1){ //include content
		$apt_post_content = $wpdb->get_var("SELECT post_content FROM $wpdb->posts WHERE ID = $apt_post_id LIMIT 1");
		$apt_haystack_string = $apt_haystack_string .' '. $apt_post_content;
	}
	if($apt_settings['apt_excerpt'] == 1){ //include excerpt
		$apt_post_excerpt = $wpdb->get_var("SELECT post_excerpt FROM $wpdb->posts WHERE ID = $apt_post_id LIMIT 1");
		$apt_haystack_string = $apt_haystack_string .' '. $apt_post_excerpt;
	}
	if($apt_settings['apt_substring_analysis'] == 1){ //analyze only a part of the post
		$apt_haystack_string = substr($apt_haystack_string, $apt_settings['apt_substring_analysis_start'], $apt_settings['apt_substring_analysis_length']);
	}

	//preparing the haystack for searching
	if($apt_settings['apt_ignore_case'] == 1){
		$apt_haystack_string = strtolower($apt_haystack_string); //make it lowercase
	}
	if($apt_settings['apt_strip_tags'] == 1){
		$apt_haystack_string = wp_strip_all_tags($apt_haystack_string); //remove HTML, PHP and JS tags
	}
	if($apt_settings['apt_decode_html_entities_analyzed_content'] == 1){
		$apt_haystack_string = html_entity_decode($apt_haystack_string); //decode HTML entities
	}
	if($apt_settings['apt_replace_nonalphanumeric'] == 1){
		$apt_haystack_string = preg_replace('/[^a-zA-Z0-9]/', ' ', $apt_haystack_string); //replace all non-alphanumeric-characters with spaces
	}
	if($apt_settings['apt_replace_whitespaces'] == 1){
		$apt_haystack_string = preg_replace('/\s/', ' ', $apt_haystack_string); //replace whitespace characters with a space
	}

	$apt_haystack_string = ' '. $apt_haystack_string .' '; //we need to add a space before and after the string: the engine is looking for ' string ' (with space at the beginning and the end, so it won't find e.g. ' ice ' in a word ' iceman ')

	### process each taxonomy separately
	foreach($apt_selected_groups_data_array as $apt_single_group_data){
		$apt_number_of_tagging_loop_iterations++;
		$apt_single_taxonomy_name = $apt_single_group_data[2];

		$apt_post_current_terms = wp_get_post_terms($apt_post_id, $apt_single_taxonomy_name, array('fields' => 'names'));
		$apt_post_current_term_count = count($apt_post_current_terms);
		$apt_found_term_names_array_local = array(); //used for adding terms to taxonomies

		#################################################################
		### stopping execution to prevent the function from doing unuseful job PART 2
		//the specified taxonomy doesn't exist, stop!
		if(!taxonomy_exists($apt_single_taxonomy_name)){
			continue;
		}
		//the user does not want us to add terms if the post already has some, stop!
		if(($apt_post_current_term_count > 0) and $apt_settings['apt_old_terms_handling'] == 3){
			continue;
		}
		//number of current terms is the same or greater than the post term limit, so we can't append the terms, stop! (replacement is ok, 3rd option won't be let here)
		if(($apt_post_current_term_count >= $apt_settings['apt_taxonomy_term_limit']) and $apt_settings['apt_old_terms_handling'] == 1){
			continue;
		}
		#################################################################

		//if we are appending terms and the letter case should be ignored, lowercase all array elements (the array is used for the term name search in this case)
		if($apt_settings['apt_old_terms_handling'] == 1 and $apt_settings['apt_ignore_case'] == 1){
			$apt_post_current_terms = array_map('strtolower', $apt_post_current_terms); //make array element lowercase
		}

		//determine if we should calculate the local post term limit - only when appending terms
		if($apt_settings['apt_old_terms_handling'] == 1){
			$apt_local_post_term_limit = $apt_settings['apt_taxonomy_term_limit'] - $apt_post_current_term_count;
		}
		else{
			$apt_local_post_term_limit = $apt_settings['apt_taxonomy_term_limit'];
		}

//die($apt_haystack_string); //for debugging
//die(var_dump($apt_settings['apt_word_separators'])); //for debugging

		if(!empty($apt_settings['apt_word_separators'])){ //continue only if separators are set
			$apt_word_separators_separated = '';

			//generate a string of WORD SEPARATORS separated by "|"
			foreach($apt_settings['apt_word_separators'] as $apt_word_separator){
				if($apt_settings['apt_decode_html_entities_word_separators'] == 1){ //html_entity_decode turns every HTML entity into applicable characters
					$apt_word_separators_separated .= preg_quote(html_entity_decode($apt_word_separator), '/') .'|'; //add "|" ("OR") between the letters, escaping those characters needing escaping
				}
				else{
					$apt_word_separators_separated .= preg_quote($apt_word_separator, '/') .'|'; //add "|" ("OR") between the letters, escaping those characters needing escaping
				}
			} //-foreach
			$apt_word_separators_separated = substr($apt_word_separators_separated, 0, -1); //remove the last extra "|" character
//die($apt_word_separators_separated); //for debugging
		} //-if separators set

		//this variable is placed below all the previous conditions to avoid loading keyword sets to memory when it's not necessary
		$apt_kw_sets = get_option('automatic_post_tagger_keywords');
		$apt_single_group_keyword_sets_array = array();

		//load only keyword sets from the current group
		foreach($apt_kw_sets as $apt_single_kw_set){
			if($apt_single_kw_set[3] == $apt_single_group_data[0]){ //if the keyword group is the same as the current group, add the keyword in the array
				array_push($apt_single_group_keyword_sets_array, $apt_single_kw_set);
			}
		} //-foreach

		### SEARCH FOR A SINGLE TERM NAME and RELATED KEYWORDS
		foreach($apt_single_group_keyword_sets_array as $apt_keyword_set_array_single){ //loop handling every keyword set
			### post/group term limit test
			$apt_found_term_names_array_local_count = count($apt_found_term_names_array_local);
			if($apt_found_term_names_array_local_count == $apt_local_post_term_limit or $apt_found_term_names_array_local_count == $apt_single_group_data[1]){ //if the number of items in the array is equal to the post/group limit (if the group limit is set), break the loop to stop adding new items
//die('<br>$apt_found_term_names_array_local_count: '. $apt_found_term_names_array_local_count .'<br>$apt_local_post_term_limit: '. $apt_local_post_term_limit .'<br>$apt_single_group_data[1]: '. $apt_single_group_data[1]); //for debugging
				break; //stop the loop - the local term limit has been reached
			}

			### preparing the needle for search (note: HTML tags in needles are not being stripped)
			$apt_term_name_needle = $apt_keyword_set_array_single[1];

			if($apt_settings['apt_ignore_case'] == 1){
				$apt_term_name_needle = strtolower($apt_term_name_needle); //make it lowercase
			}
			if($apt_settings['apt_replace_nonalphanumeric'] == 1){
				$apt_term_name_needle = preg_replace('/[^a-zA-Z0-9]/', ' ', $apt_term_name_needle); //replace all non-alphanumeric-characters with spaces
			}
			if($apt_settings['apt_replace_whitespaces'] == 1){
				$apt_term_name_needle = preg_replace('/\s/', ' ', $apt_term_name_needle); //replace whitespace characters with spaces
			}

			### reset variables
			$apt_keyword_set_found = 0;
			$apt_related_keywords_found = 0;
			$apt_term_found_current_terms_array = false;
			$apt_term_found_global_term_names_array = false;

			### check whether term names are already in global or current terms arrays
			$apt_term_found_global_term_names_array = in_array($apt_term_name_needle, $apt_found_term_names_array_global);

			if($apt_settings['apt_old_terms_handling'] == 1){
				$apt_term_found_current_terms_array = in_array($apt_term_name_needle, $apt_post_current_terms);
			}

			### stop searching if the term name is already in the global or current terms array - no need to search the haystack, add the term name to the array right away
			if($apt_term_found_global_term_names_array === true or $apt_term_found_current_terms_array === true){
				$apt_keyword_set_found = 1;
			}

//die("$apt_keyword_set_found"); //for debugging
//die(print_r($apt_kw_sets)); //for debugging
//die("$apt_search_iterations"); //for debugging
//die(print_r($apt_selected_groups_data_array)); //for debugging

			### continue only if the keyword set hasn't been found yet
			if($apt_keyword_set_found == 0){
//$apt_search_iterations++; //for debugging
				if($apt_settings['apt_search_for_related_keywords'] == 1 and !empty($apt_keyword_set_array_single[2])){ //search for related keywords if their array isn't empty (and the user wants to include them in the KW search)
					### RELATED KEYWORDS
					foreach($apt_keyword_set_array_single[2] as $apt_single_related_keyword){ //loop handling single related keywords
						### preparing the substring needle for search (note: HTML tags in needles are not being stripped)
						$apt_related_keyword_needle = $apt_single_related_keyword;
						$apt_substring_wildcard = $apt_settings['apt_wildcard_character'];

						if($apt_settings['apt_decode_html_entities_related_keywords'] == 1){
							$apt_related_keyword_needle = html_entity_decode($apt_related_keyword_needle);
						}

						//lowercase strings
						if($apt_settings['apt_ignore_case'] == 1){
							$apt_related_keyword_needle = strtolower($apt_related_keyword_needle);
							$apt_substring_wildcard = strtolower($apt_settings['apt_wildcard_character']);
						}

						if($apt_settings['apt_replace_nonalphanumeric'] == 1){
							if($apt_settings['apt_dont_replace_wildcards'] == 1){ //don't replace wildcards
								$apt_related_keyword_needle = preg_replace('/[^a-zA-Z0-9'. preg_quote($apt_substring_wildcard, '/') .']/', ' ', $apt_related_keyword_needle);
							}
							else{ //wildcards won't work
								$apt_related_keyword_needle = preg_replace('/[^a-zA-Z0-9]/', ' ', $apt_related_keyword_needle); //replace all non-alphanumeric characters with spaces
							}
						}

						if($apt_settings['apt_replace_whitespaces'] == 1){
							$apt_related_keyword_needle = preg_replace('/\s/', ' ', $apt_related_keyword_needle); //replace whitespace characters with spaces
						}

						if($apt_settings['apt_wildcards'] == 1){
							$apt_wildcard_prepared = preg_quote($apt_substring_wildcard, '/'); //preg_quote the wildcard
							$apt_related_keyword_needle = preg_quote($apt_related_keyword_needle, '/'); //preg_quote regex characters
							$apt_related_keyword_needle = str_replace($apt_wildcard_prepared, $apt_substring_wildcard, $apt_related_keyword_needle); //replace the preg_quoted wildcard with original character (backslashes must be removed because the wildcard will be replaced with the regex pattern - without this it wouldn't work!)
							$apt_related_keyword_needle_wildcards = str_replace($apt_substring_wildcard, $apt_settings['apt_wildcard_regex'], $apt_related_keyword_needle); //replace a wildcard with user-defined regex
						}
						else{
							$apt_related_keyword_needle = preg_quote($apt_related_keyword_needle, '/'); //preg_quote regex characters
						}

						### SEPARATORS SET BY USER
						if(!empty($apt_settings['apt_word_separators']) and $apt_settings['apt_replace_nonalphanumeric'] == 0){ //continue only if separators are set and the use does NOT want to replace non-alphanumeric characters with spaces
							//wildcard search for related keywords
							if($apt_settings['apt_wildcards'] == 1){ //run if wildcards are allowed
								$apt_related_keyword_needle_final = '/('. $apt_word_separators_separated .')'. $apt_related_keyword_needle_wildcards .'('. $apt_word_separators_separated .')/';

								if(preg_match($apt_related_keyword_needle_final, $apt_haystack_string)){ //'XsubstringX' found
									$apt_related_keywords_found = 1; //set variable to 1
//die("substring '". $apt_related_keyword_needle_final ."' found with separators '". $apt_word_separators_separated .'\''); //for debugging
								}

							} //-wildcards allowed
							else{ //if wildcards are not allowed, continue searching without using a regular expression
								$apt_related_keyword_needle_final = '/('. $apt_word_separators_separated .')'. $apt_related_keyword_needle .'('. $apt_word_separators_separated .')/';

								if(preg_match($apt_related_keyword_needle_final, $apt_haystack_string)){ //'XsubstringX' found
									$apt_related_keywords_found = 1; //set variable to 1
								}
							} //-else wildcard search

						} //-if separators are set or non-alphanumeric searching is disabled
						### SPACE SEPARATORS
						else{ //if no separators are set or the user does want to replace non-alphanumeric characters with spaces, continue searching (needles with spaces before and after every keyword)
							//wildcard search for related keywords
							if($apt_settings['apt_wildcards'] == 1){ //run if wildcards are allowed
								$apt_related_keyword_needle_final = '/ '. $apt_related_keyword_needle_wildcards .' /';

								if(preg_match($apt_related_keyword_needle_final, $apt_haystack_string)){
									$apt_related_keywords_found = 1; //set variable to 1
								}
							} //-wildcards allowed
							else{ //if wildcards are not allowed, continue searching without using a regular expression
								$apt_related_keyword_needle_final = ' '. $apt_related_keyword_needle .' '; //add separators - spaces

								if(strstr($apt_haystack_string, $apt_related_keyword_needle_final)){ //' substring ' found
									$apt_related_keywords_found = 1; //set variable to 1
								}
							} //-if wildcard check
						} //-else - no separators
					} //-for
				} //-if related keywords exist

//die("keyword found: ".$apt_related_keywords_found ."<br /><br />needle: ". $apt_related_keyword_needle_final ."<br /><br />text:<br /><br />". $apt_haystack_string ); //for debugging

				if($apt_settings['apt_search_for_term_name'] == 1){ //search for term names only
					### TERM NAME
					if($apt_related_keywords_found == 0){ //search for keyword sets ONLY when NO related keywords were found
//die("no substring was found, now we search for term names"); //for debugging

						### SEPARATORS SET BY USER
						if(!empty($apt_settings['apt_word_separators']) and $apt_settings['apt_replace_nonalphanumeric'] == 0){ //continue only if separators are set and the use does NOT want to replace non-alphanumeric characters with spaces
							$apt_term_name_needle_final = '/('. $apt_word_separators_separated .')'. preg_quote($apt_term_name_needle, '/') .'('. $apt_word_separators_separated .')/';

							if(preg_match($apt_term_name_needle_final, $apt_haystack_string)){ //'XkeywordX' found
								$apt_keyword_set_found = 1; //set variable to 1
//die("keywords '". $apt_term_name_needle ."' found with separators '". print_r($apt_settings['apt_word_separators']) .'\'<br /><br />analyzed content: <br /><br />'. $apt_haystack_string); //for debugging
							}
						} //-if separators are set ANd non-alphanumeric searching disabled
						### SPACE SEPARATORS
						else{ //if no separators are set or the use does want to replace non-alphanumeric characters with spaces, continue searching (needles with spaces before and after every keyword)
							$apt_term_name_needle_final = ' '. $apt_term_name_needle .' '; //add separators - spaces

							if(strstr($apt_haystack_string, $apt_term_name_needle_final)){ //' keyword ' found
								$apt_keyword_set_found = 1; //set variable to 1
							}
						} //-else - no separators
					} //-search for keyword sets if no related keywords were found
				} //-if the user wants to search for term names
			} //-if keyword set has not been found yet

//die("keyword set: ". $apt_keyword_set_array_single[1] ."<br />needle: ". $apt_term_name_needle); //for debugging

			### ADDING FOUND KEYWORDS TO AN ARRAY
			if($apt_related_keywords_found == 1 or $apt_keyword_set_found == 1){ //keyword or one of related_keywords found, add the keyword to array!
//die("keyword set: ". $apt_keyword_set_array_single[1] ."<br />rk found: ".$apt_related_keywords_found ."<br /> keyword set found: ".  $apt_keyword_set_found); //for debugging

				//add keyword set to the global array, but only if it isn't there already
				if(!in_array($apt_keyword_set_array_single[1], $apt_found_term_names_array_global)){
					array_push($apt_found_term_names_array_global, $apt_keyword_set_array_single[1]);
				}

				//if we are appending terms and the term name is already in the current terms array, just continue to the next keyword set
				if($apt_settings['apt_old_terms_handling'] == 1 and $apt_term_found_current_terms_array === true){
					continue;
				}

				//add the keyword set to the local array
				array_push($apt_found_term_names_array_local, $apt_keyword_set_array_single[1]);

				$apt_number_of_added_terms_total++; //the total number must be increased only if we are adding something to the array
			} //-if keyword set found
//die("term name:". $apt_term_name_needle ."<br />rk found: ". $apt_related_keywords_found."<br />keyword set found: " .$apt_keyword_set_found); //for debugging
		} //-foreach

//die("post term limit: ".$apt_settings['apt_taxonomy_term_limit'] ."<br />current terms: ". $apt_post_current_term_count ."<br />local term limit: ". $apt_local_post_term_limit ."<br />group term limit: ". $apt_single_group_data[1] ."<br />found keywords: ". print_r($apt_found_term_names_array_local, true)); //for debugging
//die("analyzed content:<br /><br />". $apt_haystack_string ."<br /><br />found terms:<br /><br />". print_r($apt_found_term_names_array_local, true)); //for debugging

		### merge arrays only if some terms should be added
		if($apt_number_of_added_terms_total > 0){
			$apt_taxonomies_iterations = 0;
			foreach($apt_taxonomies_with_found_terms_array as $apt_single_taxonomy_with_found_terms_array){
				if($apt_single_taxonomy_name == $apt_single_taxonomy_with_found_terms_array[0]){
					$apt_taxonomies_with_found_terms_array[$apt_taxonomies_iterations][1] = array_merge($apt_single_taxonomy_with_found_terms_array[1], $apt_found_term_names_array_local);
				} //-if
				$apt_taxonomies_iterations++;
			} //-foreach
		} //-if
//die("loop iterations: ". $apt_number_of_tagging_loop_iterations . "<br />current taxonomy: ". $apt_single_taxonomy_name ."<br />current terms: ". print_r($apt_post_current_terms, true) ."<br />array to add: ". print_r($apt_found_term_names_array_local, true) ."<br />delete old terms checkbox: ". $apt_settings['apt_old_terms_handling_2_remove_old_terms'] . "<br />current number of terms: ". $apt_post_current_term_count); //for debugging
	} //-foreach for taxonomies

//die("keyword set:". $apt_keyword_set_array_single[1] ."<br />current terms: ". print_r($apt_found_term_names_array_local, true)); //for debugging
//die(print_r($apt_found_term_names_array_local)); //for debugging

//die("number of search iterations: ". $apt_search_iterations ."<br />total number of terms to be added: ". $apt_number_of_added_terms_total ."<br />terms to be added: ". print_r($apt_taxonomies_with_found_terms_array, true)); //for debugging


    //v1.8.2 bugfix
    $apt_number_of_added_terms_all_taxonomies = 0;

    ### ADDING TERMS TO THE POST according to their taxonomies
    foreach($apt_taxonomies_with_found_terms_array as $apt_single_taxonomy_with_found_terms_array){
        $apt_number_of_added_terms_single_taxonomy = count($apt_single_taxonomy_with_found_terms_array[1]); //for debugging

        if($apt_number_of_added_terms_single_taxonomy > 0 and ($apt_settings['apt_old_terms_handling'] == 1 or $apt_settings['apt_old_terms_handling'] == 3)){ //if terms were found by the plugin; if the post has no terms, we should add them - if it already has some, it won't pass one of the first conditions in the function if $apt_settings['apt_old_terms_handling'] == 3
	        wp_set_object_terms($apt_post_id, $apt_single_taxonomy_with_found_terms_array[1], $apt_single_taxonomy_with_found_terms_array[0], true); //append terms
        }
        if($apt_settings['apt_old_terms_handling'] == 2){
	        if($apt_number_of_added_terms_single_taxonomy > 0){ //if the plugin found some keywords, replace the old terms - otherwise do not continue!
		        wp_set_object_terms($apt_post_id, $apt_single_taxonomy_with_found_terms_array[1], $apt_single_taxonomy_with_found_terms_array[0], false); //replace terms
	        }
	        else{ //no new terms/keywords were found
		        $apt_current_taxonomy_terms = wp_get_post_terms($apt_post_id, $apt_single_taxonomy_with_found_terms_array[0], array('fields' => 'names'));
		        $apt_current_taxonomy_term_count = count($apt_current_taxonomy_terms);

		        if(($apt_settings['apt_old_terms_handling_2_remove_old_terms'] == 1) and ($apt_current_taxonomy_term_count > 0)){ //if no new terms were found and there are old terms, remove them all
			        wp_delete_object_term_relationships($apt_post_id, $apt_single_taxonomy_with_found_terms_array[0]); //remove all terms
		        }
	        } //-else
        } //-if the user wants to replace old terms

        $apt_number_of_added_terms_all_taxonomies += $apt_number_of_added_terms_single_taxonomy;
    } //-foreach





//die(print_r($apt_taxonomies_with_found_terms_array)); //for debugging
//die("loop iterations: ". $apt_number_of_tagging_loop_iterations . "<br />taxonomies: ". print_r($apt_selected_groups_data_array, true) ."<br />current terms: ". print_r($apt_post_current_terms, true) . "<br />array to add: ". print_r($apt_found_term_names_array_local, true) ."<br />delete old terms checkbox: ". $apt_settings['apt_old_terms_handling_2_remove_old_terms'] . "<br />current number of terms: ". $apt_post_current_term_count); //for debugging

	//return number of added terms if needed
	if($apt_return_stats == 1){
		return $apt_number_of_added_terms_all_taxonomies;
	} //-return number of added terms
}

/**
 * The bulk tagging tool (processes a single batch)
 *
 * @param	bool	$apt_scheduled_event	If true, runs the bulk tagging tool silently in the background
 */
function apt_bulk_tagging_batch($apt_scheduled_event = false){
	global $apt_message_html_prefix_note,
	$apt_message_html_prefix_error,
	$apt_message_html_suffix;

	$apt_settings = get_option('automatic_post_tagger');

	if($apt_scheduled_event === false){
		$apt_bulk_tagging_errors = apt_get_tagging_errors(); //let the apt_get_tagging_errors function display messages only if this tagging event is not scheduled
	}
	else{
		$apt_bulk_tagging_errors = apt_get_tagging_errors(0);
	}

	///continue only if the queue isn't empty
	if(!empty($apt_settings['apt_bulk_tagging_queue'])){
		///continue only if there aren't any tagging errors (like missing posts)
		if($apt_bulk_tagging_errors > 0){
			///if errors occur and the user does not want to unschedule the event, schedule it again
			if($apt_scheduled_event === true and $apt_settings['apt_bulk_tagging_event_unscheduling'] == 0){
				apt_schedule_bulk_tagging_event();
			}

			apt_clear_bulk_tagging_suboptions();
			return;
		}

		$apt_queued_ids_sliced = array_slice($apt_settings['apt_bulk_tagging_queue'], 0, $apt_settings['apt_bulk_tagging_posts_per_batch']); //get first X elements from the array

		//don't continue if this bulk tagging event is not scheduled
		if($apt_scheduled_event === false){
			echo $apt_message_html_prefix_note .'<strong>Note:</strong> Bulk tagging is currently in progress. This may take some time.'. $apt_message_html_suffix;
			echo '<ul class="apt_custom_list">';

			//determine the number of already processed posts
			if(isset($_GET['pp'])){
				$apt_number_of_already_processed_posts = $_GET['pp'];
			}
			else{
				$apt_number_of_already_processed_posts = 0;
			}

			//determine the number of total terms added to posts
			if(isset($_GET['tt'])){
				$apt_number_of_added_terms_total = $_GET['tt'];
			}
			else{
				$apt_number_of_added_terms_total = 0;
			}

			//determine the number of affected posts
			if(isset($_GET['ap'])){
				$apt_number_of_affected_posts = $_GET['ap'];
			}
			else{
				$apt_number_of_affected_posts = 0;
			}
		} //-if this bulk tagging event is not scheduled

		### run a loop processing selected number of posts from the queue
		foreach($apt_queued_ids_sliced as $apt_post_id){
			$apt_number_of_added_terms = apt_single_post_tagging($apt_post_id, 0, 1); //pass the current post ID + pass '0' to let the function know that we do not want to check mistake scenarios again + send '1' to return number of added terms
			unset($apt_settings['apt_bulk_tagging_queue'][array_search($apt_post_id, $apt_settings['apt_bulk_tagging_queue'])]); //remove the id from the array

			//don't continue if this bulk tagging event is not scheduled
			if($apt_scheduled_event === false){
				//if the tagging function is stopped, set the number of added terms to 0
				if($apt_number_of_added_terms == null){
					$apt_number_of_added_terms = 0;
				}

				$apt_number_of_added_terms_total += $apt_number_of_added_terms; //add up currently assigned terms to the variable
				$apt_number_of_already_processed_posts++; //increase the number of processed posts

				if($apt_number_of_added_terms != 0){
					$apt_number_of_affected_posts++;
				}

				echo '<li><a href="'. admin_url('post.php?post='. $apt_post_id .'&action=edit') .'">Post ID '. $apt_post_id .'</a>: '. $apt_number_of_added_terms .' terms added</li>';
			} //-if this bulk tagging event is not scheduled
		} //-foreach

		### update the custom lowest post ID if needed
		if($apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] == 1){
			$apt_settings['apt_bulk_tagging_range_custom_lower_bound'] = $apt_post_id;
		}

		//save the (empty) IDs array to the option (+ update custom lowest post ID)
		update_option('automatic_post_tagger', $apt_settings); //save settings

		//don't continue if this bulk tagging event is not scheduled
		if($apt_scheduled_event === false){
			echo '</ul>';
			echo '<p><strong>Already processed posts:</strong> '. $apt_number_of_already_processed_posts .'<br />';
			echo '<strong>Terms added to posts:</strong> '. $apt_number_of_added_terms_total .'<br />';
			echo '<strong>Affected posts:</strong> '. $apt_number_of_affected_posts .'<br />';
			echo '<strong>Posts in the queue:</strong> '. count($apt_settings['apt_bulk_tagging_queue']) .'</p>';
		} //-if this bulk tagging event is not scheduled

		### if there are not any IDs in the queue anymore (we need to check the suboption again, since its contents has been changed in the loop)
		if(empty($apt_settings['apt_bulk_tagging_queue'])){
			//don't continue if this bulk tagging event is not scheduled
			if($apt_scheduled_event === false){
				### single event: clear options, redirect the user to a normal page
				apt_clear_bulk_tagging_suboptions();

				echo '<p class="apt_small">This page should be automatically refreshed in '. $apt_settings['apt_bulk_tagging_delay'] .' '. apt_get_grammatical_number($apt_settings['apt_bulk_tagging_delay'], 1, 12) .'. <a href="'. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=0&pp='. $apt_number_of_already_processed_posts .'&tt='. $apt_number_of_added_terms_total .'&ap='. $apt_number_of_affected_posts), 'apt_bulk_tagging_0_nonce') .'">Click here if that doesn\'t happen &raquo;</a></p>'; //display an alternative link if methods below fail
				echo '<script type="text/javascript">setTimeout(function(){window.location.replace("'. str_replace('&amp;', '&', wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=0&pp='. $apt_number_of_already_processed_posts .'&tt='. $apt_number_of_added_terms_total .'&ap='. $apt_number_of_affected_posts), 'apt_bulk_tagging_0_nonce')) .'")}, '. $apt_settings['apt_bulk_tagging_delay']*1000 .')</script>'; //the str_replace function is here because the wp_nonce_url function provides &amp; instead of &, so I need to replace it or the web browser won't redirect anything; the number of seconds has to be multiplied by 1000 here
				echo '<noscript><meta http-equiv="refresh" content="'. $apt_settings['apt_bulk_tagging_delay'] .';url='. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=0&pp='. $apt_number_of_already_processed_posts .'&tt='. $apt_number_of_added_terms_total .'&ap='. $apt_number_of_affected_posts), 'apt_bulk_tagging_0_nonce') .'"></noscript>'; //if JS is disabled, use the meta tag
				exit;
			} //-if this bulk tagging event is not scheduled
			else{
				### recurring event: unschedule this event and schedule the next
				apt_clear_bulk_tagging_suboptions();
				apt_schedule_bulk_tagging_event();
			}
		}
		else{ //else there are still some IDs in the queue
			if($apt_scheduled_event === false){
				### redirect to the same page (and continue tagging)
				echo '<p class="apt_small">This page should be automatically refreshed in '. $apt_settings['apt_bulk_tagging_delay'] .' '. apt_get_grammatical_number($apt_settings['apt_bulk_tagging_delay'], 1, 12) .'. <a href="'. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=1&pp='. $apt_number_of_already_processed_posts .'&tt='. $apt_number_of_added_terms_total .'&ap='. $apt_number_of_affected_posts), 'apt_bulk_tagging_1_nonce') .'">Click here if that doesn\'t happen &raquo;</a></p>'; //display an alternative link if methods below fail
				echo '<script type="text/javascript">setTimeout(function(){window.location.replace("'. str_replace('&amp;', '&', wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=1&pp='. $apt_number_of_already_processed_posts .'&tt='. $apt_number_of_added_terms_total .'&ap='. $apt_number_of_affected_posts), 'apt_bulk_tagging_1_nonce')) .'")}, '. $apt_settings['apt_bulk_tagging_delay']*1000 .')</script>'; //the str_replace function is here because the wp_nonce_url function provides &amp; instead of &, so I need to replace it or the web browser won't redirect anything; the number of seconds has to be multiplied by 1000 here
				echo '<noscript><meta http-equiv="refresh" content="'. $apt_settings['apt_bulk_tagging_delay'] .';url='. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=1&pp='. $apt_number_of_already_processed_posts .'&tt='. $apt_number_of_added_terms_total .'&ap='. $apt_number_of_affected_posts), 'apt_bulk_tagging_1_nonce') .'"></noscript>'; //if JS is disabled, use the meta tag
				exit;
			}
			else{
				### schedule a new event for the next batch
				wp_schedule_single_event(time() + $apt_settings['apt_bulk_tagging_delay'], 'apt_bulk_tagging_event_single_batch');
			}
		} //-else IDs in the queue
	} //-if queue not empty
}

/**
 * Returns calculated bulk tagging range
 *
 * @param	bool	$apt_database_range		If true, returns the lowest and highest post ID in the database, otherwise the range set by the user
 * @return	array	$apt_bulk_tagging_range
 */
function apt_get_bulk_tagging_range($apt_database_range = false){
	global $wpdb;

	$apt_settings = get_option('automatic_post_tagger');

	$apt_database_lowest_id = $wpdb->get_var("SELECT MIN(ID) FROM $wpdb->posts WHERE ". apt_get_allowed_post_types_statuses_sql());
	$apt_database_highest_id = $wpdb->get_var("SELECT MAX(ID) FROM $wpdb->posts WHERE ". apt_get_allowed_post_types_statuses_sql());

	if($apt_database_lowest_id === null){
		$apt_database_lowest_id = 'n/a';
	}
	if($apt_database_highest_id === null){
		$apt_database_highest_id = 'n/a';
	}

	if($apt_database_range === false){ //user range
		if($apt_settings['apt_bulk_tagging_range_lower_bound'] == 1){
			$apt_bulk_tagging_range_lower_bound_value = $apt_database_lowest_id;
		}
		else{
			$apt_bulk_tagging_range_lower_bound_value = $apt_settings['apt_bulk_tagging_range_custom_lower_bound'];
		}
		if($apt_settings['apt_bulk_tagging_range_upper_bound'] == 1){
			$apt_bulk_tagging_range_upper_bound_value = $apt_database_highest_id;
		}
		else{
			$apt_bulk_tagging_range_upper_bound_value = $apt_settings['apt_bulk_tagging_range_custom_upper_bound'];
		}
	}
	else{ //database range
		$apt_bulk_tagging_range_lower_bound_value = $apt_database_lowest_id;
		$apt_bulk_tagging_range_upper_bound_value = $apt_database_highest_id;
	}

	$apt_bulk_tagging_range = array($apt_bulk_tagging_range_lower_bound_value, $apt_bulk_tagging_range_upper_bound_value);

	return $apt_bulk_tagging_range;
}

/**
 * Creates the post queue using the post range
 *
 * @param	array	$apt_bulk_tagging_range
 * @return	array	$apt_queued_ids_array	Number of items in the queue
 */
function apt_get_post_queue($apt_bulk_tagging_range){
	global $wpdb;

	$apt_queued_ids_array = array();
	$apt_queued_ids_sql = 'SELECT ID FROM '. $wpdb->posts .' WHERE '. apt_get_allowed_post_types_statuses_sql() .' and ID >= '. $apt_bulk_tagging_range[0] .' and ID <= '. $apt_bulk_tagging_range[1];
	$apt_queued_ids_results = $wpdb->get_results($apt_queued_ids_sql, ARRAY_A);

	//extract results to an array
	foreach($apt_queued_ids_results as $apt_row){
			$apt_queued_ids_array[] = $apt_row['ID'];
	} //-foreach

	sort($apt_queued_ids_array, SORT_NUMERIC); //sort the array so that highest IDs will be at the end (necessary if the highest ID is supposed to be saved to the lower boundary custom ID optio)
	return $apt_queued_ids_array;
}

/**
 * Adds post IDs to the queue
 *
 * @param	bool	$apt_scheduled_event	If true, runs the bulk tagging tool silently in the background
 * @return	int		$apt_queue_item_count	Number of items in the queue
 */
function apt_add_post_ids_to_queue($apt_scheduled_event = false){
	global $apt_message_html_prefix_error,
	$apt_message_html_suffix;

	$apt_settings = get_option('automatic_post_tagger');

	$apt_settings['apt_bulk_tagging_range'] = apt_get_bulk_tagging_range();

	if(!preg_match('/^(0|[1-9][0-9]*){1}$/', $apt_settings['apt_bulk_tagging_range'][0]) or !preg_match('/^(0|[1-9][0-9]*){1}$/', $apt_settings['apt_bulk_tagging_range'][1])){ //non-negative integers only
		if($apt_scheduled_event === false){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> Post ID range is invalid, no items could be added to the queue.'. $apt_message_html_suffix;
		}
		return;
	}

	$apt_queued_ids_array = apt_get_post_queue($apt_settings['apt_bulk_tagging_range']);
	$apt_queue_item_count = count($apt_queued_ids_array);

	//if no post IDs are added to the array, don't save the queue
	if($apt_queue_item_count == 0){
		//don't continue if this bulk tagging event is not scheduled
		if($apt_scheduled_event === false){
			global $apt_message_html_prefix_error, $apt_message_html_suffix;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> There aren\'t any post IDs within the specified range.'. $apt_message_html_suffix;
		}
	}
	else{ //IDs are in the array, continue!
		$apt_settings['apt_bulk_tagging_queue'] = $apt_queued_ids_array; //saving retrieved ids to the option
		update_option('automatic_post_tagger', $apt_settings); //save settings
	}

	return $apt_queue_item_count;
}

/**
 * Scheduled bulk tagging - processes posts using batches; run on every page load, after everything else is loaded
 */
function apt_scheduled_bulk_tagging(){
	$apt_settings = get_option('automatic_post_tagger');

	//if the queue is empty, add new post IDs there (isn't run when the single_batch event is run, since that event is created only if there are posts in the queue) 
	if(empty($apt_settings['apt_bulk_tagging_queue'])){
		apt_add_post_ids_to_queue(true);
	}

	//process one batch - the function should schedule the event "apt_bulk_tagging_event_single_batch", which will then execute this function directly
	apt_bulk_tagging_batch(true);
}

/**
 * Schedule a new bulk tagging event
 */
function apt_schedule_bulk_tagging_event(){
	$apt_settings = get_option('automatic_post_tagger');
	wp_schedule_single_event(time() + (3600 * $apt_settings['apt_bulk_tagging_event_recurrence']), 'apt_bulk_tagging_event');
}

/**
 * Clears the bulk tagging queue and range
 */
function apt_clear_bulk_tagging_suboptions(){
	$apt_settings = get_option('automatic_post_tagger');
	$apt_settings['apt_bulk_tagging_queue'] = array();
	$apt_settings['apt_bulk_tagging_range'] = array();
	update_option('automatic_post_tagger', $apt_settings); //save settings
}
/**
 * Unschedule bulk tagging (either manually or automatically when deactivating the plugin)
 *
 * @return	bool	$apt_event_unscheduled	Whether the event was succesfully unscheduled or not
 */
function apt_unschedule_bulk_tagging_event(){
	$apt_event_unscheduled = false;

	if(wp_next_scheduled('apt_bulk_tagging_event') !== false){
		wp_clear_scheduled_hook('apt_bulk_tagging_event');
		$apt_event_unscheduled = true;
	}
	if(wp_next_scheduled('apt_bulk_tagging_event_single_batch') !== false){
		wp_clear_scheduled_hook('apt_bulk_tagging_event_single_batch');
		$apt_event_unscheduled = true;
	}

	apt_clear_bulk_tagging_suboptions();

	return $apt_event_unscheduled;
}

## =========================================================================
## ### OPTIONS PAGE
## =========================================================================

/**
 * Renders the options page
 */
function apt_options_page(){
	global $wpdb,
	$apt_backup_dir_abs_path,
	$apt_message_html_prefix_updated,
	$apt_message_html_prefix_error,
	$apt_message_html_prefix_warning,
	$apt_message_html_prefix_note,
	$apt_message_html_suffix,
	$apt_invalid_nonce_message,
	$apt_max_input_vars_value;

	apt_install_plugin_data(); //run this to make sure that plugin data exist

	$apt_settings = get_option('automatic_post_tagger');
	$apt_groups = get_option('automatic_post_tagger_groups');
	$apt_kw_sets = get_option('automatic_post_tagger_keywords');
?>

<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Automatic Post Tagger</h2>

<?php
## ===================================
## ### GET BASED ACTIONS
## ===================================

### bulk tagging redirection
if(isset($_GET['bt'])){
	if($_GET['bt'] == 0 and check_admin_referer('apt_bulk_tagging_0_nonce')){
		if(empty($apt_settings['apt_bulk_tagging_queue'])){
			echo $apt_message_html_prefix_updated .'Bulk tagging complete. APT has processed <strong>'. $_GET['pp'] .'</strong> posts and added <strong>'. $_GET['tt'] .'</strong> terms total to <strong>'. $_GET['ap'] .'</strong> posts.'. $apt_message_html_suffix;
		}
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The bulk tagging queue isn\'t empty. (Still unprocessed posts: '. count($apt_settings['apt_bulk_tagging_queue']) .')'. $apt_message_html_suffix;
		}
	}
	if($_GET['bt'] == 1 and check_admin_referer('apt_bulk_tagging_1_nonce')){
		//if there are not any ids in the queue, redirect the user to a normal page
		if(empty($apt_settings['apt_bulk_tagging_queue'])){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> Bulk tagging couldn\'t continue, because the post queue has been already emptied.'. $apt_message_html_suffix;
		}
		else{ //if there are some ids in the option, execute the function
			apt_bulk_tagging_batch();
		}
	}
}

### non-empty queue management
if(isset($_GET['queue-management'])){
	if($_GET['queue-management'] == 1 and check_admin_referer('apt_bulk_tagging_queue_management_nonce')){

		apt_clear_bulk_tagging_suboptions();
		$apt_settings = get_option('automatic_post_tagger'); //we need to load variables again, since they have been changed by the function apt_clear_bulk_tagging_suboptions()

		echo $apt_message_html_prefix_updated .'Bulk tagging queue has been emptied.'. $apt_message_html_suffix;
	}
	if($_GET['queue-management'] == 2 and check_admin_referer('apt_bulk_tagging_queue_management_nonce')){
		apt_schedule_bulk_tagging_event();
		echo $apt_message_html_prefix_updated .'Bulk tagging has been scheduled to run every '. $apt_settings['apt_bulk_tagging_event_recurrence'] .' '. apt_get_grammatical_number($apt_settings['apt_bulk_tagging_event_recurrence'], 1, 11) .'. Next bulk tagging event: </code>'. get_date_from_gmt(date('Y-m-d H:i:s', wp_next_scheduled('apt_bulk_tagging_event'))) .'</code>'. $apt_message_html_suffix;
	}
}

## ===================================
## ### VARIOUS MESSAGES
## ===================================

### display message when the "max_input_vars" limit is (about to be) reached
$apt_current_number_of_post_variables = count($_POST, COUNT_RECURSIVE);

if($apt_max_input_vars_value != false){ //make sure the value isn't false
	if($apt_current_number_of_post_variables > $apt_max_input_vars_value){
		echo $apt_message_html_prefix_error .'<strong>Error:</strong> PHP\'s "max_input_vars" limit ('. $apt_max_input_vars_value .') has been exceeded (number of sent input variables: '. $apt_current_number_of_post_variables .'); some input fields have not been successfully submitted. If you can\'t edit/delete keyword sets/configuration groups, change the option "Item editor mode" to "CSV". See <a href="https://wordpress.org/plugins/automatic-post-tagger/faq">FAQ #2</a> for more information.'. $apt_message_html_suffix;
	}
	else{ //if the limit hasn't been exceeded yet
		### display warning if the "max_input_vars" limit is about to be reached
		if($apt_settings['apt_hide_warning_messages'] == 0 and $apt_current_number_of_post_variables != 0){
			$apt_max_input_vars_percentage = round(($apt_current_number_of_post_variables / $apt_max_input_vars_value) * 100);
			$apt_remaining_input_vars_percentage = 100 - $apt_max_input_vars_percentage;

			if($apt_remaining_input_vars_percentage < 5){ //if the number of free POST variables less than 5%
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> PHP\'s "max_input_vars" limit ('. $apt_max_input_vars_value .') has been almost been reached (number of sent input variables: '. $apt_current_number_of_post_variables .'). When this happens, you won\'t be able to edit/delete keyword sets or configuration groups. You might want to change the option "Item editor mode" to "CSV". See <a href="https://wordpress.org/plugins/automatic-post-tagger/faq">FAQ #2</a> for more information.'. $apt_message_html_suffix;
			}
		} //if warning messages allowed
	} //-else limit wasn't exceeded
} //-if value is integer


### bulk tagging errors
$apt_bulk_tagging_errors = 0;

if(wp_next_scheduled('apt_bulk_tagging_event_single_batch') === false and !empty($apt_settings['apt_bulk_tagging_queue'])){ //if the queue isn't empty and recurring tagging event isn't in progress, it means bulk tagging was interrupted last time and some IDs remain in the array
	$apt_bulk_tagging_errors++;
	$apt_bulk_tagging_errors2 = apt_get_tagging_errors(0);

	echo $apt_message_html_prefix_error .'<strong>Error:</strong> The bulk tagging queue isn\'t empty ('. count($apt_settings['apt_bulk_tagging_queue']) .' posts in the queue), possibly because the last bulk tagging event has been interrupted and remaining queued posts couldn\'t be processed. ';

	echo 'To resolve this problem, <a href="'. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&queue-management=1'), 'apt_bulk_tagging_queue_management_nonce') .'">purge the contents of the queue</a>';

	if($apt_bulk_tagging_errors2 == 0){
		echo ' or <a href="'. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=1'), 'apt_bulk_tagging_1_nonce') .'">finish processing the queue now</a>';

		if(wp_next_scheduled('apt_bulk_tagging_event') !== false or wp_next_scheduled('apt_bulk_tagging_event_single_batch') !== false){
			echo ' (or you can wait until the queue is automatically processed by the next scheduled bulk tagging event)';
		}
		else{
			echo ' or <a href="'. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&queue-management=2'), 'apt_bulk_tagging_queue_management_nonce') .'">schedule a new bulk tagging event</a> which will automatically process remaining posts in the queue';
		}
	}

	echo '.'. $apt_message_html_suffix;
}

## ===================================
## ### OPTIONS SAVING
## ===================================

if(isset($_POST['apt_save_settings_button'])){ //saving all settings
	if(wp_verify_nonce($_POST['apt_settings_hash'],'apt_settings_nonce')){

		//settings saved to a single array which will be updated at the end of this condition
		$apt_settings['apt_title'] = (isset($_POST['apt_title'])) ? '1' : '0';
		$apt_settings['apt_content'] = (isset($_POST['apt_content'])) ? '1' : '0';
		$apt_settings['apt_excerpt'] = (isset($_POST['apt_excerpt'])) ? '1' : '0';
		$apt_settings['apt_search_for_term_name'] = (isset($_POST['apt_search_for_term_name'])) ? '1' : '0';
		$apt_settings['apt_search_for_related_keywords'] = (isset($_POST['apt_search_for_related_keywords'])) ? '1' : '0';
		$apt_settings['apt_old_terms_handling'] = $_POST['apt_old_terms_handling'];
		$apt_settings['apt_old_terms_handling_2_remove_old_terms'] = (isset($_POST['apt_old_terms_handling_2_remove_old_terms'])) ? '1' : '0';
		$apt_settings['apt_run_apt_publish_post'] = (isset($_POST['apt_run_apt_publish_post'])) ? '1' : '0';
		$apt_settings['apt_run_apt_save_post'] = (isset($_POST['apt_run_apt_save_post'])) ? '1' : '0';
		$apt_settings['apt_run_apt_wp_insert_post'] = (isset($_POST['apt_run_apt_wp_insert_post'])) ? '1' : '0';
		$apt_settings['apt_ignore_case'] = (isset($_POST['apt_ignore_case'])) ? '1' : '0';
		$apt_settings['apt_decode_html_entities_word_separators'] = (isset($_POST['apt_decode_html_entities_word_separators'])) ? '1' : '0';
		$apt_settings['apt_decode_html_entities_analyzed_content'] = (isset($_POST['apt_decode_html_entities_analyzed_content'])) ? '1' : '0';
		$apt_settings['apt_decode_html_entities_related_keywords'] = (isset($_POST['apt_decode_html_entities_related_keywords'])) ? '1' : '0';
		$apt_settings['apt_strip_tags'] = (isset($_POST['apt_strip_tags'])) ? '1' : '0';
		$apt_settings['apt_replace_whitespaces'] = (isset($_POST['apt_replace_whitespaces'])) ? '1' : '0';
		$apt_settings['apt_replace_nonalphanumeric'] = (isset($_POST['apt_replace_nonalphanumeric'])) ? '1' : '0';
		$apt_settings['apt_dont_replace_wildcards'] = (isset($_POST['apt_dont_replace_wildcards'])) ? '1' : '0';
		$apt_settings['apt_substring_analysis'] = (isset($_POST['apt_substring_analysis'])) ? '1' : '0';
		$apt_settings['apt_wildcards'] = (isset($_POST['apt_wildcards'])) ? '1' : '0';
		$apt_settings['apt_input_correction'] = (isset($_POST['apt_input_correction'])) ? '1' : '0';
		$apt_settings['apt_export_plugin_data_before_update'] = (isset($_POST['apt_export_plugin_data_before_update'])) ? '1' : '0';
		$apt_settings['apt_export_plugin_data_after_update'] = (isset($_POST['apt_export_plugin_data_after_update'])) ? '1' : '0';
		$apt_settings['apt_item_editor_mode'] = $_POST['apt_item_editor_mode'];
		$apt_settings['apt_hide_warning_messages'] = (isset($_POST['apt_hide_warning_messages'])) ? '1' : '0';
		$apt_settings['apt_hide_update_messages'] = (isset($_POST['apt_hide_update_messages'])) ? '1' : '0';
		$apt_settings['apt_default_group'] = $_POST['apt_default_group'];
		$apt_settings['apt_nonexistent_groups_handling'] = $_POST['apt_nonexistent_groups_handling'];

		//these variables need to be stripslashed
		$apt_stripslashed_string_separator = stripslashes($_POST['apt_string_separator']);
		$apt_stripslashed_word_separators = stripslashes($_POST['apt_word_separators']);
		$apt_stripslashed_post_types = stripslashes($_POST['apt_post_types']);
		$apt_stripslashed_post_statuses = stripslashes($_POST['apt_post_statuses']);


		if(empty($apt_stripslashed_word_separators)){ //this prevents the explode function from saving an empty [0] item in the array if no word separators are set
			$apt_settings['apt_word_separators'] = array();
			echo $apt_message_html_prefix_note .'<strong>Note:</strong> No word separators were specified; a space will be used as a default word separator.'. $apt_message_html_suffix;
		}
		else{
			//input correction
			if($apt_settings['apt_input_correction'] == 1){
				$apt_word_separators_trimmed = trim(trim($apt_stripslashed_word_separators, $apt_stripslashed_string_separator), $apt_settings['apt_string_separator']);
				$apt_word_separators_trimmed = preg_replace('/('. preg_quote($apt_stripslashed_string_separator, '/') .'){2,}/', $apt_stripslashed_string_separator, $apt_word_separators_trimmed); //replace multiple occurrences of the current string separator with one
				$apt_settings['apt_word_separators'] = explode($apt_settings['apt_string_separator'], $apt_word_separators_trimmed); //when exploding, we need to use the currently used ($apt_settings) apt_string_separator in word separators, otherwise the separators won't be exploded
			} //-input correction
			else{
				$apt_settings['apt_word_separators'] = explode($apt_settings['apt_string_separator'], $apt_stripslashed_word_separators); //when exploding, we need to use the currently used ($apt_settings) apt_string_separator in word separators, otherwise the separators won't be exploded
			} //-else input corrections
		} //-else empty word separator

		if(empty($apt_stripslashed_post_types)){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The option "apt_post_types" couldn\'t be saved, because the submitted value was empty.'. $apt_message_html_suffix;
		}
		else{
			//input correction
			if($apt_settings['apt_input_correction'] == 1){
				$apt_post_types_trimmed = trim(trim($apt_stripslashed_post_types, $apt_stripslashed_string_separator));
				$apt_post_types_trimmed = preg_replace('/('. preg_quote($apt_stripslashed_string_separator, '/') .'){2,}/', $apt_stripslashed_string_separator, $apt_post_types_trimmed); //replace multiple occurrences of the current string separator with one
				$apt_submitted_post_types_array = explode($apt_settings['apt_string_separator'], $apt_post_types_trimmed);
			} //-input correction
			else{
				$apt_submitted_post_types_array = explode($apt_settings['apt_string_separator'], $apt_stripslashed_post_types);
			} //-else input corrections


			$apt_new_post_types_array = array(); //we need an empty array

			//if a post type doesn't exist, remove it from the array
			foreach($apt_submitted_post_types_array as $apt_single_post_type_index => $apt_single_post_type){
				if(!post_type_exists($apt_single_post_type)){
					unset($apt_submitted_post_types_array[$apt_single_post_type_index]);
					echo $apt_message_html_prefix_error .'<strong>Error:</strong> The post type "<strong>'. htmlspecialchars($apt_single_post_type) .'</strong>" couldn\'t be saved, because it isn\'t registered.'. $apt_message_html_suffix;
				} //-if post type doesn't exist		
				else{
					if(!in_array($apt_single_post_type, $apt_new_post_types_array)){
						array_push($apt_new_post_types_array, $apt_single_post_type); //add the post type to the array if it isn't there already
					} //-if post type isn't in the settings array
				} //-else post type exists
			} //-foreach

			if(!empty($apt_new_post_types_array)){
				$apt_settings['apt_post_types'] = $apt_new_post_types_array;
			}
		} //-else empty post types not empty

		if(empty($apt_stripslashed_post_statuses)){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The option "apt_post_statuses" couldn\'t be saved, because the submitted value was empty.'. $apt_message_html_suffix;
		}
		else{
			//input correction
			if($apt_settings['apt_input_correction'] == 1){
				$apt_post_statuses_trimmed = trim(trim($apt_stripslashed_post_statuses, $apt_settings['apt_string_separator']));
				$apt_post_statuses_trimmed = preg_replace('/'. preg_quote($apt_settings['apt_string_separator'], '/') .'{2,}/', $apt_settings['apt_string_separator'], $apt_post_statuses_trimmed); //replacing multiple separators with one
				$apt_post_statuses_trimmed = preg_replace(array('/\s{2,}/', '/[\t\n]/'), '', $apt_post_statuses_trimmed); //removing whitespace characters
				$apt_settings['apt_post_statuses'] = explode($apt_settings['apt_string_separator'], $apt_post_statuses_trimmed);
			} //-input correction
			else{
				$apt_settings['apt_post_statuses'] = explode($apt_settings['apt_string_separator'], $apt_stripslashed_post_statuses);
			} //-else input correction
		} //-else empty post statuses

		if(empty($_POST['apt_wildcard_regex'])){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> The wildcard pattern couldn\'t be saved, because the submitted value was empty.'. $apt_message_html_suffix;
		}
		else{ //empty regex
			if(@preg_match($_POST['apt_wildcard_regex'], '') !== false){ //regex must be valid (@ suppresses PHP warnings)
				$apt_settings['apt_wildcard_regex'] = $_POST['apt_wildcard_regex'];
			}
			else{
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> The wildcard pattern couldn\'t be saved, because the submitted regular expression was invalid.'. $apt_message_html_suffix;
			}
		} //-else

		//making sure that people won't save rubbish in the DB
		if(preg_match('/^-?[0-9]+$/', $_POST['apt_substring_analysis_length'])){ //value must be an integer
			$apt_settings['apt_substring_analysis_length'] = $_POST['apt_substring_analysis_length'];
		}
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The option "apt_substring_analysis_length" couldn\'t be saved, because the submitted value wasn\'t an integer.'. $apt_message_html_suffix;
		}

		if(preg_match('/^-?[0-9]+$/', $_POST['apt_substring_analysis_start'])){ //value must be an integer
			$apt_settings['apt_substring_analysis_start'] = $_POST['apt_substring_analysis_start'];
		}
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The option "apt_substring_analysis_start" couldn\'t be saved, because the submitted value wasn\'t an integer.'. $apt_message_html_suffix;
		}

		if(preg_match('/^[1-9][0-9]*$/', $_POST['apt_taxonomy_term_limit'])){ //positive integers only
			$apt_settings['apt_taxonomy_term_limit'] = $_POST['apt_taxonomy_term_limit'];
		}
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The post term limit couldn\'t be saved, because the submitted value wasn\'t a positive integer.'. $apt_message_html_suffix;
		}

		if(preg_match('/^[1-9][0-9]*$/', $_POST['apt_backup_limit'])){ //positive integers only
			$apt_settings['apt_backup_limit'] = $_POST['apt_backup_limit'];
		}
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The backup limit couldn\'t be saved, because the submitted value wasn\'t a positive integer.'. $apt_message_html_suffix;
		}

		//the string separator must not be empty
		if(!empty($apt_stripslashed_string_separator)){
			//the string separator must not contain the wildcard character
			if(strstr($apt_stripslashed_string_separator, $_POST['apt_wildcard_character'])){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> The new string separator couldn\'t be saved, because the submitted value contained the wildcard character. Use something else, please.'. $apt_message_html_suffix;
			}
			else{ //the string doesn't contain the string separator
				if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
					//the string separator is not a comma
					if($apt_stripslashed_string_separator != ','){ //don't display when non-comma character was submitted
						echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The string separator has been set to "<strong>'. htmlspecialchars($apt_stripslashed_string_separator) .'</strong>". Using a comma instead is recommended.'. $apt_message_html_suffix;

						if($apt_stripslashed_string_separator == ';'){ //don't display when a semicolon separator was submitted
							echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> You can\'t use HTML entities as word separators when a semicolon is used as a string separator.'. $apt_message_html_suffix;
						}
					}
				} //-if warnings allowed

				$apt_settings['apt_string_separator'] = $apt_stripslashed_string_separator;
			} //-else doesn't contain the wildcard character
		} //-if not empty
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The option "apt_string_separator" couldn\'t be saved, because the submitted value was empty.'. $apt_message_html_suffix;
		}

		//the wildcard must not be empty
		if(!empty($_POST['apt_wildcard_character'])){
			//the wildcard must not contain the string separator
			if(strstr($_POST['apt_wildcard_character'], $apt_stripslashed_string_separator)){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> The new wildcard character couldn\'t be saved, because the submitted value contained the string separator. Use something else, please.'. $apt_message_html_suffix;
			}
			else{ //the string doesn't contain the string separator

				if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
					//the wildcard is not an asterisk
					if($_POST['apt_wildcard_character'] != '*'){ //display when non-asterisk character was submitted
						echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The wildcard character has been set to "<strong>'. htmlspecialchars($_POST['apt_wildcard_character']) .'</strong>". Using an asterisk instead is recommended.'. $apt_message_html_suffix;
					}
				} //-if warnings allowed

				//if the wildcard has been changed, inform the user about changing wildcards in all related keywords, if keyword sets exist
				if($_POST['apt_wildcard_character'] != $apt_settings['apt_wildcard_character'] and $apt_settings['apt_keyword_sets_total'] > 0){
					//replacing old wildcards in cells with related keywords with the new value
					$apt_keyword_wildcard_replacement_id = 0;
					//replace wildcards via a foreach
					foreach($apt_kw_sets as $apt_keyword_single){
						$apt_keyword_wildcard_replacement_id_2 = 0;
						foreach($apt_keyword_single[2] as $apt_related_keyword){
							if(strstr($apt_related_keyword, $apt_settings['apt_wildcard_character'])){
								$apt_kw_sets[$apt_keyword_wildcard_replacement_id][2][$apt_keyword_wildcard_replacement_id_2] = str_replace($apt_settings['apt_wildcard_character'], $_POST['apt_wildcard_character'], $apt_related_keyword);
							}
							$apt_keyword_wildcard_replacement_id_2++; //this incrementor must be placed AFTER the replacement function
						} //-foreach

						$apt_keyword_wildcard_replacement_id++; //this incrementor must be placed AFTER the replacement function
					} //-foreach

					update_option('automatic_post_tagger_keywords', $apt_kw_sets); //save keyword sets with new wildcards


					echo $apt_message_html_prefix_note .'<strong>Note:</strong> All old wildcard characters ("<strong>'. htmlspecialchars($apt_settings['apt_wildcard_character']) .'</strong>") used in related keywords have been changed to new values ("<strong>'. htmlspecialchars($_POST['apt_wildcard_character']) .'</strong>").'. $apt_message_html_suffix;
				} //wildcard has been changed

				$apt_settings['apt_wildcard_character'] = $_POST['apt_wildcard_character']; //this line MUST be placed after the current/old wildcard check
			} //-else doesn't contain the string separator

		} //-if not empty
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The wildcard character couldn\'t be saved, because the submitted value was empty.'. $apt_message_html_suffix;
		}

		update_option('automatic_post_tagger', $apt_settings); //save settings

		### generate warnings
		//the $apt_settings variable is used here instead of $_POST; the POST data have been already saved there

		if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
			//warn the user if the string separator is repeated multiple times in the option apt_word_separators while input correction is disabled
			if($apt_settings['apt_input_correction'] == 0){
				if(preg_match('/('. preg_quote($apt_settings['apt_string_separator'], '/') .'){2,}/', $apt_stripslashed_word_separators)){
					echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Your word separators contain multiple string separators in a row. If you don\'t remove them, APT will treat the nonexistent characters between them as word separators, which might result in non-relevant taxonomy terms being added to your posts.'. $apt_message_html_suffix;
				}
			} //-input correction disabled

			//warn the user if the specified post statuses doesn't exist //TODO - there's still no way to check whether a post status exists (whether it is registered), this should be changed when the situation changes; an error message should be shown instead of a warning
			foreach($apt_settings['apt_post_statuses'] as $apt_post_status){
				if(!in_array($apt_post_status, array('publish', 'future', 'draft', 'pending', 'private', 'trash', 'auto-draft', 'inherit'))){
					echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The post status "<strong>'. htmlspecialchars($apt_post_status) .'</strong>" is not one of the default statuses used by WP.'. $apt_message_html_suffix; //we always display this warning, because the user should see it, even if they don't want warnings to be displayed
				}
			} //-foreach

			//warn users about the inability to add terms - these messages also appear in the apt_get_tagging_errors function
			if(($apt_settings['apt_title'] == 0 and $apt_settings['apt_content'] == 0 and $apt_settings['apt_excerpt'] == 0) or ($apt_settings['apt_substring_analysis'] == 1 and $apt_settings['apt_substring_analysis_length'] == 0)){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The plugin isn\'t allowed to analyze any content.'. $apt_message_html_suffix;
			}
			if($apt_settings['apt_search_for_term_name'] == 0 and $apt_settings['apt_search_for_related_keywords'] == 0){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The plugin isn\'t allowed to search for any keyword set items.'. $apt_message_html_suffix;
			}
			if($apt_settings['apt_run_apt_publish_post'] == 0 and $apt_settings['apt_run_apt_save_post'] == 0 and $apt_settings['apt_run_apt_wp_insert_post'] == 0){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The plugin isn\'t allowed to automatically process posts. <span class="apt_help" title="APT can process posts only when running the bulk tagging tool.">i</span>'. $apt_message_html_suffix;
			}

			//warn the user about ignored word separators
			if(isset($_POST['apt_replace_nonalphanumeric']) and !empty($apt_settings['apt_word_separators'])){ //display this note only if word separators are set and the user wants to replace non-alphanumeric characters with spaces
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Replacement of non-alphanumeric characters with spaces has been enabled. Currently set word separators will be ignored.'. $apt_message_html_suffix;
			}
			//warn the user about non-functioning wildcards
			if(isset($_POST['apt_replace_nonalphanumeric']) and $apt_settings['apt_dont_replace_wildcards'] == 0){ //display this note only if wildcards are not being ignored
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Replacement of non-alphanumeric characters (including wildcards) with spaces has been enabled. Wildcards won\'t work unless you allow the option "Don\'t replace wildcards".'. $apt_message_html_suffix;
			}
			//warn the user if whitespace characters won't be replaced 
			if(!isset($_POST['apt_replace_whitespaces'])){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Replacement of whitespace characters with spaces has been disabled. APT won\'t be able to find keyword set items separated by newlines and tabs.'. $apt_message_html_suffix;
			}
			//warn the user if input correction is disabled
			if(!isset($_POST['apt_input_correction'])){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Automatic input correction has been disabled.'. $apt_message_html_suffix;
			}
			//warn the user if nonexistent group handling is set to 2
			if($_POST['apt_nonexistent_groups_handling'] == 2){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> APT is currently set to delete keyword sets belonging to nonexistent configuration groups. For example, if you import new groups from a JSON file, or edit groups when the "Item editor mode" is set to "CSV" and change your groups\' names, your keyword sets will be removed. Just to make that sure you don\'t lose any data, please create a backup before continuing.'. $apt_message_html_suffix;
			}
			if($apt_settings['apt_export_plugin_data_before_update'] == 0){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The plugin isn\'t allowed to create automatic backups before updating the plugin.'. $apt_message_html_suffix;
			}
			if($apt_settings['apt_export_plugin_data_after_update'] == 0){
				echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The plugin isn\'t allowed to create automatic backups after updating the plugin.'. $apt_message_html_suffix;
			}

		} //-if warnings allowed

		echo $apt_message_html_prefix_updated .'Plugin settings have been saved.'. $apt_message_html_suffix;
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_reinstall_plugin_button'])){ //resetting settings
	if(wp_verify_nonce($_POST['apt_settings_hash'],'apt_settings_nonce')){
		apt_unschedule_bulk_tagging_event();
		apt_uninstall_plugin_data();
		apt_install_plugin_data();

		$apt_settings = get_option('automatic_post_tagger'); //we need to load newly generated settings again, the array saved in the global variable is old
		$apt_settings['apt_admin_notice_install'] = 0; //hide the activation notice after reinstalling
		update_option('automatic_post_tagger', $apt_settings); //save settings

		echo $apt_message_html_prefix_updated .'Plugin has been reinstalled; default settings have been restored.'. $apt_message_html_suffix;
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

## ===================================
## ### KEYWORD MANAGEMENT
## ===================================

if(isset($_POST['apt_create_new_keyword_set_button'])){ //create a new keyword set
	if(wp_verify_nonce($_POST['apt_create_new_keyword_set_hash'],'apt_create_new_keyword_set_nonce')){
		apt_create_new_keyword_set($_POST['apt_new_term_name'], $_POST['apt_new_related_keywords'], $_POST['apt_create_new_keyword_group']);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_delete_all_keywords_button'])){ //delete all keyword sets
	if(wp_verify_nonce($_POST['apt_keyword_set_editor_hash'],'apt_keyword_set_editor_nonce')){
		update_option('automatic_post_tagger_keywords', array()); //save empty array value
		apt_set_group_keyword_set_count(0, 4); //this line has to be placed after the group/keyword array update to ensure correct stats are generated!

		echo $apt_message_html_prefix_updated .'<strong>'. $apt_settings['apt_keyword_sets_total'] .'</strong> '. apt_get_grammatical_number($apt_settings['apt_keyword_sets_total'], 1, 2) .' '. apt_get_grammatical_number($apt_settings['apt_keyword_sets_total'], 2) .' been deleted.'. $apt_message_html_suffix;

		$apt_settings['apt_keyword_sets_total'] = 0; //reset stats - this must happen after the update message is displayed!
		$apt_settings['apt_highest_keyword_set_id'] = 0; //reset the last id
		update_option('automatic_post_tagger', $apt_settings); //save settings
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_delete_selected_keywords_button'])){ //delete selected keyword sets
	if(wp_verify_nonce($_POST['apt_keyword_set_editor_hash'],'apt_keyword_set_editor_nonce')){
		if(isset($_POST['apt_keyword_set_list_checkbox_'])){ //determine if any checkbox was checked
			$apt_kw_sets_new = $apt_kw_sets; //load current keyword sets 
			$apt_selected_keyword_set_count = 0;

			foreach($_POST['apt_keyword_set_list_checkbox_'] as $apt_id => $apt_value){ //loop for handling checkboxes
				//find the keyword by its id and unset it
				foreach($apt_kw_sets_new as $apt_sub_key => $apt_sub_array){
					if($apt_sub_array[0] == $apt_id){
						unset($apt_kw_sets_new[$apt_sub_key]);
						$apt_selected_keyword_set_count++;
					}
				} //-foreach
			} //-foreach checkbox ids

			update_option('automatic_post_tagger_keywords', $apt_kw_sets_new); //save keyword sets - this line must be placed before the count function in order to display correct stats
			apt_set_group_keyword_set_count(0, 3); //this line has to be placed after the group/keyword array update to ensure correct stats are generated!

			$apt_settings['apt_keyword_sets_total'] = count($apt_kw_sets_new);
			update_option('automatic_post_tagger', $apt_settings); //save settings

			echo $apt_message_html_prefix_updated .'<strong>'. $apt_selected_keyword_set_count .'</strong> selected '. apt_get_grammatical_number($apt_selected_keyword_set_count, 1, 2) .' '. apt_get_grammatical_number($apt_selected_keyword_set_count, 2) .' been deleted.'. $apt_message_html_suffix;
		}
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> You must choose at least one keyword in order to delete it.'. $apt_message_html_suffix;
		}
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_save_keyword_sets_button'])){ //saving keyword sets
	if(wp_verify_nonce($_POST['apt_keyword_set_editor_hash'],'apt_keyword_set_editor_nonce')){
		if($apt_settings['apt_item_editor_mode'] == 1){ //if KEM =1
			$apt_kw_sets_new = array(); //all keyword sets will be saved into this variable

			### variables for error reporting
			$apt_empty_term_name_error = 0;
			$apt_duplicate_term_name_error = 0;
			$apt_invalid_group_name_error = 0;
			$apt_new_saved_related_keywords_wildcard_warning = 0;
			$apt_new_saved_related_keywords_extra_spaces_warning = 0;

			foreach($_POST['apt_keyword_set_list_name_'] as $apt_id => $apt_value){ //$apt_value is necessary here
				### temporary variables for determining whether an error has occured (will be reset after each iteration)
				$apt_empty_term_name_error_temp = 0;
				$apt_duplicate_term_name_error_temp = 0;

				$apt_raw_saved_term_name = $_POST['apt_keyword_set_list_name_'][$apt_id];
				$apt_raw_saved_keyword_related_keywords = $_POST['apt_keyword_set_list_related_keywords_'][$apt_id];
				$apt_new_saved_group_id = $_POST['apt_keyword_set_list_group_'][$apt_id];

				### make sure that the group is always saved, even if an invalid value is provided
				if(apt_get_group_info($apt_new_saved_group_id, 2) === false){
					$apt_invalid_group_name_error = 1;
					$apt_new_saved_group_id = $apt_settings['apt_default_group'];
				}

				### generate errors
				if(empty($apt_raw_saved_term_name) or trim($apt_raw_saved_term_name) == ''){
					$apt_empty_term_name_error = 1;
					$apt_empty_term_name_error_temp = 1;
					$apt_new_saved_term_name = apt_get_keyword_info($apt_id, 2); //restore the previous value
				}

				//the loop should be executed only if the name hasn't been restored yet
				if($apt_empty_term_name_error_temp == 0){
					$apt_current_array_index = 0;
					//check whether the group name already exists in the array, if it does, restore the previous name to avoid duplicities
					foreach($apt_kw_sets_new as $apt_keyword_array){
						if(strtolower($apt_raw_saved_term_name) == strtolower($apt_keyword_array[1])){
							$apt_duplicate_term_name_error = 1;
							$apt_duplicate_term_name_error_temp = 1;

							$apt_new_saved_term_name = apt_get_keyword_info($apt_id, 2); //restore the previous value

							//if the raw name equals to the previous name, unset the subarray that is already in the array, add it again, but with its previous kw value
							if($apt_raw_saved_term_name == $apt_new_saved_term_name){
								$apt_new_restored_array = $apt_keyword_array;
								$apt_new_restored_array[1] = apt_get_keyword_info($apt_new_restored_array[0], 2);

								unset($apt_kw_sets_new[$apt_current_array_index]);
								array_push($apt_kw_sets_new, $apt_new_restored_array);
								$apt_current_array_index++;
							}

							break; //no need to continue the search if we found the duplicate name
						}
					} //-foreach
				} //-if name not restored

				### adjust user inputs
				if($apt_duplicate_term_name_error_temp == 0 and $apt_empty_term_name_error_temp == 0){ //the term name hasn't been restored, adjustments necessary
					//input correction
					if($apt_settings['apt_input_correction'] == 1){
						$apt_new_saved_term_name = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $apt_raw_saved_term_name); //replacing multiple whitespace characters with a space (if there were, say two spaces between words, this will convert them to one)
						$apt_new_saved_term_name = trim(stripslashes($apt_new_saved_term_name)); //trimming slashes and whitespace characters
					} //-input correction
					else{
						$apt_new_saved_term_name = stripslashes($apt_raw_saved_term_name); //stripping slashes
					} //-else input correction
				} //-if name not restored


				$apt_raw_saved_related_keywords_array = explode($apt_settings['apt_string_separator'], $_POST['apt_keyword_set_list_related_keywords_'][$apt_id]);
				$apt_new_saved_related_keywords_array = array();

				if(!empty($apt_raw_saved_related_keywords_array)){ //the submitted value is NOT empty
					foreach($apt_raw_saved_related_keywords_array as $apt_raw_saved_related_keyword){
						//input correction
						if($apt_settings['apt_input_correction'] == 1){
							$apt_new_saved_related_keyword = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $apt_raw_saved_related_keyword); //replacing multiple whitespace characters with a space (if there were, say two spaces between words, this will convert them to one)
							$apt_new_saved_related_keyword = preg_replace('/'. preg_quote($apt_settings['apt_string_separator'], '/') .'{2,}/', $apt_settings['apt_string_separator'], $apt_new_saved_related_keyword); //replacing multiple separators with one
							$apt_new_saved_related_keyword = preg_replace('/'. preg_quote($apt_settings['apt_wildcard_character'], '/') .'{2,}/', $apt_settings['apt_wildcard_character'], $apt_new_saved_related_keyword); //replacing multiple wildcards with one
							$apt_new_saved_related_keyword = trim(stripslashes($apt_new_saved_related_keyword)); //removing slashes, trimming whitespace characters from the beginning and the end
						} //-input correction
						else{
							$apt_new_saved_related_keyword = stripslashes($apt_raw_saved_related_keyword);

							### generate warnings
							if(substr($apt_new_saved_related_keyword, 0, 1) == ' ' or substr($apt_new_saved_related_keyword, -1, 1) == ' '){
								$apt_new_saved_related_keywords_extra_spaces_warning = 1;
							} 
						} //-else input correction

						//add the item only if it's not empty
						if(!empty($apt_new_saved_related_keyword)){
							array_push($apt_new_saved_related_keywords_array, $apt_new_saved_related_keyword);
						} //-if related keyword exists

						//generate warnings
						if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
							if(strstr($apt_new_saved_related_keyword, $apt_settings['apt_wildcard_character']) and ($apt_settings['apt_wildcards'] == 0)){ //mistake scenario
								$apt_new_saved_related_keywords_wildcard_warning = 1;
							}
						} //-if warnings allowed
					} //-foreach
				} //-if empty related keywords check

		 		array_push($apt_kw_sets_new, array($apt_id, $apt_new_saved_term_name, $apt_new_saved_related_keywords_array, $apt_new_saved_group_id)); //add the ID + keyword + related keywords + group ID at the end of the array

				### unsetting temp variables
				unset($apt_empty_term_name_error_temp);
				unset($apt_keyword_group_name_error_temp);
				unset($apt_new_saved_term_name); //the group name variable has to be unset as well!
			} //-foreach

			update_option('automatic_post_tagger_keywords', $apt_kw_sets_new); //save keywords
			apt_set_group_keyword_set_count(0, 3); //this line has to be placed after the group/keyword array update to ensure correct stats are generated!

			$apt_settings['apt_keyword_sets_total'] = count($apt_kw_sets_new); //save the number of current keywords
			update_option('automatic_post_tagger', $apt_settings); //save settings

			echo $apt_message_html_prefix_updated .'Keyword sets have been saved.'. $apt_message_html_suffix;


			### display errors
			if($apt_empty_term_name_error == 1){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> Some term names were missing; their previous values have been restored.'. $apt_message_html_suffix;
			}
			if($apt_duplicate_term_name_error == 1){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> Some term names were duplicate; their previous values have been restored.'. $apt_message_html_suffix;
			}
			if($apt_invalid_group_name_error == 1){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> Some configuration groups were invalid; applicable keyword sets were moved to the default group "<strong>'. apt_get_group_info($apt_settings['apt_default_group'], 2) .'</strong>".'. $apt_message_html_suffix;
			}

			### display warnings
			if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
				if($apt_new_saved_related_keywords_wildcard_warning == 1){
					echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Some related keywords contain the wildcard character, but wildcard support is currently disabled!'. $apt_message_html_suffix;
				}
				if($apt_new_saved_related_keywords_extra_spaces_warning == 1){ //mistake scenario
					echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> Some related keywords contain a space near string separators.'. $apt_message_html_suffix;
				}
			} //-if warnings allowed
		} //-if IEM = 1
		else{ //IEM =1
			apt_import_items_from_textarea($_POST['apt_keyword_set_editor_textarea'], 1);
		} //-else
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

## ===================================
## ### GROUP MANAGEMENT
## ===================================

if(isset($_POST['apt_create_new_group_button'])){ //create a new configuration group
	if(wp_verify_nonce($_POST['apt_create_new_group_hash'],'apt_create_new_group_nonce')){

		//set the status
		if(isset($_POST['apt_create_new_group_status'])){
			$apt_create_new_group_status = 1;
		} //-if status enabled
		else{
			$apt_create_new_group_status = 0;
		} //-else status disabled

		apt_create_new_group($_POST['apt_create_new_group_name'], $apt_create_new_group_status, $_POST['apt_create_new_group_term_limit'], $_POST['apt_create_new_group_taxonomies']);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_delete_all_groups_button'])){ //delete all groups
	if(wp_verify_nonce($_POST['apt_configuration_group_editor_hash'],'apt_configuration_group_editor_nonce')){
		if($apt_settings['apt_configuration_groups_total'] > 1){ //continue only if the number of groups is higher than 1
			$apt_reset_groups_array = array();
			$apt_deleted_groups_count = $apt_settings['apt_configuration_groups_total'] - 1;

			### delete all groups except for the default one
			foreach($apt_groups as $apt_group){ //create an array with the default group data only
				if($apt_settings['apt_default_group'] == $apt_group[0]){
					array_push($apt_reset_groups_array, array($apt_group[0], $apt_group[1], $apt_settings['apt_keyword_sets_total'], $apt_group[3], $apt_group[4], $apt_group[5])); //the KW count will remain the same as the total KW count if we are MOVING keyword sets only
					break;
				}
			} //-foreach

			### refresh stats
			$apt_settings['apt_highest_configuration_group_id'] = $apt_settings['apt_default_group']; //reset the last id - make it equal to the default group ID
			$apt_settings['apt_configuration_groups_total'] = 1;

			update_option('automatic_post_tagger_groups', $apt_reset_groups_array); //save the default group only
			update_option('automatic_post_tagger', $apt_settings); //save settings
			apt_nonexistent_groups_handling();
			apt_set_group_keyword_set_count(0, 3); //this line has to be placed after the group/keyword array update to ensure correct stats are generated!

			echo $apt_message_html_prefix_updated .'<strong>'. $apt_deleted_groups_count .'</strong> '. apt_get_grammatical_number($apt_deleted_groups_count, 1, 1) .' '. apt_get_grammatical_number($apt_deleted_groups_count, 2) .' been deleted.'. $apt_message_html_suffix;

		} //-if number of groups higher than 1
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The number of groups must be higher than 1.'. $apt_message_html_suffix;
		} //-else only one group exists
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_delete_selected_groups_button'])){ //delete selected groups
	if(wp_verify_nonce($_POST['apt_configuration_group_editor_hash'],'apt_configuration_group_editor_nonce')){
		if(isset($_POST['apt_configuration_group_list_checkbox_'])){ //determine if any checkbox was checked
			$apt_groups_new = $apt_groups; //load current groups
			$apt_selected_groups_count = 0;

			foreach($_POST['apt_configuration_group_list_checkbox_'] as $apt_id => $apt_value){ //loop for handling checkboxes
				//unset selected non-default groups
				foreach($apt_groups_new as $apt_group_key => $apt_group_array){
					if($apt_group_array[0] == $apt_id){ //handle only selected groups
						if($apt_group_array[0] != $apt_settings['apt_default_group']){ //only unset the group if it isn't the default one
							unset($apt_groups_new[$apt_group_key]);
							$apt_selected_groups_count++;
						} //-if the current group isn't the default one
					} //-handle only selected groups
				} //-foreach groups
			} //-foreach checkboxes

			//refresh stats
			$apt_settings['apt_configuration_groups_total'] = count($apt_groups_new);
			update_option('automatic_post_tagger_groups', $apt_groups_new); //save groups
			update_option('automatic_post_tagger', $apt_settings); //save settings
			apt_nonexistent_groups_handling();
			apt_set_group_keyword_set_count(0, 3); //this line has to be placed after the group/keyword array update to ensure correct stats are generated!

			echo $apt_message_html_prefix_updated .'<strong>'. $apt_selected_groups_count .'</strong> selected '. apt_get_grammatical_number($apt_selected_groups_count, 1, 1) .' '. apt_get_grammatical_number($apt_selected_groups_count, 2) .' been deleted.'. $apt_message_html_suffix;
		}
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> You must choose at least one group in order to delete it.'. $apt_message_html_suffix;
		}
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_save_groups_button'])){ //saving changed groups
	if(wp_verify_nonce($_POST['apt_configuration_group_editor_hash'],'apt_configuration_group_editor_nonce')){
		if($apt_settings['apt_item_editor_mode'] == 1){ //if KEM =1
			$apt_groups_new = array();

			### variables for error reporting
			$apt_empty_group_name_error = 0;
			$apt_duplicate_group_name_error = 0;
			$apt_invalid_group_term_limit_error = 0;
			$apt_invalid_taxonomies_warning = 0;
			$apt_groups_invalid_taxonomies_disabled = 0;
			$apt_groups_no_taxonomies_disabled = 0;

			foreach($_POST['apt_configuration_group_list_name_'] as $apt_id => $apt_value){ //$apt_value is necessary here
				### temporary variables for determining whether an error has occured (will be reset after each iteration)
				$apt_empty_group_name_error_temp = 0;
				$apt_duplicate_group_name_error_temp = 0;

				$apt_raw_saved_group_name = $_POST['apt_configuration_group_list_name_'][$apt_id];
				$apt_raw_saved_group_term_limit = $_POST['apt_configuration_group_list_term_limit_'][$apt_id];

				### generate errors
				if(empty($apt_raw_saved_group_name) or trim($apt_raw_saved_group_name) == ''){
					$apt_empty_group_name_error++;
					$apt_empty_group_name_error_temp = 1;
					$apt_new_saved_group_name = apt_get_group_info($apt_id, 2);
				}

				//the loop should be executed only if the name hasn't been restored yet
				if($apt_empty_group_name_error_temp == 0){
					$apt_current_array_index = 0;
					//check whether the group name already exists in the array, if it does, restore the previous name to avoid duplicities
					foreach($apt_groups_new as $apt_group_array){
						if(strtolower($apt_raw_saved_group_name) == strtolower($apt_group_array[1])){
							$apt_duplicate_group_name_error++;
							$apt_duplicate_group_name_error_temp = 1;

							$apt_new_saved_group_name = apt_get_group_info($apt_id, 2); //restore the previous value

							//if the raw name equals to the previous name, unset the subarray that is already in the array, add it again, but with its previous kw value
							if($apt_raw_saved_group_name == $apt_new_saved_group_name){
								$apt_new_restored_array = $apt_group_array;
								$apt_new_restored_array[1] = apt_get_group_info($apt_new_restored_array[0], 2);

								unset($apt_groups_new[$apt_current_array_index]);
								array_push($apt_groups_new, $apt_new_restored_array);
								$apt_current_array_index++;
							}

							break; //no need to continue the search if we found the duplicate name
						}
					} //-foreach
				} //-if name not restored

				if(!preg_match('/^[1-9][0-9]*$/', $apt_raw_saved_group_term_limit)){ //positive integers only
					$apt_invalid_group_term_limit_error++;
					$apt_raw_saved_group_term_limit = apt_get_group_info($apt_id, 5);
				}

				### set the status
				if(isset($_POST['apt_configuration_group_list_status_'][$apt_id])){
					$apt_raw_saved_group_status = 1;
				} //-if status enabled
				else{
					$apt_raw_saved_group_status = 0;
				} //-else status disabled


				### adjust user inputs
				if($apt_duplicate_group_name_error_temp == 0 and $apt_empty_group_name_error_temp == 0){ //the group name hasn't been restored, adjustments necessary
					//input correction
					if($apt_settings['apt_input_correction'] == 1){
						$apt_new_saved_group_name = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $apt_raw_saved_group_name); //replacing multiple whitespace characters with a space (if there were, say two spaces between words, this will convert them to one)
						$apt_new_saved_group_name = trim(stripslashes($apt_new_saved_group_name)); //trimming slashes and whitespace characters
					} //-input correction
					else{
						$apt_new_saved_group_name = stripslashes($apt_raw_saved_group_name); //stripping slashes
					} //-else input correction
				} //-if name not restored

				$apt_raw_saved_taxonomies_array = explode($apt_settings['apt_string_separator'], $_POST['apt_configuration_group_list_taxonomies_'][$apt_id]);
				$apt_new_saved_taxonomies_array = array();

				if(!empty($apt_raw_saved_taxonomies_array)){ //the submitted value is NOT empty
					foreach($apt_raw_saved_taxonomies_array as $apt_raw_saved_taxonomy){
						//input correction
						if($apt_settings['apt_input_correction'] == 1){
							$apt_new_saved_taxonomy = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $apt_raw_saved_taxonomy); //replacing multiple whitespace characters with a space (if there were, say two spaces between words, this will convert them to one)
							$apt_new_saved_taxonomy = preg_replace('/'. preg_quote($apt_settings['apt_string_separator'], '/') .'{2,}/', $apt_settings['apt_string_separator'], $apt_new_saved_taxonomy); //replacing multiple separators with one
							$apt_new_saved_taxonomy = preg_replace('/'. preg_quote($apt_settings['apt_wildcard_character'], '/') .'{2,}/', $apt_settings['apt_wildcard_character'], $apt_new_saved_taxonomy); //replacing multiple wildcards with one
							$apt_new_saved_taxonomy = trim(stripslashes($apt_new_saved_taxonomy)); //removing slashes, trimming whitespace characters from the beginning and the end
						} //-input correction
						else{
							$apt_new_saved_taxonomy = stripslashes($apt_raw_saved_taxonomy);
						} //-else input correction

						//add the item only if it's not empty
						if(!empty($apt_new_saved_taxonomy)){
							array_push($apt_new_saved_taxonomies_array, $apt_new_saved_taxonomy);

							if(!taxonomy_exists($apt_new_saved_taxonomy) and $apt_raw_saved_group_status != 0){
								$apt_invalid_taxonomies_warning++;
								if($apt_settings['apt_input_correction'] == 1){
									$apt_raw_saved_group_status = 0; //if taxonomies are invalid, disable the group
									$apt_groups_invalid_taxonomies_disabled++;
								} //-input correction
							}
						} //-if taxonomies exist
					} //-foreach
				} //-if empty taxonomies check

				### generate warnings
				if(empty($apt_new_saved_taxonomies_array) and $apt_raw_saved_group_status != 0 and $apt_settings['apt_input_correction'] == 1){
					$apt_raw_saved_group_status = 0; //if taxonomies are missing and the group isn't disabled yet, disable the group
					$apt_groups_no_taxonomies_disabled++;
				}

	 			array_push($apt_groups_new, array($apt_id, $apt_new_saved_group_name, 'n/a', $apt_raw_saved_group_status, $apt_raw_saved_group_term_limit, $apt_new_saved_taxonomies_array)); //KW count is "n/a" because it will be changed later

				### unsetting temp variables
				unset($apt_empty_group_name_error_temp);
				unset($apt_duplicate_group_name_error_temp);
				unset($apt_new_saved_group_name); //the group name variable has to be unset as well!
			} //-foreach

			update_option('automatic_post_tagger_groups', $apt_groups_new); //save groups
			$apt_settings['apt_configuration_groups_total'] = count($apt_groups_new); //save the number of current groups
			update_option('automatic_post_tagger', $apt_settings); //save settings
			apt_set_group_keyword_set_count(0, 3); //this line has to be placed after the group/keyword array update to ensure correct stats are generated!

			echo $apt_message_html_prefix_updated .'Configuration groups have been saved.'. $apt_message_html_suffix;

			### display errors
			if($apt_empty_group_name_error > 0){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> '. $apt_empty_group_name_error .' group names were missing; their previous values have been restored.'. $apt_message_html_suffix;
			}
			if($apt_duplicate_group_name_error > 0){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> '. $apt_duplicate_group_name_error .' group names were duplicate; their previous values have been restored.'. $apt_message_html_suffix;
			}
			if($apt_invalid_group_term_limit_error > 0){
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> '. $apt_invalid_group_term_limit_error .' group term limits weren\'t positive integers; their previous values have been restored.'. $apt_message_html_suffix;
			}

			### display warnings
			if($apt_settings['apt_hide_warning_messages'] == 0){ //if warnings allowed
				if($apt_groups_no_taxonomies_disabled > 0){
					echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_groups_no_taxonomies_disabled .' configuration '. apt_get_grammatical_number($apt_groups_no_taxonomies_disabled, 1, 1) .' without taxonomies '. apt_get_grammatical_number($apt_groups_no_taxonomies_disabled, 1) .' been disabled. <span class="apt_help" title="Keyword sets belonging to disabled configuration groups are ignored when posts are being tagged.">i</span>'. $apt_message_html_suffix;
				}
				if($apt_groups_invalid_taxonomies_disabled > 0){
					echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_groups_invalid_taxonomies_disabled .' configuration '. apt_get_grammatical_number($apt_groups_invalid_taxonomies_disabled, 1, 1) .' with unregistered taxonomies '. apt_get_grammatical_number($apt_groups_invalid_taxonomies_disabled, 1) .' been disabled. <span class="apt_help" title="Keyword sets belonging to disabled configuration groups are ignored when posts are being tagged.">i</span>'. $apt_message_html_suffix;
				}
				if($apt_invalid_taxonomies_warning > 0){
					echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> '. $apt_invalid_taxonomies_warning .' configuration '. apt_get_grammatical_number($apt_invalid_taxonomies_warning, 1, 1) .' '. apt_get_grammatical_number($apt_invalid_taxonomies_warning, 1) .' been assigned unregistered taxonomies.'. $apt_message_html_suffix;
				}
			} //-if warnings allowed
		} //-if IEM = 1
		else{ //IEM =1
			apt_import_items_from_textarea($_POST['apt_configuration_groups_editor_textarea'], 2);
		} //-else
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

## ===================================
## ### PLUGIN DATA IMPORT
## ===================================

if(isset($_POST['apt_import_terms_from_taxonomies_button'])){ //import terms
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){

		$apt_stripslashed_taxonomies = stripslashes($_POST['apt_taxonomies']);

		if(empty($_POST['apt_taxonomies'])){
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The option "apt_taxonomies" couldn\'t be saved, because the submitted value was empty.'. $apt_message_html_suffix;
		}
		else{
			//input correction
			if($apt_settings['apt_input_correction'] == 1){
				$apt_taxonomies_trimmed = trim(trim($apt_stripslashed_taxonomies, $apt_settings['apt_string_separator']));
				$apt_taxonomies_trimmed = preg_replace('/'. preg_quote($apt_settings['apt_string_separator'], '/') .'{2,}/', $apt_settings['apt_string_separator'], $apt_taxonomies_trimmed); //replacing multiple separators with one
				$apt_taxonomies_trimmed = preg_replace(array('/\s{2,}/', '/[\t\n]/'), '', $apt_taxonomies_trimmed); //removing whitespace characters
				$apt_submitted_taxonomies_array = explode($apt_settings['apt_string_separator'], $apt_taxonomies_trimmed);
			} //-input correction
			else{
				$apt_submitted_taxonomies_array = explode($apt_settings['apt_string_separator'], $apt_stripslashed_taxonomies);
			} //-else input correction

			$apt_new_taxonomies_array = array(); //we need an empty array

			//if a taxonomy doesn't exist, remove it from the array
			foreach($apt_submitted_taxonomies_array as $apt_single_taxonomy_index => $apt_single_taxonomy){
				if(!taxonomy_exists($apt_single_taxonomy)){
					unset($apt_submitted_taxonomies_array[$apt_single_taxonomy_index]);
					echo $apt_message_html_prefix_error .'<strong>Error:</strong> The taxonomy "<strong>'. htmlspecialchars($apt_single_taxonomy) .'</strong>" couldn\'t be saved, because it isn\'t registered.'. $apt_message_html_suffix;
				} //-if taxonomy doesn't exist
				else{
					if(!in_array($apt_single_taxonomy, $apt_new_taxonomies_array)){
						array_push($apt_new_taxonomies_array, $apt_single_taxonomy); //add the taxonomy to the array if it isn't there already
					} //-if taxonomy isn't in the settings array
				} //-else taxonomy exists
			} //-foreach

			if(!empty($apt_new_taxonomies_array)){
				$apt_settings['apt_taxonomies'] = $apt_new_taxonomies_array;
				update_option('automatic_post_tagger', $apt_settings); //save settings (submitted taxonomies, existing only)
			}
		} //-else taxonomies not empty

		apt_import_terms_from_taxonomies($apt_settings['apt_taxonomies'], $_POST['apt_import_terms_from_taxonomies_column']);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_import_plugin_settings_from_file_button'])){ //import plugin settings
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){
		apt_import_plugin_data_from_file($_FILES['apt_import_plugin_settings_file'], 1);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}

}

if(isset($_POST['apt_import_keyword_sets_from_file_button'])){ //import keyword sets
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){
		apt_import_plugin_data_from_file($_FILES['apt_import_keyword_sets_file'], 2);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_import_configuration_groups_from_file_button'])){ //import configuration groups
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){
		apt_import_plugin_data_from_file($_FILES['apt_import_configuration_groups_file'], 3);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

## ===================================
## ### PLUGIN DATA EXPORT
## ===================================

if(isset($_POST['apt_export_plugin_settings_json_button'])){ //export plugin settings - JSON
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){
		apt_export_plugin_data(1, 1);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_export_keyword_sets_json_button'])){ //export keyword sets - JSON
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){
		apt_export_plugin_data(2, 1);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_export_keyword_sets_csv_button'])){ //export keyword sets - CSV
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){
		apt_export_plugin_data(2, 2);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_export_configuration_groups_json_button'])){ //export configuration groups - JSON
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){
		apt_export_plugin_data(3, 1);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_export_configuration_groups_csv_button'])){ //export configuration groups - CSV
	if(wp_verify_nonce($_POST['apt_export_import_plugin_data_hash'],'apt_export_import_plugin_data_nonce')){
		apt_export_plugin_data(3, 2);
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

## ===================================
## ### BULK TAGGING
## ===================================

if(isset($_POST['apt_bulk_tagging_settings_button'])){
	if(wp_verify_nonce($_POST['apt_bulk_tagging_tool_hash'],'apt_bulk_tagging_tool_nonce')){
		//get the database post ID range
		$apt_database_range = apt_get_bulk_tagging_range(true);

		### common settings for both tagging tools
		$apt_settings['apt_bulk_tagging_range_lower_bound'] = $_POST['apt_bulk_tagging_range_lower_bound'];
		$apt_settings['apt_bulk_tagging_range_upper_bound'] = $_POST['apt_bulk_tagging_range_upper_bound'];
		$apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] = (isset($_POST['apt_bulk_tagging_range_custom_lower_bound_update'])) ? '1' : '0';

		if(preg_match('/^(0|[1-9][0-9]*){1}$/', $_POST['apt_bulk_tagging_range_custom_lower_bound'])){ //non-negative integers only
			$apt_settings['apt_bulk_tagging_range_custom_lower_bound'] = $_POST['apt_bulk_tagging_range_custom_lower_bound'];
		}
		else{
			$apt_bulk_tagging_errors++;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The lowest custom post ID couldn\'t be saved, because the submitted value wasn\'t a positive integer.'. $apt_message_html_suffix;
		}
		if(preg_match('/^(0|[1-9][0-9]*){1}$/', $_POST['apt_bulk_tagging_range_custom_upper_bound'])){  //non-negative integers only
			$apt_settings['apt_bulk_tagging_range_custom_upper_bound'] = $_POST['apt_bulk_tagging_range_custom_upper_bound'];
		}
		else{
			$apt_bulk_tagging_errors++;

			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The highest custom post ID couldn\'t be saved, because the submitted value wasn\'t a positive integer.'. $apt_message_html_suffix;
		}

		if(preg_match('/^[1-9][0-9]*$/', $_POST['apt_bulk_tagging_posts_per_batch'])){ //positive integers only
			$apt_settings['apt_bulk_tagging_posts_per_batch'] = $_POST['apt_bulk_tagging_posts_per_batch'];
		}
		else{
			$apt_bulk_tagging_errors++;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The number of posts processed per batch couldn\'t be saved, because the submitted value wasn\'t a positive integer.'. $apt_message_html_suffix;
		}
		if(preg_match('/^(0|[1-9][0-9]*){1}$/', $_POST['apt_bulk_tagging_delay'])){ //non-negative integers only
			$apt_settings['apt_bulk_tagging_delay'] = $_POST['apt_bulk_tagging_delay'];
		}
		else{
			$apt_bulk_tagging_errors++;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The time delay between batches couldn\'t be saved, because the submitted value wasn\'t a positive integer.'. $apt_message_html_suffix;
		}
		if(preg_match('/^[1-9][0-9]*$/', $_POST['apt_bulk_tagging_event_recurrence'])){ //positive integers only
			$apt_settings['apt_bulk_tagging_event_recurrence'] = $_POST['apt_bulk_tagging_event_recurrence'];
		}
		else{
			$apt_bulk_tagging_errors++;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> Bulk tagging couldn\'t be scheduled, because the submitted value wasn\'t a positive integer.'. $apt_message_html_suffix;
		}

		$apt_settings['apt_bulk_tagging_event_unscheduling'] = (isset($_POST['apt_bulk_tagging_event_unscheduling'])) ? '1' : '0';

		if(!preg_match('/^(0|[1-9][0-9]*){1}$/', $apt_database_range[0]) or !preg_match('/^(0|[1-9][0-9]*){1}$/', $apt_database_range[1])){ //non-negative integers only
			$apt_bulk_tagging_errors++;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> Database post IDs couldn\'t be retrieved.'. $apt_message_html_suffix;
		}

		### value comparison
		if($apt_settings['apt_bulk_tagging_range_lower_bound'] == 1){
			$apt_bulk_tagging_range_lower_bound_value = $apt_database_range[0];
		}
		else{
			$apt_bulk_tagging_range_lower_bound_value = $apt_settings['apt_bulk_tagging_range_custom_lower_bound'];
		}
		if($apt_settings['apt_bulk_tagging_range_upper_bound'] == 1){
			$apt_bulk_tagging_range_upper_bound_value = $apt_database_range[1];
		}
		else{
			$apt_bulk_tagging_range_upper_bound_value = $apt_settings['apt_bulk_tagging_range_custom_upper_bound'];
		}

		if(preg_match('/^(0|[1-9][0-9]*){1}$/', $apt_bulk_tagging_range_lower_bound_value) and preg_match('/^(0|[1-9][0-9]*){1}$/', $apt_bulk_tagging_range_upper_bound_value)){ //non-negative integers only
			if($apt_bulk_tagging_range_lower_bound_value > $apt_bulk_tagging_range_upper_bound_value){ //if the lower value isn't higher than the higher one
				$apt_bulk_tagging_errors++;
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> The lowest post ID can\'t be higher than the highest post ID.'. $apt_message_html_suffix;
				echo $apt_message_html_prefix_error .'<strong>Error:</strong> The post ID range couldn\'t be generated.'. $apt_message_html_suffix;
			}
		}
		else{
			$apt_bulk_tagging_errors++;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The post ID range couldn\'t be generated.'. $apt_message_html_suffix;
		}

		update_option('automatic_post_tagger', $apt_settings); //save settings

		echo $apt_message_html_prefix_updated .'Bulk tagging tool settings have been saved.'. $apt_message_html_suffix;

		if($apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] == 1 and $apt_settings['apt_bulk_tagging_range_lower_bound'] != 2){
			echo $apt_message_html_prefix_warning .'<strong>Warning:</strong> The option "Update the Custom post ID to the lastly processed post ID" is enabled, but the "Lower bound of the post ID range" is not set to "Custom post ID". While the Custom post ID will be automatically updated, it will not be used as a lower bound of the post ID range when creating the post queue.'. $apt_message_html_suffix;
		}

	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_single_bulk_tagging_event_button'])){
	if(wp_verify_nonce($_POST['apt_bulk_tagging_tool_hash'],'apt_bulk_tagging_tool_nonce')){
		### if the queue isn't empty and the recurring event is supposed to run now, don't continue
		if(wp_next_scheduled('apt_bulk_tagging_event_single_batch') !== false and !empty($apt_settings['apt_bulk_tagging_queue'])){
			$apt_bulk_tagging_errors++;
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> The bulk tagging tool couldn\'t be run, because a scheduled bulk tagging event is currently in progress.'. $apt_message_html_suffix;
		}

		$apt_bulk_tagging_errors += apt_get_tagging_errors();

		#################################################################
		### check whether some errors occured - if the variable is not set, continue
		if($apt_bulk_tagging_errors == 0){
			$apt_queued_ids_count = apt_add_post_ids_to_queue();

			if($apt_queued_ids_count != 0){ //no &bt in the URL, no tagging happened yet, some post IDs are in the queue
				//since the admin_head/admin_print_scripts hook doesn't work inside the options page function and we cannot use header() or wp_redirect() here
				//(because some web hosts will throw the "headers already sent" error), so we need to use a javascript redirect or a meta tag printed to a bad place
				//OR we could constantly check the database for a saved value and use admin_menu somewhere else (I am not sure if this is a good idea)

				echo $apt_message_html_prefix_note .'<strong>Note:</strong> Bulk tagging is currently in progress. This may take some time.'. $apt_message_html_suffix;
				echo '<p><strong>Posts in the queue:</strong> '. $apt_queued_ids_count .'</p>'; //display number of posts in queue
				echo '<p class="apt_small">This page should be automatically refreshed in '. $apt_settings['apt_bulk_tagging_delay'] .' '. apt_get_grammatical_number($apt_settings['apt_bulk_tagging_delay'], 1, 12) .'. <a href="'. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=1'), 'apt_bulk_tagging_1_nonce') .'">Click here if that doesn\'t happen &raquo;</a></p>'; //display an alternative link if methods below fail
				echo '<script type="text/javascript">setTimeout(function(){window.location.replace("'. str_replace('&amp;', '&', wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=1'), 'apt_bulk_tagging_1_nonce')) .'")}, '. $apt_settings['apt_bulk_tagging_delay']*1000 .')</script>'; //the str_replace function is here because the wp_nonce_url function provides &amp; instead of &, so I need to replace it or the web browser won't redirect anything; the number of seconds has to be multiplied by 1000 here
				echo '<noscript><meta http-equiv="refresh" content="'. $apt_settings['apt_bulk_tagging_delay'] .';url='. wp_nonce_url(admin_url('options-general.php?page=automatic-post-tagger&bt=1'), 'apt_bulk_tagging_1_nonce') .'"></noscript>'; //if use the meta tag to refresh the page
				exit;
			}
		} //-if no errors found
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_recurring_bulk_tagging_event_button'])){
	if(wp_verify_nonce($_POST['apt_bulk_tagging_tool_hash'],'apt_bulk_tagging_tool_nonce')){
		$apt_bulk_tagging_errors += apt_get_tagging_errors();

		if($apt_bulk_tagging_errors == 0){
			apt_schedule_bulk_tagging_event();
			echo $apt_message_html_prefix_updated .'Bulk tagging has been scheduled to run every '. $apt_settings['apt_bulk_tagging_event_recurrence'] .' '. apt_get_grammatical_number($apt_settings['apt_bulk_tagging_event_recurrence'], 1, 11) .'. Next bulk tagging event: </code>'. get_date_from_gmt(date('Y-m-d H:i:s', wp_next_scheduled('apt_bulk_tagging_event'))) .'</code>'. $apt_message_html_suffix;
		}
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

if(isset($_POST['apt_unschedule_bulk_tagging_event_button'])){
	if(wp_verify_nonce($_POST['apt_bulk_tagging_unschedule_event_hash'],'apt_bulk_tagging_unschedule_event_nonce')){
		$apt_event_unscheduled = apt_unschedule_bulk_tagging_event();

		if($apt_event_unscheduled === true){
			echo $apt_message_html_prefix_updated .'Recurring bulk tagging event has been unscheduled.'. $apt_message_html_suffix;
		}
		else{
			echo $apt_message_html_prefix_error .'<strong>Error:</strong> There\'s no event to unschedule (it has been already unscheduled).'. $apt_message_html_suffix;
		}
	} //-nonce check
	else{ //the nonce is invalid
		die($apt_invalid_nonce_message);
	}
}

### update variables to ensure that accurate data is displayed
$apt_settings = get_option('automatic_post_tagger');
$apt_groups = get_option('automatic_post_tagger_groups');
$apt_kw_sets = get_option('automatic_post_tagger_keywords');

## =========================================================================
## ### USER INTERFACE
## =========================================================================
?>

<div id="poststuff" class="metabox-holder has-right-sidebar">
	<div class="inner-sidebar">
		<div id="side-sortables" class="meta-box-sortabless" style="position:relative;">

			<!-- postbox -->
			<div class="postbox">
				<h3 class="hndle"><span>At a glance</span></h3>
				<div class="inside">
					<ul>
						<li><strong>Status:</strong> <?php if(apt_get_tagging_errors(0) == 0){if($apt_settings['apt_run_apt_publish_post'] == 0 and $apt_settings['apt_run_apt_save_post'] == 0 and $apt_settings['apt_run_apt_wp_insert_post'] == 0){echo '<span class="apt_orange">Automatic processing disabled</span> <span class="apt_help" title="APT can process posts only when running the bulk tagging tool.">i</span>';}else{echo '<span class="apt_green">Ready to process posts</span>';}}else{echo '<span class="apt_red">Unable to process posts</span> <span class="apt_help" title="Your current settings and/or the lack of processable posts prevent the tagging tool from being run.">i</span>';} ?></li>
						<li>Scheduled bulk tagging: <?php if(wp_next_scheduled('apt_bulk_tagging_event_single_batch') !== false){echo '<span class="apt_orange">In progress</span>';}elseif(wp_next_scheduled('apt_bulk_tagging_event') !== false){echo '<span class="apt_green">Enabled</span>';}else{echo '<span class="apt_gray">Disabled</span>';} ?></li>
						<li>Automatic backups: <?php if($apt_settings['apt_export_plugin_data_after_update'] == 1 and $apt_settings['apt_export_plugin_data_before_update'] == 1){echo '<span class="apt_green">Enabled</span>';}elseif($apt_settings['apt_export_plugin_data_after_update'] == 1 xor $apt_settings['apt_export_plugin_data_before_update'] == 1){echo '<span class="apt_orange">Partially enabled</span>';}else{echo '<span class="apt_red">Disabled</span>';} ?></li>
						<?php if($apt_settings['apt_nonexistent_groups_handling'] == 2){echo '<li>Nonexistent groups handling: <span class="apt_red">Delete KWS</span></li>';} ?>
						<?php if($apt_settings['apt_input_correction'] == 0){echo '<li>Input correction: <span class="apt_red">Disabled</span></li>';} ?>
						<?php if($apt_settings['apt_hide_warning_messages'] == 1){echo '<li>Warning messages: <span class="apt_orange">Hidden</span></li>';} ?>
						<?php if($apt_settings['apt_hide_update_messages'] == 1){echo '<li>Update notifications: <span class="apt_orange">Hidden</span></li>';} ?>
					</ul>
				</div>
			</div>
			<!-- //-postbox -->

			<!-- postbox -->
			<div class="postbox">
				<h3 class="hndle"><span>Useful links</span></h3>
				<div class="inside">
						<ul>
							<li><a href="https://wordpress.org/plugins/automatic-post-tagger/"><span class="apt_icon apt_wp"></span>Plugin homepage</a></li>
							<li><a href="https://wordpress.org/support/plugin/automatic-post-tagger"><span class="apt_icon apt_wp"></span>Support forum</a></li>
							<li><a href="https://wordpress.org/plugins/automatic-post-tagger/faq"><span class="apt_icon apt_wp"></span>Frequently asked questions</a> </li>
						</ul>
				</div>
			</div>
			<!-- //-postbox -->

			<!-- postbox -->
			<div class="postbox">
				<h3 class="hndle"><span>Do you like the plugin?</span></h3>
				<div class="inside">
					<p>If you find APT useful and want to say thanks, you can do so by rating the plugin in the official repository or by supporting its further development on Patreon.</p>
						<ul>
							<li><a href="https://wordpress.org/support/view/plugin-reviews/automatic-post-tagger"><span class="apt_icon apt_rate"></span>Rate APT on WordPress.org</a></li>
							<li><a href="https://www.patreon.com/devtard"><span class="apt_icon apt_patreon"></span>Become a patron on Patreon</a></li>
						</ul>

					<p class="apt_gray apt_small">People who supported this release: <u><a href="http://www.jeans-online.kaufen/">Axel&nbsp;S.</a></u>, <u>Chris&nbsp;H.</u>, <u>Christopher&nbsp;W.</u>, <u>Jenny&nbsp;S.</u>, <u>MTJ&nbsp;Media</u> and 3 others.</p>
				</div>
			</div><!-- //-postbox -->

		</div><!-- //-side-sortables -->
	</div><!-- //-inner-sidebar -->

	<div class="has-sidebar sm-padded">
		<div id="post-body-content" class="has-sidebar-content">
			<div class="meta-box-sortabless">

				<!-- postbox -->
				<form action="<?php echo admin_url('options-general.php?page=automatic-post-tagger'); ?>" method="post">
				<div class="postbox">
					<div onclick="apt_set_widget_visibility(1);" class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Settings</span></h3>

					<div class="inside" id="apt_widget_id_[1]" <?php echo apt_get_widget_visibility(1); ?>>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									Run APT when posts are: <span class="apt_help" title="These options determine when the plugin should automatically process and tag posts.">i</span>
								</th>
								<td>
									<input type="checkbox" name="apt_run_apt_publish_post" id="apt_run_apt_publish_post" <?php if($apt_settings['apt_run_apt_publish_post'] == 1) echo 'checked="checked"'; ?>> <label for="apt_run_apt_publish_post">Published or updated</label><br />
									<input type="checkbox" name="apt_run_apt_wp_insert_post" id="apt_run_apt_wp_insert_post" <?php if($apt_settings['apt_run_apt_wp_insert_post'] == 1) echo 'checked="checked"'; ?>> <label for="apt_run_apt_wp_insert_post">Imported</label> <span class="apt_help" title="If enabled, APT will process posts created by the function 'wp_insert_post' (usually used by post import tools).">i</span><br />
									<input type="checkbox" name="apt_run_apt_save_post" id="apt_run_apt_save_post" <?php if($apt_settings['apt_run_apt_save_post'] == 1) echo 'checked="checked"'; ?> onClick="if(document.getElementById('apt_run_apt_save_post').checked){return confirm('Are you sure? If enabled, the plugin will process posts automatically after every manual and automatic post save!')}"> <label for="apt_run_apt_save_post">Saved</label> <span class="apt_help" title="If enabled, APT will process posts when they're saved (that includes automatic saves), published or updated.">i</span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Analyzed post fields: <span class="apt_help" title="APT will look for terms and their related keywords in selected areas.">i</span>
								</th>
								<td>
									<input type="checkbox" name="apt_title" id="apt_title" <?php if($apt_settings['apt_title'] == 1) echo 'checked="checked"'; ?>> <label for="apt_title">Title</label><br />
									<input type="checkbox" name="apt_content" id="apt_content" <?php if($apt_settings['apt_content'] == 1) echo 'checked="checked"'; ?>> <label for="apt_content">Body content</label><br />
									<input type="checkbox" name="apt_excerpt" id="apt_excerpt" <?php if($apt_settings['apt_excerpt'] == 1) echo 'checked="checked"'; ?>> <label for="apt_excerpt">Excerpt</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Search for these KW set items: <span class="apt_help" title="APT will search posts for selected keyword set items.">i</span>
								</th>
								<td>
									<input type="checkbox" name="apt_search_for_term_name" id="apt_search_for_term_name" <?php if($apt_settings['apt_search_for_term_name'] == 1) echo 'checked="checked"'; ?>> <label for="apt_search_for_term_name">Term name</label><br />
									<input type="checkbox" name="apt_search_for_related_keywords" id="apt_search_for_related_keywords" <?php if($apt_settings['apt_search_for_related_keywords'] == 1) echo 'checked="checked"'; ?>> <label for="apt_search_for_related_keywords">Related keywords</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Old taxonomy terms handling: <span class="apt_help" title="This option determines what happens if there already are some taxonomy terms assigned to posts.">i</span>
								</th>
								<td>
									<input type="radio" name="apt_old_terms_handling" id="apt_old_terms_handling_1" value="1" <?php if($apt_settings['apt_old_terms_handling'] == 1) echo 'checked="checked"'; ?>> <label for="apt_old_terms_handling_1">Append new terms to old terms</label><br />
									<input type="radio" name="apt_old_terms_handling" id="apt_old_terms_handling_2" value="2" <?php if($apt_settings['apt_old_terms_handling'] == 2) echo 'checked="checked"'; ?>> <label for="apt_old_terms_handling_2">Replace old terms with newly generated ones</label> <span class="apt_help" title="Taxonomy terms assigned to posts will always correspond with the posts' current content.">i</span><br />
									<span class="apt_sub_option"><input type="checkbox" name="apt_old_terms_handling_2_remove_old_terms" id="apt_old_terms_handling_2_remove_old_terms" <?php if($apt_settings['apt_old_terms_handling_2_remove_old_terms'] == 1) echo 'checked="checked"'; ?>> <label for="apt_old_terms_handling_2_remove_old_terms">Remove old terms if new ones aren't found</label> <span class="apt_help" title="Already assigned terms will be removed from posts even if the plugin doesn't find new ones (useful for removing old non-relevant terms).">i</span><br />
									<input type="radio" name="apt_old_terms_handling" id="apt_old_terms_handling_3" value="3" <?php if($apt_settings['apt_old_terms_handling'] == 3) echo 'checked="checked"'; ?>> <label for="apt_old_terms_handling_3">Do nothing</label> <span class="apt_help" title="The tagging function will skip posts which already have taxonomy terms.">i</span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="apt_taxonomy_term_limit">Taxonomy term limit:</label> <span class="apt_help" title="This is the maximum number of terms per single taxonomy which won't be exceeded when tagging posts.">i</span>
								</th>
								<td>
									 <input class="apt_width_6" type="text" name="apt_taxonomy_term_limit" id="apt_taxonomy_term_limit" value="<?php echo $apt_settings['apt_taxonomy_term_limit']; ?>" maxlength="10"><br />
								</td>
							</tr>
						</table>

						<h3 class="title">Advanced settings</h3>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="apt_post_types">Allowed post types:</label> <span class="apt_help" title="Only specified post types (separated by &quot;<?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?>&quot;) will be processed. Example: &quot;post<?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?>page&quot;. The APT meta box is displayed next to the post editor only if the post type of the currently edited post is listed here.">i</span>
								</th>
								<td>
									<input type="text" name="apt_post_types" id="apt_post_types" value="<?php echo htmlspecialchars(implode($apt_settings['apt_string_separator'], $apt_settings['apt_post_types'])); ?>" maxlength="5000" size="15">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="apt_post_statuses">Allowed post statuses:</label> <span class="apt_help" title="Only posts with these statuses (separated by &quot;<?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?>&quot;) will be processed. You can use these statuses: &quot;auto-draft&quot;, &quot;draft&quot;, &quot;future&quot;, &quot;inherit&quot;, &quot;pending&quot;, &quot;private&quot;, &quot;publish&quot;, &quot;trash&quot;.">i</span></td>
								</th>
								<td><input type="text" name="apt_post_statuses" id="apt_post_statuses" value="<?php echo htmlspecialchars(implode($apt_settings['apt_string_separator'], $apt_settings['apt_post_statuses'])); ?>" maxlength="5000" size="15"></td></tr>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="apt_word_separators">Word separators:</label> <span class="apt_help" title="Each string/character (separated by &quot;<?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?>&quot;) will be treated as a word separator. If you want to use a character identical to the string separator, enter its HTML entity number. (Example: If the current string separator is a comma, use the following HTML entity as a word separator instead: &quot;&amp;#44;&quot;) If no separators are set, a space will be used as a default word separator.">i</span>
								</th>
								<td>
									<input class="apt_width_7" type="text" name="apt_word_separators" id="apt_word_separators" value="<?php echo htmlspecialchars(implode($apt_settings['apt_string_separator'], $apt_settings['apt_word_separators'])); ?>" maxlength="5000"><br />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Content processing: <span class="apt_help" title="Various operations which are carried out when analyzed content is being processed.">i</span>
								</th>
								<td>
									<input type="checkbox" name="apt_wildcards" id="apt_wildcards" <?php if($apt_settings['apt_wildcards'] == 1) echo 'checked="checked"'; ?>> <label for="apt_wildcards">Wildcard support</label> <span class="apt_help" title="If enabled, you can use the wildcard character (&quot;<?php echo htmlspecialchars($apt_settings['apt_wildcard_character']); ?>&quot;) to match any string in related keywords. Example: the pattern &quot;cat<?php echo htmlspecialchars($apt_settings['apt_wildcard_character']); ?>&quot; will match words &quot;cat&quot;, &quot;cats&quot; and &quot;category&quot;, the pattern &quot;c<?php echo htmlspecialchars($apt_settings['apt_wildcard_character']); ?>t&quot; will match &quot;cat&quot;, &quot;cot&quot; etc. (but also &quot;ct&quot;)">i</span><br />
									<input type="checkbox" name="apt_ignore_case" id="apt_ignore_case" <?php if($apt_settings['apt_ignore_case'] == 1) echo 'checked="checked"'; ?>> <label for="apt_ignore_case">Ignore case</label> <span class="apt_help" title="Ignore case of keywords, related keywords and post content. (Note: This option will convert all these strings to lowercase)">i</span><br />
									<input type="checkbox" name="apt_substring_analysis" id="apt_substring_analysis" <?php if($apt_settings['apt_substring_analysis'] == 1) echo 'checked="checked"'; ?>> <label for="apt_substring_analysis">Analyze only</label> <input class="apt_width_6" type="text" name="apt_substring_analysis_length" value="<?php echo $apt_settings['apt_substring_analysis_length']; ?>" maxlength="10"> characters starting at position <input class="apt_width_6" type="text" name="apt_substring_analysis_start" value="<?php echo $apt_settings['apt_substring_analysis_start']; ?>" maxlength="10"> <span class="apt_help" title="This option is useful if you don't want to analyze all content. It behaves like the PHP function &quot;substr&quot;; you can also submit negative integers.">i</span><br />
									<input type="checkbox" name="apt_strip_tags" id="apt_strip_tags" <?php if($apt_settings['apt_strip_tags'] == 1) echo 'checked="checked"'; ?>> <label for="apt_strip_tags">Strip HTML, PHP, JS and CSS tags from analyzed content</label> <span class="apt_help" title="Ignore PHP/HTML/JavaScript/CSS code. (If enabled, only the word &quot;green&quot; will not be ignored in the following example: &lt;span title=&quot;red&quot;&gt;green&lt;/span&gt;)">i</span><br />
									<input type="checkbox" name="apt_decode_html_entities_word_separators" id="apt_decode_html_entities_word_separators" <?php if($apt_settings['apt_decode_html_entities_word_separators'] == 1) echo 'checked="checked"'; ?>> <label for="apt_decode_html_entities_word_separators">Decode HTML entities in word separators</label> <span class="apt_help" title="Convert HTML entities in word separators to their applicable characters.">i</span><br />
									<input type="checkbox" name="apt_decode_html_entities_analyzed_content" id="apt_decode_html_entities_analyzed_content" <?php if($apt_settings['apt_decode_html_entities_analyzed_content'] == 1) echo 'checked="checked"'; ?>> <label for="apt_decode_html_entities_analyzed_content">Decode HTML entities in analyzed content</label> <span class="apt_help" title="Convert HTML entities in analyzed content to their applicable characters.">i</span><br />
									<input type="checkbox" name="apt_decode_html_entities_related_keywords" id="apt_decode_html_entities_related_keywords" <?php if($apt_settings['apt_decode_html_entities_related_keywords'] == 1) echo 'checked="checked"'; ?>> <label for="apt_decode_html_entities_related_keywords">Decode HTML entities in related keywords</label> <span class="apt_help" title="Convert HTML entities in related keywords to their applicable characters.">i</span><br />
									<input type="checkbox" name="apt_replace_whitespaces" id="apt_replace_whitespaces" <?php if($apt_settings['apt_replace_whitespaces'] == 1) echo 'checked="checked"'; ?>> <label for="apt_replace_whitespaces">Replace whitespace characters with spaces</label> <span class="apt_help" title="If enabled, whitespace characters (spaces, tabs and newlines) will be replaced with spaces. This option will affect both the haystack (analyzed content) and the needle (keywords).">i</span><br />
									<input type="checkbox" name="apt_replace_nonalphanumeric" id="apt_replace_nonalphanumeric" <?php if($apt_settings['apt_replace_nonalphanumeric'] == 1) echo 'checked="checked"'; ?>> <label for="apt_replace_nonalphanumeric">Replace non-alphanumeric characters with spaces</label> <span class="apt_help" title="If enabled, currently set word separators will be ignored and only a space will be used as a default word separator. This option will affect both the haystack (analyzed content) and the needle (keywords).">i</span><br />
									<span class="apt_sub_option"><input type="checkbox" name="apt_dont_replace_wildcards" id="apt_dont_replace_wildcards" <?php if($apt_settings['apt_dont_replace_wildcards'] == 1) echo 'checked="checked"'; ?>> <label for="apt_dont_replace_wildcards">Don't replace wildcard characters</label> <span class="apt_help" title="This option is required if you want to use wildcards.">i</span>
								</td>
							</tr>
						</table>

						<h3 class="title">Miscellaneous</h3>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									Default configuration group: <span class="apt_help" title="Keyword sets without configuration groups will be automatically assigned to this group.">i</span>
								</th>
								<td>
									<select name="apt_default_group" class="apt_width_5">
										<?php apt_display_group_option_list($apt_settings['apt_default_group']); ?>
									</select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Nonexistent groups handling: <span class="apt_help" title="This option determines what happens to keyword sets if the configuration groups they were assigned to no longer exist. (Exception: When importing keyword sets in CSV format, items belonging to nonexistent groups are automatically moved to the default configuration group.).">i</span>
								</th>
								<td>
									<input type="radio" name="apt_nonexistent_groups_handling" id="apt_nonexistent_groups_handling_1" value="1" <?php if($apt_settings['apt_nonexistent_groups_handling'] == 1) echo 'checked="checked"'; ?>> <label for="apt_nonexistent_groups_handling_1">Move keyword sets to the default configuration group</label> <span class="apt_help" title="Keyword sets belonging to no longer existing groups will be moved to the default configuration group.">i</span><br />
									<input type="radio" name="apt_nonexistent_groups_handling" id="apt_nonexistent_groups_handling_2" value="2" <?php if($apt_settings['apt_nonexistent_groups_handling'] == 2) echo 'checked="checked"'; ?>  onClick="if(document.getElementById('apt_nonexistent_groups_handling_2').checked){return confirm('Are you sure? If your configuration groups are removed, your keyword sets will be deleted as well!')}"> <label for="apt_nonexistent_groups_handling_2">Delete all keyword sets belonging to nonexistent groups</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Item editor mode: <span class="apt_help" title="This feature may be needed if the plugin stores a lot keyword sets/configuration groups in the database and your PHP configuration prevents input fields from being submitted if there's too many of them (current value of the &quot;max_input_vars&quot; variable: <?php echo $apt_max_input_vars_value; ?>). See FAQ #2 for more information.">i</span>
								</th>
								<td>
									<input type="radio" name="apt_item_editor_mode" id="apt_item_editor_mode_1" value="1" <?php if($apt_settings['apt_item_editor_mode'] == 1) echo 'checked="checked"'; ?>> <label for="apt_item_editor_mode_1">Classic</label> <span class="apt_help" title="If enabled, each keyword set and configuration group will be editable via multiple input fields.">i</span><br />
									<input type="radio" name="apt_item_editor_mode" id="apt_item_editor_mode_2" value="2" <?php if($apt_settings['apt_item_editor_mode'] == 2) echo 'checked="checked"'; ?>> <label for="apt_item_editor_mode_2">CSV</label> <span class="apt_help" title="If enabled, keyword sets and configuration groups will be editable via a single textarea field (items have to be submitted in the CSV format).">i</span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Automatic backups: <span class="apt_help" title="APT can automatically create backup files with your plugin settings, keyword sets and configuration groups (backup directory: <?php echo $apt_backup_dir_abs_path; ?>).">i</span>
								</th>
								<td>
									<input type="checkbox" name="apt_export_plugin_data_before_update" id="apt_export_plugin_data_before_update" <?php if($apt_settings['apt_export_plugin_data_before_update'] == 1) echo 'checked="checked"'; ?> onClick="if(!document.getElementById('apt_export_plugin_data_before_update').checked){return confirm('Are you sure? If disabled, your data will NOT be automatically backed up!')}"> <label for="apt_export_plugin_data_before_update">Before plugin updates (JSON)</label> <span class="apt_help" title="Exports plugin data to JSON files before the plugin is updated to a newer version. If something goes wrong during the update, no data will be lost.">i</span><br />
									<input type="checkbox" name="apt_export_plugin_data_after_update" id="apt_export_plugin_data_after_update" <?php if($apt_settings['apt_export_plugin_data_after_update'] == 1) echo 'checked="checked"'; ?> onClick="if(!document.getElementById('apt_export_plugin_data_after_update').checked){return confirm('Are you sure? If disabled, your data will NOT be automatically backed up!')}"> <label for="apt_export_plugin_data_after_update">After plugin updates (JSON + CSV)</label> <span class="apt_help" title="Exports plugin settings to JSON and keyword sets + configuration groups to CSV files after the plugin is updated to a newer version.">i</span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="apt_backup_limit">Backup limit:</label> <span class="apt_help" title="The maximum number of generated backups for each data type (plugin settings, keyword sets, configuration groups) and format (JSON, CSV) stored in the backup directory (<?php echo $apt_backup_dir_abs_path; ?>). Old redundant files will be always automatically deleted when using the export tool.">i</span>
								</th>
								<td>
									<input class="apt_width_6" type="text" name="apt_backup_limit" id="apt_backup_limit" value="<?php echo $apt_settings['apt_backup_limit']; ?>" maxlength="10" size="3">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Automatic data correction:
								</th>
								<td>
									<input type="checkbox" name="apt_input_correction" id="apt_input_correction" <?php if($apt_settings['apt_input_correction'] == 1) echo 'checked="checked"'; ?>> <label for="apt_input_correction">Input correction <span class="apt_help" title="Removes unnecessary spaces, multiple whitespace characters, wildcards, string separators; disables groups without registered taxonomies etc. Input correction (with the exception of group disabling) is turned off by default when importing/exporting data.">i</span></label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									Hide messages: <span class="apt_help" title="Certain kinds of messages can be hidden if you consider them to be annoying.">i</span>
								</th>
								<td>
									<input type="checkbox" name="apt_hide_warning_messages" id="apt_hide_warning_messages" <?php if($apt_settings['apt_hide_warning_messages'] == 1) echo 'checked="checked"'; ?> onClick="if(document.getElementById('apt_hide_warning_messages').checked){return confirm('Are you sure? If enabled, warning messages will NOT be displayed!')}"> <label for="apt_hide_warning_messages">Hide warning messages</label><br />
									<input type="checkbox" name="apt_hide_update_messages" id="apt_hide_update_messages" <?php if($apt_settings['apt_hide_update_messages'] == 1) echo 'checked="checked"'; ?> onClick="if(document.getElementById('apt_hide_update_messages').checked){return confirm('Are you sure? If enabled, a notification will NOT be displayed after the plugin is updated!')}"> <label for="apt_hide_update_messages">Hide update notifications</label> <span class="apt_help" title="By default, every time the plugin is updated to a newer version, a message encouraging the user to check out new features is displayed.">i</span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="apt_wildcard_character">Wildcard character:</label> <span class="apt_help" title="Using an asterisk is recommended. If you change the value, all occurrences of old wildcard characters in related keywords will be changed.">i</span>
								</th>
								<td>
									<input class="apt_width_6" type="text" name="apt_wildcard_character" id="apt_wildcard_character" value="<?php echo htmlspecialchars($apt_settings['apt_wildcard_character']); ?>" maxlength="5000">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="apt_wildcard_regex">Wildcard pattern:</label> <span class="apt_help" title="This regular expression is used to match strings represented by wildcards. The regex pattern MUST be enclosed by ROUND brackets! Examples: &quot;(.*)&quot; matches any string; &quot;([a-zA-Z0-9]*)&quot; matches alphanumeric strings only.">i</span>
								</th>
								<td>
									<input class="apt_width_6" type="text" name="apt_wildcard_regex" id="apt_wildcard_regex" value="<?php echo htmlspecialchars($apt_settings['apt_wildcard_regex']); ?>" maxlength="5000" size="15">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="apt_string_separator">String separator:</label> <span class="apt_help" title="For separation of word separators, post types & statuses, related keywords etc. Using a comma is recommended.">i</span>
								</th>
								<td>
									<input class="apt_width_6" type="text" name="apt_string_separator" id="apt_string_separator" value="<?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?>" maxlength="5000">
								</td>
							</tr>
						</table>

						<p class="submit">
							<input class="button-primary" type="submit" name="apt_save_settings_button" value=" Save changes "> 
							<input class="button apt_right apt_red_background" type="submit" name="apt_reinstall_plugin_button" onClick="return confirm('Do you really want to reinstall the plugin? All plugin data will be reset.\nYou might want to create backups of your current settings, keyword sets and configuration groups first.')" value=" Reinstall plugin ">
						</p>
					</div>
				</div>
	
				<?php wp_nonce_field('apt_settings_nonce','apt_settings_hash'); ?>
				</form>
				<!-- //-postbox -->

				<!-- postbox -->
				<?php
					### sort keyword sets and groups
					if($apt_settings['apt_keyword_sets_total'] != 0){ //sort keyword sets only if there are some
						usort($apt_kw_sets, 'apt_sort_items'); //sort keyword sets by their term name
					}
					if($apt_settings['apt_configuration_groups_total'] != 0){ //sort keyword sets only if there are some
						usort($apt_groups, 'apt_sort_items'); //sort keyword sets by their term name
					}
				?>

				<form action="<?php echo admin_url('options-general.php?page=automatic-post-tagger'); ?>" method="post">
				<div class="postbox">
				<div onclick="apt_set_widget_visibility(4);" class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Keyword set editor</span> <span class="apt_normal apt_small">(<?php echo $apt_settings['apt_keyword_sets_total'] .' '. apt_get_grammatical_number($apt_settings['apt_keyword_sets_total'], 1, 3); ?> total)</span></h3>
					<div class="inside" id="apt_widget_id_[4]" <?php echo apt_get_widget_visibility(4); ?>>

						<?php
						if($apt_settings['apt_item_editor_mode'] == 1){
							if($apt_settings['apt_keyword_sets_total'] != 0){
						?>
								<div class="apt_item_editor">
									<table class="apt_width_100">
										<tr>
											<td class="apt_width_1">Term name</td>
											<td class="apt_width_3">Related keywords</td>
											<td class="apt_width_1">Configuration group</td>
											<td class="apt_width_4"></td></tr>

										<?php
											foreach($apt_kw_sets as $apt_array_id => $apt_keyword_data){
										?>
										<tr>
											<td><input class="apt_width_100" type="text" name="apt_keyword_set_list_name_[<?php echo $apt_keyword_data[0]; ?>]" id="apt_keyword_set_list_name_<?php echo $apt_keyword_data[0]; ?>" value="<?php echo htmlspecialchars($apt_keyword_data[1]); ?>" maxlength="5000"></td>
											<td><input class="apt_width_100" type="text" name="apt_keyword_set_list_related_keywords_[<?php echo $apt_keyword_data[0]; ?>]" id="apt_keyword_set_list_related_keywords_<?php echo $apt_keyword_data[0]; ?>" value="<?php echo htmlspecialchars(implode($apt_settings['apt_string_separator'], $apt_keyword_data[2])); ?>" maxlength="5000"></td>	
											<td>
												<select class="apt_width_100" name="apt_keyword_set_list_group_[<?php echo $apt_keyword_data[0]; ?>]" id="apt_keyword_set_list_group_<?php echo $apt_keyword_data[0]; ?>">
													<?php apt_display_group_option_list($apt_keyword_data[3]); ?>
												</select>
											<td>
											<td><input type="checkbox" name="apt_keyword_set_list_checkbox_[<?php echo $apt_keyword_data[0]; ?>]" id="apt_keyword_set_list_checkbox_<?php echo $apt_keyword_data[0]; ?>" onclick="apt_change_background(1,<?php echo $apt_keyword_data[0]; ?>);"></td>
										</tr>
									<?php
										} //-foreach
									?>
									</table>
								</div>
							<?php
							} //-if there are items
							else{
								echo '<p>There aren\'t any keyword sets.</p>';
							}
						} //-if IEM = 1
						else{ //IEM = 2
						?>
							<p>Keyword sets have to be submitted in CSV format. <span class="apt_help" title="Put each keyword set on a new line; related keywords and group names are optional. Strings with spaces or commas need to be enclosed in quotes. Example: &quot;Term name&quot;,&quot;related keyword,another related keyword&quot;,&quot;Group name&quot;">i</span></p>
							<textarea class="apt_item_editor_textarea" name="apt_keyword_set_editor_textarea"><?php echo apt_export_items_to_textarea(1); ?></textarea>
						<?php
						} //-else IEM = 2
						?>

						<?php if($apt_settings['apt_keyword_sets_total'] != 0 or $apt_settings['apt_item_editor_mode'] == 2){ ?>
							<?php if($apt_settings['apt_item_editor_mode'] == 2){ ?>
								<p class="apt_small"><strong>Note:</strong> You can remove individual items by deleting their lines.</p>
								<p class="apt_small"><strong>Note:</strong> If you submit nonexistent group names, keyword sets will be automatically moved to the default configuration group.</p>
							<?php } ?>

							<p class="submit">
								<input class="button" type="submit" name="apt_save_keyword_sets_button" value=" Save changes ">

								<?php if($apt_settings['apt_item_editor_mode'] == 1){ ?>
									<input class="button apt_red_background apt_right apt_button_margin_left" type="submit" name="apt_delete_selected_keywords_button" onClick="return confirm('Do you really want to delete selected keyword sets?')" value=" Delete selected ">
								<?php } ?>

								<input class="button apt_red_background apt_right apt_button_margin_left" type="submit" name="apt_delete_all_keywords_button" onClick="return confirm('Do you really want to delete all keyword sets?')" value=" Delete all ">
							</p>
						<?php } ?>
					</div>
				</div>

				<?php wp_nonce_field('apt_keyword_set_editor_nonce','apt_keyword_set_editor_hash'); ?>
				</form>
				<!-- //-postbox -->

				<!-- postbox -->
				<form action="<?php echo admin_url('options-general.php?page=automatic-post-tagger'); ?>" method="post">
				<div class="postbox">
				<div onclick="apt_set_widget_visibility(2);" class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Create new keyword set</span></h3>
					<div class="inside" id="apt_widget_id_[2]" <?php echo apt_get_widget_visibility(2); ?>>

						<table class="apt_width_100">
							<tr>
								<td class="apt_width_1">Term name: <span class="apt_help" title="Term names represent taxonomy terms that will be added to posts when they or the keyword set's related keywords are found. Example: &quot;cats&quot;">i</span></td>
								<td class="apt_width_3">Related keywords <span class="apt_small">(separated by "<strong><?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?></strong>")</span>: <span class="apt_help" title="<?php echo 'Related keywords are optional. Example: &quot;cat'. $apt_settings['apt_string_separator'] .'kitty'. $apt_settings['apt_string_separator'] .'meo'. $apt_settings['apt_wildcard_character'] .'w&quot;.'; ?>">i</span></td>
								<td class="apt_width_1">Configuration group: <span class="apt_help" title="Keyword sets can be categorized into different configuration groups, each with unique group-specific settings.">i</span></td>
							</tr>
							<tr>
								<td><input class="apt_width_100" type="text" name="apt_new_term_name" maxlength="5000"></td>
								<td><input class="apt_width_100" type="text" name="apt_new_related_keywords" maxlength="5000"></td>

								<td>
									<select class="apt_width_100" name="apt_create_new_keyword_group">
										<?php apt_display_group_option_list($apt_settings['apt_default_group']); ?>
									</select>
								</td>
							</tr>
						</table>

						<p>
							<input class="button" type="submit" name="apt_create_new_keyword_set_button" value=" Create item ">
							<span class="apt_right apt_small"><strong>Note:</strong> You can also create keyword sets directly from the APT meta box displayed next to the post editor.</span>		
						</p>
					</div>
				</div>

				<?php wp_nonce_field('apt_create_new_keyword_set_nonce','apt_create_new_keyword_set_hash'); ?>
				</form>
				<!-- //-postbox -->

				<!-- postbox -->
				<form action="<?php echo admin_url('options-general.php?page=automatic-post-tagger'); ?>" method="post">
				<div class="postbox">
					<div onclick="apt_set_widget_visibility(6);" class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Configuration group editor</span> <span class="apt_normal apt_small">(<?php echo $apt_settings['apt_configuration_groups_total'] .' '. apt_get_grammatical_number($apt_settings['apt_configuration_groups_total'], 1, 9); ?> total)</span></h3>
					<div class="inside" id="apt_widget_id_[6]" <?php echo apt_get_widget_visibility(6); ?>>

						<?php
							if($apt_settings['apt_item_editor_mode'] == 1){
								if($apt_settings['apt_configuration_groups_total'] != 0){
						?>
							<div class="apt_item_editor">
								<table class="apt_width_100">
									<tr>
										<td class="apt_width_1">Group name</td>
										<td class="apt_width_8">KW sets <span class="apt_help" title="Number of keyword sets belonging to the particular group.">i</span></td>
										<td class="apt_width_10">Enabled</td>
										<td class="apt_width_9">Term limit</td>
										<td class="apt_width_3">Taxonomies</td>
										<td class="apt_width_4"></td>
									</tr>

									<?php
										foreach($apt_groups as $apt_group_id => $apt_group_data){
									?>
									<tr>
										<td><input class="apt_width_100" type="text" name="apt_configuration_group_list_name_[<?php echo $apt_group_data[0]; ?>]" id="apt_configuration_group_list_name_<?php echo $apt_group_data[0]; ?>" value="<?php echo htmlspecialchars($apt_group_data[1]); ?>" maxlength="5000"></td>
										<td><div class="apt_special_td" id="apt_configuration_group_list_keyword_set_count_<?php echo $apt_group_data[0]; ?>"><?php echo $apt_group_data[2]; ?></div></td>
										<td><div class="apt_special_td" id="apt_configuration_group_list_status_<?php echo $apt_group_data[0]; ?>"><input class="apt_width_100" type="checkbox" name="apt_configuration_group_list_status_[<?php echo $apt_group_data[0]; ?>]" <?php if($apt_group_data[3] == 1) echo 'checked="checked"'; ?>></div></td>
										<td><input class="apt_width_100" type="text" name="apt_configuration_group_list_term_limit_[<?php echo $apt_group_data[0]; ?>]" id="apt_configuration_group_list_term_limit_<?php echo $apt_group_data[0]; ?>" value="<?php echo htmlspecialchars($apt_group_data[4]); ?>" maxlength="5000"></td>
										<td><input class="apt_width_100" type="text" name="apt_configuration_group_list_taxonomies_[<?php echo $apt_group_data[0]; ?>]" id="apt_configuration_group_list_taxonomies_<?php echo $apt_group_data[0]; ?>" value="<?php echo htmlspecialchars(implode($apt_settings['apt_string_separator'], $apt_group_data[5])); ?>" maxlength="5000"></td>
										<?php
											if($apt_group_data[0] != $apt_settings['apt_default_group']){ //display the checkbox only if the current group isn't the default one
										?>
												<td><input type="checkbox" name="apt_configuration_group_list_checkbox_[<?php echo $apt_group_data[0]; ?>]" id="apt_configuration_group_list_checkbox_<?php echo $apt_group_data[0]; ?>" onclick="apt_change_background(2,<?php echo $apt_group_data[0]; ?>);"></td>
										<?php
											} //-if the current group isn't the default one
										?>
									</tr>
									<?php
										} //-foreach
									?>
									</table>
								</div>
							<?php
							} //-if there are items
							else{
								echo '<p>There aren\'t any groups.</p>';
							}
						} //-if IEM = 1
						else{ //IEM = 2
						?>
							<p>Groups have to be submitted in CSV format. <span class="apt_help" title="Put each configuration group on a new line; taxonomies are optional. Strings with spaces or commas need to be enclosed in quotes. Example: &quot;Tags&quot;,&quot;1&quot;,&quot;25&quot;,&quot;post_tag&quot;">i</span></p>
							<textarea class="apt_item_editor_textarea" name="apt_configuration_groups_editor_textarea"><?php echo apt_export_items_to_textarea(2); ?></textarea>
						<?php
						} //-else IEM = 2
						?>

						<?php if($apt_settings['apt_configuration_groups_total'] != 0 or $apt_settings['apt_item_editor_mode'] == 2){ ?>
							<?php if($apt_settings['apt_item_editor_mode'] == 2){ ?>
									<p class="apt_small"><strong>Note:</strong> You can remove individual items by deleting their lines.</p>

									<?php if($apt_settings['apt_nonexistent_groups_handling'] == 2){
											echo '<p class="apt_small"><strong>Warning:</strong> APT is currently set to automatically delete keyword sets if you delete their groups or change their names. Just to make that sure that you don\'t lose any data, please create a backup before continuing.</p>';
										}
										else{
											echo '<p class="apt_small"><strong>Note:</strong> If you delete groups or change their names, applicable keyword sets will be automatically moved to the default configuration group.</p>';
										}
									?>
							<?php } ?>

							<p class="submit">
								<input class="button" type="submit" name="apt_save_groups_button" value=" Save changes ">
									<?php
										if($apt_settings['apt_configuration_groups_total'] > 1){
									?>

										<?php if($apt_settings['apt_item_editor_mode'] == 1){ ?>
											<input class="button apt_red_background apt_right apt_button_margin_left" type="submit" name="apt_delete_selected_groups_button" onClick="return confirm('Do you really want to delete selected configuration groups?')" value=" Delete selected ">
										<?php
											}
										?>

										<input class="button apt_red_background apt_right apt_button_margin_left" type="submit" name="apt_delete_all_groups_button" onClick="return confirm('Do you really want to delete all configuration groups (with the exception of the default one)?')" value=" Delete all ">
									<?php
										}
									?>
							</p>
						<?php } ?>
					</div>
				</div>

				<?php wp_nonce_field('apt_configuration_group_editor_nonce','apt_configuration_group_editor_hash'); ?>
				</form>
				<!-- //-postbox -->

				<!-- postbox -->
				<form action="<?php echo admin_url('options-general.php?page=automatic-post-tagger'); ?>" method="post">
				<div class="postbox">
				<div onclick="apt_set_widget_visibility(7);" class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Create new configuration group</span></h3>
					<div class="inside" id="apt_widget_id_[7]" <?php echo apt_get_widget_visibility(7); ?>>
						<table class="apt_width_100">
							<tr>
								<td class="apt_width_1">Group name: <span class="apt_help" title="Your name for the particular group.">i</span></td>
								<td class="apt_width_8">Enabled: <span class="apt_help" title="Keyword sets belonging to disabled configuration groups are ignored when posts are being tagged.">i</span></td>
								<td class="apt_width_9">Term limit: <span class="apt_help" title="The maximum number of terms from this particular group that will be added to posts.">i</span></td>
								<td class="apt_width_3">Taxonomies <span class="apt_small">(separated by "<strong><?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?></strong>")</span>: <span class="apt_help" title="Taxonomies are optional. Example: &quot;post_tag&quot;. <?php if($apt_settings['apt_input_correction'] == 1){echo 'Configuration groups without registered taxonomies are automatically disabled.';}?>">i</span></td>
							</tr>
							<tr>
								<td><input class="apt_width_100" type="text" name="apt_create_new_group_name" maxlength="5000"></td>
								<td><div class="apt_special_td"><input class="apt_width_100" type="checkbox" name="apt_create_new_group_status" checked="checked"></div></td>
								<td><input class="apt_width_100" type="text" name="apt_create_new_group_term_limit"></td>
								<td><input class="apt_width_100" type="text" name="apt_create_new_group_taxonomies" maxlength="5000"></td>
							</tr>
						</table>

						<p>
							<input class="button" type="submit" name="apt_create_new_group_button" value=" Create item ">
						</p>
					</div>
				</div>

				<?php wp_nonce_field('apt_create_new_group_nonce','apt_create_new_group_hash'); ?>
				</form>
				<!-- //-postbox -->

				<!-- postbox -->
				<form name="apt_import_form" action="<?php echo admin_url('options-general.php?page=automatic-post-tagger'); ?>" enctype="multipart/form-data" method="post">
				<div class="postbox">
				<div onclick="apt_set_widget_visibility(3);" class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Import/Export data</span></h3>
					<div class="inside" id="apt_widget_id_[3]" <?php echo apt_get_widget_visibility(3); ?>>

						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row">
										Import terms from taxonomies: <span class="apt_help" title="Imports terms from taxonomies (separated by &quot;<?php echo htmlspecialchars($apt_settings['apt_string_separator']); ?>&quot;) and assigns them to the default configuration group. If you import terms as related keywords, their IDs will be saved as term names. Unused terms won't be imported.">i</span>
									</th>
									<td>
										<input class="apt_width_2" type="text" name="apt_taxonomies" id="apt_taxonomies" value="<?php echo htmlspecialchars(implode($apt_settings['apt_string_separator'], $apt_settings['apt_taxonomies'])); ?>" maxlength="5000">
										Import as
										<select name="apt_import_terms_from_taxonomies_column">
											<option value="1" selected="selected">Term names</option>
											<option value="2">Related keywords</option>
										</select>
										<input class="button" type="submit" name="apt_import_terms_from_taxonomies_button" value=" Import " onClick="return confirm('Do you really want to import terms from specified taxonomies?')">
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										Import plugin settings: <span class="apt_help" title="Imports plugin settings from a JSON file. Missing settings will be replaced with default values.">i</span>
									</th>
									<td>
										<input type="file" size="1" name="apt_import_plugin_settings_file"> <input class="button" type="submit" name="apt_import_plugin_settings_from_file_button" value=" Import " onClick="return confirm('Do you really want to import the contents of this file?\nIf you\'re importing JSON files, your data will be overwritten.')">
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										Import keyword sets: <span class="apt_help" title="Imports keyword sets from a JSON or CSV file. Only term names are required; related keywords and configuration groups are optional. Keyword sets belonging to nonexistent configuration groups will be automatically <?php if($apt_settings['apt_nonexistent_groups_handling'] == 1){echo 'moved to the default group';}else{echo 'deleted when importing items from JSON files';} ?>.">i</span>
									</th>
									<td>
										<input type="file" size="1" name="apt_import_keyword_sets_file"> <input class="button" type="submit" name="apt_import_keyword_sets_from_file_button" value=" Import "  onClick="return confirm('Do you really want to import the contents of this file?\nIf you\'re importing JSON files, your data will be overwritten.<?php if($apt_settings['apt_nonexistent_groups_handling'] == 2){echo '\n\nAPT is currently set to delete keyword sets belonging to nonexistent configuration groups. For example, if you import keyword sets with nonexistent groups from a JSON file, these items will be removed after the import is complete.';} ?>')">
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										Import configuration groups: <span class="apt_help" title="Imports configuration groups from a JSON or CSV file.">i</span>
									</th>
									<td>
										<input type="file" size="1" name="apt_import_configuration_groups_file"> <input class="button" type="submit" name="apt_import_configuration_groups_from_file_button" value=" Import " onClick="return confirm('Do you really want to import the contents of this file?\nIf you\'re importing JSON files, your data will be overwritten.<?php if($apt_settings['apt_nonexistent_groups_handling'] == 2){echo '\n\nAPT is currently set to delete keyword sets belonging to nonexistent configuration groups. For example, if you import new groups from a JSON file, your keyword sets will be removed. Just to make that sure you don\\\'t lose any data, please create a backup before continuing.';} ?>')">
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										Export plugin settings: <span class="apt_help" title="Exports plugin settings and saves the file in the backup directory.">i</span>
									</th>
									<td>
										<input class="button" type="submit" name="apt_export_plugin_settings_json_button" value=" Export to JSON ">
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										Export keyword sets: <span class="apt_help" title="Exports all keyword sets and saves the file in the backup directory.">i</span>
									</th>
									<td>
										<input class="button" type="submit" name="apt_export_keyword_sets_json_button" value=" Export to JSON ">
										<input class="button" type="submit" name="apt_export_keyword_sets_csv_button" value=" Export to CSV ">
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										Export configuration groups: <span class="apt_help" title="Exports all configuration groups and saves the file in the backup directory.">i</span>
									</th>
									<td>
										<input class="button" type="submit" name="apt_export_configuration_groups_json_button" value=" Export to JSON ">
										<input class="button" type="submit" name="apt_export_configuration_groups_csv_button" value=" Export to CSV ">
									</td>
								</tr>
							</tbody>
						</table>

						<p class="apt_small"><strong>Note:</strong> When importing data, the contents of CSV files will be appended to your already existing keyword sets or configuration groups; JSON files will replace current plugin data.</p>
					</div>
				</div>

				<?php wp_nonce_field('apt_export_import_plugin_data_nonce','apt_export_import_plugin_data_hash'); ?>
				</form>
				<!-- //-postbox -->

				<!-- postbox -->
				<?php
					### generate range IDs
					$apt_bulk_tagging_database_range = apt_get_bulk_tagging_range(true);
				?>

				<div class="postbox">
					<div onclick="apt_set_widget_visibility(5);" class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Bulk tagging tool</span></h3>
					<div class="inside" id="apt_widget_id_[5]" <?php echo apt_get_widget_visibility(5); ?>>
						<form action="<?php echo admin_url('options-general.php?page=automatic-post-tagger'); ?>" method="post">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											Lower bound of the post ID range: <span class="apt_help" title="Posts with lower ID than the specified bound value won't be added to the post queue. The custom post ID can be automatically updated using the option &quot;Update the Custom post ID to the lastly processed post ID&quot;.">i</span>
										</th>
										<td>
											<input type="radio" name="apt_bulk_tagging_range_lower_bound" id="apt_bulk_tagging_range_lower_bound_1" value="1" <?php if($apt_settings['apt_bulk_tagging_range_lower_bound'] == 1) echo 'checked="checked"'; ?>> <label for="apt_bulk_tagging_range_lower_bound_1">Lowest database post ID <span class="apt_small apt_gray">(currently <?php echo $apt_bulk_tagging_database_range[0]; ?>)</span></label><br />
											<input type="radio" name="apt_bulk_tagging_range_lower_bound" id="apt_bulk_tagging_range_lower_bound_2" value="2" <?php if($apt_settings['apt_bulk_tagging_range_lower_bound'] == 2) echo 'checked="checked"'; ?>> <label for="apt_bulk_tagging_range_lower_bound_2">Custom post ID:</label> <input class="apt_width_6" type="text" name="apt_bulk_tagging_range_custom_lower_bound" id="apt_bulk_tagging_range_custom_lower_bound" value="<?php echo $apt_settings['apt_bulk_tagging_range_custom_lower_bound']; ?>" maxlength="10"><br />
											<span class="apt_sub_option"><input type="checkbox" name="apt_bulk_tagging_range_custom_lower_bound_update" id="apt_bulk_tagging_range_custom_lower_bound_update" <?php if($apt_settings['apt_bulk_tagging_range_custom_lower_bound_update'] == 1) echo 'checked="checked"'; ?>> <label for="apt_bulk_tagging_range_custom_lower_bound_update">Update the Custom post ID to the lastly processed post ID</label></span> <span class="apt_help" title="Automatically changes the Custom post ID to the lastly processed ID. The next time the bulk tagging tool is run, it can begin where it left off last time. If it's not necessary to always process all posts when running the bulk tagging tool, enable this option and set the Lower bound to Custom post ID. This way only the yet unprocessed posts will be always tagged; bulk taggging will be faster and less resource-intensive.">i</span>
										</td>
									</tr>

									<tr valign="top">
										<th scope="row">
											Upper bound of the post ID range: <span class="apt_help" title="Posts with higher ID than the upper bound won't be added to the post queue.">i</span>
										</th>
										<td>
											<input type="radio" name="apt_bulk_tagging_range_upper_bound" id="apt_bulk_tagging_range_upper_bound_1" value="1" <?php if($apt_settings['apt_bulk_tagging_range_upper_bound'] == 1) echo 'checked="checked"'; ?>> <label for="apt_bulk_tagging_range_upper_bound_1">Highest database post ID <span class="apt_small apt_gray">(currently <?php echo $apt_bulk_tagging_database_range[1]; ?>)</span></label><br />
											<input type="radio" name="apt_bulk_tagging_range_upper_bound" id="apt_bulk_tagging_range_upper_bound_2" value="2" <?php if($apt_settings['apt_bulk_tagging_range_upper_bound'] == 2) echo 'checked="checked"'; ?>> <label for="apt_bulk_tagging_range_upper_bound_2">Custom post ID:</label> <input class="apt_width_6" type="text" name="apt_bulk_tagging_range_custom_upper_bound" id="apt_bulk_tagging_range_custom_upper_bound" value="<?php echo $apt_settings['apt_bulk_tagging_range_custom_upper_bound']; ?>" maxlength="10">
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="apt_bulk_tagging_posts_per_batch">Posts processed per batch:</label> <span class="apt_help" title="How many posts should be processed every time a page is refreshed; low value helps avoid getting the &quot;max_execution_time&quot; error.">i</span>
										</th>
										<td>
											<input class="apt_width_6" type="text" name="apt_bulk_tagging_posts_per_batch" id="apt_bulk_tagging_posts_per_batch" value="<?php echo $apt_settings['apt_bulk_tagging_posts_per_batch']; ?>" maxlength="10">
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="apt_bulk_tagging_delay">Time delay between batches:</label> <span class="apt_help" title="Idle time between processing individual batches.">i</span>
										</th>
										<td>
											<input class="apt_width_6" type="text" name="apt_bulk_tagging_delay" id="apt_bulk_tagging_delay" value="<?php echo $apt_settings['apt_bulk_tagging_delay']; ?>" maxlength="10"> <?php echo apt_get_grammatical_number($apt_settings['apt_bulk_tagging_delay'], 1, 12); ?>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											Recurring bulk tagging events: <span class="apt_help" title="Recurring bulk tagging events are regularly run in the background. When a scheduled bulk tagging event occurs, post IDs higher than the lowest post ID in the queue (these IDs are retrieved using post types and statuses specified in the plugin's settings), are added to the bulk tagging queue. Individual batches of posts (<?php echo $apt_settings['apt_bulk_tagging_posts_per_batch'] .'&nbsp;'. apt_get_grammatical_number($apt_settings['apt_bulk_tagging_posts_per_batch'], 1, 8); ?>) are processed every time a page is loaded (assuming the set time delay (<?php echo $apt_settings['apt_bulk_tagging_delay'] .'&nbsp;'. apt_get_grammatical_number($apt_settings['apt_bulk_tagging_posts_per_batch'], 1, 12); ?>) has passed) until the queue is gradually emptied. When all batches are processed, a new bulk tagging event is automatically scheduled.">i</span>
										</th>
										<td>
											Every <input class="apt_width_6" type="text" name="apt_bulk_tagging_event_recurrence" id="apt_bulk_tagging_event_recurrence" value="<?php echo $apt_settings['apt_bulk_tagging_event_recurrence'] ?>" maxlength="10"> <?php echo apt_get_grammatical_number($apt_settings['apt_bulk_tagging_event_recurrence'], 1, 11); ?><br />
											<input type="checkbox" name="apt_bulk_tagging_event_unscheduling" id="apt_bulk_tagging_event_unscheduling" <?php if($apt_settings['apt_bulk_tagging_event_unscheduling'] == 1) echo 'checked="checked"'; ?>> <label for="apt_bulk_tagging_event_unscheduling">Automatically unschedule the bulk tagging event if errors occur</label></span> <span class="apt_help" title="If errors preventing the bulk tagging tool from processing posts occur, the recurring event will be automatically unscheduled.">i</span>
										</td>
									</tr>
								</tbody>
							</table>

							<p class="submit">
								<input class="button-primary" type="submit" name="apt_bulk_tagging_settings_button" value=" Save changes ">
								<input class="button apt_red_background apt_right apt_button_margin_left" type="submit" name="apt_single_bulk_tagging_event_button" onClick="return confirm('Do you really want to run the bulk tagging tool now?\nAny changes can\'t be reversed.')" value=" Process posts now ">

								<?php if(!(wp_next_scheduled('apt_bulk_tagging_event') !== false or wp_next_scheduled('apt_bulk_tagging_event_single_batch') !== false)){ ?>
									<input class="button apt_red_background apt_right apt_button_margin_left" type="submit" name="apt_recurring_bulk_tagging_event_button" onClick="return confirm('Do you really want to schedule a recurring bulk tagging event?')" value=" Schedule bulk tagging ">
								<?php } ?>

							</p>
							<?php wp_nonce_field('apt_bulk_tagging_tool_nonce','apt_bulk_tagging_tool_hash'); ?>
						</form>

						<?php
							if(wp_next_scheduled('apt_bulk_tagging_event') !== false or wp_next_scheduled('apt_bulk_tagging_event_single_batch') !== false){
						?>
						<form action="<?php echo admin_url('options-general.php?page=automatic-post-tagger'); ?>" method="post">
							<h3 class="title">Currently scheduled recurring bulk tagging event:</h3>
							<?php
								$apt_bulk_tagging_range = apt_get_bulk_tagging_range();

								if(preg_match('/^(0|[1-9][0-9]*){1}$/', $apt_bulk_tagging_range[0]) and preg_match('/^(0|[1-9][0-9]*){1}$/', $apt_bulk_tagging_range[1])){ //non-negative integers only
									$apt_bulk_tagging_range_post_count = count(apt_get_post_queue($apt_bulk_tagging_range));
								}
								else{
									$apt_bulk_tagging_range_post_count = 'n/a';
								}
							?>
								<table class="form-table">
									<tbody>
										<tr valign="top">
											<th scope="row">
												Current date and time:
											</th>
											<td>
												<?php echo get_date_from_gmt(date('Y-m-d H:i:s', time())); ?>
											</td>
										</tr>
										<tr valign="top">
											<th scope="row">
												Next bulk tagging event:
											</th>
											<td>
												<?php if(wp_next_scheduled('apt_bulk_tagging_event') === false){echo 'Not scheduled yet';}else{echo get_date_from_gmt(date('Y-m-d H:i:s', wp_next_scheduled('apt_bulk_tagging_event')));} ?>
											</td>
										</tr>
										<tr valign="top">
											<th scope="row">
												Next batch processing:
											</th>
											<td>
												<?php if(wp_next_scheduled('apt_bulk_tagging_event_single_batch') === false){echo 'Not scheduled yet';}else{echo get_date_from_gmt(date('Y-m-d H:i:s', wp_next_scheduled('apt_bulk_tagging_event_single_batch')));} ?>
											</td>
										</tr>
										<tr valign="top">
											<th scope="row">
												Posts in the ID range <span class="apt_small">(<?php echo $apt_bulk_tagging_range[0]; ?> - <?php echo $apt_bulk_tagging_range[1]; ?>)</span>:
											</th>
											<td>
												<?php echo $apt_bulk_tagging_range_post_count; ?>
											</td>
										</tr>

										<tr valign="top">
											<th scope="row">
												Posts in the queue: <span class="apt_help" title="Posts within the post ID range are loaded to the queue when the scheduled event occurs.">i</span>
											</th>
											<td>
												<?php echo count($apt_settings['apt_bulk_tagging_queue']); ?>
											</td>
										</tr>
									</tbody>
								</table>

								<p class="submit">
									<input class="button" type="submit" name="apt_unschedule_bulk_tagging_event_button" onClick="return confirm('Do you really want to unschedule the recurring bulk tagging event?')" value=" Unschedule bulk tagging ">
								</p>
							<?php wp_nonce_field('apt_bulk_tagging_unschedule_event_nonce','apt_bulk_tagging_unschedule_event_hash'); ?>
						</form>
					<?php
						} //-else event scheduled
					?>

					</div>
				</div>
				<!-- //-postbox -->

			</div>
		</div>
	</div>
</div>

<?php
} //- options page
?>
