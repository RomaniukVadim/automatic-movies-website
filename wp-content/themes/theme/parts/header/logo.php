<?php
/**
 * Created by PhpStorm.
 * User: ra
 * Date: 4/22/14
 * Time: 10:08 AM
 */

//read the logo + retina logo
$td_customLogo = td_util::get_option('tds_logo_upload');
$td_customLogoR = td_util::get_option('tds_logo_upload_r');

$td_logo_alt = td_util::get_option('tds_logo_alt');
$td_logo_title = td_util::get_option('tds_logo_title');

if (!empty($td_logo_title)) {
    $td_logo_title = ' title="' . $td_logo_title . '"';
}

if (!empty($td_customLogoR)) { //if retina
    ?>
        <a class="td-main-logo" href="<?php echo esc_url(home_url( '/' )); ?>">
            <img class="td-retina-data" data-retina="<?php echo esc_attr($td_customLogoR) ?>" src="<?php echo $td_customLogo?>" alt="<?php echo $td_logo_alt ?>"<?php echo $td_logo_title ?>/>
        </a>
    <?php
} else { //not retina
    if (!empty($td_customLogo)) {
    ?>
        <a class="td-main-logo" href="<?php echo esc_url(home_url( '/' )); ?>">
            <img src="<?php echo $td_customLogo?>" alt="<?php echo $td_logo_alt ?>"<?php echo $td_logo_title ?>/>
        </a>
    <?php
    }
}