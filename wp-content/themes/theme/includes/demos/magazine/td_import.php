<?php
/*  ---------------------------------------------------------------------------
    top menu - MENUS MUST HAVE THE FOLLOWING NAMES:
    td-demo-top-menu
    td-demo-header-menu
    td-demo-footer-menu
*/

//main menu
$td_demo_header_menu_id = td_demo_menus::create_menu('td-demo-header-menu', 'header-menu');


//top menu
$td_demo_top_menu = td_demo_menus::create_menu('td-demo-top-menu', 'top-menu');
td_demo_menus::add_link(array(
    'title' => 'Advertisement',
    'add_to_menu_id' => $td_demo_top_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Blog',
    'add_to_menu_id' => $td_demo_top_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Contact us',
    'add_to_menu_id' => $td_demo_top_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Buy now',
    'add_to_menu_id' => $td_demo_top_menu,
    'url' => 'http://themeforest.net/item/newspaper/5489609',
    'parent_id' => ''
));

//footer menu
$td_demo_footer_menu = td_demo_menus::create_menu('td-demo-footer-menu', 'footer-menu');
td_demo_menus::add_link(array(
    'title' => 'Advertisement',
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
    'title' => 'Contact us',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Buy now',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => 'http://themeforest.net/item/newspaper/5489609',
    'parent_id' => ''
));



/*  ----------------------------------------------------------------------------
    background - leave empty if you want to make sure that there is NO background on the demo - td_demo_misc::update_background('');
 */
td_demo_misc::update_background('td_bg', false);

// mobile menu background
td_demo_misc::update_background_mobile('td_pic_1');


/*  ----------------------------------------------------------------------------
    logo
 */
td_demo_misc::update_logo(array(
    'normal' => 'td_logo_header',
    'retina' => 'td_logo_header@2x',
    'mobile' => 'td_logo_footer'
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
    'behance' => '#',
    'facebook' => '#',
    'instagram' => '#',
    'twitter' => '#',
    'vimeo' => '#',
    'vk' => '#'
));


/*  ----------------------------------------------------------------------------
    ads
 */
td_demo_misc::clear_all_ads();
td_demo_misc::add_ad_image('header', 'td_header_ad');
td_demo_misc::add_ad_image('sidebar', 'td_sidebar_ad');


/*  ----------------------------------------------------------------------------
    sidebars
 */
//default sidebar
td_demo_widgets::remove_widgets_from_sidebar('default');
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_social_counter_widget',
	array (
		'custom_title'  => "Stay connected",
		'facebook'     => "tagdiv",
		'twitter'     => "envato",
		'youtube'       => "tagDiv"
	)
);
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_ad_box_widget',
    array (
        'spot_title' => '- Advertisement -',
        'spot_id' => 'sidebar'
    )
);
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_21_widget',
	array (
		'sort' => '',
		'custom_title' => 'Latest article',
		'limit' => '3',
		'header_color' => ''
	)
);




