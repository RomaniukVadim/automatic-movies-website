<?php
/*  ---------------------------------------------------------------------------
    top menu - MENUS MUST HAVE THE FOLLOWING NAMES:
    td-demo-top-menu
    td-demo-header-menu
    td-demo-footer-menu
*/

//main menu
$td_demo_header_menu_id = td_demo_menus::create_menu('td-demo-header-menu', 'header-menu');


//footer menu
$td_demo_footer_menu = td_demo_menus::create_menu('td-demo-footer-menu', 'footer-menu');
td_demo_menus::add_link(array(
    'title' => 'Home',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Blog',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Travel guides',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Culture',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
	'title' => 'Adventure Travel',
	'add_to_menu_id' => $td_demo_footer_menu,
	'url' => '#',
	'parent_id' => ''
));
td_demo_menus::add_link(array(
	'title' => 'USA',
	'add_to_menu_id' => $td_demo_footer_menu,
	'url' => '#',
	'parent_id' => ''
));
td_demo_menus::add_link(array(
	'title' => 'Europe',
	'add_to_menu_id' => $td_demo_footer_menu,
	'url' => '#',
	'parent_id' => ''
));
td_demo_menus::add_link(array(
	'title' => 'Asia',
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

// footer background
td_demo_misc::update_background_footer('td_footer_bg');


/*  ----------------------------------------------------------------------------
    logo
 */
td_demo_misc::update_logo(array(
    'normal' => 'td_logo_header',
    'retina' => 'td_logo_header@2x',
    'mobile' => ''
));


//footer
td_demo_misc::update_footer_logo(array(
    'normal' => 'td_logo_header@2x',
    'retina' => ''
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
    'instagram' => '#',
    'vk' => '#',
    'youtube' => '#'
));


/*  ----------------------------------------------------------------------------
    ads
 */
td_demo_misc::clear_all_ads();
td_demo_misc::add_ad_image('post_style_12', 'td_travel_post_ad');
td_demo_misc::add_ad_image('smart_list_6', 'td_travel_smart6_ad');
td_demo_misc::add_ad_image('smart_list_7', 'td_travel_smart6_ad');


/*  ----------------------------------------------------------------------------
    sidebars
 */
//default sidebar
td_demo_widgets::remove_widgets_from_sidebar('default');
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_social_counter_widget',
	array (
		'custom_title'  => "Stay connected",
		'instagram'     => "greenislandstudios",
		'youtube'       => "tagDiv"
	)
);
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_9_widget',
	array (
		'sort' => '',
		'custom_title' => 'Recent posts',
		'limit' => '3',
		'header_color' => ''
	)
);
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_15_widget',
    array (
        'sort' => '',
        'custom_title' => 'Random article',
        'limit' => '4',
        'header_color' => ''
    )
);




