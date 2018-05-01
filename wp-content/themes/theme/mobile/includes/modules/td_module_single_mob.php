<?php
/**
 * Created by ra.
 * Date: 10/23/2015
 */

class td_module_single_mob extends td_module_single_base {

    /*
     * display number of comments on post single page
     */
    function get_comments() {
        $buffy = '';
        if (td_util::get_option('tds_p_show_comments') != 'hide') {
            $buffy .= '<div class="td-post-comments">';
            $buffy .= '<a href="' . get_comments_link($this->post->ID) . '"><i class="td-icon-commenting"></i>';
            $buffy .= get_comments_number($this->post->ID);
            $buffy .= '</a>';
            $buffy .= '</div>';
        }

        return $buffy;
    }


    /*
     * social share buttons - displayed on post single page at the top of the content
     */
    function get_social_sharing_top() {
        if (!$this->is_single) {
            return;
        }

        if (td_util::get_option('tds_top_social_show') == 'hide') {
            return;
        }

        $buffy = '';

        // @todo single-post-thumbnail appears to not be in used! please check
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->post->ID ), 'single-post-thumbnail' );

        $twitter_user = td_util::get_option('tds_tweeter_username');


        $buffy .= '<div class="td-post-sharing td-post-sharing-top">';

            /**
             * get Pinterest share description
             * get it from SEO by Yoast meta (if the plugin is active and the description is set) else use the post title
             */
            if (is_plugin_active('wordpress-seo/wp-seo.php') and get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true) != '') {
                $td_pinterest_share_description = get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true);
            } else{
                $td_pinterest_share_description = htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
            }

            $buffy .= '
				<div class="td-default-sharing">
		            <a class="td-social-sharing-buttons td-social-facebook" href="http://www.facebook.com/sharer.php?u=' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-facebook"></i></a>
		            <a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( esc_url( get_permalink() ) ) . '&via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '"  ><i class="td-icon-twitter"></i></a>
		            <a class="td-social-sharing-buttons td-social-google" href="http://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-googleplus"></i></a>
		            <a class="td-social-sharing-buttons td-social-pinterest" href="http://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink() ) . '&amp;media=' . ( ! empty( $image[0] ) ? $image[0] : '' ) . '&description=' . $td_pinterest_share_description . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-pinterest"></i></a>
		            <a class="td-social-sharing-buttons td-social-whatsapp" href="whatsapp://send?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '%20-%20' . urlencode( esc_url( get_permalink() ) ) . '" ><i class="td-icon-whatsapp"></i></a>
		        </div>';


        $buffy .= '</div>';

        return $buffy;
    }

    /*
     * social share buttons - displayed on post single page at the bottom of the content
     */
    function get_social_sharing_bottom() {
        if (!$this->is_single) {
            return;
        }

        if (td_util::get_option('tds_bottom_social_show') == 'hide') {
            return;
        }

        $buffy = '';
        // @todo single-post-thumbnail appears to not be in used! please check
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->post->ID ), 'single-post-thumbnail' );
        $buffy .= '<div class="td-post-sharing td-post-sharing-bottom">';

            $twitter_user = td_util::get_option( 'tds_tweeter_username' );

            /**
             * get Pinterest share description
             * get it from SEO by Yoast meta (if the plugin is active and the description is set) else use the post title
             */
            if (is_plugin_active('wordpress-seo/wp-seo.php') and get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true) != '') {
                $td_pinterest_share_description = get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true);
            } else{
                $td_pinterest_share_description = htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
            }

            //default share buttons
            $buffy .= '
            <div class="td-default-sharing">
	            <a class="td-social-sharing-buttons td-social-facebook" href="http://www.facebook.com/sharer.php?u=' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-facebook"></i></a>
	            <a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( esc_url( get_permalink() ) ) . '&via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '"><i class="td-icon-twitter"></i></a>
	            <a class="td-social-sharing-buttons td-social-google" href="http://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-googleplus"></i></a>
	            <a class="td-social-sharing-buttons td-social-pinterest" href="http://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink() ) . '&amp;media=' . ( ! empty( $image[0] ) ? $image[0] : '' ) . '&description=' . $td_pinterest_share_description . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-pinterest"></i></a>
	            <a class="td-social-sharing-buttons td-social-whatsapp" href="whatsapp://send?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '%20-%20' . urlencode( esc_url( get_permalink() ) ) . '" ><i class="td-icon-whatsapp"></i></a>
            </div>';

        $buffy .= '</div>';

        return $buffy;
    }


    /**
     * gets the related posts ONLY on single posts. Does not run on custom post types because we don't know what taxonomy to choose and the
     * blocks do not support custom taxonomies as of 15 july 2015
     *
     * $force_sidebar_position - not used on mobile theme
     *
     * @return string
     */
    function related_posts($force_sidebar_position = '') {
        global $post;
        if ($post->post_type != 'post') {
            return '';
        }

        if (td_util::get_option('tds_similar_articles') == 'hide') {
            return '';
        }

        //td_global::$cur_single_template_sidebar_pos;

        //cur_post_same_tags
        //cur_post_same_author
        //cur_post_same_categories

        if (td_util::get_option('tds_similar_articles_type') == 'by_tag') {
            $td_related_ajax_filter_type = 'cur_post_same_tags';
        } else {
            $td_related_ajax_filter_type = 'cur_post_same_categories';
        }

        // the number of rows to show. this number will be multiplied with the hardcoded limit
        $tds_similar_articles_rows = td_util::get_option('tds_similar_articles_rows');
        if (empty($tds_similar_articles_rows)) {
            $tds_similar_articles_rows = 1;
        }

        $td_related_limit = 3 * $tds_similar_articles_rows;


        /**
         * 'td_ajax_filter_type' => 'td_custom_related' - this ajax filter type overwrites the live filter via ajax @see td_ajax::on_ajax_block
         */
        $td_block_args = array (
            'limit' => $td_related_limit,
            'ajax_pagination' => 'next_prev',
            'live_filter' => $td_related_ajax_filter_type,  //live atts - this is the default setting for this block
            'td_ajax_filter_type' => 'td_custom_related' //this filter type can overwrite the live filter @see
        );

        /**
         * @see td_block_related_posts
         */

        return td_global_blocks::get_instance('td_block_related_posts_mob')->render($td_block_args);

    }


    /**
     * the content of a single post or single post type
     * @return mixed|string|void
     */
    function get_content() {

        /*  ----------------------------------------------------------------------------
            Prepare the content
        */
        $content = get_the_content(__td('Continue', TD_THEME_NAME));
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);



        /** ----------------------------------------------------------------------------
         * Smart list support. class_exists and new object WORK VIA AUTOLOAD
         * @see td_autoload_classes::loading_classes
         */
        //$td_smart_list = get_post_meta($this->post->ID, 'td_smart_list', true);
        $td_smart_list = get_post_meta($this->post->ID, 'td_post_theme_settings', true);
        if (!empty($td_smart_list['smart_list_template'])) {

            $td_smart_list_class = 'td_smart_list_mob_1';
            if (class_exists($td_smart_list_class)) {
                /**
                 * @var $td_smart_list_obj td_smart_list
                 */
                $td_smart_list_obj = new $td_smart_list_class();  // make the class from string * magic :)

                // prepare the settings for the smart list
                $smart_list_settings = array(
                    'post_content' => $content,
                    'counting_order_asc' => false,
                    'td_smart_list_h' => 'h3',
                    'extract_first_image' => td_api_smart_list::get_key($td_smart_list_class, 'extract_first_image')
                );

                if (!empty($td_smart_list['td_smart_list_order'])) {
                    $smart_list_settings['counting_order_asc'] = true;
                }

                if (!empty($td_smart_list['td_smart_list_h'])) {
                    $smart_list_settings['td_smart_list_h'] = $td_smart_list['td_smart_list_h'];
                }
                return $td_smart_list_obj->render_from_post_content($smart_list_settings);
            } else {
                // there was an error?
                td_util::error(__FILE__, 'Missing smart list: ' . $td_smart_list_class . '. Did you disabled a tagDiv plugin?');
            }
        }
        /*  ----------------------------------------------------------------------------
            end smart list - if we have a list, the function returns above
         */




        /*  ----------------------------------------------------------------------------
            ad support on content
        */

        //read the current ad settings
        $tds_inline_ad_paragraph_mob = td_util::get_option('tds_inline_ad_paragraph_mob');

        // add inline ad
        if ( is_single() ) {

            if (empty($tds_inline_ad_paragraph_mob)) {
                $tds_inline_ad_paragraph_mob = 0;
            }

            $cnt = 0;
            $content_buffer = ''; // we replace the content with this buffer at the end

            $content_parts = preg_split('/(<p.*>)/U', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

            $p_open_tag_count = 0; // count how many <p> tags we have added to the buffer

            foreach ($content_parts as $content_part_index => $content_part_value) {
                if (!empty($content_part_value)) {

                    // Show the ad ONLY IF THE CURRENT PART IS A <p> opening tag and before the <p> -> so we will have <p>content</p>  ~ad~ <p>content</p>
                    // and prevent cases like <p> ~ad~ content</p>
                    if (preg_match('/(<p.*>)/U', $content_part_value) === 1) {
                        if ($tds_inline_ad_paragraph_mob == $p_open_tag_count) {

                            $content_buffer .= td_global_blocks::get_instance('td_block_ad_box_mob')->render(array('spot_id' => 'content_inline_mob'));
                        }
                        $p_open_tag_count++;

                    }
                    $content_buffer .= $content_part_value;
                    $cnt++;

                }

            }
            $content = $content_buffer;
        }


        // add top ad
        if ( is_single() ) {
            $content = td_global_blocks::get_instance('td_block_ad_box_mob')->render(array('spot_id' => 'content_top_mob')) . $content;
        }


        //add bottom ad
        if ( is_single() ) {
            $content = $content . td_global_blocks::get_instance('td_block_ad_box_mob')->render(array('spot_id' => 'content_bottom_mob'));
        }


        return $content;
    }

}

