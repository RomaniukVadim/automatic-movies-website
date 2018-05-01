<?php

/**
 * @todo modulele astea trebuie incarcate by default
 * module8 category label should be enabled by default
 * module_related
 * module_mega_menu
 * module_slide
 */

?>
<div class="td-box-row">
    <div class="td-box-description td-box-full">
        <span class="td-box-title">More information:</span>
        <p>From here you can enable the thumbnail image that will be cropped for the modules &amp; blocks. If the thumbnail image is not enabled for a specific module that you use, the module will show a default placeholder with the size of the image and instructions about how to enable the thumb for that module</p>
        <p><strong style="color:red">Please regenerate your thumbnails if you change any of the thumb settings!</strong> - <a href="http://forum.tagdiv.com/existing-content/" target="_blank">read more</a></p>
    </div>
    <div class="td-box-row-margin-bottom"></div>
</div>


<?php
foreach (td_api_thumb::get_all() as $thumb) {
    ?>
    <!-- THUMB -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title"><?php echo $thumb['width'] . ' x ' . $thumb['height']  ?></span>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_thumb_' . $thumb['name'],
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            <div class="td-help-checkbox-inline">
                <?php
                echo "<span>This thumb size is used for:</span> <ul><li>" . implode("</li><li>", $thumb['used_on']) . "</li></ul>";
                ?>
            </div>
        </div>
    </div>
<?php
}