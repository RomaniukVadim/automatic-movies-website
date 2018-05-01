<!-- HEADER STYLE -->
<?php echo td_panel_generator::box_start('Header Style'); ?>


    <!-- HEADER STYLE -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">HEADER STYLE</span>
            <p>Select the order in which the header elements will be arranged</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_option',
                'option_id' => 'tds_header_style',
                'values' => td_api_header_style::_helper_generate_tds_header_style()
            ));
            ?>
        </div>
    </div>


<?php echo td_panel_generator::box_end();?>




<!-- TOP BAR -->
<?php echo td_panel_generator::box_start('Top Bar', false); ?>


    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <p>
            The top bar is the black top menu. It is very useful when you want to add a <i>login option, social icons</i> and pages like <i>About us, Contact us etc..</i>.
            If you are an advanced user and want to customize it or register new top bar layouts, have a look at our <a target="_blank" href="http://forum.tagdiv.com/api-top-bar-template-introduction/">top bar template API</a>
            </p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>

    <!-- Top bar: enable disable -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Enable top bar</span>
            <p>Hide or show the bar.</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_top_bar',
                'true_value' => '',
                'false_value' => 'hide_top_bar'
            ));
            ?>
        </div>
    </div>



    <?php if (count(td_api_top_bar_template::get_all()) >  0 ) { ?>
        <!-- Top bar template -->
        <div class="td-box-row">
            <div class="td-box-description">
                <span class="td-box-title">Top bar layout</span>
                <p>How to order the top bar items</p>
            </div>
            <div class="td-box-control-full">
                <?php
                echo td_panel_generator::visual_select_o(array(
                    'ds' => 'td_option',
                    'option_id' => 'tds_top_bar_template',
                    'values' => td_api_top_bar_template::_helper_to_panel_values()
                ));
                ?>
            </div>
        </div>
    <?php } ?>



<div class="td-box-section-separator"></div>



    <!-- Top menu: enable disable -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Show top menu</span>
            <p>Hide or show the top menu. To hide the social icons: Header ⇢ Social networks</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_top_menu',
                'true_value' => '',
                'false_value' => 'hide'
            ));
            ?>
        </div>
    </div>


    <!-- Top menu: select menu -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Select the top menu</span>
            <p>Select a menu for the top section</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::dropdown(array(
                'ds' => 'wp_theme_menu_spot',
                'option_id' => 'top-menu',
                'values' => td_panel_generator::get_user_created_menus()
            ));
            ?>
        </div>
    </div>



<div class="td-box-section-separator"></div>



    <!-- Social networks: enable disable -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Show social icons</span>
            <p>Enable / Disable social networks in top menu</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'td_social_networks_show',
                'true_value' => 'show',
                'false_value' => ''
            ));
            ?>
        </div>
    </div>



<div class="td-box-section-separator"></div>



    <!-- Sign In / Join: enable disable -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Show sign in / join</span>
            <p>Enable/disable the theme login modal. (default is disabled).
                <?php td_util::tooltip_html('
                        <h3>Show sign in / join:</h3>
                        <ul>
                            <li>If it\'s enabled the Sign In / Register link shows up in the top menu</li>
                            <li>If it\'s enabled but the top menu is disabled the modal will still appear for users who want to post a comment(if posting a comment is set to require login/registration)</li>
                            <li>If it\'s disabled the login/registration will be done via the wordpress default interface</li>
                        </ul>
                ', 'right')?>
            </p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_login_sign_in_widget',
                'true_value' => 'show',
                'false_value' => ''
            ));
            ?>
        </div>
    </div>



