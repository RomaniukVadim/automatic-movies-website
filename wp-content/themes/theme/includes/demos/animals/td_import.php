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
    'title' => 'About',
    'add_to_menu_id' => $td_demo_top_menu,
    'url' => '#',
    'parent_id' => ''
));
td_demo_menus::add_link(array(
    'title' => 'Contact',
    'add_to_menu_id' => $td_demo_top_menu,
    'url' => '#',
    'parent_id' => ''
));


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
td_demo_misc::update_background('td_animals_bg', false);

// mobile background
td_demo_misc::update_background_mobile('td_pic_10');



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
    'normal' => 'td_logo_footer',
    'retina' => ''
));


/*  ----------------------------------------------------------------------------
    footer text
 */
td_demo_misc::update_footer_text('Newspaper is your news, entertainment, music fashion website. We provide you with the latest news and videos straight from the entertainment industry.');



/*  ----------------------------------------------------------------------------
    socials
 */
td_demo_misc::add_social_buttons(array(
    'facebook' => '#',
    'twitter' => '#',
    'instagram' => '#',
    'youtube' => '#'
));


/*  ----------------------------------------------------------------------------
    ads
 */
td_demo_misc::clear_all_ads();
td_demo_misc::add_ad_image('custom_ad_1', 'td_animals_post_ad');
td_demo_misc::add_ad_image('sidebar', 'td_animals_sidebar_ad');
td_demo_misc::add_ad_image('header', 'td_animals_header_ad');


/*  ----------------------------------------------------------------------------
    sidebars
 */
//default sidebar

td_demo_widgets::remove_widgets_from_sidebar('default');



td_demo_widgets::add_widget_to_sidebar('default', 'td_block_9_widget',
    array (
        'sort' => '',
        'custom_title' => 'Recent Posts',
        'limit' => '5',
        'header_color' => ''
    )
);

td_demo_widgets::add_widget_to_sidebar('default', 'td_block_popular_categories_widget',
    array (
        'custom_title' => 'POPULAR CATEGORIES',
        'limit' => '6',
        'header_color' => ''
    )
);



