<?php
class td_category_template_6 extends td_category_template {

    function render() {
        ?>

        <!-- subcategory -->
        <div class="td-category-header td-image-gradient-style8">
            <div class="td-crumb-container"><?php echo parent::get_breadcrumbs(); ?></div>
            <div class="td-category-title-holder">

                <h1 class="entry-title td-page-title"><?php echo parent::get_title(); ?></h1>
                <?php echo parent::get_description(); ?>

            </div>
	        <div class="td-pulldown-container"><?php echo parent::get_pull_down(); ?></div>
        </div>

    <?php
    }
}
