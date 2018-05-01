<!-- BACKGROUND SETTINGS -->
<?php echo td_panel_generator::box_start('Theme background'); ?>

    <!-- BACKGROUND UPLOAD -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">THEME BACKGROUND</span>
            <p>Upload a background image, the site will automatically switch to boxed version</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_site_background_image'
            ));
            ?>
        </div>
    </div>

    <!-- Background Repeat -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">REPEAT</span>
            <p>How the site background image will be displayed</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_option',
                'option_id' => 'tds_site_background_repeat',
                'values' => array(
                    array('text' => 'No Repeat', 'val' => ''),
                    array('text' => 'Tile', 'val' => 'repeat'),
                    array('text' => 'Tile Horizontally', 'val' => 'repeat-x'),
                    array('text' => 'Tile Vertically', 'val' => 'repeat-y')
                )
            ));
            ?>
        </div>
    </div>


    <!-- Background position -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">POSITION</span>
            <p>Position your background image</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_option',
                'option_id' => 'tds_site_background_position_x',
                'values' => array(
                    array('text' => 'Left', 'val' => ''),
                    array('text' => 'Center', 'val' => 'center'),
                    array('text' => 'Right', 'val' => 'right')
                )
            ));
            ?>
        </div>
    </div>


    <!-- Background attachment -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">BACKGROUND ATTACHMENT</span>
            <p>Background attachment</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_option',
                'option_id' => 'tds_site_background_attachment',
                'values' => array(
                    array('text' => 'Fixed', 'val' => 'fixed'),
                    array('text' => 'Scroll', 'val' => '')
                )
            ));
            ?>
        </div>
    </div>


    <!-- Stretch background -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">STRETCH BACKGROUND</span>
            <p>Background image stretching <br>( Leave this option disabled if you are using background click ad)</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_stretch_background',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
        </div>
    </div>



<?php echo td_panel_generator::box_end();?>


<!-- MOBILE MENU BACKGROUND -->
<?php echo td_panel_generator::box_start('Mobile menu/search background', false); ?>

<!-- BACKGROUND UPLOAD -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">BACKGROUND IMAGE</span>
        <p>Upload a background image</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::upload_image(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_background_image'
        ));
        ?>
    </div>
</div>

<!-- Background Repeat -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">REPEAT</span>
        <p>How the background image will be displayed</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::radio_button_control(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_background_repeat',
            'values' => array(
                array('text' => 'No Repeat', 'val' => ''),
                array('text' => 'Tile', 'val' => 'repeat'),
                array('text' => 'Tile Horizontally', 'val' => 'repeat-x'),
                array('text' => 'Tile Vertically', 'val' => 'repeat-y')
            )
        ));
        ?>
    </div>
</div>

<!-- Background Size -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">SIZE</span>
        <p>Set the background image size</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::radio_button_control(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_background_size',
            'values' => array(
                array('text' => 'Cover', 'val' => ''),
                array('text' => 'Full Width', 'val' => '100% auto'),
                array('text' => 'Full Height', 'val' => 'auto 100%'),
                array('text' => 'Auto', 'val' => 'auto'),
                array('text' => 'Contain', 'val' => 'contain')
            )
        ));
        ?>
    </div>
</div>

<!-- Background position -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">POSITION</span>
        <p>Position your background image</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::radio_button_control(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_background_position',
            'values' => array(
                array('text' => 'Top', 'val' => ''),
                array('text' => 'Center', 'val' => 'center center'),
                array('text' => 'Bottom', 'val' => 'center bottom')
            )
        ));
        ?>
    </div>
</div>

<?php echo td_panel_generator::box_end();?>