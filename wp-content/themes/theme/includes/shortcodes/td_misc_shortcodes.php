<?php
//button
function td_button($atts, $content = null) {
	extract(shortcode_atts(
			array(
				'label' => '', /* text button */
				'color' => '', /* button color */
				'size' => '', /* empty for default size or */
				'type' => '', /* empty for default type or */
				'target' => '', /* empty for _self or */
				'link' => '' /* empty for # or */
			),
			$atts
		)
	);

	$style_output = '';

	// color
	if ($color != '') {
		$style_output .= 'vc_btn-' . $color . ' ';
	} else {
		$style_output .= 'vc_btn-black ';
	}

	// size
	switch ($size) {
		case 'mini':
			$size = 'vc_btn-xs ';
			break;

		case 'small':
			$size = 'vc_btn-sm ';
			break;

		case 'large':
			$size = 'vc_btn-lg ';
			break;

		case 'normal':
			$size = 'vc_btn-md ';
			break;

		default:
			$size = 'vc_btn-sm ';
	}
	$style_output .= $size;

	// type
	if ($type != '') {
		$style_output .= 'vc_btn_' . $type . ' ';
	} else {
		$style_output .= 'vc_btn_square ';
	}

	// target
	if ($target != '') {
		$target = 'target="' . $target . '" ';
	} else {
		$target = '';
	}

	// link
	if ($link != '') {
		$link = 'href="' . $link . '" ';
	} else {
		$link = 'href="#"';
	}

	//parse the style
	if (!empty($style_output)) {
		$style_output = ' class="vc_btn ' . $style_output . '" ' . $target . $link;
	}

	//parse the label
	if (!empty($content)) {
		$label = $content;
	}


	return '<a ' . $style_output . '>' . $label . '</a>';
}
add_shortcode('button', 'td_button');