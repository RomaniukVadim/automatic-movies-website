<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');


class wp_noexternallinks_parser extends wp_noexternallinks
{
    var $debug_log = array();

    function output_debug()
    {
        echo "\n<!--wp-noexternallinks debug:\n" . implode("\n\n", $this->debug_log) . "\n-->";
    }

    function debug_info($info, $return = 0)
    {
        if ($this->options['debug']) {
            $t = "\n<!--wp-noexternallinks debug:\n" . $info . "\n-->";
            $this->debug_log[] = $info;
            if ($return)
                return $t;
        }
        return '';
    }

    function check_exclusions($matches)
    {
        if ($r = $this->check_follow($matches))
            return $r;
        if ($r = $this->check_excl_list($matches))
            return $r;
        return false;
    }

    function check_excl_list($matches)
    {
        #checking for entry in exclusion list

        $check_allowed = $matches[2];

        $this->debug_info('Checking link "' . $check_allowed . '" VS exclusion list {' . var_export($this->options['exclude_links_'], 1) . '}');
        foreach ($this->options['exclude_links_'] as $val)
            if (stripos($check_allowed, $val) === 0) {
                $this->debug_info('In exclusion list (' . $val . '), not masking...');
                return $matches[0];
            }
        $this->debug_info('Not in exclusion list, masking...');
        return false;
    }

    function check_follow($matches)
    {
        #support of "meta=follow" option for admins. disabled by default to minify processing.
        if (!$this->options['dont_mask_admin_follow'])
            return false;
        $id = array(get_comment_ID(), get_the_ID());//it is either page or post
        if ($id[0])
            $this->debug_info('It is a comment. id ' . $id[0]);
        elseif ($id[1])
            $this->debug_info('It is a page. id ' . $id[1]);
        $author = false;
        if ($id[0])
            $author = get_comment_author($id[0]);
        else if ($id[1])
            $author = get_the_author_meta('ID');
        if (!$author)
            $this->debug_info('it is neither post or page, applying usual rules');
        elseif (user_can($author, 'manage_options') && (stripos($matches[0], 'rel="follow"') !== FALSE || stripos($matches[0], "rel='follow'") !== FALSE)) {
            $this->debug_info('This link has a follow atribute and is posted by admin, not masking it.');
            #wordpress adds rel="nofollow" by itself when posting new link in comments. get rid of it! Also, remove our follow attibute - it is unneccesary.
            return str_ireplace(array('rel="follow"', "rel='follow'", 'rel="nofollow"'), '', $matches[0]);
        } else
            $this->debug_info('it does not have rel follow or is not posted by admin, masking it');
        return false;
    }

    function parser($matches)
    {
        global $wp_rewrite, $wpdb;
        #parser init
        $url = $matches[2];
        $this->debug_info('Parser called. Parsing argument {' . var_export($matches, 1) . "}\nAgainst link {" . $url . "}\n ");
        $r = $this->check_exclusions($matches);
        if ($r !== FALSE)
            return $r;

        #checking for different options, setting other
        if (!$wp_rewrite->using_permalinks())
            $sep = '?' . $this->options['LINK_SEP'] . '=';
        else
            $sep = '/' . $this->options['LINK_SEP'] . '/';
        if ($this->options['add_blank'])
            $ifblank = ' target="_blank"';
        if ($this->options['add_nofollow'])
            $ifnofollow = ' rel="nofollow"';
        /*masking url with numbers*/
        if (!$this->options['disable_mask_links']) {
            $url = $this->encode_link($url);
            if (!$wp_rewrite->using_permalinks())
                $url = urlencode($url);
            if ($sep[0] == '/')#to not create double backslashes
                $sep = substr($sep, 1);
            $tmp = $this->options['site'];
            //add "/" to site url- some servers dont't work with urls like xxx.ru?goto, but with xxx.ru/?goto
            if (substr($this->options['site'], 0, -1) !== '/')
                $tmp .= '/';
            $url = $tmp . $sep . $url;
        }
        if ($this->options['remove_links'])
            return '<span class="waslinkname">' . $matches[4] . '</span>';
        if ($this->options['link2text'])
            return '<span class="waslinkname">' . $matches[4] . '</span> ^(<span class="waslinkurl">' . $url . ')</span>';
        $link = '<a' . $ifblank . $ifnofollow . ' href="' . $url . '" ' . $matches[1] . $matches[3] . '>' . $matches[4] . '</a>';
        if ($this->options['put_noindex'])
            $link = '<noindex>' . $link . '</noindex>';
        if ($this->options['put_noindex_comment'])
            $link = '<!--noindex-->' . $link . '<!--/noindex-->';
        return $link;
    }

