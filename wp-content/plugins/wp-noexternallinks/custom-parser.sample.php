<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');

#include base parser
if (!defined('WP_PLUGIN_DIR'))
    include_once(ABSPATH . 'wp-content/plugins/wp-noexternallinks/wp-noexternallinks-parser.php');
else
    include_once(WP_PLUGIN_DIR . '/wp-noexternallinks/wp-noexternallinks-parser.php');

class custom_parser extends wp_noexternallinks_parser
{
#let's redefine redirect function as a sample
    function redirect($url)
    {
        global $wp_rewrite, $wpdb, $hyper_cache_stop;
        //disable Hyper Cache plugin (http://www.satollo.net/plugins/hyper-cache) from caching this page
        $hyper_cache_stop = true;
        //disable WP Super Cache caching
        if (!defined('DONOTCACHEPAGE'))
            define('DONOTCACHEPAGE', 1);

        if ($this->options['base64']) {
            $url = base64_decode($url);
        } elseif ($this->options['maskurl']) {
            $sql = 'select url from ' . $wpdb->prefix . 'masklinks where id= %s limit 1';
            $url = $wpdb->get_var($wpdb->prepare($sql, addslashes($url)));
        }
        die('<a href="' . $url . '">just click the link!</a>');
    }
}

?>