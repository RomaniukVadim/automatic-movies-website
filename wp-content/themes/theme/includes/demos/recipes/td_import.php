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
    'title' => 'Chicken & Beef',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Deserts',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Pasta',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Salads',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Shakes & Smoothies',
    'add_to_menu_id' => $td_demo_footer_menu,
    'url' => 'http://themeforest.net/item/newspaper/5489609',
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

// footer background
td_demo_misc::update_background_footer('');

// mobile menu background
td_demo_misc::update_background_mobile('td_pic_8');



/*  ----------------------------------------------------------------------------
    logo
 */
td_demo_misc::update_logo(array(
    'normal' => 'td_logo_header',
    'retina' => '',
    'mobile' => 'td_logo_mobile'
));


//footer
td_demo_misc::update_footer_logo(array(
    'normal' => 'td_logo_mobile',
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
    'evernote' => '#',
    'facebook' => '#',
    'twitter' => '#',
    'vk' => '#',
    'youtube' => '#'
));


/*  ----------------------------------------------------------------------------
    ads
 */
td_demo_misc::clear_all_ads();
td_demo_misc::add_ad_image('custom_ad_1', 'td_header_ad');


/*  ----------------------------------------------------------------------------
    sidebars
 */
//default sidebar
td_demo_widgets::remove_widgets_from_sidebar('default');
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_social_counter_widget',
	array (
		'custom_title'  => "Stay connected",
		'googleplus'  => "103996378256674536092",
		'twitter'     => "envato",
		'youtube'       => "tagDiv",
        'header_color' => '#000'
	)
);
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_popular_categories_widget',
	array (
		'sort' => '',
		'custom_title' => 'Recipe categories',
		'limit' => '8',
		'header_color' => '#000'
	)
);
td_demo_widgets::add_widget_to_sidebar('default', 'td_block_7_widget',
    array (
        'sort' => '',
        'custom_title' => 'Recipe of the day',
        'limit' => '5',
        'header_color' => '#000'
    )
);




