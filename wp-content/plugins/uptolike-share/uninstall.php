<?php

if (!defined('WP_UNINSTALL_PLUGIN'))
    exit();

function uptolike_delete_plugin() {

    delete_option('my_option_name');
}

uptolike_delete_plugin();

?>

