<?php

class td_ajax {

	/**
	 * This function is also callable, it is used to warm the cache for the ajax blocks
	 * @param string $ajax_parameters
	 * @return mixed
	 */
	static function on_ajax_block($ajax_parameters = '') {

		$isAjaxCall = false;

		if (empty($ajax_parameters)) {
			$isAjaxCall = true;
			$ajax_parameters = array (
				'td_atts' => '',            // original block atts
				'td_column_number' => 0,    // should not be 0 (1 - 2 - 3)
				'td_current_page' => '',    // the current page of the block
				'td_block_id' => '',        // block uid
				'block_type' => '',         // the type of the block / block class
				'td_filter_value' => ''     // the id for this specific filter type. The filter type is in the td_atts
			);


			if (!empty($_POST['td_atts'])) {
				$ajax_parameters['td_atts'] = json_decode(stripslashes($_POST['td_atts']), true); //current block args
			}
			if (!empty($_POST['td_column_number'])) {
				$ajax_parameters['td_column_number'] =  $_POST['td_column_number']; //the block is on x columns
			}
			if (!empty($_POST['td_current_page'])) {
				$ajax_parameters['td_current_page'] = $_POST['td_current_page'];
			}
			if (!empty($_POST['td_block_id'])) {
				$ajax_parameters['td_block_id'] = $_POST['td_block_id'];
			}
			if (!empty($_POST['block_type'])) {
				$ajax_parameters['block_type'] = $_POST['block_type'];
			}
			//read the id for this specific filter type
			if (!empty($_POST['td_filter_value'])) {
				$ajax_parameters['td_filter_value']  = $_POST['td_filter_value']; //the new id filter
			}
		}



		/*
		 * HANDLES THE PULL DOWN FILTER + TABS ON RELATED POSTS
		 * read the block atts - td filter type and overwrite the default values at runtime! (ex: the user changed the category from the dropbox, we overwrite the static default category of the block)
		 */
		if (!empty($ajax_parameters['td_atts']['td_ajax_filter_type'])) {
			//dynamic filtering
			switch ($ajax_parameters['td_atts']['td_ajax_filter_type']) {

				case 'td_category_ids_filter': // by category  - the user selected a category from the drop down. if it's empty, we show the default block atts
					if (!empty($ajax_parameters['td_filter_value'])) {
						$ajax_parameters['td_atts']['category_ids'] = $ajax_parameters['td_filter_value'];
						unset($ajax_parameters['td_atts']['category_id']);
					}
					break;


				case 'td_author_ids_filter': // by author
					if (!empty($ajax_parameters['td_filter_value'])) {
						$ajax_parameters['td_atts']['autors_id'] = $ajax_parameters['td_filter_value'];
					}
					break;

				case 'td_tag_slug_filter': // by tag - due to wp query and for combining the tags with categories we have to convert tag_ids to tag_slugs
					if (!empty($ajax_parameters['td_filter_value'])) {
						$term_obj = get_term($ajax_parameters['td_filter_value'], 'post_tag');
						$ajax_parameters['td_atts']['tag_slug'] = $term_obj->slug;
					}
					break;


				case 'td_popularity_filter_fa': // by popularity (sort)
					if (!empty($ajax_parameters['td_filter_value'])) {
						$ajax_parameters['td_atts']['sort'] = $ajax_parameters['td_filter_value'];
					}
					break;


				/**
				 * used by the related posts block
				 * - if $td_atts['td_ajax_filter_type'] == td_custom_related  ( this is hardcoded in the block atts  @see td_module_single.php:764)
				 * - overwrite the live_filter for this block - ( the default live_filter is also hardcoded in the block atts  @see td_module_single.php:764)
				 * the default live_filter for this block is: 'live_filter' => 'cur_post_same_categories'
				 * @var $td_filter_value comes via ajax
				 */
				case 'td_custom_related':
					if ($ajax_parameters['td_filter_value'] == 'td_related_more_from_author') {
						$ajax_parameters['td_atts']['live_filter'] = 'cur_post_same_author'; // change the live filter for the related posts
					}
					break;
			}
		}


		/**
		 * @var WP_Query
		 */
		$td_query = &td_data_source::get_wp_query($ajax_parameters['td_atts'], $ajax_parameters['td_current_page']); //by ref  do the query


		$buffy = td_global_blocks::get_instance($ajax_parameters['block_type'])->inner($td_query->posts, $ajax_parameters['td_column_number'], '', true);


		//pagination
		$td_hide_prev = false;
		$td_hide_next = false;
		if ($ajax_parameters['td_current_page'] == 1) {
			$td_hide_prev = true; //hide link on page 1
		}

		if (!empty($ajax_parameters['td_atts']['offset']) && !empty($ajax_parameters['td_atts']['limit']) && ($ajax_parameters['td_atts']['limit'] != 0)) {
			if ($ajax_parameters['td_current_page'] >= ceil(($td_query->found_posts - $ajax_parameters['td_atts']['offset']) / $ajax_parameters['td_atts']['limit'])) {
				$td_hide_next = true; //hide link on last page
			}
		} else if ($ajax_parameters['td_current_page'] >= $td_query->max_num_pages) {
			$td_hide_next = true; //hide link on last page
		}

//    if ($td_current_page >= $td_query->max_num_pages ) {
//	    $td_hide_next = true; //hide link on last page
//    }

		$buffyArray = array(
			'td_data' => $buffy,
			'td_block_id' => $ajax_parameters['td_block_id'],
			'td_hide_prev' => $td_hide_prev,
			'td_hide_next' => $td_hide_next
		);

		if ( true === $isAjaxCall ) {

			die(json_encode($buffyArray));
		} else {
			return json_encode($buffyArray);
		}

	}

