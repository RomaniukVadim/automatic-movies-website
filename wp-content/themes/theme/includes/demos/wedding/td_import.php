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
td_demo_misc::update_background('');

// mobile background
td_demo_misc::update_background_mobile('td_pic_9');

// footer background
td_demo_misc::update_background_footer('td_footer_bg');


/*  ----------------------------------------------------------------------------
    logo
*/
td_demo_misc::update_logo(array(
    'normal' => 'td_logo_header',
    'retina' => 'td_logo_header',
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
td_demo_misc::update_footer_text('Newspaper is your news, entertainment, music fashion website. We provide you with the latest news and videos straight from the entertainment industry.');



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
td_demo_misc::add_ad_image('smart_list_6', 'td_wedding_smartlist_ad');
td_demo_misc::add_ad_image('sidebar', 'td_wedding_sidebar_ad');


/*  ----------------------------------------------------------------------------
    sidebars
 */
//default sidebar
td_demo_widgets::remove_widgets_from_sidebar('default');

td_demo_widgets::add_widget_to_sidebar('default', 'td_block_social_counter_widget',
    array (
        'custom_title'  => "GET SOCIAL",
        'facebook'     => "tagdiv",
        'instagram'     => "tagDiv",
        'youtube'       => "tagDiv"
    )
);

td_demo_widgets::add_widget_to_sidebar('default', 'td_block_ad_box_widget',
    array (
        'spot_title' => '- Advertisement -',
        'spot_id' => 'sidebar'
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
    'category_name' => 'Planning',
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
        'category_name' => 'Ceremony',
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
        'category_name' => 'Fashion',
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
        'category_name' => 'Flowers',
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
        'category_name' => 'Hair & Makeup',
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
        'category_name' => 'Jewellery',
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
        'category_name' => 'Reception',
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
    'category_name' => 'Honeymoon',
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
    'category_name' => 'Photography',
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
    'category_name' => 'Ideas',
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
    'category_name' => 'Budget',
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
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/homepage.txt',
    'template' => 'page.php',   // the page template full file name with .php
    'td_layout' => '',
    'homepage' => true
));

//gallery
$td_gallery_id = td_demo_content::add_page(array(
    'title' => 'Gallery',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/gallery.txt',
    'template' => 'page.php',   // the page template full file name with .php
    'td_layout' => '',
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


// mega menu multiple subcateg
td_demo_menus::add_mega_menu(array(
    'title' => 'Planning',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));

td_demo_menus::add_page(array(
    'title' => 'Gallery',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'page_id' => $td_gallery_id,
    'parent_id' => ''
));

// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
	'title' => 'Honeymoon',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_8_id
));


// add a subcategory to the sub-menu
$parent_submenu_id = td_demo_menus::add_link(array(
    'title' => 'More',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => ''
));

td_demo_menus::add_category(array(
    'title' => 'Photography',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_9_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'Ideas',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_10_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'Budget',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_11_id,
    'parent_id' => $parent_submenu_id
));



/*  ---------------------------------------------------------------------------
    posts
*/
// posts in featured category

td_demo_content::add_post(array(
    'title' => '10 Tips for Staying Heathy & Happy on Your Honeymoon',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT)),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'These Wedding Photos Are Beautiful From Every Angle',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT)),
    'featured_image_td_id' => 'td_pic_2'
));

td_demo_content::add_post(array(
    'title' => '10 Amazing Tips on Socializing At Your Buddy’s Wedding',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT)),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'Bouquets That Are Perfect for a Fun and Colorful Wedding',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT)),
    'featured_image_td_id' => 'td_pic_4'
));

td_demo_content::add_post(array(
    'title' => 'What to Consider Before Planning an Outdoor Wedding',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT)),
    'featured_image_td_id' => 'td_pic_5'
));

/* ------------------------------------------------------------------ */
// posts in multiple categories

td_demo_content::add_post(array(
    'title' => '17 Trips to Consider For Your Honeymoon',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_12',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'Hottest Bridal Photo Styles From the Runways',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_11'
));

td_demo_content::add_post(array(
    'title' => 'Real Brides Spill Their Biggest Budget Mistakes',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_10'
));

td_demo_content::add_post(array(
    'title' => 'Tips on Breaking Up With a Wedding Vendor',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_9'
));

td_demo_content::add_post(array(
    'title' => 'Which Hair Extensions are Right for You?',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_8'
));

td_demo_content::add_post(array(
    'title' => 'Modern Wedding Bouquets with Texture',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_7'
));

td_demo_content::add_post(array(
    'title' => 'Best Groom’s Ring Guide Out There',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_6'
));

td_demo_content::add_post(array(
    'title' => 'Best Dress Rehearsal to Date',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_5'
));

td_demo_content::add_post(array(
    'title' => 'How to Transform Your Wedding With Lighting',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_4'
));

