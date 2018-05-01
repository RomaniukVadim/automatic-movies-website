<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

get_header();
?>

<div class="td-main-content-wrap td-main-page-wrap">
    <div class="td-container">
        <div class="td-main-content">
            <?php
            woocommerce_breadcrumb();
            woocommerce_content();
            ?>
        </div>
    </div>
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();
?>