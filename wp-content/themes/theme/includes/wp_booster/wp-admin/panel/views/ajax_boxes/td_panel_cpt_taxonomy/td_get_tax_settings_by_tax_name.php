<?php
/**
 * Created by ra on 1/13/2015.
 */
$taxonomy_name = td_util::get_http_post_val('taxonomy_name');
?>





<!-- DISPLAY VIEW -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">ARTICLE DISPLAY VIEW</span>
        <p>Select a module type, this is how your article list will be displayed. For custom modules or tuning, read <a target="_blank" href="http://forum.tagdiv.com/api-modules-introduction/">the module API</a></p>
    </div>
    <div class="td-box-control-full td-panel-module">
        <?php
        echo td_panel_generator::visual_select_o(array(
            'ds' => 'td_taxonomy',
            'item_id' => $taxonomy_name,
            'option_id' => 'tds_taxonomy_page_layout',
            'values' => td_panel_generator::helper_display_modules('enabled_on_loops')
        ));
        ?>
    </div>
</div>



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
                'ds' => 'td_taxonomy',
                'item_id' => $taxonomy_name,
                'option_id' => 'tds_taxonomy_sidebar_pos',
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
                'ds' => 'td_taxonomy',
                'item_id' => $taxonomy_name,
                'option_id' => 'tds_taxonomy_sidebar'
            ));
            ?>
            <div class="td-panel-control-comment td-text-align-right">Create or select an existing sidebar</div>
        </div>
    </div>
</div>