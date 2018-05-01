<?php

class td_module_18 extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <div class="meta-info-container">
                <div class="td-module-meta-info">
                    <?php if (td_util::get_option('tds_category_module_18') == 'yes') { echo $this->get_category(); }?>
                    <?php echo $this->get_title();?>
                    <?php echo $this->get_author();?>
                    <?php echo $this->get_date();?>
                    <?php echo $this->get_comments();?>
                </div>
                <?php echo $this->get_image('td_696x385');?>


                <div class="td-excerpt">
                    <?php echo $this->get_excerpt();?>
                </div>

                <div class="td-read-more">
                    <a href="<?php echo $this->href;?>"><?php echo __td('Read more', TD_THEME_NAME);?><i class="td-icon-menu-right"></i></a>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}