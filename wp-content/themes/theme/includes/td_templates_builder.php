<?php
//vc templates here
global $td_vc_templates;

/** Homepage template */
$data               = array();
$data['name']       = 'Homepage';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row][vc_column width="1/1"][td_block_trending_now sort="random_posts" limit="5"][td_block_big_grid_3 td_grid_style="td-grid-style-1" sort="featured"][/vc_column][/vc_row][vc_row el_class="td-ss-row"][vc_column width="2/3"][td_block_1 limit="5" custom_title="DON'T MISS" header_color="#e29c04" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" sort="" category_ids="" sort="random_posts"][td_block_2 category_id="" limit="6" custom_title="LIFESTYLE NEWS" header_color="#4caf50" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" td_ajax_filter_type="td_category_ids_filter"][td_block_15 category_id="" limit="3" custom_title="HOUSE DESIGN" header_color="#607d8b" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][td_block_1 category_id="" limit="5" custom_title="TECH AND GADGETS" header_color="#f44336" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_social_counter custom_title="STAY CONNECTED" facebook="tagDiv" twitter="envato" youtube="envato"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][td_block_15 category_id="" limit="4" custom_title="MAKE IT MODERN" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][td_block_1 category_id="" limit="3" custom_title="LATEST REVIEWS" td_filter_default_txt="All" sort="random_posts"][/vc_column][/vc_row][vc_row][vc_column width="2/3"][td_block_11 limit="5" custom_title="PERFORMANCE TRAINING" td_filter_default_txt="All" category_id="" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][td_block_6 category_id="" limit="1" custom_title="HOLIDAY RECIPES" header_color="#e91e63" td_filter_default_txt="All" tag_slug="" sort="random_posts"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][td_block_ad_box spot_id="custom_ad_1" spot_title="- Advertisement -"][/vc_column][/vc_row][vc_row][vc_column width="1/3"][td_block_19 category_id="" limit="4" custom_title="WRC RACING" header_color="#4db2ec" td_filter_default_txt="All" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_19 category_id="" limit="4" custom_title="HEALTH &amp; FITNESS" td_filter_default_txt="All" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_10 category_id="" limit="3" custom_title="BUSINESS" td_filter_default_txt="All" sort="random_posts"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][td_block_big_grid_5 custom_title="" td_grid_style="td-grid-style-5" category_id="" sort="random_posts"][td_block_ad_box spot_id="custom_ad_1" spot_title="- Advertisement -"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - travel template */
$data               = array();
$data['name']       = 'Homepage - Travel';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-travel.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="stretch_row" parallax="content-moving-fade" parallax_image="iii_td_pic_homepage_iii" el_class="td-travel-header"][vc_column][/vc_column][/vc_row][vc_row el_class="td-travel-features"][vc_column][td_block_5 custom_title="" sort="featured" limit="3"][/vc_column][/vc_row][vc_row][vc_column][td_block_ad_box spot_id="custom_ad_1" spot_title="- Advertisement -"][/vc_column][/vc_row][vc_row][vc_column][td_block_4 custom_title="Trip ideas" category_id="" limit="3" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_ajax_preloading="preload" sort="random_posts"][vc_separator style="dashed" border_width="4"][vc_empty_space height="2px"][/vc_column][/vc_row][vc_row][vc_column][td_block_4 custom_title="Travel guides" category_id="" limit="3" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_ajax_preloading="preload" sort="random_posts"][vc_separator style="dashed" border_width="4"][vc_empty_space height="2px"][/vc_column][/vc_row][vc_row][vc_column][td_block_5 custom_title="Latest from blog" limit="3" ajax_pagination="load_more"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - health template */
$data               = array();
$data['name']       = 'Homepage - Health';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-health.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row][vc_column][td_block_big_grid_3 td_grid_style="td-grid-style-4" category_id="" sort="featured"][/vc_column][/vc_row][vc_row el_class="td-ss-row"][vc_column width="2/3"][td_block_4 custom_title="POPULAR" category_id="" limit="2" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="next_prev" sort="random_posts"][td_block_18 custom_title="MUST READ" category_id="" limit="4" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="next_prev" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement - "][td_block_social_counter facebook="tagdiv" twitter="envato" youtube="envato"][td_block_21 custom_title="FOOD" category_id="" limit="3" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row][vc_row][vc_column][td_block_ad_box spot_id="custom_ad_1" spot_title="- Advertisement - "][/vc_column][/vc_row][vc_row][vc_column][td_block_16 custom_title="FITNESS" category_id="" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row][vc_row el_class="td-ss-row"][vc_column width="2/3"][td_block_1 custom_title="HEALTH" category_id="" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="next_prev" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_4 custom_title="SCIENCE" category_id="" limit="1" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row][vc_row][vc_column][td_block_ad_box spot_id="custom_ad_1" spot_title="- Advertisement - "][/vc_column][/vc_row][vc_row][vc_column][td_block_4 custom_title="LATEST POSTS" category_id="" category_ids="" sort="random_posts" limit="3" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="load_more" sort="random_posts"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - fashion template */
$data               = array();
$data['name']       = 'Homepage - Fashion';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-fashion.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_big_grid_7 td_grid_style="td-grid-style-5" sort="featured"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_ad_box spot_id="custom_ad_1" spot_title=""][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image="" el_class="td-ss-row"][vc_column width="2/3"][td_block_20 custom_title="This Week Trends" custom_url="" header_text_color="" header_color="#dd6b1f" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="3" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="load_more" ajax_pagination_infinite_stop=""][td_block_ad_box spot_id="custom_ad_2" spot_title=""][/vc_column][vc_column width="1/3"][td_block_ad_box spot_id="sidebar" spot_title="Advertising"][td_block_social_counter custom_title="We Are Social" header_color="" header_text_color="" facebook="envato" twitter="envato" youtube="tagdiv" vimeo="" googleplus="" instagram="" soundcloud="" rss="" open_in_new_window=""][td_block_slide autoplay="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="4" offset="" custom_title="" custom_url="" header_text_color="" header_color="" td_filter_default_txt="All"][td_block_13 custom_title="New Collections" custom_url="" header_text_color="" header_color="#f47395" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="2" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" ajax_pagination_infinite_stop=""][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_big_grid_4 td_grid_style="td-grid-style-5" sort="featured"][td_block_14 custom_title="Month In Review" custom_url="" header_text_color="" header_color="#c44c4c" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="3" offset="" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" ajax_pagination_infinite_stop=""][td_block_video_youtube playlist_yt="r9yVHYeg9xk,AZ3AVR7VnqA,KWFwdNIOVBA,NE8T7G-HBVo,F9fORb30PIU,JthfK81E7n0" playlist_auto_play="0"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image="" el_class="td-ss-row"][vc_column width="2/3"][td_block_18 custom_title="Hot Stuff Coming" custom_url="" header_text_color="" header_color="#b953ed" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="5" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="" ajax_pagination_infinite_stop=""][/vc_column][vc_column width="1/3"][td_block_ad_box spot_id="sidebar" spot_title="Advertising"][td_block_14 custom_title="Popular Gossips" custom_url="" header_text_color="" header_color="#f47395" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="4" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" ajax_pagination_infinite_stop=""][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - video template */
$data               = array();
$data['name']       = 'Homepage - Video';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-video.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="stretch_row" parallax="" parallax_image="" el_class="import_video_slider_bg"][vc_column width="1/1"][td_block_big_grid_6 td_grid_style="td-grid-style-1" category_id="" category_ids="" tag_slug="" autors_id="" sort="featured" installed_post_types="" offset=""][/vc_column][/vc_row][vc_row full_width="stretch_row" parallax="" parallax_image="" el_class="import_video_ad_bg"][vc_column width="1/1"][td_block_ad_box spot_id="content_bottom" spot_title=""][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image="" el_class="td-ss-row"][vc_column width="2/3"][td_block_3 custom_title="POPULAR VIDEOS" custom_url="" header_text_color="" header_color="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="" limit="4" offset="" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" ajax_pagination_infinite_stop=""][td_block_15 custom_title="MOVIE TRAILERS" custom_url="" header_text_color="" header_color="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="6" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="load_more" ajax_pagination_infinite_stop=""][td_block_ad_box spot_id="custom_ad_2" spot_title="Advertisement "][td_block_15 custom_title="GAMEPLAY" custom_url="" header_text_color="" header_color="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="6" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="load_more" ajax_pagination_infinite_stop=""][/vc_column][vc_column width="1/3"][td_block_ad_box spot_id="sidebar" spot_title="Advertisement "][td_block_video_youtube playlist_yt="14JuGRUu_bo, aZdpX6SF5Z8, 1LK0iDlPlTU, 8RrS0GTsEEg, YcNJrufroUQ, Sfiflu_CdJ4" playlist_auto_play="0"][td_block_social_counter custom_title="STAY CONNECTED" header_color="" header_text_color="" facebook="envato" twitter="envato" youtube="tagdiv" vimeo="" googleplus="" instagram="" soundcloud="" rss="" open_in_new_window="y"][td_block_18 custom_title="TOP REVIEWS" custom_url="" header_text_color="" header_color="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="" limit="5" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="" ajax_pagination_infinite_stop=""][/vc_column][/vc_row][vc_row full_width="stretch_row" parallax="" parallax_image="" el_class="import_dont_miss"][vc_column width="1/1"][td_block_14 custom_title="DON'T MISS" custom_url="" header_text_color="" header_color="#f8c900" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="3" offset="" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" ajax_pagination_infinite_stop=""][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - sport template */
$data               = array();
$data['name']       = 'Homepage - Sport';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-sport.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_trending_now navigation="" style="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="" limit="4" offset=""][td_block_big_grid_1 td_grid_style="td-grid-style-1" sort="featured"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_2 custom_title="POPULAR NEWS" custom_url="" header_text_color="" header_color="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="6" offset="" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" ajax_pagination_infinite_stop=""][td_block_16 custom_title="WORD CUP 2016" custom_url="" header_text_color="" header_color="#00964c" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="3" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" ajax_pagination_infinite_stop=""][td_block_16 custom_title="WRC Rally Cup" custom_url="" header_text_color="" header_color="#e29c04" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="3" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev" ajax_pagination_infinite_stop=""][/vc_column][vc_column width="1/3"][td_block_social_counter custom_title="STAY CONNECTED" header_color="" header_text_color="" facebook="tagDiv" twitter="envato" youtube="envato" vimeo="" googleplus="" instagram="" soundcloud="" rss="" open_in_new_window="y"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][td_block_9 custom_title="SPORT NEWS" custom_url="" header_text_color="" header_color="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="3" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="" ajax_pagination_infinite_stop=""][td_block_19 custom_title="HEALTH &amp; FITNESS" custom_url="" header_text_color="" header_color="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="3" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="" ajax_pagination_infinite_stop=""][/vc_column][/vc_row][vc_row full_width="stretch_row" parallax="" parallax_image="" el_class="td-homepage-full-row "][vc_column width="1/1"][td_block_14 custom_title="" sort="random_posts" limit="3" td_filter_default_txt="All"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_ad_box spot_id="custom_ad_1" spot_title="- Advertisement -"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_18 custom_title="CYCLING TOUR" custom_url="" header_text_color="" header_color="#054bac" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="6" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="" ajax_pagination_infinite_stop=""][/vc_column][vc_column width="1/3"][td_block_6 custom_title="TENNIS" custom_url="" header_text_color="" header_color="" category_id="" category_ids="" tag_slug="" autors_id="" installed_post_types="" sort="random_posts" limit="1" offset="" td_ajax_filter_type="" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="" ajax_pagination_infinite_stop=""][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][td_block_6 custom_title="" sort="random_posts" limit="1" offset="1" td_filter_default_txt="All" ajax_pagination="load_more"][/vc_column][/vc_row][vc_row full_width="stretch_row" parallax="" parallax_image="" el_class="td-homepage-full-row td-sport-custom-title"][vc_column width="1/1"][td_block_video_youtube playlist_title="MUST WATCH" playlist_yt="6TWv_R-qcLU, uXVNWwXGl-s, yJIoD0IIV-I, ogWJDWAeEUo, uAz9hZmcr58, 9mPyet9atKg, w6ZBc-XzlP8, ptJWKnQmPWI, ayv5KvYdnW4, BdEOq7XAyrA, rEkg9qIzOrA, FBCwz_QGZho" playlist_auto_play="0"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_ad_box spot_id="custom_ad_1" spot_title="- Advertisement -"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - tech template */
$data               = array();
$data['name']       = 'Homepage - Tech';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-tech.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row parallax_image=""][vc_column width="1/1"][td_block_trending_now limit="5"][td_block_big_grid_8 td_grid_style="td-grid-style-3" sort="featured"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_1 sort="" limit="5" custom_title="MOST POPULAR" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" td_filter_default_txt="All" ajax_pagination="next_prev"][td_block_2 category_id="" limit="6" custom_title="ANDROID" header_color="#dd4646" td_filter_default_txt="All"][/vc_column][vc_column width="1/3"][td_block_social_counter custom_title="STAY CONNECTED" facebook="envato" twitter="envato" youtube="tagDiv" open_in_new_window="y"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][td_block_6 category_id="" limit="1" custom_title="DESIGN" td_filter_default_txt="All" header_color="#25b3b5"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_ad_box spot_id="custom_ad_1"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_18 category_id="" limit="4" custom_title="GADGETS" td_filter_default_txt="All"][/vc_column][vc_column width="1/3"][td_block_19 category_id="" limit="4" custom_title="PHOTOGRAPHY" td_filter_default_txt="All"][td_block_9 category_id="" limit="3" custom_title="WINDOWS PHONE" td_filter_default_txt="All" header_color="#4db2ec"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_big_grid_4 td_grid_style="td-grid-style-5" category_id="" sort="random_posts"][td_block_ad_box spot_id="custom_ad_1"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - blog template */
$data               = array();
$data['name']       = 'Homepage - Blog';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-blog.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image="" el_class="td_classic_blog_home"][vc_column width="1/1"][td_block_big_grid_4 td_grid_style="td-grid-style-1" sort="featured"][vc_column_text  el_class="import_blog_quote"]
<blockquote><strong>" </strong>Sometimes the simplest things are the most profound. My job is to bring out in people &amp; what they wouldn't dare do themselves <strong>"</strong></blockquote>
[/vc_column_text][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - full post featured template */
$data               = array();
$data['name']       = 'Homepage - Full Post Featured';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-full-post.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_homepage_full_1][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_19 limit="6" custom_title="DON'T MISS" td_filter_default_txt="All" ajax_pagination="next_prev" offset=""][td_block_18 category_id="" limit="3" custom_title="LIFESTYLE" td_filter_default_txt="All" ajax_pagination="next_prev" offset="6" ][/vc_column][vc_column width="1/3"][td_block_social_counter custom_title="STAY CONNECTED" facebook="envato" twitter="envato" youtube="envato"][td_block_ad_box spot_id="sidebar"][td_block_3 limit="1" custom_title="POPULAR" td_filter_default_txt="All" ajax_pagination="next_prev" category_id="" sort="random_posts"][td_block_2 limit="2" custom_title="REVIEWS" td_filter_default_txt="All" category_id="" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;


/** Homepage - newspaper template */
$data               = array();
$data['name']       = 'Homepage - Newspaper';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-newspaper.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_trending_now limit="5"][td_block_big_grid_slide td_grid_style="td-grid-style-4" limit="8" sort="featured"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_2 limit="6" custom_title="DON'T MISS" td_filter_default_txt="All" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="next_prev" sort="random_posts"][td_block_1 limit="5" custom_title="TECH AND GADGETS" td_filter_default_txt="All" category_id="" header_color="#f65261" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" ajax_pagination="next_prev" sort="random_posts"][td_block_ad_box spot_id="custom_ad_1"][td_block_19 category_id="" limit="6" custom_title="TRAVEL GUIDES" td_ajax_filter_type="td_category_ids_filter" td_filter_default_txt="All" ajax_pagination="next_prev" header_color="#82b440" td_ajax_filter_ids="" sort="random_posts"][td_block_2 category_id="" limit="6" custom_title="FASHION AND TRENDS" header_color="#ff3e9f" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_social_counter custom_title="STAY CONNECTED" facebook="envato" twitter="envato" youtube="envato"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][td_block_2 category_id="" limit="5" custom_title="LATEST REVIEWS" td_filter_default_txt="All"][td_block_slide category_id="" limit="4" custom_title="POPULAR VIDEOS" td_filter_default_txt="All"][td_block_7 category_id="" limit="6" custom_title="EDITOR'S PICK" td_filter_default_txt="All" sort="random_posts"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_ad_box spot_id="custom_ad_1"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - newsmag template */
$data               = array();
$data['name']       = 'Homepage - Newsmag';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-newsmag.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_big_grid_1 td_grid_style="td-grid-style-1" category_id="" sort="featured"][/vc_column][/vc_row][vc_row el_class="td-ss-row"][vc_column width="2/3"][td_block_1 custom_title="FASHION WEEK" limit="5" td_filter_default_txt="All" ajax_pagination="next_prev" header_color="#e29c04" category_id="" sort="random_posts"][td_block_19 custom_title="GADGET WORLD" header_color="#0b8d5d" limit="8" td_filter_default_txt="All" category_id="" sort="random_posts"][vc_row_inner][vc_column_inner el_class="" width="1/2"][td_block_1 custom_title="BEST Smartphones" category_id="" limit="1" td_filter_default_txt="All" ajax_pagination="next_prev" header_color="#4db2ec" sort="random_posts"][/vc_column_inner][vc_column_inner el_class="" width="1/2"][td_block_10 custom_title="DON'T MISS" limit="3" td_filter_default_txt="All" sort="random_posts"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/3"][td_block_ad_box spot_id="sidebar"][td_block_1 custom_title="POPULAR VIDEO" header_color="#ed581c" limit="1" td_filter_default_txt="All" category_id="" ajax_pagination="next_prev" sort="random_posts"][td_block_8 custom_title="HOLIDAY RECEPIES" category_id="" limit="2" td_filter_default_txt="All" header_color="#0152a9" sort="random_posts"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_14 custom_title="EVEN MORE NEWS" header_color="#288abf" limit="3" td_filter_default_txt="All" ajax_pagination="next_prev" category_id="" sort="random_posts"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - magazine template */
$data               = array();
$data['name']       = 'Homepage - Magazine';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-magazine.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_slide custom_title="" limit="3" td_filter_default_txt="All" sort="featured"][td_block_1 limit="5" custom_title="MOST POPULAR" td_filter_default_txt="All" ajax_pagination="next_prev" offset=""][td_block_2 limit="6" custom_title="TECH" td_filter_default_txt="All" ajax_pagination="next_prev" offset="" category_id="" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids=""][td_block_ad_box spot_id="custom_ad_1"][vc_row_inner][vc_column_inner el_class="" width="1/2"][td_block_slide limit="" custom_title="PEOPLE" td_filter_default_txt="All" category_id="" sort="random_posts"][/vc_column_inner][vc_column_inner el_class="" width="1/2"][td_block_7 limit="4" custom_title="LIFE" td_filter_default_txt="All" category_id="" ajax_pagination="next_prev" offset="" sort="random_posts"][/vc_column_inner][/vc_row_inner][td_block_15 limit="3" custom_title="DESIGN" td_filter_default_txt="All" ajax_pagination="next_prev" category_id=""][/vc_column][vc_column width="1/3"][td_block_social_counter facebook="envato" twitter="envato" youtube="envato"][td_block_3 category_id="" limit="3" custom_title="LATEST VIDEOS" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][td_block_8 category_id="" limit="3" custom_title="TECH POPULAR" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][td_block_2 category_id="" limit="3" custom_title="TRAVEL" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;


/** Homepage - big slide template */
$data               = array();
$data['name']       = 'Homepage - Big Slide';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/big-slide.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_trending_now limit="5"][td_block_slide custom_title="" limit="5" td_filter_default_txt="All" sort="featured"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_2 category_id="" limit="6" offset="5" custom_title="DON'T MISS" td_filter_default_txt="All" ajax_pagination="next_prev" header_color="#4db2ec"][/vc_column][vc_column width="1/3"][td_block_social_counter custom_title="STAY CONNECTED" facebook="envato" twitter="envato" youtube="envato"][td_block_7 limit="3" custom_title="MOST POPULAR" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_15 category_id="" limit="5" custom_title="LATEST VIDEOS" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_4 category_id="" limit="2" custom_title="TRAVEL GUIDE" td_filter_default_txt="All" ajax_pagination="next_prev" header_color="#c7272f" sort="random_posts"][td_block_4 category_id="" limit="2" custom_title="PHONES &amp; DEVICES" td_filter_default_txt="All" ajax_pagination="next_prev" header_color="#107a56"][td_block_4 category_id="" limit="2" custom_title="LATEST TRENDS" td_filter_default_txt="All" ajax_pagination="next_prev" header_color="#e83e9e" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_9 category_id="" limit="3" custom_title="TECH" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][td_block_18 category_id="" limit="3" custom_title="FASHION" td_filter_default_txt="All" ajax_pagination="next_prev"][td_block_2 category_id="" limit="2" custom_title="REVIEWS" td_filter_default_txt="All"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_14 category_id="" limit="3" custom_title="ENTERTAIMENT" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - infinite scroll template */
$data               = array();
$data['name']       = 'Homepage - Infinite Scroll';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/homepage-infinite-scroll.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_trending_now limit="5"][td_block_big_grid_1 td_grid_style="td-grid-style-1" sort="featured"][td_block_14 custom_title="" category_id="" limit="3" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row][vc_row el_class="td-ss-row"][vc_column width="2/3"][td_block_4 limit="6" offset="" custom_title="Infinite Load Articles" td_filter_default_txt="All" ajax_pagination="infinite" ajax_pagination_infinite_stop="2"][/vc_column][vc_column width="1/3"][vc_widget_sidebar sidebar_id="td-default"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Homepage - loop template */
$data               = array();
$data['name']       = 'Homepage - Loop';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/loop.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_trending_now limit="5"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_18 custom_title="" limit="4" td_filter_default_txt="All" sort="random_posts"][td_block_18 custom_title="" limit="4" offset="" td_filter_default_txt="All" sort="random_posts"][td_block_18 custom_title="" limit="4" offset="" td_filter_default_txt="All" sort="random_posts"][/vc_column][vc_column width="1/3"][td_block_social_counter facebook="envato" twitter="envato" youtube="envato"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][td_block_9 limit="3" custom_title="Featured" td_filter_default_txt="All" ajax_pagination="next_prev" category_id="" sort="random_posts"][td_block_2 limit="5" custom_title="Most Popular" td_filter_default_txt="All" ajax_pagination="next_prev" category_id="" sort="random_posts"][td_block_4 category_id="" limit="3" custom_title="Latest reviews" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_ad_box spot_id="custom_ad_1"][td_block_3 limit="9" custom_title="More News" td_filter_default_txt="All" ajax_pagination="infinite" ajax_pagination_infinite_stop="1" offset="" sort="random_posts"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;


/** Homepage - less images template */
$data               = array();
$data['name']       = 'Homepage - Less Images';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/less-images.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][td_block_trending_now limit="5"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="2/3"][td_block_5 custom_title="" limit="2" td_filter_default_txt="All"][td_block_9 category_id="" limit="6" custom_title="FASHION WEEK" td_filter_default_txt="All" ajax_pagination="next_prev" td_ajax_filter_type="td_category_ids_filter" td_ajax_filter_ids="" sort="random_posts"][td_block_17 category_id="" limit="5" custom_title="DON'T MISS" td_ajax_filter_type="td_category_ids_filter" td_filter_default_txt="All" ajax_pagination="next_prev" td_ajax_filter_ids="" sort="random_posts"][vc_row_inner][vc_column_inner el_class="" width="1/2"][td_block_10 limit="3" custom_title="LIFESTYLE" td_filter_default_txt="All" category_id="" sort="random_posts"][/vc_column_inner][vc_column_inner el_class="" width="1/2"][td_block_10 limit="3" custom_title="TECHNOLOGY" td_filter_default_txt="All" category_id="" sort="random_posts"][/vc_column_inner][/vc_row_inner][td_block_21 limit="3" custom_title="LATEST NEWS" td_filter_default_txt="All" ajax_pagination="load_more"][/vc_column][vc_column width="1/3"][td_block_social_counter custom_title="STAY CONNECTED" facebook="envato" twitter="envato" youtube="envato"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement - "][td_block_21 limit="3" custom_title="POPULAR ARTICLES" td_filter_default_txt="All" sort="random_posts"][td_block_popular_categories custom_title="TRENDING CATEGORIES" limit="6" sort="random_posts"][td_block_2 category_id="" limit="4" custom_title="LATEST REVIEWS" td_filter_default_txt="All" ajax_pagination="next_prev" sort="random_posts"][vc_wp_recentcomments title="RECENT COMMENTS" number="5"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** About Me Page template */
$data               = array();
$data['name']       = 'About Me Page';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/about-me.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row el_class="aboutme_content"][vc_column width="1/3"][vc_single_image image="" style="vc_box_outline_circle_2" border_color="grey" img_link_large="" img_link_target="_self" img_size="large" alignment="center" el_class="aboutme_image"][/vc_column][vc_column width="2/3"][vc_column_text]<span class="dropcap dropcap3" style="color: #cb9558;">I</span> have learned that what is important in a dress is the woman who is wearing it. <em><strong>I'd like to believe that the women who wear my clothes are not dressing for other people</strong></em>, that they're wearing what they like and what suits them.

