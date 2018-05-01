<?php
function td_js_generator() {
    td_js_buffer::add_variable('td_ajax_url', admin_url('admin-ajax.php?td_theme_name=' . TD_THEME_NAME . '&v=' . TD_THEME_VERSION));
    td_js_buffer::add_variable('td_get_template_directory_uri', get_template_directory_uri());
    td_js_buffer::add_variable('tds_snap_menu', td_util::get_option('tds_snap_menu'));
    td_js_buffer::add_variable('tds_logo_on_sticky', td_util::get_option('tds_logo_on_sticky'));
    td_js_buffer::add_variable('tds_header_style', td_util::get_option('tds_header_style'));

    td_js_buffer::add_variable('td_please_wait', __td('Please wait...', TD_THEME_NAME));
    td_js_buffer::add_variable('td_email_user_pass_incorrect', __td('User or password incorrect!', TD_THEME_NAME));
    td_js_buffer::add_variable('td_email_user_incorrect', __td('Email or username incorrect!', TD_THEME_NAME));
    td_js_buffer::add_variable('td_email_incorrect', __td('Email incorrect!', TD_THEME_NAME));

    //use for more articles on post pages
    td_js_buffer::add_variable('tds_more_articles_on_post_enable', td_util::get_option('tds_more_articles_on_post_pages_enable'));
    td_js_buffer::add_variable('tds_more_articles_on_post_time_to_wait', td_util::get_option('tds_more_articles_on_post_pages_time_to_wait'));
    td_js_buffer::add_variable('tds_more_articles_on_post_pages_distance_from_top', intval(td_util::get_option('tds_more_articles_on_post_pages_distance_from_top')));

    //theme color - used for loading box
    $td_get_db_theme_color = td_util::get_option('tds_theme_color');
    if(!preg_match('/^#[a-f0-9]{6}$/i', $td_get_db_theme_color)) {
        $td_get_db_theme_color = '#4db2ec';//default theme color
    }
    td_js_buffer::add_variable('tds_theme_color_site_wide', $td_get_db_theme_color);

    td_js_buffer::add_variable('tds_smart_sidebar', td_util::get_option('tds_smart_sidebar'));

	td_js_buffer::add_variable('tdThemeName', TD_THEME_NAME);

    // magnific popup translations
    td_js_buffer::add_variable('td_magnific_popup_translation_tPrev', __td('Previous (Left arrow key)', TD_THEME_NAME));
    td_js_buffer::add_variable('td_magnific_popup_translation_tNext', __td('Next (Right arrow key)', TD_THEME_NAME));
    td_js_buffer::add_variable('td_magnific_popup_translation_tCounter', __td('%curr% of %total%', TD_THEME_NAME));
    td_js_buffer::add_variable('td_magnific_popup_translation_ajax_tError', __td('The content from %url% could not be loaded.', TD_THEME_NAME));
    td_js_buffer::add_variable('td_magnific_popup_translation_image_tError', __td('The image #%curr% could not be loaded.', TD_THEME_NAME));


	// make the nonce for our wp-admin ajax
	if (is_admin()) {
		if (current_user_can('switch_themes')) {
			td_js_buffer::add_variable('tdWpAdminImportNonce', wp_create_nonce('td-demo-install'));         // install demos
		}

		if (current_user_can('edit_theme_options')) {
			td_js_buffer::add_variable('tdWpAdminPanelBoxNonce', wp_create_nonce('td-panel-box'));          // load ajax box
			td_js_buffer::add_variable('tdWpAdminSidebarOpsNonce', wp_create_nonce('td-sidebar-ops'));      // sidebar operations in theme panel
		}
	}

    // javascript date
    if (td_util::get_option('tds_data_js') == 'true') {

        // get format and timestamp
        $td_date_i18n_format = td_util::get_option('tds_data_time_format');
        if ($td_date_i18n_format == '') {
            $td_date_i18n_format = 'l, F j, Y';
        }
        td_js_buffer::add_variable('tdsDateFormat', $td_date_i18n_format);

        // get months and days
        global $wp_locale;
        $monthNames = array_map(array($wp_locale, 'get_month'), range(1, 12));
        $monthNamesShort = array_map(array($wp_locale, 'get_month_abbrev'), $monthNames);
        $dayNames = array_map(array($wp_locale, 'get_weekday'), range(0, 6));
        $dayNamesShort = array_map(array($wp_locale, 'get_weekday_abbrev'), $dayNames);

        td_js_buffer::add_variable('tdDateNamesI18n', array(
            "month_names" => $monthNames,
            "month_names_short" => $monthNamesShort,
            "day_names" => $dayNames,
            "day_names_short" => $dayNamesShort
        ));
    }




    // This js code has to run as fast as possible. No jQuery dependencies here
    ob_start();
    ?>
    <script>

	    var tdBlocksArray = []; //here we store all the items for the current page

	    //td_block class - each ajax block uses a object of this class for requests
	    function tdBlock() {
		    this.id = '';
		    this.block_type = 1; //block type id (1-234 etc)
		    this.atts = '';
		    this.td_column_number = '';
		    this.td_current_page = 1; //
		    this.post_count = 0; //from wp
		    this.found_posts = 0; //from wp
		    this.max_num_pages = 0; //from wp
		    this.td_filter_value = ''; //current live filter value
		    this.is_ajax_running = false;
		    this.td_user_action = ''; // load more or infinite loader (used by the animation)
		    this.header_color = '';
		    this.ajax_pagination_infinite_stop = ''; //show load more at page x
	    }


        // td_js_generator - mini detector
        (function(){
            var htmlTag = document.getElementsByTagName("html")[0];

            if ( navigator.userAgent.indexOf("MSIE 10.0") > -1 ) {
                htmlTag.className += ' ie10';
            }

            if ( !!navigator.userAgent.match(/Trident.*rv\:11\./) ) {
                htmlTag.className += ' ie11';
            }

            if ( /(iPad|iPhone|iPod)/g.test(navigator.userAgent) ) {
                htmlTag.className += ' td-md-is-ios';
            }

            var user_agent = navigator.userAgent.toLowerCase();
            if ( user_agent.indexOf("android") > -1 ) {
                htmlTag.className += ' td-md-is-android';
            }

            if ( -1 !== navigator.userAgent.indexOf('Mac OS X')  ) {
                htmlTag.className += ' td-md-is-os-x';
            }

            if ( /chrom(e|ium)/.test(navigator.userAgent.toLowerCase()) ) {
               htmlTag.className += ' td-md-is-chrome';
            }

            if ( -1 !== navigator.userAgent.indexOf('Firefox') ) {
                htmlTag.className += ' td-md-is-firefox';
            }

            if ( -1 !== navigator.userAgent.indexOf('Safari') && -1 === navigator.userAgent.indexOf('Chrome') ) {
                htmlTag.className += ' td-md-is-safari';
            }

        })();




        var tdLocalCache = {};

        ( function () {
            "use strict";

            tdLocalCache = {
                data: {},
                remove: function (resource_id) {
                    delete tdLocalCache.data[resource_id];
                },
                exist: function (resource_id) {
                    return tdLocalCache.data.hasOwnProperty(resource_id) && tdLocalCache.data[resource_id] !== null;
                },
                get: function (resource_id) {
                    return tdLocalCache.data[resource_id];
                },
                set: function (resource_id, cachedData) {
                    tdLocalCache.remove(resource_id);
                    tdLocalCache.data[resource_id] = cachedData;
                }
            };
        })();

    </script>
    <?php
    td_js_buffer::add_to_header(td_util::remove_script_tag(ob_get_clean()));



}

// we have to call the td_js_generator on "some" hook due to the fact that td_translate is loaded on 'after_setup_theme'
// and we don't have the _td translation function yet
add_action('wp_head', 'td_js_generator', 10);
add_action('admin_head', 'td_js_generator', 10);