/*  ---------------------------------------------------------------------------
    categories
*/
$demo_cat_1_id =td_demo_category::add_category(array(
    'category_name' => 'Recipes',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'Browse our collection of family favourite meals for deliciously simple and crowd-pleasing recipes to get supper on the table in a jiffy. Find easy cheesecake recipes to make a show-stopping end to any dinner.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
    $demo_cat_2_id =td_demo_category::add_category(array(
        'category_name' => 'Chicken & Beef',
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
        'category_name' => 'Deserts',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => 'Browse our collection of family favourite meals for deliciously simple and crowd-pleasing recipes to get supper on the table in a jiffy. Find easy cheesecake recipes to make a show-stopping end to any dinner.',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_4_id =td_demo_category::add_category(array(
        'category_name' => 'Pasta',
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
        'category_name' => 'Salads',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => 'Browse our collection of family favourite meals for deliciously simple and crowd-pleasing recipes to get supper on the table in a jiffy. Find easy cheesecake recipes to make a show-stopping end to any dinner.',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));
    $demo_cat_6_id =td_demo_category::add_category(array(
        'category_name' => 'Smoothies',
        'parent_id' => $demo_cat_1_id,
        'category_template' => '',
        'top_posts_style' => '',
        'description' => 'Browse our collection of family favourite meals for deliciously simple and crowd-pleasing recipes to get supper on the table in a jiffy. Find easy cheesecake recipes to make a show-stopping end to any dinner.',
        'background_td_pic_id' => '',
        'sidebar_id' => '',
        'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
        'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    ));

$demo_cat_7_id =td_demo_category::add_category(array(
    'category_name' => 'Video',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'Browse our collection of family favourite meals for deliciously simple and crowd-pleasing recipes to get supper on the table in a jiffy. Find easy cheesecake recipes to make a show-stopping end to any dinner.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '' //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_8_id =td_demo_category::add_category(array(
    'category_name' => 'Recipe of The Day',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => 'Browse our collection of family favourite meals for deliciously simple and crowd-pleasing recipes to get supper on the table in a jiffy. Find easy cheesecake recipes to make a show-stopping end to any dinner.',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
    'tdc_category_td_grid_style' => ''
));
$demo_cat_9_id =td_demo_category::add_category(array(
    'category_name' => 'Quick and Easy Recipes',
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
    'category_name' => 'Kids Menu',
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
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/homepage.txt',
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

// mega menu multiple subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Recipes',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));

// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
	'title' => 'Kids Menu',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_10_id
));

td_demo_menus::add_mega_menu(array(
	'title' => 'Quick Recipes',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_9_id
));

td_demo_menus::add_mega_menu(array(
	'title' => 'Video',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_7_id
));

td_demo_menus::add_mega_menu(array(
    'title' => 'Recipe of The Day',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_8_id
));

// add a subcategory to the sub-menu
$parent_submenu_id = td_demo_menus::add_link(array(
    'title' => 'Blog',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => ''
));



/*  ---------------------------------------------------------------------------
    posts
*/
//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Caramel Whipped Cream Chocolate Cake",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => ''
));
td_demo_content::add_post(array(
    'title' => "Best Chocolate Chip Cookies",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => ''
));
td_demo_content::add_post(array(
    'title' => "Rocky Road Ice Cream",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => ''
));
td_demo_content::add_post(array(
    'title' => "Soft Double Chocolate Cookies",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => ''
));
td_demo_content::add_post(array(
    'title' => "Fresh Fruit Cobbler",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => ''
));



//  ----------------------------------------------------------------------------
//  Mix Cat
td_demo_content::add_post(array(
    'title' => "Ultimate Triple Chocolate Muffins",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Chicken and Couscous Salad",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => 'Spicy Warm Chicken Salad',
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => "Broccoli and Cauliflower Salad With Feta",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "Blackberry Spinach Salad",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_11'
));


//  ----------------------------------------------------------------------------
//
td_demo_content::add_post(array(
    'title' => "Bacon, Egg and Potato Salad",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "Healthy Roast Chicken",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Roast Beef With Thyme and Fennel Crust",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Duck and Pepper Stir Fry",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Beef Pot Roast",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Chicken Jalfrezi",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Chicken and Fried Rice",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "Pork Kebabs With Grilled Plums and Couscous",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => 'Quick Italian Tomato Sauce',
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_11'
));
td_demo_content::add_post(array(
    'title' => "Basil Chicken with Vermicelli",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_12'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Spicy Herb Chicken Pasta",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_13'
));
td_demo_content::add_post(array(
    'title' => "Chinese Noodle Chicken",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_14'
));
td_demo_content::add_post(array(
    'title' => 'Greek Pasta Salad',
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_15'
));
td_demo_content::add_post(array(
    'title' => "Spicy Herb Chicken Pasta",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Easy Olive Oil, Tomato and Basil Pasta",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_7'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Clean Eating Green Smoothie",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Sparkling Strawberry Smoothie",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Red, White and Blue Protein Smoothie",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Blueberry Cheesecake Protein Shake",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => "Girl Scout Cookie Samoa Shake",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Skinny Avocado Egg Sandwich',
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_13'
));
td_demo_content::add_post(array(
    'title' => "Apple Pumpkin Muffins",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_10'
));

td_demo_content::add_post(array(
    'title' => "Chunky Monkey Pancakes",
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_12'
));
td_demo_content::add_post(array(
    'title' => 'Fast and Easy Pancakes',
    'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_15'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
	'title' => 'Fresh Fruit Trifle',
	'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_7_id),
	'featured_image_td_id' => 'td_pic_14'
));
td_demo_content::add_post(array(
	'title' => "Rocky Road Bites",
	'file' => td_global::$get_template_directory . '/includes/demos/recipes/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_6_id),
	'featured_image_td_id' => 'td_pic_10'
));