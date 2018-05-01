<!--
Header style 4
-->

<div class="td-header-wrap td-header-style-4">

    <div class="td-header-top-menu-full">
        <div class="td-container td-header-row td-header-top-menu">
            <?php td_api_top_bar_template::_helper_show_top_bar() ?>
        </div>
    </div>

    <div class="td-banner-wrap-full">
        <div class="td-header-container td-header-row td-header-header">
            <div class="td-header-sp-recs">
                <?php locate_template('parts/header/ads.php', true); ?>
            </div>
        </div>
    </div>

    <div class="td-header-menu-wrap-full">
        <div class="td-header-menu-wrap">
            <div class="td-container td-header-row td-header-main-menu black-menu">
                <?php locate_template('parts/header/header-menu-h1.php', true);?>
            </div>
        </div>
    </div>

</div>