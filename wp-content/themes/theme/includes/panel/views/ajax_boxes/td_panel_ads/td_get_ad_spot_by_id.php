<?php

$ad_spot_id = td_util::get_http_post_val('ad_spot_id');


?>

<!-- ad box code -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">YOUR AD CODE</span>
        <p>Paste your ad code here. Google adsense will be made responsive automatically. <br><br> To add non adsense responsive ads, <br> <a target="_blank" href="http://forum.tagdiv.com/using-other-ads/">click here</a></p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::textarea(array(
            'ds' => 'td_ads',
            'item_id' => $ad_spot_id,
            'option_id' => 'ad_code',
        ));
        ?>
    </div>
</div>


<div class="td-box-row">
    <div class="td-box-description td-box-full">
        <span class="td-box-title">Advance usage:</span>
        <p>If you leave the AdSense size boxes on Auto, the theme will automatically resize the <strong>google ads</strong>. For more info follow this <a href="http://forum.tagdiv.com/header-ad/" target="_blank">link</a></p>
    </div>
    <div class="td-box-row-margin-bottom"></div>
</div>


<!-- disable ad on monitor -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title td-title-on-row">DISABLE ON DESKTOP</span>
        <p></p>
    </div>
    <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => $ad_spot_id,
                'option_id' => 'disable_m',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => $ad_spot_id,
                        'option_id' => 'm_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

    </div>
</div>


<!-- disable ad on tablet landscape -->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title td-title-on-row">DISABLE ON TABLET LANDSCAPE</span>
		<p></p>
	</div>
	<div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
	            'ds' => 'td_ads',
	            'item_id' => $ad_spot_id,
	            'option_id' => 'disable_tl',
	            'true_value' => 'yes',
	            'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
	                    'ds' => 'td_ads',
	                    'item_id' => $ad_spot_id,
	                    'option_id' => 'tl_size',
	                    'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

	</div>
</div>


<!-- disable ad on tablet portrait -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title td-title-on-row">DISABLE ON TABLET PORTRAIT</span>
        <p></p>
    </div>
    <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => $ad_spot_id,
                'option_id' => 'disable_tp',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => $ad_spot_id,
                        'option_id' => 'tp_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>

    </div>
</div>


<!-- disable ad on phones -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">DISABLE ON PHONE</span>
        <p></p>
    </div>
    <div class="td-box-control-full">
            <span>
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_ads',
                'item_id' => $ad_spot_id,
                'option_id' => 'disable_p',
                'true_value' => 'yes',
                'false_value' => ''
            ));
            ?>
            </span>
            <span class="td-content-float-right td_float_clear_both td-content-padding-right-40">
                <span class="td-content-padding-right-40 td-adsense-size">AdSense size: </span>
                <span class="td-content-float-right">
                    <?php
                    echo td_panel_generator::dropdown(array(
                        'ds' => 'td_ads',
                        'item_id' => $ad_spot_id,
                        'option_id' => 'p_size',
                        'values' => td_panel_generator::$google_ad_sizes
                    ));
                    ?>
            </span>
    </div>
</div>