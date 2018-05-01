<?php
/**
 * Created by ra.
 * Date: 10/9/2015
 */


/**
 * Class td_remote_video - used to gather information about remove videos
 */
class td_remote_video {


	/**
	 * Pulls information about multiple video ids
	 * @param $video_ids - the video ids that we want to get info. This function does not work with mixed video ids from multiple services
	 * @param $list_type - youtube|vimeo
	 *
	 * @return array|bool
	 */
	static function api_get_videos_info($video_ids, $list_type) {
		switch ($list_type) {
			case 'youtube':
				return self::youtube_api_get_videos_info($video_ids);
				break;
			case 'vimeo':
				return self::vimeo_api_get_videos_info($video_ids);
				break;
		}

		return false;
	}


	/**
	 * Pulls information about multiple youtube ids using just one api call to YT
	 * @param $video_ids
	 *
	 * @return array|bool
	 */
	private static function youtube_api_get_videos_info($video_ids) {
		$video_ids_comma = implode(',', $video_ids);
		$api_url = 'https://www.googleapis.com/youtube/v3/videos?id=' . $video_ids_comma . '&part=id,contentDetails,snippet&key=AIzaSyBneuqXGHEXQiJlWUOv23_FA4CzpsHaS6I';
		$json_api_response = td_remote_http::get_page($api_url, __CLASS__);

		// check for a response
		if ($json_api_response === false) {
			td_log::log(__FILE__, __FUNCTION__, 'api call failed', $api_url);
			return false;
		}

		// try to decode the json
		$api_response = @json_decode($json_api_response, true);
		if ($api_response === null and json_last_error() !== JSON_ERROR_NONE) {
			td_log::log(__FILE__, __FUNCTION__, 'Error decoding the json', $api_response);
			return false;
		}


		$buffy_videos = array();

		if (!empty($api_response['items']) and is_array($api_response['items'])) {
			foreach ($api_response['items'] as $video_item) {
				// if no item id, skip
				if (empty($video_item['id'])) {
					continue;
				}

				// duration hack for the strange youtube duration
				$duration = @$video_item['contentDetails']['duration'];
				if (!empty($duration)) {
					preg_match('/(\d+)H/', $duration, $match);
					$h = count($match) ? filter_var($match[0], FILTER_SANITIZE_NUMBER_INT) : 0;

					preg_match('/(\d+)M/', $duration, $match);
					$m = count($match) ? filter_var($match[0], FILTER_SANITIZE_NUMBER_INT) : 0;

					preg_match('/(\d+)S/', $duration, $match);
					$s = count($match) ? filter_var($match[0], FILTER_SANITIZE_NUMBER_INT) : 0;

					$duration = gmdate("H:i:s", intval($h * 3600 + $m * 60  + $s));
				}

				@$buffy_videos[$video_item['id']]= array(
					'thumb' => td_global::$http_or_https . '://img.youtube.com/vi/' . $video_item['id'] . '/default.jpg',
					'title' => $video_item['snippet']['title'],
					'time' => $duration,
				);
			}
		}

		return $buffy_videos;
	}


	/**
	 * Pulls information about multiple vimeo IDs but for each id it makes an api call
	 * @param $video_ids
	 *
	 * @return array|bool
	 */
	private static function vimeo_api_get_videos_info($video_ids) {
		$buffy_videos = array();

		foreach ($video_ids as $video_id) {
			$api_url = 'http://vimeo.com/api/v2/video/' . $video_id . '.php';   // this is the old api vimeo maintained for thumbnail_small which should not be gotten without OAuth of the new api
			$php_serialized_api_response = td_remote_http::get_page($api_url, __CLASS__);

			// check for a response
			if ($php_serialized_api_response === false) {
				td_log::log(__FILE__, __FUNCTION__, 'api call failed', $api_url);
				continue; // try with the next one
			}


			// try to deserialize
			$api_response = @unserialize($php_serialized_api_response);
			if ($api_response === false) {
				td_log::log(__FILE__, __FUNCTION__, 'Error decoding the php serialized vimeo api', $api_response);
				continue;
			}

			@$buffy_videos[$video_id]= array(
				'thumb' => $api_response[0]['thumbnail_small'],
				'title' => $api_response[0]['title'],
				'time' => gmdate("H:i:s", intval($api_response[0]['duration'])),
			);
		}


		// return false on no videos
		if (!empty($buffy_videos)) {
			return $buffy_videos;
		}
		return false;
	}



}