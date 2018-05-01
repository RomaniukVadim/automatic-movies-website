<?php

class td_ajax_mob {

    // modify the module used on search
    static function on_ajax_search() {

	    $buffy = '';
        $buffy_msg = '';

        //the search string
        if (!empty($_POST['td_string'])) {
            $td_string = $_POST['td_string'];
        } else {
            $td_string = '';
        }

        //get the data
        $td_query = &td_data_source::get_wp_query_search($td_string); //by ref  do the query

        //build the results
        if (!empty($td_query->posts)) {

	        foreach ($td_query->posts as $post) {
                $td_module_mob_1 = new td_module_mob_1($post);
                $buffy .= $td_module_mob_1->render();
            }
        }

        if (count($td_query->posts) == 0) {
            //no results
            $buffy = '<div class="result-msg no-result">' . __td('No results', TD_THEME_NAME) . '</div>';
        } else {
            //show the resutls
            /**
             * @note:
             * we use esc_url(home_url( '/' )) instead of the WordPress @see get_search_link function because that's what the internal
             * WordPress widget it's using and it was creating duplicate links like: yoursite.com/search/search_query and yoursite.com?s=search_query
             *
             * also note that esc_url - as of today strips spaces (WTF) https://core.trac.wordpress.org/ticket/23605 so we used urlencode - to encode the query param with + instead of %20 as rawurlencode does
             */

            $buffy_msg .= '<div class="result-msg"><a href="' . home_url('/?s=' . urlencode($td_string )) . '">' . __td('View all results', TD_THEME_NAME) . '</a></div>';
            //add wrap
            $buffy = '<div class="td-aj-search-results">' . $buffy . '</div>' . $buffy_msg;
        }

        //prepare array for ajax
        $buffyArray = array(
            'td_data' => $buffy,
            'td_total_results' => 2,
            'td_total_in_list' => count($td_query->posts),
            'td_search_query'=> $td_string
        );

        // Return the String
        die(json_encode($buffyArray));
    }
}