	static function on_ajax_loop() {

		$loopState = td_util::get_http_post_val('loopState');
		//print_r($loopState);


		$buffy = '';

		/**
		 * @var WP_Query
		 */
		$td_query = &td_data_source::get_wp_query($loopState['atts'], $loopState['currentPage']); //by ref  do the query


		if (!empty($td_query->posts)) {
			td_global::$is_wordpress_loop = true; ///if we are in wordpress loop; used by quotes in blocks to check if the blocks are displayed in blocks or in loop
			$td_template_layout = new td_template_layout($loopState['sidebarPosition']);
			$td_module_class = td_api_module::_helper_get_module_class_from_loop_id($loopState['moduleId']);

			//disable the grid for some of the modules
			$td_module_api = td_api_module::get_by_id($td_module_class);
			if ($td_module_api['uses_columns'] === false) {
				$td_template_layout->disable_output();
			}

			foreach ($td_query->posts as $post) {
				$buffy .= $td_template_layout->layout_open_element();

				if (class_exists($td_module_class)) {
					$td_mod = new $td_module_class($post);
					$buffy .= $td_mod->render();
				} else {
					td_util::error(__FILE__, 'Missing module: ' . $td_module_class);
				}

				$buffy .= $td_template_layout->layout_close_element();
				$td_template_layout->layout_next();
			}
			$buffy .= $td_template_layout->close_all_tags();
		} else {
			// no posts

		}

		$loopState['server_reply_html_data'] = $buffy;

		die(json_encode($loopState));
	}


