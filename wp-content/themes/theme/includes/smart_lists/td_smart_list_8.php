<?php


class td_smart_list_8 extends td_smart_list {

    protected $use_pagination = true; // set this to true to use rela pagination on this template


    protected function render_before_list_wrap() {
        if(td_global::$cur_single_template_sidebar_pos == 'no_sidebar') {
            $td_class_nr_of_columns = ' td-3-columns ';
        } else {
            $td_class_nr_of_columns = ' td-2-columns ';
        }

        $buffy = '';

        //wrapper with id for smart list wrapper type 2
        $buffy .= '<div class="td_smart_list_8' . $td_class_nr_of_columns . '">';

        return $buffy;
    }


    protected function render_list_item($item_array, $current_item_id, $current_item_number, $total_items_number) {
        //print_r($item_array);
        $buffy = '';

        // render the pagination
        $buffy .= $this->callback_render_drop_down_pagination();

        // ad smart list 8
        $buffy .= td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'smart_list_8'));

        //creating each slide
        $buffy .= '<div class="td-item">';
        $buffy .= '<div class="td-number-and-title"><h2><span class="td-sml-current-item-title">' . $item_array['title'] . '</span></h2></div>';

        //adding description
        if(!empty($item_array['description'])) {
            $buffy .= '<span class="td-sml-description">' . $item_array['description'] . '</span>';
        }

        $buffy .= '</div>';

        // render the pagination
        $buffy .= $this->callback_render_drop_down_pagination();



        return $buffy;
    }



    protected function render_after_list_wrap() {
        $buffy = '';
        $buffy .= '</div>'; // /.td_smart_list_8  wrapper with id

        return $buffy;
    }






}