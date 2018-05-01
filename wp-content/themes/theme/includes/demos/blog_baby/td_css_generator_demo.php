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
		.td-blog-baby .td-header-style-11 .sf-menu > li > a:hover,
		.td-blog-baby .td-header-style-11 .sf-menu > .sfHover > a,
		.td-blog-baby .td-header-style-11 .sf-menu > .current-menu-item > a,
		.td-blog-baby .td-header-style-11 .sf-menu > .current-menu-ancestor > a,
		.td-blog-baby .td-header-style-11 .sf-menu > .current-category-ancestor > a,
		.td-blog-baby .td_module_4 .td-post-category,
		.td-blog-baby .td-cur-simple-item:hover {
   		    color: @theme_color;
   		}

		.td-blog-baby .td-ss-main-content .block-title span,
		.td-blog-baby .td-ss-main-sidebar .block-title span,
		.td-blog-baby .td-module-comments a,
		.td-blog-baby .td-cur-simple-item {
   			border-color: @theme_color;
   		}

   		.td-blog-baby .td-module-comments a:after {
   			border-color: @theme_color transparent transparent transparent;
   		}


	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);

	$td_demo_css_compiler->load_setting('theme_color');
	$td_demo_css_compiler->load_setting('submenu_hover_color');

	return $td_demo_css_compiler->compile_css();
}