	static function on_ajax_search() {
		$buffy = '';
		$buffy_msg = '';

		//the search string
		if (!empty($_POST['td_string'])) {
			$td_string = $_POST['td_string'];
		} else {
			$td_string = '';
		}

		//get the data
		$td_query = &td_data_source::get_wp_query_search($td_string); //by ref  do the query

		//build the results
		if (!empty($td_query->posts)) {
			foreach ($td_query->posts as $post) {
				$td_module_mx2 = new td_module_mx2($post);
				$buffy .= $td_module_mx2->render();
			}
		}

		if (count($td_query->posts) == 0) {
			//no results
			$buffy = '<div class="result-msg no-result">' . __td('No results', TD_THEME_NAME) . '</div>';
		} else {
			//show the resutls
			/**
			 * @note:
			 * we use esc_url(home_url( '/' )) instead of the WordPress @see get_search_link function because that's what the internal
			 * WordPress widget it's using and it was creating duplicate links like: yoursite.com/search/search_query and yoursite.com?s=search_query
			 *
			 * also note that esc_url - as of today strips spaces (WTF) https://core.trac.wordpress.org/ticket/23605 so we used urlencode - to encode the query param with + instead of %20 as rawurlencode does
			 */

			$buffy_msg .= '<div class="result-msg"><a href="' . home_url('/?s=' . urlencode($td_string )) . '">' . __td('View all results', TD_THEME_NAME) . '</a></div>';
			//add wrap
			$buffy = '<div class="td-aj-search-results">' . $buffy . '</div>' . $buffy_msg;
		}

		//prepare array for ajax
		$buffyArray = array(
			'td_data' => $buffy,
			'td_total_results' => 2,
			'td_total_in_list' => count($td_query->posts),
			'td_search_query'=> $td_string
		);

		// Return the String
		die(json_encode($buffyArray));
	}


	static function on_ajax_login() {
		/**
		 * The ajax login is allowed when:
		 * 1. the mobile theme is active and its login option is also active
		 * 2. the main theme is active (the mobile theme is not active) and its login option is also active
		 */

		// The 'mobile' post param is set only by the login requests from the mobile theme
		// The login requests from theme version (or responsive version) do not set it
		if (empty($_POST['mobile'])) {
			if (td_util::get_option('tds_login_sign_in_widget') != 'show') {
				exit();
			}
		} else {
			if (td_util::get_option('tds_login_mobile') == 'hide') {
				exit();
			}
		}

		//json login fail
		$json_login_fail = json_encode(array('login', 0, __td('User or password incorrect!', TD_THEME_NAME)));

		//get the email address from ajax() call
		$login_email = '';
		if (!empty($_POST['email'])) {
			$login_email = $_POST['email'];
		}

		//get password from ajax() call
		$login_password = '';
		if (!empty($_POST['pass'])) {
			$login_password = $_POST['pass'];
		}

		//try to login
		if (!empty($login_email) and !empty($login_password)) {
			$obj_wp_login = td_login::login_user($login_email, $login_password);

			if (is_wp_error($obj_wp_login)) {
				die($json_login_fail);
			} else {
				die(json_encode(array('login', 1,'OK')));
			}

		} else {
			die($json_login_fail);
		}
	}

	static function on_ajax_register() {
		if (td_util::get_option('tds_login_sign_in_widget') != 'show') {
			exit();
		}
		//if registration is open from wp-admin/Settings,  then try to create a new user
		if (get_option('users_can_register') == 1){

			// json predefined return text
			$json_fail = json_encode(array('register', 0, __td('Email or username incorrect!', TD_THEME_NAME)));
			$json_user_pass_exists = json_encode(array('register', 0, __td('User or email already exists!', TD_THEME_NAME)));

			// get the email address from ajax() call
			$register_email = '';
			if (!empty($_POST['email'])) {
				$register_email = $_POST['email'];
			}

			// get user from ajax() call
			$register_user = '';
			if (!empty($_POST['user'])) {
				$register_user = $_POST['user'];
			}

			// try to login
			if (!empty($register_email) and !empty($register_user)) {

				//check user existence before adding it
				$user_id = username_exists($register_user);

				if (!$user_id and email_exists($register_email) == false ) {

					//generate random pass
					$random_password = wp_generate_password($length=12, $include_standard_special_chars=false);

					//create user
					$user_id = wp_create_user($register_user, $random_password, $register_email);

					if (intval($user_id) > 0) {
						//send email to $register_email
						wp_new_user_notification($user_id, null, 'both');
						die(json_encode(array('register', 1,__td('Please check your email (index or spam folder), the password was sent there.', TD_THEME_NAME))));
					} else {
						die($json_user_pass_exists);
					}
				} else {
					die($json_user_pass_exists);
				}
			} else {
				die($json_fail);
			}
		}//end if admin permits registration
	}

