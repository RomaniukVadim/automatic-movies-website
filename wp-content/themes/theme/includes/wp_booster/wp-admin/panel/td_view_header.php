<?php

global $submenu;

if (isset($submenu['td_theme_welcome'])) {
    $td_welcome_menu_items = $submenu['td_theme_welcome'];
}

if (!empty($td_welcome_menu_items) && is_array($td_welcome_menu_items)) {
    ?>
    <div class="wrap about-wrap td-wp-admin-header ">
        <h2 class="nav-tab-wrapper">

            <?php
                foreach ($td_welcome_menu_items as $td_welcome_menu_item) {
                    ?>
                        <a href="admin.php?page=<?php echo $td_welcome_menu_item[2]?>" class="nav-tab <?php if(isset($_GET['page']) and $_GET['page'] == $td_welcome_menu_item[2]) { echo 'nav-tab-active'; }?> "><?php echo $td_welcome_menu_item[0] ?></a>
                    <?php
                }
            ?>
        </h2>
    </div>
    <?php
}

?>


