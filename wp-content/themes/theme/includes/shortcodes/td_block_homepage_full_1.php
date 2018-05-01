<?php

class td_block_homepage_full_1 extends td_block {


    function render($atts, $content = null) {
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)
        $buffy = ''; //output buffer
        $buffy .= '<div class="' . $this->get_block_classes() . '">';
        $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
        $buffy .= $this->inner($this->td_query->posts);//inner content of the block
        $buffy .= '</div>';
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {
        ob_start();
        if (!empty($posts[0])) {
            $post = $posts[0]; //we get only one post
           // $td_post_featured_image = td_util::get_featured_image_src($post->ID, 'full');
            $td_mod_single = new td_module_single($post);
            //make the js template
            ?>

            <!-- add class to body, no jQuery and inline -->
            <?php ob_start(); ?>
            <script>
                document.body.className+=' td-boxed-layout single_template_8 homepage-post ';
            </script>
            <?php echo(ob_get_clean()); ?>



            <script type="text/template" id="<?php echo $this->block_uid . '_tmpl' ?>">

                <article id="post-<?php echo $td_mod_single->post->ID;?>" class="<?php echo join(' ', get_post_class('post td-post-template-8'));?>" <?php echo $td_mod_single->get_item_scope();?>>
                    <div class="td-post-header td-image-gradient-style8">
                        <div class="td-crumb-container"><?php echo td_page_generator::get_single_breadcrumbs($td_mod_single->title); ?></div>

                        <div class="td-post-header-holder">

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
                </article>

            </script>






            <?php
            $td_post_featured_image = td_util::get_featured_image_src($post->ID, 'full');
            ob_start();
            ?>
            <script>
                // add the template
                jQuery( '.td-header-wrap' ).after( jQuery( '#<?php echo $this->block_uid ?>_tmpl' ).html() );

                // make the wrapper and the image -> and add the image inside
                var td_homepage_full_bg_image_wrapper = jQuery( '<div class="backstretch"></div>' );
                var td_homepage_full_bg_image = jQuery( '<img class="td-backstretch not-parallax" src="<?php echo $td_post_featured_image ?>"/>' );
                td_homepage_full_bg_image_wrapper.append(td_homepage_full_bg_image);

                // add to body
                jQuery('body').prepend( td_homepage_full_bg_image_wrapper );

                // run the backstracher
                var td_backstr_item = new tdBackstr.item();
                td_backstr_item.wrapper_image_jquery_obj = td_homepage_full_bg_image_wrapper;
                td_backstr_item.image_jquery_obj = td_homepage_full_bg_image;
                tdBackstr.add_item( td_backstr_item );

            </script>
            <?php
            $buffer = ob_get_clean();
            $js = "\n". td_util::remove_script_tag($buffer);
            td_js_buffer::add_to_footer($js);

        }
        return ob_get_clean();

    }
}