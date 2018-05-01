<?php
/**
 * Created by PhpStorm.
 * User: tagdiv
 * Date: 11.12.2015
 * Time: 11:25
 */

class td_page_generator_mob extends td_page_generator {

	static function get_pagination() {
		global $wp_query;

		/**
		 * use normal pagination
		 */
		$pagenavi_options = self::pagenavi_init();

		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;



		// hack for category pages - pagination
		// we also have to check for page-pagebuilder-latest.php template because we are running there in a FAKE loop and if the category
		// filter is active for that loop, WordPress believes that we are on a category
		if(!is_admin() and td_global::$current_template != 'page-homepage-loop' and is_category()) {
			$posts_shown_in_loop = td_api_category_top_posts_style::get_key('td_category_top_posts_style_mob_1', 'posts_shown_in_the_loop');

			$numposts = $wp_query->found_posts - $posts_shown_in_loop; // fix the pagination, we have x less posts because the rest are in the top posts loop
			$max_page = ceil($numposts / $posts_per_page);
		}


		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}

		$pages_to_show = intval($pagenavi_options['num_pages']);
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}

		if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
			$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
			$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);

			echo '<div class="page-nav td-pb-padding-side">';

			previous_posts_link($pagenavi_options['prev_text']);
			if ($start_page >= 2 && $pages_to_show < $max_page) {
				$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
				echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">'.$first_page_text.'</a>';
				if(!empty($pagenavi_options['dotleft_text']) && ($start_page > 2)) {
					echo '<span class="extend">'.$pagenavi_options['dotleft_text'].'</span>';
				}
			}

			for($i = $start_page; $i  <= $end_page; $i++) {
				if($i == $paged) {
					$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
					echo '<span class="current">'.$current_page_text.'</span>';
				} else {
					$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
					echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="page" title="'.$page_text.'">'.$page_text.'</a>';
				}
			}

			if ($end_page < $max_page) {
				if(!empty($pagenavi_options['dotright_text']) && ($end_page + 1 < $max_page)) {
					echo '<span class="extend">'.$pagenavi_options['dotright_text'].'</span>';
				}

				$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
				echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">'.$last_page_text.'</a>';
			}

			next_posts_link($pagenavi_options['next_text'], $max_page);

			if(!empty($pages_text)) {
				echo '<span class="pages">'.$pages_text.'</span>';
			}

			echo '</div>';

		}

	}
}