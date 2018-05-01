<?php
/**
 * Created by ra on 5/15/2015.
 */

require_once "td_view_header.php";
?>



<div class="td-admin-wrap about-wrap">


    <div class="td-welcome-header">
        <h1>Welcome to <?php echo TD_THEME_NAME?> <div class="td-welcome-version">V <?php echo TD_THEME_VERSION?></div></h1>
        <div class="about-text">
            Thanks for using our theme, we had worked very hard to release a great product and we will do our absolute best to support this theme and fix all the issues.
        </div>
    </div>


    <?php if (!is_plugin_active('js_composer/js_composer.php')) { ?>
        <div class="td-admin-box-text td-admin-required-plugins">
            <div class="td-admin-required-plugins-wrap">
                <p><strong>Please install Visual Composer.</strong></p>
                <p>Visual Composer is a required plugin for this theme to work best.</p>
                <a class="button button-primary" href="admin.php?page=td_theme_plugins">Go to plugin installer</a>
            </div>
        </div>
    <?php } ?>

    <hr/>

    <div class="feature-section two-col">
        <div class="col">
            <h3>Fast start:</h3>
            <p>Install visual composer plugin and also install the social counter plugin if you want to add the counters on your sidebar - from our <a href="admin.php?page=td_theme_plugins">plugins panel</a></p>
            <p><a href="admin.php?page=td_theme_demos">Try our demos</a> on your testing site. Our demo system supports complete uninstalling + rollback to your original site.</p>


	        <?php if (TD_THEME_NAME == 'Newspaper') { ?>
		        <h3>Update from Newspaper 4:</h3>
		        <p>To update from version 4 please run this <a href="admin.php?page=td_theme_panel&td_page=td_view_update_newspaper_6&td_magic_token=<?php echo wp_create_nonce('td-newspaper4-import')?>" onclick="return confirm('Are you sure? Please backup your site before running the update script! \n\nWARNING: THIS IMPORT SCRIPT WILL CHANGE YOUR SIDEBARS, WIDGETS, TEMPLATES ON PAGES, TEMPLATES ON POSTS AND SHORTCODES\n\nWARNING: AFTER THE IMPORT SCRIPT RUNS IT CANNOT BE ROLLED BACK AND YOU CANNOT GO BACK TO VERSION 4 ONLY FROM A DATABASE BACKUP')">update script</a>. Note: please backup your site before updating!</p>
	        <?php } ?>
        </div>


        <div class="col">
            <img src="<?php echo get_template_directory_uri()?>/images/panel/admin-panel/logo-panel.jpg">
        </div>
    </div>


    <hr style=" border:none !important;"/>

    <h3>An easier way to make content</h3>
    <p>One of our main goals in the last year was to make the theme easier to use and more user friendly. Please let us know if you encounter any issues or if you have any feedback, we are very happy when we get your suggestions and feedback.</p>

    <div style="margin-top: 26px;">
        <div class="td-admin-box-text td-admin-box-three">
            <h2>Support forum</h2>
            <p>We offer outstanding support through our forum. To get support first you need to register  (create an account) and open a thread in the <?php echo TD_THEME_NAME?> Section.</p>
            <a class="button button-primary" href="http://forum.tagdiv.com" target="_blank">Open forum</a>
        </div>
        <div class="td-admin-box-text td-admin-box-three">
            <h2>Docs and learning</h2>
            <p>Our online documentation will give you important information about the theme. This is a exceptional resource to start discovering the theme’s true potential.</p>
            <a class="button button-primary" href="<?php echo TD_THEME_DOC_URL?>" target="_blank">Open documentation</a>
        </div>
        <div class="td-admin-box-text td-admin-box-three td-admin-box-last">
            <h2>Video tutorials</h2>
            <p>We believe that the easiest way to learn is watching a video tutorial. We have a growing library of narrated video tutorials to help you do just that.</p>
            <a class="button button-primary" href="<?php echo TD_THEME_VIDEO_TUTORIALS_URL?>" target="_blank">View tutorials</a>
        </div>
    </div>




    <!--
    <div class="td-admin-box-text">
        <p>Thank you for choosing the best theme we have ever build!</p>
		<a class="button button-primary" href="http://demo.tagdiv.com/<?php echo strtolower(TD_THEME_NAME);?>" target="_blank">View demo</a>
		<a class="button button-primary" href="http://themeforest.net/user/tagDiv" target="_blank">Our portfolio</a>
	</div>
	-->
</div>