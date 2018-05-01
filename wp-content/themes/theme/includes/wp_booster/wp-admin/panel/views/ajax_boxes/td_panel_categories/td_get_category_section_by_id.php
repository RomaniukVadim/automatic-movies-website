<?php
/**
 * Created by ra on 1/13/2015.
 */
$category_id = td_util::get_http_post_val('category_id');
?>


    <!-- Category template -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Category template</span>
            <p>This is the header of the category</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::visual_select_o(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_category_template',
                'values' => td_api_category_template::_helper_to_panel_values('default+get_all')
            ));
            ?>
        </div>
    </div>



<div class="td-box-section-separator"></div>
    <!-- Category top posts style -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Category top posts style</span>
            <p>Choose how to display the top posts. By default it will inherit the Global Category setting from the top of this page.</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::visual_select_o(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_category_top_posts_style',
                'values' => td_api_category_top_posts_style::_helper_to_panel_values('default+get_all')
            ));
            ?>
        </div>
    </div>



    <?php
    // show the $big_grid_styles_list only if we have big grids
    // Newsmag as of 10 march is not using $big_grid_styles_list
    if (!empty(td_global::$big_grid_styles_list)) {
        ?>
        <div class="td-box-row">
            <div class="td-box-description">
                <span class="td-box-title">Category top posts GRID STYLE</span>
                <p>Each category grid supports multiple styles</p>
            </div>
            <div class="td-box-control-full">
                <?php
                $td_grid_style_values = array(
                    array(
                        'text' => 'Inherit from global settings',
                        'val' => ''
                    )
                );
                foreach (td_global::$big_grid_styles_list as $big_grid_id => $params) {
                    $td_grid_style_values []= array(
                        'text' => $params['text'],
                        'val' => $big_grid_id
                    );
                }

                echo td_panel_generator::dropdown(array(
                    'ds' => 'td_category',
                    'item_id' => $category_id,
                    'option_id' => 'tdc_category_td_grid_style',
                    'values' => $td_grid_style_values
                ));
                ?>
            </div>
        </div>
    <?php } ?>


    <div class="td-box-section-separator"></div>

    <!-- DISPLAY VIEW -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">ARTICLE DISPLAY VIEW</span>
            <p>Select a module type, this is how your article list will be displayed</p>
        </div>
        <div class="td-box-control-full td-panel-module">
            <?php
            echo td_panel_generator::visual_select_o(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_layout',
                'values' => td_panel_generator::helper_display_modules('default+enabled_on_loops')
            ));
            ?>
        </div>
    </div>


    <div class="td-box-section-separator"></div>


    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Pagination style</span>
            <p>Set a pagination style for this category</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::dropdown(array(
                'ds' => 'td_category',
                'option_id' => 'tdc_category_pagination_style',
                'item_id' => $category_id,
                'values' => array(
                    array (
                        'val' => '',
                        'text' => 'Inherit from global settings',
                    ),

                    array (
                        'val' => 'normal',
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
                    'ds' => 'td_category',
                    'item_id' => $category_id,
                    'option_id' => 'tdc_sidebar_pos',
                    'values' => array(
                        array('text' => '', 'title' => '', 'val' => '', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-default.png'),
                        array('text' => '', 'title' => '', 'val' => 'sidebar_left', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-left.png'),
                        array('text' => '', 'title' => '', 'val' => 'no_sidebar', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-full.png'),
                        array('text' => '', 'title' => '', 'val' => 'sidebar_right', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-right.png')
                    )
                ));
                ?>
                <div class="td-panel-control-comment td-text-align-right">Select sidebar position</div>
            </div>
            <div class="td-display-inline-block td_sidebars_pulldown_align">
                <?php
                echo td_panel_generator::sidebar_pulldown(array(
                    'ds' => 'td_category',
                    'item_id' => $category_id,
                    'option_id' => 'tdc_sidebar_name'
                ));
                ?>
                <div class="td-panel-control-comment td-text-align-right">Create or select an existing sidebar</div>
            </div>
        </div>
    </div>



    <!-- Category color -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">CATEGORY TAG COLOR ON POST PAGE</span>
            <p>Pick a color for this category tag on post page</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::color_picker(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_color',
                'default_color' => ''
            ));
            ?>
        </div>
    </div>

    <!-- BACKGROUND UPLOAD -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">BACKGROUND UPLOAD</span>
            <p>Upload your background image.</br> You can use:</p>
            <ul>
                <li>Single Image</li>
                <li>Pattern</li>
            </ul>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_image'
            ));
            ?>
        </div>
    </div>

    <!-- BACKGROUND STYLE -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">BACKGROUND STYLE</span>
            <p>How the background will be displayed</p>
            <ul>
                <li><b>Stretch:</b> use this option when you are using a Single Image for you background and you want this image to fill the entire background.</li>
                <li><b>Tiled:</b> use this option when you are using a Pattern for you background.</li>
            </ul>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_bg_repeat',
                'values' => array(
                    array('text' => 'Default', 'val' => ''),
                    array('text' => 'Stretch', 'val' => 'stretch'),
                    array('text' => 'Tiled', 'val' => 'tile')
                )
            ));
            ?>
        </div>
    </div>

    <!-- Background color -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">BACKGROUND COLOR</span>
            <p>Use a solid color instead of an image</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::color_picker(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_bg_color',
                'default_color' => ''
            ));
            ?>
        </div>
    </div>

    <!-- Hide category tag on post -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">HIDE CATEGORY ON POST AND ON CATEGORY PAGES</span>
        <p>Show or hide category on single post page and on category pages. Useful if you want to have hidden categories to sort things up.</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::checkbox(array(
            'ds' => 'td_category',
            'item_id' => $category_id,
            'option_id' => 'tdc_hide_on_post',
            'true_value' => 'hide',
            'false_value' => ''
        ));
        ?>
    </div>
</div>
