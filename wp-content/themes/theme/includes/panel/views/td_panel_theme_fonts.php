<!-- CUSTOM FONTS PANELS -->
<?php require_once(td_global::$get_template_directory . '/includes/wp_booster/wp-admin/panel/views/td_panel_custom_fonts.php'); ?>

<!-- FONT SETTINGS -->
<div class="td-section-separator">Font Settings</div>
    <?php
    foreach (td_global::$typography_settings_list as $panel_section => $font_settings_array) {
        echo td_panel_generator::ajax_box($panel_section,
            array(
                'td_ajax_calling_file' => basename(__FILE__),
                'td_ajax_box_id' => 'td_get_font_section_by_section_id',
                'section_name' => $panel_section,
                'td_ajax_view' => 'td_theme_fonts'
            )
        );
    }
    ?>