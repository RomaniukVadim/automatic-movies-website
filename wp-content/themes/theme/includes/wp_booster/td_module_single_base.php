<?php
/**
 * Created by ra on 2/20/2015.
 */
class td_module_single_base extends td_module {

    var $td_post_theme_settings;

    var $is_single; //true if we are on a single page



    function __construct($post = '') {

        //run the parent constructor
        parent::__construct($post);

        //read post settings
        $this->td_post_theme_settings = get_post_meta($post->ID, 'td_post_theme_settings', true);

        $this->is_single = is_single();
    }




    function get_post_pagination() {
        if (!$this->is_single) {
            return '';
        }
        return wp_link_pages(array(
            'before' => '<div class="page-nav page-nav-post td-pb-padding-side">',
            'after' => '</div>',
            'link_before' => '<div>',
            'link_after' => '</div>',
            'echo' => false,
            'nextpagelink'     => '<i class="td-icon-menu-right"></i>',
            'previouspagelink' => '<i class="td-icon-menu-left"></i>'
        ));
    }


    /**
     * Gets the article title on single pages and on modules that use this class as a base (module15 on Newsmag for example).
     * @param string $cut_at - not used, it's added to maintain strict standards
     * @return string
     */
    function get_title($cut_at = '') {
        $buffy = '';
        if (!empty($this->title)) {
            $buffy .= '<h1 class="entry-title">';
            if ($this->is_single === true) {
                $buffy .= $this->title;
            } else {
                $buffy .='<a href="' . $this->href . '" rel="bookmark" title="' . $this->title_attribute . '">';
                $buffy .= $this->title;
                $buffy .='</a>';
            }
            $buffy .= '</h1>';
        }

        return $buffy;
    }

    //$show_stars_on_review - not used
    function get_author() {
        $buffy = '';
        if (td_util::get_option('tds_p_show_author_name') != 'hide') {
            $buffy .= '<div class="td-post-author-name">' . __td('By', TD_THEME_NAME) . ' ';
            $buffy .= '<a href="' . get_author_posts_url($this->post->post_author) . '">' . get_the_author_meta('display_name', $this->post->post_author) . '</a>' ;

            if (td_util::get_option('tds_p_show_author_name') != 'hide' and td_util::get_option('tds_p_show_date') != 'hide') {
                $buffy .= ' - ';
            }
            $buffy .= '</div>';
        }
        return $buffy;
    }


