<?php


if (empty($_REQUEST['td_magic_token']) || wp_verify_nonce($_REQUEST['td_magic_token'], 'td-newspaper4-import') === false) {
	echo 'Permission denied';
	die;
}


class td_update_to_newspaper6 {
    static $shortcode_map = array (
        'td_block10' => 'td_block_9',
        'td_block1' => 'td_block_1',
        'td_block2' => 'td_block_2',
        'td_block3' => 'td_block_3',
        'td_block4' => 'td_block_7',
        'td_block5' => 'td_block_8',
        'td_block6' => 'td_block_11',
        'td_block7' => 'td_block_5',
        'td_block8' => 'td_block_4',
        'td_block9' => 'td_block_12',

        'td_ad_box'             => 'td_block_ad_box',
        //'td_social' => '',
        'td_popular_categories' => 'td_block_popular_categories',
        'td_authors'            => 'td_block_authors',
        'td_text_with_title'    => 'td_block_text_with_title',
        'td_slide_big'          => 'td_block_big_grid_2',
        'td_slide'              => 'td_block_slide',
        'td_video_youtube'      => 'td_block_video_youtube',
        'td_video_vimeo'        => 'td_block_video_vimeo',
        'td_social_counter'     => 'td_block_social_counter'
    );

    static $td_options_to_be_imported = array (
        'tds_archive_page_layout',
        'tds_archive_sidebar_pos',
        'tds_author_page_layout',
        'tds_author_sidebar_pos',
        'tds_category_page_layout',
        'tds_category_sidebar_pos',
        'tds_tag_page_layout',
        'tds_tag_sidebar_pos',
        'tds_404_page_layout',
        'tds_logo_upload',
        'tds_logo_upload_r',
        'tds_favicon_upload',
        'tds_show_featured_image',
        'tds_featured_image_view_setting',   // de verificat
        'tds_show_tags',
        'tds_show_author_box',
        'tds_show_next_prev',
        'tds_similar_articles',
        'tds_similar_articles_type',   //verificat
        'tds_breadcrumbs_show',
        'tds_breadcrumbs_show_home',
        'tds_breadcrumbs_show_parent',
        'tds_breadcrumbs_show_article',
        'tds_snap_menu',  // de verificat
        'tds_stretch_background',
        'tds_header_style',  //verificat?
        'tds_inline_ad_paragraph',   //wtf ce ii
        'tds_footer_copyright',
        'tds_footer_copy_symbol',
        'tds_home_sidebar',
        'tds_home_page_layout',
        'tds_home_sidebar_pos',
        'tds_page_sidebar_pos',
        'tds_page_sidebar',
        'tds_archive_sidebar',
        'tds_author_sidebar',
        'tds_category_sidebar',
        'tds_tag_sidebar',
        'tds_search_sidebar_pos',
        'tds_search_sidebar',
        'tds_search_page_layout',
        'tds_attachment_sidebar_pos',
        'tds_attachment_sidebar',
        'tds_theme_color',
        'tds_logo_alt',
        'tds_logo_title',
        'td_analytics',
        'tds_woo_sidebar_pos',
        'tds_woo_sidebar',
        'tds_p_show_date',
        'tds_p_show_views',
        'tds_p_show_comments',
        'tds_top_menu',
        'tds_data_top_menu',
        'tds_data_time_format',
        'tds_p_enable_7_days_count',
        'tds_header_wrap_color',
        'tds_excerpts_type',
        'tds_bbpress_sidebar_pos',
        'tds_bbpress_sidebar',
        'tds_footer_color',
        'tds_footer_bottom_color',
        'tds_ios_icon_76',
        'tds_ios_icon_120',
        'tds_ios_icon_152',
        'tds_ios_icon_114',
        'tds_ios_icon_144',
        'tds_footer_text_color',
        'tds_footer_bottom_text_color',
        'td_ads',   // de verificat
        'category_options',  //de verificat
        'tds_inline_ad_align',
        'tds_disable_comments_sidewide',
        'tds_more_articles_on_post_pages_enable',
        'tds_more_articles_on_post_pages_distance_from_top',
        'tds_more_articles_on_post_pages_display',
        'tds_more_articles_on_post_pages_display_module',
        'tds_more_articles_on_post_pages_number',
        'tds_more_articles_on_post_pages_time_to_wait',
        'tds_disable_comments_pages',
        'tds_site_background_image',
        'tds_site_background_repeat',
        'tds_site_background_position_x',
        'tds_site_background_attachment',
        'tds_site_background_color',
        'td_fonts',   // de verificat
        'td_fonts_js_buffer',
        'td_fonts_css_buffer',
        'td_fonts_css_files',
        'tds_logo_menu_upload',
        'tds_logo_menu_upload_r',
        'tds_tweeter_username',
        'tds_footer',   // ???
        'tds_sub_footer',
        'td_default_site_post_template',
        'td_cake_status_time',
        'td_cake_status',
        'envato_key',
        'tds_ajax_post_view_count',
        'sidebars'
    );



    private static function replace_shortcodes($short_code_string) {
        return str_replace(array_keys(self::$shortcode_map ), array_values(self::$shortcode_map), $short_code_string);
    }


    /**
     * @param $sidebars_widgets string get_option('sidebars_widgets' )
     * @return array with new sidebars widgets
     */
    static function update_sidebar_widgets($sidebars_widgets) {
        if (is_array($sidebars_widgets)) {
            foreach ($sidebars_widgets as $sidebar_id => &$widgets) {
                if (is_array($widgets)) {
                    foreach ($widgets as &$widget) {
                        $widget = self::replace_shortcodes($widget);
                    }
                }
            }
        }
        return $sidebars_widgets;
    }


    /**
     * bring the new shortcodes in the theme
     * @param $content
     * @return mixed
     */
    static function update_content($content) {
        return self::replace_shortcodes($content);
    }


    static function update_theme_settings($old_theme_settings) {
        $settings_buffer = array();

        foreach (self::$td_options_to_be_imported as $option_id) {
            if (isset($old_theme_settings[$option_id]) and !empty($old_theme_settings[$option_id])) {
                $settings_buffer[$option_id] = $old_theme_settings[$option_id];
            }
        }
        td_global::$td_options = $settings_buffer;
        update_option(TD_THEME_OPTIONS_NAME, td_global::$td_options);
    }


    static function log($msg) {
        echo '> ' . $msg . '<br>';
    }
}







?>

<div class="wrap">

<div class="td-container-wrap">

    <div class="td-panel-main-header">
        <img src="<?php echo get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/panel-wrap/panel-logo.png'?>" alt=""/>
        <span class="td-panel-header-name"><?php echo TD_THEME_NAME . ' - Theme panel'; ?></span>
        <span class="td-panel-header-version">version: <?php echo TD_THEME_VERSION; ?></span>
    </div>


    <div id="td-container-left">
        <div id="td-container-right">
            <div id="td-col-left">
                <ul class="td-panel-menu">
                    <li class="td-welcome-menu">
                        <a data-td-is-back="yes" class="td-panel-menu-active" href="?page=td_theme_panel">
                            <span class="td-sp-nav-icon td-ico-export"></span>
                            Importing settings:
                            <span class="td-no-arrow"></span>
                        </a>
                    </li>

                    <li>
                        <a data-td-is-back="yes" href="?page=td_theme_welcome">
                            <span class="td-sp-nav-icon td-ico-back"></span>
                            Back
                            <span class="td-no-arrow"></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="td-col-right" class="td-panel-content" style="min-height: 900px">

                <!-- Export theme settings -->
                <div id="td-panel-welcome" class="td-panel-active td-panel">

                    <?php echo td_panel_generator::box_start('Newspaper 4 - Newspaper 6 updater'); ?>

                    <div class="td-box-row">

                        Import script started: <br><br>

                        <?php
                        delete_option('wpb_js_column_css_classes');
                        delete_option('wpb_js_row_css_class');
                        delete_option('wpb_js_templates');



                        $old_newspaper_options = get_option('td_008');
                        if (isset($old_newspaper_options) and is_array($old_newspaper_options)) {
                            // import the widgets
                            td_update_to_newspaper6::log('Importing widgets');

                            // import the sidebar_widgets
                            $old_sidebars_widgets = get_option('sidebars_widgets');
                            $fixed_sidebars_widgets = td_update_to_newspaper6::update_sidebar_widgets($old_sidebars_widgets);
                            update_option('sidebars_widgets', $fixed_sidebars_widgets);


                            // update each widget
                            foreach (td_update_to_newspaper6::$shortcode_map as $old_shortcode => $new_shortcode) {
                                $db_get_widget_option = get_option('widget_' . $old_shortcode . '_widget');
                                if (!empty($db_get_widget_option)) {
                                    update_option('widget_' . $new_shortcode . '_widget', $db_get_widget_option);
                                }
                            }


                            // import the settings
                            td_update_to_newspaper6::log('Importing theme settings');
                            td_update_to_newspaper6::update_theme_settings($old_newspaper_options);


                            /*
                             *  - content
                             *  - post templates
                             *  - modules
                             */
                            td_update_to_newspaper6::log('Updating the content');
                            $args = array(
                                'post_type' => array('page'),
                                'posts_per_page' => '150'
                            );
                            $query = new WP_Query( $args );
                            if (!empty($query->posts)) {
                                foreach ($query->posts as $post) {
                                    // change the shortcodes
                                    $post->post_content = td_update_to_newspaper6::update_content($post->post_content);
                                    wp_update_post($post);

                                    // change the templates
                                    $td_cur_post_template = get_post_meta($post->ID, '_wp_page_template', true);
                                    if ($td_cur_post_template == 'page-homepage-bg-loop.php' or 'page-homepage-loop.php') {
                                        update_post_meta($post->ID, '_wp_page_template', 'page-pagebuilder-latest.php');
                                    } else {
                                        update_post_meta($post->ID, '_wp_page_template', '');
                                    }


                                }


                            }

                            delete_option('wpb_js_column_css_classes');
                            delete_option('wpb_js_row_css_class');
                            delete_option('wpb_js_templates');


                            td_update_to_newspaper6::log('Please regenerate your thumbnails!');
                        } else {
                            // td_008 - not found
                            td_update_to_newspaper6::log('Newspaper 4 settings not found in database! td_008 - not found');
                            td_update_to_newspaper6::log('Quiting!');
                        }


                        ?>


                        <div class="td-box-row-margin-bottom"></div>
                    </div>


                    <?php echo td_panel_generator::box_end();?>
                </div>


            </div>
        </div>
    </div>

    <div class="td-clear"></div>

</div>

<div class="td-clear"></div>
<br><br><br><br><br><br><br>


<?php

