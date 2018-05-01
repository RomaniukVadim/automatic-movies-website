<?php
/* Template Name: Pagebuilder + page title */


get_header();

td_global::$current_template = 'page-title-sidebar';
//set the template id, used to get the template specific settings
$template_id = 'page';


$loop_sidebar_position = td_util::get_option('tds_' . $template_id . '_sidebar_pos'); //sidebar right is default (empty)


//read the custom single post settings - this setting overids all of them
$td_page = get_post_meta($post->ID, 'td_page', true);
if (!empty($td_page['td_sidebar_position'])) {
    $loop_sidebar_position = $td_page['td_sidebar_position'];
}

// sidebar position used to align the breadcrumb on sidebar left + sidebar first on mobile issue
$td_sidebar_position = '';
if($loop_sidebar_position == 'sidebar_left') {
	$td_sidebar_position = 'td-sidebar-left';
}



    //no page builder detected, we load a default page template with sidebar / no sidebar
    ?>
<div class="td-main-content-wrap">
    <div class="td-container <?php echo $td_sidebar_position; ?>">
        <div class="td-crumb-container">
            <?php echo td_page_generator::get_page_breadcrumbs(get_the_title()); ?>
        </div>
        <div class="td-pb-row">
            <?php
            switch ($loop_sidebar_position) {
                default:
                    ?>
                        <div class="td-pb-span8 td-main-content" role="main">
                            <div class="td-ss-main-content">
                                <?php
                                if (have_posts()) {
                                while ( have_posts() ) : the_post();
                                ?>
                                <div class="td-page-header">
                                    <h1 class="entry-title td-page-title">
                                        <span><?php the_title() ?></span>
                                    </h1>
                                </div>
                                <div class="td-pb-padding-side td-page-content">
                                    <?php
                                    the_content();
                                    endwhile;//end loop
                                    }
                                    ?>
                                </div>
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

                            if (have_posts()) {
                            while ( have_posts() ) : the_post();
                            ?>
                            <div class="td-page-header">
                                <h1 class="entry-title td-page-title">
                                    <span><?php the_title() ?></span>
                                </h1>
                            </div>
                            <div class="td-pb-padding-side td-page-content">
                                <?php
                                the_content();
                                endwhile; //end loop
                                }
                                ?>
                            </div>
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
                            if (have_posts()) {
                            while ( have_posts() ) : the_post();
                            ?>
                            <div class="td-page-header">
                                <h1 class="entry-title td-page-title">
                                    <span><?php the_title() ?></span>
                                </h1>
                            </div>
                            <div class="td-pb-padding-side td-page-content">
                                <?php
                                the_content();
                                endwhile; //end loop
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
            }
            ?>
        </div> <!-- /.td-pb-row -->
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php




get_footer();
?>