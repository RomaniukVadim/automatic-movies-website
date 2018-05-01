<?php
/*  ----------------------------------------------------------------------------
    the category template
 */

get_header();

td_api_category_template::render_category_template_by_id('td_category_template_mob_1');

$td_category_top_posts_style_mob_1 = new td_category_top_posts_style_mob_1();
$td_category_top_posts_style_mob_1->show_top_posts();

?>

<div class="td-main-content-wrap">
    <div class="td-container">
        <?php
        locate_template('loop.php', true);

        td_page_generator_mob::get_pagination();

        ?>
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();