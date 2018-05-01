<?php

class td_instagram {

    private static $caching_time = 10800;  // 3 hours

    public static function render_generic($atts) {
        // prepare the data
        $instragram_data = array(
            'user' => '',
        );

        // get instagram data
        $instagram_data_status = self::get_instagram_data($atts, $instragram_data);

        // check if we have an error and return that
        if ($instagram_data_status != 'instagram_fail_cache' and $instagram_data_status != 'instagram_cache_updated' and $instagram_data_status != 'instagram_cache') {
            return $instagram_data_status;
        }

        // render the HTML
        $buffy = '<!-- td instagram source: ' . $instagram_data_status . ' -->';

        // renders the block template
        $buffy .= self::render_block_template($atts, $instragram_data);

        return $buffy;
    }

    private static function render_block_template($atts, $instagram_data) {

        // stop render when no data is received
        if ($instagram_data['user'] == '') {
            return self::error('Render failed - no data is received, please check the ID: ' . $atts['instagram_id']);
        }

        // debugging
//        echo '<pre>';
//        print_r($instagram_data);
//        echo '</pre>';


        ob_start();

        // number of images per row - by default display 3 images
        $images_per_row = 3;
        if (!empty($atts['instagram_images_per_row'])) {
            $images_per_row = $atts['instagram_images_per_row'];
        }

        // number of rows
        $number_of_rows = 1;
        if (!empty($atts['instagram_number_of_rows'])) {
            $number_of_rows = $atts['instagram_number_of_rows'];
        }

        // number of total images displayed - images_row x number_of_rows
        $images_total_number = $images_per_row * $number_of_rows;

        // image gap
        $image_gap = '';
        if (!empty($atts['instagram_margin'])) {
            $image_gap = ' td-image-gap-' . $atts['instagram_margin'];
        }

        // profile picture
        $instagram_profile_picture = '';
        if (isset($instagram_data['user']['profile_pic_url'])) {
            $instagram_profile_picture = $instagram_data['user']['profile_pic_url'];
        }

        // instagram followers
        $instagram_followers = 0;
        if (isset($instagram_data['user']['followed_by']['count'])) {
            $instagram_followers = $instagram_data['user']['followed_by']['count'];
        }

        // instagram followers - check followers count data type
        $instagram_followers_type = gettype($instagram_followers);
        if ($instagram_followers_type == 'string') {
            // retrieve number from string
            $number_from_string = self::get_number_from_string($instagram_followers);
            if ($number_from_string !== false) {
                $instagram_followers = $number_from_string;
            } else {
                td_log::log(__FILE__, __FUNCTION__, 'Instagram followers is a string with no numbers included', $instagram_followers);
                $instagram_followers = 0;
            }
        } elseif ($instagram_followers_type == 'integer') {
            // do nothing, integer is ok
        } else {
            // for other types return 0
            td_log::log(__FILE__, __FUNCTION__, 'Instagram followers has an unsupported type', $instagram_followers);
            $instagram_followers = 0;
        }

        // instagram followers - format the followers number (the number is not rounded because it may return unrealistic values)
        if ($instagram_followers >= 1000000) {
            // display 1.100.000 as 1.1m
            $instagram_followers = number_format_i18n($instagram_followers / 1000000, 1) . 'm';
        } elseif ($instagram_followers >= 10000) {
            // display 10.100 as 10.1k
            $instagram_followers = number_format_i18n($instagram_followers / 1000, 1) . 'k';
        } else {
            // default
            $instagram_followers = number_format_i18n($instagram_followers);
        }

        ?>
        <!-- header section -->
        <?php
        if (empty($atts['instagram_header'])) {
            ?>
            <div class="td-instagram-header">
                <div class="td-instagram-profile-image"><img src="<?php echo $instagram_profile_picture ?>"/></div>
                <div class="td-instagram-meta">
                    <div class="td-instagram-user"><a href="https://www.instagram.com/<?php echo $atts['instagram_id'] ?>" target="_blank">@<?php echo $atts['instagram_id'] ?></a></div>
                    <div class="td-instagram-followers"><span><?php echo $instagram_followers . '</span> ' .  __td('Followers', TD_THEME_NAME); ?></div>
                    <a class="td-instagram-button" href="https://www.instagram.com/<?php echo $atts['instagram_id'] ?>" target="_blank"><?php echo __td('Follow', TD_THEME_NAME); ?></a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php
        }
        ?>

        <!-- user shared images -->
        <?php
        if (isset($instagram_data['user']['media']['nodes'])) {
            ?>
            <div class="td-instagram-main td-images-on-row-<?php echo $images_per_row . $image_gap; ?>">
                <?php
                $image_count = 0;
                foreach ($instagram_data['user']['media']['nodes'] as $image) {
                    // display only if the code and thumbnail are set
                    if ( isset( $image['code'] ) && isset( $image['thumbnail_src'] ) ) {
                        ?>
                        <div class="td-instagram-element">
                            <!-- image -->
                            <a href="https://www.instagram.com/p/<?php echo $image['code'] ?>" target="_blank">
                                <img class="td-instagram-image" src="<?php echo $image['thumbnail_src'] ?>"/>
                            </a>
                            <!-- video icon -->
                            <?php
                            if ( $image['is_video'] == 1 ) {
                                ?>
                                <span class="td-video-play-ico">
                                    <img width="40" class="td-retina" src="<?php echo td_global::$get_template_directory_uri . '/images/icons/ico-video-large.png' ?>" alt="video"/>
                                </span>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- number of images to display -->
                    <?php
                    $image_count ++;
                    if ( $image_count == $images_total_number ) {
                        break;
                    }
                }
                ?>
                <div class="clearfix"></div>
            </div>
            <?php
        }
        return ob_get_clean();
    }


    /**
     * @param $str
     * @return bool|int
     * - bool: false - $str is not a string or we don't have a number
     * - integer - return the number
     */
    private static function get_number_from_string($str) {
        // no string received
        if (gettype($str) != 'string') {
            return false;
        }
        // retrieve the numbers
        $string_length = strlen($str);
        $id = '';
        for( $i = 0; $i <= $string_length; $i++ ) {
            $char = substr($str, $i, 1);
            if(is_numeric($char)) {
                $id .= $char;
            }
        }
        // we have a number
        if ($id != '') {
            return intval($id);
        }
        return false;
    }


    /**
     * @param $atts
     * @param $instragram_data - the precomputed instagram data
     * @return bool|string
     *  - bool:true - we have the $instragram_data (from cache or from a real request)
     *  - string - error message
     */
    private static function get_instagram_data($atts, &$instragram_data) {

        $cache_key = 'td_instragram_' . strtolower($atts['instagram_id']);
        if (td_remote_cache::is_expired(__CLASS__, $cache_key) === true) {
            // cache is expired - do a request
            $instagram_get_data = self::instagram_get_json($atts, $instragram_data);
            // check the call response
            if ($instagram_get_data !== true) {
                // we have an error in the data retrieval process
                $instragram_data = td_remote_cache::get(__CLASS__, $cache_key);
                if ($instragram_data === false) {    // miss and io error... shit / die
                    return self::error('Instagram data error: ' . $instagram_get_data);
                }

                td_remote_cache::extend(__CLASS__, $cache_key, self::$caching_time);
                return 'instagram_fail_cache';
            }

            td_remote_cache::set(__CLASS__, $cache_key, $instragram_data, self::$caching_time); //we have a reply and we set it
            return 'instagram_cache_updated';

        } else {
            // cache is valid
            $instragram_data = td_remote_cache::get(__CLASS__, $cache_key);
            return 'instagram_cache';
        }
    }

    /**
     * @param $atts
     * @param $instagram_data
     * @return bool|string
     * - bool: true when data is retrieved
     * - string - error message
     */
    private static function instagram_get_json($atts, &$instagram_data){

        $instagram_html_data = self::parse_instagram_html($atts['instagram_id']);

        if ($instagram_html_data === false) {
            td_log::log(__FILE__, __FUNCTION__, 'Instagram html data cannot be retrieved', $atts['instagram_id']);
            return 'Instagram html data cannot be retrieved';
        }

        // try to decode the json
        $instagram_json = json_decode($instagram_html_data, true);
        if ($instagram_json === null and json_last_error() !== JSON_ERROR_NONE) {
            td_log::log(__FILE__, __FUNCTION__, 'Error decoding the instagram json', $instagram_json);
            return 'Error decoding the instagram json';
        }

        // current instagram data is not set
        if (!isset($instagram_json['entry_data']['ProfilePage'][0]['user'])) {
            return 'Instagram data is not set, plese check the ID';
        }

        $instagram_data['user'] = $instagram_json['entry_data']['ProfilePage'][0]['user'];

        return true;
    }


    /**
     * @param $instagram_id
     * @return bool|string
     * - bool: false - no match was found, data not retrieved
     * - string - return the serialized data present in the page script
     */
    private static function parse_instagram_html($instagram_id) {

        $data = td_remote_http::get_page('https://www.instagram.com/' . $instagram_id, __CLASS__);
        if ($data === false) {
            return false;
        }

        // get the serialized data string present in the page script
        $pattern = '/window\._sharedData = (.*);<\/script>/';
        preg_match($pattern, $data, $matches);

        if (!empty($matches[1])) {
            return $matches[1];
        } else {
            return false;
        }

    }


    /**
     * Show an error if the user is logged in. It does not check for admin
     * @param $msg
     * @return string
     */
    private static function error($msg) {
        if (is_user_logged_in()) {
            return $msg;
        }
        return '';
    }
}