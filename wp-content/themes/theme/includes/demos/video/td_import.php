<?php
/**
 * Created by ra on 5/14/2015.
 */



/*  ---------------------------------------------------------------------------
    top menu - MENUS MUST HAVE THE FOLLOWING NAMES:
    td-demo-top-menu
    td-demo-header-menu
    td-demo-footer-menu
*/

//top menu
$td_demo_top_menu_id = td_demo_menus::create_menu('td-demo-top-menu', 'top-menu');
$td_top_menu_parent_id = td_demo_menus::add_link(array(
    'title' => 'Advertising',
    'add_to_menu_id' => $td_demo_top_menu_id,
    'url' => '#',
    'parent_id' => ''
));

td_demo_menus::add_link(array(
    'title' => 'Premium',
    'add_to_menu_id' => $td_demo_top_menu_id,
    'url' => '#',
    'parent_id' => $td_top_menu_parent_id
));
td_demo_menus::add_link(array(
    'title' => 'Subscription',
    'add_to_menu_id' => $td_demo_top_menu_id,
    'url' => '#',
    'parent_id' => $td_top_menu_parent_id
));

td_demo_menus::add_link(array(
    'title' => 'Buy Now',
    'add_to_menu_id' => $td_demo_top_menu_id,
    'url' => 'http://themeforest.net/item/newspaper/5489609',
    'parent_id' => ''
));


//main menu
$td_demo_header_menu_id = td_demo_menus::create_menu('td-demo-header-menu', 'header-menu');


//footer menu
$td_demo_footer_menu = td_demo_menus::create_menu('td-demo-footer-menu', 'footer-menu');
td_demo_menus::add_link(array(
    'title' => 'About Us',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Privacy',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Advertising',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Buy Now',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => 'http://themeforest.net/item/newspaper/5489609',
    'parent_id' => ''
));




/*  ----------------------------------------------------------------------------
    background - leave empty if you want to make sure that there is NO background on the demo - td_demo_misc::update_background('');
 */
td_demo_misc::update_background('');



/*  ----------------------------------------------------------------------------
    logo
 */
td_demo_misc::update_logo(array(
    'normal' => 'td_pic_logo_desktop',
    'retina' => 'td_pic_logo_desktop_retina',
    'mobile' => 'td_pic_logo_desktop'
));


//footer
td_demo_misc::update_footer_logo(array(
    'normal' => 'td_pic_logo_desktop',
    'retina' => 'td_pic_logo_desktop'
));


/*  ----------------------------------------------------------------------------
    footer text
 */
td_demo_misc::update_footer_text('Newspaper is your news, entertainment, music fashion website. We provide you with the latest breaking news and videos straight from the entertainment industry.');



/*  ----------------------------------------------------------------------------
    socials
 */
td_demo_misc::add_social_buttons(array(
    'facebook' => '#',
    'twitter' => '#',
    'vimeo' => '#',
    'vk' => '#',
    'youtube' => '#'
));


/*  ----------------------------------------------------------------------------
    ads
 */
td_demo_misc::clear_all_ads();
td_demo_misc::add_ad_image('sidebar', 'td_video_sidebar_ad');
td_demo_misc::add_ad_image('post_style_11', 'td_video_sidebar_ad');
td_demo_misc::add_ad_image('content_bottom', 'td_video_full_ad');
td_demo_misc::add_ad_image('custom_ad_1', 'td_video_sidebar_ad');
td_demo_misc::add_ad_image('custom_ad_2', 'td_video_full_ad');


/*  ----------------------------------------------------------------------------
    sidebars
 */

//default sidebar
td_demo_widgets::remove_widgets_from_sidebar('default');
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_ad_box_widget',
    array (
        'spot_title' => '- Advertisement -',
        'spot_id' => 'sidebar'
    )
);
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_slide_widget',
    array (
        'sort' => '',
        'custom_title' => 'RECOMMENDED VIDEOS',
        'limit' => '4',
        'header_color' => ''
    )
);
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_7_widget',
    array (
        'sort' => '',
        'custom_title' => 'POPULAR',
        'limit' => '5',
        'header_color' => ''
    )
);




