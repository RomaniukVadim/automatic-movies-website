<div class="td-section-separator">Custom CSS</div>
<!-- CUSTOM CSS -->
<?php echo td_panel_generator::box_start('Custom CSS', false); ?>


	<div class="td-box-row">
		<div class="td-box-description td-box-full">
			<span class="td-box-title">WRITE YOUR OWN CSS HERE</span>
			<p>The css from this box will load on all the pages of the site. Press <strong>ctrl + space</strong> while editing to bring up a suggestion box.</p>
		</div>
	</div>


    <div class="td-box-row-margin-bottom">
            <?php
            echo td_panel_generator::css_editor(array(
                'ds' => 'td_option',
                'option_id' => 'tds_custom_css',
            ));
            ?>
    </div>

<?php echo td_panel_generator::box_end();?>



<!-- ADVANCED CSS -->
<?php echo td_panel_generator::box_start('Advanced CSS', false); ?>

    <!-- Responsive css -->
    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">RESPONSIVE CSS</span>
            <p>Paste your custom css in the appropriate box, to run only on a specific device</p>
        </div>
    </div>

    <?php
        /**
         * this part of the panel is generated from td_global::$theme_panel_custom_css_fields_list
         * td_global::$theme_panel_custom_css_fields_list is set via td_config.php on a per theme basis
         */
        foreach (td_global::$theme_panel_custom_css_fields_list as $option_id => $css_params) {
            ?>
            <!-- Css for each device type -->
            <div class="td-box-row">
                <div class="td-box-description">
                    <div class="td-display-inline-block">
                        <img src="<?php echo $css_params['img'];?>">
                    </div>
                    <div class="td-display-inline-block">
                        <span class="td-box-title"><?php echo $css_params['text'];?></span>
                        <p><?php echo $css_params['description'];?></p>
                    </div>
                </div>
                <div class="td-box-control-full">
                    <?php
                    echo td_panel_generator::css_editor(array(
                        'ds' => 'td_option',
                        'option_id' => $option_id,
	                    'css' => array(
		                    'height' => '150px',
		                    'margin-bottom' => '15px'
	                    )
                    ));
                    ?>
                </div>
            </div>
            <?php
        }
    ?>
<?php echo td_panel_generator::box_end();?>



<!-- Add custom body class -->
<?php echo td_panel_generator::box_start('Custom Body Class(s)', false); ?>
    <!-- Add custom body class -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">CUSTOM BODY CLASS(s)</span>
            <p>You can add one or more classes on theme body element. If you need more then one class, add them with a space between them.</p><p>Ex: class-test-1 class-test-2 </p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'td_body_classes'
            ));
            ?>
        </div>
    </div>
<?php echo td_panel_generator::box_end();?>

<hr>
<div class="td-section-separator">Custom Javascript</div>

<!-- CUSTOM Javascript -->
<?php echo td_panel_generator::box_start('Custom Javascript', false); ?>
    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">YOUR CUSTOM JAVASCRIPT</span>
            <p>Add custom javascript easly, using this editor. Please do not include the &lt;script&gt; &lt;/script&gt;.</p>
        </div>
    </div>
    <div class="td-box-row-margin-bottom">
        <?php
        echo td_panel_generator::js_editor(array(
            'ds' => 'td_option',
            'option_id' => 'tds_custom_javascript',
        ));
        ?>
    </div>
<?php echo td_panel_generator::box_end();?>

<hr>
<div class="td-section-separator">Custom HTML</div>

<!-- CUSTOM HTML -->
<?php echo td_panel_generator::box_start('Custom HTML', false); ?>
    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">YOUR CUSTOM HTML</span>
            <p>Add custom html easly, using this editor. The html will be placed at the end of the page.</p>
        </div>
    </div>
    <div class="td-box-row-margin-bottom">
        <?php
        echo td_panel_generator::html_editor(array(
            'ds' => 'td_option',
            'option_id' => 'tds_custom_html',
        ));
        ?>
    </div>
<?php echo td_panel_generator::box_end();