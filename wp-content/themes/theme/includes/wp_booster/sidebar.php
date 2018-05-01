<?php
/*  ----------------------------------------------------------------------------
    tagDiv sidebar loader

    Load order on pages / posts:
    - custom post / page sidebar
    - primary category sidebar
    - default sidebar

    Load order on category template:
    - custom category sidebar
    - default sidebar
 */


//if it's singular read the post/page sidebar settings
if (is_singular()) {
    $td_post_theme_settings = get_post_meta($post->ID, 'td_post_theme_settings', true);
    $td_page = get_post_meta($post->ID, 'td_page', true);
}

if (!empty($td_post_theme_settings['td_sidebar'])) {
    /*  ----------------------------------------------------------------------------
        sidebar from post - set in the post setting
     */
    dynamic_sidebar($td_post_theme_settings['td_sidebar']);
} elseif (!empty($td_page['td_sidebar'])) {
    /*  ----------------------------------------------------------------------------
        sidebar from page - set in the page setting
     */
    dynamic_sidebar($td_page['td_sidebar']);
} else {

    if (td_global::$current_template == 'woo') {
        //woo commerce
        td_util::show_sidebar('woo');
    } elseif (td_global::$current_template == 'woo_single') {
        td_util::show_sidebar('woo_single');
    } elseif (td_global::$current_template == 'bbpress') {
        td_util::show_sidebar('bbpress');
    } elseif (is_tax()) {
        // custom taxonomies
        $current_term_obj = get_queried_object();
        $tds_taxonomy_sidebar = td_util::get_taxonomy_option($current_term_obj->taxonomy, 'tds_taxonomy_sidebar');
        if (!empty($tds_taxonomy_sidebar)) {
            dynamic_sidebar($tds_taxonomy_sidebar);
        } else {
            //show default if available
            if (!dynamic_sidebar(TD_THEME_NAME . ' default')) {
                ?>
                <!-- no sidebar -->
                <?php
            }
        }
    } elseif (is_category()) {
        // sidebar from category on category page
        $curCategoryID = get_query_var('cat');
        $tax_meta_sidebar = td_util::get_category_option($curCategoryID, 'tdc_sidebar_name');////swich by RADU A, get_tax_meta($curCategoryID, 'tdc_sidebar_name');
        if (!empty($tax_meta_sidebar)) {
            //show the category one
            dynamic_sidebar($tax_meta_sidebar);
        } else {
            //show the global selected category sidebar or if nothing is selected show the default one
            td_util::show_sidebar('category');
        }

    } elseif (td_global::$current_template == 'page-homepage-loop') {
        if (!empty(td_global::$load_sidebar_from_template)) {
            //load the template
            dynamic_sidebar(td_global::$load_sidebar_from_template);
        } else {
            //show default
            dynamic_sidebar(TD_THEME_NAME . ' default');
        }


    } elseif (is_attachment()) {
        //custom sidebars for archives
        td_util::show_sidebar('attachment');

    } elseif (is_singular('post')){

        // sidebar from category on post page
        $primary_category_id = td_global::get_primary_category_id();
        if (!empty($primary_category_id)) {
            $tax_meta_sidebar = td_util::get_category_option($primary_category_id, 'tdc_sidebar_name');//swich by RADU A, get_tax_meta($primary_category_id, 'tdc_sidebar_name');
            if (!empty($tax_meta_sidebar)) {
                //show the category one
                dynamic_sidebar($tax_meta_sidebar);
            } else {
                //load the blog one or default
                td_util::show_sidebar('home');
            }
        } else {
            //load the blog one or default
            td_util::show_sidebar('home');
        }

    } elseif (is_single()) {

        // sidebar for custom post type
        $tds_custom_post_sidebar = td_util::get_ctp_option($post->post_type, 'tds_custom_post_sidebar');
        if (!empty($tds_custom_post_sidebar)) {
            // custom sidebar
            dynamic_sidebar($tds_custom_post_sidebar);
        } else {
            // show default
            dynamic_sidebar(TD_THEME_NAME . ' default');
        }

    } elseif (is_home()) {
        // it's the blog index template (home.php but I think we go with index.php)
        td_util::show_sidebar('home');

    } elseif (is_page()) {
        // custom sidebars for pages
        td_util::show_sidebar('page');

    } elseif (is_day() or is_month() or is_year()) {
        //custom sidebar for archive pages
        td_util::show_sidebar('archive');

    } elseif (is_author()) {
        //custom sidebar for author pages
        td_util::show_sidebar('author');

    } elseif (is_tag()) {
        td_util::show_sidebar('tag');

    } elseif (is_search()) {
        td_util::show_sidebar('search');

    } else {
        //show default
        dynamic_sidebar(TD_THEME_NAME . ' default');
    }
}

