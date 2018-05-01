<?php
/**
 * Created by ra.
 * Date: 9/24/2015
 */

/**
 * Class td_remote_cache - custom cache built for remote requests
 */
class td_remote_cache {

	/**
	 * @var array here we hold the cache - it is loaded and saved to a WordPress option as needed
	 */
	private static $cache = array();

	/**
	 * @var bool flag used to hook the shutdown action only once
	 */
	private static $is_shutdown_hooked = false;


	/**
	 * @var bool when this is false, read_cache_meta will not read so it looks like the cache is always empty
	 */
	private static $is_cache_enabled = true;






	/**
	 * Checks if an item is expired. It does not extend the expiration notice
	 *
	 * @param $group - the caching group to use
	 * @param $item_id - the item id
	 *
	 * @return bool
	 *  - true: the item is expired OR is not in cache
	 *  - false: the item is in cache and it's not expired
	 */
	static function is_expired($group, $item_id) {
		self::read_cache_meta();
		if (
			isset(self::$cache[$group][$item_id])
			and time() - self::$cache[$group][$item_id]['timestamp'] < self::$cache[$group][$item_id]['expires']   // timestamp and expires must be present
			) {
				return false;
		}
		return true;
	}



	/**
	 * Gets an item from the cache. If the item is not in the cache, it will return false
	 * @param $group - the caching group to use
	 * @param $item_id - the item id
	 *
	 * @return bool|array|string
	 *  - the item (array|string)
	 *  - false if the item is not in the cache. Note that false is not return for expired items, this function does not check if the item is expired
	 */
	static function get($group, $item_id) {
		self::read_cache_meta();
		if (isset(self::$cache[$group][$item_id])) {
			return self::$cache[$group][$item_id]['value']; // hit
		}
		return false; // miss
	}



	/**
	 * extends the expiration date of an item
	 * @param $group - the caching group
	 * @param $item_id - the item id, must be unique in the group
	 * @param $new_expires_value - new expiration value (WARNING: this will overwride the current expiration value of the item
	 * it does not append the value to the existing expiration value)
	 */
	static function extend($group, $item_id, $new_expires_value) {
		self::read_cache_meta();
		if (isset(self::$cache[$group][$item_id])) {
			self::$cache[$group][$item_id]['expires'] = $new_expires_value;
			self::$cache[$group][$item_id]['timestamp'] = time();
		}
		self::schedule_save_cache();
	}



	/**
	 * sets an item to the cache. If the item is already present, it will overwrite it
	 * @param $group - the caching group
	 * @param $item_id - the item id, must be unique in the group
	 * @param $item_value - the item (it can be string|array|bool etc)
	 * @param $expires - in seconds, after how many seconds the item has expired
	 */
	static function set($group, $item_id, $item_value, $expires) {
		self::read_cache_meta();
		self::$cache[$group][$item_id] = array (
			'value' => $item_value,
			'expires' => $expires,
			'timestamp' => time()
		);
		self::schedule_save_cache();
	}


	/**
	 * deletes a whole group from the cache. @todo as of 29/9/2015 is not used
	 * @param $group
	 */
	static function delete_group($group) {
		self::read_cache_meta();
		unset(self::$cache[$group]);
		self::schedule_save_cache();
	}


	/**
	 * deletes an item from the cache
	 * @param $group
	 * @param $item_id
	 */
	static function delete_item($group, $item_id) {
		self::read_cache_meta();
		unset(self::$cache[$group][$item_id]);
		self::schedule_save_cache();
	}


	/**
	 * called by all the functions that use the cache, it reads the caching key from the db only once
	 */
	private static function read_cache_meta() {
		// disable the cache using this method
		if (self::$is_cache_enabled === false) {
			self::$cache = array();
			return;
		}

		// read the cache only once!
		if (empty(self::$cache)) {
			self::$cache = get_option(TD_THEME_OPTIONS_NAME . '_remote_cache');
		}
	}


	/**
	 *
	 */
	private static function schedule_save_cache() {
		// make sure that we hook only once
		if (self::$is_shutdown_hooked === false) {
			add_action('shutdown', array(__CLASS__, 'on_shutdown_save_cache'));
			self::$is_shutdown_hooked = true;
		}
	}

	/**
	 * @internal
	 * disables the cache. Warning it also CLEARS the cache
	 */
	static function _disable_cache() {
		delete_option(TD_THEME_OPTIONS_NAME . '_remote_cache');
		self::$is_cache_enabled = false;
	}


	/**
	 * @internal
	 * save the cache hook
	 */
	static function on_shutdown_save_cache() {
		update_option(TD_THEME_OPTIONS_NAME . '_remote_cache', self::$cache);
	}

}