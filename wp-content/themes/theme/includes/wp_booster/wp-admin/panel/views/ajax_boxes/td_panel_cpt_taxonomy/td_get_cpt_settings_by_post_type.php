<?php
/**
 * Created by ra on 7/9/2015.
 */


$custom_post_type = td_util::get_http_post_val('custom_post_type');



// get the registered taxonomies for this specific post type and prepare them for use in the panels dropdowns
// add empty
$td_registered_taxonomies[] = array(
    'val' => '',
    'text' => '-- None --'
);

// read the taxonomies and build the array
$registered_taxonomies_obj = get_object_taxonomies($custom_post_type, 'objects');
foreach ($registered_taxonomies_obj as $registered_taxonomy_obj) {
    $td_registered_taxonomies[] = array(
        'val' => $registered_taxonomy_obj->name,
        'text' => $registered_taxonomy_obj->labels->name . '  ' . '(' . $registered_taxonomy_obj->name . ')'
    );
}



?>





<!-- breadcrumbs: select taxonomy -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">Breadcrumbs taxonomy</span>
        <p>What taxonomy should show up in the breadcrumbs</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::dropdown(array(
            'ds' => 'td_cpt',
            'item_id' => $custom_post_type,
            'option_id' => 'tds_breadcrumbs_taxonomy',
            'values' => $td_registered_taxonomies
        ));
        ?>
    </div>
</div>

<div class="td-box-section-separator"></div>

<!-- category spot: select taxonomy -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">Category spot taxonomy</span>
        <p>What taxonomy should show up in the category spot</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::dropdown(array(
            'ds' => 'td_cpt',
            'item_id' => $custom_post_type,
            'option_id' => 'tds_category_spot_taxonomy',
            'values' => $td_registered_taxonomies
        ));
        ?>
    </div>
</div>


<div class="td-box-section-separator"></div>

<!-- tag spot: select taxonomy -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">tag spot taxonomy</span>
        <p>What taxonomy should show up in the tag spot</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::dropdown(array(
            'ds' => 'td_cpt',
            'item_id' => $custom_post_type,
            'option_id' => 'tds_tag_spot_taxonomy',
            'values' => $td_registered_taxonomies
        ));
        ?>
    </div>
</div>

<!-- tag spot: text -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">tag spot text</span>
        <p>If you are using custom taxonomies, you can replace the default TAG label</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::input(array(
            'ds' => 'td_cpt',
            'item_id' => $custom_post_type,
            'option_id' => 'tds_tag_spot_text',
            'placeholder' => __td('TAGS')
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
                'ds' => 'td_cpt',
                'item_id' => $custom_post_type,
                'option_id' => 'tds_custom_post_sidebar_pos',
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
                'ds' => 'td_cpt',
                'item_id' => $custom_post_type,
                'option_id' => 'tds_custom_post_sidebar'
            ));
            ?>
            <div class="td-panel-control-comment td-text-align-right">Create or select an existing sidebar</div>
        </div>
    </div>
</div>