/*  ---------------------------------------------------------------------------
    categories
*/
$demo_cat_1_id =td_demo_category::add_category(array(
    'category_name' => 'Destinations',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
    $demo_cat_2_id =td_demo_category::add_category(array(
        'category_name' => 'Asia',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_3_id =td_demo_category::add_category(array(
        'category_name' => 'Caribbean',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_4_id =td_demo_category::add_category(array(
        'category_name' => 'Europe',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_5_id =td_demo_category::add_category(array(
        'category_name' => 'USA',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));

$demo_cat_6_id =td_demo_category::add_category(array(
    'category_name' => 'Adventure Travel',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_7_id =td_demo_category::add_category(array(
    'category_name' => 'Culture',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    'tdc_category_td_grid_style' => '2'
));
$demo_cat_8_id =td_demo_category::add_category(array(
    'category_name' => 'Travel guides',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    'tdc_category_td_grid_style' => ''
));
$demo_cat_9_id =td_demo_category::add_category(array(
    'category_name' => 'Trip ideas',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));


/*  ----------------------------------------------------------------------------
    pages
 */
//homepage
$td_homepage_id = td_demo_content::add_page(array(
    'title' => 'Home',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/homepage.txt',
    'template' => 'page.php',   // the page template full file name with .php
    'td_layout' => '',
    'homepage' => true
));

$td_blog_id = td_demo_content::add_page(array(
	'title' => 'Travel blog',
	'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/travel-blog.txt',
	'template' => 'page-pagebuilder-latest.php',   // the page template full file name with .php
	'td_layout' => '12',
	'homepage' => false
));


/*  ----------------------------------------------------------------------------
    menu
 */

//add the homepage to the menu
td_demo_menus::add_page(array(
    'title' => 'Start here',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_homepage_id,
    'parent_id' => ''
));

td_demo_menus::add_page(array(
	'title' => 'Travel blog',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'page_id' => $td_blog_id,
	'parent_id' => ''
));


// mega menu multiple subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Destinations',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));

// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
	'title' => 'Trip ideas',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_9_id
));

td_demo_menus::add_mega_menu(array(
	'title' => 'Culture',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_7_id
));

td_demo_menus::add_mega_menu(array(
	'title' => 'Guides',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_8_id
));



/*  ---------------------------------------------------------------------------
    posts
*/
// post in featured category
td_demo_content::add_post(array(
    'title' => '8 Incredible Pictures From The Travel Photographer',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_smart.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_12',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => '10 Landscapes You Won’t Have Even Imagined Exist',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => 'Top Most Beautiful Islands In The World',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_3'
));


//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "10 Hotels That Are Perfect for Solo Travelers",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_12',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => "Top Reasons to Go to Barcelona",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_12',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => "Paris's 10 Best New Boutiques",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_12',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => "World's 15 Best Summer Music Festivals",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_12',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => "10 Things Not to Do in Bangkok",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_12',
    'smart_list' => 'td_smart_list_6'
));



//  ----------------------------------------------------------------------------
//  Mix Cat
td_demo_content::add_post(array(
    'title' => "20 Ultimate Things to Do in Hong Kong",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Vietnam's Top 12 Experiences",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => '10 Best Island Getaways for 2015',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => "Cuba's Top 12 Experiences",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "5 Must-Have Experiences on Grand Cayman Island",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_2'
));


//  ----------------------------------------------------------------------------
//
td_demo_content::add_post(array(
    'title' => "5 Ways to Unwind in Aruba",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "10 Best Caribbean All-Inclusive Resorts for 2015",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "3 Great Weekend Trips From Mexico City",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Long Weekend in Barcelona",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "6 Hotel Deals for Martin Luther King",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Romantic Getaway: Long Weekend in Montréal",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "The river wild: Whitewater rafting rivers for the adventurous",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "Where to Find Affordable Lodging in New York City",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => '10 Things NOT to Do at Walt Disney World',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "Ultimate Guide to European Rail Passes",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_2'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Where Can I Learn Spanish in Madrid?",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "Hotel Debuts in Costa Rica: Andaz Peninsula Papagayo",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Luxury Hotel Debuts in French Alps',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Top 10 Things to Do in Napa Valley (Besides Drink Wine)",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "5 Unique Ways to See the Grand Canyon",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_7'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Beginner's Guide to Hawaii: Kauai",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "10 Things You Should Know Before You Go to Tibet",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Ultimate Guide to Vienna's Coffee Renaissance",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "How to Choose the Right Cruise for You",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => "The 5 New Watch Trends To Try Now",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Are You Already Wearing the Hottest Brands in Your City?',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "7 Reasons Cruising Is a Great Way to See the World",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_10'
));

td_demo_content::add_post(array(
    'title' => "Choose Your Own Adventure: Machu Picchu",
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'Could Shanghai Disneyland Be Cooler Than Walt Disney',
    'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_5'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
	'title' => 'Are You Already Wearing the Hottest Brands in Your City?',
	'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_7_id),
	'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
	'title' => "7 Reasons Cruising Is a Great Way to See the World",
	'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_6_id),
	'featured_image_td_id' => 'td_pic_10'
));

td_demo_content::add_post(array(
	'title' => "Choose Your Own Adventure: Machu Picchu",
	'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_5_id),
	'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
	'title' => 'Could Shanghai Disneyland Be Cooler Than Walt Disney',
	'file' => td_global::$get_template_directory . '/includes/demos/travel/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_7_id),
	'featured_image_td_id' => 'td_pic_4'
));