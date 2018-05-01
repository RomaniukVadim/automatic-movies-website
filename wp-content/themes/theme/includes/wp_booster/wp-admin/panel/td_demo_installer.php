<?php
/**
 * Created by ra on 5/15/2015.
 */
class td_demo_installer {




    function __construct() {
        //AJAX VIEW PANEL LOADING
        add_action( 'wp_ajax_td_ajax_demo_install', array( $this, 'ajax_demos_controller' ) );
    }


    function ajax_demos_controller() {


		// die if request is fake
	    check_ajax_referer('td-demo-install', 'td_magic_token');

        if (!current_user_can('switch_themes')) {
            die;
        }

        // try to extend the time limit
        @set_time_limit(240);


        $td_demo_action = td_util::get_http_post_val('td_demo_action');
        $td_demo_id = td_util::get_http_post_val('td_demo_id');



        /*  ----------------------------------------------------------------------------
            Uninstall button - do uninstall with content
         */
        if ($td_demo_action == 'uninstall_demo') {
            // remove our content
            td_demo_media::remove();
            td_demo_content::remove();
            td_demo_category::remove();
            td_demo_menus::remove();
            td_demo_widgets::remove();

            // restore all settings to the state before a demo was loaded
            $td_demo_history = new td_demo_history();
            $td_demo_history->restore_all();

            // update our state - no stack installed
            td_demo_state::update_state('', '');
        }




        /*  ----------------------------------------------------------------------------
            remove content before stack install
        */



        /*  ----------------------------------------------------------------------------
           Install content only - remove old settings
       */
        else if ($td_demo_action == 'remove_content_before_install_no_content') {

            // save the history - this class will save the history only when going from user settings -> stack
            $td_demo_history = new td_demo_history();
            $td_demo_history->save_all();



            // clean the user settings
            td_demo_media::remove();
            td_demo_content::remove();
            td_demo_category::remove();
            td_demo_menus::remove();
            td_demo_widgets::remove();


            // remove panel settings and recompile the css as empty
            foreach (td_global::$td_options as $option_id => $option_value) {
                td_global::$td_options[$option_id] = '';
            }
            //typography settings
            td_global::$td_options['td_fonts'] = '';
            //css font files (google) buffer
            td_global::$td_options['td_fonts_css_files'] = '';
            //compile user css if any
            td_global::$td_options['tds_user_compile_css'] = td_css_generator();
            update_option(TD_THEME_OPTIONS_NAME, td_global::$td_options);
        }

        /*  ----------------------------------------------------------------------------
            Install with no content
        */
        else if ($td_demo_action == 'install_no_content_demo') {
            td_demo_state::update_state($td_demo_id, 'no_content');
            // load panel settings - this will also recompile the css
            $this->import_panel_settings(td_global::$demo_list[$td_demo_id]['folder'] . 'td_panel_settings.txt', false);
        }





        // step 1
        else if ($td_demo_action == 'remove_content_before_install') {

            // save the history - this class will save the history only when going from user settings -> stack
            $td_demo_history = new td_demo_history();
            $td_demo_history->save_all();



            // clean the user settings
            td_demo_media::remove();
            td_demo_content::remove();
            td_demo_category::remove();
            td_demo_menus::remove();
            td_demo_widgets::remove();
        }
        /*  ----------------------------------------------------------------------------
            install Full
        */
        else if ($td_demo_action == 'td_media_1') {
            // change our state
            td_demo_state::update_state($td_demo_id, 'full');

            // load panel settings
            $this->import_panel_settings(td_global::$demo_list[$td_demo_id]['folder'] . 'td_panel_settings.txt', true);

            // load the media import script
            require_once(td_global::$demo_list[$td_demo_id]['folder'] . 'td_media_1.php');
        }


        else if ($td_demo_action == 'td_media_2') {
	        //echo 'sss';
            // load the media import script
            require_once(td_global::$demo_list[$td_demo_id]['folder'] . 'td_media_2.php');
        }
        else if ($td_demo_action == 'td_media_3') {

            // load the media import script
            require_once(td_global::$demo_list[$td_demo_id]['folder'] . 'td_media_3.php');
        }
        else if ($td_demo_action == 'td_media_4') {
            // load the media import script
            require_once(td_global::$demo_list[$td_demo_id]['folder'] . 'td_media_4.php');
        }
        else if ($td_demo_action == 'td_media_5') {
            // load the media import script
            require_once(td_global::$demo_list[$td_demo_id]['folder'] . 'td_media_5.php');
        }
        else if ($td_demo_action == 'td_media_6') {
            // load the media import script
            require_once(td_global::$demo_list[$td_demo_id]['folder'] . 'td_media_6.php');
        }


        else if ($td_demo_action == 'td_import')  {
            require_once(td_global::$demo_list[$td_demo_id]['folder'] . 'td_import.php');

        }


    }


    public function import_panel_settings($file_path, $empty_ignored_settings = false) { //it's public only for testing

        // this settings will be "" out when any of the imports is runned
        $ignored_settings = array(
            'tds_logo_upload',
            'tds_logo_upload_r',
            'tds_favicon_upload',
            'tds_logo_menu_upload',
            'tds_logo_menu_upload_r',
            'tds_footer_logo_upload',
            'tds_footer_retina_logo_upload',
            'tds_site_background_image',
            'category_options',
            'td_ads',
            'sidebars'
        );


        //read the settings file
        $file_settings = unserialize(base64_decode(file_get_contents($file_path, true)));

        //apply td_cake variables
        $file_settings['td_cake_status_time'] = td_util::get_option('td_cake_status_time');
        $file_settings['td_cake_status'] = td_util::get_option('td_cake_status');
        $file_settings['envato_key'] = td_util::get_option('envato_key');


        if ($empty_ignored_settings === true) {
            // we empty the ignored settings
            td_global::$td_options = $file_settings;
            foreach ($ignored_settings as $setting) {
	            if (isset(td_global::$td_options[$setting])) {
		            unset(td_global::$td_options[$setting]);
	            }
                //td_global::$td_options[$setting] = '';
            }
        } else {
            // we leave the ignored settings alone
            foreach ($file_settings as $setting_id => $setting_value) {
                if (!in_array($setting_id, $ignored_settings)) {
                    td_global::$td_options[$setting_id] = $setting_value;
                }
            }
        }

        //compile user css if any
        td_global::$td_options['tds_user_compile_css'] = td_css_generator();
        //write the changes to the database
        update_option(TD_THEME_OPTIONS_NAME, td_global::$td_options);
    }

}

new td_demo_installer();