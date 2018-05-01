<?php
//check if admin allow registration
$users_can_register = get_option('users_can_register');

$users_can_register_form = '';

if ($users_can_register == 1) {

	//add the Register tab to the modal window if `Anyone can register` chec
	//$users_can_register_tab = ' / <a id="register-link">' . __td('REGISTER', TD_THEME_NAME) . '</a>';

	$users_can_register_form = '
            <div id="td-register-div" class="td-login-animation td-login-hide">
            	<!-- close button -->
	            <div class="td-register-close">
	                <a href="#" class="td-back-button"><i class="td-icon-read-down"></i></a>
	                <div class="td-login-title">' . __td('Sign up', TD_THEME_NAME) . '</div>
	                <!-- close button -->
		            <div class="td-mobile-close">
		                <a href="#"><i class="td-icon-close-mobile"></i></a>
		            </div>
	            </div>
            	<div class="td-login-panel-title"><span>' . __td('Welcome!', TD_THEME_NAME) . '</span>' . __td('Register for an account', TD_THEME_NAME) .'</div>
                <div class="td-login-form-wrap">
	                <div class="td_display_err"></div>
	                <div class="td-login-inputs"><input class="td-login-input" type="text" name="register_email" id="register_email" value="" required><label>' . __td('your email', TD_THEME_NAME) .'</label></div>
	                <div class="td-login-inputs"><input class="td-login-input" type="text" name="register_user" id="register_user" value="" required><label>' . __td('your username', TD_THEME_NAME) .'</label></div>
	                <input type="button" name="register_button" id="register_button" class="wpb_button btn td-login-button" value="' . __td('REGISTER', TD_THEME_NAME) . '">
	                <div class="td-login-info-text">' . __td('A password will be e-mailed to you.', TD_THEME_NAME) . '</div>
                </div>
            </div>';
}

echo '
            <div id="td-login-div" class="td-login-animation td-login-hide">
            	<!-- close button -->
	            <div class="td-login-close">
	                <a href="#" class="td-back-button"><i class="td-icon-read-down"></i></a>
	                <div class="td-login-title">' . __td('Sign in', TD_THEME_NAME) . '</div>
	                <!-- close button -->
		            <div class="td-mobile-close">
		                <a href="#"><i class="td-icon-close-mobile"></i></a>
		            </div>
	            </div>
	            <div class="td-login-form-wrap">
	                <div class="td-login-panel-title"><span>' . __td('Welcome!', TD_THEME_NAME) . '</span>' . __td('Log into your account', TD_THEME_NAME) .'</div>
	                <div class="td_display_err"></div>
	                <div class="td-login-inputs"><input class="td-login-input" type="text" name="login_email" id="login_email" value="" required><label>' . __td('your username', TD_THEME_NAME) .'</label></div>
	                <div class="td-login-inputs"><input class="td-login-input" type="password" name="login_pass" id="login_pass" value="" required><label>' . __td('your password', TD_THEME_NAME) .'</label></div>
	                <input type="button" name="login_button" id="login_button" class="td-login-button" value="' . __td('LOG IN', TD_THEME_NAME) . '">
	                <div class="td-login-info-text"><a href="#" id="forgot-pass-link">' . __td('Forgot your password?', TD_THEME_NAME) . '</a></div>
                </div>
            </div>

            ' . $users_can_register_form . '

            <div id="td-forgot-pass-div" class="td-login-animation td-login-hide">
                <!-- close button -->
	            <div class="td-forgot-pass-close">
	                <a href="#" class="td-back-button"><i class="td-icon-read-down"></i></a>
	                <div class="td-login-title">' . __td('Password recovery', TD_THEME_NAME) . '</div>
	            </div>
	            <div class="td-login-form-wrap">
	                <div class="td-login-panel-title">' . __td('Recover your password', TD_THEME_NAME) .'</div>
	                <div class="td_display_err"></div>
	                <div class="td-login-inputs"><input class="td-login-input" type="text" name="forgot_email" id="forgot_email" value="" required><label>' . __td('your email', TD_THEME_NAME) .'</label></div>
	                <input type="button" name="forgot_button" id="forgot_button" class="wpb_button btn td-login-button" value="' . __td('Send My Pass', TD_THEME_NAME) . '">
                </div>
            </div>
';