<?php
/**
 * the start of the panel
 */

class td_panel {
    function __construct() {
        // add panel to the wp-admin menu on the left
        add_action('admin_menu', array($this, 'register_theme_panel'));



        if (isset($_GET['page']) and $_GET['page'] == 'td_theme_panel') {
            add_filter('admin_body_class', array($this, 'add_body_class'));
        }


    }


    function add_body_class($classes) {
        $classes .= ' td-theme-panel-body ';
        return $classes;
    }



    /**
     * register our theme panel via the hook
     */
    function register_theme_panel() {
        /* wp doc: add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position ); */
        add_menu_page('Theme panel', TD_THEME_NAME, "edit_posts", "td_theme_welcome", array($this, "td_view_welcome"), null, 3);

        if (current_user_can( 'activate_plugins' )) {
            add_submenu_page("td_theme_welcome", 'Plugins', 'Plugins', 'edit_posts', 'td_theme_plugins', array($this, "td_theme_plugins"));
        }
        add_submenu_page( "td_theme_welcome", 'Install demos', 'Install demos', 'edit_posts', 'td_theme_demos',  array($this, "td_theme_demos") );
        add_submenu_page( "td_theme_welcome", 'Support', 'Support', 'edit_posts', 'td_theme_support',  array($this, "td_theme_support") );
        add_submenu_page( "td_theme_welcome", 'System status', 'System status', 'edit_posts', 'td_system_status',  array($this, "td_system_status") );
        add_submenu_page( "td_theme_welcome", 'Theme panel', 'Theme panel', 'edit_posts', 'td_theme_panel',  array($this, "td_theme_panel") );


        // shit hack for welcome menu
        global $submenu; // this is a global from WordPress
        $submenu['td_theme_welcome'][0][0] = 'Welcome';


    }



    function td_view_welcome() {
        require_once "td_view_welcome.php";
    }


    function td_theme_demos() {
        require_once "td_view_install_demos.php";
    }

	function td_theme_support() {
		require_once "td_view_support.php";
	}

    function td_theme_plugins() {
        require_once "td_view_theme_plugins.php";
    }

    function td_system_status() {
        require_once 'td_view_system_status.php';
    }

    /**
     * this is our theme panel
     */
    function td_theme_panel() {

        //run the wp-admin panel background



        // load the view based on the td_page parameter
        if (!empty($_REQUEST['td_page'])) {

            if ($_REQUEST['td_page'] == 'td_view_import_export_settings') {
                include 'td_view_import_export_settings.php';
            }
            elseif ($_REQUEST['td_page'] == 'td_view_update_newspaper_6') {
	            include 'td_view_update_newspaper_6.php';
            }




        } else {
            // default we load the panel
            include 'td_view_panel.php';
        }

        if(!empty($_REQUEST['clear_social_counter_cache']) and $_REQUEST['clear_social_counter_cache'] == 1) {
            //clear social counter cache
            update_option('td_social_api_v3_last_val', '');
        }

    }





}

new td_panel();




/*  ----------------------------------------------------------------------------
    change the value of the button used to return the picture into pannel
    It only changes the text from insert into post to Use this image
    @deprecated @todo - will have to deprecate this and put proper upload form in the panel
 */
function td_replace_upload_thickbox_button_text($text, $translated_text) {
    if ($text == 'Insert into Post') {
        $referer = strpos(wp_get_referer(), 'td_upload');
        if($referer != '') {
            return 'Use this image';
        }
    }

    //return the default text
    return $translated_text;
}





function td_upload_image_options() {
    global $pagenow;

    if($pagenow == 'media-upload.php' or $pagenow == 'async-upload.php') {
        add_filter('gettext', 'td_replace_upload_thickbox_button_text' , 1, 3);
    }
}

add_action('admin_init', 'td_upload_image_options');







