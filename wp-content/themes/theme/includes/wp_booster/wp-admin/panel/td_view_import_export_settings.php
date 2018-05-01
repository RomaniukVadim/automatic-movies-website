<!-- used to validate the theme settings reset input value -->
<script type="text/javascript">
    function tdValidateReset() {
        var resetInputField = document.forms["td_panel_reset_settings"]["td_unregistered[tds_reset_theme_options]"];

        if (resetInputField.value != "reset") {
            alert('Please make sure you wrote "reset" on the input field.');

            // clear field value
            resetInputField.value = '';
            return false;
        }
        return true;
    }
</script>

<?php

$show_update_msg = 0;


// import theme settings
if(!empty($_REQUEST['action_import']) && $_REQUEST['action_import'] == 'import_theme_settings') {


	if (empty($_POST['td_magic_token']) || wp_verify_nonce($_POST['td_magic_token'], 'td-import-panel') === false) {
		echo 'Permission denied';
		die;
	}


    if (!empty($_POST['td_update_theme_options']['tds_update_theme_options'])) {
        if (update_option(TD_THEME_OPTIONS_NAME, @unserialize(@base64_decode($_POST['td_update_theme_options']['tds_update_theme_options'])))) {
            $show_update_msg = 1;
        }
    }
}


// reset theme settings
if(!empty($_REQUEST['action_reset']) && $_REQUEST['action_reset'] == 'reset_theme_settings') {

	if (empty($_POST['td_magic_token']) || wp_verify_nonce($_POST['td_magic_token'], 'td-import-panel') === false) {
		echo 'Permission denied';
		die;
	}

    if(isset($_POST['td_unregistered']['tds_reset_theme_options']) && $_POST['td_unregistered']['tds_reset_theme_options'] == 'reset') {

        // if a demo is installed remove it
        $installed_demo = td_demo_state::get_installed_demo();
        if ($installed_demo !== false){

            // remove demo content
            td_demo_media::remove();
            td_demo_content::remove();
            td_demo_category::remove();
            td_demo_menus::remove();
            td_demo_widgets::remove();

            // restore all settings to the state before a demo was loaded
            $td_demo_history = new td_demo_history();
            $td_demo_history->restore_all();

            // update status to default - no demo installed
            td_demo_state::update_state('', '');
        }

        // delete the theme settings
        if(delete_option(TD_THEME_OPTIONS_NAME)) {
            $show_update_msg = 2;
        }
    }
}
?>
<div class="td_displaying_saving"></div>
<div class="td_wrapper_saving_gifs">
    <img class="td_displaying_saving_gif" src="<?php echo get_template_directory_uri();?>/includes/wp_booster/wp-admin/images/panel/loading.gif">
    <img class="td_displaying_ok_gif" src="<?php echo get_template_directory_uri()?>/includes/wp_booster/wp-admin/images/panel/saved.gif">
</div>


<div class="wrap">

