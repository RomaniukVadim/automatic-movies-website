<?php
if (!function_exists('vc_map_get_attributes')) {
	include "vc_column_old.php";
} else {
	/**
	 * Shortcode attributes
	 * @var $atts
	 * @var $el_class
	 * @var $width
	 * @var $css
	 * @var $offset
	 * @var $content - shortcode content
	 * Shortcode class
	 * @var $this WPBakeryShortCode_VC_Column
	 */
	$output = '';
	$atts = vc_map_get_attributes($this->getShortcode(), $atts);
	extract($atts);


// tagDiv Code
	global $td_column_count, $td_row_count;
	if (empty($width)) {
		$td_column_count = '1/1';
	} else {
		$td_column_count = $width;
	}
// /tagDiv


	$width = wpb_translateColumnWidthToSpan($width);
	$width = vc_column_offset_class_merge($offset, $width);

	$css_classes = array(
		$this->getExtraClass($el_class),
		'wpb_column',
		'vc_column_container',
		$width,
		vc_shortcode_custom_css_class($css),
	);

	$wrapper_attributes = array();

	$css_class = preg_replace('/\s+/', ' ', apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', array_filter($css_classes)), $this->settings['base'], $atts));
	$wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';

	$output .= '<div ' . implode(' ', $wrapper_attributes) . '>';
	$output .= '<div class="wpb_wrapper">';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div>' . $this->endBlockComment('.wpb_wrapper');
	$output .= '</div>' . $this->endBlockComment($this->getShortcode());

	echo $output;
}