<?php
/**
 * Created by ra.
 * Date: 9/2/2015
 * CSS generator for this specific demo
 */


function td_css_demo_gen() {
	$td_demo_custom_css = "
	<style>

		/* @theme_color */
		.td-blog-health .td-header-style-1 .td-header-menu-wrap {
			border-bottom-color:  @theme_color;
		}

		.td-blog-health .td-module-17 .td-module-meta-holder,
		.td-blog-health .td-vlog-container .td_video_playlist_title {
		 	background-color: @theme_color;
		}

		/* @submenu_hover_color */
		.td-blog-health .td-header-style-1 .sf-menu > li > a:hover,
		.td-blog-health .td-header-style-1 .sf-menu > .sfHover > a,
		.td-blog-health .td-header-style-1 .sf-menu > .current-menu-item > a,
		.td-blog-health .td-header-style-1 .sf-menu > .current-menu-ancestor > a,
		.td-blog-health .td-header-style-1 .sf-menu > .current-category-ancestor > a {
			color: @submenu_hover_color;
		}

		/* @module_17_color */
		.td-blog-health .td_module_17 .td-module-meta-holder {
		 	background-color: @module_17_color;
		}

	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);

	$td_demo_css_compiler->load_setting('theme_color');
	$td_demo_css_compiler->load_setting('module_17_color');
	$td_demo_css_compiler->load_setting('submenu_hover_color');

	//load the selection color
	$tds_theme_color = td_util::get_option('tds_theme_color');
	if (!empty($tds_theme_color)) {
		//the sliders text
		$td_demo_css_compiler->load_setting_raw('module_17_color', td_util::hex2rgba($tds_theme_color, 0.7));
	}

	return $td_demo_css_compiler->compile_css();
}
