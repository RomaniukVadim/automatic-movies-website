<?php
include_once get_template_directory()  . '/includes/wp_booster/wp-admin/external/wpalchemy/MetaBox.php';



add_action('init', 'td_register_post_metaboxes', 9999); // we need to be on init because we use get_post_types - we need the high priority to catch retarded plugins that bind late to the hook to register it's CPT
function td_register_post_metaboxes() {
    $td_template_settings_path = get_template_directory() . '/includes/wp_booster/wp-admin/content-metaboxes/';


    //default page
    new WPAlchemy_MetaBox(array(
        'id' => 'td_page',
        'title' => 'Page template settings',
        'types' => array('page'),
        'priority' => 'high',
        'template' => $td_template_settings_path . 'td_set_page.php',
    ));



    //homepage with loop
    new WPAlchemy_MetaBox(array(
        'id' => 'td_homepage_loop',
        'title' => 'Homepage latest articles',
        'types' => array('page'),
        'priority' => 'high',
        'template' => $td_template_settings_path . 'td_set_page_with_loop.php',
    ));


    if (current_user_can('publish_posts')) {
        // featured video
        new WPAlchemy_MetaBox(array(
            'id' => 'td_post_video',
            'title' => 'Featured Video',
            'types' => array('post'),
            'priority' => 'low',
            'context' => 'side',
            'template' => $td_template_settings_path . 'td_set_video_meta.php',
        ));
    }





    /**
     * single posts, Custom Post Types and WooCommerce products all use the same metadata keys!
     * we just switch here the views
     */


    /**
     * 'post' post type / single
     */
    if (current_user_can('publish_posts')) {
        new WPAlchemy_MetaBox(array(
            'id' => 'td_post_theme_settings',
            'title' => 'Post settings',
            'types' => array('post'),
            'priority' => 'high',
            'template' => get_template_directory() . '/includes/wp_booster/wp-admin/content-metaboxes/td_set_post_settings.php',
        ));
    }


    /**
     * Custom Post Types
     */
    $td_custom_post_types = get_post_types( // get all the custom post types EXCEPT post page etc.
        array(
            '_builtin' => false // ignore built in CPT
        ),
        'names' //return the names in an array
    );

    // remove the woo_commerce post tyep from the array if it's available and the woo_commerce plugin is installed
    if (td_global::$is_woocommerce_installed === true) {
        $woo_key = array_search('product', $td_custom_post_types);
        if($woo_key !== false) {
            unset($td_custom_post_types[$woo_key]);
        }
    }

    // if we have any CPT left, associate them with the metaboxes
    if (!empty($td_custom_post_types) && current_user_can('publish_posts')) {
        new WPAlchemy_MetaBox(array(
            'id' => 'td_post_theme_settings',
            'title' => 'Custom Post Type - layout settings',
            'types' => $td_custom_post_types,
            'priority' => 'high',
            'template' => get_template_directory() . '/includes/wp_booster/wp-admin/content-metaboxes/td_set_post_settings_cpt.php',
        ));
    }

    /**
     * woo commerce product post type
     */
    if (td_global::$is_woocommerce_installed === true) {
        new WPAlchemy_MetaBox(array(
            'id' => 'td_post_theme_settings',
            'title' => 'WooCommerce - product layout settings',
            'types' => array('product'),
            'priority' => 'default',
            'template' => get_template_directory() . '/includes/wp_booster/wp-admin/content-metaboxes/td_set_post_settings_woo.php',
        ));
    }




}