<div class="td-box-section-separator"></div>


    <!-- Date: enable disable -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">SHOW DATE</span>
            <p>Hide or show the date in the top menu</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_data_top_menu',
                'true_value' => 'show',
                'false_value' => ''
            ));
            ?>
        </div>
    </div>



    <!-- Date: format -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">DATE FORMAT</span>
            <p>Default value: l, F j, Y. <a href="http://php.net/manual/en/function.date.php">Read more</a> about the date format (it's the same with the php date function)</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_data_time_format'
            ));
            ?>
        </div>
    </div>

    <!-- Date: format -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">JAVASCRIPT DATE</span>
            <p>Enable this if you use a cache plugin, it displays the local data.</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_option',
                'option_id' => 'tds_data_js',
                'true_value' => 'true',
                'false_value' => ''
            ));
            ?>
        </div>
    </div>

<?php if (td_global::$feature_locked === false) { ?>
<div class="td-box-section-separator"></div>
	<!-- Weather: enable disable -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title">SHOW WEATHER</span>
			<p>Hide or show the weather info in the top menu</p>
		</div>
		<div class="td-box-control-full">
			<?php
			echo td_panel_generator::checkbox(array(
				'ds' => 'td_option',
				'option_id' => 'tds_weather_top_menu',
				'true_value' => 'show',
				'false_value' => ''
			));
			?>
		</div>
	</div>


	<!-- Weather: location -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title">Location</span>
			<p><a href="http://openweathermap.org/find" target="_blank">Find your location</a> - You can use "city name" (ex: London) or "city name,country code" (ex: London,uk)</p>
		</div>
		<div class="td-box-control-full">
			<?php
			echo td_panel_generator::input(array(
				'ds' => 'td_option',
				'option_id' => 'tds_weather_location_top_menu'
			));
			?>
		</div>
	</div>


	<!-- Weather: Units -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title">Units</span>
			<p>Choose what units to use when showing the temperature</p>
		</div>
		<div class="td-box-control-full">
			<?php
			echo td_panel_generator::radio_button_control(array(
				'ds' => 'td_option',
				'option_id' => 'tds_weather_units_top_menu',
				'values' => array(
					array('text' => 'Celsius', 'val' => ''),
					array('text' => 'Fahrenheit', 'val' => 'imperial')
				)
			));
			?>
		</div>
	</div>
<?php } ?>



<?php echo td_panel_generator::box_end();?>


<!-- MAIN MENU -->
<?php echo td_panel_generator::box_start('Main Menu', false); ?>

    <!-- MAIN MENU -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Header menu (main)</span>
            <p>Select a menu for the main header section</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::dropdown(array(
                'ds' => 'wp_theme_menu_spot',
                'option_id' => 'header-menu',
                'values' => td_panel_generator::get_user_created_menus()
            ));
            ?>
        </div>
    </div>

    <!-- Mega menu preload -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Mega menu preloader</span>
            <p>Preload content for all mega menus. This provides a better user experience but with a performance hit - <a href="http://forum.tagdiv.com/what-is-ajax-preloading/" target="_blank">read more</a></p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_option',
                'option_id' => 'tds_mega_menu_ajax_preloading',
                'values' => array (
                    array('text' => '<strong>No preloading</strong> - default', 'val' => ''),
                    array('text' => '<strong>Optimized preloading</strong>', 'val' => 'preload'),
                    array('text' => '<strong>Preload all </strong>', 'val' => 'preload_all')
                )
            ));
            ?>
        </div>
    </div>

    <div class="td-box-section-separator"></div>

    <!-- STICKY MENU -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">STICKY MENU</span>
            <p>How to display the header menu on scroll</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_option',
                'option_id' => 'tds_snap_menu',
                'values' => array (
                    array('text' => '<strong>Normal menu</strong> - (not sticky)', 'val' => ''),
                    array('text' => '<strong>Always sticky</strong> - stays at the top of the page', 'val' => 'snap'),
                    array('text' => '<strong>Smart snap </strong> - (mobile)', 'val' => 'smart_snap_mobile'),
                    array('text' => '<strong>Smart snap </strong> - (always)', 'val' => 'smart_snap_always'),
                )
            ));
            ?>
        </div>
    </div>

	<!-- SHOW THE MOBILE LOGO ON THE STICKY MENU -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title">LOGO ON STICKY MENU</span>
			<p>Show / Hide the Logo on sticky menu</p>
			<p><strong>Notice: </strong>If you choose <strong>Mobile logo</strong>, upload a logo in <strong>Logo for Mobile</strong> section</p>
		</div>
		<div class="td-box-control-full">
			<?php
			echo td_panel_generator::radio_button_control(array(
				'ds' => 'td_option',
				'option_id' => 'tds_logo_on_sticky',
				'values' => array (
					array('text' => '<strong>Disabled</strong>', 'val' => ''),
					array('text' => '<strong>Header logo </strong> - show the header logo', 'val' => 'show_header_logo'),
					array('text' => '<strong>Mobile logo </strong> - show the mobile logo', 'val' => 'show'),
				)
			));
			?>
		</div>
	</div>

