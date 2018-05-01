<?php


class td_exchange {

    private static $caching_time = 10800;  // 3 hours

    /**
     * Used by all the shortcodes + widget to render the exchange. The top bar has a separate function bellow
     * @param $atts
     * @return string
     */
    static function render_generic($atts) {

        // prepare the data and do an api call
        $exchange_data = array (
            'api_base' => '',
            'api_rates' => array()
        );

        $exchange_data_status = self::get_exchange_data($atts, $exchange_data);

        // check if we have an error and return that
        if ($exchange_data_status != 'api_fail_cache' and $exchange_data_status != 'api' and $exchange_data_status != 'cache') {
            return $exchange_data_status;
        }

        // render the HTML
        $buffy = '<!-- td exchange source: ' . $exchange_data_status  . ' -->';

        // renders the block template
        $buffy .= self::render_block_template($atts, $exchange_data);


        return $buffy;
    }

    /**
     * @param $atts
     * @param $exchange_data
     * @return string - block render
     */
    private static function render_block_template($atts, $exchange_data) {
        // stop render when no data is received
        if (empty($exchange_data['api_rates'])){
            $return_currency = 'eur';
            if (!empty($atts['e_base_currency'])) {
                $return_currency = $atts['e_base_currency'];
            }
            return self::error('Render failed - no data is received: ' . $return_currency);
        }

        ob_start();

        $td_currencies = array(
            'eur' => 'Euro Member Countries',
            'aud' => 'Australian Dollar',
            'bgn' => 'Bulgarian Lev',
            'brl' => 'Brazilian Real',
            'cad' => 'Canadian Dollar',
            'chf' => 'Swiss Franc',
            'cny' => 'Chinese Yuan Renminbi',
            'czk' => 'Czech Republic Koruna',
            'dkk' => 'Danish Krone',
            'gbp' => 'British Pound',
            'hkd' => 'Hong Kong Dollar',
            'hrk' => 'Croatian Kuna',
            'huf' => 'Hungarian Forint',
            'idr' => 'Indonesian Rupiah',
            'ils' => 'Israeli Shekel',
            'inr' => 'Indian Rupee',
            'jpy' => 'Japanese Yen',
            'krw' => 'Korean (South) Won',
            'mxn' => 'Mexican Peso',
            'myr' => 'Malaysian Ringgit',
            'nok' => 'Norwegian Krone',
            'nzd' => 'New Zealand Dollar',
            'php' => 'Philippine Peso',
            'pln' => 'Polish Zloty',
            'ron' => 'Romanian (New) Leu',
            'rub' => 'Russian Ruble',
            'sek' => 'Swedish Krona',
            'sgd' => 'Singapore Dollar',
            'thb' => 'Thai Baht',
            'try' => 'Turkish Lira',
            'usd' => 'United States Dollar',
            'zar' => 'South African Rand'
        );

        if (empty($atts['e_base_currency'])) {
            // default base currency is EUR
            $atts['e_base_currency'] = 'eur';
        } else {
            // we have custom base currency - add EUR to the rates list
            $exchange_data['api_rates']['EUR'] = 1;
            // custom base currency code and rate
            $base_currency_code = strtoupper($atts['e_base_currency']);
            $base_currency_rate = $exchange_data['api_rates'][$base_currency_code];
            // recalculate all rates
            $exchange_data['api_rates'] = self::td_calculate_new_rates($base_currency_code, $base_currency_rate, $exchange_data['api_rates']);
        }

        // set base currency title - ex. EUR - Euro Member Countries
        $base_currency_title =  strtoupper($atts['e_base_currency']) . ' - ' .  __td($td_currencies[$atts['e_base_currency']], TD_THEME_NAME);

        // check if we have custom rates
        if (!empty($atts['e_custom_rates'])){
            // retrieve custom rates codes
            $e_custom_rates = explode(',',strtoupper($atts['e_custom_rates']));
            // store custom selected rates
            $custom_rates_output = array();

            foreach ($e_custom_rates as $e_custom_rate) {
                // remove whitespace for each custom rate code
                $e_custom_rate = trim($e_custom_rate);
                // check if the custom exists in the api rates array
                if (isset($exchange_data['api_rates'][$e_custom_rate])){
                    $custom_rates_output[$e_custom_rate] = $exchange_data['api_rates'][$e_custom_rate];
                }
            }
            // replace default rates with custom rates
            if (!empty($custom_rates_output)) {
                $exchange_data['api_rates'] = $custom_rates_output;
            }
        }

        // default decimals is 4
        $e_rate_decimals = 4;
        // get rate decimals
        if (!empty($atts['e_rate_decimals'])) {
            $e_rate_decimals = $atts['e_rate_decimals'];
        }

        ?>

        <div class="td-exchange-header">
            <div class="td-exchange-base"><span class="td-flags td-flag-header td-flag-<?php echo $atts['e_base_currency'] ?>"></span><span class="td-base-title"><?php echo $base_currency_title ?></span></div>
        </div>


         <div class="td-exchange-rates">
            <?php

            foreach ($exchange_data['api_rates'] as $rate_code => $rate_value) {
                // use lowercase on classes
                $rate_code_class = strtolower($rate_code);
                // change rate into currency - ex. 1usd = 1.3210eur
                $rate_value = 1 / $rate_value;
                // round the rate value using decimals set on block settings
                $rate_value = round($rate_value, $e_rate_decimals);
                // flag title
                $rate_title = 'title="' . __td($td_currencies[$rate_code_class], TD_THEME_NAME) . '"';
                ?>
                <div class="td-rate">
                    <span <?php echo $rate_title ?> class="td-flags td-flags-all td-flag-<?php echo $rate_code_class ?>"></span>
                    <div class="td-rate-currency td-rate-<?php echo $rate_code_class ?>"><?php echo $rate_code . '</div><div class="td-exchange-value">' . number_format_i18n($rate_value, $e_rate_decimals)?></div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="clearfix"></div>

        <?php
        return ob_get_clean();
    }


    /**
     * @param $base_currency_code (string) - ex. AUD or USD
     * @param $base_currency_rate (integer)
     * @param $default_api_rates (array)
     * @return $new_rate (array) - new rate based on the base rate
     */
    private static function td_calculate_new_rates($base_currency_code, $base_currency_rate, $default_api_rates) {
        foreach ($default_api_rates as $rate_code => $rate_value) {
            // remove the custom selected base rate from the the list
            if ($base_currency_code != $rate_code) {
                $new_rates[$rate_code] = $rate_value / $base_currency_rate;
            }
        }
        return $new_rates;
    }


    /**
     * @param $atts
     * @param $exchange_data - the precomputed exchange data
     * @return bool|string
     *  - bool:true - we have the $exchange_data (from cache or from a real request)
     *  - string - error message
     */
    private static function get_exchange_data($atts, &$exchange_data) {

        $cache_key = 'td_exchange_eur';
		if (td_remote_cache::is_expired(__CLASS__, $cache_key) === true) {
            // cache is expired - do a request
            $fixed_api_data = self::fixer_get_data($atts, $exchange_data);
            // check the api call response
            if ($fixed_api_data !== true) {
                // we have an error in the api
                $exchange_data = td_remote_cache::get(__CLASS__, $cache_key);
                if ($exchange_data === false) {    // miss and io error... shit / die
                    return self::error('Exchange API error: ' . $fixed_api_data);
                }

                td_remote_cache::extend(__CLASS__, $cache_key, self::$caching_time);
                return 'api_fail_cache';
            }

            td_remote_cache::set(__CLASS__, $cache_key, $exchange_data, self::$caching_time); //we have a reply and we set it
            return 'api';

        } else {
            // cache is valid
            $exchange_data = td_remote_cache::get(__CLASS__, $cache_key);
            return 'cache';
        }
    }


    /**
     * adds to the &$exchange_data the information from FIXER
     * @param $atts - the shortcode atts
     * @param $exchange_data - BYREF exchange data - this function will add to it
     *
     * @return bool|string
     *   - true: if everything is ok
     *   - string: the error message, if there was an error
     */
    private static function fixer_get_data($atts, &$exchange_data){

        // default base currency is eur and it returns all rates
        $api_url = 'https://api.fixer.io/latest';
        $json_api_response = td_remote_http::get_page($api_url, __CLASS__);

        // check for a response
        if ($json_api_response === false) {
            td_log::log(__FILE__, __FUNCTION__, 'Api call failed', $api_url);
            return 'Api call failed';
        }

        // try to decode the json
        $api_response = @json_decode($json_api_response, true);
        if ($api_response === null and json_last_error() !== JSON_ERROR_NONE) {
            td_log::log(__FILE__, __FUNCTION__, 'Error decoding the json', $api_response);
            return 'Error decoding the json';
        }

        // current base currency
        if (isset($api_response['base'])) {
            $exchange_data['api_base'] = $api_response['base'];
        }

        // current rates
        if (isset($api_response['rates'])) {
            $exchange_data['api_rates'] = $api_response['rates'];
        }

        return true;
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

