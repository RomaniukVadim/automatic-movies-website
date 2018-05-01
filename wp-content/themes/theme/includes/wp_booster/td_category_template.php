<?php
/**
 * Created by ra on 2/10/2015.
 */


abstract class td_category_template {

    const SIBLING_CATEGORY_LIMIT = 100; // if you want to show more or less categories on the category page, modify here

    private $current_category_id;
    private $current_category_obj;
    private $current_category_link;


    /**
     * abstract render * must have *
     * @return mixed
     */
    abstract function render();

    function __construct() {
        $this->current_category_id =  td_global::$current_category_obj->cat_ID;
        $this->current_category_obj =  td_global::$current_category_obj;
        $this->current_category_link = get_category_link($this->current_category_id);
    }


    /**
     * Generates the sibling categories, it also compiles the $custom_category_color_css and adds it to the footer css buffer
     * @param string $params_array
     *
     *  array(
     *       'current_category_css' => '
     *           <style>
     *              // the css style to compile
     *           </style>
     *       ',
     *           'show_background_color' => true - if true, the theme will output inline css to color the background color
     *       )
     *
     * @return string
     * @throws ErrorException
     */
    protected function get_sibling_categories($params_array = '') {
        $buffy = '';

        //the subcategories
        if (!empty($this->current_category_obj->cat_ID)) {

	        if ($this->current_category_obj->parent === 0) {

		        // get child categories
		        $categories_objects = get_categories( array(
			        'parent'     => $this->current_category_obj->cat_ID,
			        'hide_empty' => 0,
			        'number'     => self::SIBLING_CATEGORY_LIMIT
		        ) );
	        }

	        // if no child categories get siblings
	        if (empty($categories_objects)) {
		        $categories_objects = get_categories(array(
			        'parent'        => $this->current_category_obj->parent,
			        'hide_empty'    => 0,
			        'number'        => self::SIBLING_CATEGORY_LIMIT
		        ));
	        }
        }


        /**
         * if we have categories to show... show them
         */
        if (!empty($categories_objects)) {
            $buffy = '<div class="td-category-siblings">';
                $buffy .= '<ul class="td-category">';
                    foreach ($categories_objects as $category_object) {

                        // ignore featured cat and uncategorized
                        if (($category_object->name == TD_FEATURED_CAT) OR
	                        (strtolower($category_object->cat_name) == 'uncategorized')) {
                            continue;
                        }

                        if (!empty($category_object->name) and td_util::get_category_option($category_object->cat_ID,'tdc_hide_on_post') != 'hide') {
                            $class = '';
                            if($category_object->cat_ID == $this->current_category_id) {
                                $class = 'td-current-sub-category';
                            }


                            $td_css_inline = new td_css_inline();

                            // @todo we can add more properties as needed, ex: show_border_color
                            if (!empty($params_array['show_background_color'])) {
                                $tdc_color_current_cat = td_util::get_category_option($category_object->cat_ID, 'tdc_color');
                                $td_css_inline->add_css (
                                    array(
                                        'background-color' => $tdc_color_current_cat
                                    )
                                );
                            }


                            $buffy .= '<li class="entry-category"><a ' . $td_css_inline->get_inline_css() . ' class="' . $class . '"  href="' . get_category_link($category_object->cat_ID) . '">' . $category_object->name . '</a></li>';
                        }
                    }
                $buffy .= '</ul>';


                // subcategory dropdown list
                $buffy .= '<div class="td-subcat-dropdown td-pulldown-filter-display-option">';
                    $buffy .= '<div class="td-subcat-more"><i class="td-icon-menu-down"></i></div>';

                    // the dropdown list
                    $buffy .= '<ul class="td-pulldown-filter-list">';
                    $buffy .= '</ul>';

                $buffy .= '</div>';

            $buffy .= '<div class="clearfix"></div>';

            $buffy .= '</div>';
        }


        // compile the custom css
        if (!empty($params_array['current_category_css'])) {
            $tdc_color = td_util::get_category_option($this->current_category_obj->cat_ID, 'tdc_color');

            $td_css_compiler = new td_css_compiler($params_array['current_category_css']);
            $td_css_compiler->load_setting_raw('current_category_color', $tdc_color);
            td_css_buffer::add_to_footer($td_css_compiler->compile_css());
        }


        return $buffy;
    }




