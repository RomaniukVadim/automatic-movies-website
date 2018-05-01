<?php

class td_module_9 extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render() {
        ob_start();



        ?>

        <div class="<?php echo $this->get_module_classes();?>">

            <div class="item-details">
                <?php echo $this->get_comments();?>
                <?php echo $this->get_title();?>

                <?php if (td_util::get_option('tds_category_module_9') == 'yes') { echo $this->get_category(); }?>

                <div class="td-module-meta-info">
                    <?php echo $this->get_author();?>
                    <?php echo $this->get_date();?>
                </div>

            </div>

	        <?php echo $this->get_quotes_on_blocks();?>

        </div>

        <?php return ob_get_clean();
    }
}