	static function on_ajax_remember_pass() {
		if (td_util::get_option('tds_login_sign_in_widget') != 'show') {
			exit();
		}
		//json predefined return text
		$json_fail = json_encode(array('remember_pass', 0, __td('Email address not found!', TD_THEME_NAME)));

		//get the email address from ajax() call
		$remember_email = '';
		if (!empty($_POST['email'])) {
			$remember_email = $_POST['email'];
		}

		if (td_login::recover_password($remember_email)) {
			die(json_encode(array('remember_pass', 1, __td('Your password is reset, check your email.', TD_THEME_NAME))));
		} else {
			die($json_fail);
		}
	}

	static function on_ajax_new_sidebar() {

		// die if request is fake
		check_ajax_referer('td-sidebar-ops', 'td_magic_token');


		if (!current_user_can('edit_theme_options')) {
			die;
		}

		$list_current_sidebars = '';

		//nr of chars displayd as name option
		$sub_str_val = 35;

		//add new sidebar
		$if_add_new_sidebar = 1;

		//get the new sidebar name from ajax() call
		$new_sidebar_name = '';
		if (!empty($_POST['sidebar'])) {
			$new_sidebar_name = trim($_POST['sidebar']);
		}




		$theme_sidebars = td_util::get_option('sidebars');

		//default sidebar
		$list_current_sidebars .= '<div class="td-option-sidebar-wrapper"><a class="td-option-sidebar" data-area-dsp-id="xxx_replace_xxx" title="Default Sidebar">Default Sidebar</a></div>';

		if(!empty($theme_sidebars)) {
			//check to see if there is already a sidebar with that name
			foreach($theme_sidebars as $key_sidebar_option => $sidebar_option){
				if($new_sidebar_name == $sidebar_option) {
					$if_add_new_sidebar = 0;
				}

				//create a list with sidebars to be returned, the text `xxx_replace_xxx` will be replace with the id of the controler
				$list_current_sidebars .= '<div class="td-option-sidebar-wrapper"><a class="td-option-sidebar" data-area-dsp-id="xxx_replace_xxx" title="' . $sidebar_option . '">' .  substr(str_replace(array('"', "'"), '`', $sidebar_option), 0, $sub_str_val) . '</a><a class="td-delete-sidebar-option" data-sidebar-key="' . $key_sidebar_option . '"></a></div>';
			}
		}

		//check for empty strings
		if(empty($new_sidebar_name)) {
			$if_add_new_sidebar = 0;
			die(json_encode(array('td_bool_value' => '0', 'td_msg' => 'Please insert a name for your new sidebar!')));

		}

		//add the new sidebar
		if($if_add_new_sidebar == 1){
			//generating id of the sidebar in the theme_option (td_008) string in wp_option table
			$sidebar_unique_id = uniqid() . '_' . rand(1, 999999);
			$theme_sidebars[$sidebar_unique_id] = $new_sidebar_name;



			td_util::update_option('sidebars', $theme_sidebars);


			//add the new sidebar to the existing list
			$list_current_sidebars .= '<div class="td-option-sidebar-wrapper"><a class="td-option-sidebar" data-area-dsp-id="xxx_replace_xxx" data-sidebar-key="' . $sidebar_unique_id . '" title="' . $new_sidebar_name . '">' . substr(str_replace(array('"', "'"), '`', $new_sidebar_name), 0, $sub_str_val) . '</a><a class="td-delete-sidebar-option" data-sidebar-key="' . $sidebar_unique_id . '"></a></div>';

			die(json_encode(array('td_bool_value' => '1', 'td_msg' => 'Succes', 'value_insert' => $list_current_sidebars, 'value_selected' => substr(str_replace(array('"', "'"), '`', $new_sidebar_name), 0, $sub_str_val))));

		} else {
			die(json_encode(array('td_bool_value' => '0', 'td_msg' => 'This name is already used as a sidebar name. Please use another name!')));
		}
	}

