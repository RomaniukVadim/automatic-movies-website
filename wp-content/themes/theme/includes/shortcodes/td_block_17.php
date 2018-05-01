<?php

class td_block_17 extends td_block {


    function render($atts, $content = null){
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        if (empty($td_column_number)) {
            $td_column_number = td_util::vc_get_column_number(); // get the column width of the block from the page builder API
        }

        $buffy = ''; //output buffer


        //get the js for this block
        $buffy .= $this->get_block_js();

        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

        //get the block title
        $buffy .= $this->get_block_title();

        //get the sub category filter for this block
        $buffy .= $this->get_pull_down_filter();

        $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner td-column-' . $td_column_number . '">';
        $buffy .= $this->inner($this->td_query->posts, $td_column_number); //inner content of the block
        $buffy .= '</div>';

        //get the ajax pagination for this block
        $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {

        $buffy = '';

        $td_block_layout = new td_block_layout();
        $td_post_count = 0; // the number of posts rendered


        if (!empty($posts)) {
            foreach ($posts as $post) {

                $td_module_4 = new td_module_4($post);
                $td_module_8 = new td_module_8($post);

                switch ($td_column_number) {

                    case '1': //one column layout
                        $buffy .= $td_block_layout->open12(); //added in 010 theme - span 12 doesn't use rows
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_module_4->render();
                        } else {
                            $buffy .= $td_module_8->render();
                        }
                        $buffy .= $td_block_layout->close12();
                        break;

                    case '2': //two column layout
                        $buffy .= $td_block_layout->open_row();
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_block_layout->open6();
                            $buffy .= $td_module_4->render();
                            $buffy .= $td_block_layout->close6();
                        } else { //the rest
                            $buffy .= $td_block_layout->open6();
                            $buffy .= $td_module_8->render();
                        }
                        break;

                    case '3': //three column layout
                        $buffy .= $td_block_layout->open_row();
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_block_layout->open4();
                            $buffy .= $td_module_4->render();
                            $buffy .= $td_block_layout->close4();
                        } else { //2-3 cols
                            $buffy .= $td_block_layout->open4();
                            $buffy .= $td_module_8->render();

                            if ($td_post_count == 4) { //make new column
                                $buffy .= $td_block_layout->close4();
                            }
                        }
                        break;
                }
                $td_post_count++;
            }
        }
        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}