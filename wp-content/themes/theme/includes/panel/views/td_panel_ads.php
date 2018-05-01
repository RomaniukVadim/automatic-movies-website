<?php

echo td_panel_generator::box_start('Header ad', false);?>
    <!-- ad box code -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">YOUR HEADER AD</span>
            <p>Paste your ad code here. Google adsense will be made responsive automatically. <br><br> To add non adsense responsive ads, <br> <a target="_blank" href="http://forum.tagdiv.com/using-other-ads/">click here</a></p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::textarea(array(
                'ds' => 'td_ads',
                'item_id' => 'header',
                'option_id' => 'ad_code',
            ));
            ?>
        </div>
    </div>


    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">Advance usage:</span>
            <p>If you leave the AdSense size boxes on Auto, the theme will automatically resize the <strong>google ads</strong>. For more info follow this <a href="http://forum.tagdiv.com/header-ad/" target="_blank">link</a></p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>

    <!-- disable ad on monitor -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON DESKTOP</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                    'ds' => 'td_ads',
                    'item_id' => 'header',
                    'option_id' => 'disable_m',
                    'true_value' => 'yes',
                    'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                         'ds' => 'td_ads',
                         'item_id' => 'header',
                         'option_id' => 'm_size',
                         'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>
        </div>
    </div>


	<!-- disable ad on table landscape -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title td-title-on-row">DISABLE ON TABLET LANDSCAPE</span>
			<p></p>
		</div>
		<div class="td-box-control-full">
	            <span>
	            <?php
	            echo td_panel_generator::checkbox(array(
		            'ds' => 'td_ads',
		            'item_id' => 'header',
		            'option_id' => 'disable_tl',
		            'true_value' => 'yes',
		            'false_value' => ''
	            ));
	            ?>
	            </span>
	            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
	                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
	                <span class="td-content-float-right">
	                    <?php
	                    echo td_panel_generator::dropdown(array(
		                    'ds' => 'td_ads',
		                    'item_id' => 'header',
		                    'option_id' => 'tl_size',
		                    'values' => td_panel_generator::$google_ad_sizes
	                    ));
	                    ?>
	            </span>
		</div>
	</div>


    <!-- disable ad on tablet portrait -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON TABLET PORTRAIT</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'header',
                'option_id' => 'disable_tp',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'header',
                        'option_id' => 'tp_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>


    <!-- disable ad on phones -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">DISABLE ON PHONE</span>
            <p>Google adsense requiers that you do not use big header ads on mobiles!</p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'header',
                'option_id' => 'disable_p',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'header',
                        'option_id' => 'p_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>
<?php echo td_panel_generator::box_end();?>




<?php echo td_panel_generator::box_start('Sidebar ad', false);?>

   <div class="td-box-row">
        <div class="td-box-description td-box-full">
             <span class="td-box-title">Notice:</span>
             <p>To show the ads on the sidebar, please drag the "[taDiv] Ad box" widget to the desired sidebar. </p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
   </div>

    <!-- ad box code -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">YOUR SIDEBAR AD</span>
            <p>Paste your ad code here. Google adsense will be made responsive automatically. <br><br> To add non adsense responsive ads, <br> <a target="_blank" href="http://forum.tagdiv.com/using-other-ads/">click here</a> (last paragraph)</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::textarea(array(
                'ds' => 'td_ads',
                'item_id' => 'sidebar',
                'option_id' => 'ad_code',
            ));
            ?>
        </div>
    </div>


    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">Advance usage:</span>
            <p>If you leave the AdSense size boxes on Auto, the theme will automatically resize the <strong>google ads</strong>. For more info follow this <a href="http://forum.tagdiv.com/header-ad/" target="_blank">link</a></p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>


    <!-- disable ad on monitor -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON DESKTOP</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'sidebar',
                'option_id' => 'disable_m',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'sidebar',
                        'option_id' => 'm_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>



	<!-- disable ad on table landscape -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title td-title-on-row">DISABLE ON TABLET LANDSCAPE</span>
			<p></p>
		</div>
		<div class="td-box-control-full">
	            <span>
	            <?php
	            echo td_panel_generator::checkbox(array(
		            'ds' => 'td_ads',
		            'item_id' => 'sidebar',
		            'option_id' => 'disable_tl',
		            'true_value' => 'yes',
		            'false_value' => ''
	            ));
	            ?>
	            </span>
	            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
	                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
	                <span class="td-content-float-right">
	                    <?php
	                    echo td_panel_generator::dropdown(array(
		                    'ds' => 'td_ads',
		                    'item_id' => 'sidebar',
		                    'option_id' => 'tl_size',
		                    'values' => td_panel_generator::$google_ad_sizes
	                    ));
	                    ?>
	            </span>
		</div>
	</div>




    <!-- disable ad on tablet portrait -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON TABLET PORTRAIT</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'sidebar',
                'option_id' => 'disable_tp',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'sidebar',
                        'option_id' => 'tp_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>


    <!-- disable ad on phones -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">DISABLE ON PHONE</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'sidebar',
                'option_id' => 'disable_p',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'sidebar',
                        'option_id' => 'p_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>
        </div>
    </div>

