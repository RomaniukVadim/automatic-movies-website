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
    'title' => 'About',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Blog',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => '#'
));
td_demo_menus::add_link(array(
    'title' => 'Contact',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
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
    'normal' => 'td_logo_header',
    'retina' => '',
    'mobile' => ''
));


//footer
td_demo_misc::update_footer_logo(array(
    'normal' => 'td_logo_footer',
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
    'instagram' => '#',
    'vimeo' => '#',
    'youtube' => '#'
));


/*  ----------------------------------------------------------------------------
    ads
 */
td_demo_misc::clear_all_ads();
td_demo_misc::add_ad_image('custom_ad_1', 'td_cars_post_ad');
td_demo_misc::add_ad_image('sidebar', 'td_cars_sidebar_ad');


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

td_demo_widgets::add_widget_to_sidebar('default', 'td_block_social_counter_widget',
	array (
		'custom_title'  => "",
        'facebook'     => "tagdiv",
        'instagram'     => "tagDiv",
		'youtube'       => "tagDiv"
	)
);

td_demo_widgets::add_widget_to_sidebar('default', 'td_block_9_widget',
    array (
        'sort' => '',
        'custom_title' => 'Recent Posts',
        'limit' => '4',
        'header_color' => ''
    )
);




/*  ---------------------------------------------------------------------------
    categories
*/
$demo_cat_1_id =td_demo_category::add_category(array(
    'category_name' => 'Car News',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
    $demo_cat_2_id =td_demo_category::add_category(array(
        'category_name' => 'Auto Shows',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => '',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_3_id =td_demo_category::add_category(array(
        'category_name' => 'Classic Cars',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => '',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_4_id =td_demo_category::add_category(array(
        'category_name' => 'First Drive',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => '',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_5_id =td_demo_category::add_category(array(
        'category_name' => 'Future Cars',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => '',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_6_id =td_demo_category::add_category(array(
        'category_name' => 'Motorsports',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => '',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_7_id =td_demo_category::add_category(array(
        'category_name' => 'Technology',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => '',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));

$demo_cat_8_id =td_demo_category::add_category(array(
    'category_name' => 'Deals',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_9_id =td_demo_category::add_category(array(
    'category_name' => 'Reviews',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    'tdc_category_td_grid_style' => '2'
));
$demo_cat_10_id =td_demo_category::add_category(array(
    'category_name' => 'Tests',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    'tdc_category_td_grid_style' => ''
));
$demo_cat_11_id =td_demo_category::add_category(array(
    'category_name' => 'Life',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_12_id =td_demo_category::add_category(array(
    'category_name' => 'Tuning',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
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
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/homepage.txt',
    'template' => 'page.php',   // the page template full file name with .php
    'td_layout' => '',
    'homepage' => true
));

/*  ----------------------------------------------------------------------------
    menu
 */

//add the homepage to the menu
td_demo_menus::add_page(array(
    'title' => 'Home',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_homepage_id,
    'parent_id' => ''
));


// mega menu multiple subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Car News',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));

// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
	'title' => 'Deals',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_8_id
));

td_demo_menus::add_mega_menu(array(
	'title' => 'Reviews',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_9_id
));

// add a subcategory to the sub-menu
$parent_submenu_id = td_demo_menus::add_link(array(
    'title' => 'See More',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => ''
));

td_demo_menus::add_category(array(
    'title' => 'Tests',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_10_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'Life',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_11_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'Tuning',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_12_id,
    'parent_id' => $parent_submenu_id
));



/*  ---------------------------------------------------------------------------
    posts
*/
// post in featured category
td_demo_content::add_post(array(
    'title' => 'The Best Supercars of All Times',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/smart_list.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => 'Hottest New Cars at Detroit',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/smart_list.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => 'TVR Stages a More Credible Comeback',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => '2016 Hyundai Sonata Hybrid',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Top 5 Motorsport Games of 2015',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/smart_list.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => '2015 Lexus GX460 Luxury',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => 'Dodge Unveils 2015 Charger Pursuit',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_7'
));


//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Best Cars of 2016",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id,$demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => "BFGoodrich Unveils G-Force Tires",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id,$demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "New Car Financing",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id,$demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Mansory Lamborghini Aventador",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id,$demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => "10 Best Car Deals of the Month",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id,$demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_9'
));



//  ----------------------------------------------------------------------------
//  Mix Categories
td_demo_content::add_post(array(
    'title' => "Fiat Sells Off Ferrari",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "Car Deals from Top US Brokers",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'Tesla Reportedly Loses $4,000 on Each Model S',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "Junkyard All-You-Can-Carry Sale",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Crazy ABT Audi RS3 Reaches Over 430hp",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_5'
));


//  ----------------------------------------------------------------------------
//
td_demo_content::add_post(array(
    'title' => "Limited Production Aventador",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Alfa Romeo Giulia Sounds Great",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => "There’s Nothing Funny About Toyota’s Fuel Leaks",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Hackers Seize Control of a Tesla Model S",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "Modify Your New Mercedes-Benz C-Class",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_12_id),
    'featured_image_td_id' => 'td_pic_10'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Cars in Miniature Swarm Greater Boston Area",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "Get Ready for Diesel Cadillacs",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => "All But 2 Buick Models Built Overseas",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => 'Fia Action for Road Safety',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Dodge Launches ‘Don’t Touch My Dart’ Campaign",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_5'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Volkswagen Beetle R-Line",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "2016 Porsche Boxster Spyder",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => 'Land Rover Range Rover Sport’s New Diesel V-6',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Jaguar Crossover “F-Pace”",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "2016 GMC Terrain",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_10'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Ford Testing Right Hand Drive Mustang",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "New Chevrolet Spark",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => "2017 Ford Raptor Dominates an Off-Road Trail",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "2016 Chevrolet Malibu",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Alfa Romeo 4C Coupe",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_5'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Audi R8 on a Country Road',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "2015 Chevrolet Camaro ZL1 Coupe",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7'
));

td_demo_content::add_post(array(
    'title' => "Mercedes AMG C63 S Sedan",
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => 'Chevy Silverado Midnight Edition',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_9'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
	'title' => 'Volkswagen Golf SportWagen TDI',
	'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_9_id),
	'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
	'title' => "Chevrolet Corvette Stingray Review Notes",
	'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_9_id),
	'featured_image_td_id' => 'td_pic_1'
));

td_demo_content::add_post(array(
	'title' => "’70s F1 Cars Will Star at Goodwood",
	'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_6_id),
	'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
	'title' => 'Could Your Child Win a Season’s Racing?',
	'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_6_id),
	'featured_image_td_id' => 'td_pic_3'
));
//-------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Octane’s Goodwood Festival of Speed',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Motorsport Goes to the Movies',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => 'BRMs Go Back to Blyton',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => 'All the Best Bits of Goodwood Motorsport',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => 'LaFerrari, McLaren P1, and Porsche 918 On-Track',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_8'
));
//-------------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Mercedes-Benz Plans GLE Hybrid to Debut in New York',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => 'Two New Scion Models Confirmed for the New York Auto Show',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => 'Aston Martin DBX Concept: Gorgeous Electric Sports-Car',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => 'Acura to Bring Updated RDX to 2015 Chicago Auto Show',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'The Superest Supercars from Geneva',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_3'
));
//-------------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'The 66th IAA Cars Shows “Mobility Connects”',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Hudson Italia Emerges from Garage after 40 Years',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => 'Monterey Auctions See $393 Million in Sales',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => 'What Next for the Barn Finds?',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => 'Knobbly Lives Again',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_8'
));
//-------------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Holyrood Concours of Elegance',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => '400-hp BMW Diesel Just Around the Corner',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => 'Land Rover Recreates 1948 Production Line',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => 'The Lexus Hoverboard is Here and it’s Real',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_2'
));
//-------------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Volkswagen e-Golf SEL Premium',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => '605 HP Audi R8 Plus Dials the Power',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Tesla’s Prototype Model S Charger is a Freaky Robot',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => 'VW’s New Turbo 1.4',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => 'The Bloodhound Supersonic Car',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_7'
));
//-------------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Cadillac CT6: You Can’t Call It Fat',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => 'Buick Enclave Tuscan Edition',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => '2015 Lexus GX460 Luxury',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => '2016 Hyundai Sonata Hybrid',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => 'Roush Stage 3 Mustang',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_2'
));
//-------------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => '2016 Lincoln MKX',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => 'Land Rover Discovery Sport: Simply Unstoppable!',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Tesla Model S Convertible',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => '2017 Mercedes-AMG C63 Coupe Revealed',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => 'Bond’s New Aston Points to the DB’s Future',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_7'
));
//-------------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Lamborghini Huracan LP610-4',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => 'Dodge Unveils 2015 Charger Pursuit',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => '2016 Mercedes CLS Coupe',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => 'Lincoln Continental Concept Headed for Production',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => '2016 Camaro Starts at $26.695',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'Ford GT Spotted on Detroit Highway',
    'file' => td_global::$get_template_directory . '/includes/demos/cars/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_3'
));
