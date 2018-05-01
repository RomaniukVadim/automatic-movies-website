<?php
/**
 * Created by ra on 7/20/2015.
 */

class tdx_util {
    /**
     * Shows a soft error. The site will run as usual if possible. If the user is logged in and has 'switch_themes'
     * privileges this will also output the caller file path
     * @param $file - The file should be __FILE__
     * @param $message
     */
    static function error($file, $message, $more_data = '') {
        echo '<br><br>wp booster error:<br>';
        echo $message;
        if (is_user_logged_in() and current_user_can('switch_themes')){
            echo '<br>' . $file;
            if (!empty($more_data)) {
                echo '<br><br><pre>';
                echo 'more data:' . PHP_EOL;
                print_r($more_data);
                echo '</pre>';
            }
        };
    }

}