<?php

if (!is_admin()):
    add_action('rcl_enqueue_scripts','rcl_feed_scripts',10);
endif;

function rcl_feed_scripts(){
    rcl_enqueue_style('rcl-feed',rcl_addon_url('style.css', __FILE__));
    rcl_enqueue_script( 'rcl-feed', rcl_addon_url('js/scripts.js', __FILE__) );
}

require_once 'addon-core.php';
require_once 'shortcodes.php';

add_action('init','rcl_add_block_feed_button');
function rcl_add_block_feed_button(){
    rcl_block('actions','rcl_add_feed_button',array('id'=>'fd-footer','order'=>5,'public'=>-1));
}

function rcl_add_feed_button($user_id){
    global $user_ID;
    if(!$user_ID||$user_ID==$user_id) return false;
    if(rcl_get_feed_author_current_user($user_id)){
        return rcl_get_feed_callback_link($user_id,__('Unsubscribe','wp-recall'),'rcl_update_feed_current_user');
    }else{
        return rcl_get_feed_callback_link($user_id,__('Subscribe','wp-recall'),'rcl_update_feed_current_user');
    }
}

function rcl_add_userlist_follow_button(){
    global $rcl_user;
    echo '<div class="follow-button">'.rcl_add_feed_button($rcl_user->ID).'</div>';
}

add_action('init','rcl_add_followers_tab');
function rcl_add_followers_tab(){
    global $user_LK;
    $count = 0;
    if(!is_admin()){
        $count = rcl_feed_count_subscribers($user_LK);
    }
    rcl_tab('followers','rcl_followers_tab',__('Followers','wp-recall'),array('public'=>1,'ajax-load'=>true,'cache'=>true,'output'=>'counters','counter'=>$count,'class'=>'fa-twitter'));
}

add_action('init','rcl_add_subscriptions_tab');
function rcl_add_subscriptions_tab(){
    global $user_LK;
    $count = 0;
    if(!is_admin()){
        $count = rcl_feed_count_authors($user_LK);
    }
    rcl_tab('subscriptions','rcl_subscriptions_tab',__('Subscriptions','wp-recall'),array('public'=>0,'ajax-load'=>true,'cache'=>true,'output'=>'counters','counter'=>$count,'class'=>'fa-bell-o'));
}

function rcl_followers_tab($user_id){

    $content = '<h3>'.__('List subscribers','wp-recall').'</h3>';

    $cnt = rcl_feed_count_subscribers($user_id);

    if($cnt){
        add_filter('rcl_user_description','rcl_add_userlist_follow_button',90);
        add_filter('rcl_users_query','rcl_feed_subsribers_query_userlist',10);
        $content .= rcl_get_userlist(array(
            'templates' => 'rows',
            'inpage'=>20,
            'orderby'=>'user_registered',
            'filters'=>1,
            'search_form'=>0,
            'data'=>'rating_total,description,posts_count,comments_count',
            'add_uri'=>array('tab'=>'followers')
            ));
    }else
        $content .= '<p>'.__('Following yet','wp-recall').'</p>';

    return $content;
}

function rcl_subscriptions_tab($user_id){
    $feeds = rcl_feed_count_authors($user_id);
    $content = '<h3>'.__('List subscriptions','wp-recall').'</h3>';
    if($feeds){
        add_filter('rcl_user_description','rcl_add_userlist_follow_button',90);
        add_filter('rcl_users_query','rcl_feed_authors_query_userlist',10);
        $content .= rcl_get_userlist(array(
            'template' => 'rows',
            'orderby'=>'user_registered',
            'inpage'=>20,
            'filters'=>1,
            'search_form'=>0,
            'data'=>'rating_total,description,posts_count,comments_count',
            'add_uri'=>array('tab'=>'subscriptions')
            ));
    } else{
        $content .= '<p>'.__('Subscriptions yet','wp-recall').'</p>';
    }
    return $content;
}

