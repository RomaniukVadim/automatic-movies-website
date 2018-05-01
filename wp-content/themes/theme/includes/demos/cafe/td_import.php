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

// mobile background
td_demo_misc::update_background_mobile('td_pic_10');

// footer background
td_demo_misc::update_background_footer('td_footer_bg');

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
    'youtube' => '#'
));


/*  ----------------------------------------------------------------------------
    ads
 */
td_demo_misc::clear_all_ads();


/*  ----------------------------------------------------------------------------
    sidebars
 */
//default sidebar
td_demo_widgets::remove_widgets_from_sidebar('default');

td_demo_widgets::add_widget_to_sidebar('default', 'td_block_social_counter_widget',
	array (
		'custom_title'  => "Get in Touch",
        'facebook'     => "tagdiv",
        'twitter'     => "envato",
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
    'category_name' => 'Blog',
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
        'category_name' => 'Receipes',
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
        'category_name' => 'Health',
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
        'category_name' => 'Events',
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
        'category_name' => 'Travel',
        'parent_id' => $demo_cat_1_id,
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
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/homepage.txt',
    'template' => 'page.php',   // the page template full file name with .php
    'td_layout' => '',
    'homepage' => true
));

//menu page
$td_menupage_id = td_demo_content::add_page(array(
    'title' => 'Menu',
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/menu.txt',
    'template' => 'page-pagebuilder-title.php',   // the page template full file name with .php
    'td_layout' => '',
    'sidebar_position' => 'no_sidebar',
    'homepage' => false
));

//coffee page
$td_coffeepage_id = td_demo_content::add_page(array(
    'title' => 'Coffee',
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/coffee.txt',
    'template' => 'page-pagebuilder-title.php',   // the page template full file name with .php
    'td_layout' => '',
    'sidebar_position' => 'no_sidebar',
    'homepage' => false
));

//pastry page
$td_pastrypage_id = td_demo_content::add_page(array(
    'title' => 'Pastry',
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/pastry.txt',
    'template' => 'page-pagebuilder-title.php',   // the page template full file name with .php
    'td_layout' => '',
    'sidebar_position' => 'no_sidebar',
    'homepage' => false
));

//desserts page
$td_dessertspage_id = td_demo_content::add_page(array(
    'title' => 'Desserts',
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/desserts.txt',
    'template' => 'page-pagebuilder-title.php',   // the page template full file name with .php
    'td_layout' => '',
    'sidebar_position' => 'no_sidebar',
    'homepage' => false
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

//add the menu page to the menu
td_demo_menus::add_page(array(
    'title' => 'Menu',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_menupage_id,
    'parent_id' => ''
));

//add the coffee page to the menu
td_demo_menus::add_page(array(
    'title' => 'Coffee',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_coffeepage_id,
    'parent_id' => ''
));

//add the pastry page to the menu
td_demo_menus::add_page(array(
    'title' => 'Pastry',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_pastrypage_id,
    'parent_id' => ''
));

//add the desserts page to the menu
td_demo_menus::add_page(array(
    'title' => 'Desserts',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_dessertspage_id,
    'parent_id' => ''
));


// mega menu multiple subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Blog',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));




/*  ---------------------------------------------------------------------------
    posts set 1
*/

td_demo_content::add_post(array(
    'title' => "Where to Go in Orange County",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_1'
));

td_demo_content::add_post(array(
    'title' => "5 Unique Ways to See Manhattan",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_2'
));

td_demo_content::add_post(array(
    'title' => "Start Exploring Brooklyn",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_3'
));

td_demo_content::add_post(array(
    'title' => "You Can No Longer Ignore Queens",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_4'
));

td_demo_content::add_post(array(
    'title' => "Long Weekend in NYC",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_5'
));


/*  ---------------------------------------------------------------------------
    posts set 2
*/


td_demo_content::add_post(array(
    'title' => "Global Food Photography Festival",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));

td_demo_content::add_post(array(
    'title' => "The New York Concert Month",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_7'
));

td_demo_content::add_post(array(
    'title' => "Top 10 Gallery Exhibitions",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));

td_demo_content::add_post(array(
    'title' => "NYC Book Festival",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_9'
));

td_demo_content::add_post(array(
    'title' => "The East Coast Delight",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_10'
));


/*  ---------------------------------------------------------------------------
    posts set 3
*/

td_demo_content::add_post(array(
    'title' => "The Dangers of Fast Food",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_1'
));

td_demo_content::add_post(array(
    'title' => "Good Sources of Potasium",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_2'
));

td_demo_content::add_post(array(
    'title' => "The Power of Protein",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_3'
));

td_demo_content::add_post(array(
    'title' => "Good Fats vs Bad Fats",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_4'
));

td_demo_content::add_post(array(
    'title' => "A Diet for Better Energy",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_5'
));


/*  ---------------------------------------------------------------------------
    posts set 4
*/


td_demo_content::add_post(array(
    'title' => "Fresh Strawberry Mousse",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default_receipes.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));

td_demo_content::add_post(array(
    'title' => "Chocolate Croissants",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default_receipes.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_7'
));

td_demo_content::add_post(array(
    'title' => "French Maccaroons",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default_receipes.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_8'
));

td_demo_content::add_post(array(
    'title' => "Delicious Chocolate Cake",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default_receipes.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_9'
));

td_demo_content::add_post(array(
    'title' => "Blueberry Muffins",
    'file' => td_global::$get_template_directory . '/includes/demos/cafe/pages/post_default_receipes.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_10'
));