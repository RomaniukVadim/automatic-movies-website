<?php
class td_social_api {

    private static $caching_time = 10800;  // cache expire time - default 10800 = 3 hours

    /**
     * - decode the json data
     * @param $url
     * @return array|mixed|object|string
     */
    private function get_json($url) {
        $td_json = json_decode(td_remote_http::get_page($url, __CLASS__), true);
        if ($td_json === null and json_last_error() !== JSON_ERROR_NONE) {
            td_log::log(__FILE__, __FUNCTION__, 'Error decoding the json', $td_json);
            return 'Error decoding the json';
        }
        return $td_json;
    }

    /**
     * - parse all characters in a string and retrieve only the numeric ones
     * @param $td_string
     * @return string
     */
    private function extract_numbers_from_string($td_string) {
        $buffy = '';
        foreach (str_split($td_string) as $td_char) {
            if (is_numeric($td_char)) {
                $buffy .= $td_char;
            }
        }
        return $buffy;
    }


    /**
     * - check the cache, update it if necessary and return the service data (number of likes, followers, etc.)
     * @param $service_id
     * @param $user_id
     * @param string $access_token
     * @return array|bool|int|string
     */
    public function get_social_counter($service_id, $user_id, $access_token = '') {

        //in cache we save the service name followed by the user id (ex. facebook_envato)
        $service_cache_key = $service_id . '_' . $user_id;

        if (td_remote_cache::is_expired(__CLASS__, $service_cache_key) === true ) {
            //cache is expired - do a request
            $service_data = $this->get_service_data($service_id, $user_id, $access_token);

            //check if the cache is already set and the current cached value is > 0
            if ($service_data === 0) {
                $service_cached_data = td_remote_cache::get(__CLASS__, $service_cache_key);
                if ($service_cached_data !== false && $service_cached_data > 0){
                    //keep the cached value
                    $service_data = $service_cached_data;
                }
            }

            //set the cache - we don't use td_remote_cache::extend because td_remote_cache::is_expired returns true when the cache is not set
            td_remote_cache::set(__CLASS__, $service_cache_key , $service_data, self::$caching_time);

        } else {
            // cache is valid return the cached value
            $service_data = td_remote_cache::get(__CLASS__, $service_cache_key);
        }

        return $service_data;
    }