    function encode_link($url)
    {
        global $wpdb;
        if ($this->options['base64']) {
            $url = base64_encode($url);
        } elseif ($this->options['maskurl']) {
            $sql = 'select id from ' . $wpdb->prefix . 'masklinks where url= %s limit 1';
            $result = $wpdb->get_var($wpdb->prepare($sql, $url));
            if (is_null($result) && strpos($wpdb->last_error, "doesn't exist"))//no table found
            {
                /*create masklink table*/
                echo '<div class="error">' . __('Failed to make masked link. MySQL link table does not exist. Trying to create table.', 'wp-noexternallinks') . '</div>';
                $sql2 = 'CREATE TABLE ' . $wpdb->prefix . 'masklinks(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,`url` VARCHAR(255),  PRIMARY KEY (`id`))';
                $res = $wpdb->query($sql2);
                if (!$res) {
                    echo '<div class="error">' . __('Failed to create table. Please, check mysql permissions.', 'wp-noexternallinks') . '</div>';
                    $this->debug_info(__('Failed SQL: ', 'wp-noexternallinks') . '<br>' . $sql2 . '<br>' . __('Error was:', 'wp-noexternallinks') . '<br>' . $wpdb->last_error);
                } else {
                    echo '<div class="updated">' . __('Table created.', 'wp-noexternallinks') . '</div>';
                    $wpdb->query($sql);
                }
            } elseif (is_null($result)) {
                $this->debug_info(__('Failed SQL: ', 'wp-noexternallinks') . '<br>' . $sql . '<br>' . __('Error was:', 'wp-noexternallinks') . '<br>' . $wpdb->last_error);
            }
            if (!$result) {
                $sql = 'INSERT INTO ' . $wpdb->prefix . 'masklinks VALUES("",%s)';
                $wpdb->query($wpdb->prepare($sql, $url));
                $url = $wpdb->insert_id;
            } else
                $url = $result;
        }
        return $url;
    }

    function decode_link($url)
    {
        global $wpdb;
        if ($this->options['base64']) {
            $url = base64_decode($url);
        } elseif ($this->options['maskurl']) {
            $sql = 'select url from ' . $wpdb->prefix . 'masklinks where id= %s limit 1';
            $url = $wpdb->get_var($wpdb->prepare($sql, $url));
        }
        return $url;
    }

    function __construct()
    {
        $this->load_options();
        $this->set_filters();
        add_filter('template_redirect', array($this, 'check_redirect'), 1);
        $this->debug_info("Options: \n" . var_export($this->options, true));
    }

    function check_redirect()#checking if it is redirect page
    {
        $goto = '';
        $p = strpos($_SERVER['REQUEST_URI'], '/' . $this->options['LINK_SEP'] . '/');
        if (@$_REQUEST[$this->options['LINK_SEP']])
            $goto = $_REQUEST[$this->options['LINK_SEP']];
        elseif ($p !== FALSE)
            $goto = substr($_SERVER['REQUEST_URI'], $p + strlen($this->options['LINK_SEP']) + 2);
        $goto=strip_tags($goto);//just in case of xss
        //what is this block?! Better remove it...
        /*else {
            $url = $_SERVER['REQUEST_URI'];
            $url = explode('/', $url);
            if ($url[sizeof($url) - 2] == $this->options['LINK_SEP'])
                $goto = $url[sizeof($url) - 1];
        }
        if (!strpos($goto, '://'))
            $goto = str_replace(':/', '://', $goto);
        */
        if ($goto)
            $this->redirect($goto);
    }

