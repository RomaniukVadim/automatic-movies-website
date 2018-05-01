<?php
/**
 * Created by PhpStorm.
 * User: tagdiv
 * Date: 10.07.2015
 * Time: 15:58
 */

global $loop_module_id, $loop_sidebar_position, $post, $td_sidebar_position;

//global $wp_query;
//var_dump($wp_query->query_vars);

td_global::load_single_post($post);


/*  ----------------------------------------------------------------------------
    the post template (single article template)
 */

//get_header();


//set the template id, used to get the template specific settings
$template_id = 'home';  //home = blog index = blog - use the same settings from the blog index

//prepare the loop variables

//read the global settings
$loop_sidebar_position = td_util::get_option('tds_' . $template_id . '_sidebar_pos'); //sidebar right is default (empty)
$loop_module_id = 1; //use the default 1 module (full post)

//read the primary category sidebar position! - we have to make the page after the primary category or after the global setting
$primary_category_id = td_global::get_primary_category_id();
if (!empty($primary_category_id)) {
	$tax_meta_sidebar = td_util::get_category_option($primary_category_id, 'tdc_sidebar_pos');//swich by RADU A, get_tax_meta($primary_category_id, 'tdc_sidebar_pos');
	if (!empty($tax_meta_sidebar)) {
		//update the sidebar position from the category setting
		$loop_sidebar_position = $tax_meta_sidebar;
	}
}

// custom post type - override sidebar position
if ($post->post_type != 'post') {
    $tds_custom_post_sidebar_pos = td_util::get_ctp_option($post->post_type, 'tds_custom_post_sidebar_pos');
    if (!empty($tds_custom_post_sidebar_pos)) {
        //update the sidebar position from custom post type
        $loop_sidebar_position = $tds_custom_post_sidebar_pos;
    }
}

//read the custom single post settings - this setting overids all of them
$td_post_theme_settings = get_post_meta($post->ID, 'td_post_theme_settings', true);
if (!empty($td_post_theme_settings['td_sidebar_position'])) {
	$loop_sidebar_position = $td_post_theme_settings['td_sidebar_position'];
}

//set the content width if needed (we already have the default in functions)
if ($loop_sidebar_position == 'no_sidebar') {
	$content_width = 980;
}

//send the sidebar position to gallery
td_global::$cur_single_template_sidebar_pos = $loop_sidebar_position;

//increment the views counter
td_page_views::update_page_views($post->ID);


//added by Radu A. check if this post have a post template to be display with.
//if not use the default site post template from Theme Panel -> Post Settings -> Default site post template
$td_default_site_post_template = td_util::get_option('td_default_site_post_template');

if(empty($td_post_theme_settings['td_post_template']) and !empty($td_default_site_post_template)) {
	$td_post_theme_settings['td_post_template'] = $td_default_site_post_template;
}

// sidebar position used to align the breadcrumb on sidebar left
$td_sidebar_position = '';
if($loop_sidebar_position == 'sidebar_left') {
	$td_sidebar_position = 'td-sidebar-left';
}