<?php echo td_panel_generator::box_end();?>


<!-- LOGO -->
<?php echo td_panel_generator::box_start('Logo &amp; Favicon', false); ?>

    <!-- LOGO UPLOAD -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">LOGO UPLOAD</span>
            <p>Upload your logo (272 x 90px) .png or .jpg</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_logo_upload'
            ));
            ?>
        </div>
    </div>

    <!-- RETINA LOGO UPLOAD -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">RETINA LOGO UPLOAD</span>
            <p>Upload your retina logo (544 x 180px) .png or .jpg. </p>
            <ul>
                <li>If you do not set any retina logo, the site will load the normal logo on retina displays</li>
                <li>The retina logo has to have the same file format with the normal logo</li>
            </ul>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_logo_upload_r'
            ));
            ?>
        </div>
    </div>


    <!-- FAVICON -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">FAVICON</span>
            <p>Optional - upload a favicon image <br>(16 x 16px) .png</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_favicon_upload'
            ));
            ?>
        </div>
    </div>


    <!-- Logo ALT attribute -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">LOGO ALT ATTRIBUTE</span>
            <p><a href="http://www.w3schools.com/tags/att_img_alt.asp" target="_blank">Alt attribute</a> for the logo. This is the alternative text if the logo cannot be displayed. It's useful for SEO and generally is the name of the site.</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_logo_alt'
            ));
            ?>
        </div>
    </div>


    <!-- Logo TITLE attribute -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">LOGO TITLE ATTRIBUTE</span>
            <p><a href="http://www.w3schools.com/tags/att_global_title.asp" target="_blank">Title attribute</a> for the logo. This attribute specifies extra information about the logo. Most browsers will show a tooltip with this text on logo hover.</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_logo_title'
            ));
            ?>
        </div>
    </div>


    <div class="td-box-row" style="margin-top: 85px;">
        <div class="td-box-description td-box-full">
            <span class="td-box-title"><?php echo td_global::$td_wp_admin_text_list['text_header_logo'] ?></span>
            <p><?php echo td_global::$td_wp_admin_text_list['text_header_logo_description'] ?></p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>

	<!-- Text LOGO -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title">TEXT LOGO</span>
			<p>Write a text logo</p>
		</div>
		<div class="td-box-control-full">
			<?php
			echo td_panel_generator::input(array(
				'ds' => 'td_option',
				'option_id' => 'tds_logo_text',
				'placeholder' => strtoupper(TD_THEME_NAME)
			));
			?>
		</div>
	</div>


	<!-- Text LOGO Tagline -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title">TEXT LOGO TAGLINE</span>
			<p>Write a tagline for the text logo</p>
		</div>
		<div class="td-box-control-full">
			<?php
			echo td_panel_generator::input(array(
				'ds' => 'td_option',
				'option_id' => 'tds_tagline_text',
				'placeholder' => 'DISCOVER THE ART OF PUBLISHING'
			));
			?>
		</div>
	</div>
<?php echo td_panel_generator::box_end();?>



