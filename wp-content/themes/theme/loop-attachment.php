<?php

$td_att_url = '';
$td_att_alt = '';

if (have_posts()) {
    while ( have_posts() ) : the_post();



        if ( wp_attachment_is_image( $post->id ) ) {
            $td_att_image = wp_get_attachment_image_src( $post->id, 'full');

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
    echo td_page_generator::no_posts();
}



