<?php

/**
 * this module is similar to single
 * Class td_module_16
 */

class td_module_16 extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <?php echo $this->get_image('thumbnail');?>

            <div class="item-details">
                <?php echo $this->get_title();?>

                <div class="td-module-meta-info">
                    <?php if (td_util::get_option('tds_category_module_16') == 'yes') { echo $this->get_category(); }?>
                    <?php echo $this->get_author();?>
                    <?php echo $this->get_date();?>
                    <?php echo $this->get_comments();?>
                </div>

                <div class="td-excerpt">
                    <?php echo $this->get_excerpt();?>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }

}