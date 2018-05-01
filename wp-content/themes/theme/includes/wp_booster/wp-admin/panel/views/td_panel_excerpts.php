<!-- Excerpts -->
<?php echo td_panel_generator::box_start('Excerpts');?>

    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">Just a tip:</span>
            <p>Adding a text as excerpt on post edit page (Excerpt box), will overwrite the theme excerpts</p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>

    <!-- BACKGROUND UPLOAD -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class=" td-box-title">EXCERPTS TYPE</span>
            <p>Set the excerpt type</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_option',
                'option_id' => 'tds_excerpts_type',
                'values' => array(
                    array('text' => 'On Words', 'val' => ''),
                    array('text' => 'On Letters', 'val' => 'letters')
                )
            ));
            ?>
        </div>
    </div>

<?php echo td_panel_generator::box_end();?>









<?php
foreach (td_api_module::get_all() as $td_module_class => $td_module_array) {

    if (!empty($td_module_array['excerpt_title']) or !empty($td_module_array['excerpt_content'])) {

        $td_box_title = $td_module_array['text'];
        if (!empty($td_module_array['used_on_blocks'])) {
            $td_box_title .= td_panel_generator::helper_generate_used_on_block_list($td_module_array['used_on_blocks']);
        }



        echo td_panel_generator::box_start($td_box_title, false);
        ?>

        <div class="td-box-row">
            <div class="td-box-description td-box-full">
                <span class="td-box-title">Notice:</span>
                <p>You can find documentation on how blocks are created from modules <a href="http://forum.tagdiv.com/modules-and-blocks/" target="_blank">here</a></p>
            </div>
            <div class="td-box-row-margin-bottom"></div>
        </div>


        <?php if (!empty($td_module_array['excerpt_title'])) { ?>
            <!-- TITLE LENGTH -->
            <div class="td-box-row">
                <div class="td-box-description">
                    <span class=" td-box-title td-title-on-row">TITLE LENGTH</span>
                    <p></p>
                </div>
                <div class="td-box-control-full">
                    <?php
                    echo td_panel_generator::input(array(
                        'ds' => 'td_option',
                        'option_id' => $td_module_class . '_title_excerpt',
                        'placeholder' => $td_module_array['excerpt_title']
                    ));
                    ?>
                </div>
            </div>
        <?php } ?>


        <?php if (!empty($td_module_array['excerpt_content'])) { ?>
            <!-- CONTENT LENGTH LENGTH -->
            <div class="td-box-row">
                <div class="td-box-description">
                    <span class=" td-box-title td-title-on-row">CONTENT LENGTH</span>
                    <p></p>
                </div>
                <div class="td-box-control-full">
                    <?php
                    echo td_panel_generator::input(array(
                        'ds' => 'td_option',
                        'option_id' => $td_module_class . '_content_excerpt',
                        'placeholder' => $td_module_array['excerpt_content']
                    ));
                    ?>
                </div>
            </div>
        <?php } ?>


        <?php
        echo td_panel_generator::box_end();
    }


}

?>