    /**
     * v3 23 ian 2015
     * @param $thumbType
     * @return string
     */
    function get_image($thumbType) {
        global $page;


//        if ( //check to see if the current single template is configured to show the featured image on the second page
//            !isset( td_global::$single_templates_list[td_global::$cur_single_template]['show_featured_image_on_all_pages'] )
//            or td_global::$single_templates_list[td_global::$cur_single_template]['show_featured_image_on_all_pages'] === false
//        ){

        if (td_api_single_template::_check_show_featured_image_on_all_pages(td_global::$cur_single_template) === false) {
            //the post is configured to show the featured image only on the first page
            if (!empty($page) and $page > 1) {
                return '';
            }
        }


        //do not show the featured image if the global setting is set to hide - show the video preview regardless of the setting
        if (td_util::get_option('tds_show_featured_image') == 'hide' and get_post_format($this->post->ID) != 'video') {
            return '';
        }


        //handle video post format
        if (get_post_format($this->post->ID) == 'video') {
            //if it's a video post...
            $td_post_video = get_post_meta($this->post->ID, 'td_post_video', true);

            //render the video if the post has a video in the featured video section of the post
            if (!empty($td_post_video['td_video'])) {
                return td_video_support::render_video($td_post_video['td_video']);
            }
        } else {
            //if it's a normal post, show the default thumb

            if (!is_null($this->post_thumb_id)) {
                //get the featured image id + full info about the 640px wide one
                $featured_image_id = get_post_thumbnail_id($this->post->ID);
                $featured_image_info = td_util::attachment_get_full_info($featured_image_id, $thumbType);

                //get the full size for the popup
                $featured_image_full_size_src = td_util::attachment_get_src($featured_image_id, 'full');

                $buffy = '';

                $show_td_modal_image = td_util::get_option('tds_featured_image_view_setting') ;

                if (is_single()) {
                    if ($show_td_modal_image != 'no_modal') {
                        //wrap the image_html with a link + add td-modal-image class
                        $image_html = '<a href="' . $featured_image_full_size_src['src'] . '" data-caption="' . esc_attr($featured_image_info['caption'], ENT_QUOTES) . '">';
                        $image_html .= '<img width="' . $featured_image_info['width'] . '" height="' . $featured_image_info['height'] . '" class="entry-thumb td-modal-image" src="' . $featured_image_info['src'] . '" alt="' . $featured_image_info['alt']  . '" title="' . $featured_image_info['title'] . '"/>';
                        $image_html .= '</a>';
                    } else { //no_modal
                        $image_html = '<img width="' . $featured_image_info['width'] . '" height="' . $featured_image_info['height'] . '" class="entry-thumb" src="' . $featured_image_info['src'] . '" alt="' . $featured_image_info['alt']  . '" title="' . $featured_image_info['title'] . '"/>';
                    }
                } else {
                    //on blog index page
                    $image_html = '<a href="' . $this->href . '"><img width="' . $featured_image_info['width'] . '" height="' . $featured_image_info['height'] . '" class="entry-thumb" src="' . $featured_image_info['src'] . '" alt="' . $featured_image_info['alt']  . '" title="' . $featured_image_info['title'] . '"/></a>';
                }


                $buffy .= '<div class="td-post-featured-image">';

                // caption - put html5 wrapper on when we have a caption
                if (!empty($featured_image_info['caption'])) {
                    $buffy .= '<figure>';
                    $buffy .= $image_html;

                    $buffy .= '<figcaption class="wp-caption-text">' . $featured_image_info['caption'] . '</figcaption>';
                    $buffy .= '</figure>';
                } else {
                    $buffy .= $image_html;
                }

                $buffy .= '</div>';


                return $buffy;
            } else {
                return ''; //the post has no thumb
            }
        }
    }


    /**
     * get the category spot of the single post / single post type
     * @return string - the html of the spot
     */
    function get_category() {
        $terms_ui_array  = array();


        if ($this->post->post_type != 'post') {

            // CUSTOM POST TYPES - on custom post types, we retrieve the taxonomy setting from the panel and we show
            // only the ones that are selected in wp-admin, just like a normal theme
            $category_spot_taxonomy = td_util::get_ctp_option($this->post->post_type, 'tds_category_spot_taxonomy');
            $terms_for_category_spot = wp_get_post_terms($this->post->ID, $category_spot_taxonomy);
            foreach ($terms_for_category_spot as $term_for_category_spot) {
                $term_for_category_spot_url = get_term_link($term_for_category_spot, $category_spot_taxonomy);
                if (!is_wp_error($term_for_category_spot_url)) {
                    $terms_ui_array[ $term_for_category_spot->name ]  = array(
                        'color'        => '',
                        'link'         => $term_for_category_spot_url,
                        'hide_on_post' => ''
                    );
                }
            }

        } else {
            // POST TYPE - here we work with categories
            // NOTE: due to legacy, the theme also outputs the parent of the first category if available
            $categories = get_the_category( $this->post->ID );
            if (!empty($categories)) {
                foreach ( $categories as $category ) {
                    if ( $category->name != TD_FEATURED_CAT ) { //ignore the featured category name
                        //get the parent of this cat
                        $td_parent_cat_obj = get_category( $category->category_parent );

                        //if we have a parent and the default category display is disabled show it first
                        if ( ! empty( $td_parent_cat_obj->name ) and td_util::get_option('tds_default_category_display') != 'true') {
                            $tax_meta__color_parent                = td_util::get_category_option( $td_parent_cat_obj->cat_ID, 'tdc_color' );//swich by RADU A, get_tax_meta($td_parent_cat_obj->cat_ID,'tdc_color');
                            $tax_meta__hide_on_post_parent         = td_util::get_category_option( $td_parent_cat_obj->cat_ID, 'tdc_hide_on_post' );//swich by RADU A, get_tax_meta($td_parent_cat_obj->cat_ID,'tdc_hide_on_post');
                            $terms_ui_array[ $td_parent_cat_obj->name ] = array(
                                'color'        => $tax_meta__color_parent,
                                'link'         => get_category_link( $td_parent_cat_obj->cat_ID ),
                                'hide_on_post' => $tax_meta__hide_on_post_parent
                            );
                        }

                        //show the category, only if we didn't already showed the parent
                        $tax_meta_color                = td_util::get_category_option( $category->cat_ID, 'tdc_color' );//swich by RADU A, get_tax_meta($category->cat_ID,'tdc_color');
                        $tax_meta__hide_on_post_parent = td_util::get_category_option( $category->cat_ID, 'tdc_hide_on_post' );//swich by RADU A, get_tax_meta($category->cat_ID,'tdc_hide_on_post');
                        $terms_ui_array[ $category->name ]  = array(
                            'color'        => $tax_meta_color,
                            'link'         => get_category_link( $category->cat_ID ),
                            'hide_on_post' => $tax_meta__hide_on_post_parent
                        );
                    }
                }
            }
        }


        /**
         * output stage
         *  we go in with an array of:
         *   array (
         *       $terms_ui_array[category_name] = array (
         *              'color' => '',
         *              'link' => ''
         *              'hide_on_post'
         *       )
         *   )
         */
        $buffy = '';
        if (td_util::get_option('tds_p_categories_tags') != 'hide') {
            $buffy .= '<ul class="td-category">';


            foreach ( $terms_ui_array as $term_name => $term_params ) {
                if ( $term_params['hide_on_post'] == 'hide' ) {
                    continue;
                }

                if ( ! empty( $term_params['color'] ) ) {
                    // set title color based on background color contrast
                    $td_cat_title_color = td_util::readable_colour($term_params['color'], 200, 'rgba(0, 0, 0, 0.9)', '#fff');
                    $td_cat_color = ' style="background-color:' . $term_params['color'] . '; color:' . $td_cat_title_color . '; border-color:' . $term_params['color']  . ';"';
                } else {
                    $td_cat_color = '';
                }


                $buffy .= '<li class="entry-category"><a ' . $td_cat_color . ' href="' . $term_params['link'] . '">' . $term_name . '</a></li>';
            }
            $buffy .= '</ul>';
        }

        return $buffy;
    }


