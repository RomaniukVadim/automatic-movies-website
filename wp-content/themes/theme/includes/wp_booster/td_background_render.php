<?php
/**
 * Created by ra on 4/28/2015.
 */

class td_background_render {

    // here we store the background parameters
    private $background_parameters = array();



    function __construct($background_parameters) {

        // save a local copy
        $this->background_parameters = $background_parameters;

        // bg click ad
        td_js_buffer::add_variable('td_ad_background_click_link', stripslashes($this->background_parameters['td_ad_background_click_link'])); // the slashes are added by wp in the panel submit
        td_js_buffer::add_variable('td_ad_background_click_target', $this->background_parameters['td_ad_background_click_target']);


        // add the css if needed - the css knows about the stretched background!
        if ($this->background_parameters['theme_bg_image'] != '' or  $this->background_parameters['theme_bg_color'] != '') {
            td_css_buffer::add_to_header($this->add_css_custom_background());
        }

        // add the js if needed - needed only for stretch background
        if (!empty($this->background_parameters['theme_bg_image']) and $this->background_parameters['is_stretched_bg'] == true) {
            td_js_buffer::add_to_footer($this->add_js_hook());
        }

        // here we manipulate the body_class-es, we remove the WordPress ones and add our own + boxed version class
        add_filter('body_class', array($this,'add_slug_to_body_class'));
    }





    /**
     * we emulate the WordPress background function using our own setting
     * @return string - the new css
     */
    private function add_css_custom_background() {
        $css_array = array();

        //color handling
        if (!empty($this->background_parameters['theme_bg_color'])) {
            $css_array['background-color'] = $this->background_parameters['theme_bg_color'];
        }

        // image handling; if there is no image stretching
        if(!empty($this->background_parameters['theme_bg_image']) and $this->background_parameters['is_stretched_bg'] == false) {

            //add the image
            $css_array['background-image'] = 'url("' . $this->background_parameters['theme_bg_image'] . '")';

            //repeat image option
            switch ($this->background_parameters['theme_bg_repeat']) {
                case '':
                    $css_array['background-repeat'] = 'no-repeat';
                    break;

                case 'repeat':
                    //$css.= "\n" . 'background-repeat:repeat;';//default value `background-repeat`
                    break;

                case 'repeat-x':
                    $css_array['background-repeat'] = 'repeat-x';
                    break;

                case 'repeat-y':
                    $css_array['background-repeat'] = 'repeat-y';
                    break;
            }//end switch


            //position image option
            switch ($this->background_parameters['theme_bg_position']) {
                case '':
                    //$css.= "\n" . 'background-position:left top;';//default value `background-position`
                    break;

                case 'center':
                    $css_array['background-position'] = 'center top';
                    break;

                case 'right':
                    $css_array['background-position'] = 'right top';
                    break;
            }//end switch


            //background attachment options
            switch ($this->background_parameters['theme_bg_attachment']) {
                case '':
                    //$css.= "\n" . 'background-attachment:scroll;';//default value `background-attachment`
                    break;

                case 'fixed':
                    $css_array['background-attachment'] = 'fixed';
                    break;
            }//end switch
        }

        $td_css_inline = new td_css_inline();
        $td_css_inline->add_css($css_array);

        return $td_css_inline->get_css_for_selector('body');
    }



    //custom background js
    private function add_js_hook() {
            ob_start();
            // @todo chestia asta ar trebuii trecuta pe flag sau ceva in td_config ?
            ?>

            <script>

	            // if the theme has tdBackstr support, it means this already uses it
                if ( 'undefined' !== typeof window.tdBackstr ) {

                    (function(){
                        // the site background td-backstretch jquery object is dynamically added in DOM, and after any translation effects are applied over td-backstretch
                        var wrapper_image_jquery_obj = jQuery( '<div class=\'backstretch\'></div>' );
                        var image_jquery_obj = jQuery( '<img class=\'td-backstretch not-parallax\' src=\'<?php echo $this->background_parameters['theme_bg_image']; ?>\'>' );

                        wrapper_image_jquery_obj.append( image_jquery_obj );

                        jQuery( 'body' ).prepend( wrapper_image_jquery_obj );

                        var td_backstr_item = new tdBackstr.item();

                        td_backstr_item.wrapper_image_jquery_obj = wrapper_image_jquery_obj;
                        td_backstr_item.image_jquery_obj = image_jquery_obj;

	                    tdBackstr.add_item( td_backstr_item );

                    })();
                }

            </script>
            <?php
            $buffer = ob_get_clean();
            $js = "\n". td_util::remove_script_tag($buffer);
        return $js;
    }



    /**
     * Adds the boxed layout or full layout classes
     * @param $classes
     * @return array
     */
    function add_slug_to_body_class($classes) {
        if ($this->background_parameters['is_boxed_layout'] === true) {
            $classes[] = 'td-boxed-layout';

	        if ($this->background_parameters['td_ad_background_click_link'] != '') {
		        $classes[] = 'td-ad-background-link';
	        }
        } else {
            $classes[] = 'td-full-layout';
        }
        return $classes;
    }

}
