<?php


/*  ----------------------------------------------------------------------------
    the custom compiler
 */
class td_css_compiler {
    var $raw_css;
    var $settings; //array

    var $css_sections; //array

    function __construct($raw_css) {
        $this->raw_css = $raw_css;

//	    print_r(debug_backtrace());
//	    die;
    }


    function load_setting($name, $append_to_value = '') {
        //echo 'rara1';
        $current_customizer_value = td_util::get_option('tds_' . $name);
        if (!empty($current_customizer_value)) {
            $current_customizer_value.= $append_to_value;
        }
        $this->load_setting_raw($name, $current_customizer_value);
    }

    function load_setting_raw($full_name, $value) {

        $this->settings[$full_name] = $value;
        //print_r($this->settings) ;
    }




    function load_setting_array($arr) {

        $remove_empty = array_filter($arr[key($arr)]);
        if (empty($remove_empty)) {
            return;
        }

        $this->settings[key($arr)] = $arr[key($arr)];
    }

    function split_into_sections() {
        //remove <style> wrap
        $this->raw_css = str_replace('<style>', '', $this->raw_css);
        $this->raw_css = str_replace('</style>', '', $this->raw_css);

        //explode the sections
        $css_splits = explode('/*', $this->raw_css);
        foreach ($css_splits as $css_split) {
            $css_split_parts = explode('*/', $css_split);
            if (!empty($css_split_parts[0]) and !empty($css_split_parts[1])) {
                $this->css_sections[trim($css_split_parts[0])] = $css_split_parts[1];
            }
        }
    }


    function compile_sections() {
        if (!empty($this->css_sections) and !empty($this->settings)) {
            foreach ($this->css_sections as $section_name => &$section_css) {
                foreach ($this->settings as $setting_name => $setting_value) {

                    if (is_array($setting_value)) {
                        //we have a property -> falue array :)
                        $css_property_value_buffer = '';
                        foreach ($setting_value as $css_property => $css_value) {
                            if (!empty($css_value)) {
                                $css_property_value_buffer .= str_replace('_', '-', $css_property) . ':' . $css_value . ';' . "\n\t";
                            }
                        }

                        //write the values to the sections css by ref
                        //$section_css = str_replace('@' . $setting_name, $css_property_value_buffer, $section_css);
                        $section_css = preg_replace('/@' . $setting_name . '\b/', $css_property_value_buffer, $section_css);
                    } else {
                        //$section_css = str_replace('@' . $setting_name, $setting_value, $section_css);
                        $section_css = preg_replace('/@' . $setting_name . '\b/', $setting_value, $section_css);
                    }

                }
            }
        }
    }




    function compile_css() {
        //print_r($this->settings);
        //die;

        $this->split_into_sections();
        //print_r($this->css_sections);
        //die;
        $this->compile_sections();

        $buffy = '';

        foreach ($this->css_sections as $section_name => $section_css) {
            if (!empty($this->settings[str_replace('@', '', $section_name)])) {
                $buffy.= $section_css;
            }
        }

        $buffy = trim($buffy);

        //print_r($this->css_sections);
        return $buffy;
    }
}
