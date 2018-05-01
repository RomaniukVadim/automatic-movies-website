<?php
/*
Plugin Name: Find duplicates
Description: A plugin that finds duplicate and similar posts based on their post_content or post_title similarity. You can define the percentage of similarity, post type and post status. The plugin is a great utility to find duplicates that differ in only a few characters.
Version: 1.4.6
Author: Markus Seyer
Plugin URI: http://www.markusseyer.de
Author URI: http://www.markusseyer.de
*/


register_activation_hook(__FILE__, array('FindDuplicates', 'activate') );
register_deactivation_hook(__FILE__, array('FindDuplicates', 'deactivate') );

class FindDuplicates {
    private static $url = '';
    private static $dir = '';

    public static function init() {
        self::$url = apply_filters( __CLASS__.'_url', plugins_url('/', __FILE__), __FILE__ );
        self::$dir = apply_filters( __CLASS__.'_dir', plugin_dir_path(__FILE__), __FILE__ );
        self::load();
        self::add_actions();
        self::add_filters();
    }

    protected static function load() {
    }
    protected static function add_actions() {
        add_action('save_post', array('FindDuplicates','save_post'));
        add_action('admin_menu', array('FindDuplicates','action_admin_menu'));
        add_action('admin_init', array('FindDuplicates','action_admin_init'));
        add_action('post_submitbox_misc_actions', array('FindDuplicates','output_fd_meta'));
        add_action('wp_ajax_get_duplicate_results', array('FindDuplicates','get_duplicate_results'));
        add_action('wp_ajax_get_duplicate_results_meta', array('FindDuplicates','get_duplicate_results_meta'));
        add_action('wp_ajax_get_posts_count', array('FindDuplicates','get_posts_count'));
        add_action('wp_ajax_remove_result', array('FindDuplicates','remove_result'));
    }
    protected static function add_filters() {
    }

    public static function activate() {
        $options = delete_option('find_duplicates_data');
        $options = array();

        $options['settings'] = array(
            'target' => 'trash',
        );

        $options['auto'] = array(
            'active' => 0,
            'datefrom' => "",
            'dateto' => "",
            'days' => "",
            'statuses' => array('publish'),
            'similarity' => 80,
            'field' => 0,
            'types' => array('post'),
            'filterhtml' => 0,
            'filterwords' => "",
            'filterhtmlentities' => 0
        );
        //$options['auto']['comparelimit'] = 1000;

        $options['meta'] = array(
            'active' => 0,
            'datefrom' => "",
            'dateto' => "",
            'days' => "",
            'statuses' => array('publish'),
            'similarity' => 80,
            'field' => 0,
            'types' => array('post'),
            'filterhtml' => 0,
            'filterwords' => "",
            'filterhtmlentities' => 0,
            'comparelimit' => 1000
        );


        $options['search'] = array(
            'datefrom' => "",
            'dateto' => "",
            'statuses' => array('publish'),
            'similarity' => 80,
            'field' => 0,
            'types' => 'post',
            'filterhtml' => 0,
            'filterwords' => "",
            'filterhtmlentities' => 0,
            'comparelimit' => 1000,
            'done' => array(),
            'post2_offset' => 0,
            'found' => array(),
            'postlimit' => 1,
        );

        update_option('find_duplicates_data', $options);
    }

    public static function deactivate() {
        $options = delete_option('find_duplicates_data');
    }
    /* CALLBACKS */

