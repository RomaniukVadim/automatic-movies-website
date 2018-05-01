<?php
class td_block_ad_box_mob extends td_block {


    function render($atts, $content = null) {

        extract(shortcode_atts(
            array(
                'spot_id' => '', //header / sidebar etc
                'align' => '', //align left or right in inline content,
	            'spot_title' => '',
            ), $atts));


        if (empty($spot_id)) {
            return;
        }

        $ad_array = td_util::get_td_ads($spot_id);

        // return if the ad for a specific spot id is empty
        if (empty($ad_array[$spot_id]['ad_code'])) {
            return;
        }


        $buffy = '';

        $buffy .= $this->render_ads($ad_array[$spot_id], $atts);


        return $buffy;

    }



    /**
     * This function renders and returns a normal ad.
     * @param $ad_array - uses an ad array of the form:
    - current_ad_type - google or other
    - ad_code - the full ad code as entered by the user
    - disable_m - disable on monitor
    - disable_tp - disable on tablet p
    - disable_p - disable on phones
    - g_data_ad_client - the google ad client id (ca-pub-etc)
    - g_data_ad_slot - the google ad slot id
     *
     * @return the full rendered ad
     */
    function render_ads($ad_array, $atts) {

        $spot_id = ''; //the spot id header / sidebar etc we read it from shortcode

        extract(shortcode_atts(
            array(
                'spot_id' => '', //header / sidebar etc
                'align' => '', //align left or right in inline content
                'spot_title' => ''

            ), $atts));


        $buffy = '';

        $buffy .= '<div class="td-a-rec td-a-rec-id-' . $spot_id . ' ">';

            $spot_title = td_util::get_option('tds_ad_title_mob');

            if (!empty($spot_title)) {
                $buffy .= '<span class="td-adspot-title">' . $spot_title . '</span>';
            }

            $buffy .= do_shortcode(stripslashes($ad_array['ad_code']));

        $buffy .= '</div>';

        return $buffy;
    }
}