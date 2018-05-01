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
		.td-magazine .td-header-style-1 .td-header-gradient::before,
		.td-magazine .td-header-style-1 .td-mega-span .td-post-category:hover,
		.td-magazine .td-header-style-1 .header-search-wrap .td-drop-down-search::after {
			background-color: @theme_color;
		}

		.td-magazine .td-header-style-1 .td_mod_mega_menu:hover .entry-title a,
		.td-magazine .td-header-style-1 .td_mega_menu_sub_cats .cur-sub-cat,
		.td-magazine .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab.vc_active > a,
		.td-magazine .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab:hover > a,
		.td-magazine .td-related-title .td-cur-simple-item {
			color: @theme_color;
		}

		.td-magazine .td-header-style-1 .header-search-wrap .td-drop-down-search::before {
			border-color: transparent transparent @theme_color;
		}

		.td-magazine .td-header-style-1 .td-header-top-menu-full {
			border-top-color: @theme_color;
		}
	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);
	$td_demo_css_compiler->load_setting('theme_color');

	return $td_demo_css_compiler->compile_css();
}
