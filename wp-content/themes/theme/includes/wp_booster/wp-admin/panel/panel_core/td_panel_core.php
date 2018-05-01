<?php



//AJAX VIEW PANEL LOADING
add_action( 'wp_ajax_td_panel_core_load_ajax_box', array('td_panel_core', 'load_ajax_box'));



class td_panel_core {
    private static $current_theme_panel_id = ''; /** the ajax boxes read this @see \td_panel_generator::ajax_box */



    static function get_current_theme_panel_id () { /** the ajax boxes read this @see \td_panel_generator::ajax_box */
        return self::$current_theme_panel_id;
    }



    static function render_panel($all_theme_panels_list, $panel_spot_id) {
        self::$current_theme_panel_id = $panel_spot_id; /** the ajax boxes read this @see \td_panel_generator::ajax_box */

        //print_r($global_panels_array);

        ?>
        <form id="td_panel_big_form" action="?page=td_theme_panel" method="post">


	        <input type="hidden" name="td_magic_token" value="<?php echo wp_create_nonce("td-update-panel") ?>"/>

            <input type="hidden" name="action" value="td_ajax_update_panel">
            <div class="td_displaying_saving"></div>
            <div class="td_wrapper_saving_gifs">
                <img class="td_displaying_saving_gif" src="<?php echo get_template_directory_uri();?>/includes/wp_booster/wp-admin/images/panel/loading.gif">
                <img class="td_displaying_ok_gif" src="<?php echo get_template_directory_uri()?>/includes/wp_booster/wp-admin/images/panel/saved.gif">
            </div>


            <div class="wrap">

                <div class="td-container-wrap">

                    <div class="td-panel-main-header">
                        <img src="<?php echo get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/panel-wrap/panel-logo.png'?>" alt=""/>
                        <span class="td-panel-header-name"><?php echo $all_theme_panels_list[$panel_spot_id]['title']; ?></span>
                        <span class="td-panel-header-version"><?php echo $all_theme_panels_list[$panel_spot_id]['subtitle']; ?></span>
                    </div>


                    <div id="td-container-left">
                        <div id="td-container-right">


                            <!-- Panel Navigation -->
                            <div id="td-col-left">
                                <ul class="td-panel-menu">

                                    <?php
                                    //show the panel tabs on the left
                                    $td_is_first_panel = true;
                                    $td_first_menu_item_class = 'td-panel-menu-active'; //to show the class only on the first loop
                                    $td_first_menu_welcome_menu = 'td-welcome-menu'; //we are using this class to fix some rendering issues with the first menu

                                    foreach ($all_theme_panels_list[$panel_spot_id]['panels'] as $panel_id => $panel_array) {

                                        switch ($panel_array['type']) {
                                            case 'separator':
                                                //it's a group
                                                ?>
                                                <li class="td-panel-menu-sep"><?php echo $panel_array['text'] ?></li>
                                                <?php
                                                break;


                                            case 'link':
                                                ?>
                                                <li>
                                                    <a href="<?php echo $panel_array['url'] ?>">
                                                        <span class="td-sp-nav-icon td-ico-export"></span>
                                                        <?php echo $panel_array['text'] ?>
                                                        <span class="td-arrow"></span>
                                                    </a>
                                                </li>
                                                <?php
                                                break;


                                            default:
                                                ?>
                                                <li class="<?php echo $td_first_menu_welcome_menu?>">
                                                    <a data-panel="<?php echo $panel_id ?>" data-bg="<?php echo esc_attr(get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/bg/1.jpg')?>" class="<?php echo $td_first_menu_item_class; ?>" href="#">
                                                        <span class="td-sp-nav-icon <?php echo $panel_array['ico_class'] ?>"></span>
                                                        <?php echo $panel_array['text'] ?>
                                                        <span class="td-arrow"></span>
                                                    </a>
                                                </li>

                                                <?php
                                                break;
                                        }


                                        $td_first_menu_item_class = ''; // do not show any more td-panel-menu-active
                                        $td_first_menu_welcome_menu = '';
                                    }
                                    ?>




                                </ul>
                            </div>



                            <!-- Panel Content -->
                            <div id="td-col-right" class="td-panel-content">
                                <?php
                                // show the panel views
                                $td_panel_active = 'td-panel-active'; //to show the class only on the first loop
                                foreach ($all_theme_panels_list[$panel_spot_id]['panels'] as $panel_id => $panel_array) {
                                    if (isset($panel_array['file'])) {

                                        ?>
                                        <div id="<?php echo $panel_id ?>" class="<?php echo $td_panel_active ?> td-panel">
                                            <?php
                                            require_once($panel_array['file']); // the panel is loaded from our hardcoded global panel list - there should be no security issues
                                            ?>
                                        </div>
                                        <?php
                                        $td_panel_active = '';
                                    }
                                }
                                ?>
                            </div>



                        </div>
                    </div>

                    <div class="td-clear"></div>

                    <div class="td-panel-main-footer">
                        <input type="button" id="td_button_save_panel" class="td-panel-save-button" value="SAVE SETTINGS">
                    </div>

                </div>

                <div class="td-clear"></div>
        </form>

        <?php
    }




