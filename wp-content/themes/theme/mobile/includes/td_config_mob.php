<?php


class td_config_mob {

	/**
	 * setup the global theme specific variables.
	 * @depends td_global
	 */
	static function on_td_global_after_config() {

        /**
         * js files list
         */
        td_global::$js_files = array(
            'tdExternal' =>             '/mobile/includes/js_dev/tdExternal.js',
            'tdDetect' =>               '/mobile/includes/js_dev/tdDetect.js',
            'tdUtil' =>                 '/mobile/includes/js_dev/tdUtil.js',
            'tdSite' =>                 '/mobile/includes/js_dev/tdSite.js',
            'tdAjaxSearch' =>           '/mobile/includes/js_dev/tdAjaxSearch.js',
            'vimeo_froogaloop' =>       '/mobile/includes/js_dev/vimeo_froogaloop.js',
            'tdVideoPlaylist' =>        '/mobile/includes/js_dev/tdVideoPlaylist.js',
            'tdEvents' =>               '/mobile/includes/js_dev/tdEvents.js',
            'tdAjaxCount' =>            '/mobile/includes/js_dev/tdAjaxCount.js',
            'tdCustomEvents' =>         '/mobile/includes/js_dev/tdCustomEvents.js',
            'tdAffix' =>                '/mobile/includes/js_dev/tdAffix.js',
            'tdLogin' =>                '/mobile/includes/js_dev/tdLogin.js',
        );

		/*
		 * !Important.
		 *
		 * 1. For mobile theme specific variables, the registration is done using 'add'.
		 * These usually reference the specific files from mobile theme.
		 *
		 * 2. For the variables that are usually registered by the main theme, the registration is done with 'update'.
		 * This is necessary because in wp admin, these are already registered by the main theme, and because of this we can't use 'add'
		 * (ERROR: the component is already registered)
		 * Anyway, in the front end, they are NOT registered by the main theme, and the 'update' method does what actually 'add' does.
		 * It registers the component to be used.
		 *
		 * An alternative way for doing this, it would be to copy the file from the main theme to the mobile theme, and to register
		 * the component as the new one, with a new id, using the 'add' method.
		 */

		/**
		 * modules list
		 */
		$td_api_module_components = td_api_module::get_all();

		// The get_template_directory on mobile theme is finishing in 'mobile/', but on wp admin, using
		// the live search from desktop agent (!Important), the mobile theme isn't set,
		// so a consistent path must be specified.
		//
		// That's why the td_global::$get_templated_directory is used instead of get_template_directory()

		td_api_module::add('td_module_single_mob',
			array(  // this module is for internal use only

				//'file' => get_template_directory() . 'includes/modules/td_module_single_mob.php',
				'file' => td_global::$get_template_directory . '/mobile/includes/modules/td_module_single_mob.php',
				'text' => 'Single Module',
				'img' => '',
				'used_on_blocks' => '',
				'excerpt_title' => '',
				'excerpt_content' => '',
				'enabled_on_more_articles_box' => false,
				'enabled_on_loops' => false,
				'uses_columns' => false,                      // if the module uses columns on the page template + loop
				'category_label' => false,
				'class' => '',
				'group' => 'mob' // '' - main theme, 'mob' - mobile theme, 'woo' - woo theme
			)
		);

		td_api_module::add('td_module_mob_1',
			array(


				//'file' => get_template_directory() . 'includes/modules/td_module_mob_1.php',
				'file' => td_global::$get_template_directory . '/mobile/includes/modules/td_module_mob_1.php',
				'text' => 'Module M1',
				'img' => td_global::$get_template_directory . '/mobile/images/panel/modules/td_module_51.png', // must be changed
				'used_on_blocks' => array('td_block_3'),
				'excerpt_title' => 12,
				'excerpt_content' => '',
				'enabled_on_more_articles_box' => false,
				'enabled_on_loops' => true,
				'uses_columns' => false,
				'category_label' => true,
				'class' => 'td_module_wrap td-animation-stack',
				'group' => 'mob' // '' - main theme, 'mob' - mobile theme, 'woo' - woo theme
			)
		);

		td_api_module::add('td_module_mob_2',
			array(
				'file' => td_global::$get_template_directory . '/mobile/includes/modules/td_module_mob_2.php',
				'text' => 'Module M2',
				'img' => td_global::$get_template_directory . '/mobile/images/panel/modules/td_module_52.png', // must be changed
				'used_on_blocks' => array('td_block_3'),
				'excerpt_title' => 12,
				'excerpt_content' => '',
				'enabled_on_more_articles_box' => false,
				'enabled_on_loops' => true,
				'uses_columns' => false,
				'category_label' => true,
				'class' => 'td_module_wrap td-animation-stack',
				'group' => 'mob' // '' - main theme, 'mob' - mobile theme, 'woo' - woo theme
			)
		);

		if (!array_key_exists('td_module_mx9', $td_api_module_components)) {
			td_api_module::add('td_module_mx9',
				array(
					'file'                         => td_global_mob::$get_parent_template_directory . '/includes/modules/td_module_mx9.php',
					'text'                         => 'Module MX9',
					'img'                          => '',
					'used_on_blocks'               => array( 'tdm_block_big_grid_2' ),
					'excerpt_title'                => 25,
					'excerpt_content'              => '',
					'enabled_on_more_articles_box' => false,
					'enabled_on_loops'             => false,
					'uses_columns'                 => false,
					'category_label'               => true,
					'class'                        => 'td-animation-stack',
					'group'                        => 'mob' // '' - main theme, 'mob' - mobile theme, 'woo' - woo theme
				)
			);
		}

		if (!array_key_exists('td_module_mx10', $td_api_module_components)) {
			td_api_module::add( 'td_module_mx10',
				array(
					'file'                         => td_global_mob::$get_parent_template_directory . '/includes/modules/td_module_mx10.php',
					'text'                         => 'Module MX10',
					'img'                          => '',
					'used_on_blocks'               => array( 'tdm_block_big_grid_2' ),
					'excerpt_title'                => 25,
					'excerpt_content'              => '',
					'enabled_on_more_articles_box' => false,
					'enabled_on_loops'             => false,
					'uses_columns'                 => false,
					'category_label'               => true,
					'class'                        => 'td-animation-stack',
					'group'                        => 'mob' // '' - main theme, 'mob' - mobile theme, 'woo' - woo theme
				)
			);
		}




		/**
		 * thumb list
		 */
		$td_api_thumb_components = td_api_thumb::get_all();

		if (!array_key_exists('td_265x198', $td_api_thumb_components)) {
			td_api_thumb::add( 'td_265x198',
				array(
					'name'                  => 'td_265x198',
					'width'                 => 265,
					'height'                => 198,
					'crop'                  => array( 'center', 'top' ),
					'post_format_icon_size' => 'normal',
					'used_on'               => array(
						'Module M1'
					)
				)
			);
		}

		if (!array_key_exists('td_741x486', $td_api_thumb_components)) {
			td_api_thumb::add( 'td_741x486',
				array(
					'name'                  => 'td_741x486',
					'width'                 => 741,
					'height'                => 486,
					'crop'                  => array( 'center', 'top' ),
					'post_format_icon_size' => 'normal',
					'used_on'               => array(
						'Big grid M1'
					)
				)
			);
		}


		/**
		 * block templates - @todo momentan e din parent theme!
		 */
		$td_api_block_template_components = td_api_block_template::get_all();

		if (!array_key_exists('td_block_template_1', $td_api_block_template_components)) {
			td_api_block_template::add( 'td_block_template_1',
				array(
					'file' => td_global_mob::$get_parent_template_directory . '/includes/block_templates/td_block_template_1.php',
				)
			);
		}

		td_api_block::add('td_block_ad_box_mob',
			array(
				'map_in_visual_composer' => false,
				"name" => 'Ad box mobile',
				"base" => 'td_block_ad_box_mob',
				"class" => "",
				"controls" => "full",
				"category" => 'Blocks',
				'icon' => 'icon-pagebuilder-ads',
				'file' => td_global_mob::$get_parent_template_directory . '/mobile/includes/shortcodes/td_block_ad_box_mob.php',
			)
		);


        td_api_block::add('td_block_related_posts_mob',
            array(
                'map_in_visual_composer' => false,
                "name" => 'Mobile related posts',
                "base" => 'td_block_related_posts_mob',
                "class" => 'td_block_related_posts_mob',
                "controls" => "full",
                "category" => 'Blocks',
                'icon' => 'icon-pagebuilder-td_block_related_posts_mob',
                'file' => td_global::$get_template_directory . '/mobile/includes/shortcodes/td_block_related_posts_mob.php',
                "params" => td_config::td_block_big_grid_params(),
            )
        );

		/**
		 * block - @todo momentan e din parent theme!
		 */
		$td_api_block_components = td_api_block::get_all();

		td_api_block::add('td_block_big_grid_mob_1',
			array(
				'map_in_visual_composer' => false,
				"name" => 'Big Grid 1',
				"base" => 'td_block_big_grid_mob_1',
				"class" => 'td_block_big_grid_mob_1',
				"controls" => "full",
				"category" => 'Blocks',
				'icon' => 'icon-pagebuilder-td_block_big_grid_mob_1',
				'file' => get_template_directory() . '/includes/shortcodes/td_block_big_grid_mob_1.php',
				"params" => td_config::td_block_big_grid_params(),
			)
		);

		if (!array_key_exists('td_block_video_youtube', $td_api_block_components)) {
			td_api_block::add('td_block_video_youtube',
				array(
					'map_in_visual_composer' => true,
					"name" => 'Video Playlist',
					"base" => "td_block_video_youtube",
					"class" => "td_block_video_playlist_youtube",
					"controls" => "full",
					"category" => 'Blocks',
					'icon' => 'icon-pagebuilder-td-youtube',
					'file' => td_global_mob::$get_parent_template_directory . '/includes/shortcodes/td_block_video_youtube.php',
				)
			);
		}

		if (!array_key_exists('td_block_video_vimeo', $td_api_block_components)) {
			td_api_block::add('td_block_video_vimeo',
				array(
					'map_in_visual_composer' => true,
					"name"                   => 'Video Playlist',
					"base"                   => "td_block_video_vimeo",
					"class"                  => "td_block_video_playlist_vimeo",
					"controls"               => "full",
					"category"               => 'Blocks',
					'icon'                   => 'icon-pagebuilder-td-vimeo',
					'file'                   => td_global_mob::$get_parent_template_directory . '/includes/shortcodes/td_block_video_vimeo.php',
				)
			);
		}


		/**
		 * category templates
		 */
		td_api_category_template::add('td_category_template_mob_1',
			array (
				'file' => td_global::$get_template_directory . '/mobile/includes/category_templates/td_category_template_mob_1.php',
				'img' => td_global::$get_template_directory_uri . '/images/panel/category_templates/icon-category-1.png',
				'text' => 'Style 1',
				'group' => 'mob' // '' - main theme, 'mob' - mobile theme, 'woo' - woo theme
			)
		);


		/**
		 * category top posts styles
		 */
		td_api_category_top_posts_style::add('td_category_top_posts_style_mob_1',
			array (
				'file' => td_global::$get_template_directory . '/mobile/includes/category_top_posts_styles/td_category_top_posts_style_mob_1.php',
				'posts_shown_in_the_loop' => 3,
				'img' => td_global::$get_template_directory_uri . '/images/panel/category_templates/icon-category-top-2.png',
				'text' => 'Grid 2',
				'td_block_name' => 'td_block_big_grid_mob_1',
				'group' => 'mob' // '' - main theme, 'mob' - mobile theme, 'woo' - woo theme
			)
		);

        /**
         * smart lists
         */
        td_api_smart_list::add('td_smart_list_mob_1',
            array(
                'file' => td_global::$get_template_directory . '/mobile/includes/smart_lists/td_smart_list_mob_1.php',
                'text' => 'Smart list mobile 1',
                'img' => td_global::$get_template_directory_uri . '/mobile/images/panel/smart_lists/td_smart_list_mob_1.png',
                'extract_first_image' => true,
                'group' => 'mob' // '' - main theme, 'mob' - mobile theme, 'woo' - woo theme
            )
        );
	}
}