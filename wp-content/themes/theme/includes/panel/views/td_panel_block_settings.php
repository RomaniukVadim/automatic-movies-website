<!-- Thumbs on Modules/Blocks -->
<?php
    echo td_panel_generator::ajax_box('Thumbs on modules &amp; blocks', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_thumbs_on_modules_and_blocks',
        ), '', 'td_panel_box_thumb_on_modules'
    );
?>





<!-- Category label on modules -->
<?php echo td_panel_generator::box_start('Category tag on Modules/Blocks', false); ?>

    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">More information:</span>
            <p>From here you can show or hide the category tag from modules. <a target="_blank" href="http://forum.tagdiv.com/theme-thumbs/" >Read more about modules</a></p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>



    <?php
    foreach (td_api_module::get_all() as $td_module_class => $td_module_array) {
        if ($td_module_array['category_label'] === true) {
            ?>
            <!-- <?php echo $td_module_array['text'] ?> -->
            <div class="td-box-row">
                <div class="td-box-description">
                    <span class="td-box-title"><?php echo $td_module_array['text'] . td_panel_generator::helper_generate_used_on_block_list($td_module_array['used_on_blocks']) ?></span>
                    <p>Hide or show the category tag</p>
                </div>
                <div class="td-box-control-full">
                    <?php
                    echo td_panel_generator::checkbox(array(
                        'ds' => 'td_option',
                        'option_id' => 'tds_category_' . td_api_module::_helper_get_module_name_from_class($td_module_class),
                        'true_value' => 'yes',
                        'false_value' => ''
                    ));
                    ?>
                </div>
            </div>
            <?php
        }
    }

    ?>
<?php echo td_panel_generator::box_end();?>





<!-- 7 days post sorting -->
<?php echo td_panel_generator::box_start('7 days post sorting', false); ?>


<!-- text -->
<div class="td-box-row">
	<div class="td-box-description td-box-full">
		<p>When you enable this option a new sorting option will work and it will be selectable on each block (7 days popular). This sorting option will pick posts that are popular in the last 7 days, ordered by page views. This option comes with a small performance penalty and it does not work well with caching plugins yet. When caching is enabled the sorting will be an estimation of the popularity in the last 7 days.</p>
	</div>
	<div class="td-box-row-margin-bottom"></div>
</div>

<!-- use 7 days post sorting -->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">USE 7 DAYS POST SORTING</span>
		<p>Enable or disable the popular last 7 days.</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_option',
			'option_id' => 'tds_p_enable_7_days_count',
			'true_value' => 'enabled',
			'false_value' => ''
		));
		?>
	</div>
</div>
<?php echo td_panel_generator::box_end();?>







<?php
    //@todo run only on Newsmag - HACK
    if (TD_THEME_NAME === 'Newsmag') { ?>
    <hr>
    <div class="td-section-separator">Block predefined style</div>

    <!-- STYLE 1 CSS ------------------------------------------------------------------------->
    <?php
    echo td_panel_generator::ajax_box('Style 1 - Red', array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_style_1_red'
        )
    );
    ?>



    <!-- STYLE 2 CSS ------------------------------------------------------------------------->
    <?php
    echo td_panel_generator::ajax_box('Style 2 - Black', array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_style_2_black'
        )
    );
    ?>



    <!-- STYLE 3 CSS ------------------------------------------------------------------------->
    <?php
    echo td_panel_generator::ajax_box('Style 3 - Orange', array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_style_3_orange'
        )
    );
    ?>



    <!-- STYLE 4 CSS ------------------------------------------------------------------------->
    <?php
    echo td_panel_generator::ajax_box('Style 4 - Yellow', array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_style_4_yellow'
        )
    );
    ?>



    <!-- STYLE 5 CSS ------------------------------------------------------------------------->
    <?php
    echo td_panel_generator::ajax_box('Style 5 - Green', array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_style_5_green'
        )
    );
    ?>



    <!-- STYLE 6 CSS ------------------------------------------------------------------------->
    <?php
    echo td_panel_generator::ajax_box('Style 6 - Pink', array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_style_6_pink'
        )
    );

}