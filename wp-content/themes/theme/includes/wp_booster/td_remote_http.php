<?php
/**
 * Created by ra.
 * Date: 9/24/2015
 */

/**
 * Class td_remote_http - exports the get_page method. Is used to retrieve remote information
 */
class td_remote_http {

	const http_request_timeout = 10;
	const run_test_on_fail_after = 10; // if all channels failed, run the test again after 2 hours



	/**
	 * @var array the supported channels. We also have to declare them below @see td_remote_http::get_page_via_channel
	 */
	private static $get_url_channels = array (
		'wordpress',
		'file_get_contents',
		'curl'
	);



	/**
	 * returns the html of a remote page or FALSE on error. This function also automatically logs HTTP request errors to td_log
	 * @param $url - the remote url
	 * @param string $caller_id - a string id to aid us with information about what component called this function. When we get the logs from our clients
	 * the $caller_id will help us to know what component generated the failed http request and what method was used to request the data
	 *
	 * @return bool|string
	 *          - string: the page html
	 *          - bool FALSE: if the request failed
	 */
	static function get_page($url, $caller_id = '') {
		$td_remote_http = td_util::get_option('td_remote_http');

		// see if we have a manual channel
		if (!empty($td_remote_http['manual_channel'])) {
			//return here
			return self::get_page_via_channel($url, $caller_id, $td_remote_http['manual_channel']);
		}

		// check if the test ran
		if (isset($td_remote_http['test_status'])) {
			// the test ran

			if ($td_remote_http['test_status'] == 'all_fail') {
				// all the tests fail, see if the requiered time passed to run all of them again
				if (time() - $td_remote_http['test_time'] > self::run_test_on_fail_after) {
					// run the test again
					$channel_that_passed = '';
					$test_result = self::run_test($url, $caller_id, $channel_that_passed);

					$td_remote_http['test_time'] = time();
					if ($test_result !== false) {

						$td_remote_http['test_status'] = $channel_that_passed;
						td_util::update_option('td_remote_http', $td_remote_http); // save new status
						td_log::log_info(__FILE__, __FUNCTION__, 'all_fail -> time passed -> Test passed with channel: ' . $channel_that_passed, $url);
						return $test_result;

					} else {

						// all tests failed
						$td_remote_http['test_status'] = 'all_fail';
						td_util::update_option('td_remote_http', $td_remote_http); // save new status
						td_log::log_info(__FILE__, __FUNCTION__, 'all_fail -> time passed -> all_fail again', $url);
						return false;

					}


				} else {
					td_log::log_info(__FILE__, __FUNCTION__, 'all_fail -> waiting' . (time() - $td_remote_http['test_time']) . 's passed', $url);
					return false; // no working channels, and we have to wait more
				}
			} else {
				// we have a channel that passed in test_status
				// @todo here we can count the number of fails and run the test again
				td_log::log_info(__FILE__, __FUNCTION__, 'we have a channel that passed in test_status: ' . $td_remote_http['test_status'], $url);
				return self::get_page_via_channel($url, $caller_id, $td_remote_http['test_status']);
			}

		} else {
			// the test was not run
			$channel_that_passed = '';
			$test_result = self::run_test($url, $caller_id, $channel_that_passed);

			$td_remote_http['test_time'] = time();
			if ($test_result !== false) {
				$td_remote_http['test_status'] = $channel_that_passed;
				td_util::update_option('td_remote_http', $td_remote_http); //save
				td_log::log_info(__FILE__, __FUNCTION__, 'first run -> test passed with channel: ' . $channel_that_passed, $url);
				return $test_result;
			} else {
				// all tests failed
				$td_remote_http['test_status'] = 'all_fail';
				td_util::update_option('td_remote_http', $td_remote_http); //save
				td_log::log_info(__FILE__, __FUNCTION__, 'first run -> all failed', $url);
				return false;
			}


		}

	}



	/**
	 * Tries to download a page by trying each chanel one by one.
	 * If a good channel is found, it will be returned by ref in the &$channel_that_passed parameter
	 * @param $url - the url that we want to fatch
	 * @param string $caller_id - we need to pass the caller_id so we can log who requested the channel
	 * @param string &$channel_that_passed by reference!
	 *
	 * @return bool|string
	 *          - bool FALSE: if no usable channel found
	 *          - string: the content of the page if a channel passed. NOTE: &$channel_that_passed will contain the channel that passed
	 */
	private static function run_test($url, $caller_id = '', &$channel_that_passed) {
		foreach (self::$get_url_channels as $channel) {
			$response = self::get_page_via_channel($url, $caller_id, $channel);
			if ($response !== false) {
				$channel_that_passed = $channel;
				return $response;
			}
		}

		return false;
	}



