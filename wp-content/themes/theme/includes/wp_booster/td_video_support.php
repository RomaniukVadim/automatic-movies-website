<?php
/**
 * Class td_video_support - tagDiv video support V 2.0 @since 4 nov 2015
 * downloads the video thumbnail and puts it asa a featured image to the post
 */
class td_video_support{

	private static $on_save_post_post_id; // here we keep the post_id when the save_post hook runs. We need the post_id to pass it to the other hook @see on_add_attachment_set_featured_image

	/**
	 * Render a video on the fornt end from URL
	 * @param $videoUrl - the video url that we want to render
	 *
	 * @return string - the player HTML
	 */
	static function render_video($videoUrl) {
		$buffy = '';
		switch (self::detect_video_service($videoUrl)) {
			case 'youtube':
				$buffy .= '
                <div class="wpb_video_wrapper">
                    <iframe id="td_youtube_player" width="600" height="560" src="' . 'https://www.youtube.com/embed/' . self::get_youtube_id($videoUrl) . '?enablejsapi=1&feature=oembed&wmode=opaque&vq=hd720' . self::get_youtube_time_param($videoUrl) . '" frameborder="0" allowfullscreen=""></iframe>
                    <script type="text/javascript">
						var tag = document.createElement("script");
						tag.src = "https://www.youtube.com/iframe_api";

						var firstScriptTag = document.getElementsByTagName("script")[0];
						firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

						var player;

						function onYouTubeIframeAPIReady() {
							player = new YT.Player("td_youtube_player", {
								height: "720",
								width: "960",
								events: {
									"onReady": onPlayerReady
								}
							});
						}

						function onPlayerReady(event) {
							player.setPlaybackQuality("hd720");
						}
					</script>

                </div>

                ';

				break;
			case 'dailymotion':
				$buffy .= '
                    <div class="wpb_video_wrapper">
                        <iframe frameborder="0" width="600" height="560" src="' . td_global::$http_or_https . '://www.dailymotion.com/embed/video/' . self::get_dailymotion_id($videoUrl) . '"></iframe>
                    </div>
                ';
				break;
			case 'vimeo':
				$buffy = '
                <div class="wpb_video_wrapper">
                    <iframe src="' . td_global::$http_or_https . '://player.vimeo.com/video/' . self::get_vimeo_id($videoUrl) . '" width="500" height="212" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                </div>
                ';
				break;
		}
		return $buffy;
	}


	/**
	 * Downloads the video thumb on the save_post hook
	 * @param $post_id
	 */
	static function on_save_post_get_video_thumb($post_id) {
		//verify post is not a revision
		if ( !wp_is_post_revision( $post_id ) ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			$td_post_video = get_post_meta($post_id, 'td_post_video', true);

			//check to see if the url is valid
			if (empty($td_post_video['td_video']) or self::validate_video_url($td_post_video['td_video']) === false) {
				return;
			}

			if (!empty($td_post_video['td_last_video']) and $td_post_video['td_last_video'] == $td_post_video['td_video']) {
				//we did not update the url
				return;
			}

			$videoThumbUrl = self::get_thumb_url($td_post_video['td_video']);

			if (!empty($videoThumbUrl)) {
				self::$on_save_post_post_id = $post_id;

				// add the function above to catch the attachments creation
				add_action('add_attachment', array(__CLASS__, 'on_add_attachment_set_featured_image'));

				// load the attachment from the URL
				media_sideload_image($videoThumbUrl, $post_id, $post_id);

				// we have the Image now, and the function above will have fired too setting the thumbnail ID in the process, so lets remove the hook so we don't cause any more trouble
				remove_action('add_attachment', array(__CLASS__, 'on_add_attachment_set_featured_image'));
			}
		}
	}



	/**
	 * set the last uploaded image as a featured image. We 'upload' the video thumb via the media_sideload_image call from above
	 * @internal
	 */
	static function on_add_attachment_set_featured_image($att_id){
		update_post_meta(self::$on_save_post_post_id, '_thumbnail_id', $att_id);
	}