<!-- LOGO for MOBILE-->
<?php echo td_panel_generator::box_start('Logo for Mobile', false); ?>


    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <p>You can optionally load a different logo on mobile phones and small screens. Usually the logo is smaller so that it can fit in the smart affix menu. iPhone, iPad, Samsung S3 S4 S5 and a lot of phones use the retina logo.</p>
            <p>If you don't upload any Logo Mobile by default will be used the Logo that you uploaded in the section above. This Option is recommended when your logo will not scale perfect on mobile devices.</p>
	        <p><strong>Notice: </strong>Don't upload a logo for Mobile if you use <strong>Header Style: </strong><?php echo td_global::$td_wp_admin_text_list['text_header_logo_mobile'] ?></strong>, It's not necessary.</p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>



	<!-- LOGO MOBILE -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title">LOGO MOBILE</span>
			<p>Upload your logo</p>
            <p><strong>Note: </strong>For best results logo mobile size: <?php echo td_global::$td_wp_admin_text_list['text_header_logo_mobile_image'] ?></p>
		</div>
		<div class="td-box-control-full">
			<?php
			echo td_panel_generator::upload_image(array(
				'ds' => 'td_option',
				'option_id' => 'tds_logo_menu_upload'
			));
			?>
		</div>
	</div>

	<!-- RETINA LOGO MOBILE IN MENU UPLOAD -->
	<div class="td-box-row">
		<div class="td-box-description">
			<span class="td-box-title">RETINA LOGO MOBILE</span>
			<p>Upload your retina logo (double size)</p>
            <p><strong>Note: </strong>For best results retina logo mobile size: <?php echo td_global::$td_wp_admin_text_list['text_header_logo_mobile_image_retina'] ?></p>
		</div>
		<div class="td-box-control-full">
			<?php
			echo td_panel_generator::upload_image(array(
				'ds' => 'td_option',
				'option_id' => 'tds_logo_menu_upload_r'
			));
			?>
		</div>
	</div>

<?php echo td_panel_generator::box_end();?>





<!-- iOS Bookmarklet -->
<?php echo td_panel_generator::box_start('iOS Bookmarklet', false); ?>

    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <p>The bookmarklets work on iOS and Android. When a user adds your site to the home screen, the phone will download one of the icons from here (based on the screen size and device type) and your site will appear with that icon on the homes creen</p>
        </div>
        <div class="td-box-row-margin-bottom"></div>
    </div>



    <!-- iOS bookmarklet 76x76 -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">IMAGE 76 x 76</span>
            <p>Upload your icon (76 x 76px) .png</p>
        </div>
        <div class="td-box-control-full">
            <?php // ipad mini non retina + ipad 2
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_ios_icon_76'
            ));
            ?>
        </div>
    </div>


    <!-- iOS bookmarklet 114x114 -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">IMAGE 114 x 114</span>
            <p>Upload your icon (114 x 114px) .png</p>
        </div>
        <div class="td-box-control-full">
            <?php  // iphone retina ios6
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_ios_icon_114'
            ));
            ?>
        </div>
    </div>


    <!-- iOS bookmarklet 120x120 -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">IMAGE 120 x 120</span>
            <p>Upload your icon (120 x 120px) .png</p>
        </div>
        <div class="td-box-control-full">
            <?php // iphone retina ioS7
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_ios_icon_120'
            ));
            ?>
        </div>
    </div>


    <!-- iOS bookmarklet 144x144 -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">IMAGE 144 x 144</span>
            <p>Upload your icon (144 x 144px) .png</p>
        </div>
        <div class="td-box-control-full">
            <?php // ipad retina ios6
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_ios_icon_144'
            ));
            ?>
        </div>
    </div>


    <!-- iOS bookmarklet 152x152 -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">IMAGE 152 x 152</span>
            <p>Upload your icon (152 x 152px) .png</p>
        </div>
        <div class="td-box-control-full">
            <?php // ipad retina ios7
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_option',
                'option_id' => 'tds_ios_icon_152'
            ));
            ?>
        </div>
    </div>


<?php echo td_panel_generator::box_end();?>

