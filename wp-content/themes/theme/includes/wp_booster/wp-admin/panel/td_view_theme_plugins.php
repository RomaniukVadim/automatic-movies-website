<?php
/**
 * Created by ra on 5/15/2015.
 */

if (current_user_can( 'activate_plugins' )) {
    // deactivate a plugin from tgm
    if (isset($_GET['td_deactivate_plugin_slug'])) {

	    if (empty($_GET['td_magic_token']) || wp_verify_nonce($_GET['td_magic_token'], 'td-panel-plugins') === false ) {
		    echo 'Permission denied';
		    die;
	    }

        $td_deactivate_plugin_slug = $_GET['td_deactivate_plugin_slug'];
        if (!empty($td_deactivate_plugin_slug)) {
            $plugins = TGM_Plugin_Activation::$instance->plugins;
            foreach ($plugins as $plugin) {
                if ($plugin['slug'] == $td_deactivate_plugin_slug) {
                    deactivate_plugins($plugin['file_path']);
                    ?>
                    <script type="text/javascript">
                        window.location = "admin.php?page=td_theme_plugins";
                    </script>
                    <?php
                    break;
                }
            }
        }
    }

    // Activate a plugin
    if (isset($_GET['td_activate_plugin_slug'])) {

	    if (empty($_GET['td_magic_token']) || wp_verify_nonce($_GET['td_magic_token'], 'td-panel-plugins') === false) {
		    echo 'Permission denied';
		    die;
	    }


        $td_activate_plugin_slug = $_GET['td_activate_plugin_slug'];
        if (!empty($td_activate_plugin_slug)) {
            $plugins = TGM_Plugin_Activation::$instance->plugins;

            foreach ($plugins as $plugin) {
                if ($plugin['slug'] == $td_activate_plugin_slug) {
                    activate_plugins($plugin['file_path']);
                    ?>
                    <script type="text/javascript">
                        window.location = "admin.php?page=td_theme_plugins";
                    </script>
                    <?php
                    break;
                }
            }
        }
    }
}



require_once "td_view_header.php";


//print_r(get_plugins());





?>



<div class="td-admin-wrap about-wrap theme-browser td-admin-plugins">
    <h1>Install premium plugins</h1>
    <div class="about-text">
        <p>
            Install the included plugins with ease using this panel. All the plugins are well tested to work with the theme and we keep them up to date.
            The themes comes packed with the following premium plugins:
        </p>
    </div>


   <div class="td-admin-columns">


<?php





$wp_plugin_list = get_plugins();


    //asort($theme_plugins);

	$td_tgm_theme_plugins = TGM_Plugin_Activation::$instance->plugins;

	$td_tgm_theme_plugins = array_merge($td_tgm_theme_plugins, td_global::$theme_plugins_for_info_list);


    foreach ($td_tgm_theme_plugins as $td_tgm_theme_plugin) {

        $tmp_class = 'td-plugin-not-installed';
        $required_label = $td_tgm_theme_plugin['required_label'];



	    if (isset($td_tgm_theme_plugin['file_path'])) {
		    // file_path key is missing from elements that come from td_global::$theme_plugins_for_info_list
		    if (is_plugin_active( $td_tgm_theme_plugin['file_path'])) {
			    $tmp_class = 'td-plugin-active';
			    $required_label = 'active';
		    }
		    else if (isset($wp_plugin_list[$td_tgm_theme_plugin['file_path']])) {
			    $tmp_class = 'td-plugin-inactive';
		    }
	    } else {
			// no install - usually plugins from td_global::$theme_plugins_for_info_list
		    $tmp_class = 'td-plugin-no-install';
	    }



        //echo '<br>';
        //echo $theme_plugin['file_path'] . ' ' . is_plugin_inactive( $theme_plugin['file_path'] ) . '<br>';

        //print_r(is_plugin_inactive( $theme_plugin['file_path'] ));

        ?>

        <div class="td-wp-admin-plugin theme <?php echo $tmp_class ?>">

            <!-- Import content -->
            <div class="theme-screenshot">
                <span class="td-plugin-required td-<?php echo $required_label; ?>"><?php echo $required_label; ?></span>
                <img class="td-demo-thumb" src="<?php echo $td_tgm_theme_plugin['img'] ?>"/>
            </div>

            <div class="td-admin-title">
                <div class="td-progress-bar-wrap"><div class="td-progress-bar"></div></div>
                <h3 class="theme-name"><?php echo $td_tgm_theme_plugin['name'] ?></h3>
            </div>

            <div class="td-admin-checkbox td-small-checkbox">
                <p><?php echo $td_tgm_theme_plugin['text'] ?></p>
            </div>

            <div class="theme-actions">
                <a class="button button-primary td-button-install-plugin" href="<?php
                echo esc_url( wp_nonce_url(
                    add_query_arg(
                        array(
                            'page'		  	=> urlencode(TGM_Plugin_Activation::$instance->menu),
                            'plugin'		=> urlencode($td_tgm_theme_plugin['slug']),
                            'plugin_name'   => urlencode($td_tgm_theme_plugin['name']),
                            'plugin_source' => urlencode($td_tgm_theme_plugin['source']),
                            'tgmpa-install' => 'install-plugin',
                            'return_url' => 'td_theme_plugins'
                        ),
                        admin_url('themes.php')
                    ),
                    'tgmpa-install'
                ));
                ?>">Install</a>
                <a class="button button-secondary td-button-uninstall-plugin" href="<?php
                echo esc_url(
                    add_query_arg(
                        array(
                            'page'		  	            => urlencode('td_theme_plugins'),
                            'td_deactivate_plugin_slug'	=> urlencode($td_tgm_theme_plugin['slug']),
	                        'td_magic_token' => wp_create_nonce('td-panel-plugins')
                        ),
                        admin_url('admin.php')
                    ));
                ?>"">Deactivate</a>

                <a class="button button-primary td-button-activate-plugin" href="<?php
                echo esc_url(
                    add_query_arg(
                        array(
                            'page'		  	            => urlencode('td_theme_plugins'),
                            'td_activate_plugin_slug'	=> urlencode($td_tgm_theme_plugin['slug']),
                            'td_magic_token' => wp_create_nonce('td-panel-plugins')
                        ),
                        admin_url('admin.php')
                    ));
                ?>"">Activate</a>
            </div>
        </div>






        <?php
    }
?>

    </div>
    <hr style="clear:left"/>
    <h3>Tested Plugins:</h3>
    <div class="about-text">
        <p>With each theme release we provide a list of fully suported plugins. In order to make the plugins look and work better, the theme may add custom stylesheets and hook custom code to them.
            We manually inspect each plugin periodically. If we missed something, feel free to contact us!</p>
    </div>

    <div class="td-supported-plugin-list">
        <div class="td-supported-plugin">WP Super Cache <span> - caching plugin</span></div>
        <div class="td-supported-plugin">Contact form 7 <span>- used to make contact forms</span></div>
        <div class="td-supported-plugin">bbPress <span>- forum plugin</span></div>
        <div class="td-supported-plugin">BuddyPress<span>- social network plugin</span></div>
        <div class="td-supported-plugin">Font Awesome 4 Menus<span>- icon pack, supported in the theme menus</span></div>
        <div class="td-supported-plugin">Jetpack  <span>- plugin with lots of features *it may slow down your site</span></div>
        <div class="td-supported-plugin">WooCommerce <span>- eCommerce solution</span></div>
        <div class="td-supported-plugin">WordPress SEO <span> - SEO plugin</span></div>
        <div class="td-supported-plugin">Wp User Avatar <span> - Change users avatars</span></div>
    </div>



</div>