/*  ---------------------------------------------------------------------------
    categories
*/
$demo_cat_1_id =td_demo_category::add_category(array(
    'category_name' => 'Pets',
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
        'category_name' => 'Birds',
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
        'category_name' => 'Cats',
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
        'category_name' => 'Dogs',
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
        'category_name' => 'Fish',
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
        'category_name' => 'Rodents',
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
    'category_name' => 'Wild',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_8_id =td_demo_category::add_category(array(
    'category_name' => 'Farm',
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
$demo_cat_9_id =td_demo_category::add_category(array(
    'category_name' => 'Circus',
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
$demo_cat_10_id =td_demo_category::add_category(array(
    'category_name' => 'Health',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_11_id =td_demo_category::add_category(array(
    'category_name' => 'Facts',
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
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/homepage.txt',
    'template' => 'page-pagebuilder-latest.php',   // the page template full file name with .php
    'td_layout' => '10',
    'limit' => '5',
    'homepage' => true
));

/*  ----------------------------------------------------------------------------
    menu
 */

//add the homepage to the menu
td_demo_menus::add_page(array(
    'title' => '<i class="td-icons-home td-icons-animals"></i>Home',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_homepage_id,
    'parent_id' => ''
));


// mega menu multiple subcateg
td_demo_menus::add_mega_menu(array(
    'title' => '<i class="td-icons-pets td-icons-animals"></i>Pets',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));

// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
	'title' => '<i class="td-icons-wild td-icons-animals"></i>Wild',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_7_id
));

td_demo_menus::add_mega_menu(array(
	'title' => '<i class="td-icons-farm td-icons-animals"></i>Farm',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_8_id
));

td_demo_menus::add_mega_menu(array(
    'title' => '<i class="td-icons-circus td-icons-animals"></i>Circus',
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

td_demo_menus::add_category(array(
    'title' => 'Health',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_10_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'Facts',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_11_id,
    'parent_id' => $parent_submenu_id
));


/*  ---------------------------------------------------------------------------
    posts
*/

// post in featured category
td_demo_content::add_post(array(
    'title' => 'People Ask for Tougher Laws Against Animal Poaching',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'

));
td_demo_content::add_post(array(
    'title' => 'The Mystery Of The Vampire Rabbit',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'New Life Extending Drug For Dogs',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_3'
));

//  ----------------------------------------------------------------------------

td_demo_content::add_post(array(
    'title' => "6 Surprising Facts About Farm Animal Intelligence",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => "Helping Kids Cope with Pet Loss",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Nation Aims to Train Therapy Dogs for Veterans",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => "Meet Cholita, The Abused Circus Girrafe from Peru",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "A New Look At Chickens",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_9'
));



//  ----------------------------------------------------------------------------
//  Mix Categories

td_demo_content::add_post(array(
    'title' => "5 Ways to Prepare Your Backyard for Birds",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => "Exotic Birds Need Care Too",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'Backyard Birds and Bird Feeders',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "For the Birds and Butterflies",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "European Birds Species on the Decline",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_5'
));

//  ----------------------------------------------------------------------------

td_demo_content::add_post(array(
    'title' => "8 Funny Facts About your Furry Feline Friend",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => "Banning Cats As Pets in the Next 10 Years",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => 'Kind-hearted Cat Nurses Sick Animals Better',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Adoptable Black Cats… Because Black Cats Matter!",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "For The Love Of A Mother Cat",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_10'
));


//  ----------------------------------------------------------------------------

td_demo_content::add_post(array(
    'title' => "Air Canada Pilot Diverts Flight To Save A Dog’s Life",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "Leala The Pit Bull Saves The Life Of Her Friend",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => "Abandoned Dog Taught Sign Language By Deaf Child",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "5 Things You Need to Know before You Get A Dog",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4'
));

//  ----------------------------------------------------------------------------

td_demo_content::add_post(array(
    'title' => "Spot Signs of Distress in Your Fish",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Finding Dory Poster Released",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => 'The Aquarium Trade',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Something Smells Fishy",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "5 Mind Blowing Facts about Fish",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

//  ----------------------------------------------------------------------------

td_demo_content::add_post(array(
    'title' => "Unusual Rodents that Are Legal to Own",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "The Easter Bunny and Me",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => "Cuban Couple Tame Massive Rodent",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "Amazing Facts about the Vampire Squirrel",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

//  ----------------------------------------------------------------------------

td_demo_content::add_post(array(
    'title' => 'Lunch With A Side Of African Elephant',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => "Male Sloths Are Not Lazy, Study Confirms",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => '6 Surprising Facts about Lions',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => 'Celebrating the 10th Anniversary of our Sanctuary',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => 'Pollution Affecting Tigers',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_1'
));

//  ----------------------------------------------------------------------------

td_demo_content::add_post(array(
	'title' => 'Why We Love Farm Animals',
	'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_8_id),
	'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
	'title' => "Farm Sanctuary Adds Third Shelter",
	'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_8_id),
	'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
	'title' => "Tamaya is Horse Heaven for People Too",
	'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_8_id),
	'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
	'title' => 'Crazy barn Life At Cincinaty Ranch',
	'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_8_id),
	'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Top Strategies for Farm Animal Growth",
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

//-------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => '3 Ways of Saving Circus Animals',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
td_demo_content::add_post(array(
    'title' => 'Honduras Bans Circuses',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => 'Protect Horses from Cruel Entertainment on World Animal Day',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => 'Dolphins are Wildlife, Not Entertainers',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

//-------------------------------------------------------------------------------------

td_demo_content::add_post(array(
    'title' => 'Tips for Keeping Aging Pets Healthy',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => 'Vet Exposes Sugary Secret of Pet Treats',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Hip Dysplasia and Dogs',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => 'Ending the Bear Bile Industry',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_6'
));

//-------------------------------------------------------------------------------------

td_demo_content::add_post(array(
    'title' => 'Top Facts about Animal Behaviour',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'If You Eat Meat You Need To Know These 5 Facts',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => 'Pets Can Ride Public Trains Legally',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => '6 Animals that Went Viral Around the World',
    'file' => td_global::$get_template_directory . '/includes/demos/animals/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));