    function show_referer_warning()
    {
        ?>
        <html>
    <head><title><?php _e('Redirecting...', 'wp-noexternallinks'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="robots" content="noindex,nofollow"/>
        <meta http-equiv="refresh" content="5; url=<?php echo get_home_url(); ?>"/>
    </head>
    <body style="margin:0;">
    <div align="center" style="margin-top: 15em;">
        <?php
        echo __('You have been redirected through this website from a suspicious source. We prevented it and you are going to be redirected to our ', 'wp-noexternallinks') . '<a href="' . get_home_url() . '">' . __('safe web site.', 'wp-noexternallinks') . '</a>'; ?>
    </div>
    </body></html><?php die();
    }

    function add_stats_record($url)
    {
        global $wpdb;
        if (!$this->options['stats'])
            return;
        $sql = 'INSERT INTO ' . $wpdb->prefix . 'links_stats VALUES("", %s ,NOW())';
        $res = $wpdb->query($wpdb->prepare($sql, $url));
        if ($res !== FALSE)
            return;#all ok
        #error - stats record could not be created
        $this->debug_info(__('Failed SQL: ', 'wp-noexternallinks') . '<br>' . $sql . '<br>' . __('Error was:', 'wp-noexternallinks') . '<br>' . $wpdb->last_error);
        echo '<div class="error">' . __('Failed to save statistic data. Trying to create table.', 'wp-noexternallinks') . '</div>';
        $sql2 = 'CREATE TABLE ' . $wpdb->prefix . 'links_stats(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,`url` VARCHAR(255), `date` DATETIME, PRIMARY KEY (`id`))';
        $res = $wpdb->query($sql2);
        if ($res === FALSE) {
            echo '<div class="error">' . __('Failed to create table. Please, check mysql permissions.', 'wp-noexternallinks') . '</div>';
            $this->debug_info(__('Failed SQL: ', 'wp-noexternallinks') . '<br>' . $sql2 . '<br>' . __('Error was:') . '<br>' . $wpdb->last_error);
        } else {
            echo '<div class="updated">' . __('Table created.', 'wp-noexternallinks') . '</div>';
            $wpdb->query($sql);
        }
    }


    function redirect($url)
    {
        global $wp_rewrite, $wpdb, $hyper_cache_stop;
        //disable Hyper Cache plugin (http://www.satollo.net/plugins/hyper-cache) from caching this page
        $hyper_cache_stop = true;
        //disable WP Super Cache caching
        if (!defined('DONOTCACHEPAGE'))
            define('DONOTCACHEPAGE', 1);
        $url = $this->decode_link($url);
        $this->add_stats_record($url);
        $this->init_lang();
        if (!$wp_rewrite->using_permalinks())
            $url = urldecode($url);
        $url = str_ireplace('&#038;', '&', $url);

        if ($this->options['restrict_referer']) {
            #checking for spamer attack, redirect should happen from your own website

            if (stripos(wp_get_referer(), $this->options['site']) !== 0)#oh, god, it happened!
                $this->show_referer_warning();
        }
        $this->show_redirect_page($url);
    }


    function show_redirect_page($url)
    {
        header('Content-type: text/html; charset="utf-8"', true);
        if (!$this->options['no302'] && $url)
            @header('Location: ' . $url);
        ?>
        <html>
    <head><title><?php _e('Redirecting...', 'wp-noexternallinks'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="robots" content="noindex,nofollow"/>
        <?php if ($url) echo '<meta http-equiv="refresh" content="';
        if ($this->options['redtime'])
            echo $this->options['redtime'];
        else echo '0';
        echo '; url=' . $url . '" />'; ?>
    </head>
    <body style="margin:0;">
    <div align="center" style="margin-top: 15em;">
        <?php
        if ($this->options['redtxt'] && $url)
            echo str_replace('LINKURL', $url, $this->options['redtxt']);
        elseif ($url)
            echo __('You were going to the redirect link, but something did not work properly.<br>Please, click ', 'wp-noexternallinks') . '<a href="' . $url . '">' . __('HERE ', 'wp-noexternallinks') . '</a>' . __(' to go to ', 'wp-noexternallinks') . $url . __(' manually. ', 'wp-noexternallinks');
        else
            _e('Sorry, no url redirect specified. Can`t complete request.', 'wp-noexternallinks'); ?>
    </div>
    </body></html><?php die();
    }

    function filter($content)
    {
        $this->debug_info("Processing text: \n" . str_replace('-->', '--&gt;', $content));
        if (function_exists('is_feed') && is_feed() && !$this->options['mask_rss'] && !$this->options['mask_rss_comment']) {
            $this->debug_info('It is feed, no processing');
            return $content;
        }
        $pattern = '/<a (.*?)href=[\"\'](.*?)[\"\'](.*?)>(.*?)<\/a>/si';
        $content = preg_replace_callback($pattern, array($this, 'parser'), $content, -1, $count);
        $this->debug_info($count . " replacements done.\nFilter returned: \n" . str_replace('-->', '--&gt;', $content));
        return $content;
    }

    function chk_post($content)
    {
        global $post;
        $this->debug_info("Checking post for meta.");
        $mask = get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true);
        if ($mask == 2)/*nomask*/ {
            $this->debug_info("Meta nomask. No masking will be applied");
            return $content;
        } else {
            $this->debug_info("Filter will be applied");
            return $this->filter($content);
        }
    }

    function fullmask_begin()
    {
        if (defined('DOING_CRON'))
            return;//do not try to use output buffering on cron
        $a = ob_start(array($this, 'fullmask_end'));
        if (!$a)
            echo '<div class="error">' . __('Can not get output buffer!') . __('WP_NoExternalLinks Can`t use output buffer. Please, disable full masking and use other filters.', 'wp-noexternallinks') . '</div>';
        if ($this->options['debug'])
            $this->debug_info("Starting full mask.");
    }

    function fullmask_end($text)
    {
        global $post;
        if (defined('DOING_CRON'))
            return '';//do not try to use output buffering on cron
        $r = '';
        $r .= $this->debug_info("Full mask finished. Applying filter", 1);
        if (!$text)
            $r .= '<div class="error">' . __('Output buffer empty!') . __('WP_NoExternalLinks Can`t use output buffer. Please, disable full masking and use other filters.', 'wp-noexternallinks', 1) . '</div>';
        else {
            $r .= $this->debug_info("Processing text (htmlspecialchars on it to stay like comment): \n" . htmlspecialchars($text), 1);
            if (is_object($post) && (get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true) == 2))
                $r .= $text;
            elseif (function_exists('is_feed') && is_feed())
                $r .= $text;
            else
                $r .= $this->filter($text);
        }
        $r .= $this->debug_info("Full mask output finished", 1);
        return $r;
    }

