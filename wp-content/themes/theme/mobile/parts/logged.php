<?php
//get current logd in user data
global $current_user;

echo '
	<div class="td-logged-wrap">
		<div class="td-menu-avatar"><div class="td-avatar-container">' .	get_avatar($current_user->ID, 80) .	'</div></div>
		<div class="td-menu-username"><a href="' . get_author_posts_url($current_user->ID) . '" class="td_user_logd_in">' . $current_user->display_name . '</a></div>
		<div class="td-menu-logout"><a href="' . wp_logout_url(home_url( '/' )) . '">' . __td('Logout', TD_THEME_NAME) . '</a></div>
	</div>
';