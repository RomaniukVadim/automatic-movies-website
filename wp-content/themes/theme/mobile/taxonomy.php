<?php
/**
 * the custom taxonomy template
 * This file is loaded by WordPress on custom taxonomies. You can further customize this template
 * for specific taxonomies by copying this file to taxonomy-yourTaxonomyName.php
 */

get_header();

// get the current taxonomy object - note that it's note complete
$current_term_obj = get_queried_object();

?>

<div class="td-main-content-wrap">
    <div class="td-container">
        <div class="td-crumb-container">
            <?php echo td_page_generator_mob::get_taxonomy_breadcrumbs($current_term_obj); // get the breadcrumbs - /includes/wp_booster/td_page_generator.php ?>
        </div>

        <div class="td-main-content">
            <div class="td-page-header">
                <h1 class="entry-title td-page-title">
                    <span><?php echo $current_term_obj->name ?></span>
                </h1>
            </div>

            <?php

            locate_template('loop.php', true);

            echo td_page_generator_mob::get_pagination();
            ?>

        </div>
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();