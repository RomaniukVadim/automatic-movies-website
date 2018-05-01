<?php

/**
 * related posts block, used on single post template to show the related posts by tag author etc.
 * @see td_module_single::related_posts
 */
class td_block_related_posts extends td_block {


    function render($atts, $content = null) {


        if (td_util::get_option('tds_similar_articles_type') == 'by_tag') {
            $current_post_tags = wp_get_post_tags(get_the_ID());

            if (empty($current_post_tags)) {
                return '';
            }
        }


        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        // this block need td_column_number to add rows if more posts are displayed on a post.
        /// the td_column_number is not standard here, it's    5 for full width / 3 for content + sidebar
        extract(shortcode_atts(
                array(
                    'td_column_number' => ''
                ), $atts));


        // we have no related posts to display
        if ($this->td_query->post_count == 0) {
            return;
        }


        $buffy = ''; //output buffer

        //get the js for this block
        $buffy .= $this->get_block_js();

        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

        //get the filter for this block
        $buffy .= '<h4 class="td-related-title">';
            $buffy .= '<a id="' . td_global::td_generate_unique_id() . '" class="td-related-left td-cur-simple-item" data-td_filter_value="" data-td_block_id="' . $this->block_uid . '" href="#">' . __td('RELATED ARTICLES', TD_THEME_NAME) . '</a>';
            $buffy .= '<a id="' . td_global::td_generate_unique_id() . '" class="td-related-right" data-td_filter_value="td_related_more_from_author" data-td_block_id="' . $this->block_uid . '" href="#">' . __td('MORE FROM AUTHOR', TD_THEME_NAME) . '</a>';
        $buffy .= '</h4>';

        $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
        $buffy .= $this->inner($this->td_query->posts, $td_column_number);  //inner content of the block
        $buffy .= '</div>';

        //get the ajax pagination for this block
        $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {


        $td_block_layout = new td_block_layout();
        $td_block_layout->row_class = 'td-related-row';
        $td_block_layout->span4_class = 'td-related-span4';


        $buffy = '';




        $td_current_column = 1; //the current column

        if (!empty($posts)) {
            foreach ($posts as $td_post_count => $post) {

                $td_module_related_posts = new td_module_related_posts($post);



                switch ($td_column_number) {
                    case '3': //the layout when we are on content + sidebar

                        $buffy .= $td_block_layout->open_row();
                        $buffy .= $td_block_layout->open4();
                        $buffy .= $td_module_related_posts->render();
                        $buffy .= $td_block_layout->close4();

                        if ($td_current_column == 3) {
                            $buffy .= $td_block_layout->close_row();
                        }

                        break;

                    case '5': //the layout when we are on


                        $buffy .= $td_block_layout->open_row();
                        $buffy .= $td_block_layout->open4();
                        $buffy .= $td_module_related_posts->render();
                        $buffy .= $td_block_layout->close4();

                        if ($td_current_column == 5) {
                            $buffy .= $td_block_layout->close_row();
                        }

                        break;
                }


                //current column
                if ($td_current_column == $td_column_number) {
                    $td_current_column = 1;
                } else {
                    $td_current_column++;
                }
            } //end for each



        }

        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;

    }
}

