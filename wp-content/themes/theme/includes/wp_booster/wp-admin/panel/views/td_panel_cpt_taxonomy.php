<hr>
<div class="td-section-separator">Custom post types</div>


<?php



/**
 * Created by ra on 7/9/2015.
 */

// get all the custom post types, EXCEPT the built in ones
$td_custom_post_types_obj = get_post_types(
    array(
        '_builtin' => false // ignore built in CPT
    ),
    'objects' //output objects instead of names
);


$are_custom_post_types_installed = false;
foreach ($td_custom_post_types_obj as $custom_post_type_obj) {
    if (
            $custom_post_type_obj->name == 'vc_grid_item'  // do not show settings for visual composer
            or ( // do not show settings for woocommerce CPT because we set up woocommerce from a different panel
                td_global::$is_woocommerce_installed === true
                and (
                       $custom_post_type_obj->name == 'product_variation'
                    or $custom_post_type_obj->name == 'product'
                    or $custom_post_type_obj->name == 'shop_order'
                    or $custom_post_type_obj->name == 'shop_order_refund'
                    or $custom_post_type_obj->name == 'shop_coupon'
                    or $custom_post_type_obj->name == 'shop_webhook'
                )
            )
        ) {
        continue;
    }
    echo td_panel_generator::ajax_box($custom_post_type_obj->labels->name . '<span class="td-excerpt-arrow"></span><span class="td-box-title-label">' . $custom_post_type_obj->name . '</span>', array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_get_cpt_settings_by_post_type',
            'custom_post_type' => $custom_post_type_obj->name
        )
    );

    $are_custom_post_types_installed = true;
}

if ($are_custom_post_types_installed === false) {
    echo    '<div class="td-panel-no-settings-found" style="text-align: center">
                <strong>No custom post types detected</strong> <br>
                <span>
                    Please note that WooCommerce post types are ignored
                </span>
            </div>
            ';
}
?>




<hr>
<div class="td-section-separator">Custom taxonomies</div>
<?php
// get all the taxonomies - except the built ones
$td_taxonomies_obj = get_taxonomies(
    array(
        '_builtin' => false
    ),
    'object'
);

$are_custom_taxonomies_installed = false;
foreach ($td_taxonomies_obj as $td_taxonomy_obj) {
    if ( // ignore woocommerce taxonomies because we set up woocommerce from a different panel
        td_global::$is_woocommerce_installed === true
        and (
               $td_taxonomy_obj->name == 'product_type'
            or $td_taxonomy_obj->name == 'product_cat'
            or $td_taxonomy_obj->name == 'product_shipping_class'
            or $td_taxonomy_obj->name == 'product_tag'
        )
    ) {
        continue;
    }


    $taxonomy_used_on_cpt_html = '<span class="td-box-title-right-title">Used on CPT:</span>';
    if (!empty($td_taxonomy_obj->object_type)) {
        foreach ($td_taxonomy_obj->object_type as $taxonomy_used_on_cpt) {
            $taxonomy_used_on_cpt_html .= '<span class="td-box-title-label">' . $taxonomy_used_on_cpt . '</span>';
        }
    } else {
        $taxonomy_used_on_cpt_html .= '<span class="td-box-title-label">not used on CPT</span>';
    }
    $taxonomy_used_on_cpt_html = '<span class="td-box-title-right">' . $taxonomy_used_on_cpt_html . '</span>';


    echo td_panel_generator::ajax_box($td_taxonomy_obj->labels->name . '<span class="td-excerpt-arrow"></span><span class="td-box-title-label">' . $td_taxonomy_obj->name . '</span>' . $taxonomy_used_on_cpt_html, array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_get_tax_settings_by_tax_name',
            'taxonomy_name' => $td_taxonomy_obj->name
        )
    );

    $are_custom_taxonomies_installed = true;
}

if ($are_custom_taxonomies_installed === false) {
    echo    '<div class="td-panel-no-settings-found" style="text-align: center">
                <strong>No custom taxonomies detected</strong> <br>
                <span>
                    please note that WooCommerce taxonomies are ignored
                </span>
            </div>
            ';
}

//print_r($td_taxonomies_obj);