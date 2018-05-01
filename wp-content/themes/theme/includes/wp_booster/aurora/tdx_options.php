<?php
/**
 * Created by ra on 7/23/2015.
 */


class tdx_options {
    private static $options_cache = array();

    /**
     * @var array - here we store all the registered data sources
     */
    private static $registered_data_sources = array();



    /**
     * reads an option for a specific plugin BUT first it looks in the cache
     * @param $datasource
     * @param $option_id
     * @return string
     */
    static function get_option($datasource, $option_id ) {

	    switch ( $datasource ) {

		    case 'td_woo_question_translate' :

			    $datasource_id = 'TD_Woo_Question';
			    $datasource_key = $datasource;

			    // check if the data source is registered
			    if (!in_array($datasource_id, self::$registered_data_sources)) {
				    tdx_util::error(__FILE__, 'get_option on an unregistered data source', $datasource_id);
				    return '';
			    }

			    if (!isset(self::$options_cache[$datasource_id])) {
				    // the option cache is not set for this plugin id, fetch it form db
				    self::$options_cache[$datasource_id] = get_option($datasource_id);
			    }

				if ( empty( self::$options_cache[$datasource_id][$datasource_key] ) ) {
					return '';

			    } else {
					if ( empty( $option_id ) ) {
						return self::$options_cache[$datasource_id][$datasource_key];
					} else {
						if ( empty( self::$options_cache[$datasource_id][$datasource_key][$option_id] ) ) {
							return '';
						} else {
							return self::$options_cache[$datasource_id][$datasource_key][$option_id];
						}
					}
			    }

			    break;

		    case 'td_woo_relprod_translate' :

			    $datasource_id = 'TD_Woo_Relprod';
			    $datasource_key = $datasource;

			    // check if the data source is registered
			    if (!in_array($datasource_id, self::$registered_data_sources)) {
				    tdx_util::error(__FILE__, 'get_option on an unregistered data source', $datasource_id);
				    return '';
			    }

			    if (!isset(self::$options_cache[$datasource_id])) {
				    // the option cache is not set for this plugin id, fetch it form db
				    self::$options_cache[$datasource_id] = get_option($datasource_id);
			    }

			    if ( empty( self::$options_cache[$datasource_id][$datasource_key] ) ) {
				    return '';

			    } else {
				    if ( empty( $option_id ) ) {
					    return self::$options_cache[$datasource_id][$datasource_key];
				    } else {
					    if ( empty( self::$options_cache[$datasource_id][$datasource_key][$option_id] ) ) {
						    return '';
					    } else {
						    return self::$options_cache[$datasource_id][$datasource_key][$option_id];
					    }
				    }
			    }

			    break;


		    default:

			    // check if the data source is registered
			    if (!in_array($datasource, self::$registered_data_sources)) {
				    tdx_util::error(__FILE__, 'get_option on an unregistered data source', $datasource);
				    return '';
			    }

			    if (!isset(self::$options_cache[$datasource])) {
				    // the option cache is not set for this plugin id, fetch it form db
				    self::$options_cache[$datasource] = get_option($datasource);
			    }

			    if (!empty(self::$options_cache[$datasource][$option_id])) {
				    return self::$options_cache[$datasource][$option_id];
			    } else {
				    return '';
			    }
	    }
    }

    /**
     * updates an option in the cache. YOU MUST FLUSH THE CACHE TO THE DATABASE TO SAVE IT!
     * @param $datasource
     * @param $option_id
     * @param $option_value
     */
    static function update_option_in_cache($datasource, $option_id, $option_value) {
        // check if the data source is registered
        if (!in_array($datasource, self::$registered_data_sources)) {
            tdx_util::error(__FILE__, 'get_option on an unregistered data source datasource: ' . $datasource . ' option_id: ' . $option_id . ' - Make sure your case is added in td_panel_data_source read and update methods');
            return;
        }

        if (!isset(self::$options_cache[$datasource])) {
            // the option cache is not set for this plugin id, fetch it form db
            self::$options_cache[$datasource] = get_option($datasource);
        }

        // update the option cache
        self::$options_cache[$datasource][$option_id] = $option_value;
    }



	static function update_options_in_cache($datasource, $options_array) {
		// check if the data source is registered
		if (!in_array($datasource, self::$registered_data_sources)) {
			tdx_util::error(__FILE__, 'get_option on an unregistered data source', $datasource);
			return;
		}

		if (!isset(self::$options_cache[$datasource])) {
			// the option cache is not set for this plugin id, fetch it form db
			self::$options_cache[$datasource] = get_option($datasource);
		}

		foreach ($options_array as $option_id => $option_value) {
			self::$options_cache[$datasource][$option_id] = $option_value;
		}
	}



    /**
     * saves the cache to the database
     */
    static function flush_options() {
        if (empty(self::$options_cache)) {
            return;
        }
        foreach (self::$options_cache as $datasource => $option_cache) {
            update_option($datasource, $option_cache);
        }
    }



    /**
     * Allows plugins to register new datasources
     * @param $data_source_id - the id of the datasource
     */
    static function register_data_source($data_source_id) {
        self::$registered_data_sources[] = $data_source_id;
    }


    /**
     * saves a bundle of options @see td_panel_data_source::update
     * IT ALSO FLUSHES THE CACHE
     * @param $datasource - the data source
     * @param $options_array  - the options array to update
     */
    static function set_data_to_datasource($datasource, $options_array) {

	    if ( ! empty($options_array) and is_array( $options_array ) ) {

		    switch ( $datasource ) {

			    case 'td_woo_question_translate' :

				    self::update_option_in_cache( 'TD_Woo_Question', $datasource, $options_array );
				    break;

			    case 'td_woo_relprod_translate' :

				    self::update_option_in_cache( 'TD_Woo_Relprod', $datasource, $options_array );
				    break;

			    default :

				    foreach ( $options_array as $option_id => $option_value ) {
					    self::update_option_in_cache( $datasource, $option_id, $option_value );
				    }
		    }
        }
        self::flush_options();
    }
}