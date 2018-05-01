<?php

/**
 * related posts block, used on single post template to show the related posts by tag author etc.
 * @see td_module_single::related_posts
 */
class td_block_related_posts_mob extends td_block {


    function render($atts, $content = null) {

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

        $buffy .= '<div class="' . $this->get_block_classes() . '">';

        //get the filter for this block
        $buffy .= '<h4 class="td-related-title">';
            $buffy .= '<a id="' . td_global::td_generate_unique_id() . '" class="td-related-left td-cur-simple-item" data-td_filter_value="" data-td_block_id="' . $this->block_uid . '" href="#">' . __td('RELATED ARTICLES', TD_THEME_NAME) . '</a>';
        $buffy .= '</h4>';

        $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
        $buffy .= $this->inner($this->td_query->posts, $td_column_number);  //inner content of the block
        $buffy .= '</div>';

        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {


        $td_block_layout = new td_block_layout();
        $td_block_layout->row_class = 'td-related-row';
        $td_block_layout->span4_class = 'td-related-span4';


        $buffy = '';

        if (!empty($posts)) {
            foreach ($posts as $td_post_count => $post) {

                $td_module_related_posts = new td_module_mob_1($post);

                        $buffy .= $td_block_layout->open_row();
                        $buffy .= $td_block_layout->open4();
                        $buffy .= $td_module_related_posts->render();
                        $buffy .= $td_block_layout->close4();


            } //end for each
        }

        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;

    }
}