    /**
     * Loads the ajax box content
     */
    static function load_ajax_box() {

	    // die if request is fake
	    check_ajax_referer('td-panel-box', 'td_magic_token');


        //if user is logged in and can switch themes
        if (!current_user_can('edit_theme_options')) {
            die;
        }


        // read some of the variables
        $td_ajax_calling_file = td_util::get_http_post_val('td_ajax_calling_file');
        $td_ajax_box_id = td_util::get_http_post_val('td_ajax_box_id');

        $td_current_panel_spot_id =  td_util::get_http_post_val('td_current_theme_panel_id');



        $td_ajax_calling_file_id = str_replace('.php', '', $td_ajax_calling_file); //get the calling file id so we can look it up in our td_global panel list array


        $buffy = '';


        foreach (td_global::$all_theme_panels_list[$td_current_panel_spot_id]['panels'] as $panel_id => $panel_array) {

            // locate the entry for this specific panel spot -> panel by using the 'file' key
            if (isset($panel_array['file']) and strpos($panel_array['file'], $td_ajax_calling_file) !== false) {


                if ($panel_array['type'] == 'in_theme') {
                    // if the panel is in theme, we have to look for it in the theme's /panel folder and only after that in the wp-booster panel
                    ob_start();
                    $td_template_found_in_theme_or_child = locate_template('includes/panel/views/ajax_boxes/' . $td_ajax_calling_file_id  . '/' . $td_ajax_box_id . '.php', true);
                    if (empty($td_template_found_in_theme_or_child)) {
                        require_once(TEMPLATEPATH . '/includes/wp_booster/wp-admin/panel/views/ajax_boxes/' . $td_ajax_calling_file_id . '/' . $td_ajax_box_id . '.php');
                    }
                    $buffy = ob_get_clean();


                } elseif ($panel_array['type'] == 'in_plugin') {
                    // the panel is in a plugin. Here we look in the plugins folder and we patch the path for this specific plugin
                    $folder_path = dirname($panel_array['file']);

                    $ajax_box_plugin_path = $folder_path . '/' . $td_ajax_calling_file_id . '/' . $td_ajax_box_id;
                    if (file_exists($ajax_box_plugin_path)) {
                        ob_start();
                        require_once $ajax_box_plugin_path;
                        $buffy = ob_get_clean();
                    }
                }

                break; // we found our item and we tried to load it, now exit the loop
            }
        }




        if (empty($buffy)) {
            $buffy = 'No ajax panel found OR Panel is empty! <br> ' . __FILE__;
        }


        // each panel has to have a td-clear at the end
        $buffy .= '<div class="td-clear"></div>';

        //return the view counts
        die(json_encode($buffy));


    }

}