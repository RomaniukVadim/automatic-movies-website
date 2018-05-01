<?php


class td_smart_list_mob_1 extends td_smart_list {

    protected $use_pagination = true; // set this to true to use rela pagination on this template


    protected function render_before_list_wrap() {
        if(td_global::$cur_single_template_sidebar_pos == 'no_sidebar') {
            $td_class_nr_of_columns = ' td-3-columns ';
        } else {
            $td_class_nr_of_columns = ' td-2-columns ';
        }

        $buffy = '';

        //wrapper with id for smart list wrapper type 1
        $buffy .= '<div class="tdm_smart_list_1' . $td_class_nr_of_columns . '">';

        return $buffy;
    }


    protected function render_list_item($item_array, $current_item_id, $current_item_number, $total_items_number) {
        //print_r($item_array);
        $buffy = '';

        // render the pagination
        $buffy .= $this->callback_render_pagination();

        //creating each slide
        $buffy .= '<div class="td-item">';
        $buffy .= '<h2 class="td-sml-top-tile"><span class="td-sml-current-item-title">' . $current_item_number. '. ' . $item_array['title'] . '</span></h2>';

        //get image info
        $first_img_all_info = td_util::attachment_get_full_info($item_array['first_img_id']);

        //image caption
        $first_img_caption = $item_array['first_img_caption'];

        // image
        $first_img_info = wp_get_attachment_image_src($item_array['first_img_id'], 'td_696x0');

        if (!empty($first_img_info[0])) {

            // if a custom link is set use it
            if (!empty($item_array['first_img_link']) && $first_img_all_info['src'] != $item_array['first_img_link']) {
                $first_img_all_info['src'] = $item_array['first_img_link'];
            }

            $buffy .= '
                            <figure class="td-slide-smart-list-figure td-slide-smart-list-1">
                                <a class="td-sml-link-to-image" href="' . $first_img_all_info['src'] . '" data-caption="' . esc_attr($first_img_caption, ENT_QUOTES) . '">
                                    <img src="' . $first_img_info[0] . '"/>
                                </a>
                                <figcaption class="td-sml-caption"><div>' . $first_img_caption . '</div></figcaption>
                            </figure>';
        }

        // ad smart list mobile
        $buffy .= td_global_blocks::get_instance('td_block_ad_box_mob')->render(array('spot_id' => 'smart_list_mob'));

        //adding description
        if(!empty($item_array['description'])) {
            $buffy .= '<span class="td-sml-description">' . $item_array['description'] . '</span>';
        }

        // render the pagination
        $buffy .= $this->callback_render_pagination();

        $buffy .= '</div>';

        return $buffy;
    }



    protected function render_after_list_wrap() {
        $buffy = '';
        $buffy .= '</div>'; // /.td_smart_list_1  wrapper with id

        return $buffy;
    }






}