    /* PUBLIC METHODS */
    public static function save_post($pid) {
            if (!wp_is_post_revision($pid) AND get_post_status($pid) != "auto-draft") {
                $newpost = get_post($pid);
                $options = get_option('find_duplicates_data', array());
                if ($options['auto']['active'] == 1 AND in_array(get_post_type($newpost), $options['auto']['types'])) {
                    if ($newpost->post_status == "publish") {
                        $type = get_post_type($newpost);
                        $log = "";
                        $options = get_option('find_duplicates_data', array());
                        $post_status = implode("','", $options['auto']['statuses']);
                        $datewhere = "";
                        if(!empty($options['auto']['days'])) {
                            $datewhere .= "post_date>='" . date("Y-m-d",time()-(intval($options['auto']['days'])*24*60*60)) . " 00:00:00" . "' AND ";
                            $datewhere .= "post_date<='" . date("Y-m-d") . " 23:59:59" . "' AND ";
                        } else {
                            if (!empty($options['auto']['datefrom'])) {
                                $datewhere .= "post_date>='" . $options['auto']['datefrom'] . " 00:00:00" . "' AND ";
                            }
                            if (!empty($options['auto']['dateto'])) {
                                $datewhere .= "post_date<='" . $options['auto']['dateto'] . " 23:59:59" . "' AND ";
                            }
                        }
                        global $wpdb;
                        //$allPosts_count = $wpdb->get_results("SELECT COUNT(ID) as count FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $type . "' AND post_status IN('" . $post_status . "') AND ID != " . $pid);
                        //$allPosts_count = $allPosts_count[0]->count;
                        $allPosts = $wpdb->get_results("SELECT ID,post_title,post_date,post_content FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $type . "' AND post_status IN('" . $post_status . "') AND ID != " . $pid);

                        foreach ($allPosts as $post2) {
                            $post = new stdClass();
                            $post->ID = $pid;
                            $post->post_title = $newpost->post_title;
                            $post->post_content = $newpost->post_content;
                            $isDuplicate = self::compare_post($post,$post2,$options['auto']);
                            if(is_array($isDuplicate)) {
                                $target = $options['settings']['target'];
                                switch($target) {
                                    case "trash":
                                        $result = wp_delete_post($pid, false);
                                        break;
                                    case "pending":
                                        $my_post = array(
                                            'ID' => $pid,
                                            'post_status' => 'pending'
                                        );
                                        $result = wp_update_post($my_post);
                                        break;
                                    case "draft":
                                        $my_post = array(
                                            'ID' => $pid,
                                            'post_status' => 'draft'
                                        );
                                        $result = wp_update_post($my_post);
                                        break;
                                }
                                /*$my_post = array();
                                $my_post['ID'] = $pid;
                                $my_post['post_status'] = 'pending';*/
                                if($result === true OR $result > 0) {
                                //if (wp_update_post($my_post) != false) {
                                    $log .= "Duplicate: " . $pid . " (similar to " . $post2->ID . ")<br />";
                                } else {
                                    $log .= "Error: " . $pid . "(similar to " . $post2->ID . ")<br />";
                                }
                            }
                            set_time_limit(300);
                        }
                        $old_log = get_option('find_duplicates_auto_log', '');
                        update_option('find_duplicates_auto_log', $old_log . $log);
                    }
                }
            }
            return $pid;
    }

    public static function action_admin_menu()
    {
        $page = add_management_page('Find duplicates', 'Find duplicates', 'manage_options', __FILE__, array('FindDuplicates','output_fd_page'));
        add_action('admin_print_styles-' . $page, array('FindDuplicates','load_javascript'));
        $page = add_options_page('Find duplicates', 'Find duplicates', 'manage_options', __FILE__, array('FindDuplicates','output_fd_options_page'));
        add_action('admin_print_styles-' . $page, array('FindDuplicates','load_javascript_options'));
    }

    public static function action_admin_init()
    {
        wp_register_script('find-duplicates-js', plugins_url('/js/find-duplicates-page.js', __FILE__));
        wp_register_script('find-duplicates-js-meta', plugins_url('/js/find-duplicates-meta.js', __FILE__));
        wp_enqueue_style('find-duplicates-css', plugins_url('css/smoothness/jquery-ui.min.css', __FILE__));
        load_plugin_textdomain('find-duplicates', false, basename(dirname(__FILE__)) . '/languages');
    }

    public static function output_fd_meta()
    {
        global $post;
        $options = get_option('find_duplicates_data', array());
        if ($options['meta']['active'] == 1 AND in_array(get_post_type($post), $options['meta']['types'])) {
            wp_enqueue_script('find-duplicates-js-meta');
            include(plugin_dir_path(__FILE__) . 'tpl/metabox.php');
        }
    }

    public static function get_duplicate_results()
    {
        if ($_POST['startnew'] == 1) {
            $options = get_option('find_duplicates_data', array());
            $options['search']['field'] = $_POST['search_field'];
            $options['search']['datefrom'] = $_POST['datefrom'];
            $options['search']['dateto'] = $_POST['dateto'];
            $options['search']['statuses'] = $_POST['statuses'];
            $options['search']['types'] = $_POST['types'];
            $options['search']['similarity'] = $_POST['similarity'];
            $options['search']['done'] = array();
            $options['search']['post2_offset'] = 0;
            $options['search']['found'] = array();
            $options['search']['filterhtml'] = $_POST['filterhtml'];
            $options['search']['filterwords'] = $_POST['filterwords'];
            $options['search']['filterhtmlentities'] = $_POST['filterhtmlentities'];
            $options['search']['comparelimit'] = empty($_POST['comparelimit']) ? 1000 : $_POST['comparelimit'];
            update_option('find_duplicates_data', $options);
        }
        echo self::find_similar_posts();
        die;
    }

    public static function output_fd_page()
    {
        if (!current_user_can('edit_posts')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        include(plugin_dir_path(__FILE__) . 'tpl/search.php');
    }

    public static function output_fd_options_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        if (isset($_POST['save'])) {
            $options = get_option('find_duplicates_data', array());
            $options['settings']['target'] = $_POST['settings_target'];

            $options['auto']['active'] = ($_POST['auto_active'] == 1) ? 1 : 0;
            $options['auto']['datefrom'] = $_POST['auto_datefrom'];
            $options['auto']['dateto'] = $_POST['auto_dateto'];
            $options['auto']['days'] = $_POST['auto_days'];
            $options['auto']['statuses'] = isset($_POST['auto_status']) ? $_POST['auto_status'] : array();
            $options['auto']['types'] = isset($_POST['auto_types']) ? $_POST['auto_types'] : array();
            $options['auto']['similarity'] = $_POST['auto_similarity'];
            $options['auto']['field'] = $_POST['auto_field'];
            $options['auto']['comparelimit'] = intval($_POST['auto_comparelimit']);
            $options['auto']['filterhtml'] = isset($_POST['auto_filterhtml']) ? 1 : 0;
            $options['auto']['filterhtmlentities'] = isset($_POST['auto_filterhtmlentities']) ? 1 : 0;
            $options['auto']['filterwords'] = $_POST['auto_filterwords'];

            $options['meta']['active'] = isset($_POST['meta_active']) ? 1 : 0;
            $options['meta']['datefrom'] = $_POST['meta_datefrom'];
            $options['meta']['dateto'] = $_POST['meta_dateto'];
            $options['meta']['days'] = $_POST['meta_days'];
            $options['meta']['statuses'] = isset($_POST['meta_status']) ? $_POST['meta_status'] : array();
            $options['meta']['types'] = isset($_POST['meta_types']) ? $_POST['meta_types'] : array();
            $options['meta']['similarity'] = $_POST['meta_similarity'];
            $options['meta']['field'] = $_POST['meta_field'];
            $options['meta']['comparelimit'] = intval($_POST['meta_comparelimit']);
            $options['meta']['filterhtml'] = isset($_POST['meta_filterhtml']) ? 1 : 0;
            $options['meta']['filterhtmlentities'] = isset($_POST['meta_filterhtmlentities']) ? 1 : 0;
            $options['meta']['filterwords'] = $_POST['meta_filterwords'];

            update_option('find_duplicates_data', $options);
        }
        include(plugin_dir_path(__FILE__) . 'tpl/options.php');
    }

    protected static function delete_post($id) {
        $options = get_option('find_duplicates_data', array());
        $status = get_post_status($id);
        $target = $options['settings']['target'];
        if($status !== false AND $status !== $target) {
            switch($target) {
                case "trash":
                    $result = wp_delete_post($id, false);
                    break;
                case "pending":
                    $post = array(
                        'ID' => $id,
                        'post_status' => 'pending'
                    );
                    $result = wp_update_post($post);
                    break;
                case "draft":
                    $post = array(
                        'ID' => $id,
                        'post_status' => 'draft'
                    );
                    $result = wp_update_post($post);
                    break;
            }

            if($result === true OR $result > 0) {
                $data = get_option('find_duplicates_data', null);
                foreach ($data['found'] as $key => $element) {
                    if ($element[0] == $id) {
                        unset($data['found'][$key]);
                    }
                }
                update_option('find_duplicates_data', $data);
            }
            return $result;
        }
        return true;
    }

    public static function get_duplicate_results_meta()
    {
        echo self::find_similar_post_meta($_POST['title'], $_POST['content'], $_POST['id'], $_POST['search_field'], $_POST['type']);
        die;
    }


    public function load_javascript()
    {
        wp_enqueue_script('find-duplicates-js');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('jquery-ui-datepicker');
    }

    public function load_javascript_options()
    {
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('jquery-ui-datepicker');
    }

    public static function get_posts_count()
    {
        $statuses = $_POST['statuses'];
        $post_type = $_POST['types'];
        $datefrom = (empty($_POST['datefrom'])) ? "" : $_POST['datefrom'] . " 00:00:00";
        $dateto = (empty($_POST['dateto'])) ? "" : $_POST['dateto'] . " 23:59:59";

        $datewhere = "";
        if (!empty($datefrom)) {
            $datewhere .= "post_date>='" . $datefrom . "' AND ";
        }

        if (!empty($dateto)) {
            $datewhere .= "post_date<='" . $dateto . "' AND ";
        }

        $count = 0;
        if (is_array($statuses)) {
            $post_statuses = "'" . implode("','", $statuses) . "'";
            global $wpdb;
            $posts = $wpdb->get_results("SELECT COUNT(ID) as count FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $post_type . "' AND post_status IN(" . $post_statuses . ") ");
            $count = $posts[0]->count;
        }
        echo json_encode(array(intval($count)));
        die;
    }

    public static function remove_result()
    {
        $oldid = $_POST['oldid'];
        $id = $_POST['id'];
        $result = true;
        if($oldid > 0) {
            $result = self::delete_post($oldid);
        }
        if($id > 0) {
            $result = self::delete_post($id);
        }
        $result = $result ? 1 : 0;
        echo json_encode(array($result));
        die;
    }

    /* INTERNAL METHODS */

    protected static function start_searching(&$limit,&$log,&$new_duplicates) {
        $options = get_option('find_duplicates_data', array());
        // get Posts
        $post_status = implode("','", $options['search']['statuses']);
        $excludes = implode("','", $options['search']['done']);
        $datewhere = "";
        if (!empty($options['search']['datefrom'])) {
            $datewhere .= "post_date>='" . $options['search']['datefrom'] . " 00:00:00" . "' AND ";
        }

        if (!empty($options['search']['dateto'])) {
            $datewhere .= "post_date<='" . $options['search']['dateto'] . " 23:59:59" . "' AND ";
        }
        $post2_offset = $options['search']['post2_offset'];
        global $wpdb;

        $allPosts_count = $wpdb->get_results("SELECT COUNT(ID) as count FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $options['search']['types'] . "' AND post_status IN('" . $post_status . "') AND ID NOT IN('" . $excludes . "')");
        $allPosts_count = $allPosts_count[0]->count;
        $allPosts = $wpdb->get_results("SELECT ID,post_title,post_date,post_content FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $options['search']['types'] . "' AND post_status IN('" . $post_status . "') AND ID NOT IN('" . $excludes . "') LIMIT " . $post2_offset . "," . $limit);
        if ($allPosts_count >= ($options['search']['post2_offset'] + $limit) AND $allPosts_count > $limit) {
            $options['search']['post2_offset'] = $options['search']['post2_offset'] + $limit;
        } else {
            $options['search']['post2_offset'] = 0;
        }
        // END get Posts
        $posts = $wpdb->get_results("SELECT ID,post_title,post_date,post_content FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $options['search']['types'] . "' AND post_status IN('" . $post_status . "') AND ID NOT IN('" . $excludes . "') LIMIT 1");

        if($limit > count($allPosts)) {
            $limit = 0;
        }

        foreach ($posts as $post) {
            $log .= "Comparing post " . $post->ID . " with " . count($allPosts). " other ones <br />";
            //$log .= "Comparing post " . $post->ID . " with " . $post2_offset . "-" . ($post2_offset + $limit) . "<br />";
            foreach ($allPosts as $post2) {
                $limit--;
                $isDuplicate = self::compare_post($post,$post2,$options['search']);
                if (is_array($isDuplicate)) {
                    if (strtotime($post->post_date) > strtotime($post2->post_date)) {
                        $options['search']['found'][] = array($post->ID, $post2->ID, intval(round($isDuplicate['similarity'])));
                        $new_duplicates[] = array($post->ID, $post2->ID, intval(round($isDuplicate['similarity'])), get_admin_url(), $post->post_title, $post2->post_title);
                    } else {
                        $options['search']['found'][] = array($post2->ID, $post->ID, intval(round($isDuplicate['similarity'])));
                        $new_duplicates[] = array($post2->ID, $post->ID, intval(round($isDuplicate['similarity'])), get_admin_url(), $post2->post_title, $post->post_title);
                    }
                }
            }
            if ($options['search']['post2_offset'] == 0) {
                $options['search']['done'][] = $post->ID;
            }
        }
        update_option('find_duplicates_data', $options);
        return $limit;
    }

    protected static function find_similar_posts()
    {
        $log = "";
        $new_duplicates = array();
        $options = get_option('find_duplicates_data', array());
        $limit = $options['search']['comparelimit'];
        while($limit > 0) {
            $limit = self::start_searching($limit,$log,$new_duplicates);
        }
        return json_encode(array(count($options['search']['done']), $log, $new_duplicates, count($options['search']['found'])));
    }

    protected static function compare_post(&$post,&$post2,$parameter) {
            $isDuplicate = false;
            if ($post2->ID != $post->ID) {
                switch($parameter['field']) {
                    case 1: //onlytitle
                        $post_compare = $post->post_title;
                        $post2_compare = $post2->post_title;
                        break;
                    case 2: //title AND content seperatly
                        $para = $parameter;
                        $para['field'] = 1;
                        $isDuplicate = self::compare_post($post,$post2,$para);
                        if($isDuplicate === false) {
                            $para['field'] = 0;
                            $isDuplicate = self::compare_post($post,$post2,$para);
                        }
                        break;
                    default: //content
                        $post_compare = $post->post_content;
                        $post2_compare = $post2->post_content;
                        break;
                }
                if($parameter['field'] != 2) {
                    if ($parameter['filterhtmlentities'] == 1) {
                        $post_compare = html_entity_decode($post_compare);
                        $post2_compare = html_entity_decode($post2_compare);
                    }
                    if ($parameter['filterhtml'] == 1) {
                        $post_compare = strip_tags($post_compare);
                        $post2_compare = strip_tags($post2_compare);
                    }
                    if (!empty($parameter['filterwords'])) {
                        $words = explode(",",$parameter['filterwords']);
                        foreach($words as $word) {
                            $post_compare = str_replace($word,"",$post_compare);
                            $post2_compare = str_replace($word,"",$post2_compare);
                        }
                    }
                    $lenDiff = strlen($post_compare) - strlen($post2_compare);
                    if ($lenDiff > -200 AND $lenDiff < 200) {
                        if($parameter['similarity'] == 100 AND ($post2_compare == $post_compare)) {
                            $isDuplicate = array('duplicate' => true,'similarity' => 100);
                        } else {
                            similar_text($post2_compare, $post_compare, $p);
                            if($p > $parameter['similarity']) {
                                $isDuplicate = array('duplicate' => true,'similarity' => $p);
                            }
                        }
                    }
                }
            }
            return $isDuplicate;
    }

    protected static function find_similar_post_meta($title, $content, $id, $field = 0, $type = 'post')
    {
        //ini_set("display_errors", true);

        if( ini_get('safe_mode') ){

        }else{
            //set_time_limit(300);
            ini_set('max_execution_time',300);
        }
        $log = "";
        $new_duplicates = array();
        $options = get_option('find_duplicates_data', array());
        $post2_limit = $options['meta']['comparelimit'];


        // get Posts
        $post_status = implode("','", $options['meta']['statuses']);
        $datewhere = "";
        if(!empty($options['meta']['days'])) {
            $datewhere .= "post_date>='" . date("Y-m-d",time()-(intval($options['meta']['days'])*24*60*60)) . " 00:00:00" . "' AND ";
            $datewhere .= "post_date<='" . date("Y-m-d") . " 23:59:59" . "' AND ";
        } else {
            if (!empty($options['meta']['datefrom'])) {
                $datewhere .= "post_date>='" . $options['meta']['datefrom'] . " 00:00:00" . "' AND ";
            }
            if (!empty($options['meta']['dateto'])) {
                $datewhere .= "post_date<='" . $options['meta']['dateto'] . " 23:59:59" . "' AND ";
            }
        }

        global $wpdb;
        $allPosts_count = $wpdb->get_results("SELECT COUNT(ID) as count FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $type . "' AND post_status IN('" . $post_status . "') AND ID != " . $id);
        $allPosts_count = $allPosts_count[0]->count;
        $allPosts = $wpdb->get_results("SELECT ID,post_title,post_date,post_content FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $type . "' AND post_status IN('" . $post_status . "') AND ID != " . $id);

        $log .= "Comparing " . $id . " (" . $allPosts_count . "," . $post2_limit . "," . $content . ")<br />";
        foreach ($allPosts as $post2) {
            $parameter = $options['meta'];
            //$parameter['field'] = $field;
            $post = new stdClass();
            $post->ID = $id;
            $post->post_title = $title;
            $post->post_content = $content;
            $isDuplicate = self::compare_post($post,$post2,$parameter);
            if(is_array($isDuplicate)) {
                $new_duplicates[] = array($post2->ID, $id, intval(round($isDuplicate['similarity'])), get_admin_url(), $post2->post_title, $title);
            }
        }

        return json_encode(array($allPosts_count, $log, $new_duplicates, count($new_duplicates)));
    }



}
add_action( 'init', array('FindDuplicates', 'init') );