    function set_filters()
    {
        register_activation_hook(__FILE__, array($this, 'activate'));
        if ($this->options['debug'])
            add_action('wp_footer', array($this, 'output_debug'), 99);

        if ($this->options['noforauth']) {
            $this->debug_info("Masking is enabled only for non logged in users");
            if (!function_exists('is_user_logged_in')) {
                $this->debug_info("'is_user_logged_in' function not found! Trying to include its file");
                $path = constant('ABSPATH') . 'wp-includes/pluggable.php';
                if (file_exists($path))
                    require_once($path);
                else
                    $this->debug_info("pluggable file not found! Not gonna include.");
            }
            if (is_user_logged_in()) {
                $this->debug_info("User is authorised, we're not doing anything");
                return;
            }
        }
        if ($this->options['fullmask']) {
            $this->debug_info("Setting fullmask filters");
            $this->fullmask_begin();
        } else {
            $this->debug_info("Setting per element filters");
            if ($this->options['mask_mine']) {
                add_filter('the_content', array($this, 'chk_post'), 99);
                add_filter('the_excerpt', array($this, 'chk_post'), 99);
            }
            if ($this->options['mask_comment']) {
                add_filter('comment_text', array($this, 'filter'), 99);
                add_filter('comment_url', array($this, 'filter'), 99);
            }
            if ($this->options['mask_rss']) {
                add_filter('the_content_feed', array($this, 'filter'), 99);
                add_filter('the_content_rss', array($this, 'filter'), 99);
            }
            if ($this->options['mask_rss_comment'])
                add_filter('comment_text_rss', array($this, 'filter'), 99);
            if ($this->options['mask_author']) {
                add_filter('get_comment_author_url_link', array($this, 'filter'), 99);
                add_filter('get_comment_author_link', array($this, 'filter'), 99);
                add_filter('get_comment_author_url', array($this, 'filter'), 99);
            }
            #add custom filter for user usage
            add_filter('wp_noexternallinks', array($this, 'filter'), 99);
        }
    }
}

?>