	/**
	 * detects if we have a recognized video service and makes sure that it's a valid url
	 * @param $videoUrl
	 * @return bool
	 */
	private static function validate_video_url($videoUrl) {
		if (self::detect_video_service($videoUrl) === false) {
			return false;
		}
		if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $videoUrl)) {
			return false;
		}
		return true;
	}


	/**
	 * Returns the video thumb url from the video URL
	 * @param $videoUrl
	 * @return string
	 */
	private static function get_thumb_url($videoUrl) {

		switch (self::detect_video_service($videoUrl)) {
			case 'youtube':
				$yt_1920_url = td_global::$http_or_https . '://img.youtube.com/vi/' . self::get_youtube_id($videoUrl) . '/maxresdefault.jpg';
				$yt_640_url  = td_global::$http_or_https . '://img.youtube.com/vi/' . self::get_youtube_id($videoUrl) . '/sddefault.jpg';
				$yt_480_url  = td_global::$http_or_https . '://img.youtube.com/vi/' . self::get_youtube_id($videoUrl) . '/hqdefault.jpg';

				if (!self::is_404($yt_1920_url)) {
					return $yt_1920_url;
				}

				elseif (!self::is_404($yt_640_url)) {
					return $yt_640_url;
				}

				elseif (!self::is_404($yt_480_url)) {
					return $yt_480_url;
				}

				else {
					td_log::log(__FILE__, __FUNCTION__, 'No suitable thumb found for youtube.', $videoUrl);
				}
				break;



			case 'dailymotion':
				$dailymotion_api_json = td_remote_http::get_page('https://api.dailymotion.com/video/' . self::get_dailymotion_id($videoUrl) . '?fields=thumbnail_url', __CLASS__);
				if ($dailymotion_api_json !== false) {
					$dailymotion_api = @json_decode($dailymotion_api_json);
					if ($dailymotion_api === null and json_last_error() !== JSON_ERROR_NONE) {
						td_log::log(__FILE__, __FUNCTION__, 'json decaode failed for daily motion api', $videoUrl);
						return '';
					}

					if (!empty($dailymotion_api) and !empty($dailymotion_api->thumbnail_url)) {
						return $dailymotion_api->thumbnail_url;
					}
				}
				break;



			case 'vimeo':
				//@todo e stricat nu mai merge de ceva timp cred
				$url = 'http://vimeo.com/api/oembed.json?url=https://vimeo.com/' . self::get_vimeo_id($videoUrl);

				$response = wp_remote_get($url, array(
					'timeout' => 10,
					'sslverify' => false,
					'user-agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0'
				));

				if (!is_wp_error($response)) {
					$td_result = @json_decode(wp_remote_retrieve_body($response));
					return ($td_result->thumbnail_url);
				}
				break;
		}


		return '';
	}



	/*
	 * youtube
	 */
    private static function get_youtube_id($videoUrl) {
        $query_string = array();
        parse_str(parse_url($videoUrl, PHP_URL_QUERY), $query_string);

        if (empty($query_string["v"])) {
            //explode at ? mark
            $yt_short_link_parts_explode1 = explode('?', $videoUrl);

            //short link: http://youtu.be/AgFeZr5ptV8
            $yt_short_link_parts = explode('/', $yt_short_link_parts_explode1[0]);
            if (!empty($yt_short_link_parts[3])) {
                return $yt_short_link_parts[3];
            }

            return $yt_short_link_parts[0];
        } else {
            return $query_string["v"];
        }
    }



    /*
     * youtube t param from url (ex: http://youtu.be/AgFeZr5ptV8?t=5s)
     */
    private static function get_youtube_time_param($videoUrl) {
        $query_string = array();
        parse_str(parse_url($videoUrl, PHP_URL_QUERY), $query_string);
        if (!empty($query_string["t"])) {

            if (strpos($query_string["t"], 'm')) {
                //take minutes
                $explode_for_minutes = explode('m', $query_string["t"]);
                $minutes = trim($explode_for_minutes[0]);

                //take seconds
                $explode_for_seconds = explode('s', $explode_for_minutes[1]);
                $seconds = trim($explode_for_seconds[0]);

                $startTime = ($minutes * 60) + $seconds;
            } else {
                //take seconds
                $explode_for_seconds = explode('s', $query_string["t"]);
                $seconds = trim($explode_for_seconds[0]);

                $startTime = $seconds;
            }

            return '&start=' . $startTime;
        } else {
            return '';
        }
    }

    /*
     * Vimeo id
     */
    private static function get_vimeo_id($videoUrl) {
        sscanf(parse_url($videoUrl, PHP_URL_PATH), '/%d', $video_id);
        return $video_id;
    }

    /*
     * Dailymotion
     */
    private static function get_dailymotion_id($videoUrl) {
        $id = strtok(basename($videoUrl), '_');
        if (strpos($id,'#video=') !== false) {
            $videoParts = explode('#video=', $id);
            if (!empty($videoParts[1])) {
                return $videoParts[1];
            }
        } else {
            return $id;
        }

    }

    /*
     * Detect the video service from url
     */
    private static function detect_video_service($videoUrl) {
        $videoUrl = strtolower($videoUrl);
        if (strpos($videoUrl,'youtube.com') !== false or strpos($videoUrl,'youtu.be') !== false) {
            return 'youtube';
        }
        if (strpos($videoUrl,'dailymotion.com') !== false) {
            return 'dailymotion';
        }
        if (strpos($videoUrl,'vimeo.com') !== false) {
            return 'vimeo';
        }

        return false;
    }


    private static function is_404($url) {
        $headers = @get_headers($url);
	    if (!empty($headers[0]) and strpos($headers[0],'404') !== false) {
		    return true;
	    }
	    return false;
    }



}

