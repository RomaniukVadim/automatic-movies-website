<!--
Header style 7
-->

<div class="td-header-wrap td-header-style-7">
    <?php if (td_util::get_option('tds_top_bar') != 'hide_top_bar') { ?>
    <div class="td-header-top-menu-full">
        <div class="td-container td-header-row td-header-top-menu">
            <?php td_api_top_bar_template::_helper_show_top_bar() ?>
        </div>
    </div>
    <?php } ?>

    <div class="td-header-menu-wrap-full">
        <div class="td-header-menu-wrap td-header-gradient">
            <div class="td-container td-header-row td-header-main-menu">
                <div class="td-header-sp-logo">
                    <?php locate_template('parts/header/logo-h1.php', true);?>
                </div>
                    <?php locate_template('parts/header/header-menu.php', true);?>
            </div>
        </div>
    </div>

    <div class="td-banner-wrap-full">
        <div class="td-container-header td-header-row td-header-header">
            <div class="td-header-sp-recs">
                <?php locate_template('parts/header/ads.php', true); ?>
            </div>
        </div>
    </div>

</div>