    function get_comments() {
        $buffy = '';
        if (td_util::get_option('tds_p_show_comments') != 'hide') {
            $buffy .= '<div class="td-post-comments">';
            $buffy .= '<a href="' . get_comments_link($this->post->ID) . '"><i class="td-icon-comments"></i>';
            $buffy .= get_comments_number($this->post->ID);
            $buffy .= '</a>';
            $buffy .= '</div>';
        }

        return $buffy;
    }

    function get_views() {
        $buffy = '';
        if (td_util::get_option('tds_p_show_views') != 'hide') {
            $buffy .= '<div class="td-post-views">';
            $buffy .= '<i class="td-icon-views"></i>';
            // WP-Post Views Counter
            if (function_exists('the_views')) {
                $post_views = the_views(false);
                $buffy .= $post_views;
            }
            // Default Theme Views Counter
            else {
                $buffy .= '<span class="td-nr-views-' . $this->post->ID . '">' . td_page_views::get_page_views($this->post->ID) .'</span>';
            }

            $buffy .= '</div>';
        }
        return $buffy;
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

            $td_smart_list_class = $td_smart_list['smart_list_template'];
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
        $tds_inline_ad_paragraph = td_util::get_option('tds_inline_ad_paragraph');
        $tds_inline_ad_align = td_util::get_option('tds_inline_ad_align');


        //add the inline ad
        if (td_util::is_ad_spot_enabled('content_inline') and is_single()) {

            if (empty($tds_inline_ad_paragraph)) {
                $tds_inline_ad_paragraph = 0;
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
                        if ($tds_inline_ad_paragraph == $p_open_tag_count) {
                            switch ($tds_inline_ad_align) {
                                case 'left':
                                    $content_buffer .= td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline', 'align' => 'left'));
                                    break;

                                case 'right':
                                    $content_buffer .= td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline', 'align' => 'right'));
                                    break;

                                default:
                                    $content_buffer .= td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline'));
                                    break;
                            }
                        }
                        $p_open_tag_count ++;
                    }
                    $content_buffer .= $content_part_value;
                    $cnt++;
                }
            }
            $content = $content_buffer;
        }

        $td_display_top_ad = true;
        //disable the top ad on post template 1, it breaks the layout, the top image and ad should float on the left side of the content
        if (isset($td_smart_list['td_post_template']) && $td_smart_list['td_post_template'] == 'single_template_1') {
            $td_display_top_ad = false;

        //if the post individual template is not set, check the global settings, if template 1 is set disable the top ad
        } elseif (empty($td_smart_list['td_post_template'])) {
            $td_default_site_post_template = td_util::get_option('td_default_site_post_template');
            if(!empty($td_default_site_post_template) and $td_default_site_post_template == 'single_template_1') {
                $td_display_top_ad = false;
            }
        }

        //add the top ad
        if (td_util::is_ad_spot_enabled('content_top') && is_single() && $td_display_top_ad === true) {
            $content = td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_top')) . $content;
        }


        //add bottom ad
        if (td_util::is_ad_spot_enabled('content_bottom') && is_single()) {
            $content = $content . td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_bottom'));
        }


        return $content;
    }


    /**
     * returns the item scope for single pages. If we have an article or a review
     * @return string
     */
    function get_item_scope() {
        //show the review meta only on single posts that are reviews, the rest have to be article (in article lists)
        if ($this->is_review && is_single()) {
            return 'itemscope itemtype="' . td_global::$http_or_https . '://schema.org/Review"';
        } else {
            return 'itemscope itemtype="' . td_global::$http_or_https . '://schema.org/Article"';
        }
    }


    /**
     * This method outputs the item scope for SINGLE templates. If you are looking for the modules @see td_module::get_item_scope_meta()
     * @updated 23 july 2015
     *  - if the module that uses this class is not on a single page, we use the @see td_module::get_item_scope_meta() this allows
     * us to output normal module item scope insted of no item scope like it was before this update
     * @updated 16 december 2015
     * - removed structured data from modules, now it displays only on single and it returns the current post data
     * - no more interference with the itemprop's coming from modules
     * - all single structured data is now gathered here
     * @return string
     */
    function get_item_scope_meta() {

        // don't display meta on pages
        if (!is_single()) {
            return '';
        }

        // determine publisher name - use author name if there's no blog name
        $td_publisher_name = get_bloginfo('name');
        if (empty($td_publisher_name)){
            $td_publisher_name = esc_attr(get_the_author_meta('display_name', $this->post->post_author));
        }
        // determine publisher logo
        $td_publisher_logo = td_util::get_option('tds_logo_upload');

        $buffy = ''; //the vampire slayer

        // author
        $buffy .= '<span style="display: none;" itemprop="author" itemscope itemtype="https://schema.org/Person">' ;
        $buffy .= '<meta itemprop="name" content="' . esc_attr(get_the_author_meta('display_name', $this->post->post_author)) . '">' ;
        $buffy .= '</span>' ;

        // datePublished
        $td_article_date_unix = get_the_time('U', $this->post->ID);
        $buffy .= '<meta itemprop="datePublished" content="' . date(DATE_W3C, $td_article_date_unix) . '">';

        // dateModified
        $buffy .= '<meta itemprop="dateModified" content="' . the_modified_date('c', '', '', false) . '">';

        // mainEntityOfPage
        $buffy .= '<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="' . get_permalink($this->post->ID) .'"/>';

        // publisher
        $buffy .= '<span style="display: none;" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
        $buffy .= '<span style="display: none;" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">';
        $buffy .= '<meta itemprop="url" content="' . $td_publisher_logo . '">';
        $buffy .= '</span>';
        $buffy .= '<meta itemprop="name" content="' . $td_publisher_name . '">';
        $buffy .= '</span>';

        // headline @todo we may improve this one to use the subtitle or excerpt? - We could not find specs about what it should be.
        $buffy .= '<meta itemprop="headline " content="' . esc_attr( $this->post->post_title) . '">';

        // featured image
        $td_image = array();
        if (!is_null($this->post_thumb_id)) {
            /**
             * from google documentation:
             * A URL, or list of URLs pointing to the representative image file(s). Images must be
             * at least 160x90 pixels and at most 1920x1080 pixels.
             * We recommend images in .jpg, .png, or. gif formats.
             * https://developers.google.com/structured-data/rich-snippets/articles
             */
            $td_image = wp_get_attachment_image_src($this->post_thumb_id, 'full');

        } else {
            // when the post has no image use the placeholder
            $td_image[0] = get_template_directory_uri() . '/images/no-thumb/td_meta_replacement.png';
            $td_image[1] = '1068';
            $td_image[2] = '580';
        }

        // ImageObject meta
        if (!empty($td_image[0])) {
            $buffy .= '<span style="display: none;" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';
            $buffy .= '<meta itemprop="url" content="' . $td_image[0] . '">';
            $buffy .= '<meta itemprop="width" content="' . $td_image[1] . '">';
            $buffy .= '<meta itemprop="height" content="' . $td_image[2] . '">';
            $buffy .= '</span>';
        }

        // if we have a review, we must add additional stuff
        if ($this->is_review) {

            // the item that is reviewd
            $buffy .= '<span style="display: none;" itemprop="itemReviewed" itemscope itemtype="https://schema.org/Thing">';
            $buffy .= '<meta itemprop="name " content = "' . $this->title_attribute . '">';
            $buffy .= '</span>';

            if (!empty($this->td_review['review'])) {
                $buffy .= '<meta itemprop="reviewBody" content = "' . esc_attr($this->td_review['review']) . '">';
            } else {
                //we have no review text :| get a excerpt for the about meta thing
                if ($this->post->post_excerpt != '') {
                    $td_post_excerpt = $this->post->post_excerpt;
                } else {
                    $td_post_excerpt = td_util::excerpt($this->post->post_content, 45);
                }
                $buffy .= '<meta itemprop="reviewBody" content = "' . esc_attr($td_post_excerpt) . '">';
            }

            // review rating
            $buffy .= '<span style="display: none;" class="td-page-meta" itemprop="reviewRating" itemscope itemtype="' . td_global::$http_or_https . '://schema.org/Rating">';
            $buffy .= '<meta itemprop="worstRating" content = "1">';
            $buffy .= '<meta itemprop="bestRating" content = "5">';
            $buffy .= '<meta itemprop="ratingValue" content = "' . td_review::calculate_total_stars($this->td_review) . '">';
            $buffy .= ' </span>';
        }
        return $buffy;
    }


    /**
     * returns the review at the bottom of single posts and single posts types
     * @return string
     */
    function get_review() {
        if (!$this->is_single) {
            return '';
        }

        if ($this->is_review) {
            //print_r($this->td_review);
            $buffy = '';
            $buffy .= td_review::render_table($this->td_review);



            return $buffy;
        }

    }


    /**
     * gets the source and via spot on single posts and single custom post types
     * @return string|void
     */
    function get_source_and_via() {
        if (!$this->is_single) {
            return;
        }


        $buffy ='';

        //via and source
        if (!empty($this->td_post_theme_settings['td_source']) or !empty($this->td_post_theme_settings['td_via'])) {
            $via_url = '#';
            $source_url = '#';

            // used to check is post have tags to align the source and via container
            $td_no_tags = '';
            if (!has_tag()) {
                $td_no_tags = 'td-no-tags';
            }

            if (!empty($this->td_post_theme_settings['td_via_url'])) {
                $via_url = $this->td_post_theme_settings['td_via_url'];
            }

            if (!empty($this->td_post_theme_settings['td_source_url'])) {
                $source_url = $this->td_post_theme_settings['td_source_url'];
            }

            $buffy .= '<div class="td-post-source-via ' . $td_no_tags . '">';
            if (!empty($this->td_post_theme_settings['td_via'])) {
                $buffy .= '<div class="td-post-small-box"><span>' . __td('VIA', TD_THEME_NAME) . '</span><a rel="nofollow" href="' . esc_url($via_url) . '">' . $this->td_post_theme_settings['td_via'] . '</a></div>';
            }

            if (!empty($this->td_post_theme_settings['td_source'])) {
                $buffy .= '<div class="td-post-small-box"><span>' . __td('SOURCE', TD_THEME_NAME) . '</span><a rel="nofollow" href="' . esc_url($source_url) . '">' . $this->td_post_theme_settings['td_source'] . '</a></div>';
            }
            $buffy .= '</div>';
        }


        return $buffy;
    }


    /**
     * get the tags spot of the single post or single custom post type
     * @return string
     */
    function get_the_tags() {
        if (td_util::get_option('tds_show_tags') == 'hide') {
            return '';
        }

        $buffy = '';

        $terms_ui_array = array();
        $tags_spot_text = __td('TAGS', TD_THEME_NAME); // the default text for tags - on CPT we can overwrite this via the panel

        if ($this->post->post_type != 'post') {
            // on custom post types we need to read what to show in the tag spot from the panel
            $tag_spot_taxonomy = td_util::get_ctp_option($this->post->post_type, 'tds_tag_spot_taxonomy');
            $terms_for_tag_spot = wp_get_post_terms($this->post->ID, $tag_spot_taxonomy);
            foreach ($terms_for_tag_spot as $term_for_tag_spot) {
                $term_for_tag_spot_url = get_term_link($term_for_tag_spot, $tag_spot_taxonomy);
                if (!is_wp_error($term_for_tag_spot_url)) {
                    $terms_ui_array[ $term_for_tag_spot->name ]  = array(
                        'url'         => $term_for_tag_spot_url,
                    );
                }
            }

            // also update the default tag spot text if it's set in the theme's panel
            $new_tag_spot_text = td_util::get_ctp_option($this->post->post_type, 'tds_tag_spot_text');
            if (!empty($new_tag_spot_text)) {
                $tags_spot_text = $new_tag_spot_text;
            }
        } else {
            // on single posts we deal with tags
            $td_post_tags = get_the_tags();
            if (!empty($td_post_tags)) {
                foreach ($td_post_tags as $tag) {
                    $terms_ui_array[$tag->name] = array (
                        'url' => get_tag_link($tag->term_id)
                    );
                }
            }
        }



        /**
         * output stage
         *  we go in with an array of
         *   array (
         *       $terms_ui_array[tag_name] = array (
         *              'url' => '',
         *       )
         *   )
         */
        if (!empty($terms_ui_array)) {
            $buffy .= '<ul class="td-tags td-post-small-box clearfix">';
            $buffy .= '<li><span>' . $tags_spot_text . '</span></li>';
            foreach ($terms_ui_array as $term_name => $term_params) {
                $buffy .=  '<li><a href="' . $term_params['url'] . '">' . $term_name . '</a></li>';
            }
            $buffy .= '</ul>';
        }

        return $buffy;
    }


    /**
     * get the next and previous links on single posts and single custom post types
     * @return string
     */
    function get_next_prev_posts() {
        if (!$this->is_single) {
            return '';
        }

        if (td_util::get_option('tds_show_next_prev') == 'hide') {
            return '';
        }

        $buffy = '';

        $next_post = get_next_post();
        $prev_post = get_previous_post();

        if (!empty($next_post) or !empty($prev_post)) {
            $buffy .= '<div class="td-block-row td-post-next-prev">';
            if (!empty($prev_post)) {
                $buffy .= '<div class="td-block-span6 td-post-prev-post">';
                $buffy .= '<div class="td-post-next-prev-content"><span>' .__td('Previous article', TD_THEME_NAME) . '</span>';
                $buffy .= '<a href="' . esc_url(get_permalink($prev_post->ID)) . '">' . get_the_title( $prev_post->ID ) . '</a>';
                $buffy .= '</div>';
                $buffy .= '</div>';
            } else {
                $buffy .= '<div class="td-block-span6 td-post-prev-post">';
                $buffy .= '</div>';
            }
            $buffy .= '<div class="td-next-prev-separator"></div>';
            if (!empty($next_post)) {
                $buffy .= '<div class="td-block-span6 td-post-next-post">';
                $buffy .= '<div class="td-post-next-prev-content"><span>' .__td('Next article', TD_THEME_NAME) . '</span>';
                $buffy .= '<a href="' . esc_url(get_permalink($next_post->ID)) . '">' . get_the_title( $next_post->ID ) . '</a>';
                $buffy .= '</div>';
                $buffy .= '</div>';
            }
            $buffy .= '</div>'; //end fluid row
        }

        return $buffy;
    }


    /**
     * gets the author on single posts and single custom post types
     * @param string $author_id
     * @return string|void
     */
    function get_author_box($author_id = '') {

        if (!$this->is_single) {
            return '';
        }


        if (empty($author_id)) {
            $author_id = $this->post->post_author;
        }

        // add the author as hidden for google and return if the author box is set to disabled
        if (td_util::get_option('tds_show_author_box') == 'hide') {
            $buffy = '<div class="td-author-name vcard author" style="display: none"><span class="fn">';
            $buffy .= '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta('display_name', $author_id) . '</a>' ;
            $buffy .= '</span></div>';
            return $buffy;
        }



        $buffy = '';

        $hideAuthor = td_util::get_option('hide_author');

        if (empty($hideAuthor)) {

            $buffy .= '<div class="author-box-wrap">';
            $buffy .= '<a href="' . get_author_posts_url($author_id) . '">' ;
            $buffy .= get_avatar(get_the_author_meta('email', $author_id), '96');
            $buffy .= '</a>';


            $buffy .= '<div class="desc">';
            $buffy .= '<div class="td-author-name vcard author"><span class="fn">';
            $buffy .= '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta('display_name', $author_id) . '</a>' ;
            $buffy .= '</span></div>';

            if (get_the_author_meta('user_url', $author_id) != '') {
                $buffy .= '<div class="td-author-url"><a href="' . get_the_author_meta('user_url', $author_id) . '">' . get_the_author_meta('user_url', $author_id) . '</a></div>';
            }

            $buffy .= '<div class="td-author-description">';
            $buffy .=  get_the_author_meta('description', $author_id);
            $buffy .= '</div>';


            $buffy .= '<div class="td-author-social">';
            foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                //echo get_the_author_meta($td_social_id) . '<br>';
                $authorMeta = get_the_author_meta($td_social_id);
                if (!empty($authorMeta)) {

                    //the theme can use the twitter id instead of the full url. This avoids problems with yoast plugin
                    if ($td_social_id == 'twitter') {
                        if(filter_var($authorMeta, FILTER_VALIDATE_URL)){

                        } else {
                            $authorMeta = str_replace('@', '', $authorMeta);
                            $authorMeta = 'http://twitter.com/' . $authorMeta;
                        }
                    }
                    $buffy .= td_social_icons::get_icon($authorMeta, $td_social_id, true);
                }
            }
            $buffy .= '</div>';



            $buffy .= '<div class="clearfix"></div>';

            $buffy .= '</div>'; ////desc
            $buffy .= '</div>'; //author-box-wrap
        }


        return $buffy;
    }


    /**
     * gets the related posts ONLY on single posts. Does not run on custom post types because we don't know what taxonomy to choose and the
     * blocks do not support custom taxonomies as of 15 july 2015
     * @param string $force_sidebar_position - allows us to overwrite the sidebar position. Useful on templates where the related
     *                              articles appear outside of the loop - sidebar grid (like on the top)
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

        if (td_global::$cur_single_template_sidebar_pos == 'no_sidebar' or $force_sidebar_position === 'no_sidebar') {
            $td_related_limit = 5 * $tds_similar_articles_rows;
            $td_related_class = 'td-related-full-width';
            $td_column_number = 5;
        } else {
            $td_related_limit = 3 * $tds_similar_articles_rows;
            $td_related_class = '';
            $td_column_number = 3;
        }



        /**
         * 'td_ajax_filter_type' => 'td_custom_related' - this ajax filter type overwrites the live filter via ajax @see td_ajax::on_ajax_block
         */
        $td_block_args = array (
            'limit' => $td_related_limit,
            'ajax_pagination' => 'next_prev',
            'live_filter' => $td_related_ajax_filter_type,  //live atts - this is the default setting for this block
            'td_ajax_filter_type' => 'td_custom_related', //this filter type can overwrite the live filter @see
            'class' => $td_related_class,
            'td_column_number' => $td_column_number
        );


        /**
         * @see td_block_related_posts
         */
        return td_global_blocks::get_instance('td_block_related_posts')->render($td_block_args);

    }


}