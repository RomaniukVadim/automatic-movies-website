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
		.td-health .td-module-comments a {
        	background-color: @theme_color;
    	}
    	.td-health .td-module-comments a:after {
        	border-color: @theme_color transparent transparent transparent;
    	}

    	/* @submenu_hover_color */
    	.td-health .td-header-style-6 .sf-menu > li > a:hover,
	    .td-health .td-header-style-6 .sf-menu > .sfHover > a,
	    .td-health .td-header-style-6 .sf-menu > .current-menu-item > a,
	    .td-health .td-header-style-6 .sf-menu > .current-menu-ancestor > a,
	    .td-health .td-header-style-6 .sf-menu > .current-category-ancestor > a {
	        color: @submenu_hover_color !important;
	    }
	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);
	$td_demo_css_compiler->load_setting('theme_color');
	$td_demo_css_compiler->load_setting('submenu_hover_color');

	return $td_demo_css_compiler->compile_css();
}
