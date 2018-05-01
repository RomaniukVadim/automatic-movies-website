<?php
/**
 * Created by PhpStorm.
 * User: tagdiv
 * Date: 03.02.2015
 * Time: 10:05
 */

/**
 * Class td_module_mx_empty
 *
 * This mx module is used to complete modules in the td_block_big_grid block,
 * which should use just td_module_mx5 and td_module_mx6
 */
class td_module_mx_empty extends td_module {

    function __construct() {}

    function render($order_no) {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes(array("td-big-grid-post-$order_no", "td-big-grid-post", "td-module-empty")); ?>">
            <div class="td-module-thumb"></div>
        </div>

        <?php return ob_get_clean();
    }
}