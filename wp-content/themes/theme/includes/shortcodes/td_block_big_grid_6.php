<?php

/**
 *
 * Class td_block_big_grid_6
 */
class td_block_big_grid_6 extends td_block {

    const POST_LIMIT = 7;

    function render($atts, $content = null){

        // for big grids, extract the td_grid_style
        extract(shortcode_atts(
            array(
                'td_grid_style' => 'td-grid-style-1'
            ), $atts));


        $atts['limit'] = self::POST_LIMIT;

        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)


        $buffy = '';

        $buffy .= '<div class="' . $this->get_block_classes(array($td_grid_style, 'td-hover-1')) . '" ' . $this->get_block_html_atts() . '>';
            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
                $buffy .= $this->inner($this->td_query->posts); //inner content of the block
                $buffy .= '<div class="clearfix"></div>';
            $buffy .= '</div>';
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts) {

        $buffy = '';

            $td_block_layout = new td_block_layout();

            if (!empty($posts)) {

                $buffy .= '<div class="td-big-grid-wrapper">';

                $post_count = 0;

	            // when 2 posts make post scroll full
	            $td_scroll_posts = '';
	            if (count($posts) == 3) {
		            $td_scroll_posts = ' td-scroll-full';
	            }

                foreach ($posts as $post) {

	                if ($post_count == 2) {
		                $buffy .= '<div class="td-big-grid-scroll' . $td_scroll_posts . '">';
	                }

                    if ($post_count < 2) {
                        $td_module_mx5 = new td_module_mx5($post);
                        $buffy .= $td_module_mx5->render($post_count);

                        $post_count++;
                        continue;
                    }

                    $td_module_mx13 = new td_module_mx13($post);
                    $buffy .= $td_module_mx13->render($post_count);

                    $post_count++;
                }

                if ($post_count < self::POST_LIMIT) {

                    for ($i = $post_count; $i < self::POST_LIMIT; $i++) {

                        $td_module_mx_empty = new td_module_mx_empty();
                        $buffy .= $td_module_mx_empty->render($i);
                    }
                }

	            if($post_count >= 3) {
		            $buffy .= '</div>';  // close td-big-grid-scroll
	            }
	            $buffy .= '</div>'; // close td-big-grid-wrapper
            }

            $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}