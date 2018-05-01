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
      	@media (min-width: 768px) {
			.td-recipes .td_module_wrap .td-post-category {
				color: @theme_color;
			}
		}
		.td-recipes .td_module_mega_menu .td-post-category,
		.td-recipes .footer-email-wrap a,
		.td-recipes .td-post-template-13 header .td-post-author-name a {
			color: @theme_color;
		}

		.td-recipes.td_category_template_4 .td-category .td-current-sub-category {
			background-color: @theme_color;
        	border-color: @theme_color;
		}
	</style>
	";

	$td_demo_css_compiler = new td_css_compiler($td_demo_custom_css);
	$td_demo_css_compiler->load_setting('theme_color');

	return $td_demo_css_compiler->compile_css();
}
