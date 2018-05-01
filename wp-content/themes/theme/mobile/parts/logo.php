<?php

// read the mobile logo + retina logo
$td_mobile_customLogo = td_util::get_option('tds_logo_menu_upload');
$td_mobile_customLogoR = td_util::get_option('tds_logo_menu_upload_r');

// read the header logo + retina logo
$td_header_logo = td_util::get_option('tds_logo_upload');
$td_header_logoR = td_util::get_option('tds_logo_upload_r');

$td_logo_alt = td_util::get_option('tds_logo_alt');
$td_logo_title = td_util::get_option('tds_logo_title');

if (!empty($td_logo_title)) {
    $td_logo_title = ' title="' . $td_logo_title . '"';
}


if (!empty($td_mobile_customLogo)) {

    // mobile logo here
    if (!empty($td_mobile_customLogoR)) {
        //if retina
        ?>

        <a class="td-mobile-logo"
           href="<?php echo esc_url(home_url('/')); ?>">
            <img class="td-retina-data" data-retina="<?php echo esc_attr($td_mobile_customLogoR) ?>"
                 src="<?php echo $td_mobile_customLogo ?>"
                 alt="<?php echo $td_logo_alt ?>"<?php echo $td_logo_title ?>/>
        </a>
    <?php
    } else {
        //not retina
        if (!empty($td_mobile_customLogo)) {
            ?>
            <a class="td-mobile-logo"
               href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo $td_mobile_customLogo ?>"
                                                                 alt="<?php echo $td_logo_alt ?>"<?php echo $td_logo_title ?>/></a>
        <?php
        }
    }

} else {

    // header logo here
    if (!empty($td_header_logoR)) {
        //if retina
        ?>
        <a class="td-header-logo"
           href="<?php echo esc_url(home_url('/')); ?>">
            <img class="td-retina-data" data-retina="<?php echo esc_attr($td_header_logoR) ?>"
                 src="<?php echo $td_header_logo ?>" alt="<?php echo $td_logo_alt ?>"<?php echo $td_logo_title ?>/>
        </a>
    <?php
    } else {
        //not retina
        if (!empty($td_header_logo)) {
            ?>

            <a class="td-header-logo"
               href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo $td_header_logo ?>"
                                                                 alt="<?php echo $td_logo_alt ?>"<?php echo $td_logo_title ?>/></a>
        <?php
        }
    }
}