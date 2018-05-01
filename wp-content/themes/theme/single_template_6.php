<?php
// Template 6 - post-final-6.psd - full image background
//get the global sidebar position from td_single_template_vars.php

locate_template('includes/wp_booster/td_single_template_vars.php', true);

get_header();

global $loop_sidebar_position, $td_sidebar_position, $post;

$td_mod_single = new td_module_single($post);

$td_post_featured_image = td_util::get_featured_image_src($post->ID, 'full');

if (!empty($td_post_featured_image)) {

	td_js_buffer::add_to_footer(
		'jQuery(window).ready(function() {' . "\r\n" .
			'(function(){' . "\r\n" .
				'var td_backstr_item = new tdBackstr.item();' . "\r\n" .

				'td_backstr_item.wrapper_image_jquery_obj = jQuery( "#td-full-screen-header-image" );' . "\r\n" .
				'td_backstr_item.image_jquery_obj = td_backstr_item.wrapper_image_jquery_obj.find( \'img:first\' );' . "\r\n" .

	            'tdBackstr.add_item( td_backstr_item );' . "\r\n" .
			'})();' . "\r\n" .
		'});'
	);
}

?>
<article id="post-<?php echo $td_mod_single->post->ID;?>" class="<?php echo join(' ', get_post_class('td-post-template-6'));?>" <?php echo $td_mod_single->get_item_scope();?>>

    <div class="td-full-screen-header-image-wrap">

        <div id="td-full-screen-header-image" class="td-image-gradient-style6">
            <img class="td-backstretch" src="<?php echo $td_post_featured_image; ?>">
        </div>

        <div class="td-container td-post-header">

            <div class="td-post-header-holder">
                <?php echo td_page_generator::get_single_breadcrumbs($td_mod_single->title); ?>

                <header class="td-post-title">

                    <?php echo $td_mod_single->get_category(); ?>
                    <?php echo $td_mod_single->get_title();?>


                    <?php if (!empty($td_mod_single->td_post_theme_settings['td_subtitle'])) { ?>
                        <p class="td-post-sub-title"><?php echo $td_mod_single->td_post_theme_settings['td_subtitle']; ?></p>
                    <?php } ?>


                    <div class="td-module-meta-info">
                        <?php echo $td_mod_single->get_author();?>
                        <?php echo $td_mod_single->get_date(false);?>
                        <?php echo $td_mod_single->get_views();?>
                        <?php echo $td_mod_single->get_comments();?>
                    </div>

                </header>
            </div>
        </div>

    </div>


    <div class="td-container">
        <div class="td-pb-row">
            <?php

            //the default template
            switch ($loop_sidebar_position) {
                default:
                    ?>
                        <div class="td-pb-span8 td-main-content" role="main">
                            <div class="td-ss-main-content">
                                <?php
                                locate_template('loop-single-6.php', true);
                                comments_template('', true);
                                ?>
                            </div>
                        </div>
                        <div class="td-pb-span4 td-main-sidebar" role="complementary">
                            <div class="td-ss-main-sidebar">
                                <?php get_sidebar(); ?>
                            </div>
                        </div>
                    <?php
                    break;

                case 'sidebar_left':
                    ?>
                    <div class="td-pb-span8 td-main-content <?php echo $td_sidebar_position; ?>-content" role="main">
                        <div class="td-ss-main-content">
                            <?php
                            locate_template('loop-single-6.php', true);
                            comments_template('', true);
                            ?>
                        </div>
                    </div>
	                <div class="td-pb-span4 td-main-sidebar" role="complementary">
		                <div class="td-ss-main-sidebar">
			                <?php get_sidebar(); ?>
		                </div>
	                </div>
                    <?php
                    break;

                case 'no_sidebar':
                    ?>
                    <div class="td-pb-span12 td-main-content" role="main">
                        <div class="td-ss-main-content">
                            <?php
                            locate_template('loop-single-6.php', true);
                            comments_template('', true);
                            ?>
                        </div>
                    </div>
                    <?php
                    break;

            }
            ?>
        </div> <!-- /.td-pb-row -->
    </div> <!-- /.td-container -->
</article> <!-- /.post -->

<?php

get_footer();