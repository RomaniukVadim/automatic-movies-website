<?php
/**
 * Created by ra on 7/17/2015.
 */
class td_panel_woo {
    function __construct() {
        add_action('admin_menu',  array($this, 'register_td_panel_woo'), 99);

        if (isset($_GET['page']) and $_GET['page'] == 'td_panel_woo') {
            add_filter('admin_body_class', array($this, 'add_body_class'));
        }
    }

    function register_td_panel_woo() {
        if (td_global::$is_woocommerce_installed === true and isset(td_global::$all_theme_panels_list['td_panel_woo'])) {
            add_submenu_page("woocommerce", 'tagDiv Plugins', 'tagDiv Plugins', 'edit_posts', 'td_panel_woo',  array($this, 'render_td_panel_woo'));
        }
    }

    function render_td_panel_woo() {
        //print_r(td_global::$all_theme_panels_list);
        td_panel_core::render_panel(td_global::$all_theme_panels_list, 'td_panel_woo');
    }


    function add_body_class($classes) {
        $classes .= ' td-theme-panel-body ';
        return $classes;
    }
}

new td_panel_woo();