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
		.td-black .td-post-category:hover {
			background-color: @theme_color;
		}

	  	.td-black .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab.vc_active > a,
	  	.td-black .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab:hover > a,
	  	.td-black .td-footer-instagram-container .td-instagram-user a {
			color: @theme_color;
		}

		.td-black .page-nav .current {
			border-color: @theme_color;
		}

		/* @submenu_hover_color */
		.td-black .td-header-style-5 .sf-menu > li > a:hover,
	  	.td-black .td-header-style-5 .sf-menu > .sfHover > a,
	  	.td-black .td-header-style-5 .sf-menu > .current-menu-item > a,
	  	.td-black .td-header-style-5 .sf-menu > .current-menu-ancestor > a,
	  	.td-black .td-header-style-5 .sf-menu > .current-category-ancestor > a,
     	.td-black .td_mega_menu_sub_cats .cur-sub-cat {
	  		color: @submenu_hover_color;
	  	}
	  	.td-black .sf-menu .td-post-category:hover {
			background-color: @submenu_hover_color;
		}

	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);
	$td_demo_css_compiler->load_setting('theme_color');
	$td_demo_css_compiler->load_setting('submenu_hover_color');

	return $td_demo_css_compiler->compile_css();
}
