<?php
// v3 - for wp_010 from block 3

class td_block_trending_now extends td_block {


    function render($atts, $content = null) {
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        $buffy = ''; //output buffer


	    $additional_classes = array();


        // style 2
        if(!empty($atts['style'])) {
	        $additional_classes []= 'td-pb-full-cell';
	        $additional_classes []= 'td-trending-style2';
        }

        //get the js for this block
        $buffy .= $this->get_block_js();

        $buffy .= '<div class="' . $this->get_block_classes($additional_classes) . '" ' . $this->get_block_html_atts() . '>';

            //get the sub category filter for this block
            //$buffy .= $this->get_pull_down_filter();

            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';

                $buffy .= $this->inner($this->td_query->posts, '' , $atts);  //inner content of the block

            $buffy .= '</div>';

            //get the ajax pagination for this block
            $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '', $atts = array()) {

        $buffy = '';
        $navigation = '';

        if (!empty($atts['navigation'])) {
            $navigation = $atts['navigation'];
        }

        $td_block_layout = new td_block_layout();

        if (!empty($posts)) {

            $buffy .= $td_block_layout->open_row();

            $trending_now_unique_id = td_global::td_generate_unique_id();//generate unique id for this object

            $buffy .= '<div class="td-trending-now-wrapper" id="' . $trending_now_unique_id . '" data-start="' . esc_attr($navigation) . '">';
                $buffy .= '<div class="td-trending-now-title">' . __td('Trending Now', TD_THEME_NAME) . '</div><div class="td-trending-now-display-area">';

                foreach ($posts as $post_count => $post) {

                    $td_module_trending_now = new td_module_trending_now($post);

                    $buffy .= $td_module_trending_now->render($post_count);
                }

                $buffy .= '</div>';

                $buffy .= '<div class="td-next-prev-wrap">';
                    $buffy .= '<a href="#"
                                  class="td_ajax-prev-pagex td-trending-now-nav-left"
                                  data-wrapper-id="' . $trending_now_unique_id . '"
                                  data-moving="left"
                                  data-control-start="' . $navigation . '"><i class="td-icon-menu-left"></i></a>';

                    $buffy .= '<a href="#"
                                  class="td_ajax-next-pagex td-trending-now-nav-right"
                                  data-wrapper-id="' . $trending_now_unique_id . '"
                                  data-moving="right"
                                  data-control-start="' . $navigation . '"><i class="td-icon-menu-right"></i></a>';
                $buffy .= '</div>';
            $buffy .= '</div>';

            $buffy .= $td_block_layout->close_row();
        }

        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}