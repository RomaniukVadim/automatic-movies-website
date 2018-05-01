<?php

class td_module_mob_1 extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <?php echo $this->get_image('td_265x198');?>
            <div class="item-details">
                <?php echo $this->get_title();?>

                <div class="td-module-meta-info">
                    <?php echo $this->get_category(); ?>
                    <?php echo $this->get_date();?>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}