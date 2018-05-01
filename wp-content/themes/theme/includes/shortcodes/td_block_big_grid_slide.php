<?php
/**
 * Created by PhpStorm.
 * User: tagdiv
 * Date: 18.05.2015
 * Time: 15:22
 */

class td_block_big_grid_slide extends td_block {
	private $internal_block_instance;



	function render($atts, $content = null) {
		$this->internal_block_instance = new td_block_big_grid_2();


		$this->block_uid = td_global::td_generate_unique_id(); //update unique id on each render

		$buffy = ''; //output buffer

		extract(shortcode_atts(
			array(
				'limit' => 4,
				'sort' => '',
				'category_id' => '',
				'category_ids' => '',
				'tag_slug' => '',
				'force_columns' => '',
				'autoplay' => '',
				'offset' => 0
			),$atts));

		if (empty($td_column_number)) {
			$td_column_number = td_util::vc_get_column_number(); // get the column width of the block
		}

		if ($td_column_number == 3) {

			$current_limit = intval($limit);

			$post_limit = constant(get_class($this->internal_block_instance) . '::POST_LIMIT');

			$td_query = td_data_source::get_wp_query($atts);



			if (!empty($td_query->posts)) {

				if (($current_limit > $post_limit) and (count($td_query->posts) > $post_limit)) {

					$buffy .= '<div class="td-big-grid-slide td_block_wrap" id="iosSlider_'. $this->block_uid .'">';
					$buffy .= '<div class="td-theme-slider td_block_inner" id="' . $this->block_uid . '">';


					$current_offset = 0;

					$atts['class'] = 'item';

					while ($current_limit >  0) {

						$atts['offset'] = $offset + $current_offset;

						$buffy .= $this->internal_block_instance->render($atts);

						$current_offset += $post_limit;
						$current_limit -= $post_limit;
					}

					$buffy .= '</div>';//end slider (if slider)

					$buffy .= '<i class = "td-icon-left"></i>';
					$buffy .= '<i class = "td-icon-right"></i>';

					$buffy .= '</div>';//end iosSlider (if slider)

					$autoplay_settings = '';
					$current_autoplay = filter_var($autoplay, FILTER_VALIDATE_INT);

					if ($current_autoplay !== false) {
						$autoplay_settings = 'autoSlide: true, autoSlideTimer: ' . $current_autoplay * 1000 . ',';
					}

					$slide_javascript = ';jQuery(document).ready(function() {
                        jQuery("#iosSlider_' . $this->block_uid . '").iosSlider({
                            snapToChildren: true,
                            desktopClickDrag: true,
                            keyboardControls: true,
                            responsiveSlides: true,
                            infiniteSlider: true,
                            ' . $autoplay_settings . '
                            navPrevSelector: jQuery("#iosSlider_' . $this->block_uid . ' .td-icon-left"),
                            navNextSelector: jQuery("#iosSlider_' . $this->block_uid . ' .td-icon-right")
                        });
                    });';

					td_js_buffer::add_to_footer($slide_javascript);

				} else {
					$buffy .= $this->internal_block_instance->render($atts);
				}
			}
		}
		return $buffy;
	}
}