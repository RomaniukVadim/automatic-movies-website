<?php


/**
 * @todo remove this hack - this view has to be rebuilt
 */
$td_panel_custom_typography_ajax = new td_panel_custom_typography_ajax();
echo $td_panel_custom_typography_ajax->td_custom_typology_generate_font_controls();


class td_panel_custom_typography_ajax {

    //class variable
    var $td_typology_fonts_array;
    var $td_font_size_list;
    var $td_line_height_list;
    var $td_font_style_list;
    var $td_font_weight;
    var $td_text_transform;

    function __construct($post = '') {

        //create typology_fonts_array
        $this->td_typology_fonts_array = $this->td_create_custom_typology_fonts_array();

        //create font_size_list
        $this->td_font_size_list = $this->get_font_size_list();

        //create line_height_list
        $this->td_line_height_list = $this->get_line_height_list();

        //create font_style_list
        $this->td_font_style_list = $this->get_td_font_style_list();

        //create font_style_list
        $this->td_font_weight = $this->get_td_font_weight();

        //create text_transform
        $this->td_text_transform = $this->get_td_text_transform();
    }


    /**
     * create fonts array for pulldown control
     * param an array in format: id => value
     *
     * return array   in format:
     *       array(
     *           array('text' => 'value', 'val' => 'id'),
     *           .................
     *       )
     *
     * */
    public function td_create_custom_typology_fonts_array() {
        $buffy = $user_fonts = array();

        $buffy[] = array('text' => 'Default font', 'val' => '');

        //read the user fonts array
        if(!empty(td_global::$td_options['td_fonts_user_inserted'])) {

            $user_fonts = td_global::$td_options['td_fonts_user_inserted'];


            //custom font links & typekit
            foreach($user_fonts as $key_font => $value_font){

                //look for the field number
                $revers_key_font = strrev($key_font);
                $explode_key_font = explode('_', $revers_key_font);
                $fld_number = intval($explode_key_font[0]);

                //add custom user fonts links    (numaratoare incepe de la 1)
                if(substr($key_font, 0, 10) == 'font_file_') {
                    $font_family_field_nr = 'font_family_' . $fld_number;

                    if(!empty($user_fonts['font_file_' . $fld_number]) and !empty($user_fonts[$font_family_field_nr])) {
                        $buffy[] = array('text' => $user_fonts[$font_family_field_nr], 'val' => 'file_' . $fld_number );
                    }

                    //add tipekit fonts                  (numaratoare incepe de la 1)
                } elseif(substr($key_font, 0, 21) == 'type_kit_font_family_') {
                    $type_kit_font_family_field_nr = 'type_kit_font_family_' . $fld_number;

                    if(!empty($user_fonts[$type_kit_font_family_field_nr])) {
                        $buffy[] = array('text' => $user_fonts[$type_kit_font_family_field_nr], 'val' => 'tk_' . $fld_number);
                    }
                }

            }
        }


        //fonts stack
        foreach(td_fonts::$font_stack_list as $key_fs_id => $key_fs_value) {
            $buffy[] = array('text' => $key_fs_value, 'val' => $key_fs_id);
        }



        //google fonts
        foreach(td_fonts::$font_names_google_list as $key_id => $key_value) {
            $buffy[] = array('text' => $key_value, 'val' => 'g_' . $key_id);
        }

        return $buffy;
    }


    /**
     * create the list of font sizes
     *
     * @return array   in format:
     *       array(
     *           array('text' => 'value', 'val' => 'id'),
     *           .................
     *       )
     *
     */
    public function get_font_size_list() {
        $buffy_font_size[0] = array('text' => 'Default size', 'val' => '' );

        for ($i = 5; $i <= 90; $i++) {
            $buffy_font_size[] = array('text' => $i . 'px', 'val' => $i . 'px');
        }

        return $buffy_font_size;
    }


    /**
     * create the list of font sizes
     *
     * @return array   in format:
     *       array(
     *           array('text' => 'value', 'val' => 'id'),
     *           .................
     *       )
     *
     */
    public function get_line_height_list() {
        $buffy_line_height[0] = array('text' => 'Default line height', 'val' =>'');

        for ($i = 5; $i <= 90; $i++) {
            $buffy_line_height[$i] = array('text' => $i . 'px', 'val' => $i . 'px');
        }

        return $buffy_line_height;
    }


    /**
     * create the list with font styles
     *
     * @return array   in format:
     *       array(
     *           array('text' => 'value', 'val' => 'id'),
     *           .................
     *       )
     *
     */
    public function get_td_font_style_list() {
        $buffy_font_style[] = array('text' => 'Default font style', 'val' =>'');
        $buffy_font_style[] = array('text' => 'Italic', 'val' =>'italic');
        $buffy_font_style[] = array('text' => 'Oblique', 'val' =>'oblique');
        $buffy_font_style[] = array('text' => 'Normal (Remove italic)', 'val' =>'normal');
        return $buffy_font_style;
    }



