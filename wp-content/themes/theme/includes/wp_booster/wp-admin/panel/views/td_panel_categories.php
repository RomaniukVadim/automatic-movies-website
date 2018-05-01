<!-- CATEGORY page -->
<?php echo td_panel_generator::box_start('Category global settings', true); ?>


    <div class="td-box-description td-box-full">
        <p>Set the default layout for all the categories. Note that you can change the layout and settings on each category from Theme panel ⇢ Categories</p>
        <ul>
            <li>You can view each category page by going to Posts ⇢ Categories ⇢ hover on a category ⇢ select view</li>
            <li>This WordPress template is located in <strong>category.php</strong> file.</li>
        </ul>
    </div>


    <!-- Category template -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Category template</span>
            <p>
                This is the header of the category
                <?php td_util::tooltip_html('
                        <h3>Category template:</h3>
                        <p>From here you can change the category header.</p>
                        <ul>
                            <li>This setting can be overwritten on a per category basis from the boxes below</li>
                            <li>Some of the headers also show the category description</li>
                            <li>For advanced users who want to customize the category header, here is the <a target="_blank" href="http://forum.tagdiv.com/api-category-top-section-template-introduction/">API documentation</a></li>
                            <li>Have fun finding the header that you like!</li>
                        </ul>
                ', 'right')?>
            </p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::visual_select_o(array(
                'ds' => 'td_option',
                'option_id' => 'tds_category_template',
                'values' => td_api_category_template::_helper_to_panel_values()
            ));
            ?>
        </div>
    </div>

    <!-- Category pull-down filter -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Category pull-down filter</span>
            <p>
                This setting controls the display of the category pull-down filter.
                <?php td_util::tooltip_html('
                        <h3>Category pull-down filter:</h3>
                        <p>This option allows you to enable or disable this filter:</p>
                        <ul>
                            <li>By default it\'s enabled.</li>
                            <li>This filter allows you to set a different post sort order and it can be found on the top section of the category page.</li>
                            <li>If you select "Disable" this filter will be removed from all category pages.</li>
                        </ul>
                ', 'right')?>
            </p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_category_pull_down',
                'true_value' => '',
                'false_value' => 'hide'
            ));
            ?>
        </div>
    </div>



