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
		.td-politics .td-header-style-11 .sf-menu > li > a:hover,
	    .td-politics .td-header-style-11 .sf-menu > .sfHover > a,
	    .td-politics .td-header-style-11 .sf-menu > .current-menu-item > a,
	    .td-politics .td-header-style-11 .sf-menu > .current-menu-ancestor > a,
	    .td-politics .td-header-style-11 .sf-menu > .current-category-ancestor > a {
	        background-color: @submenu_hover_color;
	    }
	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);
	$td_demo_css_compiler->load_setting('submenu_hover_color');

	return $td_demo_css_compiler->compile_css();
}