    protected function get_pull_down() {

        // if the filter is disabled in theme panel return ''
        if (td_util::get_option('tds_category_pull_down') == 'hide'){
            return '';
        }

        //get the `filter_by` URL ($_GET) variable
        $filter_by = get_query_var('filter_by');

        $td_category_big_grid_drop_down_filter_options = array(
            array('id' => 'latest', 'value' => $this->current_category_link, 'caption' => __td('Latest', TD_THEME_NAME)),
            array('id' => 'featured' , 'value' => esc_url(add_query_arg('filter_by', 'featured', $this->current_category_link)), 'caption' => __td('Featured posts', TD_THEME_NAME)),
            array('id' => 'popular', 'value' => esc_url(add_query_arg('filter_by', 'popular', $this->current_category_link)), 'caption' => __td('Most popular', TD_THEME_NAME)),
            array('id' => 'popular7' , 'value' => esc_url(add_query_arg('filter_by', 'popular7', $this->current_category_link)), 'caption' => __td('7 days popular', TD_THEME_NAME)),
            array('id' => 'review_high' , 'value' => esc_url(add_query_arg('filter_by', 'review_high', $this->current_category_link)), 'caption' => __td('By review score', TD_THEME_NAME)),
            array('id' => 'random_posts' , 'value' => esc_url(add_query_arg('filter_by', 'random_posts', $this->current_category_link)), 'caption' => __td('Random', TD_THEME_NAME))
        );

        //create the drop-down filter on category pages
        return $this->generate_category_pull_down($td_category_big_grid_drop_down_filter_options, $filter_by);
    }



    protected function get_title() {
        return $this->current_category_obj->name;
    }


    protected function get_breadcrumbs() {
        return td_page_generator::get_category_breadcrumbs($this->current_category_obj);
    }


    protected function get_description() {
        if (!empty($this->current_category_obj->description)) { // is needed?
            return '<div class="td-category-description"><p>' . $this->current_category_obj->description . '</p></div>';
        }
    }








    /**
     * Returns a category pull down
     * @param $td_pull_down_items =
     * array (
     *      id => value
     *      ..........
     * )
     * @return string
     */
    private function generate_category_pull_down($td_pull_down_items, $filter_by) {
        $buffy = '';
        $block_uid = td_global::td_generate_unique_id();

        $buffy .= '<div class="td-category-pulldown-filter td-wrapper-pulldown-filter">';
            $buffy .= '<div class="td-pulldown-filter-display-option">';

                //show the default display valuea
                $buffy .= '<div class="td-subcat-more">';
                if (empty($filter_by)) {
                    $buffy .=  $td_pull_down_items[0]['caption'] . ' <i class="td-icon-menu-down"></i>';
                } else {
                    //print_r($td_pull_down_items);
                    foreach ($td_pull_down_items as $item) {
                        if ($item['id'] == $filter_by) {
                            $buffy .=  $item['caption'] . ' <i class="td-icon-menu-down"></i>';
                            break;
                        }

                    }
                }

                $buffy .= '</div>';

                //builde the dropdown
                $buffy .= '<ul class="td-pulldown-filter-list">';

                foreach ($td_pull_down_items as $item) {
                    $buffy .= '<li class="td-pulldown-filter-item"><a class="td-pulldown-category-filter-link" id="' . td_global::td_generate_unique_id() . '" data-td_block_id="' . $block_uid . '" href="' . $item['value'] . '">' . $item['caption'] . '</a></li>';
                }
                $buffy .= '</ul>';

            $buffy .= '</div>';  //.td-pulldown-filter-display-option
        $buffy .= '</div>';

        return $buffy;
    }


}