<?php echo td_panel_generator::box_end();?>



<?php echo td_panel_generator::box_start('Article top ad', false);?>

    <!-- ad box code -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">YOUR ARTICLE TOP AD</span>
            <p>Paste your ad code here. Google adsense will be made responsive automatically. <br><br> To add non adsense responsive ads, <br> <a target="_blank" href="http://forum.tagdiv.com/using-other-ads/">click here</a> (last paragraph)</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::textarea(array(
                'ds' => 'td_ads',
                'item_id' => 'content_top',
                'option_id' => 'ad_code',
            ));
            ?>
        </div>
    </div>


    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">Advance usage:</span>
            <p>If you leave the AdSense size boxes on Auto, the theme will automatically resize the <strong>google ads</strong>. For more info follow this <a href="http://forum.tagdiv.com/header-ad/" target="_blank">link</a></p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>


    <!-- disable ad on monitor -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON DESKTOP</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_top',
                'option_id' => 'disable_m',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_top',
                        'option_id' => 'm_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>


	<!-- disable ad on table landscape -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title td-title-on-row">DISABLE ON TABLET LANDSCAPE</span>
			<p></p>
		</div>
		<div class="td-box-control-full">
	            <span>
	            <?php
	            echo td_panel_generator::checkbox(array(
		            'ds' => 'td_ads',
		            'item_id' => 'content_top',
		            'option_id' => 'disable_tl',
		            'true_value' => 'yes',
		            'false_value' => ''
	            ));
	            ?>
	            </span>
	            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
	                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
	                <span class="td-content-float-right">
	                    <?php
	                    echo td_panel_generator::dropdown(array(
		                    'ds' => 'td_ads',
		                    'item_id' => 'content_top',
		                    'option_id' => 'tl_size',
		                    'values' => td_panel_generator::$google_ad_sizes
	                    ));
	                    ?>
	            </span>
		</div>
	</div>




    <!-- disable ad on tablet portrait -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON TABLET PORTRAIT</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_top',
                'option_id' => 'disable_tp',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_top',
                        'option_id' => 'tp_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>


    <!-- disable ad on phones -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">DISABLE ON PHONE</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_top',
                'option_id' => 'disable_p',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_top',
                        'option_id' => 'p_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>

<?php echo td_panel_generator::box_end();?>



