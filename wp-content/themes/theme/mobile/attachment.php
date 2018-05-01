<?php
/*  ----------------------------------------------------------------------------
    the attachment template
 */

global $post;

get_header();
?>

<div class="td-main-content-wrap">
    <div class="td-container">
        <div class="td-crumb-container">
            <?php
            if (!empty($post->post_parent) and !empty($post->post_title)) {
                echo td_page_generator_mob::get_attachment_breadcrumbs($post->post_parent, $post->post_title);
            }
            ?>
        </div>
        <div class="td-main-content">
            <?php
            if (is_single()) {?>
                <h1 class="entry-title td-page-title">
                <span><?php the_title(); ?></span>
                </h1><?php
            } else {?>
                <h1 class="entry-title td-page-title">
                <a href="<?php ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                </h1><?php
            }


            // The loop attachment

            $td_att_url = '';
            $td_att_alt = '';

            if (have_posts()) {
	            while (have_posts()) : the_post();
		            if (wp_attachment_is_image($post->id)) {
			            $td_att_image = wp_get_attachment_image_src($post->id, 'full');

			            if (!empty($td_att_image[0])) {
				            $td_att_url = $td_att_image[0];
			            }

			            if (empty($td_att_image[0])) {
				            $td_att_image[0] = ''; //init the variable to not have problems
			            }

			            $td_image_data = td_util::get_image_attachment_data($post->post_parent);
			            if (!empty($td_image_data->alt)) {
				            $td_att_alt = $td_image_data->alt;
			            }

			            ?>
			            <a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment"><img class="td-attachment-page-image" src="<?php echo $td_att_image[0];?>" alt="<?php echo $td_att_alt ?>" /></a>

			            <div class="td-attachment-page-content">
				            <?php the_content(); ?>
			            </div>
		            <?php
		            }
	            endwhile; //end loop

            } else {
	            //no posts
	            echo td_page_generator_mob::no_posts();
            }
            ?>

            <div class="td-attachment-prev"><?php previous_image_link(); ?></div>
            <div class="td-attachment-next"><?php next_image_link(); ?></div>
        </div>
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();