<?php

class td_review {

    //calculates the average stars rating
    static function render_stars($td_review) {
        $total_stars = self::calculate_total_stars($td_review);
        return self::number_to_stars($total_stars);
    }


	// converts the rating to 0-5 to be used with stars
	static function calculate_total_stars($td_review) {
		if (!empty($td_review['has_review'])) {
			switch ($td_review['has_review']) {
				case 'rate_stars' :
					return round(self::calculate_total($td_review), 1);
					break;
				case 'rate_percent':
					return round(self::calculate_total($td_review) / 10 / 2, 1);
					break;
				case 'rate_point' :
					return round(self::calculate_total($td_review) / 2, 1);
					break;
			}
		}
	}

    //converts 0 - 5 to stars
    private static function number_to_stars($total_stars) {

        $star_integer = intval($total_stars);

	    $buffy = '';

	    // this echo full stars
	    for ($i = 0; $i < $star_integer; $i++) {
		    $buffy .= '<i class="td-icon-star"></i>';
	    }

	    $star_rest = $total_stars - $star_integer;

	    // this echo full star or half or empty star
	    if ($star_rest >= 0.25 and $star_rest < 0.75) {
		    $buffy .= '<i class="td-icon-star-half"></i>';
	    } else if ($star_rest >= 0.75) {
		    $buffy .= '<i class="td-icon-star"></i>';
	    } else if ($total_stars != 5) {
		    $buffy .= '<i class="td-icon-star-empty"></i>';
	    }

	    // this echo empty star
	    for ($i = 0; $i < 4-$star_integer; $i++) {
		    $buffy .= '<i class="td-icon-star-empty"></i>';
	    }

		return $buffy;
    }

    //draws the bars
    private static function number_to_bars($percent_rating) {
        $buffy = '';
        $buffy .= '<div class="td-rating-bar-wrap">';
            $buffy .= '<div style="width:' . $percent_rating . '%"></div>';
        $buffy .= '</div>';

        return $buffy;
    }

    //check to see if we have a rating
    //@legacy this is legacy code - introduced on Newspaper - nu puteam sa-l schimbam ca stricam compatibilitatea
    private static function has_review($td_review) {
        if (!empty($td_review['has_review']) and (
	                !empty($td_review['p_review_stars']) or
	                !empty($td_review['p_review_percents']) or
	                !empty($td_review['p_review_points'])
	            )
            ) {
            return true;
        } else {
            return false;
        }
    }



    // converts the rating to 0-5 to be used with stars
    private static function calculate_total_key_value($td_review) {
        if (!empty($td_review['has_review'])) {
            switch ($td_review['has_review']) {
                case 'rate_stars' :
                    return round(self::calculate_total($td_review), 1);
                    break;
                case 'rate_percent':
                    return round(self::calculate_total($td_review) / 10 / 2, 3);
                    break;
                case 'rate_point' :
                    return round(self::calculate_total($td_review) / 2, 1);
                    break;
            }
        }
    }

    //calculates the average of the rating
    private static function calculate_total($td_review, $show_percent = false) {
        //print_r($td_review);
        if (!empty($td_review['has_review'])) {

            $total = 0;
            $cnt = 0;

            switch ($td_review['has_review']) {
                case 'rate_stars' :
                    if (!empty($td_review['p_review_stars'])) {
                        foreach ($td_review['p_review_stars'] as $section) {
                            if (!empty($section['desc']) and !empty($section['rate'])) {
                                $total = $total + $section['rate'];
                                $cnt++;
                            }
                        }
                    }
                    break;

                case 'rate_percent' :
                    if (!empty($td_review['p_review_percents'])) {
                        foreach ($td_review['p_review_percents'] as $section) {
                            if (!empty($section['desc']) and !empty($section['rate'])) {
                                $total = $total + $section['rate'];
                                $cnt++;
                            }
                        }
                    }
                    break;

                case 'rate_point' :
                    if (!empty($td_review['p_review_points'])) {
                        foreach ($td_review['p_review_points'] as $section) {
                            if (!empty($section['desc']) and !empty($section['rate'])) {
                                $total = $total + $section['rate'];
                                $cnt++;
                            }
                        }
                    }
                    break;

            }

            if ($total == 0) {
                $result = 0;
            } else {
                $result = round($total / $cnt, 1);
            }


            if ($show_percent and $td_review['has_review'] == 'rate_percent') {
                return $result . ' %';
            } else {
                return $result;
            }
        }

    }


    /*  ----------------------------------------------------------------------------
        render table
     */

    static function render_table($td_review) {
        $buffy = '';
        $buffy .= self::render_table_head();
        $buffy .= self::render_table_rows($td_review);
        $buffy .= self::render_table_footer($td_review);

        return $buffy;
    }


    /*  ----------------------------------------------------------------------------
        render table head
     */

    private static function render_table_head() {
        $buffy = '';
        $buffy .= '<table class="td-review">';
        $buffy .= '<tr class="td-review-header">';
            $buffy .= '<td colspan="2">';
                $buffy .= '<span class="block-title">' . __td('REVIEW OVERVIEW', TD_THEME_NAME) . '</span>';
            $buffy .= '</td>';
        $buffy .= '</tr>';
        return $buffy;
    }