<div class="td-box-section-separator"></div>

    <!-- Category top posts style -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Category top posts style</span>
            <p>
                Set top post style
                <?php td_util::tooltip_html('
                        <h3>Category top post styles:</h3>
                        <p>Highlight the latest posts on a category page</p>
                        <ul>
                            <li>This setting can be overwritten on a per category basis from the boxes below</li>
                            <li>Use this setting + the <i>grid style</i> setting to get the results that you want</li>
                            <li>For advanced users, here is the <a target="_blank" href="http://forum.tagdiv.com/api-category-top-section-style-introduction/">API documentation</a></li>
                        </ul>
                ', 'right')?>
            </p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::visual_select_o(array(
                'ds' => 'td_option',
                'option_id' => 'tds_category_top_posts_style',
                'values' => td_api_category_top_posts_style::_helper_to_panel_values()
            ));
            ?>
        </div>
    </div>

    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Category top posts GRID STYLE</span>
            <p>Each category grid supports multiple styles</p>
        </div>
        <div class="td-box-control-full">
            <?php

            $td_grid_style_values = array();
            foreach (td_global::$big_grid_styles_list as $big_grid_id => $params) {
                $td_grid_style_values []= array(
                    'text' => $params['text'],
                    'val' => $big_grid_id
                );
            }
            echo td_panel_generator::dropdown(array(
                'ds' => 'td_option',
                'option_id' => 'tds_category_td_grid_style',
                'values' => $td_grid_style_values
            ));
            ?>
        </div>
    </div>

<div class="td-box-section-separator"></div>


    <!-- DISPLAY VIEW -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">ARTICLE DISPLAY VIEW</span>
            <p>Select a module type, this is how your article list will be displayed. For custom modules or tuning, read <a target="_blank" href="http://forum.tagdiv.com/api-modules-introduction/">the module API</a></p>
        </div>
        <div class="td-box-control-full td-panel-module">
            <?php
            echo td_panel_generator::visual_select_o(array(
                'ds' => 'td_option',
                'option_id' => 'tds_category_page_layout',
                'values' => td_panel_generator::helper_display_modules('enabled_on_loops')
            ));
            ?>
        </div>
    </div>


<div class="td-box-section-separator"></div>

<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">Pagination style</span>
        <p>Set a pagination style for all categories</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::dropdown(array(
            'ds' => 'td_option',
            'option_id' => 'tds_category_pagination_style',
            'values' => array(
                array (
                    'val' => '',
                    'text' => 'Normal pagination'
                ),
                array (
                    'val' => 'infinite',
                    'text' => 'Infinite loading'
                ),
                array (
                    'val' => 'infinite_load_more',
                    'text' => 'Infinite loading + Load more'
                )
            )
        ));
        ?>
    </div>
</div>


<div class="td-box-section-separator"></div>


    <!-- Custom Sidebar + position -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">CUSTOM SIDEBAR + POSITION</span>
            <p>Sidebar position and custom sidebars</p>
        </div>
        <div class="td-box-control-full td-panel-sidebar-pos">
            <div class="td-display-inline-block">
                <?php
                echo td_panel_generator::visual_select_o(array(
                    'ds' => 'td_option',
                    'option_id' => 'tds_category_sidebar_pos',
                    'values' => array(
                        array('text' => '', 'title' => '', 'val' => 'sidebar_left', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-left.png'),
                        array('text' => '', 'title' => '', 'val' => 'no_sidebar', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-full.png'),
                        array('text' => '', 'title' => '', 'val' => '', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-right.png')
                    )
                ));
                ?>
                <div class="td-panel-control-comment td-text-align-right">Select sidebar position</div>
            </div>
            <div class="td-display-inline-block td_sidebars_pulldown_align">
                <?php
                echo td_panel_generator::sidebar_pulldown(array(
                    'ds' => 'td_option',
                    'option_id' => 'tds_category_sidebar'
                ));
                ?>
                <div class="td-panel-control-comment td-text-align-right">Create or select an existing sidebar</div>
            </div>
        </div>
    </div>


<?php echo td_panel_generator::box_end();?>


<hr>
<div class="td-section-separator">Per category settings</div>




<?php













/**
 * custom walker - it's used only in this panel
 * Class td_category_walker_panel
 */
class td_category_walker_panel extends Walker {
    var $tree_type = 'category';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');


    var $td_category_hierarchy = array();  // we store them like so [0] Category 1 - [1] Category 2 - [2] Category 3


    var $td_category_buffer = array();

    /**
     * $td_last_depth - int.
     * store the last depth, used to reset $td_category_hierarchy on multiple branches
     * Ex:
     *      - main category[depth 0]:
     *                    - subcategory a [depth 1]
     *                         - subcategory a1 [depth 2]
     *                              - subcategory a12 [depth 3]
     *                    - subcategory b [depth 1]
     *                         - subcategory b1 [depth 2]
     *                              - subcategory b12 [depth 3]
     * they are processed in the same sequence
     * when you pass from depth 3 to 1 you have to remove the previous items present on depth 2 and 3 inside the $td_category_hierarchy array
     */
    var $td_last_depth = 0;

    function start_lvl( &$output, $depth = 0, $args = array() ) {

    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {

    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

        // reset the $td_category_hierarchy array
        if ($this->td_last_depth > $depth && $depth > 0) {
            $buffy = array();
            //keep only the array elements which have a depth lower than the current depth
            //the current element is added after this sequence, in the "build the category hierarchy" line
            for ($i = 0; $i < $depth; $i++){
                $buffy[] = $this->td_category_hierarchy[$i];
            }
            $this->td_category_hierarchy = $buffy;
        }
        $this->td_last_depth = $depth;

        //build the category hierarchy - [0] Category 1 - [1] Category 2 - [2] Category 3
        $this->td_category_hierarchy[$depth] = $category;

        if ($depth == 0) {
            //reset the parrents
            $this->td_category_hierarchy = array();
            //put the
            $this->td_category_hierarchy[0] = $category;

            //add first parent
            $this->td_category_buffer['<a href="' . get_category_link($category->term_id) . '" target="_blank" data-is-category-link="yes">' . $category->name . '</a>'] = $category->term_id;
        } else {

            $td_tmp_buffer = '';
            $last_cat_id = 0;
            $contor_array = 0;
            //print_r($this->td_category_hierarchy);
            foreach ($this->td_category_hierarchy as $parent_cat_obj) {

                if ($td_tmp_buffer === '') {
                    $td_tmp_buffer = '<a href="' . get_category_link($parent_cat_obj->term_id) . '" target="_blank" data-is-category-link="yes">' . $parent_cat_obj->name . '</a>';
                    $last_cat_id = $parent_cat_obj->term_id;
                } else {
                    if($this->td_category_hierarchy[$contor_array-1]->term_id == $parent_cat_obj->parent) {
                        $td_tmp_buffer .=  '<img src="' . get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/panel-breadcrumb.png" class="td-panel-breadcrumb"/>' . '<a href="' . get_category_link($parent_cat_obj->term_id) . '" target="_blank" data-is-category-link="yes">' . $parent_cat_obj->name . '</a>';
                        $last_cat_id = $parent_cat_obj->term_id;
                    }
                }

                $contor_array++;

            }


            //add child
            $this->td_category_buffer[$td_tmp_buffer] = $last_cat_id;

        }


    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {

    }

}



// get all the categories
$categories = get_categories(array(
	'hide_empty' => 0,
	'number' => 1000
));

// 'walk' all the categories
$td_category_walker_panel = new td_category_walker_panel;
$td_category_walker_panel->walk($categories, 4);

// add each category panel
foreach ($td_category_walker_panel->td_category_buffer as $display_category_name => $category_id) {
	?>
	<!-- LAYOUT SETTINGS -->
	<?php
	echo td_panel_generator::ajax_box($display_category_name, array(
			'td_ajax_calling_file' => basename(__FILE__),
			'td_ajax_box_id' => 'td_get_category_section_by_id',
			'category_id' => $category_id
		)
	);
}//end foreach