function rcl_feed_authors_query_userlist($query){
    global $user_LK;
    $query->query['join'][] = "INNER JOIN ".RCL_PREF."feeds AS feeds ON users.ID=feeds.object_id";
    $query->query['where'][] = "feeds.user_id='$user_LK'";
    $query->query['where'][] = "feeds.feed_type='author'";
    $query->query['where'][] = "feeds.feed_status='1'";
    $query->query['relation'] = "AND";
    $query->query['group'] = false;
    return $query;
}

function rcl_feed_subsribers_query_userlist($query){
    global $user_LK;
    $query->query['join'][] = "INNER JOIN ".RCL_PREF."feeds AS feeds ON users.ID=feeds.user_id";
    $query->query['where'][] = "feeds.object_id='$user_LK'";
    $query->query['where'][] = "feeds.feed_type='author'";
    $query->query['where'][] = "feeds.feed_status='1'";
    $query->query['relation'] = "AND";
    $query->query['group'] = false;
    return $query;
}

function rcl_update_feed_current_user($author_id){
    global $user_ID;

    $ignored_id = rcl_is_ignored_feed_author($author_id);

    if($ignored_id){

        $args = array(
            'feed_id'=>$ignored_id,
            'user_id'=>$user_ID,
            'object_id'=>$author_id,
            'feed_type'=>'author',
            'feed_status'=>1
        );

        $result = rcl_update_feed_data($args);

        if($result){
            $data['success'] = __('Signed up for a subscription','wp-recall');
            $data['this'] = __('Unsubscribe','wp-recall');
        }else{
            $data['error'] = __('Error','wp-recall');
        }

    }else{

        $feed = rcl_get_feed_author_current_user($author_id);

        if($feed){
            $result = rcl_remove_feed_author($author_id);
            if($result){
                $data['success'] = __('Subscription has been dropped','wp-recall');
                $data['this'] = __('Subscribe','wp-recall');
            }else{
                $data['error'] = __('Error','wp-recall');
            }
        }else{
            $result = rcl_add_feed_author($author_id);
            if($result){
                $data['success'] = __('Signed up for a subscription','wp-recall');
                $data['this'] = __('Unsubscribe','wp-recall');
            }else{
                $data['error'] = __('Error','wp-recall');
            }
        }
    }

    $data['return'] = 'notice';

    return $data;
}

add_action('wp_ajax_rcl_feed_progress','rcl_feed_progress');
function rcl_feed_progress(){
    global $rcl_feed;
    
    rcl_verify_ajax_nonce();

    $content = $_POST['content'];
    $paged = $_POST['paged'];

    include_once 'classes/class-rcl-feed.php';
    $list = new Rcl_Feed(array('paged'=>$paged,'content'=>$content,'filters'=>0));

    $count = false;

    if(!$list->number){

        $count = $list->count_feed_posts();

        $rclnavi = new Rcl_PageNavi('rcl-feed',$count,array('in_page'=>$list->inpage,'current_page'=>$list->paged));
        $list->offset = $rclnavi->offset;
        $list->number = $rclnavi->in_page;
    }

    $feedsdata = $list->get_feed();

    $content = '';

    if(!$feedsdata){
        $content .= '<p align="center">'.__('News not found','wp-recall').'</p>';

        $result['content'] = $content;
        $result['code'] = 0;

        echo json_encode($result);
        exit;
    }

    foreach($feedsdata as $rcl_feed){ $list->setup_data($rcl_feed);
        $content .= '<div id="feed-'.$rcl_feed->feed_type.'-'.$rcl_feed->feed_ID.'" class="feed-box feed-user-'.$rcl_feed->feed_author.' feed-'.$rcl_feed->feed_type.'">';
        $content .= rcl_get_include_template('feed-post.php',__FILE__);
        $content .= '</div>';
    }

    $list->remove_data();

    $result['content'] = $content;
    $result['code'] = 100;

    echo json_encode($result);
    exit;
}