It's not a status thing. It pains me physically to see a woman victimized, rendered pathetic, by fashion. I believe that my clothes can give people a better image of themselves - that it can increase their feelings of confidence and happiness. <strong>Fashion is not something that exists in dresses only.</strong>
<blockquote>FASHION IS IN THE SKY, IN THE STREET, FASHION HAS TO DO WITH IDEAS, THE WAY WE LIVE, WHAT IS HAPPENING.</blockquote>
<em><strong>Vanity is the healthiest thing in life.</strong></em> My aim is to make the poor look rich and the rich look poor. I am no longer concerned with sensation and innovation,<em> but with the perfection of my style.</em>[/vc_column_text][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][vc_text_separator title="Latest Articles" title_align="separator_align_center" align="align_center" color="grey"][td_block_big_grid_5 td_grid_style="td-grid-style-5"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;


/** Contact Page template */
$data               = array();
$data['name']       = 'Contact Page';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/contact-page.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row][vc_column width="2/3"][vc_column_text]You are a part of the Rebel Alliance and a traitor so what do you think of her Han. But with the blast shield down even see! How am I supposed to fight need your help Luke. She needs your help getting too old for this sort of thing.

Act so surprised your highness. You mercy mission this time several transmissions were beamed to this ship by Rebel spies.
<ul>
	<li>You mean it controls your actions?</li>
	<li>But with the blast shield down can even see! How am I supposed to fight?</li>
	<li>I get involved got work to do not that I like the Empire</li>
	<li>But nothing can do about it right now such a long way from here.</li>
