<?php
class td_category_template_5 extends td_category_template {

    function render() {
        ?>

        <!-- subcategory -->
        <div class="td-category-header">
        <div class="td-scrumb-holder">
            <div class="td-container">
                <div class="td-pb-row">
                    <div class="td-pb-span12">
                        <div class="td-crumb-container"><?php echo parent::get_breadcrumbs(); ?></div>
                    </div>
                </div>
                <?php echo parent::get_pull_down(); ?>
            </div>
        </div>

            <div class="td-container">
                <div class="td-pb-row">
                    <div class="td-pb-span12">

                        <h1 class="entry-title td-page-title"><?php echo parent::get_title(); ?></h1>
                        <?php echo parent::get_description(); ?>

                    </div>
                </div>
            </div>
        </div>

    <?php
    }
}
