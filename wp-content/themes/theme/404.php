<?php

//set the template id, used to get the template specific settings
$template_id = '404';

td_global::$current_template = $template_id;

td_global::$load_featured_img_from_template = 'full';

//prepare the loop variables
global $loop_module_id, $loop_sidebar_position;
$loop_sidebar_position = 'no_sidebar';
$loop_module_id = td_util::get_option('tds_' . $template_id . '_page_layout', 1); //module 1 is default




get_header();

?>
<div class="td-main-content-wrap">
    <div class="td-container">
        <div class="td-pb-row">
            <div class="td-pb-span12">
                <div class="td-404-title">
                    <?php _etd('Ooops... Error 404', TD_THEME_NAME); ?>
                </div>

                <div class="td-404-sub-title">
                    <?php _etd('Sorry, but the page you are looking for doesn_t exist.', TD_THEME_NAME); ?>
                </div>

                <div class="td-404-sub-sub-title">
                    <?php _etd('You can go to the', ''); ?>
                    <a href="<?php echo esc_url(home_url( '/' )); ?>"><?php _etd('HOMEPAGE', TD_THEME_NAME); ?></a>

                </div>


                <h4 class="block-title"><span><?php echo __td('OUR LATEST POSTS', TD_THEME_NAME)?></span></h4>

                <?php


                $args = array(
                    'post_type'=> 'post',
                    'showposts' => 6
                );
                query_posts($args);


                $td_loop_block_module = td_util::get_option('tds_404_page_layout');
                //$td_loop_block_module


                locate_template('loop.php', true);
                //get_template_part('category', 'slider');
                wp_reset_query();

                ?>
            </div>
        </div> <!-- /.td-pb-row -->
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();
?>