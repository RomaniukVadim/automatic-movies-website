<?php


class td_unique_posts {


    static $rendered_posts_ids = array(); //here we hold all the rendered posts id's. It's used by the data source to remove them in the following queries
    private static $keep_rendered_posts_ids = false; //if this is true, we add posts to the $rendered_posts_ids array

    static $unique_articles_enabled = false;  //if true, the datasource will filter the rendered posts id

    static function td_init() {
        /**
         * we need to hook after header because in mega menu we can have all kinds of modules and we don't want the unique
         * articles class to interfere with them.
         */
        add_filter('td_wp_booster_after_header', array(__CLASS__, 'on_td_wp_booster_after_header'), 10);

        /**
         * this hook is called each time a module is instantiated
         */
        add_filter('td_wp_booster_module_constructor', array(__CLASS__, 'on_td_wp_booster_module_constructor'), 5, 3);
    }


    //if we are on a page, read the page meta and see if td_unique_articles is set
    static function on_td_wp_booster_after_header() {
        $page_id = get_queried_object_id();

        if (is_page()) {

	        // previous meta
	        //$td_unique_articles = get_post_meta($page_id, 'td_unique_articles', true);

	        $meta_key = 'td_page';
	        $td_page_template = get_post_meta($page_id, '_wp_page_template', true);
	        if (!empty($td_page_template) && ($td_page_template == 'page-pagebuilder-latest.php')) {
		        $meta_key = 'td_homepage_loop';

	        }

	        $td_unique_articles = get_post_meta($page_id, $meta_key, true);
	        if (!empty($td_unique_articles['td_unique_articles'])) {
		        self::$keep_rendered_posts_ids = true; //for new module hook
		        self::$unique_articles_enabled = true; //for datasource
	        }
        }
        if (td_util::get_option('tds_ajax_post_view_count') == 'enabled') {
            self::$keep_rendered_posts_ids = true;
        }
    }


    //we hook td_module constructor if  `unique articles` is enabled
    static function on_td_wp_booster_module_constructor($module, $post) {
        if (self::$keep_rendered_posts_ids == true) {
            /**
             * @todo in viitor daca ne trebuie ceva mai bun trebuie refactorizat sa foloseasca api-ul de la module sau constructorul din td_module
             */
            // exclude td_module_trending_now din unique articles
            if (get_class($module) != 'td_module_trending_now') {
                self::$rendered_posts_ids[] = $post->ID;
            }
        }
    }

}


td_unique_posts::td_init();