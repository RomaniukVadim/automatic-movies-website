<?php
/**
 * Created by PhpStorm.
 * User: tagdiv
 * Date: 03.02.2015
 * Time: 10:05
 */

class td_module_mx9 extends td_module {

    function __construct($post) {
        parent::__construct($post);
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes(array("td-big-grid-post-0", "td-big-grid-post", "td-big-thumb")); ?>">
            <?php
                echo $this->get_image('td_741x486');
            ?>
            <div class="td-meta-info-container">
                <div class="td-meta-align">
                    <div class="td-big-grid-meta">
                        <?php if (td_util::get_option('tds_category_module_mx9') == 'yes') { echo $this->get_category(); }?>
                        <?php echo $this->get_title();?>
                    </div>
                    <div class="td-module-meta-info">
                        <?php echo $this->get_author();?>
                        <?php echo $this->get_date();?>
                    </div>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}