<?php
/**
 * Created by ra on 7/20/2015.
 */


class tdx_api_panel {

    /**
     * adds a new panel to a specific panel spot. After each panel is added, the panel spot can be rendered from @see td_panel_core::render_panel
     * @param $panel_spot_id
     * @param $params_array
     */
    static function add($panel_spot_id, $params_array) {
        if (isset(td_global::$all_theme_panels_list[$panel_spot_id])) {
            if (!isset(td_global::$all_theme_panels_list[$panel_spot_id]['panels'])) { //make sure we have an array in panels, makes ::add array_merge work
                td_global::$all_theme_panels_list[$panel_spot_id]['panels'] = array();
            }
            td_global::$all_theme_panels_list[$panel_spot_id]['panels'] = array_merge($params_array, td_global::$all_theme_panels_list[$panel_spot_id]['panels']);
        } else {
            td_global::$all_theme_panels_list[$panel_spot_id]['panels'] = $params_array;
        }
    }


    /**
     * updates a panel spot. WARNING: it will only update the keys from the $update_array
     * @param $panel_spot_id
     * @param $update_array
     */
    static function update_panel_spot($panel_spot_id, $update_array) {
        foreach ($update_array as $option_id => $option_value) {
            td_global::$all_theme_panels_list[$panel_spot_id][$option_id] = $option_value;
        }
    }


}