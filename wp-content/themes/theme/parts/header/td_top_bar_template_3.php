<?php if (td_util::get_option('tds_top_bar') != 'hide_top_bar') { ?>

    <div class="top-bar-style-3">
        <?php locate_template('parts/header/top-menu.php', true); ?>
        <?php locate_template('parts/header/top-widget.php', true); ?>
    </div>

<?php }
    locate_template('parts/header/td-login-modal.php', true);
?>