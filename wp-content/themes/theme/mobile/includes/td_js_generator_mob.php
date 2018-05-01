<?php
function td_js_generator_mob() {
    td_js_buffer::add_variable('td_ajax_url', admin_url('admin-ajax.php?td_theme_name=' . TD_THEME_NAME . '&v=' . TD_THEME_VERSION));
	td_js_buffer::add_variable('tdThemeName', TD_THEME_NAME);

    td_js_buffer::add_variable('td_please_wait', __td('Please wait...', TD_THEME_NAME));
    td_js_buffer::add_variable('td_email_user_pass_incorrect', __td('User or password incorrect!', TD_THEME_NAME));
    td_js_buffer::add_variable('td_email_user_incorrect', __td('Email or username incorrect!', TD_THEME_NAME));
    td_js_buffer::add_variable('td_email_incorrect', __td('Email incorrect!', TD_THEME_NAME));

    // The mini detector - ads classes to the HTML tag, it enables us to fix issues in each device.
    // Has to run as fast as possible
    ob_start();
    ?>
    <script>
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

            if( -1 !== navigator.userAgent.indexOf('IEMobile') ){
                htmlTag.className += ' td-md-is-iemobile';
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
add_action('wp_head', 'td_js_generator_mob');
add_action('admin_head', 'td_js_generator_mob');