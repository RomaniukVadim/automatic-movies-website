<!-- LOGIN MODAL -->
<?php
//check if admin allow registration
$users_can_register = get_option('users_can_register');

//if admin permits registration
$users_can_register_tab = '';
$users_can_register_form = '';

if($users_can_register == 1){

    //add the Register tab to the modal window if `Anyone can register` chec
    $users_can_register_tab = '<li><a id="register-link">' . __td('REGISTER', TD_THEME_NAME) . '</a></li>';

    $users_can_register_form = '
                        <div id="td-register-div" class="td-display-none">
                            <div class="td-login-panel-title">' . __td('Register for an account', TD_THEME_NAME) .'</div>
                            <input class="td-login-input" type="text" name="register_email" id="register_email" placeholder="' . __td('your email', TD_THEME_NAME) .'" value="" required>
                            <input class="td-login-input" type="text" name="register_user" id="register_user" placeholder="' . __td('your username', TD_THEME_NAME) .'" value="" required>
                            <input type="button" name="register_button" id="register_button" class="wpb_button btn td-login-button" value="' . __td('Register', TD_THEME_NAME) . '">
                             <div class="td-login-info-text">' . __td('A password will be e-mailed to you.', TD_THEME_NAME) . '</div>
                        </div>';
}

echo '
                <div  id="login-form" class="white-popup-block mfp-hide mfp-with-anim">
                    <ul class="td-login-tabs">
                        <li><a id="login-link" class="td_login_tab_focus">' . __td('LOG IN', TD_THEME_NAME) . '</a></li>' . $users_can_register_tab . '
                    </ul>



                    <div class="td-login-wrap">
                        <div class="td_display_err"></div>

                        <div id="td-login-div" class="">
                            <div class="td-login-panel-title">' . __td('Welcome! Log into your account', TD_THEME_NAME) .'</div>
                            <input class="td-login-input" type="text" name="login_email" id="login_email" placeholder="' . __td('your username', TD_THEME_NAME) .'" value="" required>
                            <input class="td-login-input" type="password" name="login_pass" id="login_pass" value="" placeholder="' . __td('your password', TD_THEME_NAME) .'" required>
                            <input type="button" name="login_button" id="login_button" class="wpb_button btn td-login-button" value="' . __td('Log In', TD_THEME_NAME) . '">


                            <div class="td-login-info-text"><a href="#" id="forgot-pass-link">' . __td('Forgot your password?', TD_THEME_NAME) . '</a></div>


                        </div>

                        ' . $users_can_register_form . '

                         <div id="td-forgot-pass-div" class="td-display-none">
                            <div class="td-login-panel-title">' . __td('Recover your password', TD_THEME_NAME) .'</div>
                            <input class="td-login-input" type="text" name="forgot_email" id="forgot_email" placeholder="' . __td('your email', TD_THEME_NAME) .'" value="" required>
                            <input type="button" name="forgot_button" id="forgot_button" class="wpb_button btn td-login-button" value="' . __td('Send My Pass', TD_THEME_NAME) . '">
                        </div>




                    </div>
                </div>
                ';
?>