<?php

function rcl_action(){
    global $rcl_userlk_action;
    $last_action = rcl_get_useraction($rcl_userlk_action);
    $class = (!$last_action)? 'online': 'offline';

    if($last_action) $status = __('not online','wp-recall').' '.$last_action;
    else $status = __('online','wp-recall');
    
    echo sprintf('<span class="user-status %s">%s</span>',$class,$status);
}

function rcl_avatar($size=120){
    global $user_LK; $after='';
    echo '<div id="rcl-contayner-avatar">';
	echo '<span class="rcl-user-avatar">'.get_avatar($user_LK,$size).'</span>';
	echo apply_filters('after-avatar-rcl',$after,$user_LK);
	echo '</div>';

}

function rcl_status_desc(){
    global $user_LK;
    $desc = get_the_author_meta('description',$user_LK);
    if($desc) echo '<div class="ballun-status">'
        . '<p class="status-user-rcl">'.nl2br(esc_textarea($desc)).'</p>'
        . '</div>';
}

function rcl_username(){
    global $user_LK;
    echo get_the_author_meta('display_name',$user_LK);
}

function rcl_notice(){
    $notify = '';
    $notify = apply_filters('notify_lk',$notify);
    if($notify) echo '<div class="notify-lk">'.$notify.'</div>';
}

//добавляем стили колорпикера и другие в хеадер
add_action('wp_head','rcl_inline_styles',100);
function rcl_inline_styles(){
    global $rcl_options;

    list($r, $g, $b) = (isset($rcl_options['primary-color'])&&$rcl_options['primary-color'])? sscanf($rcl_options['primary-color'], "#%02x%02x%02x"): array(76, 140, 189);
    
    $styles = 'a.recall-button,
    .recall-button.rcl-upload-button,
    input[type="submit"].recall-button,
    input[type="submit"] .recall-button,
    input[type="button"].recall-button,
    input[type="button"] .recall-button,
    a.recall-button:hover,
    .recall-button.rcl-upload-button:hover,
    input[type="submit"].recall-button:hover,
    input[type="submit"] .recall-button:hover,
    input[type="button"].recall-button:hover,
    input[type="button"] .recall-button:hover{
        background: rgb('.$r.', '.$g.', '.$b.');
    }
    a.recall-button.active,
    a.recall-button.active:hover,
    a.recall-button.filter-active,
    a.recall-button.filter-active:hover,
    a.data-filter.filter-active,
    a.data-filter.filter-active:hover{
        background: rgba('.$r.', '.$g.', '.$b.', 0.4);
    } 
    .rcl_preloader i{
        color: rgb('.$r.', '.$g.', '.$b.');
    }
    p.status-user-rcl::before{
        border-color: transparent transparent transparent rgb('.$r.', '.$g.', '.$b.');   
    }
    .ballun-status p.status-user-rcl{
        border: 1px solid rgb('.$r.', '.$g.', '.$b.');
    }
    .rcl-field-input input[type="checkbox"]:checked + label.block-label::before,
    .rcl-field-input input[type="radio"]:checked + label.block-label::before{
        background: rgb('.$r.', '.$g.', '.$b.');
    }';
    
    $styles = apply_filters('rcl_inline_styles',$styles,array($r, $g, $b));

    // удаляем пробелы, переносы, табуляцию
    $styles =  preg_replace('/ {2,}/','',str_replace(array("\r\n", "\r", "\n", "\t"), '', $styles));

    echo '<style>'.$styles.'</style>';

}

add_action('wp_recall_init','init_user_lk',2);
function init_user_lk(){
    global $wpdb,$user_LK,$rcl_userlk_action,$rcl_options,$user_ID;

    $user_LK = false;
    $userLK = false;
    $get='user';
    $nicename = false;
    
    if(isset($rcl_options['link_user_lk_rcl'])&&$rcl_options['link_user_lk_rcl']!='') $get = $rcl_options['link_user_lk_rcl'];
    if(isset($_GET[$get])) $userLK = $_GET[$get];

    if(!$userLK){
        if($rcl_options['view_user_lk_rcl']==1){
                $post_id = url_to_postid($_SERVER['REQUEST_URI']);
                if($rcl_options['lk_page_rcl']==$post_id) $user_LK = $user_ID;
        }else {
            if(isset($_GET['author'])) $user_LK = $_GET['author'];
            else{
                $url = (isset($_SERVER['SCRIPT_URL']))? $_SERVER['SCRIPT_URL']: $_SERVER['REQUEST_URI'];
                $url = preg_replace('/\?.*/', '', $url);
                $url_ar = explode('/',$url);
                foreach($url_ar as $key=>$u){
                    if($u!='author') continue;
                    $nicename = $url_ar[$key+1];
                    break;
                }
                if(!$nicename) return false;
                $user_LK = $wpdb->get_var($wpdb->prepare("SELECT ID FROM ".$wpdb->prefix."users WHERE user_nicename='%s'",$nicename));
            }
        }
    }else{
	$user_LK = $userLK;
    }

    if($user_LK){
        $rcl_userlk_action = rcl_get_time_user_action($user_LK);
    }
}

