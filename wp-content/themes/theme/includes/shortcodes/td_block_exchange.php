<?php

class td_block_exchange extends td_block {



	/**
	 * Disable loop block features. This block does not use a loop and it dosn't need to run a query.
	 */
	function __construct() {
		parent::disable_loop_block_features();
	}



    function render($atts, $content = null) {

        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        if (empty($td_column_number)) {
            $td_column_number = td_util::vc_get_column_number(); // get the column width of the block from the page builder API
        }

        $buffy = ''; //output buffer
        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';
            //get the block title
            $buffy .= $this->get_block_title();
            $buffy .= '<div id=' . $this->block_uid . ' class="td-exchange-wrap td_block_inner td-column-' . $td_column_number . '">';
                $buffy.= td_exchange::render_generic($atts);
            $buffy .= '</div>';
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }


}