<?php
//get current logd in user data
global $current_user;
//check if admin allow registration
$users_can_register = get_option('users_can_register');

//if admin permits registration
$users_can_register_tab = '';

if ($users_can_register == 1) {
	//add the Register tab to the modal window if `Anyone can register` chec
	$users_can_register_tab = ' <span></span><a id="register-link-mob">' . __td('Join', TD_THEME_NAME) . '</a>';
}

echo '
    <div class="td-guest-wrap">
        <div class="td-menu-avatar"><div class="td-avatar-container">' . get_avatar($current_user->ID, 80) . '</div></div>
        <div class="td-menu-login"><a id="login-link-mob">' . __td('Sign in', TD_THEME_NAME) . '</a>' . $users_can_register_tab . '</div>
    </div>
';