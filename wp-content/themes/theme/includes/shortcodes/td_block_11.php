<?php

/**
 * Class td_block_11
 */
class td_block_11 extends td_block {



    function render($atts, $content = null){
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        $buffy = ''; //output buffer

        //get the js for this block
        $buffy .= $this->get_block_js();

        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

            //get the block title
            $buffy .= $this->get_block_title();

            //get the sub category filter for this block
            $buffy .= $this->get_pull_down_filter();

            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
                $buffy .= $this->inner($this->td_query->posts); //inner content of the block
            $buffy .= '</div>';

            //get the ajax pagination for this block
            $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {

        $buffy = '';
        $td_block_layout = new td_block_layout();

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $td_module_10 = new td_module_10($post);

                $buffy .= $td_block_layout->open12(); //added in 010 theme - span 12 doesn't use rows
                    $buffy .= $td_module_10->render($post);
                $buffy .= $td_block_layout->close12();
            }
        }
        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}
