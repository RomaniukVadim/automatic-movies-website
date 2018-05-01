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
		.td-cars .td-module-comments a,
		.td-cars .td_video_playlist_title {
			background-color: @theme_color;
		}

		.td-cars .td-module-comments a:after {
			border-color: @theme_color transparent transparent transparent;
		}

		/* @submenu_hover_color */
		.td-cars .td-header-style-10 .sf-menu > li > a:hover,
		.td-cars .td-header-style-10 .sf-menu > .sfHover > a,
		.td-cars .td-header-style-10 .sf-menu > .current-menu-item > a,
		.td-cars .td-header-style-10 .sf-menu > .current-menu-ancestor > a,
		.td-cars .td-header-style-10 .sf-menu > .current-category-ancestor > a,
		.td-cars .td-header-style-10 .header-search-wrap .td-icon-search:hover {
			color: @submenu_hover_color;
		}


	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);

	$td_demo_css_compiler->load_setting('theme_color');
	$td_demo_css_compiler->load_setting('submenu_hover_color');

	return $td_demo_css_compiler->compile_css();
}
