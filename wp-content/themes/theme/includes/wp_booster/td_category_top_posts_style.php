<?php

abstract class td_category_top_posts_style {

    // we keep the buffer and posts count for private use here:
    private $rendered_block_buffer = '';
    private $rendered_posts_count = 0;



    /**
     * force all the td_category_top_posts_style s to have this method.
     * each top posts style, uses this method:
     *  - it calls @see render_posts_to_buffer()
     *  - and if @see get_rendered_post_count() != 0
     *    - it will show @see get_buffer() and the wrappers
     */
    abstract function show_top_posts();



    /**
     * we have to render the block first in the buffer, to avoid two queries.
     * - IF there are posts, we already have the buffer with the block's content and we don't have to make another query
     * - IF there are no posts, we ignore the buffer and we can also remove the wraps in the child classes of this class
     */
    protected function render_posts_to_buffer() {
        // get the global category top posts grid style setting

	    $td_grid_style = td_util::get_option('tds_category_td_grid_style');
	    $limit = td_api_category_top_posts_style::_helper_get_posts_shown_in_the_loop();
	    $block_name = td_api_category_top_posts_style::get_key(get_class($this), 'td_block_name');

        // overwrite the $td_grid_style if the setting for this category was changed
        $td_grid_style_per_category_setting = td_util::get_category_option(td_global::$current_category_obj->cat_ID, 'tdc_category_td_grid_style');
        if ($td_grid_style_per_category_setting != '') {
            $td_grid_style = $td_grid_style_per_category_setting;
        }



        // we have to have a default grid, there seems to be a problem with the grid styles
        if (empty($td_grid_style)) {
            $td_grid_style = 'td-grid-style-1';
        }


        //parameters to filter to for big grid
        $atts_for_big_grid = array(
            'limit' => $limit,
            'category_id' => td_global::$current_category_obj->cat_ID,
            'sort' => get_query_var('filter_by'),
            'td_grid_style' => $td_grid_style
        );


        //show the big grid
	    $block_instance = td_global_blocks::get_instance($block_name);
	    $this->rendered_block_buffer = $block_instance->render($atts_for_big_grid);
        $this->rendered_posts_count = $block_instance->td_query->post_count;

        if ($this->rendered_posts_count > 0) {
            td_global::$custom_no_posts_message = false;
        }
        // use class_name($this) to get the id :)
    }



    /**
     * gets the buffer, should be called after @see render_posts_to_buffer();
     * @return string
     */
    protected function get_buffer() {
        return $this->rendered_block_buffer;
    }



    /**
     * gets the number of posts @via td_global_blocks::get_instance($block_name)->td_query->post_count;
     * @see render_posts_to_buffer();
     * @return string
     */
    protected function get_rendered_post_count() {
        return $this->rendered_posts_count;
    }
}