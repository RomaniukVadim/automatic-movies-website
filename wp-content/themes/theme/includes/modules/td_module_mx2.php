<?php

class td_module_mx2 extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?>">

            <?php echo $this->get_image('td_80x60');?>

            <div class="item-details">
                <?php echo $this->get_title();?>
                <div class="td-module-meta-info">
                    <?php if (td_util::get_option('tds_category_module_mx2') == 'yes') { echo $this->get_category(); }?>
                    <?php //echo $this->get_author();?>
                    <?php echo $this->get_date();?>
                    <?php //echo $this->get_comments();?>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}