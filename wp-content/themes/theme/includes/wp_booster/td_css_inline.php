<?php

/**
 * Used to render inline css easy
 * Class td_css_inline
 */
class td_css_inline {
    private $buffy_array = array();


    /**
     * adds an inline css style
     * @param $css_array
     *
     *  array (
     *      'background-color' => 'red',
     *      'etc..'
     *  )
     *
     */
    public function add_css($css_array) {
        $this->buffy_array = array_merge($this->buffy_array, $css_array);
    }


    /**
     * Converts a CSS array (color=>red) to CSS  color:red;
     * @return string
     */
    private function get_css_block($add_new_line_after_prop = false) {
        if (empty($this->buffy_array)) {
            return '';
        }

        $buffy = '';
        foreach ($this->buffy_array as $css_property => $css_property_value) {
            if (empty($buffy)) {
                $buffy = $css_property . ':' . $css_property_value;
            } else {
                if ($add_new_line_after_prop === true) {
                    $buffy .= ';' . PHP_EOL . "\t" . $css_property . ':' . $css_property_value;
                } else {
                    $buffy .= ';' . $css_property . ':' . $css_property_value;
                }

            }
        }
        $buffy = trim($buffy);
        if (!empty($buffy)) {
            $buffy .= ';'; //add the last ; if the buffer is not empty
        }

        return trim($buffy);
    }


    /**
     * returns a css like:
     *  .my-class {
     *      color:red;
     *  }
     * @param $selector string the css selector to append to the generated css
     * @return string the css in the selectors brackets
     */
    public function get_css_for_selector($selector) {
        $buffy = $this->get_css_block(true);
        if (!empty($buffy)) {
            $buffy = PHP_EOL . $selector . ' {' . PHP_EOL . "\t" . $buffy . PHP_EOL . '}';
            return $buffy;
        }
        return '';
    }

    /**
     * returns the inline css, must be called in the atts section of a HTML tag ex: <div <?php echo $td_css_inline->get_inline_css() ?> class="test">
     * @return string
     */
    public function get_inline_css() {
        $buffy = $this->get_css_block();
        if (!empty($buffy)) {
            $buffy = 'style="' . $buffy . '"';
            return $buffy;
        }
        return '';
    }
}