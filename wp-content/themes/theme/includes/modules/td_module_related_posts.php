<?php

class td_module_related_posts extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes(array("td_mod_related_posts")); ?>">
            <div class="td-module-image">
                <?php echo $this->get_image('td_218x150');?>
                <?php if (td_util::get_option('tds_category_module_related_posts') == 'yes') { echo $this->get_category(); }?>
            </div>
            <div class="item-details">
                <?php echo $this->get_title();?>
            </div>
        </div>
        <?php return ob_get_clean();
    }
}