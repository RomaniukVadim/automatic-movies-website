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
		 .td-cafe .td-header-style-10 .sf-menu > li > a:hover,
		 .td-cafe .td-header-style-10 .sf-menu > .sfHover > a,
		 .td-cafe .td-header-style-10 .sf-menu > .current-menu-item > a,
		 .td-cafe .td-header-style-10 .sf-menu > .current-menu-ancestor > a,
		 .td-cafe .td-header-style-10 .sf-menu > .current-category-ancestor > a
		 .td-cafe .td-module-meta-info .td-post-author-name a:hover,
		 .td-cafe .td-module-meta-info .td-post-comments i:hover,
		 .td-cafe .author-box-wrap .td-author-name a:hover,
		 .td-cafe .author-box-wrap .td-author-social i:hover,
		 .td-cafe .td-footer-wrapper .widget a:hover  {
		 	color: @theme_color;
		 }

		 .td-cafe .td-module-comments a,
		 .td-cafe .td-post-category,
		 .td-cafe .td-menu-summary .wpb_single_image:before,
		 .td-cafe .td-menu-summary .wpb_heading:before,
		 .td-cafe .td-menu-products .td-menu-images .wpb_heading:before,
		 .td-cafe .td-ss-main-sidebar .td-search-form-widget input[type=submit],
		 .td-cafe .comment-respond input[type=submit],
		 .td-cafe .td-post-header .td-category a {
		    background-color: @theme_color;
  		 }

	    .td-cafe .td-module-comments a:after {
			border-color: @theme_color transparent transparent transparent;
	    }



	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);


	$td_demo_css_compiler->load_setting('theme_color');

	return $td_demo_css_compiler->compile_css();
}
