<?php
/**
 * td_global_blocks.php
 * no td_util loaded, no access to settings
 */


class td_global_blocks {
    private static $global_instances = array();
    private static $global_id_lazy_instances = array();

    /**
     * @param $block_instance
     * @deprecated Use add_id instead of it. It's maintained just for plugin compatibility
     */
    static function add_instance($block_instance) {
    }

    /**
     * @param $block_id string keeps a reference of the block for lazy instance
     */
    static function add_lazy_shortcode($block_id) {
        self::$global_id_lazy_instances[] = $block_id;
        add_shortcode($block_id, array('td_global_blocks', 'proxy_function'));
    }

    static function proxy_function($atts, $content, $tag) {
        return self::get_instance($tag)->render($atts, $content);
    }

    static function get_instance($block_id) {
        if (isset(self::$global_instances[$block_id])) {
            return self::$global_instances[$block_id];
        } else if (in_array($block_id, self::$global_id_lazy_instances)) {
            $new_instance = new $block_id();
            self::$global_instances[$block_id] = $new_instance;
            return $new_instance;
        } else {
            /**
             * return a fake new instance of td_block - so that we have the render() method for decoupling - when the blocks are deleted :)  @todo wtf?
             */
            return new td_block();
        }
    }


    /**
     * map all the blocks in the pagebuilder
     */
    static function wpb_map_all() {
        //print_r(td_block_api::get_all()); die;

        foreach (td_api_block::get_all() as $block_settings) {
            // shortcodes that have no $block_settings['map_in_visual_composer'] are maped!
            // shrotcodes that have $block_settings['map_in_visual_composer'] !== false are maped
            if (isset($block_settings['map_in_visual_composer']) and $block_settings['map_in_visual_composer'] !== false) {
                vc_map($block_settings);
            }
        }
    }


    static function debug_get_all_instances() {
        return self::$global_instances;
    }

    static function debug_get_all_id_lazy_instances() {
        return self::$global_id_lazy_instances;
    }
}