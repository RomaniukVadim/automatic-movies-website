<?php
/**
 * Created by ra.
 * Date: 9/2/2015
 * CSS generator for this specific demo
 */


function td_css_demo_gen() {
	$td_demo_custom_css = "
	<style>
		/* @submenu_hover_color */
		.td-travel .td-header-style-5 .sf-menu > li > a:hover,
	    .td-travel .td-header-style-5 .sf-menu > .sfHover > a,
	    .td-travel .td-header-style-5 .sf-menu > .current-menu-item > a,
	    .td-travel .td-header-style-5 .sf-menu > .current-menu-ancestor > a,
	    .td-travel .td-header-style-5 .sf-menu > .current-category-ancestor > a {
	        color: @submenu_hover_color;
	    }
	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);
	$td_demo_css_compiler->load_setting('submenu_hover_color');

	return $td_demo_css_compiler->compile_css();
}
