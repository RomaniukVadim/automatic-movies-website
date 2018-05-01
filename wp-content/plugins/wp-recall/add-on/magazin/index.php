<?php

if (!session_id()) { session_start(); }

require_once("functions.php");
require_once("functions/ajax-func.php");

if(is_admin()):
    require_once("admin-pages.php");
else:
    require_once("functions/shortcodes.php");
    add_action('rcl_enqueue_scripts','rcl_rmag_scripts',10);
endif;

function rcl_rmag_scripts(){
    rcl_enqueue_style('rcl-magazine',rcl_addon_url('style.css', __FILE__));
    rcl_enqueue_script( 'rcl-magazine', rcl_addon_url('js/scripts.js', __FILE__) );
}

function rmag_global_unit(){
    if(defined('RMAG_PREF')) return false;
    global $wpdb,$rmag_options,$user_ID;

    if(!isset($_SESSION['return_'.$user_ID]))
            $_SESSION['return_'.$user_ID] = (isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER']: '/';
    
    $rmag_options = get_option('primary-rmag-options');
    define('RMAG_PREF', $wpdb->prefix."rmag_");
}
add_action('init','rmag_global_unit',10);

add_action('init','rcl_tab_orders');
function rcl_tab_orders(){
    rcl_tab('orders','rcl_orders',__('Orders','wp-recall'),array('public'=>0,'ajax-load'=>true,'class'=>'fa-shopping-cart','order'=>30,'path'=>__FILE__));
}

function rcl_orders($author_lk){
    global $wpdb,$user_ID,$rmag_options,$rcl_options,$order;

        $block = apply_filters('content_order_tab','');

	if(isset($_GET['order-id'])){

                $order = rcl_get_order($_GET['order-id']);

                if($order->order_author!=$author_lk) return false;

                $status = $order->order_status;
                $order_id = $order->order_id;
                $price = $order->order_price;

                $block .= '<a class="recall-button view-orders" href="'.rcl_format_url(get_author_posts_url($author_lk),'orders').'">Смотреть все заказы</a>';

                $block .= '<h3>'.__('Order','wp-recall').' №'.$order_id.'</h3>';
                
                $postdata = rcl_encode_post(array(
                    'callback'=>'rcl_trash_order',
                    'order_id'=>$order_id
                ));

                $block .= '<div id="manage-order">';
                if($status == 1||$status == 5) 
                    $block .= '<div class="remove-order">'
                        . '<input class="remove_order recall-button rcl-ajax" data-post="'.$postdata.'" type="button" value="'.__('Delete','wp-recall').'">'
                        . '</div>';
                if($status==1&&function_exists('rcl_payform')){
                    
                    $type_pay = $rmag_options['type_order_payment'];
                    
                    $payment = new Rcl_Payment();
                    
                    $block .= '<div class="rcl-types-paeers">';
                    
                    if($type_pay==1||$type_pay==2){
                        $block .= $payment->get_form(array('id_pay'=>$order_id,'summ'=>$price,'type'=>2));
                    }
                    
                    if(!$type_pay||$type_pay==2){
                        $block .= $payment->personal_account_pay_form($order_id);
                    }
                    
                    $block .= '</div>';
                    
                }
                $block .= '</div>';

                $block .= '<div class="redirectform"></div>';

		$block .= rcl_get_include_template('order.php',__FILE__);

	}else{

		global $orders;

		$orders = rcl_get_orders(array('user_id'=>$author_lk,'status_not_in'=>6));

		if(!$orders) $block .= '<p>'.__('You have not yet issued any order','wp-recall').'.</p>';
		else $block .= rcl_get_include_template('orders-history.php',__FILE__);

	}

	return $block;
}