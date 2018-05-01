<?php
/**
 * Created by PhpStorm.
 * User: ra
 * Date: 4/22/14
 * Time: 10:07 AM
 */

//check to see if we show the socials from our theme or from wordpress
if(td_util::get_option('td_social_networks_show') == 'show') { ?>
<div class="td-header-sp-top-widget">
    <?php

        //get the socials that are set by user
        $td_get_social_network = td_util::get_option('td_social_networks');

        if(!empty($td_get_social_network)) {
            foreach($td_get_social_network as $social_id => $social_link) {
                if(!empty($social_link)) {
                   echo td_social_icons::get_icon($social_link, $social_id, true);
                }
            }
        }
    ?>
</div>
<?php
}