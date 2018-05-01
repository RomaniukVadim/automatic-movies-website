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

	//parse the label
	if (!empty($content)) {
		$label = $content;
	}

	return '<a class="td-buttons"' . $link . $target . '>' . $label . '</a>';
}
add_shortcode('button', 'td_button');