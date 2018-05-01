<?php
// Template 11  -post-final-11.psd
//get the global sidebar position from td_single_template_vars.php

locate_template('includes/wp_booster/td_single_template_vars.php', true);

get_header();

global $loop_sidebar_position, $td_sidebar_position, $post;

$td_mod_single = new td_module_single($post);

?>
<article id="post-<?php echo $td_mod_single->post->ID;?>" class="<?php echo join(' ', get_post_class('td-post-template-11'));?>" <?php echo $td_mod_single->get_item_scope();?>>
    <div class="td-video-template-bg">
        <div class="td-container">
            <div class="td-pb-row">
                <div class="td-pb-span12 td-crumb-container"><?php echo td_page_generator::get_single_breadcrumbs($td_mod_single->title); ?></div>

                <div class="td-pb-span4 td-post-header">

                    <?php echo $td_mod_single->get_category(); ?>

                    <header class="td-post-title">
                        <?php echo $td_mod_single->get_title();?>


                        <?php if (!empty($td_mod_single->td_post_theme_settings['td_subtitle'])) { ?>
                            <p class="td-post-sub-title"><?php echo $td_mod_single->td_post_theme_settings['td_subtitle'];?></p>
                        <?php } ?>


                        <div class="td-module-meta-info">
                            <?php echo $td_mod_single->get_author();?>
                            <?php echo $td_mod_single->get_date(false);?>
                            <?php echo $td_mod_single->get_views();?>
                            <?php echo $td_mod_single->get_comments();?>
                        </div>
                    </header>


                    <?php
                    // ad spot
                    echo td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'post_style_11')); ?>

                </div>

                <div class="td-pb-span8 td-post-featured-video">
                    <?php
                    // override the default featured image by the templates (single.php and home.php/index.php - blog loop)
                    if (!empty(td_global::$load_featured_img_from_template)) {
                        echo $td_mod_single->get_image(td_global::$load_featured_img_from_template);
                    } else {
                        echo $td_mod_single->get_image('td_696x0');
                    }
                    ?>

                    <?php echo $td_mod_single->get_social_sharing_top();?>

                </div>
            </div>
        </div>
    </div>
    <div class="td-video-template-bg-small">
        <div class="td-container">
                  <?php echo $td_mod_single->related_posts('no_sidebar');?>
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
                                locate_template('loop-single-11.php', true);
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
                            locate_template('loop-single-11.php', true);
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
                    //td_global::$load_featured_img_from_template = 'art-slide-big';
                    td_global::$load_featured_img_from_template = 'full';
                    ?>
                    <div class="td-pb-span12 td-main-content" role="main">
                        <div class="td-ss-main-content">
                            <?php
                            locate_template('loop-single-11.php', true);
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