add_action('wp_footer','rcl_popup_contayner',10);
function rcl_popup_contayner(){
    echo '<div id="rcl-overlay"></div>
        <div id="rcl-popup"></div>';
}

add_filter('wp_footer', 'rcl_footer_url',10);
function rcl_footer_url(){	
	if(is_front_page()&&!is_user_logged_in()){
            if(get_option('rcl_footer_link')==1)
                echo '<p class="plugin-info">'.__('The site works using the functionality of the plugin','wp-recall').'  <a target="_blank" href="https://codeseller.ru/">Wp-Recall</a></p>';
        }
}

function rcl_get_author_block(){
    global $post;

    $content = "<div id=block_author-rcl>";
    $content .= "<h3>".__('Author of publication','wp-recall')."</h3>";

    if(function_exists('rcl_add_userlist_follow_button')) add_filter('rcl_user_description','rcl_add_userlist_follow_button',90);

    $content .= rcl_get_userlist(array(
            'template' => 'rows',
            'include' => $post->post_author,
            'filter' => 0,
            'data'=>'rating_total,description,posts_count,user_registered,comments_count'
            //'orderby'=>'time_action'
        ));

    if(function_exists('rcl_add_userlist_follow_button')) remove_filter('rcl_user_description','rcl_add_userlist_follow_button',90);

    $content .= "</div>";

    return $content;
}

function rcl_get_time_user_action($user_id){
    global $wpdb;
    
    $cachekey = json_encode(array('rcl_get_time_user_action',$user_id));
    $cache = wp_cache_get( $cachekey );
    if ( $cache )
        return $cache;
    
    $action = $wpdb->get_var($wpdb->prepare("SELECT time_action FROM ".RCL_PREF."user_action WHERE user='%d'",$user_id));

    wp_cache_add( $cachekey, $action );
    
    return $action;
}

function rcl_get_miniaction($action,$user_id=false){
    global $wpdb;
    if(!$action) $action = rcl_get_time_user_action($user_id);
    $last_action = rcl_get_useraction($action);
    $class = (!$last_action&&$action)?'online':'offline';

    $content = '<div class="status_author_mess '.$class.'">';
    if(!$last_action&&$action) $content .= '<i class="fa fa-circle"></i>';
    else $content .= __('not online','wp-recall').' '.$last_action;
    $content .= '</div>';

    return $content;
}

//заменяем ссылку автора комментария на ссылку его ЛК
add_filter('get_comment_author_url', 'rcl_get_link_author_comment');
function rcl_get_link_author_comment($href){
    global $comment;
    if($comment->user_id==0) return $href;
    $href = get_author_posts_url($comment->user_id);
    return $href;
}

add_action('wp_head','rcl_hidden_admin_panel');
function rcl_hidden_admin_panel(){
    global $rcl_options,$user_ID;

    if(!$user_ID){
        return show_admin_bar(false);
    }

    $access = 7;
    if(isset($rcl_options['consol_access_rcl'])) $access = $rcl_options['consol_access_rcl'];
    $user_info = get_userdata($user_ID);
    if ( $user_info->user_level < $access ){
            show_admin_bar(false);
    }else{
            return true;
    }
}

add_action('init','rcl_banned_user_redirect');
function rcl_banned_user_redirect(){
    global $user_ID;
    if(!$user_ID) return false;
    $user_data = get_userdata( $user_ID );
    $roles = $user_data->roles;
    $role = array_shift($roles);
    if($role=='banned') wp_die(__('Congratulations! You have been banned.','wp-recall'));
}

add_filter('the_content','rcl_message_post_moderation');
function rcl_message_post_moderation($cont){
global $post;
    if($post->post_status=='pending'){
        $mess = '<h3 class="pending-message">'.__('Publication pending approval!','wp-recall').'</h3>';
        $cont = $mess.$cont;
    }
    return $cont;
}

function rcl_sort_gallery($attaches,$key,$user_id=false){
    global $user_ID;

    if(!$attaches) return false;
    if(!$user_id) $user_id = $user_ID;
    $cnt = count($attaches);
    $v=$cnt+10;
    foreach($attaches as $attach){
        $id = str_replace($key.'-'.$user_id.'-','',$attach->post_name);
        if(!is_numeric($id)||$id>100) $id = $v++;
        if(!$id) $id = 0;
        foreach($attach as $k=>$att){
                $gallerylist[(int)$id][$k]=$attach->$k;
        }
    }

    $b=0;
    $cnt = count($gallerylist);
    for($a=0;$b<$cnt;$a++){
        if(!isset($gallerylist[$a])) continue;
        $new[$b] = $gallerylist[$a];
        $b++;
    }
    for($a=$cnt-1;$a>=0;$a--){$news[]=(object)$new[$a];}

    return $news;
}

function rcl_bar_add_icon($id_icon,$args){
    global $rcl_bar,$rcl_options;
    if(!isset($rcl_options['view_recallbar'])||!$rcl_options['view_recallbar']) return false;
    $rcl_bar['icons'][$id_icon] = $args;
}
function rcl_bar_add_menu_item($id_item,$args){
    global $rcl_bar,$rcl_options;
    if(!isset($rcl_options['view_recallbar'])||!$rcl_options['view_recallbar']) return false;
    $rcl_bar['menu'][$id_item] = $args;
}
