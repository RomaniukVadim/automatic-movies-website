<?php

function td_first_install_setup() {
    $td_isFirstInstall = td_util::get_option('firstInstall');
    if (empty($td_isFirstInstall)) {
        td_util::update_option('firstInstall', 'themeInstalled');

        wp_insert_term('Featured', 'category', array(
            'description' => 'Featured posts',
            'slug' => 'featured',
            'parent' => 0
        ));

        // bulk enable all the theme thumbs!
        $td_theme_thumbs = td_api_thumb::get_all();
        foreach ($td_theme_thumbs as $td_theme_thumb_id => $td_theme_thumb_params) {
            td_global::$td_options['tds_thumb_' . $td_theme_thumb_id] = 'yes';
        }
        update_option(TD_THEME_OPTIONS_NAME, td_global::$td_options); // force an update of the options ()

    }
}
td_first_install_setup();



function td_after_theme_is_activated() {
    global $pagenow;
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
        wp_redirect(admin_url('admin.php?page=td_theme_welcome'));
        exit;
    }
}
td_after_theme_is_activated();




function td_theme_migration() {
	$td_db_version = td_util::get_option('td_version');


    // empty -> any version
	if (empty($td_db_version)) {

		// wp_parse_args format
		$args = array(
			'post_type' => array('page', 'post'),
			'numberposts' => '200',
			'orderby' => 'post_date',
			'order' => 'DESC',

			'meta_query' => array(
				'relation' => 'OR',
				array('key' => 'td_homepage_loop_filter'),
				array('key' => 'td_unique_articles'),
				array('key' => 'td_smart_list'),
				array('key' => 'td_review')
			),
			'update_post_term_cache' => false,
		);

		$recent_posts = wp_get_recent_posts($args);

		foreach ($recent_posts as $recent_post) {

			// page settings
			$update_td_homepage_loop = false;
			$td_homepage_loop = get_post_meta($recent_post['ID'], 'td_homepage_loop');
			$td_page = get_post_meta($recent_post['ID'], 'td_page');
			$td_homepage_loop_filter = get_post_meta($recent_post['ID'], 'td_homepage_loop_filter');
			$td_unique_articles = get_post_meta($recent_post['ID'], 'td_unique_articles');

			if (!empty($td_homepage_loop_filter) and is_array($td_homepage_loop_filter) and (count($td_homepage_loop_filter) > 0)) {
				foreach ($td_homepage_loop_filter[0] as $filter_key => $filter_value) {
					$td_homepage_loop[0][$filter_key] = $filter_value;
				}
				$update_td_homepage_loop = true;
			}

			if (!empty($td_unique_articles) and is_array($td_unique_articles) and (count($td_unique_articles) > 0)) {
				foreach ($td_unique_articles[0] as $filter_key => $filter_value) {
					$td_homepage_loop[0][$filter_key] = $filter_value;
					$td_page[0][$filter_key] = $filter_value;
				}
				$update_td_homepage_loop = true;
			}

			if ($update_td_homepage_loop === true) {
				update_post_meta($recent_post['ID'], 'td_homepage_loop', $td_homepage_loop[0]);
				update_post_meta($recent_post['ID'], 'td_page', $td_page[0]);
			}





			// post settings
			$update_td_post_theme_settings = false;
			$td_post_theme_settings = get_post_meta($recent_post['ID'], 'td_post_theme_settings');
			$td_smart_list = get_post_meta($recent_post['ID'], 'td_smart_list');
			$td_review = get_post_meta($recent_post['ID'], 'td_review');

			if (!empty($td_review) and is_array($td_review) and (count($td_review) > 0)) {
				foreach ($td_review[0] as $filter_key => $filter_value) {
					$td_post_theme_settings[0][$filter_key] = $filter_value;
				}
				$update_td_post_theme_settings = true;
			}

			if (!empty($td_smart_list) and is_array($td_smart_list) and (count($td_smart_list) > 0)) {
				foreach ($td_smart_list[0] as $filter_key => $filter_value) {
					$td_post_theme_settings[0][$filter_key] = $filter_value;
				}
				$update_td_post_theme_settings = true;
			}

			if ($update_td_post_theme_settings === true) {
				update_post_meta($recent_post['ID'], 'td_post_theme_settings', $td_post_theme_settings[0]);
			}

			//delete_post_meta($recent_post['ID'], 'td_homepage_loop_filter');
			//delete_post_meta($recent_post['ID'], 'td_unique_articles');
			//delete_post_meta($recent_post['ID'], 'td_smart_list');
			//delete_post_meta($recent_post['ID'], 'td_review');
		}

		// the following delete operations must be done
		//delete_post_meta_by_key('td_homepage_loop_filter');
		//delete_post_meta_by_key('td_unique_articles');
		//delete_post_meta_by_key('td_smart_list');
		//delete_post_meta_by_key('td_review');
	}


    // update the database version
    if ($td_db_version != TD_THEME_VERSION) {
        td_util::update_option('td_version', TD_THEME_VERSION);
    }


}
td_theme_migration();