	static function on_ajax_delete_sidebar (){

		// die if request is fake
		check_ajax_referer('td-sidebar-ops', 'td_magic_token');


		if (!current_user_can('edit_theme_options')) {
			die;
		}

		//nr of chars displayd as name option
		$sub_str_val = 35;

		$list_current_sidebars = $value_deleted_sidebar = '';

		//get the sidebar key from ajax() call
		$sidebar_key_in_array = '';
		if (!empty($_POST['sidebar'])) {
			$sidebar_key_in_array = trim($_POST['sidebar']);
		}

		$theme_sidebars = td_util::get_option('sidebars');

		//option for default sidebar
		$list_current_sidebars .= '<div class="td-option-sidebar-wrapper"><a class="td-option-sidebar" data-area-dsp-id="xxx_replace_xxx" title="Default Sidebar">Default Sidebar</a></div>';

		if(!empty($theme_sidebars)) {
			foreach($theme_sidebars as $key_sidebar_option => $sidebar_option){
				if($key_sidebar_option == $sidebar_key_in_array) {

					//take the value to send it back, to be mached againt all pull down controllers, to remove this option if selected
					$value_deleted_sidebar = trim($sidebar_option);

					//removes the sidebar from the array of sidebars
					unset($theme_sidebars[$key_sidebar_option]);
				} else {
					//create a list with sidebars to be returned, the text `xxx_replace_xxx` will be replace with the id of the controler
					$list_current_sidebars .= '<div class="td-option-sidebar-wrapper"><a class="td-option-sidebar" data-area-dsp-id="xxx_replace_xxx" title="' . $sidebar_option . '">' . substr(str_replace(array('"', "'"), '`', $sidebar_option), 0, $sub_str_val) . '</a><a class="td-delete-sidebar-option" data-sidebar-key="' . $key_sidebar_option . '"></a></div>';
				}
			}


			td_util::update_option('sidebars', $theme_sidebars);

			die(json_encode(array('td_bool_value' => '1', 'td_msg' => 'Succes', 'value_insert' => $list_current_sidebars, 'value_to_march_del' => $value_deleted_sidebar)));
		}

	}

	static function on_ajax_update_views () {
		if (td_util::get_option('tds_ajax_post_view_count') != 'enabled') {
			exit();
		}

		//get the post ids // iy you don't send data encoded with json the remove json_decode(stripslashes(
		if (!empty($_POST['td_post_ids'])) {
			$td_post_id = json_decode(stripslashes($_POST['td_post_ids']));

			//error check
			if (empty($td_post_id[0])) {
				$td_post_id[0] = 0;
			}

			//get the current post count
			$current_post_count = td_page_views::get_page_views($td_post_id[0]);
			//echo($current_post_count);

			$new_post_count = $current_post_count + 1;

			//update the count
			update_post_meta($td_post_id[0], td_page_views::$post_view_counter_key, $new_post_count);

			die(json_encode(array($td_post_id[0]=>$new_post_count)));
		}
	}

	static function on_ajax_get_views() {
		if (td_util::get_option('tds_ajax_post_view_count') != 'enabled') {
			exit();
		}

		//get the post ids // iy you don't send data encoded with json the remove json_decode(stripslashes(
		if (!empty($_POST['td_post_ids'])) {
			$td_post_ids = json_decode(stripslashes($_POST['td_post_ids']));

			//will hold the return array
			$buffy = array();

			//this check for arrays with values // and count($td_post_ids) > 0
			if(!empty($td_post_ids) and is_array($td_post_ids)) {

				//this check for arrays with values
				foreach($td_post_ids as $post_id) {
					$buffy[$post_id] = td_page_views::get_page_views($post_id);
				}

				//return the view counts
				die(json_encode($buffy));
			}
		}
	}
}