</ul>
[/vc_column_text][vc_row_inner][vc_column_inner width="1/2"][td_block_text_with_title custom_title="Contact Details"]<strong>Newspaper Comunication Service</strong>
123 California St. Doargo

(650) 123-2558 (main number)
(650) 123-0247 (fax)

Email: <strong><a href="mailto:contact@yoursite.com" target="_blank">contact@yoursite.com</a></strong>[/td_block_text_with_title][/vc_column_inner][vc_column_inner width="1/2"][td_block_text_with_title custom_title="About us"]<strong>Newspaper</strong> is your news entertainment music fashion website. We provide you with the latest breaking news
and videos straight from entertainment industry world.[/td_block_text_with_title][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/1"][vc_raw_html]JTNDaDQlMjBjbGFzcyUzRCUyMmJsb2NrLXRpdGxlJTIyJTNFJTNDc3BhbiUzRVNlbmQlMjB1cyUyMGElMjBtZXNzYWdlJTIxJTNDJTJGc3BhbiUzRSUzQyUyRmg0JTNF[/vc_raw_html][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner el_class="" width="1/1"][vc_column_text]Install Contact Form 7 Plugin and replace this text block with your contact form[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/3"][td_block_2 limit="3" custom_title="LATEST POSTS" td_filter_default_txt="All"][td_block_ad_box spot_id="sidebar" spot_title="- Advertisement -"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Sidebar right template */
$data               = array();
$data['name']       = 'Sidebar Right';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/sidebar-right.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row][vc_column width="2/3"][/vc_column][vc_column width="1/3"][vc_widget_sidebar sidebar_id="td-default"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;

/** Sidebar left template */
$data               = array();
$data['name']       = 'Sidebar Left';
$data['image_path'] = get_template_directory_uri() . '/images/pagebuilder/sidebar-left.png';
$data['custom_class'] = ''; // default is ''
$data['content']    = <<<CONTENT
[vc_row][vc_column width="1/3"][vc_widget_sidebar sidebar_id="td-default"][/vc_column][vc_column width="2/3"][/vc_column][/vc_row]
CONTENT;

$td_vc_templates[] = $data;