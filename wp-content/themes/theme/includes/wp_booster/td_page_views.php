<?php
class td_page_views {


    static $post_view_counter_key = 'post_views_count';

    //the name of the field where 7 days counter are kept(in a serialized array) for the given post
    private static $post_view_counter_7_day_array = 'post_views_count_7_day_arr';

    //the name of the field for the total of 7 days
    static $post_view_counter_7_day_total = 'post_views_count_7_day_total';

    //the name of the field for the 7 days last page view - used on td_data_source to filter the posts with views older than 7 days
    static $post_view_counter_7_day_last_date = 'post_views_count_7_day_last_date';

    private static $post_view_7days_last_day = 'post_view_7days_last_day';


    //used only in single.php to update the views
    static function update_page_views($postID) {
        if (td_util::get_option('tds_p_show_views') == 'hide') {
            return;
        }

        global $page;

        //$page == 1 - fix for yoast
        if (is_single() and (empty($page) or $page == 1)) {  //do not update the counter only on single posts that are on the first page of the post
            //use general single page count only when `ajax_post_view_count` is disabled
            if(td_util::get_option('tds_ajax_post_view_count') != 'enabled') {
                //used for general count
                $count = get_post_meta($postID, self::$post_view_counter_key, true);
                if ($count == ''){
                    update_post_meta($postID, self::$post_view_counter_key, 1);
                } else {
                    $count++;
                    update_post_meta($postID, self::$post_view_counter_key, $count);
                }
            }

            //stop here if
            if (td_util::get_option('tds_p_enable_7_days_count') != 'enabled') {
                return;
            }

            //debug - reset array
            //update_post_meta($postID, self::$post_view_counter_7_day_array, array());

            //used for 7 day count array
            $current_day = date("N") - 1;  //get the current day
            $current_date = date("U"); //get the current Unix date
            $count_7_day_array = get_post_meta($postID, self::$post_view_counter_7_day_array, true);  // get the array with day of week -> count


            //check if the first entry is an array (used to detect and reset the older themes array)
            if (is_array($count_7_day_array) && is_array($count_7_day_array[0])) {


                if (isset($count_7_day_array[$current_day])) { // check to see if the current day is defined - if it's not defined it's not ok.

                    //check if the current day matches the 'date' key inside the count_7_day array
                    $current_day_of_the_year = date('z', $current_date);
                    $count_7_day_of_the_year = date('z', $count_7_day_array[$current_day]['date']);
                    if (get_post_meta($postID, self::$post_view_7days_last_day, true) == $current_day && $count_7_day_of_the_year == $current_day_of_the_year) {
                        //the day was not changed since the last update - increment the count
                        $count_7_day_array[$current_day]['count']++;
                    } else {
                        //the day was changed since the last update - reset the current day
                        $count_7_day_array[$current_day]['count'] = 1;
                        //set the current date
                        $count_7_day_array[$current_day]['date'] = $current_date;

                        //reset old entries inside the 7 days array (older than 7 days)
                        $one_week_ago = $current_date - 604800;
                        foreach ($count_7_day_array as $day => $parameters) {
                            if ($parameters['date'] < $one_week_ago) {
                                $count_7_day_array[$day] = array('date' => 0, 'count' => 0);
                            }
                        }

                        //update last day with the current day
                        update_post_meta($postID, self::$post_view_7days_last_day, $current_day);

                        //update last date with the current date - it only updates once when the day changes
                        update_post_meta($postID, self::$post_view_counter_7_day_last_date, $current_date);
                    }

                    //update the array
                    update_post_meta($postID, self::$post_view_counter_7_day_array, $count_7_day_array);

                    //sum the 7days total count
                    $sum_7_day_count = 0;
                    foreach ($count_7_day_array as $day => $parameters){
                        $sum_7_day_count += $parameters['count'];
                    }
                    update_post_meta($postID, self::$post_view_counter_7_day_total, $sum_7_day_count);
                }

            } else {
                //the array is not initialized
                $count_7_day_array = array(
                    0 => array('date' => 0, 'count' => 0),
                    1 => array('date' => 0, 'count' => 0),
                    2 => array('date' => 0, 'count' => 0),
                    3 => array('date' => 0, 'count' => 0),
                    4 => array('date' => 0, 'count' => 0),
                    5 => array('date' => 0, 'count' => 0),
                    6 => array('date' => 0, 'count' => 0)
                );
                $count_7_day_array[$current_day]['count'] = 1; // add one view on the current day
                $count_7_day_array[$current_day]['date'] = $current_date; //set the current date

                //update the array
                update_post_meta($postID, self::$post_view_counter_7_day_array, $count_7_day_array);

                //update last day with the current day
                update_post_meta($postID, self::$post_view_7days_last_day, $current_day);

                //update last date with the current date
                update_post_meta($postID, self::$post_view_counter_7_day_last_date, $current_date);

                //update the 7 days total - 1 view :)
                update_post_meta($postID, self::$post_view_counter_7_day_total, 1);
            }


            // debug
            //update_post_meta($postID, self::$post_view_counter_7_day_last_date, ($current_date - 6048005));

//            $count_7_day_array = get_post_meta($postID, self::$post_view_counter_7_day_array, true);
//            $count_7_day_total = get_post_meta($postID, self::$post_view_counter_7_day_total, true);
//            $count_7_day_total_all = get_post_meta($postID, self::$post_view_counter_key, true);
//
//            $count_7_day_lastday = get_post_meta($postID, self::$post_view_7days_last_day, true);
//            $count_7_day_lastdate = get_post_meta($postID, self::$post_view_counter_7_day_last_date, true);
//
//            echo '<br>';
//            print_r($count_7_day_array);
//            echo "<br>total week: " . $count_7_day_total;
//            echo "<br>total all time: " . $count_7_day_total_all;
//            echo '<br>last day: ' . $count_7_day_lastday;
//            echo '<br>last date: ' . $count_7_day_lastdate;
//            echo '<br>7 days ago (YYYY-MM-DD): ' . date('Y-m-d', strtotime('-17 day', $current_date));


        }
    }

    static function get_page_views($postID) {
        $count = get_post_meta($postID, self::$post_view_counter_key, true);

        if ($count == '') {
            delete_post_meta($postID, self::$post_view_counter_key);
            add_post_meta($postID, self::$post_view_counter_key, '0');
            return "0";
        }
        return $count;
    }



    static function on_manage_posts_columns_views($defaults) {
        $defaults['td_post_views'] = 'Views';
        return $defaults;
    }

    static function on_manage_posts_custom_column($column_name, $id) {
        if($column_name === 'td_post_views'){
            echo self::get_page_views(get_the_ID());
        }
    }
}


