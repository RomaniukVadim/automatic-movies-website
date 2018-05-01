
<div class="td-header-sp-top-menu">


	<?php
	// show the weather if needed
	if (td_util::get_option('tds_weather_top_menu') == 'show') {
		$atts['w_location'] = td_util::get_option('tds_weather_location_top_menu');
		$atts['w_units'] = td_util::get_option('tds_weather_units_top_menu');
		// render the weather
		echo td_weather::render_generic($atts, 'td_top_weather_uid', 'top_bar_template');
	}



	// show the date and time if needed
    if (td_util::get_option('tds_data_top_menu') == 'show') {
        $tds_data_time = td_util::get_option('tds_data_time_format');
        if ($tds_data_time == '') {
            $tds_data_time = 'l, F j, Y';
        }
        // if the js date is enabled hide the default one
        $td_date_visibility = '';
        if (td_util::get_option('tds_data_js') == 'true') {
            $td_date_visibility = 'style="visibility:hidden;"';
        }
        ?>
        <div class="td_data_time">
            <div <?php echo $td_date_visibility ?>>

                <?php echo date_i18n(stripslashes($tds_data_time)); ?>

            </div>
        </div>
    <?php
    }




    //show login widget
    if (td_util::get_option('tds_login_sign_in_widget') == 'show') {
        //test if user is logd in or not
        if ( is_user_logged_in() ) {
            //get current logd in user data
            global $current_user;

            //<span class="td-sp-ico-logout"></span>
            echo '<ul class="top-header-menu td_ul_logout">
                        <li class="menu-item">' .
                            get_avatar($current_user->ID, 20) . '<a href="' . get_author_posts_url($current_user->ID) . '" class="td_user_logd_in">' . $current_user->display_name . '</a>' .
                        '</li>
                        <li class="menu-item">
                            <a href="' . wp_logout_url(home_url( '/' )) . '"><i class="td-icon-logout"></i>' . __td('Logout', TD_THEME_NAME) . '</a>
                        </li>
                 </ul>';
        } else {

            echo '<ul class="top-header-menu td_ul_login"><li class="menu-item"><a class="td-login-modal-js menu-item" href="#login-form" data-effect="mpf-td-login-effect">' . __td('Sign in / Join', TD_THEME_NAME) . '</a><span class="td-sp-ico-login td_sp_login_ico_style"></span></li></ul>';
        }
    }//end login window



if (td_util::get_option('tds_top_menu') != 'hide') {
    //shows top menu
    wp_nav_menu(array(
        'theme_location' => 'top-menu',
        'menu_class' => 'top-header-menu',
        'fallback_cb' => 'td_wp_top_menu',
        'container_class' => 'menu-top-container'
    ));

    //if no top menu is set show link to create new menu
    function td_wp_top_menu()
    {
        echo '<ul class="top-header-menu">';
        echo '<li class="menu-item-first"><a href="' . esc_url(home_url('/')) . 'wp-admin/nav-menus.php?action=locations">Click here - to select or create a menu</a></li>';
        echo '</ul>';
    }
}

?>
</div>
