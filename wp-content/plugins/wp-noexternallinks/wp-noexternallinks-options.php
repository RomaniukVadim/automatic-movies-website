<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');

class wp_noexternallinks_admin extends wp_noexternallinks
{
    function __construct()
    {
        $this->init_lang();
        $this->load_options();
        add_action('save_post', array($this, 'save_postdata'));
        add_action('do_meta_boxes', array($this, 'add_custom_box'), 15, 2);
        add_action('admin_menu', array($this, 'modify_menu'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        #register_deactivation_hook(__FILE__,array($this,'wp_noextrenallinks_DeActivate'));
    }

    function save_postdata($post_id)
    {
        if (!wp_verify_nonce($_REQUEST['wp_noextrenallinks_noncename'], plugin_basename(__FILE__)))
            return $post_id;

        if ('page' == $_REQUEST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }
        $mask = (int)$_REQUEST['wp_noextrenallinks_mask_links'];
        update_post_meta($post_id, 'wp_noextrenallinks_mask_links', $mask);
    }

    function add_custom_box($page, $context)
    {
        add_meta_box('wp_noextrenallinks_sectionid1', __('Link masking for this post', 'wp-noexternallinks'), array($this, 'inner_custom_box1'), 'post', 'advanced');
        add_meta_box('wp_noextrenallinks_sectionid1', __('Link masking for this post', 'wp-noexternallinks'), array($this, 'inner_custom_box1'), 'page', 'advanced');
    }

    function inner_custom_box1()
    {
        global $post;
        echo '<input type="hidden" name="wp_noextrenallinks_noncename" id="wp_noextrenallinks_noncename" value="' .
            wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        $mask = get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true);
        if ($mask === '')
            $mask = 0;
        echo '<input type="radio" name="wp_noextrenallinks_mask_links" value="0"';
        if ($mask == 0) echo ' checked';
        echo '>' . __('Use default policy from plugin settings', 'wp-noexternallinks') . '<br><input type="radio" name="wp_noextrenallinks_mask_links" value="2"';
        if ($mask == 2) echo ' checked';
        echo '>' . __('Don`t mask links', 'wp-noexternallinks');
    }

    /*
    function Activate()
    {
      #nothing now.
    }

    function DeActivate()
    {
      #here could be option uninstall. But better not.
    }
    */

    function update()
    {
        $this->options = $_REQUEST['options'];
        $this->update_options();
        echo '<div class="updated">' . __('Options updated.', 'wp-noexternallinks') . '</div>';
        $this->load_options();
    }


    function modify_menu()
    {
        add_options_page(
            'NoExternalLinks&nbsp;<img src="' . plugin_dir_url(__FILE__) . 'externallink.png">',
            'NoExternalLinks&nbsp;<img src="' . plugin_dir_url(__FILE__) . 'externallink.png">',
            'manage_options',
            __FILE__,
            array($this, 'admin_options')
        );
    }

    function get_admin_page()
    {
        return get_admin_url(null, 'options-general.php?page=wp-noexternallinks%2Fwp-noexternallinks-options.php');
    }

    function show_navi()
    {
        $page = $this->get_admin_page();
        if ($_REQUEST['action'] == 'stats') {
            ?>
            <a href="<?php echo $page ?>"
               class="button-primary"><?php _e('View options', 'wp-noexternallinks'); ?></a>
        <?php } else { ?>
            <a href="<?php echo $page; ?>&action=stats"
               class="button-primary"><?php _e('View Stats', 'wp-noexternallinks'); ?></a>
        <?php } ?>
        <a href="http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/"
           class="button-primary"><?php _e('Feedback', 'wp-noexternallinks'); ?></a>
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EE8RM4N7BSNZ6"
           class="button-primary"><?php _e('Donate', 'wp-noexternallinks'); ?></a>
        <?php
    }

    function view_stats()
    {
        global $wpdb;
        ?>
        <form method="post" action="">
        <input type="hidden" name="page" value="wp-noexternallinks%2Fwp-noexternallinks-options.php">
        <?php wp_nonce_field('update-options');
        $this->show_navi(); ?><br><br>
        <?php

        if (!$this->options['stats']) {
            _e('Statistic for plugin is disabled! Please, go to options page and enable it via checkbox "Log all outgoing clicks".', 'wp-noexternallinks');
            echo '</form>';
        } else {
            if ($_REQUEST['date1'])
                $date1 = $_REQUEST['date1'];
            else
                $date1 = date('Y-m-d');
            if ($_REQUEST['date2'])
                $date2 = $_REQUEST['date2'];
            else
                $date2 = date('Y-m-d');
            _e('View stats from', 'wp-noexternallinks');
            ?>
            <input type="text" name="date1" value="<?php echo $date1; ?>"> <?php _e('to', 'wp-noexternallinks'); ?>
            <input type="text" name="date2" value="<?php echo $date2; ?>"><input type="submit"
                                                                                 value="<?php _e('View', 'wp-noexternallinks'); ?>"
                                                                                 class="button-primary">
            </form><br>
            <style>.urlul {
                    padding: 5px 0px 0px 25px;
                }</style>
            <?php
            $sql = 'select * from ' . $wpdb->prefix . 'links_stats where `date` between %s and DATE_ADD(%s,INTERVAL 1 DAY)';
            $sql = $wpdb->prepare($sql, $date1, $date2);
            $result = $wpdb->get_results($sql, ARRAY_A);
            if (is_array($result) && sizeof($result)) {
                $out = array();
                foreach ($result as $row) {
                    $nfo = parse_url($row['url']);
                    if ($row['url'] && $nfo['host'])
                        $out[$nfo['host']][$row['url']]++;
                }
                foreach ($out as $host => $arr) {
                    echo '<br>' . $host . '<ul class="urlul">';
                    foreach ($arr as $url => $outs)
                        echo '<li><a href="' . $url . '">' . $url . '</a> (' . $outs . ')</li>';
                    echo '</ul>';
                }
            } else
                _e('No statistic for given period.', 'wp-noexternallinks');
        }

    }

    function option_page()
    {
        ?>
        <p><?php _e('That plugins allows you to mask all external links and make them internal or hidden - using PHP redirect or special link tags and attributes. Yeah, by the way - it does not change anything in the base - only replaces links on output. If you disabled this plugin and still have links masked - it is your caching plugin`s fault!', 'wp-noexternallinks'); ?></p>
        <p>
            <?php echo __('If you need to make custom modifications for plugin - you can simply extend it, according to', 'wp-noexternallinks') . ' <a href="http://jehy.ru/articles/2014/12/08/custom-parser-for-wp-noexternallinks/">' . __('this article.', 'wp-noexternallinks') . '</a>.'; ?>
        </p>
        <p>
            <?php echo __('If you need to mask links in posts`s custom field, take a look at', 'wp-noexternallinks') . ' <a href="http://jehy.ru/articles/2015/03/06/masking-links-in-custom-fields-with-wp-noexternallinks/">' . __('this article.', 'wp-noexternallinks') . '</a>.'; ?>
        </p>
        <form method="post" action="">
            <?php wp_nonce_field('wp-noexternallinks', 'update-options');
            $this->show_navi(); ?>
            <br>
            <?php echo '<h2>' . __('Global links masking settings', 'wp-noexternallinks') . '</h2>' . '(' . __('You can also disable plugin on per-post basis', 'wp-noexternallinks') . ')'; ?>
            <br><br>
            <?php
            $opt = $this->GetOptionInfo();
            echo '<h3>' . __('Choose masking type', 'wp-noexternallinks') . '</h3><p>' . __('Default masking type is via 302 redirects. Please choose one of the following mods if you do not like it:', 'wp-noexternallinks') . '</p>';
            $this->show_option_group($opt, 'type');
            echo '<h3>' . __('What to mask', 'wp-noexternallinks') . '</h3>';
            $this->show_option_group($opt, 'what');
            echo '<h3>' . __('What to exclude from masking', 'wp-noexternallinks') . '</h3>';
            $this->show_option_group($opt, 'exclude');
            echo '<h3>' . __('Common configuration', 'wp-noexternallinks') . '</h3>';
            $this->show_option_group($opt, 'common');
            echo '<h3>' . __('Link encoding', 'wp-noexternallinks') . '</h3><p>' . __('Those options are not secure enough if you want to protect your data from someone but are quite enough to make link not human-readable. Please choose one of them:', 'wp-noexternallinks') . '</p>';
            $this->show_option_group($opt, 'encode');
            echo '<h3>' . __('Configuration for javascript redirects (if enabled)', 'wp-noexternallinks') . '</h3>';
            $this->show_option_group($opt, 'java');

            ?><input type="submit" name="submit" value="<?php _e('Save Changes', 'wp-noexternallinks') ?>"
                     class="button-primary"/>
        </form>
        <?php
    }

    function show_option_group($opt, $name)
    {
        foreach ($opt as $arr) {
            if ($arr['grp'] === $name) {
                $this->show_option($arr);
                echo '<br>';
            }
        }
    }

    function show_option($arr)
    {
        if ($arr['type'] == 'chk') {
            echo '<br><input type="checkbox" name="options[' . $arr['new_name'] . ']" value="1"';
            if ($this->options[$arr['new_name']])
                echo ' checked';
            echo '>' . $arr['name'];
        } elseif ($arr['type'] == 'txt') {
            echo '<br>' . $arr['name'] . ':<br><input type="text" name="options[' . $arr['new_name'] . ']" value="' . $this->options[$arr['new_name']] . '">';
        } elseif ($arr['type'] == 'text') {
            echo '<p>' . $arr['name'] . ':</p>';
            echo '<textarea name="options[' . $arr['new_name'] . ']" class="large-text code" rows="6" cols="50">' . $this->options[$arr['new_name']] . '</textarea>';
        }
    }

    function admin_options()
    {
        echo '<div class="wrap"><h2>WP-NoExternalLinks</h2>';
        if ($_REQUEST['submit']) {
            check_admin_referer('wp-noexternallinks', 'update-options');
            $this->update();
        }
        if ($_REQUEST['action'] == 'stats')
            $this->view_stats();
        else
            $this->option_page();
        echo '</div>';
    }
}

?>