<?php
/*  ----------------------------------------------------------------------------
    the 404 template
 */

get_header();

?>
<div class="td-main-content-wrap">
    <div class="td-container">
        <div class="td-404-title">
            <?php _etd('Ooops... Error 404', TD_THEME_NAME); ?>
        </div>

        <div class="td-404-sub-title">
            <?php _etd('Sorry, but the page you are looking for doesn_t exist.', TD_THEME_NAME); ?>
        </div>

        <div class="td-404-sub-sub-title">
            <a href="<?php echo esc_url(home_url( '/' )); ?>"><?php _etd('HOMEPAGE', TD_THEME_NAME); ?></a>
        </div>

        <h4 class="block-title"><span><?php echo __td('OUR LATEST POSTS', TD_THEME_NAME)?></span></h4>

        <?php
        $args = array(
            'post_type'=> 'post',
            'showposts' => 6
        );
        query_posts($args);

        locate_template('loop.php', true);

        wp_reset_query();

        ?>
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();