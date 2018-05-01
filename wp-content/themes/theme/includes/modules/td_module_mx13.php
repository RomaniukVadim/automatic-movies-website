<?php
/**
 * Created by PhpStorm.
 * User: tagdiv
 * Date: 03.02.2015
 * Time: 10:05
 */

class td_module_mx13 extends td_module {

    function __construct($post) {
        parent::__construct($post);
    }

    function render($order_no) {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes(array("td-big-grid-post-$order_no", "td-big-grid-post", "td-tiny-thumb")); ?>">
            <?php
                echo $this->get_image('td_218x150');
            ?>
            <div class="td-meta-info-container">
                <div class="td-meta-align">
                    <div class="td-big-grid-meta">
                        <?php if (td_util::get_option('tds_category_module_mx13') == 'yes') { echo $this->get_category(); }?>
                        <?php echo $this->get_title();?>
                    </div>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}