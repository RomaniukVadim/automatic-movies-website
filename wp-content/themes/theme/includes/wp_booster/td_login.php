<?php



class td_login {


    /**
     * @param $username
     * @param $password
     * @param $email
     * @return mixed  WP_Error on failure or user id on success
     */
    static function new_user($username, $password, $email) {
        $user_data = array(
            'ID' => '',
            'user_pass' => $password,
            'user_login' => $username,
            'user_nicename' => $username,
            'user_url' => '',
            'user_email' => $email,
            'display_name' => $username,
            'nickname' => $username,
            'first_name' => '',
            'role' => get_option('default_role') // Use default role or another role, e.g. 'editor'
        );
        $user_id = wp_insert_user( $user_data );
        return $user_id;

        /*
        if (is_wp_error($user_id)) {
            // existing_user_email, empty_user_login, existing_user_login
            //echo $user_id->get_error_code();

            echo $user_id->get_error_message();
        }
        */
    }


    /**
     * @param $username
     * @param $password
     * @return mixed WP_User on success or WP_Error on failure
     */
    static function login_user($username, $password) {
        $credentials = array();
        $credentials['user_login'] = $username;
        $credentials['user_password'] = $password;
        $credentials['remember'] = true;
        $user_obj = wp_signon($credentials, false);
        return $user_obj;
    }


    static function recover_password($user_login) {
        global $wpdb, $current_site;

        if ( empty( $user_login) ) {
            return false;
        } else if ( strpos( $user_login, '@' ) ) {
            $user_data = get_user_by( 'email', trim( $user_login ) );
            if ( empty( $user_data ) )
                return false;
        } else {
            $login = trim($user_login);
            $user_data = get_user_by('login', $login);
        }

        do_action('lostpassword_post');


        if ( !$user_data ) return false;

        // redefining user_login ensures we return the right case in the email
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;

        do_action('retreive_password', $user_login);  // Misspelled and deprecated
        do_action('retrieve_password', $user_login);

        $allow = apply_filters('allow_password_reset', true, $user_data->ID);

        if ( ! $allow )
            return false;
        else if ( is_wp_error($allow) )
            return false;

        //$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
        //if ( empty($key) ) {
            // Generate something random for a key...
            $key = wp_generate_password(20, false);
            do_action('retrieve_password_key', $user_login, $key);

            if ( empty( $wp_hasher ) ) {
                require_once ABSPATH . 'wp-includes/class-phpass.php';
                $wp_hasher = new PasswordHash( 8, true );
            }

            $key_hash = $wp_hasher->HashPassword( $key );

            // Now insert the new md5 key into the db
            $wpdb->update($wpdb->users, array('user_activation_key' => $key_hash), array('user_login' => $user_login));
        //}
        $message = __('Someone requested that the password be reset for the following account:', TD_THEME_NAME) . "\r\n\r\n";
        $message .= network_home_url( '/' ) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s', TD_THEME_NAME), $user_login) . "\r\n\r\n";
        $message .= __('If this was a mistake, just ignore this email and nothing will happen.', TD_THEME_NAME) . "\r\n\r\n";
        $message .= __('To reset your password, visit the following address:', TD_THEME_NAME) . "\r\n\r\n";
        $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

        if ( is_multisite() )
            $blogname = $GLOBALS['current_site']->site_name;
        else
            // The blogname option is escaped with esc_html on the way into the database in sanitize_option
            // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $title = sprintf( __('[%s] Password Reset', TD_THEME_NAME), $blogname );

        $title = apply_filters('retrieve_password_title', $title);
        $message = apply_filters('retrieve_password_message', $message, $key);

        if ( $message && !wp_mail($user_email, $title, $message) ){
            wp_die( __('The e-mail could not be sent.', TD_THEME_NAME) . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...', TD_THEME_NAME) );
        }

        return true;
    }

}