    /**
     * create the list with font weight
     *
     * @return array   in format:
     *       array(
     *           array('text' => 'value', 'val' => 'id'),
     *           .................
     *       )
     *
     */
    public function get_td_font_weight() {
        $buffy_font_weight[0] = array('text' => 'Default font weight', 'val' => '');
        $buffy_font_weight[1] = array('text' => 'Normal', 'val' => 'normal');
        $buffy_font_weight[2] = array('text' => 'Bold', 'val' => 'bold');

        return $buffy_font_weight;
    }


    /**
     * create the text transform list
     *
     * @return array   in format:
     *       array(
     *           array('text' => 'value', 'val' => 'id'),
     *           .................
     *       )
     *
     */
    public function get_td_text_transform() {
        $buffy_text_transform[] = array('text' => 'Default text transform', 'val' => '');
        $buffy_text_transform[] = array('text' => 'Uppercase', 'val' => 'uppercase');
        $buffy_text_transform[] = array('text' => 'Capitalize', 'val' => 'capitalize');
        $buffy_text_transform[] = array('text' => 'Lowercase', 'val' => 'lowercase');
        $buffy_text_transform[] = array('text' => 'None (normal text)', 'val' => 'none');




        return $buffy_text_transform;
    }



    //creates the block with controls
    public function td_custom_typology_generate_font_controls() {

        ob_start();

        //get the sections start and end
        $section_name = td_util::get_http_post_val('section_name');

	    ?>
		<div class="td-panel-fonts-header">
		    <div class="td-panel-font-description td-panel-font-family">Font family</div>
			<div class="td-panel-font-description td-panel-font-size">Size</div>
		    <div class="td-panel-font-description td-panel-font-line-height">Line height</div>
		    <div class="td-panel-font-description td-panel-font-style">Style</div>
		    <div class="td-panel-font-description td-panel-font-weight">Weight</div>
		    <div class="td-panel-font-description td-panel-font-transform">Transform</div>
		</div>
	    <?php

        foreach(td_global::$typography_settings_list[$section_name] as $font_setting_id => $font_setting) {

                ?>
                <div class="td-box-row td-panel-font-typography">
	                <div class="td-box-description">

	                    <span class="td-box-title td-title-on-row">
		                    <?php echo $font_setting['text']; ?>
	                    </span>
	                </div>
	                <div class="td-box-control-full">

		                <div class="td-panel-font-family">
			                <?php
			                echo td_panel_generator::dropdown(array(
				                'ds' => 'td_fonts',
				                'item_id' => $font_setting_id,
				                'option_id' => 'font_family',
				                'values' => $this->td_typology_fonts_array
			                ));
			                ?>
		                </div>

	                    <?php if ($font_setting['type'] != 'general_setting') { ?>

		                    <div class="td-panel-font-size">
			                    <?php
		                        echo td_panel_generator::dropdown(array(
		                            'ds' => 'td_fonts',
		                            'item_id' => $font_setting_id,
		                            'option_id' => 'font_size',
		                            'values' => $this->td_font_size_list
		                        ));
		                        ?>
		                    </div>
		                    <div class="td-panel-font-line-height">
		                        <?php
		                        echo td_panel_generator::dropdown(array(
		                            'ds' => 'td_fonts',
		                            'item_id' => $font_setting_id,
		                            'option_id' => 'line_height',
		                            'values' => $this->td_line_height_list
		                        ));
		                        ?>
		                    </div>
		                    <div class="td-panel-font-style">
		                        <?php
		                        echo td_panel_generator::dropdown(array(
		                            'ds' => 'td_fonts',
		                            'item_id' => $font_setting_id,
		                            'option_id' => 'font_style',
		                            'values' => $this->td_font_style_list
		                        ));
		                        ?>
		                    </div>
		                    <div class="td-panel-font-weight">
		                        <?php
		                        echo td_panel_generator::dropdown(array(
		                            'ds' => 'td_fonts',
		                            'item_id' => $font_setting_id,
		                            'option_id' => 'font_weight',
		                            'values' => $this->td_font_weight
		                        ));
		                        ?>
		                    </div>
		                    <div class="td-panel-font-transform">
		                        <?php
		                        echo td_panel_generator::dropdown(array(
		                            'ds' => 'td_fonts',
		                            'item_id' => $font_setting_id,
		                            'option_id' => 'text_transform',
		                            'values' => $this->td_text_transform
		                        ));
		                        ?>
		                    </div>

	                    <?php } ?>

	                </div>
                </div><?php
        }//end foreach

        return ob_get_clean();

    }

}//end class