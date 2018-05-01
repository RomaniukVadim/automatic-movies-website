<?php
/*Шаблон для отображения содержимого шорткода basket - полной корзины пользователя*/
/*Данный шаблон можно разместить в папке используемого шаблона /wp-content/wp-recall/templates/ и он будет подключаться оттуда*/
?>
<?php global $products,$product,$CartData; ?>
<div id="cart-form" class="cart-data">
    <table class="order-data">
        <tr>
            <th class="product-name"><?php _e('Product','wp-recall'); ?></th>
            <th><?php _e('Price','wp-recall'); ?></th>
            <th class="product-number"><?php _e('Amount','wp-recall'); ?></th>
            <th><?php _e('Sum','wp-recall'); ?></th>
        </tr>
        <?php foreach($products as $product): rcl_setup_cartdata($product); ?>
            <tr id="product-<?php rcl_product_ID(); ?>">
                <td>
                    <a href="<?php rcl_product_permalink(); ?>"><?php rcl_product_title(); ?></a>
                    <?php rcl_product_excerpt(); ?>
                </td>
                <td><?php rcl_product_price(); ?></td>
                <td data-product="<?php rcl_product_ID(); ?>">
                        <a class="edit-num add-product" onclick="rcl_cart_add_product(this);return false;" href="#"><i class="fa fa-plus"></i></a>
                        <a class="edit-num remove-product" onclick="rcl_cart_remove_product(this);return false;" href="#"><i class="fa fa-minus"></i></a>
                        <span class="number-product"><?php rcl_product_number(); ?></span>
                </td>
                <td class="sumprice-product"><?php rcl_product_summ(); ?> <?php echo rcl_get_primary_currency(1); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="2"></th>
            <th><?php _e('Total amount','wp-recall'); ?></th>
            <th class="cart-summa"><?php echo $CartData->cart_price; ?> <?php echo rcl_get_primary_currency(1); ?></th>
        </tr>
    </table>
</div>