td_demo_content::add_post(array(
    'title' => '5 Stunning Ceremony Decor Ideas',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id,$demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */
// posts in one category

td_demo_content::add_post(array(
    'title' => 'Get the Most Out of Honeymoon Rental Services',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_1'
));

td_demo_content::add_post(array(
    'title' => '17 Trips to Consider For Your Honeymoon',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_2',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'Honeymoon Destination Closeup: Maldives',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_3'
));

td_demo_content::add_post(array(
    'title' => 'The Latest Travel Trends for Couples',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_4'
));

td_demo_content::add_post(array(
    'title' => '8 Places You Should Visit During your Honeymoon',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'Gorgeous Ways To Wear Your Hair For Your Photoshoot',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_6'
));

td_demo_content::add_post(array(
    'title' => 'These Wedding Photos Are Beautiful From Every Angle',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'What to Wear for Your Engagement Photos',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_8'
));

td_demo_content::add_post(array(
    'title' => 'Beautiful Ideas for Your Wedding Photos',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_9'
));

td_demo_content::add_post(array(
    'title' => '10 Totally Chill Engagement Photo Ideas',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'New Start-Up Will Help You Get Married For $99',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_11'
));

td_demo_content::add_post(array(
    'title' => 'These Wedding Photos Are Beautiful From Every Angle',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_12',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'What to Wear for Your Engagement Photos',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_1'
));

td_demo_content::add_post(array(
    'title' => 'Beautiful Ideas for Your Wedding Photos',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_2'
));

td_demo_content::add_post(array(
    'title' => '10 Totally Chill Engagement Photo Ideas',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_11_id),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'Peace and Love Wedding-Style',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_11'
));

td_demo_content::add_post(array(
    'title' => '10 Wedding Proposals that Will Make You Happy',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_12',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => '5 Ways to Mix Berry Tones Into Your Wedding',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_1'
));

td_demo_content::add_post(array(
    'title' => 'Super Weddings, Gatsby Style!',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_2'
));

td_demo_content::add_post(array(
    'title' => '10 Amazing Tips on Socializing At Your Buddy’s Wedding',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'Gorgeous Braided Wedding Hairstyles',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_4'
));

td_demo_content::add_post(array(
    'title' => '5 Ways to Handle Wedding-Day Emergencies',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'Find the Right Makeup for Your Skin Tone',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));

td_demo_content::add_post(array(
    'title' => 'Gorgeous Ways To Wear Your Hair Down',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_7'
));

td_demo_content::add_post(array(
    'title' => '10 Stunning Ideas for Your Wedding Makeup',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'Garden-Gorgeous Wedding Bouquets',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_9'
));

td_demo_content::add_post(array(
    'title' => '15 Ways to Use Red Roses in Your Wedding',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'Bouquets That Are Perfect for a Fun and Colorful Wedding',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_11'
));

td_demo_content::add_post(array(
    'title' => 'Fresh Ideas for Your Wedding Flowers',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_12'
));

td_demo_content::add_post(array(
    'title' => 'Fabulous Flowers for Fall Weddings',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'Keep Your Wedding Rings Looking Perfect',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_2'
));

td_demo_content::add_post(array(
    'title' => '10 Cute Ideas for Your Ring Bearer',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'Find Your Dream Wedding Ring',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_4'
));

td_demo_content::add_post(array(
    'title' => 'These Gems are Truly Outrageous',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_5'
));

td_demo_content::add_post(array(
    'title' => '4 Apps for Finding Your Perfect Ring',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'The Wedding Jumpsuit is Here to Stay',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_7'
));

td_demo_content::add_post(array(
    'title' => '6 Reasons Why the Dress Doesn’t Fit',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'To Veil Or Not To Veil?',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_9'
));

td_demo_content::add_post(array(
    'title' => 'Simple & Elegant Wedding Dresses',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_10'
));

td_demo_content::add_post(array(
    'title' => 'Bridal Fashion and Fun at the Mansion',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_11',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));


/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'The Biggest Wedding Trends for 2015',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_12'
));

td_demo_content::add_post(array(
    'title' => '15 Fun Wedding Reception Ideas',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'Find Your Dream Wedding Venue',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_2'
));

td_demo_content::add_post(array(
    'title' => 'What to Consider Before Planning an Outdoor Wedding',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_3'
));

td_demo_content::add_post(array(
    'title' => '15 Romantic Ideas for Your Wedding Reception',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

/* ------------------------------------------------------------------ */

td_demo_content::add_post(array(
    'title' => 'Exciting Ideas for Your Ceremony Exit',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_5'
));

td_demo_content::add_post(array(
    'title' => '40 Ways to Decorate Your Ceremony Aisle',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));

td_demo_content::add_post(array(
    'title' => 'Beautiful Outdoor Wedding Ceremonies',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_7'
));

td_demo_content::add_post(array(
    'title' => 'Our Guide to Writing Your Own Vows',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_8'
));

td_demo_content::add_post(array(
    'title' => '10 Very Pretty Ceremony Backdrops',
    'file' => td_global::$get_template_directory . '/includes/demos/wedding/pages/post_smart.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_6'
));