/*  ---------------------------------------------------------------------------
    categories
*/
$demo_cat_1_id =td_demo_category::add_category(array(
    'category_name' => 'Lifestyle',
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
        'category_name' => 'Travel',
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
        'category_name' => 'Health',
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
        'category_name' => 'Music',
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
        'category_name' => 'Recipes',
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
    'category_name' => 'World',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_7_id =td_demo_category::add_category(array(
    'category_name' => 'Fashion',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_8_id =td_demo_category::add_category(array(
    'category_name' => 'Sport',
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
    'category_name' => 'Music',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'From festivals in Florida to touring Dracula’s digs in Romania, we round up the best destinations to visit this October. As summer abandons Europe again this October, eke out the last of the rays and raves in Ibiza, where nightclubs will be going out with a bang for the winter break. When the party finally stops head to the island’s north.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_10_id =td_demo_category::add_category(array(
    'category_name' => 'Photography',
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
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/homepage.txt',
    'template' => 'page-pagebuilder-latest.php',   // the page template full file name with .php
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

// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
	'title' => 'World',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_6_id
));

// mega menu multiple subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Lifestyle',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));

td_demo_menus::add_mega_menu(array(
	'title' => 'Fashion',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_7_id
));

td_demo_menus::add_mega_menu(array(
	'title' => 'Sport',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_8_id
));

td_demo_menus::add_mega_menu(array(
    'title' => 'Music',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_9_id
));

// add a subcategory to the sub-menu
$parent_submenu_id = td_demo_menus::add_link(array(
    'title' => 'More',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => ''
));

td_demo_menus::add_link(array(
    'title' => 'Food & Recipes',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_link(array(
    'title' => 'Photography',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_link(array(
    'title' => 'Recipes',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_link(array(
    'title' => 'Travel',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_link(array(
    'title' => 'Arts',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => $parent_submenu_id
));



/*  ---------------------------------------------------------------------------
    posts
*/
td_demo_content::add_post(array(
    'title' => 'The Workout That Burns More Calories Than Running',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'Gigabyte GeForce GTX 950 Review: Pricing Is Everything',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => 'A Thomas Hart Benton Mural, Repurposed as a Writing Desk',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Fashion Week Parties: Night 4',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_5'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "The Definitive Guide To Marketing Your Business On Instagram",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => ''
));
td_demo_content::add_post(array(
    'title' => "Mobile Marketing and the Future of E-Commerce",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => ''
));
td_demo_content::add_post(array(
    'title' => "Things to Look For in a Financial Trading Platform",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => ''
));
td_demo_content::add_post(array(
    'title' => "A Look at How Social & Mobile Gaming Increase Sales",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => ''
));
td_demo_content::add_post(array(
    'title' => "Boxtrade Lands $50 Million In Another New Funding Round",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => ''
));


// post in featured category
td_demo_content::add_post(array(
    'title' => 'Celebrity make-up artist Gary Cockerill shows you beauty trick',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_1_id),
    'featured_image_td_id' => 'td_pic_1'
));

//  ----------------------------------------------------------------------------
//  Mix Cat
td_demo_content::add_post(array(
    'title' => "The Secret to Your Company's Financial Health",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Burberry is the first brand to get an Apple Music channel",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => 'How Pixar brings its animated movies to life',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => "New movies and TV shows to stream on Netflix, Amazon and Hulu",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "Minions is now the second biggest animated movie ever",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_11'
));


//  ----------------------------------------------------------------------------
//
td_demo_content::add_post(array(
    'title' => "The Most Popular Celebrity Baby Names of the Millennium",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "E!'s Fashion Finder: Biggest Shows, Parties and Celebrity",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Ben Affleck and Jennifer Garner at Farmers Market in LA",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Celebrity make-up artist Gary Cockerill shows you beauty trick",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Kristen Stewart at the Toronto Film Festival 2015",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Cover Girl Announces Star Wars Makeup Line",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "10 Outfits Inspired by Famous Works of Art",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "7 Coolest Fashion Startups You Should Know About",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => 'The Pros and Cons of Permanent Make-up',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_11'
));
td_demo_content::add_post(array(
    'title' => "MakeUp in New York 2015 unveils a series of hot innovations",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_12'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Trinity Audio Delta Review: Fighting the Hybrid Fight",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_13'
));
td_demo_content::add_post(array(
    'title' => "New Samsung Speakers Play 360-Degree Audio",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_14'
));
td_demo_content::add_post(array(
    'title' => 'Bose SoundTrue Ultra In-Ear Headphones Launched',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_15'
));
td_demo_content::add_post(array(
    'title' => "Grain Audio OEHP On-Ear Headphones, Save 25%",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Technology Tell Review: IK Multimedia iRig Mic Studio",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_7'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "The best gadgets from IFA 2016",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Gigabyte GeForce GTX 950 Review: Pricing Is Everything",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Apple Watch Climbs the List of the Top Wearable Gadgets",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Geeky Gadgets Deals Of The Week",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => "The Hottest Wearable Tech and Smart Gadgets of 2016",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Entertainment buzz: Taylor Swift gets an Emmy',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_13'
));
td_demo_content::add_post(array(
    'title' => "Village Roadshow Entertainment Secures $480 Million",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_10'
));

td_demo_content::add_post(array(
    'title' => "How Grand Theft Auto hijacked the entertainment industry",
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_12'
));
td_demo_content::add_post(array(
    'title' => 'Apple TV is finally changing the living room',
    'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_15'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
	'title' => 'Lenovo Introduces Its Best Entertainment Tablets Yet',
	'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_7_id),
	'featured_image_td_id' => 'td_pic_14'
));
td_demo_content::add_post(array(
	'title' => "Margaret Cho Designs Solitaire Jumpsuit For Betabrand",
	'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_6_id),
	'featured_image_td_id' => 'td_pic_10'
));

td_demo_content::add_post(array(
	'title' => "Day 3 of Spring 2016 New York Fashion Week's most inspiring",
	'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_5_id),
	'featured_image_td_id' => 'td_pic_12'
));
td_demo_content::add_post(array(
	'title' => 'The Hottest Hairstyle at Fashion Week Is Not on the Runways',
	'file' => td_global::$get_template_directory . '/includes/demos/magazine/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_7_id),
	'featured_image_td_id' => 'td_pic_14'
));