	/**
	 * Returns a page's HTML by using a specific channel
	 * @param $url
	 * @param string $caller_id
	 * @param $channel
	 *
	 * @return bool|mixed|string
	 */
	private static function get_page_via_channel($url, $caller_id = '', $channel) {
		switch ($channel) {
			case 'wordpress':
				return self::get_url_wordpress($url, $caller_id);
			break;

			case 'file_get_contents':
				return self::get_url_file_get_contents($url, $caller_id);
			break;

			case 'curl':
				return self::get_url_curl($url, $caller_id);
			break;
		}

		return false;
	}



	/**
	 * WordPress download channel
	 * @param $url
	 * @param string $caller_id
	 *
	 * @return bool|string
	 */
	private static function get_url_wordpress($url, $caller_id = '') {
		//return false;
		$response = wp_remote_get($url, array(
			'timeout' => self::http_request_timeout,
			'sslverify' => false,
			'user-agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0'
		));

		if (is_wp_error($response)) {
			td_log::log(__FILE__, __FUNCTION__, 'caller_id:' . $caller_id . ' got wp_error, get_error_message: ' . $response->get_error_message());
			return false;
		}

		$td_request_result = wp_remote_retrieve_body($response);
		if ($td_request_result == '') {
			td_log::log(__FILE__, __FUNCTION__, 'caller_id:' . $caller_id . ' Empty response via wp_remote_retrieve_body, Quitting. HTTP REPONSE CODE: ' . wp_remote_retrieve_response_code($response));
			return false;
		}
		return $td_request_result;
	}



	/**
	 * file_get_contents download channel
	 * @param $url
	 * @param string $caller_id
	 *
	 * @return bool|string
	 */
	private static function get_url_file_get_contents($url, $caller_id = '') {

		$opts = array(
			'http'=>array(
				'method' => "GET",
				'timeout' => self::http_request_timeout,        //added in td_remote_http v1.0
				'ignore_errors' => true,                        //added in td_remote_http v1.0
				'header' => "Accept-language: en\r\n" .
				            "User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0\r\n"
			)
		);
		$context = stream_context_create($opts);
		$td_data = @file_get_contents($url, false, $context);

		if ($td_data === false) {
			td_log::log(__FILE__, __FUNCTION__, 'caller_id:' . $caller_id . ' file_get_contents returned FALSE (AKA error), full headers attached', $http_response_header); // wtf $http_response_header? -> http://php.net/manual/ro/reserved.variables.httpresponseheader.php
			return false;
		}

		if (empty($td_data)) {
			td_log::log(__FILE__, __FUNCTION__, 'caller_id:' . $caller_id . ' file_get_contents returned empty result, full headers attached', $http_response_header);   // wtf $http_response_header? -> http://php.net/manual/ro/reserved.variables.httpresponseheader.php
			return false;
		} else {
			return $td_data;
		}
	}



	/**
	 * curl download channel
	 * @param $url
	 * @param string $caller_id
	 *
	 * @return bool|mixed
	 */
	private static function get_url_curl($url, $caller_id = '') {
		//return false;
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		//mergem dupa redirecturi
		curl_setopt ($ch,  CURLOPT_FOLLOWLOCATION, true);
		curl_setopt ($ch,  CURLOPT_MAXREDIRS, 3); //max redirects
		curl_setopt ($ch,  CURLOPT_ENCODING, ''); //folosim compresia - daca e empty trimite toate formele de compresie suportate
		//timeout? - 300 sec = 5 min
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, self::http_request_timeout); //Fail if a web server doesn’t respond to a connection within a time limit (seconds).
		curl_setopt($ch, CURLOPT_TIMEOUT, self::http_request_timeout); //Fail if a web server doesn’t return the web page within a time limit (seconds).
		curl_setopt($ch, CURLOPT_HEADER, false);
		// misc
		curl_setopt($ch,CURLOPT_AUTOREFERER,true); //The referer is a URL for the web page that linked to the requested web page. When following redirects, set this to true and CURL automatically fills in the URL of the page being redirected away from.
		curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($ch);

		//error checking
		if ($data === false) {
			td_log::log(__FILE__, __FUNCTION__, 'caller_id:' . $caller_id . ' curl_exec returned FALSE (AKA Error) curl_error:' . curl_error($ch) . ' curl_getinfo attached to this message', curl_getinfo($ch));
			curl_close($ch);
			return false;
		}

		curl_close($ch);

		return $data;
	}





}