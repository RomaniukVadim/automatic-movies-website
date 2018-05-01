<?php


class td_smart_list_3 extends td_smart_list {
    //holds the unique id of current smart list slide
    private $smart_list_tip_3_unique_id;

    //holds the code for the slide controls (Prev and Next)
    private $slide_controls;

    private $nr_slide_on_smart_list = 0;



    protected function render_before_list_wrap() {
        $buffy = '';

        if(td_global::$cur_single_template_sidebar_pos == 'no_sidebar') {
            $td_class_nr_of_columns = ' td-3-columns ';
        } else {
            $td_class_nr_of_columns = ' td-2-columns ';
        }

        //the controls
        $this->slide_controls = '<a class="td-left-smart-list doubleSliderPrevButton" href="#" onclick="return false;"><i class = "td-icon-left"></i>' .  __td('Prev', TD_THEME_NAME). '</a><a class="td-right-smart-list doubleSliderNextButton" href="#" onclick="return false;">' .  __td('Next', TD_THEME_NAME). '<i class = "td-icon-right"></i></a>';

        //generate unique gallery slider id
        $this->smart_list_tip_3_unique_id = 'smart_list_tip3_' . td_global::td_generate_unique_id();



        //wrapper with id for smart list wrapper type 3
        $buffy .= '<div class="td_smart_list_3 ' . $td_class_nr_of_columns . '">';

            //top controls
            $buffy .= '<div class="td-controls">' . $this->slide_controls . '</div>';

            //beginning of the slider
            $buffy .= '<div class="td-iosSlider td-smart-list-slider" id="' . $this->smart_list_tip_3_unique_id. '">';
                $buffy .= '<div class = "td-slider">';


        return $buffy;
    }


    protected function render_list_item($item_array, $current_item_id, $current_item_number, $total_items_number) {
        $buffy = '';

        //get the title
        $smart_list_3_title = '';
        if(!empty($item_array['title'])) {
            $smart_list_3_title = $item_array['title'];
        }

        //creating each slide
        $buffy .= '<div class="td-item" id="' . $this->smart_list_tip_3_unique_id . '_item_' . $current_item_id . '">';
            $buffy .= '<div class="td-number-and-title"><h2><span class="td-sml-current-item-nr">' . $current_item_number. '</span><span class="td-sml-current-item-title">' . $smart_list_3_title . '</span></h2></div>';

            //get image info
            $first_img_all_info = td_util::attachment_get_full_info($item_array['first_img_id']);

            //get image link target
            $first_img_link_target = $item_array['first_img_link_target'];

            //image caption
            $first_img_caption = $item_array['first_img_caption'];

            $first_img_info = wp_get_attachment_image_src($item_array['first_img_id'], 'medium');

            //image and caption
            $buffy_image = '';
            if (!empty($first_img_info[0])) {

                // class used by magnific popup
                $smart_list_lightbox = " td-lightbox-enabled";

                // if a custom link is set use it
                if (!empty($item_array['first_img_link']) && $first_img_all_info['src'] != $item_array['first_img_link']) {
                    $first_img_all_info['src'] = $item_array['first_img_link'];

                    // remove the magnific popup class for custom links
                    $smart_list_lightbox = "";
                }

                $buffy_image = '
                           <figure class="td-sml3-display-image td-slide-smart-list-figure' . $smart_list_lightbox . '">
                                <a class="td-sml-link-to-image" href="' . $first_img_all_info['src'] . '" id="td-sml3-slide_' . $this->nr_slide_on_smart_list . '" data-caption="' . esc_attr($first_img_caption, ENT_QUOTES) . '" ' . $first_img_link_target . ' >
                                    <img src="' . $first_img_info[0] . '"/>
                                </a>
                                <figcaption class="td-sml-caption"><div>' . $first_img_caption . '</div></figcaption>
                           </figure>';
            }

            if(!empty($item_array['description'])) {

                $buffy .= '<div class="td-sml-description">' . $buffy_image . $item_array['description'] . '</div>';
            }


        $buffy .= '</div>';

        $this->nr_slide_on_smart_list++;

        return $buffy;

    }


    protected function render_after_list_wrap() {
        $buffy = '';

                $buffy .= '</div>';
            $buffy .= '</div>'; // end ios slider
            $buffy .= '<div class="td-sml3-bottom-controls">' . $this->slide_controls . '</div>';//bottom controls
        $buffy .= '</div>'; //.td_smart_list_3  wrapper with id



        // @todo fix the moving from left to right from the controls, now the slide only works from right to left,
        td_js_buffer::add_to_footer('
jQuery(document).ready(function() {
    jQuery("#' . $this->smart_list_tip_3_unique_id . '").iosSlider({
        snapToChildren: true,
        desktopClickDrag: true,
        keyboardControls: false,
        infiniteSlider: true,
        navPrevSelector: jQuery(".td_smart_list_3 .doubleSliderPrevButton"),
        navNextSelector: jQuery(".td_smart_list_3 .doubleSliderNextButton"),
        startAtSlide:td_history.get_current_page("slide"),
        onSliderLoaded : td_resize_smartlist_slides,
		onSliderResize : td_resize_smartlist_sliders_and_update,
		onSlideChange : td_resize_smartlist_slides,
		onSlideComplete : td_history.slide_changed_callback
    });


    // add current page history
    td_history.replace_history_entry({current_slide:td_history.get_current_page("slide"), slide_id:"' . $this->smart_list_tip_3_unique_id . '"});

});
    ');

        return $buffy;
    }
}