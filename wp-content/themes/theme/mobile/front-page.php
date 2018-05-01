<?php
/* Home page */

get_header();

// display - Your latest posts
// @see https://codex.wordpress.org/Function_Reference/is_home
if ('posts' == get_option('show_on_front')) {

    ?>
    <div class="td-main-content-wrap td-blog-index">
        <div class="td-container">
            <div class="td-crumb-container">
                <?php echo td_page_generator_mob::get_home_breadcrumbs(); ?>
            </div>
            <div class="td-main-content">
                <?php
                locate_template('loop.php', true);
                echo td_page_generator_mob::get_pagination();
                ?>
            </div>
        </div> <!-- /.td-container -->
    </div> <!-- /.td-main-content-wrap -->
    <?php

// display - A static page
} elseif (('page' == get_option('show_on_front')) && is_front_page()) {

	//prepare the loop variables
	global $paged;

	$td_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
    $td_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var

    //paged works on single pages, page - works on homepage
    $paged = max( $td_page, $td_paged );

    $td_list_custom_title =__td('LATEST ARTICLES', TD_THEME_NAME);
    ?>

    <div class="td-main-content-wrap td-main-page-wrap">

        <?php
        // display Big Grid Mob 1 and the content at the top of the page
        if ( empty( $paged ) or $paged < 2 ) { //show this only on the first page
            if ( have_posts() ) { ?>
                <?php while ( have_posts() ) : the_post(); ?>

                    <div class="td-container">
                        <?php echo do_shortcode('[td_block_big_grid_mob_1 sort="featured"]'); ?>
                        <?php the_content(); ?>
                    </div>

                <?php endwhile; ?>
            <?php }
        }
        ?>

        <div class="td-container td-pb-article-list td-main-content" role="main">
            <?php if ( empty( $paged ) or $paged < 2 ) { ?>
                <h4 class="block-title"><span><?php echo $td_list_custom_title; ?></span></h4>
            <?php }

            $posts_per_page = get_query_var('posts_per_page') ? get_query_var('posts_per_page') : 10;

            // query used on Latest Articles section
            $wp_query_args = array(
                'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
            );
            query_posts($wp_query_args);

            locate_template('loop.php', true);
            echo td_page_generator_mob::get_pagination();
            wp_reset_query();
            ?>
        </div>
    </div>
<?php

}

get_footer();