    private static function render_table_rows($td_review) {
        $buffy = '';


        if (!empty($td_review['has_review'])) {
            switch ($td_review['has_review']) {
                case 'rate_stars' :
                    if (!empty($td_review['p_review_stars'])) {
                        foreach ($td_review['p_review_stars'] as $section) {
                            if (!empty($section['desc']) and !empty($section['rate'])) {
                                $buffy .= '<tr class="td-review-row-stars">';
                                $buffy .= '<td class="td-review-desc">';
                                $buffy .= $section['desc'];
                                $buffy .= '</td>';
                                $buffy .= '<td class="td-review-stars">';
                                $buffy .= self::number_to_stars($section['rate']);
                                //$buffy .= $section['rate'];
                                $buffy .= '</td>';
                                $buffy .= '</tr>';
                            }
                        }
                    }
                    break;

                case 'rate_percent' :
                    if (!empty($td_review['p_review_percents'])) {
                        foreach ($td_review['p_review_percents'] as $section) {
                            if (!empty($section['desc']) and !empty($section['rate'])) {
                                $buffy .= '<tr class="td-review-row-bars">';
                                $buffy .= '<td colspan="2">';
                                $buffy .= '<div class="td-review-details">';
                                $buffy .= '<div class="td-review-desc">' . $section['desc'] . '</div>';
                                $buffy .= '<div class="td-review-percent">' . $section['rate'] . ' %</div>';
                                $buffy .= '</div>';
                                $buffy .= self::number_to_bars($section['rate']);
                                $buffy .= '</td>';
                                $buffy .= '</tr>';
                            }
                        }
                    }
                    break;

                case 'rate_point' :
                    if (!empty($td_review['p_review_points'])) {
                        foreach ($td_review['p_review_points'] as $section) {
                            if (!empty($section['desc']) and !empty($section['rate'])) {
                                $buffy .= '<tr class="td-review-row-bars">';
                                $buffy .= '<td colspan="2">';
                                $buffy .= '<div class="td-review-details">';
                                $buffy .= '<div class="td-review-desc">' . $section['desc'] . '</div>';;
                                $buffy .= '<div class="td-review-percent">' . $section['rate'] . '</div>';
                                $buffy .= '</div>';
                                $buffy .= self::number_to_bars($section['rate'] * 10);
                                $buffy .= '</td>';
                                $buffy .= '</tr>';
                            }
                        }
                    }
                    break;

            }



        }
        return $buffy;
    }



    /*  ----------------------------------------------------------------------------
        render table footer
     */
    private static function render_table_footer($td_review) {
        if (!empty($td_review['has_review'])) {

            $buffy = '';
            $buffy .= '<tr class="td-review-footer ' . $td_review['has_review'] . '">';
                $buffy .= '<td class="td-review-summary">';
                    $buffy .= '<span class="block-title">' . __td('SUMMARY', TD_THEME_NAME) . '</span>';
                    if (!empty($td_review['review'])) {
                        $buffy .= '<div class="td-review-summary-content">' . $td_review['review'] . '</div>';
                    }

                $buffy .= '</td>';
                $buffy .= '<td class="td-review-score"><div class="td-review-overall">';
                switch ($td_review['has_review']) {
                    case 'rate_stars' :
                        $buffy .= '<div class="td-review-final-score">' . self::calculate_total($td_review) . '</div>';
                        $buffy .= '<div class="td-review-final-star">' . self::render_stars($td_review) . '</div>';
                        break;

                    case 'rate_percent' :
                        $buffy .= '<div class="td-review-final-score">' . self::calculate_total($td_review) . '<span class="td-review-percent-sign">%</span></div>';
                        $buffy .= '<div class="td-review-final-star">' . self::render_stars($td_review) . '</div>';
                        break;

                    case 'rate_point' :
                        $buffy .= '<div class="td-review-final-score">' . self::calculate_total($td_review) . '</div>';
                        $buffy .= '<div class="td-review-final-star">' . self::render_stars($td_review) . '</div>';
                        break;

                }

                $buffy .= '<span>' . __td('OVERALL SCORE', TD_THEME_NAME) . '</span>';
                $buffy .= '</div></td>';

            $buffy .= '</tr>';
            $buffy .= '</table>';
            return $buffy;
        }
    }




    static function on_save_post_update_review($post_id) {
        //$td_review = get_post_meta($post_id, 'td_review', true);
	    $td_review = get_post_meta($post_id, 'td_post_theme_settings', true);
        if (self::has_review($td_review)) {
            update_post_meta($post_id, 'td_review_key', self::calculate_total_key_value($td_review));
            /*
            $myFile = "d:/testFile.txt";
            $fh = fopen($myFile, 'w') or die("can't open file");
            $stringData = print_r($td_review, true);
            $stringData .= self::calculate_total($td_review);

            fwrite($fh, $stringData);
            fclose($fh);
             */
        } else {
            // delete the review data when you select no review
            delete_post_meta($post_id, 'td_review_key');
        }
    }
}
