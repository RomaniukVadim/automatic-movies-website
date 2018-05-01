<?php
include_once 'functions/core.php';
include_once 'functions/init.php';

function rcl_get_cart_button($product_id){
    global $rmag_options;
    
    $check = apply_filters('rcl_check_cart_button',true,$product_id);
    
    $button = '<div class="cart-button" itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
    
    if($check){
    
        $insale = (get_post_meta($product_id,'outsale',1))? 0: 1;
        if(isset($rmag_options['products_warehouse_recall'])&&$rmag_options['products_warehouse_recall']==1){
            $amount = get_post_meta($product_id, 'amount_product', 1);
            $insale = ($amount>0||$amount==false)? 1: 0;
        }
		
        if($insale){
            
            $button .= '<a href="#" class="recall-button" data-product="'.$product_id.'" onclick="rcl_add_cart(this);return false;" itemprop="availability" href="http://schema.org/InStock">
                <span class="cart-icon">
                        <i class="fa fa-shopping-cart"></i>
                </span>
                <span class="cart-price">';
                    $button .= rcl_get_price($product_id);
                $button .= '</span>
            </a>';
             
        }else{
            
            $button .= '<span class="product-outsale">
                <i class="fa fa-refresh rcl-icon"></i>'.__('Not in the sale','wp-recall').'
            </span>';
            
        }

    }else{
        
        $text_button = apply_filters('rcl_text_cart_button',__('Not in the sale','wp-recall'),$product_id);
        $button .= '<span class="product-outsale">
            <i class="fa fa-refresh rcl-icon"></i>'.$text_button.'
        </span>';

    }
    
    $button .= '</div>';
    
    $button = apply_filters('rcl_cart_button',$button,$product_id);
    
    return $button;
}

add_filter('the_content','rcl_related_products',80);
function rcl_related_products($content){
	global $rmag_options,$productlist;$post;
        
	if($rmag_options['sistem_related_products']!=1) return $content;
        
	if(!isset($post)||$post->post_type!='products')return $content;
        
	$related = get_post_meta($post->ID,'related_products_recall',1);
        
	if(!$related||!is_array($related)) return $content;
        
        $productlist['desc'] = 200;
        
	$args = array(
            'numberposts' => $rmag_options['size_related_products'],
            'orderby'     => 'rand',
            'post_type'   => 'products',
            'exclude'     => $post->ID
	);
        
        foreach($related as $tax=>$id){
            if($id>0) 
                $args['tax_query'][] = array(
                        'taxonomy'=>$tax,
                        'field'=>'id',
                        'terms'=> $id
                    );
        }

	$related_products = get_posts($args);

	if(!$related_products) return $content;
        
        $title_related = $rmag_options['title_related_products_recall'];
        if($title_related) $content .= '<h3>'.$title_related.'</h3>';
        
	$content .='<div class="products-box type-slab">
                    <div class="products-list">';
        
	foreach($related_products as $post){ setup_postdata($post);
		$content .= rcl_get_include_template('product-slab.php',__FILE__);
	}
        wp_reset_query();

	$content .= '</div>'
                . '</div>';

	return $content;
}

add_filter('the_content','rcl_gallery_product',1);
function rcl_gallery_product($content){
global $post;
	if(get_post_type($post->ID)=='products'){
		if(get_post_meta($post->ID, 'recall_slider', 1)!=1||!is_single()) return $content;

		if(!class_exists( 'Attachments' )){
		$postmeta = get_post_meta($post->ID, 'children_prodimage', 1);

			if($postmeta){
                            rcl_bxslider_scripts();
				$values = explode(',',$postmeta);

				$gallery = '<div id="product-gallery">'
                                        . '<ul class="rcl-gallery">';
				foreach((array) $values as $children ){
					$large = wp_get_attachment_image_src( $children, 'large' );
					$gallery .= '<li><a class="fancybox" href="'.$large[0].'"><img src="'.$large[0].'"></a></li>';
					$thumbs[] = $large[0];
				}
				$gallery .= '</ul>';
				if(count($thumbs)>1){
					$gallery .= '<div id="bx-pager">';
						foreach($thumbs as $k=>$src ){
							$gallery .= '<a data-slide-index="'.$k.'" href=""><img src="'.$src.'" /></a>';
						}
					$gallery .= '</div>';
				}
                                $gallery .= '</div>';
			}
			return $gallery.$content;
		}else{
			$attachments = new Attachments( 'attachments_products' );

			if( $attachments->exist() ) :
                            rcl_bxslider_scripts();
				$num=0;
				$gallery = '<div id="product-gallery">'
                                        . '<ul class="rcl-gallery">';
			while( $attachments->get() ) :
				$num++;

				$large = wp_get_attachment_image_src( $children, 'large' );
				$gallery .= '<li><a class="fancybox" href="'.$attachments->src( 'full' ).'"><img src="'.$attachments->src( 'thumbnail' ).'"></a></li>';
				$thumbs[] = $large[0];

			endwhile;
				$gallery .= '</ul>';

				$gallery .= '<div id="bx-pager">';
					foreach($thumbs as $k=>$src ){
						$gallery .= '<a data-slide-index="'.$k.'" href=""><img src="'.$src.'" /></a>';
					}
				$gallery .= '</div>';
			endif;

                        $gallery .= '</div>';

			return $gallery.$content;
		}
	} else {
		return $content;
	}
}

//Выводим кнопку корзины в кратком содержании
add_filter('the_excerpt', 'rcl_excerpt_cart');
function rcl_excerpt_cart($excerpt){
    global $post;
    if($post->post_type=='products') $excerpt .= rcl_get_cart_button($post->ID);
    return $excerpt;
}

//Выводим категорию товара
add_filter('the_content','rcl_product_meta',10);
function rcl_product_meta($content){
    global $post;
    if($post->post_type!='products') return $content;
    $product_cat = rcl_get_product_category($post->ID);
    return $product_cat.$content;
}

//снимаем товар заказа с резерва
function rcl_remove_reserve($order_id,$st=0){
	global $rmag_options,$wpdb;
	if($rmag_options['products_warehouse_recall']!=1) return false;

	$orders = rcl_get_order($order_id);
        foreach((array)$orders as $sumproduct){
                $reserve = get_post_meta($sumproduct->product,'reserve_product',1);
                if($reserve){ //если резев имеется
                        $reserve = $reserve - "$sumproduct->count";//уменьшаем резерв
                        update_post_meta($sumproduct->product, 'reserve_product', $reserve);
                        if($st){
                                $amount = get_post_meta($sumproduct->product, 'amount_product', 1);
                                $amount = $amount + "$sumproduct->count";//увеличиваем наличие
                                update_post_meta($sumproduct->product, 'amount_product', $amount);
                        }
                }
        }

}