<div class="td-container-wrap">

	<div class="td-panel-main-header">
		<img src="<?php echo get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/panel-wrap/panel-logo.png'?>" alt=""/>
		<span class="td-panel-header-name"><?php echo TD_THEME_NAME . ' - Theme panel'; ?></span>
		<span class="td-panel-header-version">version: <?php echo TD_THEME_VERSION; ?></span>
	</div>


	<div id="td-container-left">
	    <div id="td-container-right">
	        <div id="td-col-left">
	            <ul class="td-panel-menu">
	                <li class="td-welcome-menu">
	                    <a data-td-is-back="yes" class="td-panel-menu-active" href="?page=td_theme_panel">
	                        <span class="td-sp-nav-icon td-ico-export"></span>
	                        IMPORT / EXPORT
	                        <span class="td-no-arrow"></span>
	                    </a>
	                </li>

	                <li>
	                    <a data-td-is-back="yes" href="?page=td_theme_panel">
	                        <span class="td-sp-nav-icon td-ico-back"></span>
	                        Back
	                        <span class="td-no-arrow"></span>
	                    </a>
	                </li>
	            </ul>
	        </div>
	        <div id="td-col-right" class="td-panel-content" style="min-height: 900px">

            <div id="td-panel-welcome" class="td-panel-active td-panel">

                <?php echo td_panel_generator::box_start('Importing / exporting theme settings'); ?>

                <!-- Import/Export theme settings -->
                <form id="td_panel_import_export_settings" name="td_panel_import_export_settings" action="?page=td_theme_panel&td_page=td_view_import_export_settings&action_import=import_theme_settings" method="post" onsubmit="return confirm('Are you sure you want to import this settings?\nIt will overwrite the one that you have now!');">
	                <input type="hidden" name="td_magic_token" value="<?php echo wp_create_nonce("td-import-panel") ?>"/>
                    <input type="hidden" name="action" value="td_ajax_update_panel">

                        <div class="td-box-row">
                            <div class="td-box-description td-box-full">
                                <span class="td-box-title">EXPORT THEME SETTINGS</span>
                                <p>
                                    This box contains all the panel options encoded as a string so you can easily copy them and move them to another server.
                                </p>
                            </div>
                            <div class="td-box-control-full">
                                <?php
                                // encode only if the value is set - else it displays some strange characters
                                $td_read_theme_settings = get_option(TD_THEME_OPTIONS_NAME);
                                if (!empty($td_read_theme_settings)) {
                                    $td_read_theme_settings = base64_encode(serialize(get_option(TD_THEME_OPTIONS_NAME)));
                                }
                                echo td_panel_generator::textarea(array(
                                    'ds' => 'td_unregistered',
                                    'option_id' => 'tds_read_theme_options',
                                    'value' => $td_read_theme_settings
                                ));
                                ?>
                            </div>
                            <div class="td-box-row-margin-bottom"></div>
                        </div>

                        <div class="td-box-row">
                            <div class="td-box-description td-box-full">
                                <span class="td-box-title">IMPORT THEME SETTINGS</span>
                                <p>Paste your theme settings string here and the theme will load them into the database</p>
                            </div>
                            <div class="td-box-control-full">
                                <?php
                                echo td_panel_generator::textarea(array(
                                    'ds' => 'td_update_theme_options',
                                    'option_id' => 'tds_update_theme_options'
                                ));
                                ?>
                            </div>
                            <div class="td-box-row-margin-bottom"></div>
                        </div>

                    <div class="td-box-row">
                        <input type="submit" class="td-big-button td-button-remove-border" name="action" value="Import theme settings">
                    </div>

                    <div class="td-box-section-separator"></div>
                </form>

                <!-- Reset theme settings -->
                <form id="td_panel_reset_settings" name="td_panel_reset_settings" action="?page=td_theme_panel&td_page=td_view_import_export_settings&action_reset=reset_theme_settings" method="post" onsubmit="return tdValidateReset();">
	                <input type="hidden" name="td_magic_token" value="<?php echo wp_create_nonce("td-import-panel") ?>"/>
                    <input type="hidden" name="action" value="td_ajax_update_panel">

                        <div class="td-box-row">
                            <div class="td-box-description td-box-full">
                                <span class="td-box-title">RESET THEME SETTINGS</span>
                                <p>
                                    To reset the theme settings enter "reset" in the following field and press the "Reset theme settings" button.
                                    <?php td_util::tooltip_html('
                                        <h3>Reset theme settings:</h3>
                                        <p>This option allows you reset the theme settings:</p>
                                        <ul>
                                            <li>If a demo is installed it\'s content will also be removed.</li>
                                            <li>The theme will return to default, as it was on it\'s first install.</li>
                                            <li>Note that the length of this process may vary (10 - 40 seconds), please wait until the reset confirmation message appears.</li>
                                        </ul>
                                    ', 'right')?>
                                </p>
                            </div>
                            <div class="td-box-control-full">
                                <?php
                                echo td_panel_generator::input(array(
                                    'ds' => 'td_unregistered',
                                    'option_id' => 'tds_reset_theme_options',
                                    'placeholder' => 'reset',
                                ));
                                ?>
                            </div>
                            <div class="td-box-row-margin-bottom"></div>
                        </div>

                    <div class="td-box-row">
                        <input type="submit" class="td-big-button td-button-remove-border" name="action" value="Reset theme settings">
                    </div>
                </form>

                <?php echo td_panel_generator::box_end();?>
            </div>


	        </div>
	    </div>
	</div>

	<div class="td-clear"></div>

</div>

<div class="td-clear"></div>

</div>
<?php if($show_update_msg == 1){?><script type="text/javascript">alert('Import is done!');</script><?php }?>
<?php if($show_update_msg == 2){?><script type="text/javascript">alert('Theme settings reset completed!');</script><?php }?>
<br><br><br><br><br><br><br>
