<?php
/*
	Plugin Name: tagDiv Social Counter
	Plugin URI: http://tagdiv.com
	Description: Social counter for WordPress. Widget and visual composer block.
	Author: tagDiv
	Version: 4.1
	Author URI: http://tagdiv.com
*/


// load the api
require_once 'td_social_api.php';



class td_social_counter_plugin {

    var $plugin_path = '';

    function __construct($load_before_theme = false, $siblings_priority_level = 0) {
        $this->plugin_path =  dirname(__FILE__);
        add_action('td_global_after', array($this, 'hook_td_global_after'));
        add_action('td_wp_booster_loaded', array($this, 'td_wp_booster_loaded'));

	    add_action('wp_ajax_vc_edit_form', 'td_vc_edit_form');
	    function td_vc_edit_form() {
		    echo '<script type="text/javascript" src="' . plugin_dir_url( __FILE__ ) . 'js/td_social_counter.js"></script>';
	    }
    }

    function td_wp_booster_loaded() {
        require_once 'widget/td_block_social_counter_widget.php';
    }

    function hook_td_global_after() {
        $block_id = 'td_block_social_counter';

        $block_settings = array(
            'map_in_visual_composer' => true,
            "name" => 'Social Counter',
            "base" => 'td_block_social_counter',
            "class" => 'td_block_social_counter',
            "controls" => "full",
            "category" => __('Blocks', TD_THEME_NAME),
            'icon' => 'icon-pagebuilder-td_social_counter',
            "params" => array(
                array(
                    "param_name" => "custom_title",
                    "type" => "textfield",
                    "value" => "Block title",
                    "heading" => __("Optional - custom title for this block:", TD_THEME_NAME),
                    "description" => "",
                    "holder" => "div",
                    "class" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Header color", TD_THEME_NAME),
                    "param_name" => "header_color",
                    "value" => '', //Default Red color
                    "description" => __("Choose a custom header color for this block", TD_THEME_NAME)
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Header text color", TD_THEME_NAME),
                    "param_name" => "header_text_color",
                    "value" => '', //Default Red color
                    "description" => __("Choose a custom header color for this block", TD_THEME_NAME)
                ),

                array(
                    "param_name" => "style",
                    "type" => "dropdown",
                    "value" => array('Default' => '', 'Style 1 - Default black' => 'style1', 'Style 2 - Default with border' => 'style2 td-social-font-icons', 'Style 3 - Default colored circle' => 'style3 td-social-colored', 'Style 4 - Default colored square' => 'style4 td-social-colored', 'Style 5 - Boxes with space' => 'style5 td-social-boxed', 'Style 6 - Full boxes' => 'style6 td-social-boxed', 'Style 7 - Black boxes' => 'style7 td-social-boxed', 'Style 8 - Boxes with border' => 'style8 td-social-boxed td-social-font-icons', 'Style 9 - Colored circles' => 'style9 td-social-boxed td-social-colored', 'Style 10 - Colored squares' => 'style10 td-social-boxed td-social-colored'),
                    "heading" => 'Style:',
                    "description" => "Style of the `Social Counter` widget",
                    "holder" => "div",
                    "class" => ""
                ),

                array(
                    "param_name" => "facebook",
                    "type" => "textfield",
                    "value" => "",
                    "heading" => __("Facebook id:", TD_THEME_NAME) . '&nbsp<a href="http://forum.tagdiv.com/tagdiv-social-counter-tutorial/" target="_blank">Also Complete the App Id and the Security Key</a>',
                    "description" => "",
                    "holder" => "div",
                    "class" => ""
                ),
	            array(
		            "param_name" => "facebook_app_id",
		            "type" => "textfield",
		            "value" => "",
		            "heading" => __("Facebook App Id:", TD_THEME_NAME),
		            "description" => "",
		            "holder" => "div",
		            "class" => ""
	            ),
	            array(
		            "param_name" => "facebook_security_key",
		            "type" => "textfield",
		            "value" => "",
		            "heading" => __("Facebook Security Key:", TD_THEME_NAME),
		            "description" => "",
		            "holder" => "div",
		            "class" => ""
	            ),
	            array(
		            "param_name" => "facebook_access_token",
		            "type" => "textfield",
		            "value" => "",
		            "heading" => __("Facebook Access Token:", TD_THEME_NAME) . '&nbsp;<a class="td_access_token facebook" href="#">Get Access Token</a><i class="td_access_token_info" style="display: none; color: #F00; margin-left: 10px">Please wait...</i>',
		            "description" => "",
		            "holder" => "div",
		            "class" => ""
	            ),
                array(
                    "param_name" => "twitter",
                    "type" => "textfield",
                    "value" => "",
                    "heading" => __("Twitter id:", TD_THEME_NAME),
                    "description" => "",
                    "holder" => "div",
                    "class" => ""
                ),
                array(
                    "param_name" => "youtube",
                    "type" => "textfield",
                    "value" => "",
                    "heading" => __("Youtube id:", TD_THEME_NAME),
                    "description" => "User: www.youtube.com/user/<b style='color: #000'>ENVATO</b><br/>Channel: www.youtube.com/<b style='color: #000'>channel/UCJr72fY4cTaNZv7WPbvjaSw</b>",
                    "holder" => "div",
                    "class" => ""
                ),
                array(
                    "param_name" => "vimeo",
                    "type" => "textfield",
                    "value" => "",
                    "heading" => __("Vimeo id:", TD_THEME_NAME),
                    "description" => "",
                    "holder" => "div",
                    "class" => ""
                ),
                array(
                    "param_name" => "googleplus",
                    "type" => "textfield",
                    "value" => '',
                    "heading" => __("Google Plus User:", TD_THEME_NAME),
                    "description" => "",
                    "holder" => "div",
                    "class" => ""
                ),
                array(
                    "param_name" => "instagram",
                    "type" => "textfield",
                    "value" => '',
                    "heading" => __("Instagram User:", TD_THEME_NAME),
                    "description" => "",
                    "holder" => "div",
                    "class" => ""
                ),
                array(
                    "param_name" => "soundcloud",
                    "type" => "textfield",
                    "value" => '',
                    "heading" => __("Soundcloud User:", TD_THEME_NAME),
                    "description" => "",
                    "holder" => "div",
                    "class" => ""
                ),
                array(
                    "param_name" => "rss",
                    "type" => "textfield",
                    "value" => '',
                    "heading" => __("Feed subscriber count:", TD_THEME_NAME),
                    "description" => "Write the number of followers",
                    "holder" => "div",
                    "class" => ""
                ),
                array(
                    "param_name" => "open_in_new_window",
                    "type" => "dropdown",
                    "value" => array('- Same window -' => '', 'New window' => 'y'),
                    "heading" => __("Open in:", TD_THEME_NAME),
                    "description" => "",
                    "holder" => "div",
                    "class" => ""
                )
            )
        );

        $td_theme_name = '';
        if (defined('TD_THEME_NAME')) {
            $td_theme_name = TD_THEME_NAME;
        }



        $block_settings['file'] = $this->plugin_path . '/shortcode/td_block_social_counter.php';

        if ($td_theme_name == 'Newsmag') {
            // on 010 add the border_top parameter
	        $block_settings['params'][] =
                array(
	                "param_name" => "border_top",
	                "type" => "dropdown",
	                "value" => array('- With border -' => '', 'no border' => 'no_border_top'),
	                "heading" => __("Border top:", TD_THEME_NAME),
	                "description" => "",
	                "holder" => "div",
	                "class" => ""
                );

        }

        td_api_block::add($block_id, $block_settings);

    }
}

new td_social_counter_plugin();