/*
die;
$sidebar_widgets_test = 'a:21:{s:19:"wp_inactive_widgets";a:3:{i:0;s:19:"td_block4_widget-11";i:1;s:18:"td_block3_widget-3";i:2;s:18:"td_social_widget-7";}s:10:"td-default";a:4:{i:0;s:26:"td_social_counter_widget-2";i:1;s:18:"td_ad_box_widget-5";i:2;s:18:"td_block2_widget-2";i:3;s:17:"td_slide_widget-2";}s:12:"td-top-right";a:1:{i:0;s:19:"login_form_widget-2";}s:11:"td-footer-1";a:2:{i:0;s:20:"footer_logo_widget-3";i:1;s:18:"td_social_widget-4";}s:11:"td-footer-2";a:1:{i:0;s:18:"td_block4_widget-8";}s:11:"td-footer-3";a:1:{i:0;s:30:"td_popular_categories_widget-2";}s:18:"td-default-widgets";a:13:{i:0;s:10:"archives-6";i:1;s:10:"archives-7";i:2;s:10:"calendar-3";i:3;s:12:"categories-5";i:4;s:11:"tag_cloud-5";i:5;s:17:"recent-comments-3";i:6;s:8:"search-7";i:7;s:14:"recent-posts-4";i:8;s:14:"recent-posts-3";i:9;s:12:"categories-4";i:10;s:6:"meta-9";i:11;s:12:"categories-3";i:12;s:10:"archives-5";}s:11:"td-homepage";a:1:{i:0;s:18:"td_block1_widget-2";}s:10:"td-authors";a:2:{i:0;s:19:"td_authors_widget-3";i:1;s:18:"td_block2_widget-3";}s:13:"td-homepage-2";a:2:{i:0;s:8:"search-8";i:1;s:18:"td_block2_widget-9";}s:11:"td-archives";a:3:{i:0;s:10:"archives-8";i:1;s:8:"search-9";i:2;s:18:"td_block4_widget-9";}s:7:"td-tags";a:2:{i:0;s:11:"tag_cloud-6";i:1;s:19:"td_block4_widget-10";}s:13:"td-attachment";a:1:{i:0;s:18:"td_block2_widget-5";}s:11:"td-category";a:1:{i:0;s:18:"td_block2_widget-6";}s:8:"td-video";a:1:{i:0;s:6:"text-2";}s:13:"td-shortcodes";a:1:{i:0;s:10:"nav_menu-2";}s:22:"td-woocommerce-sidebar";a:4:{i:0;s:25:"woocommerce_widget_cart-2";i:1;s:28:"woocommerce_product_search-2";i:2;s:26:"woocommerce_price_filter-2";i:3;s:32:"woocommerce_top_rated_products-2";}s:10:"td-modules";a:4:{i:0;s:6:"text-3";i:1;s:18:"td_ad_box_widget-6";i:2;s:26:"td_social_counter_widget-3";i:3;s:18:"td_block2_widget-7";}s:10:"td-reviews";a:2:{i:0;s:18:"td_block2_widget-8";i:1;s:18:"td_block3_widget-2";}s:20:"td-test-adsense-spot";a:1:{i:0;s:18:"td_ad_box_widget-7";}s:13:"array_version";i:3;}';
$testing_options_009 = 'YToyNjE6e3M6ODoic2lkZWJhcnMiO2E6MTQ6e2k6MDtzOjE1OiJEZWZhdWx0IFdpZGdldHMiO2k6MTtzOjg6IkhvbWVwYWdlIjtpOjI7czo3OiJBdXRob3JzIjtpOjM7czoxMDoiSG9tZXBhZ2UgMiI7aTo0O3M6ODoiQXJjaGl2ZXMiO2k6NTtzOjQ6IlRhZ3MiO2k6NjtzOjEwOiJBdHRhY2htZW50IjtpOjc7czo4OiJDYXRlZ29yeSI7aTo4O3M6NToiVmlkZW8iO2k6OTtzOjEwOiJTaG9ydGNvZGVzIjtpOjEwO3M6MTk6Ildvb2NvbW1lcmNlIHNpZGViYXIiO2k6MTE7czo3OiJNb2R1bGVzIjtpOjEyO3M6NzoiUmV2aWV3cyI7aToxMztzOjE3OiJ0ZXN0IGFkc2Vuc2Ugc3BvdCI7fXM6MTE6InRkX2FkX3Nwb3RzIjthOjI6e3M6MTA6InNpZGViYXIgYWQiO2E6NTp7czoxOiJwIjtzOjExNToiPGEgaHJlZj1cIiNcIj48aW1nIHNyYz1cImh0dHA6Ly8wZGl2LmNvbTo2OS9uZXdzcGFwZXJfZGVtby93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wOC9hZHMtMzAwLmpwZ1wiIGFsdD1cIlwiIC8+PC9hPiI7czoyOiJ0cCI7czoxMTU6IjxhIGhyZWY9XCIjXCI+PGltZyBzcmM9XCJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDgvYWRzLTIwMC5qcGdcIiBhbHQ9XCJcIiAvPjwvYT4iO3M6MjoidGwiO3M6MTE1OiI8YSBocmVmPVwiI1wiPjxpbWcgc3JjPVwiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzA4L2Fkcy0yNTAuanBnXCIgYWx0PVwiXCIgLz48L2E+IjtzOjE6Im0iO3M6MTE1OiI8YSBocmVmPVwiI1wiPjxpbWcgc3JjPVwiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzA4L2Fkcy0zMDAuanBnXCIgYWx0PVwiXCIgLz48L2E+IjtzOjQ6Im5hbWUiO3M6MTA6InNpZGViYXIgYWQiO31zOjY6InRvcCBhZCI7YTo0OntzOjI6InRwIjtzOjE0OToiPGEgaHJlZj1cIiNcIj48aW1nIGNsYXNzPVwidGQtcmV0aW5hXCIgd2lkdGg9XCI0NjhcIiBzcmM9XCJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDgvYWRzLTQ2OC5qcGdcIiBhbHQ9XCJcIiAvPjwvYT4iO3M6MjoidGwiO3M6MTQ5OiI8YSBocmVmPVwiI1wiPjxpbWcgY2xhc3M9XCJ0ZC1yZXRpbmFcIiB3aWR0aD1cIjQ2OFwiIHNyYz1cImh0dHA6Ly8wZGl2LmNvbTo2OS9uZXdzcGFwZXJfZGVtby93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wOC9hZHMtNDY4LmpwZ1wiIGFsdD1cIlwiIC8+PC9hPiI7czoxOiJtIjtzOjExNToiPGEgaHJlZj1cIiNcIj48aW1nIHNyYz1cImh0dHA6Ly8wZGl2LmNvbTo2OS9uZXdzcGFwZXJfZGVtby93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wOC9hZHMtNzI4LmpwZ1wiIGFsdD1cIlwiIC8+PC9hPiI7czo0OiJuYW1lIjtzOjY6InRvcCBhZCI7fX1zOjEyOiJmaXJzdEluc3RhbGwiO3M6MTQ6InRoZW1lSW5zdGFsbGVkIjtzOjE0OiJ0ZHNfcmVzcG9uc2l2ZSI7czowOiIiO3M6MTY6InRkc19ibG9nX3NpZGViYXIiO3M6MDoiIjtzOjIwOiJ0ZHNfYmxvZ19zaWRlYmFyX3BvcyI7czowOiIiO3M6MTc6InRkc19ibG9nX2V4Y2VycHRzIjtzOjA6IiI7czoyMzoidGRzX2FyY2hpdmVfcGFnZV9sYXlvdXQiO3M6MToiNiI7czoyMzoidGRzX2FyY2hpdmVfc2lkZWJhcl9wb3MiO3M6MDoiIjtzOjIyOiJ0ZHNfYXV0aG9yX3BhZ2VfbGF5b3V0IjtzOjE6IjYiO3M6MjI6InRkc19hdXRob3Jfc2lkZWJhcl9wb3MiO3M6MDoiIjtzOjI0OiJ0ZHNfY2F0ZWdvcnlfcGFnZV9sYXlvdXQiO3M6MToiNiI7czoyNDoidGRzX2NhdGVnb3J5X3NpZGViYXJfcG9zIjtzOjA6IiI7czoxOToidGRzX3RhZ19wYWdlX2xheW91dCI7czoxOiI1IjtzOjE5OiJ0ZHNfdGFnX3NpZGViYXJfcG9zIjtzOjA6IiI7czoxOToidGRzXzQwNF9wYWdlX2xheW91dCI7czoxOiI2IjtzOjE2OiJ0ZHNfaGVhZGVyX2NvbG9yIjtzOjc6IiNlZTU2NTYiO3M6MjE6InRkc19oZWFkZXJfbGluZV9jb2xvciI7czo3OiIjZjU3MjcyIjtzOjE0OiJ0ZHNfbGlua19jb2xvciI7czowOiIiO3M6MjA6InRkc19saW5rX2hvdmVyX2NvbG9yIjtzOjA6IiI7czoxNToidGRzX2xvZ29fdXBsb2FkIjtzOjc2OiJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDcvaGVhZGVyLWxvZ28ucG5nIjtzOjE3OiJ0ZHNfbG9nb191cGxvYWRfciI7czo4MzoiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzA3L2hlYWRlci1sb2dvLXJldGluYS5wbmciO3M6MTg6InRkc19mYXZpY29uX3VwbG9hZCI7czo3NDoiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzA4L2Zhdmljb24xMS5wbmciO3M6MjM6InRkc19zaG93X2ZlYXR1cmVkX2ltYWdlIjtzOjA6IiI7czozMToidGRzX2ZlYXR1cmVkX2ltYWdlX3ZpZXdfc2V0dGluZyI7czo4OiJub19tb2RhbCI7czoxMzoidGRzX3Nob3dfdGFncyI7czowOiIiO3M6MTk6InRkc19zaG93X2F1dGhvcl9ib3giO3M6MDoiIjtzOjE4OiJ0ZHNfc2hvd19uZXh0X3ByZXYiO3M6MDoiIjtzOjIwOiJ0ZHNfc2ltaWxhcl9hcnRpY2xlcyI7czowOiIiO3M6MjU6InRkc19zaW1pbGFyX2FydGljbGVzX3R5cGUiO3M6NjoiYnlfdGFnIjtzOjI2OiJ0ZHNfc2ltaWxhcl9hcnRpY2xlc19jb3VudCI7czowOiIiO3M6MjA6InRkc19icmVhZGNydW1ic19zaG93IjtzOjA6IiI7czoyNToidGRzX2JyZWFkY3J1bWJzX3Nob3dfaG9tZSI7czowOiIiO3M6Mjc6InRkc19icmVhZGNydW1ic19zaG93X3BhcmVudCI7czowOiIiO3M6Mjg6InRkc19icmVhZGNydW1ic19zaG93X2FydGljbGUiO3M6NDoiaGlkZSI7czoxMzoidGRzX3NuYXBfbWVudSI7czoxNzoic21hcnRfc25hcF9hbHdheXMiO3M6MjI6InRkc19zdHJldGNoX2JhY2tncm91bmQiO3M6MDoiIjtzOjE2OiJ0ZHNfaGVhZGVyX3N0eWxlIjtzOjA6IiI7czoyMjoidGRzX21vZDJfdGl0bGVfZXhjZXJwdCI7czowOiIiO3M6MjI6InRkc19tb2QzX3RpdGxlX2V4Y2VycHQiO3M6MDoiIjtzOjIyOiJ0ZHNfbW9kNF90aXRsZV9leGNlcnB0IjtzOjA6IiI7czoyMjoidGRzX21vZDVfdGl0bGVfZXhjZXJwdCI7czoxOiI3IjtzOjIzOiJ0ZHNfbW9kX2NvbnRlbnRfZXhjZXJwdCI7aToyNTtzOjIyOiJ0ZHNfd3BfZGVmYXVsdF9leGNlcnB0IjtzOjI6IjIyIjtzOjE1OiJ0ZHNfdG9wX2FkX3Nwb3QiO3M6MTc6IkFkIHNwb3QgLS0gdG9wIGFkIjtzOjEzOiJ0ZHNfaW5saW5lX2FkIjtzOjQ6ImxlZnQiO3M6MjM6InRkc19pbmxpbmVfYWRfcGFyYWdyYXBoIjtzOjA6IiI7czoxODoidGRzX2lubGluZV9hZF9zcG90IjtzOjA6IiI7czoyMjoidGRzX2Zvb3Rlcl93aWRnZXRfY29scyI7czowOiIiO3M6MjA6InRkc19mb290ZXJfY29weXJpZ2h0IjtzOjM2OiJDb3B5cmlnaHQgMjAxNCAtIE5ld3NwYXBlciBieSB0YWdEaXYiO3M6MjI6InRkc19mb290ZXJfY29weV9zeW1ib2wiO3M6MDoiIjtzOjE3OiJ0ZHNfZm9vdGVyX2xpbmtfMSI7czowOiIiO3M6MTc6InRkc19mb290ZXJfbGlua18yIjtzOjA6IiI7czoxNzoidGRzX2Zvb3Rlcl9saW5rXzMiO3M6MDoiIjtzOjE3OiJ0ZHNfZm9vdGVyX2xpbmtfNCI7czowOiIiO3M6MTc6InRkc19mb290ZXJfbGlua181IjtzOjA6IiI7czoxNjoidGRzX2hvbWVfc2lkZWJhciI7czowOiIiO3M6MjA6InRkc19ob21lX3BhZ2VfbGF5b3V0IjtzOjE6IjgiO3M6MjA6InRkc19ob21lX3NpZGViYXJfcG9zIjtzOjA6IiI7czoyNDoidGRzX21vZDdfY29udGVudF9leGNlcnB0IjtzOjI6IjMwIjtzOjE0OiJ0ZHNfc2VwYXJhdG9yMSI7czowOiIiO3M6MTQ6InRkc19zZXBhcmF0b3IyIjtzOjA6IiI7czoxNDoidGRzX3NlcGFyYXRvcjMiO3M6MDoiIjtzOjE0OiJ0ZHNfc2VwYXJhdG9yNCI7czowOiIiO3M6MTQ6InRkc19zZXBhcmF0b3I1IjtzOjA6IiI7czoxNDoidGRzX3NlcGFyYXRvcjYiO3M6MDoiIjtzOjE0OiJ0ZHNfc2VwYXJhdG9yNyI7czowOiIiO3M6MjQ6InRkc19pbmxpbmVfYWRfcGFyYWdyYXBoMiI7aTozO3M6MTU6InRkc19zZXBhcmF0b3JhMSI7czowOiIiO3M6MTU6InRkc190b3BfYWRfY29kZSI7czoxMDE6IjxhIGhyZWY9IiMiPjxpbWcgc3JjPSJodHRwOi8vMGRpdi5jb206Njkvd3BfMDA4L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzA4L2Fkcy03MjguanBnIiBhbHQ9IiIgLz48L2E+IjtzOjE1OiJ0ZHNfc2VwYXJhdG9yYTIiO3M6MDoiIjtzOjIzOiJ0ZF90cmFuc2xhdGlvbl9tYXBfdXNlciI7YTo5NTp7czoxNjoiVmlldyBhbGwgcmVzdWx0cyI7czoxNjoiVmlldyBhbGwgcmVzdWx0cyI7czoxMDoiTm8gcmVzdWx0cyI7czoxMDoiTm8gcmVzdWx0cyI7czo0OiJIb21lIjtzOjQ6IkhvbWUiO3M6MTA6IkNhdGVnb3JpZXMiO3M6MTA6IkNhdGVnb3JpZXMiO3M6NToiQ0xPU0UiO3M6NToiQ0xPU0UiO3M6NDoiUGFnZSI7czo0OiJQYWdlIjtzOjM6IkFsbCI7czowOiIiO3M6MjoiYnkiO3M6MjoiYnkiO3M6OToiTG9hZCBtb3JlIjtzOjk6IkxvYWQgbW9yZSI7czoxNzoiVmlldyBhbGwgcG9zdHMgaW4iO3M6MTc6IlZpZXcgYWxsIHBvc3RzIGluIjtzOjE2OiJQcmV2aW91cyBhcnRpY2xlIjtzOjE2OiJQcmV2aW91cyBhcnRpY2xlIjtzOjEyOiJOZXh0IGFydGljbGUiO3M6MTI6Ik5leHQgYXJ0aWNsZSI7czo2OiJBdXRob3IiO3M6NjoiQXV0aG9yIjtzOjI1OiJNb3JlIGFydGljbGVzIGZyb20gYXV0aG9yIjtzOjI1OiJNb3JlIGFydGljbGVzIGZyb20gYXV0aG9yIjtzOjE2OiJTSU1JTEFSIEFSVElDTEVTIjtzOjE2OiJTSU1JTEFSIEFSVElDTEVTIjtzOjY6InNvdXJjZSI7czo2OiJzb3VyY2UiO3M6NjoiU09VUkNFIjtzOjA6IiI7czozOiJ2aWEiO3M6MzoidmlhIjtzOjM6IlZJQSI7czowOiIiO3M6ODoiQ29udGludWUiO3M6ODoiQ29udGludWUiO3M6NToiTmFtZToiO3M6NToiTmFtZToiO3M6NjoiRW1haWw6IjtzOjY6IkVtYWlsOiI7czo4OiJXZWJzaXRlOiI7czo4OiJXZWJzaXRlOiI7czo4OiJDb21tZW50OiI7czo4OiJDb21tZW50OiI7czoxMzoiTGVhdmUgYSBSZXBseSI7czoxMzoiTGVhdmUgYSBSZXBseSI7czoxMjoiUG9zdCBDb21tZW50IjtzOjEyOiJQb3N0IENvbW1lbnQiO3M6MTI6IkNhbmNlbCByZXBseSI7czoxMjoiQ2FuY2VsIHJlcGx5IjtzOjU6IlJlcGx5IjtzOjU6IlJlcGx5IjtzOjI1OiJMb2cgaW4gdG8gbGVhdmUgYSBjb21tZW50IjtzOjI1OiJMb2cgaW4gdG8gbGVhdmUgYSBjb21tZW50IjtzOjExOiJOTyBDT01NRU5UUyI7czoxMToiTk8gQ09NTUVOVFMiO3M6OToiMSBDT01NRU5UIjtzOjk6IjEgQ09NTUVOVCI7czo4OiJDT01NRU5UUyI7czo4OiJDT01NRU5UUyI7czoxNToiUmV2aWV3IG92ZXJ2aWV3IjtzOjE1OiJSZXZpZXcgb3ZlcnZpZXciO3M6NzoiU3VtbWFyeSI7czo3OiJTdW1tYXJ5IjtzOjI2OiI0MDQgRXJyb3IgLSBwYWdlIG5vdCBmb3VuZCI7czoxODoiT29vcHMuLi4gRXJyb3IgNDA0IjtzOjE2OiJPVVIgTEFURVNUIFBPU1RTIjtzOjA6IiI7czo2MDoiV2VfcmUgc29ycnksIGJ1dCB0aGUgcGFnZSB5b3UgYXJlIGxvb2tpbmcgZm9yIGRvZXNuX3QgZXhpc3QuIjtzOjA6IiI7czoxNzoiWW91IGNhbiBnbyB0byB0aGUiO3M6MTc6IllvdSBjYW4gZ28gdG8gdGhlIjtzOjg6ImhvbWVwYWdlIjtzOjg6ImhvbWVwYWdlIjtzOjc6IkF1dGhvcnMiO3M6MDoiIjtzOjk6IlBvc3RzIGJ5ICI7czo5OiJQb3N0cyBieSAiO3M6NToiUE9TVFMiO3M6NToiUE9TVFMiO3M6OToiUG9zdHMgaW4gIjtzOjk6IlBvc3RzIGluICI7czo0OiJUYWdzIjtzOjQ6IlRhZ3MiO3M6NDoiVEFHUyI7czowOiIiO3M6MTc6IlBvc3RzIHRhZ2dlZCB3aXRoIjtzOjE3OiJQb3N0cyB0YWdnZWQgd2l0aCI7czozOiJUYWciO3M6MDoiIjtzOjE2OiJEYWlseSBBcmNoaXZlczogIjtzOjE2OiJEYWlseSBBcmNoaXZlczogIjtzOjE4OiJNb250aGx5IEFyY2hpdmVzOiAiO3M6MTg6Ik1vbnRobHkgQXJjaGl2ZXM6ICI7czoxNzoiWWVhcmx5IEFyY2hpdmVzOiAiO3M6MTc6IlllYXJseSBBcmNoaXZlczogIjtzOjg6IkFyY2hpdmVzIjtzOjg6IkFyY2hpdmVzIjtzOjE1OiJMQVRFU1QgQVJUSUNMRVMiO3M6MTU6IkxBVEVTVCBBUlRJQ0xFUyI7czoxNDoic2VhcmNoIHJlc3VsdHMiO3M6MTQ6InNlYXJjaCByZXN1bHRzIjtzOjY6IlNlYXJjaCI7czo2OiJTZWFyY2giO3M6NjI6IklmIHlvdV9yZSBub3QgaGFwcHkgd2l0aCB0aGUgcmVzdWx0cywgcGxlYXNlIGRvIGFub3RoZXIgc2VhcmNoIjtzOjA6IiI7czoxMDoiQ29udGFjdCB1cyI7czoxMDoiQ29udGFjdCB1cyI7czo3OiJDb250YWN0IjtzOjA6IiI7czozNjoiUGFnZSAlQ1VSUkVOVF9QQUdFJSBvZiAlVE9UQUxfUEFHRVMlIjtzOjM2OiJQYWdlICVDVVJSRU5UX1BBR0UlIG9mICVUT1RBTF9QQUdFUyUiO3M6NDoiTmV4dCI7czo0OiJOZXh0IjtzOjQ6IlByZXYiO3M6NDoiUHJldiI7czoyNjoiTm8gcmVzdWx0cyBmb3IgeW91ciBzZWFyY2giO3M6MDoiIjtzOjE5OiJObyBwb3N0cyB0byBkaXNwbGF5IjtzOjA6IiI7czo2OiJMT0cgSU4iO3M6MDoiIjtzOjY6IkxvZyBJbiI7czowOiIiO3M6ODoiUkVHSVNURVIiO3M6MDoiIjtzOjg6IlJlZ2lzdGVyIjtzOjA6IiI7czoxMjoiU2VuZCBNeSBQYXNzIjtzOjA6IiI7czoyMToiRm9yZ290IHlvdXIgcGFzc3dvcmQ/IjtzOjA6IiI7czoxNDoiUGxlYXNlIHdhaXQuLi4iO3M6MDoiIjtzOjI3OiJVc2VyIG9yIHBhc3N3b3JkIGluY29ycmVjdCEiO3M6MDoiIjtzOjI4OiJFbWFpbCBvciB1c2VybmFtZSBpbmNvcnJlY3QhIjtzOjA6IiI7czoxNjoiRW1haWwgaW5jb3JyZWN0ISI7czowOiIiO3M6Mjk6IlVzZXIgb3IgZW1haWwgYWxyZWFkeSBleGlzdHMhIjtzOjA6IiI7czo3NToiUGxlYXNlIGNoZWNrIHlvdSBlbWFpbCAoaW5kZXggb3Igc3BhbSBmb2xkZXIpLCB0aGUgcGFzc3dvcmQgd2FzIHNlbnQgdGhlcmUuIjtzOjA6IiI7czoyNDoiRW1haWwgYWRkcmVzcyBub3QgZm91bmQhIjtzOjA6IiI7czo0MToiWW91ciBwYXNzd29yZCBpcyByZXNldCwgY2hlY2sgeW91ciBlbWFpbC4iO3M6MDoiIjtzOjMzOiJXZWxjb21lISBMb2dpbiBpbiB0byB5b3VyIGFjY291bnQiO3M6MDoiIjtzOjIzOiJSZWdpc3RlciBmb3IgYW4gYWNjb3VudCI7czowOiIiO3M6MjE6IlJlY292ZXIgeW91ciBwYXNzd29yZCI7czowOiIiO3M6MTM6InlvdXIgdXNlcm5hbWUiO3M6MDoiIjtzOjEzOiJ5b3VyIHBhc3N3b3JkIjtzOjA6IiI7czoxMDoieW91ciBlbWFpbCI7czowOiIiO3M6MzU6IkEgcGFzc3dvcmQgd2lsbCBiZSBlLW1haWxlZCB0byB5b3UuIjtzOjA6IiI7czo2OiJMb2dvdXQiO3M6MDoiIjtzOjE2OiJTZWFyY2ggdGhlIGZvcnVtIjtzOjA6IiI7czo2OiJGb3J1bXMiO3M6MDoiIjtzOjQ6Ikxpa2UiO3M6MDoiIjtzOjQ6IkZhbnMiO3M6MDoiIjtzOjY6IkZvbGxvdyI7czowOiIiO3M6OToiRm9sbG93ZXJzIjtzOjA6IiI7czo5OiJTdWJzY3JpYmUiO3M6MDoiIjtzOjExOiJTdWJzY3JpYmVycyI7czowOiIiO3M6MTI6Ik1PUkUgU1RPUklFUyI7czowOiIiO3M6ODoiVGltZWxpbmUiO3M6MDoiIjtzOjQ6IkJsb2ciO3M6MDoiIjt9czoxNToidGRzX3NlcGFyYXRvcjExIjtzOjA6IiI7czoyMDoidGRzX3BhZ2Vfc2lkZWJhcl9wb3MiO3M6MDoiIjtzOjE2OiJ0ZHNfcGFnZV9zaWRlYmFyIjtzOjA6IiI7czoxOToidGRzX2FyY2hpdmVfc2lkZWJhciI7czo4OiJBcmNoaXZlcyI7czoxODoidGRzX2F1dGhvcl9zaWRlYmFyIjtzOjc6IkF1dGhvcnMiO3M6MjA6InRkc19jYXRlZ29yeV9zaWRlYmFyIjtzOjA6IiI7czoxNToidGRzX3RhZ19zaWRlYmFyIjtzOjQ6IlRhZ3MiO3M6MTQ6InRkc190YWdfbGF5b3V0IjtzOjE6IjYiO3M6MjI6InRkc19zZWFyY2hfc2lkZWJhcl9wb3MiO3M6MDoiIjtzOjE4OiJ0ZHNfc2VhcmNoX3NpZGViYXIiO3M6MDoiIjtzOjIyOiJ0ZHNfc2VhcmNoX3BhZ2VfbGF5b3V0IjtzOjY6InNlYXJjaCI7czoxNToidGRzX3NlcGFyYXRvcjY2IjtzOjA6IiI7czoxMzoidGRzX21lbnVfZm9udCI7czoyOiIxMSI7czoxODoidGRzX21lbnVfZm9udF9zaXplIjtzOjA6IiI7czoyMDoidGRzX21lbnVfbGluZV9oZWlnaHQiO3M6MDoiIjtzOjE1OiJ0ZHNfc2VwYXJhdG9yNjciO3M6MDoiIjtzOjE2OiJ0ZHNfc2VjdGlvbl9mb250IjtzOjE6IjEiO3M6MjE6InRkc19zZWN0aW9uX2ZvbnRfc2l6ZSI7czowOiIiO3M6MjM6InRkc19zZWN0aW9uX2xpbmVfaGVpZ2h0IjtzOjA6IiI7czoxNToidGRzX3NlcGFyYXRvcjY4IjtzOjA6IiI7czoxMzoidGRzX2JvZHlfZm9udCI7czoxOiI2IjtzOjE4OiJ0ZHNfYm9keV9mb250X3NpemUiO3M6MDoiIjtzOjIwOiJ0ZHNfYm9keV9saW5lX2hlaWdodCI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3I2OSI7czowOiIiO3M6MTQ6InRkc19xdW90ZV9mb250IjtzOjA6IiI7czoxOToidGRzX3F1b3RlX2ZvbnRfc2l6ZSI7czowOiIiO3M6MjE6InRkc19xdW90ZV9saW5lX2hlaWdodCI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3IyMiI7czowOiIiO3M6MjY6InRkc19hdHRhY2htZW50X3NpZGViYXJfcG9zIjtzOjA6IiI7czoyMjoidGRzX2F0dGFjaG1lbnRfc2lkZWJhciI7czoxMDoiQXR0YWNobWVudCI7czoxNjoidGRzX3NlcGFyYXRvcjU2NiI7czowOiIiO3M6MTU6InRkc19zb2NpYWxfc2hvdyI7czowOiIiO3M6MTg6InRkc19zb2NpYWxfdHdpdHRlciI7czowOiIiO3M6MTg6InRkc19tZW51X2ZvbnRfZm9udCI7czoxOiIwIjtzOjIzOiJ0ZHNfbWVudV9mb250X2ZvbnRfc2l6ZSI7czowOiIiO3M6MjU6InRkc19tZW51X2ZvbnRfbGluZV9oZWlnaHQiO3M6MDoiIjtzOjE2OiJ0ZHNfY29udGVudF9mb250IjtzOjA6IiI7czoyMToidGRzX2NvbnRlbnRfZm9udF9zaXplIjtzOjA6IiI7czoyMzoidGRzX2NvbnRlbnRfbGluZV9oZWlnaHQiO3M6MDoiIjtzOjIzOiJ0ZHNfY29udGVudF9mb250X2ZhbWlseSI7czowOiIiO3M6MjA6InRkc19tZW51X2ZvbnRfZmFtaWx5IjtzOjA6IiI7czoxNjoidGRfYWRzZW5zZV9zcG90cyI7YTozOntzOjE1OiJhZHNlbnNlIHNpZGViYXIiO2E6MTQ6e3M6NDoibmFtZSI7czoxNToiYWRzZW5zZSBzaWRlYmFyIjtzOjY6InB1Yl9pZCI7czoyMDoicHViLTgxMjY1NDMyOTI3ODY5OTkiO3M6MToicCI7czoxMDoiMDg3NTkwOTk2OSI7czozOiJwX3ciO3M6MzoiMzAwIjtzOjM6InBfaCI7czozOiIyNTAiO3M6MjoidHAiO3M6MTA6IjMzODA5NDY0NjUiO3M6NDoidHBfdyI7czozOiIyMDAiO3M6NDoidHBfaCI7czozOiIyMDAiO3M6MjoidGwiO3M6MTA6IjU1Njk5NTgwNTQiO3M6NDoidGxfdyI7czozOiIyNTAiO3M6NDoidGxfaCI7czozOiIyNTAiO3M6MToibSI7czoxMDoiMDg3NTkwOTk2OSI7czozOiJtX3ciO3M6MzoiMzAwIjtzOjM6Im1faCI7czozOiIyNTAiO31zOjExOiJhZHNlbnNlIHRvcCI7YToxNDp7czo0OiJuYW1lIjtzOjExOiJhZHNlbnNlIHRvcCI7czo2OiJwdWJfaWQiO3M6MjA6InB1Yi0xMDc4MzE3MzE2ODE0Mzk4IjtzOjE6InAiO3M6MTA6IjMwOTM1NTE3MzgiO3M6MzoicF93IjtzOjM6IjMwMCI7czozOiJwX2giO3M6MzoiMjUwIjtzOjI6InRwIjtzOjEwOiIzMzk4Mzc3MDUxIjtzOjQ6InRwX3ciO3M6MzoiNDY4IjtzOjQ6InRwX2giO3M6MjoiNjAiO3M6MjoidGwiO3M6MTA6IjE5NjUyODk5NzciO3M6NDoidGxfdyI7czozOiI0NjgiO3M6NDoidGxfaCI7czoyOiI2MCI7czoxOiJtIjtzOjEwOiI1MjcwMzk1MzAzIjtzOjM6Im1fdyI7czozOiI3MjgiO3M6MzoibV9oIjtzOjI6IjkwIjt9czoxOToiYXN5bmNocm9ub3VzIGhlYWRlciI7YToxMjp7czo0OiJuYW1lIjtzOjE5OiJhc3luY2hyb25vdXMgaGVhZGVyIjtzOjY6InB1Yl9pZCI7czoyMDoicHViLTgxMjY1NDMyOTI3ODY5OTkiO3M6MzoicF93IjtzOjM6IjMwMCI7czozOiJwX2giO3M6MzoiMjUwIjtzOjQ6InRwX3ciO3M6MzoiNDY4IjtzOjQ6InRwX2giO3M6MjoiNjAiO3M6NDoidGxfdyI7czozOiI0NjgiO3M6NDoidGxfaCI7czoyOiI2MCI7czozOiJtX3ciO3M6MzoiNzI4IjtzOjM6Im1faCI7czoyOiI5MCI7czoxMjoiYWRfY29kZV90eXBlIjtzOjU6ImFzeW5jIjtzOjExOiJhc3luY19hZF9pZCI7czoxMDoiMzY3NDcyMjQ1OCI7fX1zOjE1OiJ0ZHNfdGhlbWVfY29sb3IiO3M6MDoiIjtzOjMwOiJ0ZHNfYmlnX3NsaWRlX21haW5fZm9udF9mYW1pbHkiO3M6MDoiIjtzOjI4OiJ0ZHNfYmlnX3NsaWRlX21haW5fZm9udF9zaXplIjtzOjA6IiI7czozMDoidGRzX2JpZ19zbGlkZV9tYWluX2xpbmVfaGVpZ2h0IjtzOjA6IiI7czoyOToidGRzX2JpZ19zbGlkZV9zZWNfZm9udF9mYW1pbHkiO3M6MDoiIjtzOjI3OiJ0ZHNfYmlnX3NsaWRlX3NlY19mb250X3NpemUiO3M6MDoiIjtzOjI5OiJ0ZHNfYmlnX3NsaWRlX3NlY19saW5lX2hlaWdodCI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3I3MCI7czowOiIiO3M6Mjg6InRkc193aWRnZXRfdGl0bGVfZm9udF9mYW1pbHkiO3M6MDoiIjtzOjI2OiJ0ZHNfd2lkZ2V0X3RpdGxlX2ZvbnRfc2l6ZSI7czowOiIiO3M6Mjg6InRkc193aWRnZXRfdGl0bGVfbGluZV9oZWlnaHQiO3M6MDoiIjtzOjE1OiJ0ZHNfc2VwYXJhdG9yNzEiO3M6MDoiIjtzOjM2OiJ0ZHNfd2lkZ2V0X2FydF9iaWdfdGl0bGVfZm9udF9mYW1pbHkiO3M6MDoiIjtzOjM0OiJ0ZHNfd2lkZ2V0X2FydF9iaWdfdGl0bGVfZm9udF9zaXplIjtzOjA6IiI7czozNjoidGRzX3dpZGdldF9hcnRfYmlnX3RpdGxlX2xpbmVfaGVpZ2h0IjtzOjA6IiI7czoxNToidGRzX3NlcGFyYXRvcjcyIjtzOjA6IiI7czozODoidGRzX3dpZGdldF9hcnRfc21hbGxfdGl0bGVfZm9udF9mYW1pbHkiO3M6MDoiIjtzOjM2OiJ0ZHNfd2lkZ2V0X2FydF9zbWFsbF90aXRsZV9mb250X3NpemUiO3M6MDoiIjtzOjM4OiJ0ZHNfd2lkZ2V0X2FydF9zbWFsbF90aXRsZV9saW5lX2hlaWdodCI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3I3MyI7czowOiIiO3M6MjY6InRkc19wb3N0X3RpdGxlX2ZvbnRfZmFtaWx5IjtzOjA6IiI7czoyNDoidGRzX3Bvc3RfdGl0bGVfZm9udF9zaXplIjtzOjA6IiI7czoyNjoidGRzX3Bvc3RfdGl0bGVfbGluZV9oZWlnaHQiO3M6MDoiIjtzOjEyOiJ0ZHNfbG9nb19hbHQiO3M6MDoiIjtzOjE0OiJ0ZHNfbG9nb190aXRsZSI7czowOiIiO3M6MTQ6InRkc19tZW51X2NvbG9yIjtzOjA6IiI7czoxMjoidGRfYW5hbHl0aWNzIjtzOjQzNToiPHNjcmlwdD4NCiAgKGZ1bmN0aW9uKGkscyxvLGcscixhLG0pe2lbXCdHb29nbGVBbmFseXRpY3NPYmplY3RcJ109cjtpW3JdPWlbcl18fGZ1bmN0aW9uKCl7DQogIChpW3JdLnE9aVtyXS5xfHxbXSkucHVzaChhcmd1bWVudHMpfSxpW3JdLmw9MSpuZXcgRGF0ZSgpO2E9cy5jcmVhdGVFbGVtZW50KG8pLA0KICBtPXMuZ2V0RWxlbWVudHNCeVRhZ05hbWUobylbMF07YS5hc3luYz0xO2Euc3JjPWc7bS5wYXJlbnROb2RlLmluc2VydEJlZm9yZShhLG0pDQogIH0pKHdpbmRvdyxkb2N1bWVudCxcJ3NjcmlwdFwnLFwnLy93d3cuZ29vZ2xlLWFuYWx5dGljcy5jb20vYW5hbHl0aWNzLmpzXCcsXCdnYVwnKTsNCg0KICBnYShcJ2NyZWF0ZVwnLCBcJ1VBLTQzOTYzNDk0LTFcJywgXCdhdXRvXCcpOw0KICBnYShcJ3NlbmRcJywgXCdwYWdldmlld1wnKTsNCg0KPC9zY3JpcHQ+IjtzOjE1OiJ0ZHNfc2VwYXJhdG9yNjEiO3M6MDoiIjtzOjE5OiJ0ZHNfd29vX3NpZGViYXJfcG9zIjtzOjA6IiI7czoxNToidGRzX3dvb19zaWRlYmFyIjtzOjE5OiJXb29jb21tZXJjZSBzaWRlYmFyIjtzOjIzOiJ0ZHNfY3JvcF9mZWF0dXJlc19pbWFnZSI7czowOiIiO3M6MTU6InRkc19wX3Nob3dfZGF0ZSI7czowOiIiO3M6MTY6InRkc19wX3Nob3dfdmlld3MiO3M6MDoiIjtzOjE5OiJ0ZHNfcF9zaG93X2NvbW1lbnRzIjtzOjA6IiI7czoxMjoidGRzX3RvcF9tZW51IjtzOjA6IiI7czoyNDoidGRzX3RvcF9tZW51X2ZvbnRfZmFtaWx5IjtzOjA6IiI7czoyMjoidGRzX3RvcF9tZW51X2ZvbnRfc2l6ZSI7czowOiIiO3M6MjQ6InRkc190b3BfbWVudV9saW5lX2hlaWdodCI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3I3NCI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3I3NSI7czowOiIiO3M6MjY6InRkc190YWJzX3RpdGxlX2ZvbnRfZmFtaWx5IjtzOjA6IiI7czoyNDoidGRzX3RhYnNfdGl0bGVfZm9udF9zaXplIjtzOjA6IiI7czoyNjoidGRzX3RhYnNfdGl0bGVfbGluZV9oZWlnaHQiO3M6MDoiIjtzOjE3OiJ0ZHNfZGF0YV90b3BfbWVudSI7czowOiIiO3M6MjA6InRkc19kYXRhX3RpbWVfZm9ybWF0IjtzOjk6ImwsIEYgaiwgWSI7czoxNToidGRzX3NlcGFyYXRvcmUyIjtzOjA6IiI7czoyNDoidGRzX21vZDJfY29udGVudF9leGNlcnB0IjtzOjA6IiI7czoxNToidGRzX3NlcGFyYXRvcmUzIjtzOjA6IiI7czoxNToidGRzX3NlcGFyYXRvcmU0IjtzOjA6IiI7czoxNToidGRzX3NlcGFyYXRvcmU1IjtzOjA6IiI7czoyNDoidGRzX21vZDVfY29udGVudF9leGNlcnB0IjtzOjA6IiI7czoxNToidGRzX3NlcGFyYXRvcmU2IjtzOjA6IiI7czoyMjoidGRzX21vZDZfdGl0bGVfZXhjZXJwdCI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3JlNyI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3JlOCI7czowOiIiO3M6MjI6InRkc19tb2Q4X3RpdGxlX2V4Y2VycHQiO3M6MDoiIjtzOjI0OiJ0ZHNfbW9kOF9jb250ZW50X2V4Y2VycHQiO3M6MDoiIjtzOjE1OiJ0ZHNfc2VwYXJhdG9yZTkiO3M6MDoiIjtzOjIyOiJ0ZHNfbW9kOV90aXRsZV9leGNlcnB0IjtzOjA6IiI7czoyNDoidGRzX21vZDlfY29udGVudF9leGNlcnB0IjtzOjI6IjMwIjtzOjE2OiJ0ZHNfc2VwYXJhdG9yZTEwIjtzOjA6IiI7czoyODoidGRzX21vZF9zZWFyY2hfdGl0bGVfZXhjZXJwdCI7czowOiIiO3M6MzA6InRkc19tb2Rfc2VhcmNoX2NvbnRlbnRfZXhjZXJwdCI7czowOiIiO3M6MTY6InRkc19zZXBhcmF0b3JlMTEiO3M6MDoiIjtzOjI1OiJ0ZHNfcF9lbmFibGVfN19kYXlzX2NvdW50IjtzOjA6IiI7czoxNjoidGRzX3NlcGFyYXRvcjcxMSI7czowOiIiO3M6MjA6InRkc19zbWFsbF90ZXh0X3NsaWRlIjtzOjA6IiI7czoyMToidGRzX2hlYWRlcl93cmFwX2NvbG9yIjtzOjA6IiI7czoxODoidGRzX3RvcF9tZW51X2NvbG9yIjtzOjA6IiI7czoxOToidGRzX2xvZ29fdGV4dF9jb2xvciI7czowOiIiO3M6MjA6InRkc19oZWFkZXJfYWxpZ25fdG9wIjtzOjA6IiI7czoyODoidGRzX25vcm1hbF9zbGlkZV9mb250X2ZhbWlseSI7czowOiIiO3M6MjY6InRkc19ub3JtYWxfc2xpZGVfZm9udF9zaXplIjtzOjA6IiI7czoyODoidGRzX25vcm1hbF9zbGlkZV9saW5lX2hlaWdodCI7czowOiIiO3M6MTU6InRkc19zZXBhcmF0b3I3NiI7czowOiIiO3M6MTc6InRkc19leGNlcnB0c190eXBlIjtzOjA6IiI7czoyMzoidGRzX2JicHJlc3Nfc2lkZWJhcl9wb3MiO3M6MDoiIjtzOjE5OiJ0ZHNfYmJwcmVzc19zaWRlYmFyIjtzOjA6IiI7czoxOToidGRzX21lbnVfdGV4dF9jb2xvciI7czowOiIiO3M6MTY6InRkc19mb290ZXJfY29sb3IiO3M6MDoiIjtzOjIzOiJ0ZHNfZm9vdGVyX2JvdHRvbV9jb2xvciI7czowOiIiO3M6MzI6InRkc19oZWFkZXJfbWVudV9sb2dvX3Bvc2l0aW9uaW5nIjtzOjA6IiI7czoyNToidGRzX2lubGluZV9hZF9zaG93X2F0X2VuZCI7czowOiIiO3M6MTY6InRkc19tb2JpbGVfc3dpcGUiO3M6MDoiIjtzOjE1OiJ0ZHNfaW9zX2ljb25fNzYiO3M6Nzc6Imh0dHA6Ly8wZGl2LmNvbTo2OS9uZXdzcGFwZXJfZGVtby93cC1jb250ZW50L3VwbG9hZHMvMjAxNC8wMS9uZXdzcGFwZXItNzYucG5nIjtzOjE2OiJ0ZHNfaW9zX2ljb25fMTIwIjtzOjc4OiJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDEvbmV3c3BhcGVyLTEyMC5wbmciO3M6MTY6InRkc19pb3NfaWNvbl8xNTIiO3M6Nzg6Imh0dHA6Ly8wZGl2LmNvbTo2OS9uZXdzcGFwZXJfZGVtby93cC1jb250ZW50L3VwbG9hZHMvMjAxNC8wMS9uZXdzcGFwZXItMTUyLnBuZyI7czoxNjoidGRzX2lvc19pY29uXzExNCI7czo3ODoiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzAxL25ld3NwYXBlci0xMTQucG5nIjtzOjE2OiJ0ZHNfaW9zX2ljb25fMTQ0IjtzOjc4OiJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDEvbmV3c3BhcGVyLTE0NC5wbmciO3M6MzA6InRkc19mZWF0dXJlZF9pbWFnZV9wbGFjZWhvbGRlciI7czowOiIiO3M6MjM6InRkc190b3BfbWVudV90ZXh0X2NvbG9yIjtzOjA6IiI7czoyMToidGRzX2Zvb3Rlcl90ZXh0X2NvbG9yIjtzOjA6IiI7czoyODoidGRzX2Zvb3Rlcl9ib3R0b21fdGV4dF9jb2xvciI7czowOiIiO3M6MTQ6InRkc19jdXN0b21fY3NzIjtzOjcxNjk6ImJvZHkgLmJsb2NrLXRpdGxlIHsNCmxpbmUtaGVpZ2h0OiAzMHB4Ow0KfQ0KDQpwLmRlbW9fc3RvcmV7YmFja2dyb3VuZC1jb2xvcjojNGZiMmVjO2NvbG9yOiMwYjIzMzE7fS53b29jb21tZXJjZSBzbWFsbC5ub3Rle2NvbG9yOiM3Nzc7fS53b29jb21tZXJjZSAud29vY29tbWVyY2UtYnJlYWRjcnVtYntjb2xvcjojNzc3O30ud29vY29tbWVyY2UgLndvb2NvbW1lcmNlLWJyZWFkY3J1bWIgYXtjb2xvcjojNzc3O30ud29vY29tbWVyY2UgZGl2LnByb2R1Y3Qgc3Bhbi5wcmljZSwud29vY29tbWVyY2UgZGl2LnByb2R1Y3QgcC5wcmljZXtjb2xvcjojNGZiMmVjO30ud29vY29tbWVyY2UgZGl2LnByb2R1Y3QgLnN0b2Nre2NvbG9yOiM0ZmIyZWM7fS53b29jb21tZXJjZSBkaXYucHJvZHVjdCAud29vY29tbWVyY2UtdGFicyB1bC50YWJzIGxpe2JvcmRlcjoxcHggc29saWQgI2RmZGJkZjtiYWNrZ3JvdW5kLWNvbG9yOiNmN2Y2Zjc7fS53b29jb21tZXJjZSBkaXYucHJvZHVjdCAud29vY29tbWVyY2UtdGFicyB1bC50YWJzIGxpIGF7Y29sb3I6IzVlNWU1ZTt9Lndvb2NvbW1lcmNlIGRpdi5wcm9kdWN0IC53b29jb21tZXJjZS10YWJzIHVsLnRhYnMgbGkgYTpob3Zlcntjb2xvcjojNzc3O30ud29vY29tbWVyY2UgZGl2LnByb2R1Y3QgLndvb2NvbW1lcmNlLXRhYnMgdWwudGFicyBsaS5hY3RpdmV7YmFja2dyb3VuZDojZmZmO2JvcmRlci1ib3R0b20tY29sb3I6I2ZmZjt9Lndvb2NvbW1lcmNlIGRpdi5wcm9kdWN0IC53b29jb21tZXJjZS10YWJzIHVsLnRhYnMgbGkuYWN0aXZlOmJlZm9yZXtib3gtc2hhZG93OjJweCAycHggMCAjZmZmO30ud29vY29tbWVyY2UgZGl2LnByb2R1Y3QgLndvb2NvbW1lcmNlLXRhYnMgdWwudGFicyBsaS5hY3RpdmU6YWZ0ZXJ7Ym94LXNoYWRvdzotMnB4IDJweCAwICNmZmY7fS53b29jb21tZXJjZSBkaXYucHJvZHVjdCAud29vY29tbWVyY2UtdGFicyB1bC50YWJzIGxpOmJlZm9yZSwud29vY29tbWVyY2UgZGl2LnByb2R1Y3QgLndvb2NvbW1lcmNlLXRhYnMgdWwudGFicyBsaTphZnRlcntib3JkZXI6MXB4IHNvbGlkICNkZmRiZGY7cG9zaXRpb246YWJzb2x1dGU7Ym90dG9tOi0xcHg7d2lkdGg6NXB4O2hlaWdodDo1cHg7Y29udGVudDpcIiBcIjt9Lndvb2NvbW1lcmNlIGRpdi5wcm9kdWN0IC53b29jb21tZXJjZS10YWJzIHVsLnRhYnMgbGk6YmVmb3Jle2xlZnQ6LTZweDstd2Via2l0LWJvcmRlci1ib3R0b20tcmlnaHQtcmFkaXVzOjRweDstbW96LWJvcmRlci1ib3R0b20tcmlnaHQtcmFkaXVzOjRweDtib3JkZXItYm90dG9tLXJpZ2h0LXJhZGl1czo0cHg7Ym9yZGVyLXdpZHRoOjAgMXB4IDFweCAwO2JveC1zaGFkb3c6MnB4IDJweCAwICNmN2Y2Zjc7fS53b29jb21tZXJjZSBkaXYucHJvZHVjdCAud29vY29tbWVyY2UtdGFicyB1bC50YWJzIGxpOmFmdGVye3JpZ2h0Oi02cHg7LXdlYmtpdC1ib3JkZXItYm90dG9tLWxlZnQtcmFkaXVzOjRweDstbW96LWJvcmRlci1ib3R0b20tbGVmdC1yYWRpdXM6NHB4O2JvcmRlci1ib3R0b20tbGVmdC1yYWRpdXM6NHB4O2JvcmRlci13aWR0aDowIDAgMXB4IDFweDtib3gtc2hhZG93Oi0ycHggMnB4IDAgI2Y3ZjZmNzt9Lndvb2NvbW1lcmNlIGRpdi5wcm9kdWN0IC53b29jb21tZXJjZS10YWJzIHVsLnRhYnM6YmVmb3Jle2JvcmRlci1ib3R0b206MXB4IHNvbGlkICNkZmRiZGY7fS53b29jb21tZXJjZSBzcGFuLm9uc2FsZXtiYWNrZ3JvdW5kLWNvbG9yOiM0ZmIyZWM7Y29sb3I6IzAyMDUwNzt9Lndvb2NvbW1lcmNlIHVsLnByb2R1Y3RzIGxpLnByb2R1Y3QgLnByaWNle2NvbG9yOiM0ZmIyZWM7fS53b29jb21tZXJjZSB1bC5wcm9kdWN0cyBsaS5wcm9kdWN0IC5wcmljZSAuZnJvbXtjb2xvcjpyZ2JhKDE1MiwxNTksMTYzLDAuNSk7fS53b29jb21tZXJjZSBuYXYud29vY29tbWVyY2UtcGFnaW5hdGlvbiB1bHtib3JkZXI6MXB4IHNvbGlkICNkZmRiZGY7fS53b29jb21tZXJjZSBuYXYud29vY29tbWVyY2UtcGFnaW5hdGlvbiB1bCBsaXtib3JkZXItcmlnaHQ6MXB4IHNvbGlkICNkZmRiZGY7fS53b29jb21tZXJjZSBuYXYud29vY29tbWVyY2UtcGFnaW5hdGlvbiB1bCBsaSBzcGFuLmN1cnJlbnQsLndvb2NvbW1lcmNlIG5hdi53b29jb21tZXJjZS1wYWdpbmF0aW9uIHVsIGxpIGE6aG92ZXIsLndvb2NvbW1lcmNlIG5hdi53b29jb21tZXJjZS1wYWdpbmF0aW9uIHVsIGxpIGE6Zm9jdXN7YmFja2dyb3VuZDojZjdmNmY3O2NvbG9yOiM5NzhhOTc7fS53b29jb21tZXJjZSBhLmJ1dHRvbiwud29vY29tbWVyY2UgYnV0dG9uLmJ1dHRvbiwud29vY29tbWVyY2UgaW5wdXQuYnV0dG9uLC53b29jb21tZXJjZSAjcmVzcG9uZCBpbnB1dCNzdWJtaXR7Y29sb3I6IzVlNWU1ZTtiYWNrZ3JvdW5kLWNvbG9yOiNmN2Y2Zjc7fS53b29jb21tZXJjZSBhLmJ1dHRvbjpob3Zlciwud29vY29tbWVyY2UgYnV0dG9uLmJ1dHRvbjpob3Zlciwud29vY29tbWVyY2UgaW5wdXQuYnV0dG9uOmhvdmVyLC53b29jb21tZXJjZSAjcmVzcG9uZCBpbnB1dCNzdWJtaXQ6aG92ZXJ7YmFja2dyb3VuZC1jb2xvcjojZTZlNWU2O2NvbG9yOiM1ZTVlNWU7fS53b29jb21tZXJjZSBhLmJ1dHRvbi5hbHQsLndvb2NvbW1lcmNlIGJ1dHRvbi5idXR0b24uYWx0LC53b29jb21tZXJjZSBpbnB1dC5idXR0b24uYWx0LC53b29jb21tZXJjZSAjcmVzcG9uZCBpbnB1dCNzdWJtaXQuYWx0e2JhY2tncm91bmQtY29sb3I6IzRmYjJlYztjb2xvcjojMGIyMzMxO30ud29vY29tbWVyY2UgYS5idXR0b24uYWx0OmhvdmVyLC53b29jb21tZXJjZSBidXR0b24uYnV0dG9uLmFsdDpob3Zlciwud29vY29tbWVyY2UgaW5wdXQuYnV0dG9uLmFsdDpob3Zlciwud29vY29tbWVyY2UgI3Jlc3BvbmQgaW5wdXQjc3VibWl0LmFsdDpob3ZlcntiYWNrZ3JvdW5kLWNvbG9yOiMzZWExZGI7Y29sb3I6IzBiMjMzMTt9Lndvb2NvbW1lcmNlIGEuYnV0dG9uLmFsdC5kaXNhYmxlZCwud29vY29tbWVyY2UgYnV0dG9uLmJ1dHRvbi5hbHQuZGlzYWJsZWQsLndvb2NvbW1lcmNlIGlucHV0LmJ1dHRvbi5hbHQuZGlzYWJsZWQsLndvb2NvbW1lcmNlICNyZXNwb25kIGlucHV0I3N1Ym1pdC5hbHQuZGlzYWJsZWQsLndvb2NvbW1lcmNlIGEuYnV0dG9uLmFsdDpkaXNhYmxlZCwud29vY29tbWVyY2UgYnV0dG9uLmJ1dHRvbi5hbHQ6ZGlzYWJsZWQsLndvb2NvbW1lcmNlIGlucHV0LmJ1dHRvbi5hbHQ6ZGlzYWJsZWQsLndvb2NvbW1lcmNlICNyZXNwb25kIGlucHV0I3N1Ym1pdC5hbHQ6ZGlzYWJsZWQsLndvb2NvbW1lcmNlIGEuYnV0dG9uLmFsdDpkaXNhYmxlZFtkaXNhYmxlZF0sLndvb2NvbW1lcmNlIGJ1dHRvbi5idXR0b24uYWx0OmRpc2FibGVkW2Rpc2FibGVkXSwud29vY29tbWVyY2UgaW5wdXQuYnV0dG9uLmFsdDpkaXNhYmxlZFtkaXNhYmxlZF0sLndvb2NvbW1lcmNlICNyZXNwb25kIGlucHV0I3N1Ym1pdC5hbHQ6ZGlzYWJsZWRbZGlzYWJsZWRdLC53b29jb21tZXJjZSBhLmJ1dHRvbi5hbHQuZGlzYWJsZWQ6aG92ZXIsLndvb2NvbW1lcmNlIGJ1dHRvbi5idXR0b24uYWx0LmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSBpbnB1dC5idXR0b24uYWx0LmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSAjcmVzcG9uZCBpbnB1dCNzdWJtaXQuYWx0LmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSBhLmJ1dHRvbi5hbHQ6ZGlzYWJsZWQ6aG92ZXIsLndvb2NvbW1lcmNlIGJ1dHRvbi5idXR0b24uYWx0OmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSBpbnB1dC5idXR0b24uYWx0OmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSAjcmVzcG9uZCBpbnB1dCNzdWJtaXQuYWx0OmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSBhLmJ1dHRvbi5hbHQ6ZGlzYWJsZWRbZGlzYWJsZWRdOmhvdmVyLC53b29jb21tZXJjZSBidXR0b24uYnV0dG9uLmFsdDpkaXNhYmxlZFtkaXNhYmxlZF06aG92ZXIsLndvb2NvbW1lcmNlIGlucHV0LmJ1dHRvbi5hbHQ6ZGlzYWJsZWRbZGlzYWJsZWRdOmhvdmVyLC53b29jb21tZXJjZSAjcmVzcG9uZCBpbnB1dCNzdWJtaXQuYWx0OmRpc2FibGVkW2Rpc2FibGVkXTpob3ZlcntiYWNrZ3JvdW5kLWNvbG9yOiM0ZmIyZWM7Y29sb3I6IzBiMjMzMTt9Lndvb2NvbW1lcmNlIGEuYnV0dG9uOmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSBidXR0b24uYnV0dG9uOmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSBpbnB1dC5idXR0b246ZGlzYWJsZWQ6aG92ZXIsLndvb2NvbW1lcmNlICNyZXNwb25kIGlucHV0I3N1Ym1pdDpkaXNhYmxlZDpob3Zlciwud29vY29tbWVyY2UgYS5idXR0b24uZGlzYWJsZWQ6aG92ZXIsLndvb2NvbW1lcmNlIGJ1dHRvbi5idXR0b24uZGlzYWJsZWQ6aG92ZXIsLndvb2NvbW1lcmNlIGlucHV0LmJ1dHRvbi5kaXNhYmxlZDpob3Zlciwud29vY29tbWVyY2UgI3Jlc3BvbmQgaW5wdXQjc3VibWl0LmRpc2FibGVkOmhvdmVyLC53b29jb21tZXJjZSBhLmJ1dHRvbjpkaXNhYmxlZFtkaXNhYmxlZF06aG92ZXIsLndvb2NvbW1lcmNlIGJ1dHRvbi5idXR0b246ZGlzYWJsZWRbZGlzYWJsZWRdOmhvdmVyLC53b29jb21tZXJjZSBpbnB1dC5idXR0b246ZGlzYWJsZWRbZGlzYWJsZWRdOmhvdmVyLC53b29jb21tZXJjZSAjcmVzcG9uZCBpbnB1dCNzdWJtaXQ6ZGlzYWJsZWRbZGlzYWJsZWRdOmhvdmVye2JhY2tncm91bmQtY29sb3I6I2Y3ZjZmNzt9Lndvb2NvbW1lcmNlICNyZXZpZXdzIGgyIHNtYWxse2NvbG9yOiM3Nzc7fS53b29jb21tZXJjZSAjcmV2aWV3cyBoMiBzbWFsbCBhe2NvbG9yOiM3Nzc7fS53b29jb21tZXJjZSAjcmV2aWV3cyAjY29tbWVudHMgb2wuY29tbWVudGxpc3QgbGkgLm1ldGF7Y29sb3I6Izc3Nzt9Lndvb2NvbW1lcmNlICNyZXZpZXdzICNjb21tZW50cyBvbC5jb21tZW50bGlzdCBsaSBpbWcuYXZhdGFye2JhY2tncm91bmQ6I2Y3ZjZmNztib3JkZXI6MXB4IHNvbGlkICNmMGVlZjA7fS53b29jb21tZXJjZSAjcmV2aWV3cyAjY29tbWVudHMgb2wuY29tbWVudGxpc3QgbGkgLmNvbW1lbnQtdGV4dHtib3JkZXI6MXB4IHNvbGlkICNmMGVlZjA7fS53b29jb21tZXJjZSAjcmV2aWV3cyAjY29tbWVudHMgb2wuY29tbWVudGxpc3QgI3Jlc3BvbmR7Ym9yZGVyOjFweCBzb2xpZCAjZjBlZWYwO30ud29vY29tbWVyY2UgLnN0YXItcmF0aW5nOmJlZm9yZXtjb2xvcjojZGZkYmRmO30ud29vY29tbWVyY2Uud2lkZ2V0X3Nob3BwaW5nX2NhcnQgLnRvdGFsLC53b29jb21tZXJjZSAud2lkZ2V0X3Nob3BwaW5nX2NhcnQgLnRvdGFse2JvcmRlci10b3A6M3B4IGRvdWJsZSAjZjdmNmY3O30ud29vY29tbWVyY2UgZm9ybS5sb2dpbiwud29vY29tbWVyY2UgZm9ybS5jaGVja291dF9jb3Vwb24sLndvb2NvbW1lcmNlIGZvcm0ucmVnaXN0ZXJ7Ym9yZGVyOjFweCBzb2xpZCAjZGZkYmRmO30ud29vY29tbWVyY2UgLm9yZGVyX2RldGFpbHMgbGl7Ym9yZGVyLXJpZ2h0OjFweCBkYXNoZWQgI2RmZGJkZjt9Lndvb2NvbW1lcmNlIC53aWRnZXRfcHJpY2VfZmlsdGVyIC51aS1zbGlkZXIgLnVpLXNsaWRlci1oYW5kbGV7YmFja2dyb3VuZC1jb2xvcjojNGZiMmVjO30ud29vY29tbWVyY2UgLndpZGdldF9wcmljZV9maWx0ZXIgLnVpLXNsaWRlciAudWktc2xpZGVyLXJhbmdle2JhY2tncm91bmQtY29sb3I6IzRmYjJlYzt9Lndvb2NvbW1lcmNlIC53aWRnZXRfcHJpY2VfZmlsdGVyIC5wcmljZV9zbGlkZXJfd3JhcHBlciAudWktd2lkZ2V0LWNvbnRlbnR7YmFja2dyb3VuZC1jb2xvcjojMGI2ZWE4O30ud29vY29tbWVyY2UtY2FydCB0YWJsZS5jYXJ0IHRkLmFjdGlvbnMgLmNvdXBvbiAuaW5wdXQtdGV4dHtib3JkZXI6MXB4IHNvbGlkICNkZmRiZGY7fS53b29jb21tZXJjZS1jYXJ0IC5jYXJ0LWNvbGxhdGVyYWxzIC5jYXJ0X3RvdGFscyBwIHNtYWxse2NvbG9yOiM3Nzc7fS53b29jb21tZXJjZS1jYXJ0IC5jYXJ0LWNvbGxhdGVyYWxzIC5jYXJ0X3RvdGFscyB0YWJsZSBzbWFsbHtjb2xvcjojNzc3O30ud29vY29tbWVyY2UtY2FydCAuY2FydC1jb2xsYXRlcmFscyAuY2FydF90b3RhbHMgLmRpc2NvdW50IHRke2NvbG9yOiM0ZmIyZWM7fS53b29jb21tZXJjZS1jYXJ0IC5jYXJ0LWNvbGxhdGVyYWxzIC5jYXJ0X3RvdGFscyB0ciB0ZCwud29vY29tbWVyY2UtY2FydCAuY2FydC1jb2xsYXRlcmFscyAuY2FydF90b3RhbHMgdHIgdGh7Ym9yZGVyLXRvcDoxcHggc29saWQgI2Y3ZjZmNzt9Lndvb2NvbW1lcmNlLWNoZWNrb3V0IC5jaGVja291dCAuY3JlYXRlLWFjY291bnQgc21hbGx7Y29sb3I6Izc3Nzt9Lndvb2NvbW1lcmNlLWNoZWNrb3V0ICNwYXltZW50e2JhY2tncm91bmQ6I2Y3ZjZmNzt9Lndvb2NvbW1lcmNlLWNoZWNrb3V0ICNwYXltZW50IHVsLnBheW1lbnRfbWV0aG9kc3tib3JkZXItYm90dG9tOjFweCBzb2xpZCAjZGZkYmRmO30ud29vY29tbWVyY2UtY2hlY2tvdXQgI3BheW1lbnQgZGl2LnBheW1lbnRfYm94e2JhY2tncm91bmQtY29sb3I6I2ViZTllYjtjb2xvcjojNWU1ZTVlO30ud29vY29tbWVyY2UtY2hlY2tvdXQgI3BheW1lbnQgZGl2LnBheW1lbnRfYm94IGlucHV0LmlucHV0LXRleHQsLndvb2NvbW1lcmNlLWNoZWNrb3V0ICNwYXltZW50IGRpdi5wYXltZW50X2JveCB0ZXh0YXJlYXtib3JkZXItY29sb3I6I2QzY2VkMztib3JkZXItdG9wLWNvbG9yOiNjN2MwYzc7fS53b29jb21tZXJjZS1jaGVja291dCAjcGF5bWVudCBkaXYucGF5bWVudF9ib3ggOjotd2Via2l0LWlucHV0LXBsYWNlaG9sZGVye2NvbG9yOiNjN2MwYzc7fS53b29jb21tZXJjZS1jaGVja291dCAjcGF5bWVudCBkaXYucGF5bWVudF9ib3ggOi1tb3otcGxhY2Vob2xkZXJ7Y29sb3I6I2M3YzBjNzt9Lndvb2NvbW1lcmNlLWNoZWNrb3V0ICNwYXltZW50IGRpdi5wYXltZW50X2JveCA6LW1zLWlucHV0LXBsYWNlaG9sZGVye2NvbG9yOiNjN2MwYzc7fS53b29jb21tZXJjZS1jaGVja291dCAjcGF5bWVudCBkaXYucGF5bWVudF9ib3ggc3Bhbi5oZWxwe2NvbG9yOiM3Nzc7fS53b29jb21tZXJjZS1jaGVja291dCAjcGF5bWVudCBkaXYucGF5bWVudF9ib3g6YWZ0ZXJ7Y29udGVudDpcIlwiO2Rpc3BsYXk6YmxvY2s7Ym9yZGVyOjhweCBzb2xpZCAjZWJlOWViO2JvcmRlci1yaWdodC1jb2xvcjp0cmFuc3BhcmVudDtib3JkZXItbGVmdC1jb2xvcjp0cmFuc3BhcmVudDtib3JkZXItdG9wLWNvbG9yOnRyYW5zcGFyZW50O3Bvc2l0aW9uOmFic29sdXRlO3RvcDotM3B4O2xlZnQ6MDttYXJnaW46LTFlbSAwIDAgMmVtO30NCg0KIjtzOjI2OiJ0ZHNfcmVzcG9uc2l2ZV9jc3NfZGVza3RvcCI7czowOiIiO3M6MzM6InRkc19yZXNwb25zaXZlX2Nzc19pcGFkX2xhbmRzY2FwZSI7czowOiIiO3M6MzI6InRkc19yZXNwb25zaXZlX2Nzc19pcGFkX3BvcnRyYWl0IjtzOjA6IiI7czoyNDoidGRzX3Jlc3BvbnNpdmVfY3NzX3Bob25lIjtzOjA6IiI7czo2OiJ0ZF9hZHMiO2E6Mzp7czo2OiJoZWFkZXIiO2E6MTA6e3M6NzoiYWRfY29kZSI7czo2MDk6IjxkaXYgY2xhc3M9XCJ0ZC12aXNpYmxlLWRlc2t0b3BcIj4NCjxhIGhyZWY9XCIjXCI+PGltZyBzcmM9XCJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDcvcmVjNzI4LmpwZ1wiIC8+PC9hPg0KPC9kaXY+DQoNCjxkaXYgY2xhc3M9XCJ0ZC12aXNpYmxlLXRhYmxldC1sXCI+DQo8YSBocmVmPVwiI1wiPjxpbWcgc3JjPVwiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzA3L3JlYzQ2OC5qcGdcIiAvPjwvYT4NCjwvZGl2Pg0KDQo8ZGl2IGNsYXNzPVwidGQtdmlzaWJsZS10YWJsZXQtdHBcIj4NCjxhIGhyZWY9XCIjXCI+PGltZyBzcmM9XCJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDcvcmVjNDY4LmpwZ1wiIC8+PC9hPg0KPC9kaXY+DQoNCjxkaXYgY2xhc3M9XCJ0ZC12aXNpYmxlLXBob25lXCI+DQo8YSBocmVmPVwiI1wiPjxpbWcgc3JjPVwiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzA3L3JlYzMyMC5qcGdcIiAvPjwvYT4NCjwvZGl2PiI7czo5OiJkaXNhYmxlX20iO3M6MDoiIjtzOjY6Im1fc2l6ZSI7czowOiIiO3M6MTA6ImRpc2FibGVfdGwiO3M6MDoiIjtzOjc6InRsX3NpemUiO3M6MDoiIjtzOjEwOiJkaXNhYmxlX3RwIjtzOjA6IiI7czo3OiJ0cF9zaXplIjtzOjA6IiI7czo5OiJkaXNhYmxlX3AiO3M6MzoieWVzIjtzOjY6InBfc2l6ZSI7czowOiIiO3M6MTU6ImN1cnJlbnRfYWRfdHlwZSI7czo1OiJvdGhlciI7fXM6Nzoic2lkZWJhciI7YToxMDp7czo3OiJhZF9jb2RlIjtzOjYwOToiPGRpdiBjbGFzcz1cInRkLXZpc2libGUtZGVza3RvcFwiPg0KPGEgaHJlZj1cIiNcIj48aW1nIHNyYz1cImh0dHA6Ly8wZGl2LmNvbTo2OS9uZXdzcGFwZXJfZGVtby93cC1jb250ZW50L3VwbG9hZHMvMjAxNC8wNy9yZWMzMDAucG5nXCIgLz48L2E+DQo8L2Rpdj4NCg0KPGRpdiBjbGFzcz1cInRkLXZpc2libGUtdGFibGV0LWxcIj4NCjxhIGhyZWY9XCIjXCI+PGltZyBzcmM9XCJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDcvcmVjMjAwLnBuZ1wiIC8+PC9hPg0KPC9kaXY+DQoNCjxkaXYgY2xhc3M9XCJ0ZC12aXNpYmxlLXRhYmxldC10cFwiPg0KPGEgaHJlZj1cIiNcIj48aW1nIHNyYz1cImh0dHA6Ly8wZGl2LmNvbTo2OS9uZXdzcGFwZXJfZGVtby93cC1jb250ZW50L3VwbG9hZHMvMjAxNC8wNy9yZWMyMDAucG5nXCIgLz48L2E+DQo8L2Rpdj4NCg0KPGRpdiBjbGFzcz1cInRkLXZpc2libGUtcGhvbmVcIj4NCjxhIGhyZWY9XCIjXCI+PGltZyBzcmM9XCJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDcvcmVjMzAwLnBuZ1wiIC8+PC9hPg0KPC9kaXY+IjtzOjk6ImRpc2FibGVfbSI7czowOiIiO3M6NjoibV9zaXplIjtzOjA6IiI7czoxMDoiZGlzYWJsZV90bCI7czowOiIiO3M6NzoidGxfc2l6ZSI7czowOiIiO3M6MTA6ImRpc2FibGVfdHAiO3M6MDoiIjtzOjc6InRwX3NpemUiO3M6MDoiIjtzOjk6ImRpc2FibGVfcCI7czowOiIiO3M6NjoicF9zaXplIjtzOjA6IiI7czoxNToiY3VycmVudF9hZF90eXBlIjtzOjU6Im90aGVyIjt9czoxMToiY3VzdG9tX2FkXzEiO2E6MTA6e3M6NzoiYWRfY29kZSI7czo2MDk6IjxkaXYgY2xhc3M9XCJ0ZC12aXNpYmxlLWRlc2t0b3BcIj4NCjxhIGhyZWY9XCIjXCI+PGltZyBzcmM9XCJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDcvcmVjNzI4LmpwZ1wiIC8+PC9hPg0KPC9kaXY+DQoNCjxkaXYgY2xhc3M9XCJ0ZC12aXNpYmxlLXRhYmxldC1sXCI+DQo8YSBocmVmPVwiI1wiPjxpbWcgc3JjPVwiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzA3L3JlYzQ2OC5qcGdcIiAvPjwvYT4NCjwvZGl2Pg0KDQo8ZGl2IGNsYXNzPVwidGQtdmlzaWJsZS10YWJsZXQtdHBcIj4NCjxhIGhyZWY9XCIjXCI+PGltZyBzcmM9XCJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDcvcmVjNDY4LmpwZ1wiIC8+PC9hPg0KPC9kaXY+DQoNCjxkaXYgY2xhc3M9XCJ0ZC12aXNpYmxlLXBob25lXCI+DQo8YSBocmVmPVwiI1wiPjxpbWcgc3JjPVwiaHR0cDovLzBkaXYuY29tOjY5L25ld3NwYXBlcl9kZW1vL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzA3L3JlYzMyMC5qcGdcIiAvPjwvYT4NCjwvZGl2PiI7czo5OiJkaXNhYmxlX20iO3M6MDoiIjtzOjY6Im1fc2l6ZSI7czo4OiI3MjggeCA5MCI7czoxMDoiZGlzYWJsZV90bCI7czowOiIiO3M6NzoidGxfc2l6ZSI7czowOiIiO3M6MTA6ImRpc2FibGVfdHAiO3M6MDoiIjtzOjc6InRwX3NpemUiO3M6MDoiIjtzOjk6ImRpc2FibGVfcCI7czowOiIiO3M6NjoicF9zaXplIjtzOjA6IiI7czoxNToiY3VycmVudF9hZF90eXBlIjtzOjU6Im90aGVyIjt9fXM6MTY6ImNhdGVnb3J5X29wdGlvbnMiO2E6NDM6e2k6NzthOjE6e3M6OToidGRjX2NvbG9yIjtzOjc6IiNGNTY4NTUiO31pOjIxODthOjE6e3M6OToidGRjX2NvbG9yIjtzOjc6IiNjODViY2QiO31pOjE5O2E6MTp7czo5OiJ0ZGNfY29sb3IiO3M6NzoiIzRkYjJlYyI7fWk6MTQ7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjNDg4ZGM3Ijt9aToyMDc7YToyOntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjYiO3M6OToidGRjX2NvbG9yIjtzOjc6IiM2MjRhOTMiO31pOjk4O2E6Mjp7czoxMDoidGRjX2xheW91dCI7czoxOiIyIjtzOjE1OiJ0ZGNfc2lkZWJhcl9wb3MiO3M6MTI6InNpZGViYXJfbGVmdCI7fWk6MTM7YTo0OntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjMiO3M6OToidGRjX2NvbG9yIjtzOjc6IiM4NWEwZGUiO3M6OToidGRjX2ltYWdlIjtzOjY3OiJodHRwOi8vMGRpdi5jb206NjkvbmV3c3BhcGVyX2RlbW8vd3AtY29udGVudC91cGxvYWRzLzIwMTMvMTIvMDcuanBnIjtzOjEzOiJ0ZGNfYmdfcmVwZWF0IjtzOjc6InN0cmV0Y2giO31pOjEyOTthOjI6e3M6MTY6InRkY19zaWRlYmFyX25hbWUiO3M6ODoiQ2F0ZWdvcnkiO3M6OToidGRjX2NvbG9yIjtzOjc6IiM1NTMxMTEiO31pOjI1O2E6MTp7czo5OiJ0ZGNfY29sb3IiO3M6NzoiIzUwYmU3ZSI7fWk6MjM7YToyOntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjQiO3M6OToidGRjX2NvbG9yIjtzOjc6IiM4NWEwZGUiO31pOjk7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjZTNjNzAxIjt9aToxMTthOjE6e3M6OToidGRjX2NvbG9yIjtzOjc6IiM0REIyRUMiO31pOjEyO2E6MTp7czo5OiJ0ZGNfY29sb3IiO3M6NzoiI0FFQjQxMyI7fWk6MTY7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjNzFhNTNmIjt9aTozO2E6Mzp7czoxMDoidGRjX2xheW91dCI7czoxOiI1IjtzOjEwOiJ0ZGNfc2xpZGVyIjtzOjM6InllcyI7czo5OiJ0ZGNfY29sb3IiO3M6NzoiIzg1YTBkZSI7fWk6MTU7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjZTNjNzAxIjt9aToyNTE7YTo1OntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjEiO3M6MTY6InRkY19zaWRlYmFyX25hbWUiO3M6NzoiTW9kdWxlcyI7czoxMDoidGRjX3NsaWRlciI7czozOiJ5ZXMiO3M6OToidGRjX2NvbG9yIjtzOjc6IiNlYTQ1NDUiO3M6MTY6InRkY19oaWRlX29uX3Bvc3QiO3M6NDoiaGlkZSI7fWk6MjUyO2E6Mzp7czoxMDoidGRjX2xheW91dCI7czoxOiIyIjtzOjE2OiJ0ZGNfc2lkZWJhcl9uYW1lIjtzOjc6Ik1vZHVsZXMiO3M6MTY6InRkY19oaWRlX29uX3Bvc3QiO3M6NDoiaGlkZSI7fWk6MjUzO2E6Mzp7czoxMDoidGRjX2xheW91dCI7czoxOiIzIjtzOjE2OiJ0ZGNfc2lkZWJhcl9uYW1lIjtzOjc6Ik1vZHVsZXMiO3M6MTY6InRkY19oaWRlX29uX3Bvc3QiO3M6NDoiaGlkZSI7fWk6MjU0O2E6Mzp7czoxMDoidGRjX2xheW91dCI7czoxOiI0IjtzOjE2OiJ0ZGNfc2lkZWJhcl9uYW1lIjtzOjc6Ik1vZHVsZXMiO3M6MTY6InRkY19oaWRlX29uX3Bvc3QiO3M6NDoiaGlkZSI7fWk6MjU1O2E6NDp7czoxMDoidGRjX2xheW91dCI7czoxOiI1IjtzOjE2OiJ0ZGNfc2lkZWJhcl9uYW1lIjtzOjc6Ik1vZHVsZXMiO3M6MTA6InRkY19zbGlkZXIiO3M6MzoieWVzIjtzOjE2OiJ0ZGNfaGlkZV9vbl9wb3N0IjtzOjQ6ImhpZGUiO31pOjI1NjthOjM6e3M6MTA6InRkY19sYXlvdXQiO3M6MToiNiI7czoxNjoidGRjX3NpZGViYXJfbmFtZSI7czo3OiJNb2R1bGVzIjtzOjE2OiJ0ZGNfaGlkZV9vbl9wb3N0IjtzOjQ6ImhpZGUiO31pOjI1NzthOjQ6e3M6MTA6InRkY19sYXlvdXQiO3M6MToiNyI7czoxNjoidGRjX3NpZGViYXJfbmFtZSI7czo3OiJNb2R1bGVzIjtzOjEwOiJ0ZGNfc2xpZGVyIjtzOjM6InllcyI7czoxNjoidGRjX2hpZGVfb25fcG9zdCI7czo0OiJoaWRlIjt9aTozMDU7YTozOntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjgiO3M6MTY6InRkY19zaWRlYmFyX25hbWUiO3M6NzoiTW9kdWxlcyI7czoxNjoidGRjX2hpZGVfb25fcG9zdCI7czo0OiJoaWRlIjt9aTozMDY7YTozOntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjkiO3M6MTY6InRkY19zaWRlYmFyX25hbWUiO3M6NzoiTW9kdWxlcyI7czoxNjoidGRjX2hpZGVfb25fcG9zdCI7czo0OiJoaWRlIjt9aToyNTg7YTozOntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjY6InNlYXJjaCI7czoxNjoidGRjX3NpZGViYXJfbmFtZSI7czo3OiJNb2R1bGVzIjtzOjE2OiJ0ZGNfaGlkZV9vbl9wb3N0IjtzOjQ6ImhpZGUiO31pOjU7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjNDg4ZGM3Ijt9aTo2O2E6MTp7czo5OiJ0ZGNfY29sb3IiO3M6NzoiIzAwNzdlNiI7fWk6MjY7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjZTNjNzAxIjt9aToyNzthOjE6e3M6OToidGRjX2NvbG9yIjtzOjc6IiNhMDhmOWQiO31pOjIyMTthOjE6e3M6OToidGRjX2NvbG9yIjtzOjc6IiNjODM3MzciO31pOjIwO2E6MTp7czo5OiJ0ZGNfY29sb3IiO3M6NzoiIzU2NTc1MiI7fWk6MjQ7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjZTE0ZTQyIjt9aToxOTE7YTo0OntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjIiO3M6MTU6InRkY19zaWRlYmFyX3BvcyI7czoxMzoic2lkZWJhcl9yaWdodCI7czoxNjoidGRjX3NpZGViYXJfbmFtZSI7czo3OiJSZXZpZXdzIjtzOjk6InRkY19jb2xvciI7czo3OiIjYmJlNjI2Ijt9aTo0O2E6MTp7czo5OiJ0ZGNfY29sb3IiO3M6NzoiI0YxNkM5QyI7fWk6MjE7YToyOntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjEiO3M6OToidGRjX2NvbG9yIjtzOjc6IiNmNTJhNTciO31pOjE4O2E6NDp7czoxMDoidGRjX2xheW91dCI7czoxOiI2IjtzOjE1OiJ0ZGNfc2lkZWJhcl9wb3MiO3M6MTA6Im5vX3NpZGViYXIiO3M6MTA6InRkY19zbGlkZXIiO3M6MzoieWVzIjtzOjk6InRkY19jb2xvciI7czo3OiIjODVhMGRlIjt9aToyMTk7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjN2Q4ZTI1Ijt9aToxMDthOjE6e3M6OToidGRjX2NvbG9yIjtzOjc6IiNmZjQwNDAiO31pOjg7YTozOntzOjEwOiJ0ZGNfbGF5b3V0IjtzOjE6IjYiO3M6MTA6InRkY19zbGlkZXIiO3M6MzoieWVzIjtzOjk6InRkY19jb2xvciI7czo3OiIjODVhMGRlIjt9aToyMjA7YToxOntzOjk6InRkY19jb2xvciI7czo3OiIjZmY1MjhhIjt9aTozMTY7YToxOntzOjEwOiJ0ZGNfc2xpZGVyIjtzOjM6InllcyI7fWk6MzE1O2E6MTp7czoxMDoidGRjX2xheW91dCI7czoxOiIyIjt9fXM6MTk6InRkc19pbmxpbmVfYWRfYWxpZ24iO3M6MDoiIjtzOjI5OiJ0ZHNfZGlzYWJsZV9jb21tZW50c19zaWRld2lkZSI7czowOiIiO3M6Mzg6InRkc19tb3JlX2FydGljbGVzX29uX3Bvc3RfcGFnZXNfZW5hYmxlIjtzOjA6IiI7czo0OToidGRzX21vcmVfYXJ0aWNsZXNfb25fcG9zdF9wYWdlc19kaXN0YW5jZV9mcm9tX3RvcCI7czowOiIiO3M6Mzk6InRkc19tb3JlX2FydGljbGVzX29uX3Bvc3RfcGFnZXNfZGlzcGxheSI7czowOiIiO3M6NDY6InRkc19tb3JlX2FydGljbGVzX29uX3Bvc3RfcGFnZXNfZGlzcGxheV9tb2R1bGUiO3M6MDoiIjtzOjM4OiJ0ZHNfbW9yZV9hcnRpY2xlc19vbl9wb3N0X3BhZ2VzX251bWJlciI7czowOiIiO3M6NDQ6InRkc19tb3JlX2FydGljbGVzX29uX3Bvc3RfcGFnZXNfdGltZV90b193YWl0IjtzOjA6IiI7czoyMjoidGRzX3RyYW5zcGFyZW50X2hlYWRlciI7czowOiIiO3M6MTk6InRkc19tZW51X2ljb25fY29sb3IiO3M6MDoiIjtzOjI2OiJ0ZHNfZGlzYWJsZV9jb21tZW50c19wYWdlcyI7czowOiIiO3M6MTk6InRkc19saWtlX3R3ZWV0X3Nob3ciO3M6MDoiIjtzOjI0OiJ0ZHNfdGltZWxpbmVfc2lkZWJhcl9wb3MiO3M6MDoiIjtzOjIwOiJ0ZHNfdGltZWxpbmVfc2lkZWJhciI7czowOiIiO3M6MjU6InRkc19zaXRlX2JhY2tncm91bmRfaW1hZ2UiO3M6MDoiIjtzOjI2OiJ0ZHNfc2l0ZV9iYWNrZ3JvdW5kX3JlcGVhdCI7czowOiIiO3M6MzA6InRkc19zaXRlX2JhY2tncm91bmRfcG9zaXRpb25feCI7czowOiIiO3M6MzA6InRkc19zaXRlX2JhY2tncm91bmRfYXR0YWNobWVudCI7czowOiIiO3M6MjU6InRkc19zaXRlX2JhY2tncm91bmRfY29sb3IiO3M6MDoiIjtzOjIzOiJ0ZHNfYmlnX3NsaWRlX3RyYW5zZm9ybSI7czowOiIiO3M6MjM6InRkc19tYWluX21lbnVfdHJhbnNmb3JtIjtzOjA6IiI7czoyNDoidGRzX3N1Yl9tZW51X2ZvbnRfZmFtaWx5IjtzOjA6IiI7czoyMjoidGRzX3N1Yl9tZW51X2ZvbnRfc2l6ZSI7czowOiIiO3M6MjQ6InRkc19zdWJfbWVudV9saW5lX2hlaWdodCI7czowOiIiO3M6MzI6InRkc19ibG9ja3F1b3RlX3RpdGxlX2ZvbnRfZmFtaWx5IjtzOjA6IiI7czozMDoidGRzX2Jsb2NrcXVvdGVfdGl0bGVfZm9udF9zaXplIjtzOjA6IiI7czozMjoidGRzX2Jsb2NrcXVvdGVfdGl0bGVfbGluZV9oZWlnaHQiO3M6MDoiIjtzOjg6InRkX2ZvbnRzIjthOjA6e31zOjE4OiJ0ZF9mb250c19qc19idWZmZXIiO3M6MDoiIjtzOjE5OiJ0ZF9mb250c19jc3NfYnVmZmVyIjtzOjA6IiI7czoxODoidGRfZm9udHNfY3NzX2ZpbGVzIjtzOjA6IiI7czoyMDoidGRzX2xvZ29fbWVudV91cGxvYWQiO3M6MDoiIjtzOjIyOiJ0ZHNfbG9nb19tZW51X3VwbG9hZF9yIjtzOjA6IiI7czoyMDoidGRzX3R3ZWV0ZXJfdXNlcm5hbWUiO3M6MDoiIjtzOjEwOiJ0ZHNfZm9vdGVyIjtzOjA6IiI7czoxNDoidGRzX3N1Yl9mb290ZXIiO3M6MDoiIjtzOjI5OiJ0ZF9kZWZhdWx0X3NpdGVfcG9zdF90ZW1wbGF0ZSI7czowOiIiO3M6Mzc6InRkc19iaWdfc2xpZGVfYmlnX2ltYWdlX3RpdGxlX2V4Y2VycHQiO3M6MDoiIjtzOjM5OiJ0ZHNfYmlnX3NsaWRlX3NtYWxsX2ltYWdlX3RpdGxlX2V4Y2VycHQiO3M6MDoiIjtzOjE1OiJ0ZF9ib2R5X2NsYXNzZXMiO3M6MDoiIjtzOjE5OiJ0ZF9jYWtlX3N0YXR1c190aW1lIjtpOjE0MTE2MjY5NDY7czoxNDoidGRfY2FrZV9zdGF0dXMiO3M6MToiNCI7czoyNzoidGRzX3Nob3dfYXV0aG9yX3VuZGVyX3RpdGxlIjtzOjA6IiI7czoyNDoidGRzX2FqYXhfcG9zdF92aWV3X2NvdW50IjtzOjA6IiI7czoyNDoidGRzX21vZF8xMF90aXRsZV9leGNlcnB0IjtzOjA6IiI7czoyMToidGRzX2N1c3RvbV9qYXZhc2NyaXB0IjtzOjA6IiI7czoyMDoidGRzX3VzZXJfY29tcGlsZV9jc3MiO3M6MDoiIjt9';
$testing_options_009 = unserialize(base64_decode($testing_options_009));

foreach ($testing_options_009 as $key =>$value) {
if (isset(td_global::$td_options[$key])) {
echo "\n\n $key \n ---------------------- \n";
echo '009 -> ';
print_r($value);
echo "\n" . '011 -> ';
print_r(td_global::$td_options[$key]);


}
}
die;

$array_key_diff = array_diff_key($testing_options_009, td_global::$td_options);
echo "new keys in 009 -------------------------------------------\n\n\n\n\n";
print_r($array_key_diff);



$array_key_diff_2 = array_diff_key(td_global::$td_options, $testing_options_009);
echo "new keys in 011 -------------------------------------------\n\n\n\n";
print_r($array_key_diff_2);

die;
print_r(unserialize($sidebar_widgets_test));
print_r(td_update_to_newspaper6::update_sidebar_widgets(unserialize($sidebar_widgets_test)));



$newspaper_4_6_shortcode_mapp = array(
'td_block10' => 'td_block_10',
'td_block1' => 'td_block_1',
'td_block2' => 'td_block_2',
'td_block3' => 'td_block_3',
'td_block4' => 'td_block_4',
'td_block5' => 'td_block_5',
'td_block6' => 'td_block_6',
'td_block7' => 'td_block_7',
'td_block8' => 'td_block_8',
'td_block9' => 'td_block_9',

'td_ad_box'             => 'td_block_ad_box',
//'td_social' => '',
'td_popular_categories' => 'td_block_popular_categories',
'td_authors'            => 'td_block_authors',
'td_text_with_title'    => 'td_block_text_with_title',
'td_slide_big'          => 'td_block_big_grid_2',
'td_slide'              => 'td_block_slide',
'td_video_youtube'      => 'td_block_video_youtube',
'td_video_vimeo'        => 'td_block_video_vimeo',
'td_social_counter'     => 'td_block_social_counter',

);

*/
?>
