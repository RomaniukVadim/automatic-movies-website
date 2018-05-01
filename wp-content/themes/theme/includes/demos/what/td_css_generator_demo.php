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
		.td-what .td_module_3 .td-module-image .td-post-category,
    	.td-what .td_module_11 .td-post-category,
    	.td-what .td_module_18 .td-post-category,
    	.td-what .td_module_18 .td-post-category:hover,
    	.td-what .td-related-title .td-cur-simple-item:hover {
			color: @theme_color;
		}

		/* @submenu_hover_color */
		.td-what .td-header-style-6 .black-menu .sf-menu > li > a:hover,
	    .td-what .td-header-style-6 .black-menu .sf-menu > .sfHover > a,
	    .td-what .td-header-style-6 .black-menu .sf-menu > .current-menu-item > a,
	    .td-what .td-header-style-6 .black-menu .sf-menu > .current-menu-ancestor > a,
	    .td-what .td-header-style-6 .black-menu .sf-menu > .current-category-ancestor > a {
	    	color: @submenu_hover_color;
	    }
	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);

	$td_demo_css_compiler->load_setting('theme_color');
	$td_demo_css_compiler->load_setting('submenu_hover_color');

	return $td_demo_css_compiler->compile_css();
}
