<?php

class td_module_14 extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <div class="meta-info-container">
                <?php echo $this->get_image('td_696x385');?>

                <div class="td-module-meta-info">
                    <div class="td-module-meta-holder">
                        <?php echo $this->get_title();?>
                        <?php if (td_util::get_option('tds_category_module_14') == 'yes') { echo $this->get_category(); }?>
                        <?php echo $this->get_author();?>
                        <?php echo $this->get_date();?>
                        <?php echo $this->get_comments();?>
                    </div>
                </div>
            </div>

            <div class="td-excerpt">
                <?php echo $this->get_excerpt();?>

                <div class="td-read-more">
                    <a href="<?php echo $this->href;?>"><?php echo __td('Read more', TD_THEME_NAME);?></a>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}