<?php echo td_panel_generator::box_start('Article inline ad', false);?>

    <!-- ad box code -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">YOUR ARTICLE INLINE AD</span>
            <p>Paste your ad code here. Google adsense will be made responsive automatically. <br><br> To add non adsense responsive ads, <br> <a target="_blank" href="http://forum.tagdiv.com/using-other-ads/">click here</a> (last paragraph)</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::textarea(array(
                'ds' => 'td_ads',
                'item_id' => 'content_inline',
                'option_id' => 'ad_code',
            ));
            ?>
        </div>
    </div>

    <!-- After paragraph  //alignment & after paragraph settings only for inline ads-->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">AFTER PARAGRAPH:</span>
            <p>After how many paragraphs the ad will display. The theme will analyze the content of each post and it will inject an ad after the selected number of paragraphs</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_inline_ad_paragraph'
            ));
            ?>
        </div>
    </div>


    <!-- DISPLAY VIEW -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">AD POSITION IN CONTENT</span>
            <p>Ad position in content. Float left, full post width or float right.</p>
        </div>
        <div class="td-box-control-full td-panel-module">
            <?php
            echo td_panel_generator::visual_select_o(array(
                'ds' => 'td_option',
                'option_id' => 'tds_inline_ad_align',
                'values' => array(
                    array('text' => '', 'title' => '', 'val' => 'left', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/rec-left.png'),
                    array('text' => '', 'title' => '', 'val' => '', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/rec-center.png'),
                    array('text' => '', 'title' => '', 'val' => 'right', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/rec-right.png')
                )
            ));
            ?>
        </div>
    </div>


    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">Advance usage:</span>
            <p>If you leave the AdSense size boxes on Auto, the theme will automatically resize the <strong>google ads</strong>. For more info follow this <a href="http://forum.tagdiv.com/header-ad/" target="_blank">link</a></p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>


    <!-- disable ad on monitor -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON DESKTOP</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_inline',
                'option_id' => 'disable_m',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_inline',
                        'option_id' => 'm_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>



	<!-- disable ad on table landscape -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title td-title-on-row">DISABLE ON TABLET LANDSCAPE</span>
			<p></p>
		</div>
		<div class="td-box-control-full">
	            <span>
	            <?php
	            echo td_panel_generator::checkbox(array(
		            'ds' => 'td_ads',
		            'item_id' => 'content_inline',
		            'option_id' => 'disable_tl',
		            'true_value' => 'yes',
		            'false_value' => ''
	            ));
	            ?>
	            </span>
	            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
	                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
	                <span class="td-content-float-right">
	                    <?php
	                    echo td_panel_generator::dropdown(array(
		                    'ds' => 'td_ads',
		                    'item_id' => 'content_inline',
		                    'option_id' => 'tl_size',
		                    'values' => td_panel_generator::$google_ad_sizes
	                    ));
	                    ?>
	            </span>
		</div>
	</div>




    <!-- disable ad on tablet portrait -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON TABLET PORTRAIT</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_inline',
                'option_id' => 'disable_tp',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_inline',
                        'option_id' => 'tp_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>


    <!-- disable ad on phones -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">DISABLE ON PHONE</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_inline',
                'option_id' => 'disable_p',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_inline',
                        'option_id' => 'p_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>

<?php echo td_panel_generator::box_end();?>



<?php echo td_panel_generator::box_start('Article bottom ad', false);?>

    <!-- ad box code -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">YOUR ARTICLE BOTTOM AD</span>
            <p>Paste your ad code here. Google adsense will be made responsive automatically. <br><br> To add non adsense responsive ads, <br> <a target="_blank" href="http://forum.tagdiv.com/using-other-ads/">click here</a> (last paragraph)</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::textarea(array(
                'ds' => 'td_ads',
                'item_id' => 'content_bottom',
                'option_id' => 'ad_code',
            ));
            ?>
        </div>
    </div>


    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">Advance usage:</span>
            <p>If you leave the AdSense size boxes on Auto, the theme will automatically resize the <strong>google ads</strong>. For more info follow this <a href="http://forum.tagdiv.com/header-ad/" target="_blank">link</a></p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>


    <!-- disable ad on monitor -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON DESKTOP</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_bottom',
                'option_id' => 'disable_m',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_bottom',
                        'option_id' => 'm_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>


	<!-- disable ad on table landscape -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title td-title-on-row">DISABLE ON TABLET LANDSCAPE</span>
			<p></p>
		</div>
		<div class="td-box-control-full">
	            <span>
	            <?php
	            echo td_panel_generator::checkbox(array(
		            'ds' => 'td_ads',
		            'item_id' => 'content_bottom',
		            'option_id' => 'disable_tl',
		            'true_value' => 'yes',
		            'false_value' => ''
	            ));
	            ?>
	            </span>
	            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
	                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
	                <span class="td-content-float-right">
	                    <?php
	                    echo td_panel_generator::dropdown(array(
		                    'ds' => 'td_ads',
		                    'item_id' => 'content_bottom',
		                    'option_id' => 'tl_size',
		                    'values' => td_panel_generator::$google_ad_sizes
	                    ));
	                    ?>
	            </span>
		</div>
	</div>



    <!-- disable ad on tablet portrait -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row">DISABLE ON TABLET PORTRAIT</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_bottom',
                'option_id' => 'disable_tp',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_bottom',
                        'option_id' => 'tp_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>


    <!-- disable ad on phones -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">DISABLE ON PHONE</span>
            <p></p>
        </div>
        <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => 'content_bottom',
                'option_id' => 'disable_p',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => 'content_bottom',
                        'option_id' => 'p_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

        </div>
    </div>

<?php echo td_panel_generator::box_end();?>



<?php
//backround add
echo td_panel_generator::box_start('Background click Ad', false);?>

    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">Notice:</span>
            <p>Please go to <strong>BACKGROUND</strong> tab if you also need a background image</p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>

    <!-- ad box code -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">URL</span>
            <p>Paste your link here like : http://www.domain.com</p>
        </div>
        <div class="td-box-control-full td-panel-input-wide">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_background_click_url',
            ));
            ?>
        </div>
    </div>


    <!-- ad taget -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Open in new window</span>
            <p>If enabled, this option will open the URL in a new window. Leave disabled for the URL to be loaded in current page</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_background_click_target',
                'true_value' => '_blank',
                'false_value' => ''
            ));
            ?>
        </div>
    </div>

