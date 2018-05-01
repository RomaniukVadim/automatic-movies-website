<?php
/**
 * If you are looking for the loop that's handling the single post page (single.php), check out loop-single.php
 **/

global $post;

$td_template_layout = new td_template_layout('no_sidebar');

$td_module_class = 'td_module_mob_1';

//disable the grid for some of the modules
$td_module = td_api_module::get_by_id($td_module_class);
if ($td_module['uses_columns'] === false) {
    $td_template_layout->disable_output();
}

if (have_posts()) {

    // get the post after which the add is displayed
    $tds_loop_ad_module_mob = td_util::get_option('tds_loop_ad_module_mob');

    // by default display the ad after 5 posts
    if (empty($tds_loop_ad_module_mob)) {
	    $tds_loop_ad_module_mob = 5;
    }

    // ad position counter
	// The 0 position is not valid, because at the top there's the ad header
    $td_ad_position_counter = 1;

    while ( have_posts() ) : the_post();
        if (class_exists($td_module_class)) {
            $td_mod = new $td_module_class($post);
            echo $td_mod->render();
        } else {
            td_util::error(__FILE__, 'Missing module: ' . $td_module_class);
        }
        $td_template_layout->layout_next();

	    // place the ad after 5 posts, then increment ad position counter
	    if ($td_ad_position_counter++ == $tds_loop_ad_module_mob) {
            echo td_global_blocks::get_instance('td_block_ad_box_mob')->render(array('spot_id' => 'loop_mob'));;
        }

    endwhile; //end loop

    echo $td_template_layout->close_all_tags();

} else {
    /**
     * no posts to display. This function generates the __td('No posts to display').
     * the text can be overwritten by the themplate using the global @see td_global::$custom_no_posts_message
     */

    echo td_page_generator_mob::no_posts();
}