/*  ---------------------------------------------------------------------------
    categories
*/
$demo_cat_1_id =td_demo_category::add_category(array(
    'category_name' => 'Videos',
    'parent_id' => 0,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_2_id =td_demo_category::add_category(array(
    'category_name' => 'Animations',
    'parent_id' => $demo_cat_1_id,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_3_id =td_demo_category::add_category(array(
    'category_name' => 'GamePlay',
    'parent_id' => $demo_cat_1_id,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_4_id =td_demo_category::add_category(array(
    'category_name' => 'Movie Trailers',
    'parent_id' => $demo_cat_1_id,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_5_id =td_demo_category::add_category(array(
    'category_name' => 'Music',
    'parent_id' => $demo_cat_1_id,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_6_id =td_demo_category::add_category(array(
    'category_name' => "Tutorials",
    'parent_id' => $demo_cat_1_id,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));

$demo_cat_7_id =td_demo_category::add_category(array(
    'category_name' => 'Series',
    'parent_id' => 0,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_8_id =td_demo_category::add_category(array(
    'category_name' => 'Game Reviews',
    'parent_id' => 0,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_9_id =td_demo_category::add_category(array(
    'category_name' => 'Top Ads',
    'parent_id' => 0,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_10_id =td_demo_category::add_category(array(
    'category_name' => 'Best Of',
    'parent_id' => 0,
    'category_template' => 'td_category_template_5',
    'top_posts_style' => 'td_category_top_posts_style_4',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '2', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));



/*  ----------------------------------------------------------------------------
    pages
 */
//homepage
$td_homepage_id = td_demo_content::add_page(array(
    'title' => 'News',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/homepage.txt',
    'template' => 'page-pagebuilder-latest.php',   // the page template full file name with .php
    'td_layout' => '10',
    'homepage' => true
));

/*  ----------------------------------------------------------------------------
    menu
 */

//add the homepage to the menu
td_demo_menus::add_page(array(
    'title' => 'News',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_homepage_id,
    'parent_id' => ''
));


// mega menu multiple subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Videos',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));


// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Series',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_7_id
));


// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Game Reviews',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_8_id
));

// add a category to the menu
td_demo_menus::add_category(array(
    'title' => 'Top Ads',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_9_id
));


// add a subcategory to the sub-menu
$parent_submenu_id = td_demo_menus::add_link(array(
    'title' => 'Best Of',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => ''
));

td_demo_menus::add_category(array(
    'title' => 'Movie Trailers',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_2_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'Music',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_3_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'GamePlay',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_4_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => "Animations",
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_5_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => "Tutorials",
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_6_id,
    'parent_id' => $parent_submenu_id
));


/*  ---------------------------------------------------------------------------
    posts
*/
// post in featured category

td_demo_content::add_post(array(
    'title' => 'Kit Kat Double Act, My Life as Splactor',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'Game of Thrones: Watchers of the Wall',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'Mass Effect 4 Dreams - Beyond Imagination',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'Avengers: Age of Ultron Official Extended Trailer',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => '1 Hour Music Mix for Gaming - Melodic',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'Game Scoop - 42 Reason We Would Miss Konami',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_13',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'Starcraft 2: Legacy of the Void is Faster and More Aggressive',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_5',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video',
    'template' => 'single_template_11'
));


//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Daredevil Series Will Change the Marvel Cinematic Universe",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Gaming Drum and Bass Mix – Fast Breaks",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Mad Max: Fury Road Heads Up May’s Must See Movies",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_12',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "The Week in Video Game Movie News – Keepin’ It Reel",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Star Wars Rebels: Season 2 The Dark",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));



//  ----------------------------------------------------------------------------
//  Mix Cat
td_demo_content::add_post(array(
    'title' => "How To Train Your Dragon 2 – Animation Sequel HD",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Feel The Power Gaming Music Mix",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_14',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'SMITE Battleground of the Gods Cinematic Trailer',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Big Hero 6 – Best Disney Movies For Kids",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Just Around The Bend – Adobe Photoshop CC Timelapse",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_11',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));


//  ----------------------------------------------------------------------------
//
td_demo_content::add_post(array(
    'title' => "Ultimate Gaming Music Tribute",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "The Flash: Examining All the Secrets in the New Trailer",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Destiny: Black Shield – House of Wolves Crucible PVP Gameplay",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Everything We Know About Destiny’s House Of Wolves",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Funny Banned Condom Commercials",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Destiny: House of Wolves Trials of Osiris – Rewind Theater",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Neverwinter Review – Early Access Weapons Gameplay",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Terry Crews Old Spice Muscle Music",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'Ratchet & Clank All 4 One Cutscenes with Subtitles',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_11',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "The Brave and the Bold – The Flash VS The Arrow",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_12',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "New Electro & House Dance Mix #71",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_13',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "2013 Kia Soul Hamster Commercial Gangnam",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_14',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'The Crew vs. Forza Horizon 2 vs. Driveclub Gameplay',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Halo: The Complete Saga Wars, Reach, Master Chief Collection",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Fantastic Four | official trailer US (2015) Marvel",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Jupiter Rising – Adobe CC Manipulation",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "LEGO Marvel Super Heroes - Hot",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Top Popular Songs Dubstep 2014",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Final Fantasy 14 – Heavensward Opening Cinematic",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Dawn of Justice? – The Superhero Show – Batman v Superman",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'The Originals – Ashes to Ashes',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Photoshop Concept Art Tutorials | Photo Manipulation",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));

td_demo_content::add_post(array(
    'title' => "Black Birds – Mix Tribute – Music Video",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'Supernatural – Dark Dynasty',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_12',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Star Wars Rebels: Season 2 The Dark",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_13',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Nothing But Time – Adobe Photoshop CS6 Manipulation",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_14',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "There’s No Need to Worry About Star Wars Battlefront",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'The Walking Dead – Series',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Bloodborne Walkthrough Gameplay – Character Creation",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Destiny: The Dark Below Animation ",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Kobe vs Messi: Legends on Board – Turkish Airlines",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'The Arrow - Get Ready',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Aphrodite’s Tartarus – Manipulation",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => 'Nike Football: The Last Game ft. Ronaldo, Neymar Jr',
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Total War Battles: Kingdom Open Beta Trailer",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Dota 2 Great Game - Cheating Pros are Ruining",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Video Game Music Video – You’re Gonna Go Far, Kid",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_11',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "AXE Apollo – Sorry, Dario",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "Sapeurs - New Guinness Advert",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
td_demo_content::add_post(array(
    'title' => "The 100 - The new sci-fi series",
    'file' => td_global::$get_template_directory . '/includes/demos/video/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_11',
    'featured_video_url' => 'https://www.youtube.com/watch?v=o7JSltCqpCI',
    'post_format' => 'video'
));