<?php  echo td_panel_generator::box_end();?>

<?php
echo td_panel_generator::ajax_box('Post template style 1 ', array(
		'td_ajax_calling_file' => basename(__FILE__),
		'td_ajax_box_id' => 'td_get_ad_spot_by_id',
		'ad_spot_id' => 'post_style_1'
	)
);
?>

<?php
echo td_panel_generator::ajax_box('Post template style 11 ', array(
		'td_ajax_calling_file' => basename(__FILE__),
		'td_ajax_box_id' => 'td_get_ad_spot_by_id',
		'ad_spot_id' => 'post_style_11'
	)
);
?>

<?php
echo td_panel_generator::ajax_box('Post template style 12, 13 ', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_get_ad_spot_by_id',
        'ad_spot_id' => 'post_style_12'
    )
);
?>

<?php
echo td_panel_generator::ajax_box('Smart list 6 ', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_get_ad_spot_by_id',
        'ad_spot_id' => 'smart_list_6'
    )
);
?>

<?php
echo td_panel_generator::ajax_box('Smart list 7 ', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_get_ad_spot_by_id',
        'ad_spot_id' => 'smart_list_7'
    )
);
?>

<?php
echo td_panel_generator::ajax_box('Smart list 8 ', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_get_ad_spot_by_id',
        'ad_spot_id' => 'smart_list_8'
    )
);
?>

<?php
echo td_panel_generator::ajax_box('Footer top ', array(
		'td_ajax_calling_file' => basename(__FILE__),
		'td_ajax_box_id' => 'td_get_ad_spot_by_id',
		'ad_spot_id' => 'footer_top'
	)
);
?>

<!-- custom ads -->
<?php
    echo td_panel_generator::ajax_box('Custom ad 1', array(
            'td_ajax_calling_file' => basename(__FILE__),
            'td_ajax_box_id' => 'td_get_ad_spot_by_id',
            'ad_spot_id' => 'custom_ad_1'
        )
    );
?>


<?php
echo td_panel_generator::ajax_box('Custom ad 2', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_get_ad_spot_by_id',
        'ad_spot_id' => 'custom_ad_2'
    )
);
?>

<?php
echo td_panel_generator::ajax_box('Custom ad 3', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_get_ad_spot_by_id',
        'ad_spot_id' => 'custom_ad_3'
    )
);
?>


<?php
echo td_panel_generator::ajax_box('Custom ad 4', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_get_ad_spot_by_id',
        'ad_spot_id' => 'custom_ad_4'
    )
);
?>

<?php
echo td_panel_generator::ajax_box('Custom ad 5', array(
        'td_ajax_calling_file' => basename(__FILE__),
        'td_ajax_box_id' => 'td_get_ad_spot_by_id',
        'ad_spot_id' => 'custom_ad_5'
    )
);
?>
