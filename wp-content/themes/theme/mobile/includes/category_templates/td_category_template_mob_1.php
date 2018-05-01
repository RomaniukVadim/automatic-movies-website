<?php
class td_category_template_mob_1 extends td_category_template {

    function render() {
        ?>

        <!-- subcategory -->
        <div class="td-category-header">
            <div class="td-container">
                <div class="td-crumb-container"><?php echo parent::get_breadcrumbs(); ?></div>
                <h1 class="entry-title td-page-title"><?php echo parent::get_title(); ?></h1>
                <?php echo parent::get_sibling_categories(); ?>
                <?php echo parent::get_description(); ?>
            </div>
        </div>

        <?php
    }
}