    /**
     * - retrieve the count for each service(likes, followers, etc)
     * @param $service_id
     * @param $user_id
     * @param $access_token
     * @return int
     */
    private function get_service_data($service_id, $user_id, $access_token) {
        $buffy_array = 0;

        switch ($service_id) {
            case 'facebook':

                //old api - v2.5 and older
                $td_data = @$this->get_json( "https://graph.facebook.com/v2.0/$user_id?access_token=$access_token&fields=likes" );


                if (!empty($td_data['likes']) && is_numeric($td_data['likes'])) {
                    $buffy_array = (int)$td_data['likes'];
                } else {
                    //new api - v2.6 and newer, likes was replaced with fan_count
                    //we have to make 2 separate requests - if you call for both fields (likes,fan_count) you receive an error on older api versions and no result is returned
                    $td_data = @$this->get_json( "https://graph.facebook.com/v2.0/$user_id?access_token=$access_token&fields=fan_count" );
                    if (!empty($td_data['fan_count'])) {
                        $buffy_array = (int)$td_data['fan_count'];
                    }
                }

                break;

            case 'twitter':

                $twitter_worked = false;

                //check 1 via https
                $td_data = td_remote_http::get_page("https://twitter.com/$user_id", __CLASS__);

                if ($td_data === false) {
                    td_log::log(__FILE__, __FUNCTION__, 'Twitter get_page method FAILED, we are trying again via the api', $td_data);
                } else {
                    $pattern = "/title=\"(.*)\"(.*)data-nav=\"followers\"/i";
                    preg_match_all($pattern, $td_data, $matches);
                    if (!empty($matches[1][0])) {
                        //$td_buffer_counter_fix = str_replace(array('.', ',', ' ', '&nbsp;'), '', htmlentities($matches[1][0]));  //old radu hack to filter numbers 2/2/2015
                        $td_buffer_counter_fix = $this->extract_numbers_from_string($matches[1][0]);

                        // $td_buffer_counter_fix = str_replace(',','', $matches[1][0]);
                        $buffy_array = (int) $td_buffer_counter_fix;

                        if (!empty($buffy_array) and is_numeric($buffy_array)) {
                            $twitter_worked = true; //skip twitter second check it worked!
                        }
                    }

                }



                //check 2 via twitter api client - we only get here if the first check did not returned anything
                if ($twitter_worked === false) {
                    if (!class_exists('TwitterApiClient')) {
                        require_once 'twitter-client.php';
                        $Client = new TwitterApiClient;
                        $Client->set_oauth (YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, SOME_ACCESS_KEY, SOME_ACCESS_SECRET);
                        try {
                            $path = 'users/show';
                            $args = array ('screen_name' => $user_id);
                            $data = @$Client->call( $path, $args, 'GET' );
                            if (!empty($data['followers_count'])) {
                                $buffy_array = (int) $data['followers_count'];  //set the buffer
                            }
                        }
                        catch( TwitterApiException $Ex ){
                            //twitter rate limit will show here
                            //print_r($Ex);
                        }
                    }
                }


                break;

            case 'vimeo':

                $td_data = td_remote_http::get_page("http://vimeo.com/$user_id", __CLASS__);
                $pattern = "/<b class=\"stat_list_count\">(.*?)<\/b>(\s+)<span class=\"stat_list_label\">likes<\/span>/";
                preg_match($pattern, $td_data, $matches);
                if (!empty($matches[1])) {
                    $buffy_array = (int) $matches[1];
                }

                break;

            case 'youtube':

                $url = "https://www.googleapis.com/youtube/v3/channels?part=statistics&key=AIzaSyBneuqXGHEXQiJlWUOv23_FA4CzpsHaS6I";

                $search_id = str_replace("channel/", "", $user_id);

                if (strpos($user_id, "channel/") === 0) {
                    $url .= "&id=$search_id";
                } else {
                    $url .= "&forUsername=$search_id";
                }

                $subscriberCount = 0;
                $td_data = @$this->get_json($url);

                if (is_array($td_data) && !empty($td_data['items'][0]['statistics']['subscriberCount'])) {
                    $subscriberCount = $td_data['items'][0]['statistics']['subscriberCount'];
                }

                if (!empty($subscriberCount)) {
                    $buffy_array = (int) $subscriberCount;
                }
                break;

            case 'googleplus':
                $td_data = @$this->get_json("https://www.googleapis.com/plus/v1/people/$user_id?key=AIzaSyA1hsdPPNpkS3lvjohwLNkOnhgsJ9YCZWw");
                if (is_array($td_data) && !empty($td_data['circledByCount'])) {
                    $buffy_array = (int) $td_data['circledByCount'];
                }else{
                    $td_data = td_remote_http::get_page("https://plus.google.com/$user_id/posts", __CLASS__);
                    $pattern = "/<span role=\"button\" class=\"d-s o5a\" tabindex=\"0\">(.*?)<\/span>/";
                    preg_match($pattern, $td_data, $matches);
                    if (!empty($matches[1])) {
                        $expl_maches = explode(' ', trim($matches[1]));
                        $buffy_array = str_replace(array('.', ','), array(''), $expl_maches[0]);
                    }
                }
                break;

            case 'instagram':
                $td_data = td_remote_http::get_page("http://instagram.com/$user_id#", __CLASS__);
                //$pattern = "/followed_by\":(.*?),\"follows\":/";
                //$pattern = "/followed_by\"\:\{\"count\"\:(.*?)\}\,\"/";

                // get the serialized data string present in the page script
                $pattern = '/window\._sharedData = (.*);<\/script>/';
                preg_match($pattern, $td_data, $matches);
                if (!empty($matches[1])) {
                    $instagram_json = json_decode($matches[1], true);
                    if (!empty($instagram_json['entry_data']['ProfilePage'][0]['user']['followed_by']['count'])) {
                        $buffy_array = (int) $instagram_json['entry_data']['ProfilePage'][0]['user']['followed_by']['count'];
                    }

                }
                break;

            case 'soundcloud':
                $td_data = @$this->get_json("http://api.soundcloud.com/users/$user_id.json?client_id=97220fb34ad034b5d4b59b967fd1717e");
                if (is_array($td_data) && !empty($td_data['followers_count'])) {
                    $buffy_array = (int) $td_data['followers_count'];
                }
                break;

            case 'rss':
                $buffy_array = (int) $user_id;
                break;
        }


        return $buffy_array;
    }

}