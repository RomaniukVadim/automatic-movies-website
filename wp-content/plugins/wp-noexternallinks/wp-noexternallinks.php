<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');
#@error_reporting(E_ALL ^ E_NOTICE);#disable extra error reporting for shitty servers

/*
Plugin Name: WP No External Links
Plugin URI: http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/
Description: This plugin will allow you to mask all external links to internal, or to hide them. Your own posts, comments pages, authors pages... To set up, visit <a href="options-general.php?page=wp-noexternallinks/wp-noexternallinks-options.php">configuration panel</a>.
Version: 3.5.17
Author: Jehy
Author URI: http://jehy.ru/articles/
Update Server: http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/
Min WP Version: 2.6
Max WP Version: 4.5.3
*/

/*  Copyright 2012  Jehy  (email : fate@jehy.ru)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class wp_noexternallinks
{
    var $options;/*all plugin options*/
    function init_lang()
    {
        $plugin_dir = basename(dirname(__FILE__));
        load_plugin_textdomain('wp-noexternallinks', false, $plugin_dir . '/lang');
    }

    function activate()
    {
        global $wpdb;
        $sql = 'CREATE TABLE ' . $wpdb->prefix . 'links_stats(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,`url` VARCHAR(255), `date` DATETIME, PRIMARY KEY (`id`))';
        $res = $wpdb->query($sql);
    }

    function update_options()
    {
        $opt = $this->GetOptionInfo();
        foreach ($opt as $key => $arr) {
            $name = $arr['new_name'];
            if (!isset($this->options[$name]))
                $this->options[$name] = '0';//for damn checkboxes
        }

        foreach ($this->options as $i => $val)
            $this->options[$i] = stripslashes($val);
        $r = update_option('wp_noexternallinks', $this->options);
        if (!$r) {
            if (serialize($this->options) != serialize(get_option('wp_noexternallinks'))) {
                init_lang();
                echo '<div class="error">' . __('Failed to update options!', 'wp-noexternallinks') . '</div>';
            }
            /*else echo 'nothing changed ;_;';*/
        }
    }

    function GetOptionInfo()
    {
        return array(
            array('old_name' => 'noexternallinks_mask_mine', 'new_name' => 'mask_mine', 'def_value' => 1, 'type' => 'chk', 'name' => __('Mask links in posts and pages', 'wp-noexternallinks'), 'grp' => 'what'),
            array('old_name' => 'noexternallinks_mask_comment', 'new_name' => 'mask_comment', 'def_value' => 1, 'type' => 'chk', 'name' => __('Mask links in comments', 'wp-noexternallinks'), 'grp' => 'what'),
            array('old_name' => 'noexternallinks_mask_author', 'new_name' => 'mask_author', 'def_value' => 1, 'type' => 'chk', 'name' => __('Mask comments authors`s homepage links', 'wp-noexternallinks'), 'grp' => 'what'),
            array('new_name' => 'mask_rss', 'def_value' => 0, 'type' => 'chk', 'name' => __('Mask links in your RSS post content', 'wp-noexternallinks') . ' ' . __('(may result in invalid RSS if used with some masking options)', 'wp-noexternallinks'), 'grp' => 'what'),
            array('new_name' => 'mask_rss_comment', 'def_value' => 0, 'type' => 'chk', 'name' => __('Mask links in RSS comments', 'wp-noexternallinks') . ' ' . __('(may result in invalid RSS if used with some masking options)', 'wp-noexternallinks'), 'grp' => 'what'),
            array('old_name' => 'noexternallinks_add_nofollow', 'new_name' => 'add_nofollow', 'def_value' => 1, 'type' => 'chk', 'name' => __('Add <b>rel=nofollow</b> for masked links (for google)', 'wp-noexternallinks'), 'grp' => 'common'),
            array('old_name' => 'noexternallinks_add_blank', 'new_name' => 'add_blank', 'def_value' => 1, 'type' => 'chk', 'name' => __('Add <b>target="blank"</b> for all links to other sites (links will open in new window)', 'wp-noexternallinks'), 'grp' => 'common'),
            array('old_name' => 'noexternallinks_put_noindex', 'new_name' => 'put_noindex', 'def_value' => 0, 'type' => 'chk', 'name' => __('Surround masked links with <b>&lt;noindex&gt;link&lt;/noindex&gt;</b> tag (for yandex search engine)', 'wp-noexternallinks'), 'grp' => 'common'),
            array('new_name' => 'put_noindex_comment', 'def_value' => 0, 'type' => 'chk', 'name' => __('Surround masked links with comment <b>&lt;!--noindex--&gt;link&lt;!--/noindex--&gt;</b> (for yandex search engine, better then noindex tag because valid)', 'wp-noexternallinks'), 'grp' => 'common'),
            array('old_name' => 'noexternallinks_disable_mask_links', 'new_name' => 'disable_mask_links', 'def_value' => 0, 'type' => 'chk', 'name' => __('No redirect', 'wp-noexternallinks'), 'grp' => 'type'),
            array('old_name' => 'noexternallinks_link_separator', 'new_name' => 'LINK_SEP', 'def_value' => 'goto', 'type' => 'txt', 'name' => __('Link separator for redirects (default="goto")', 'wp-noexternallinks'), 'grp' => 'common'),
            array('old_name' => 'noexternallinks_exclude_links', 'new_name' => 'exclude_links', 'def_value' => '', 'type' => 'text', 'name' => __('Exclude URLs that you don`t want to mask (all urls, beginning with those, won`t be masked). Put one adress on each line, including protocol prefix (for example,', 'wp-noexternallinks') . ' "<b>http://</b>jehy.ru" ' . __('or', 'wp-noexternallinks') . ' <b>https://</b>google.com ' . __('or', 'wp-noexternallinks') . ' <b>ftp://</b>microsoft.com). ' . __('Skype, javascript and mail links are excluded by default. To exclude full protocol, just add line with it`s prefix - for example,', 'wp-noexternallinks') . ' "<b>ftp://</b>"', 'grp' => 'exclude'),
            array('new_name' => 'fullmask', 'def_value' => 0, 'type' => 'chk', 'name' => __('Mask ALL links in document (can slow down your blog and conflict with some cache and other plugins. Not recommended).', 'wp-noexternallinks'), 'grp' => 'what'),
            array('new_name' => 'stats', 'def_value' => 0, 'type' => 'chk', 'name' => __('Log all outgoing clicks.', 'wp-noexternallinks'), 'grp' => 'common'),
            array('new_name' => 'keep_stats', 'def_value' => 30, 'type' => 'txt', 'name' => __('Days to keep clicks stats', 'wp-noexternallinks'), 'grp' => 'common'),
            array('new_name' => 'no302', 'def_value' => 0, 'type' => 'chk', 'name' => __('Use javascript redirect', 'wp-noexternallinks'), 'grp' => 'type'),
            array('new_name' => 'redtime', 'def_value' => 3, 'type' => 'txt', 'name' => __('Redirect time (seconds)', 'wp-noexternallinks'), 'grp' => 'java'),
            array('new_name' => 'redtxt', 'def_value' => 'This page demonstrates link redirect with "WP-NoExternalLinks" plugin. You will be redirected in 3 seconds. Otherwise, please click on <a href="LINKURL">this link</a>.', 'type' => 'text', 'name' => __('Custom redirect text. Use word "LINKURL" where you want to use redirect url. For example, <b>CLICK &lt;a href="LINKURL"&gt;HERE NOW&lt;/a&gt;</b>', 'wp-noexternallinks'), 'grp' => 'java'),
            array('new_name' => 'noforauth', 'def_value' => 0, 'type' => 'chk', 'name' => __('Do not mask links when registered users visit site', 'wp-noexternallinks'), 'grp' => 'exclude'),
            array('new_name' => 'maskurl', 'def_value' => 0, 'type' => 'chk', 'name' => __('Mask url with special numeric code. Be careful, this option may slow down your blog.', 'wp-noexternallinks'), 'grp' => 'encode'),
            array('new_name' => 'remove_links', 'def_value' => 0, 'type' => 'chk', 'name' => __('Completely remove links from your posts. Someone needed it...', 'wp-noexternallinks'), 'grp' => 'common'),
            array('new_name' => 'link2text', 'def_value' => 0, 'type' => 'chk', 'name' => __('Turn all links into text. For perverts.', 'wp-noexternallinks'), 'grp' => 'common'),
            array('new_name' => 'base64', 'def_value' => 0, 'type' => 'chk', 'name' => __('Use base64 encoding for links.', 'wp-noexternallinks'), 'grp' => 'encode'),
            array('new_name' => 'debug', 'def_value' => 0, 'type' => 'chk', 'name' => __('Debug mode (Adds comments lines like "&lt;!--wp-noexternallinks debug: some info--&gt;" to output. For testing only!)', 'wp-noexternallinks'), 'grp' => 'common'),
            array('new_name' => 'restrict_referer', 'def_value' => 1, 'type' => 'chk', 'name' => __('Check for document referer and restrict redirect if it is not your own web site. Useful against spoofing attacks. User will be redirected to main page of your web site.', 'wp-noexternallinks'), 'grp' => 'common'),
            array('new_name' => 'dont_mask_admin_follow', 'def_value' => 0, 'type' => 'chk', 'name' => __('Do not mask links which have <b>rel="follow"</b> atribute and are posted by admin', 'wp-noexternallinks'), 'grp' => 'exclude'),
        );
    }

    function load_options()
    {
        global $wpdb;
        $opt = $this->GetOptionInfo();
        $update = false;
        $this->options = get_option('wp_noexternallinks');
        if (!$this->options)
            $this->options = array();
        /*check if options are fine*/
        foreach ($opt as $key => $arr) {
            $name = $arr['new_name'];
            if (!isset($this->options[$name]) && $arr['def_value'])/* no option value, but it should be*/ {
                /*try to get old version*/
                if ($arr['old_name']) {
                    $val = get_option($arr['old_name'], 'omg');
                    /*set default value. we can't use default false return because user value could be set to false*/
                    if ($val === 'omg')
                        $val = $arr['def_value'];
                } else
                    $val = $arr['def_value'];
                $this->options[$name] = $val;
                $update = true;
            }
        }


        if ($update)/*upgrade or just some kind of shit*/ {
            /*if we're going back from old version - let's check for excludes...*/
            if (!$this->options['exclude_links']) {
                $val = get_option('noexternallinks_exclude_links');
                if ($val)
                    $this->options['exclude_links'] = $val;
            }
            $this->update_options();
        }
        /*add values to exclude*/
        $exclude_links = array();
        $site = get_option('home');
        if (!$site)
            $site = get_option('siteurl');
        $this->options['site'] = $site;
        $site = str_replace(array("http://", "https://"), '', $site);
        $p = strpos($site, '/');
        if ($p !== FALSE)
            $site = substr($site, 0, $p);/*site root is excluded from masking, not only blog url*/
        $exclude_links[] = "http://" . $site;
        $exclude_links[] = "https://" . $site;
        $exclude_links[] = 'javascript';
        $exclude_links[] = 'mailto';
        $exclude_links[] = 'skype';
        $exclude_links[] = '/';/* for relative links*/
        $exclude_links[] = '#';/*for internal links*/

        $a = @explode("\n", $this->options['exclude_links']);
        for ($i = 0; $i < sizeof($a); $i++)
            $a[$i] = trim($a[$i]);
        $this->options['exclude_links_'] = @array_merge($exclude_links, $a);

        /*statistic*/
        if ($this->options['stats']) {
            $flush = get_option('wp_noexternallinks_flush');
            if (!$flush || $flush < time() - 3600 * 24)/*flush every 24 hours*/ {
                $sql = 'delete from ' . $wpdb->prefix . 'links_stats where `date`<DATE_SUB(curdate(), INTERVAL %d DAY)';
                $wpdb->query($wpdb->prepare($sql, $this->options['keep_stats']));
                update_option('wp_noexternallinks_flush', time());
            }
        }
    }
}


$upload_dir = wp_upload_dir();
if (is_admin()) {
    include_once(plugin_dir_path(__FILE__) . 'wp-noexternallinks-options.php');
    new wp_noexternallinks_admin();
} elseif (file_exists($upload_dir['basedir'] . '/custom-parser.php')) {
    include_once($upload_dir['basedir'] . '/custom-parser.php');
    if (class_exists('custom_parser'))
        new custom_parser();
    else
        echo '<div class="error">' . __('Custom parser file found but <b>custom_parser</b> class not defined!', 'wp-noexternallinks') . '</div>';
} else {
    include_once(plugin_dir_path(__FILE__) . 'wp-noexternallinks-parser.php');
    new wp_noexternallinks_parser();
}

?>