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
td_demo_misc::update_background('td_college_bg');



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
td_demo_misc::add_ad_image('custom_ad_1', 'td_college_post_ad');
td_demo_misc::add_ad_image('sidebar', 'td_college_sidebar_ad');
td_demo_misc::add_ad_image('header', 'td_college_header_ad');


/*  ----------------------------------------------------------------------------
    sidebars
 */
//default sidebar

td_demo_widgets::add_widget_to_sidebar('default', 'td_block_social_counter_widget',
    array (
        'custom_title'  => "",
        'facebook'     => "tagdiv",
        'instagram'     => "tagDiv",
        'youtube'       => "tagDiv"
    )
);

td_demo_widgets::remove_widgets_from_sidebar('default');
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
    'category_name' => 'College',
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
        'category_name' => 'Campus',
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
        'category_name' => 'Student Life',
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
        'category_name' => 'Fraternities',
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
        'category_name' => 'Financial',
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
    'category_name' => 'Study Abroad',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
));
$demo_cat_7_id =td_demo_category::add_category(array(
    'category_name' => 'Careers',
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
$demo_cat_8_id =td_demo_category::add_category(array(
    'category_name' => 'Technology',
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
$demo_cat_9_id =td_demo_category::add_category(array(
    'category_name' => 'Sport',
    'parent_id' => 0,
    'category_template' => '',
    'top_posts_style' => '',
    'description' => '',
    'background_td_pic_id' => '',
    'sidebar_id' => '',
    'tdc_layout' => '', //THE MODULE ID 1 2 3 NO NAME JUST ID
    'tdc_sidebar_pos' => '', //sidebar_left, sidebar_right, no_sidebar
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


/*  ----------------------------------------------------------------------------
    pages
 */
//homepage
$td_homepage_id = td_demo_content::add_page(array(
    'title' => 'Home',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/homepage.txt',
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
    'title' => 'College',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_1_id
));

// mega menu one subcateg
td_demo_menus::add_mega_menu(array(
	'title' => 'Study Abroad',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_6_id
));

td_demo_menus::add_mega_menu(array(
	'title' => 'Careers',
	'add_to_menu_id' => $td_demo_header_menu_id,
	'category_id' => $demo_cat_7_id
));

// add a subcategory to the sub-menu
$parent_submenu_id = td_demo_menus::add_link(array(
    'title' => 'More',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'url' => '#',
    'parent_id' => ''
));

td_demo_menus::add_category(array(
    'title' => 'Technology',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_8_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'Sport',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_9_id,
    'parent_id' => $parent_submenu_id
));
td_demo_menus::add_category(array(
    'title' => 'Health',
    'add_to_menu_id' => $td_demo_header_menu_id,
    'category_id' => $demo_cat_10_id,
    'parent_id' => $parent_submenu_id
));



/*  ---------------------------------------------------------------------------
    posts
*/
// post in featured category
td_demo_content::add_post(array(
    'title' => 'UK Students Continuing to Look Overseas',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'

));
td_demo_content::add_post(array(
    'title' => 'Back-to-School Money Tips for College',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => '10 Things About College Campuses',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_3',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => 'Elite Colleges Don’t Guarantee Success',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'Complete Guide to a Killer Confidence',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => 'The 38-Year-Old Frat Boy',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => 'Find the Best College for You',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => '8 Things College Students Don’t Need',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array(get_cat_ID(TD_FEATURED_CAT), $demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));


//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "5 Best College Majors for a Lucrative Career",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => "Working With Fraternities to Prevent Rape",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => "Social Networks Could Be Banned in Campus Networks",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "The Right Way to Borrow for College",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Top Apps that Students Absolutely Love",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id,$demo_cat_3_id,$demo_cat_4_id,$demo_cat_5_id,$demo_cat_6_id,$demo_cat_7_id,$demo_cat_8_id,$demo_cat_9_id,$demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_5'
));



//  ----------------------------------------------------------------------------
//  Mix Categories
td_demo_content::add_post(array(
    'title' => "8 Things College Students Don’t Need",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_1',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => "Students Cover Bathroom Mirrors with Messages",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => 'Find the Best College for You',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "The 38-Year-Old Frat Boy",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => "Here’s to a Great College Story",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_3_id),
    'featured_image_td_id' => 'td_pic_5'
));


//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "University Boots Frat For Nude Photos",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Elite Colleges Don’t Guarantee Success",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => "Sorority Video Generates Discrimination",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "Coming Out When You’re in a Frat",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "Banned Frat Parties After Alcohol Problems",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_4_id),
    'featured_image_td_id' => 'td_pic_10'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Safety Notice to Students after Campus Burglaries",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "Make the Most of a Campus Tour",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => "School’s About to Start – Let the Accomodation Begin!",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => '10 Things About College Campuses',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => "Best On-Campus Values in 2015",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_2_id),
    'featured_image_td_id' => 'td_pic_5',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "Back-to-School Money Tips for College",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => "Unusual Ways People Pay for College",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => 'Colleges That Let You Skip the Student Loans',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => "How to Cut Your Textbook Costs in Half",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => "Top Sources for College Scholarships",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_5_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => "The Pros and Cons of Getting a Degree Abroad",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => "Final Deadline for Europe Applications",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
    'title' => "Cambridge and Oxford are UK’s Best Universities",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => "Finding The Right Foreign College Is Hard",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_4',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => "First Master Student Coarses Agreed for Spain",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_6_id),
    'featured_image_td_id' => 'td_pic_5'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => '10 Great Part-Time Jobs for College Students',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => "Best Questions You Can Ask During a Job Interview",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_7'
));

td_demo_content::add_post(array(
    'title' => "How to Conquer Your First Career Fears",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => '10 Best College Majors for a Lucrative Career',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_9',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => 'Interviewing Advice in a Hot Job Market',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_10'
));
td_demo_content::add_post(array(
    'title' => 'The Worst College Majors for Your Career',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_7_id),
    'featured_image_td_id' => 'td_pic_1'
));

//  ----------------------------------------------------------------------------
td_demo_content::add_post(array(
	'title' => 'Putting More Technology In Universities',
	'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_8_id),
	'featured_image_td_id' => 'td_pic_2'
));
td_demo_content::add_post(array(
	'title' => "Drunk Mode App Is Redefining College Parties",
	'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_8_id),
	'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
	'title' => "New App Ensures Students Get Home Safe",
	'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_8_id),
	'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
	'title' => 'Students Develop Mind-Controlled Robotic Arm',
	'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
	'categories_id_array' => array($demo_cat_8_id),
	'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => "Top Online Courses for First Year Students",
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_8_id),
    'featured_image_td_id' => 'td_pic_6',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));

//-------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => '5 Essential Rules of Good Health',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_7',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => 'Obesity Linked to Major Heart Disease',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_8'
));
td_demo_content::add_post(array(
    'title' => 'Should You Visit Your Doctor?',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_9'
));
td_demo_content::add_post(array(
    'title' => '10 Ways to Stay Healthy This Winter',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_10',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
td_demo_content::add_post(array(
    'title' => 'What Young Men Should Ask Their Doctors',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_1'
));
td_demo_content::add_post(array(
    'title' => 'How to Prevent Study Stress',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_10_id),
    'featured_image_td_id' => 'td_pic_2'
));
//-------------------------------------------------------------------------------------
td_demo_content::add_post(array(
    'title' => 'Cameron Makes a Perfect Diving Catch',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_3'
));
td_demo_content::add_post(array(
    'title' => 'Freeskiing’s Blonde Wonder Woman',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_4'
));
td_demo_content::add_post(array(
    'title' => 'The Ball-Catching Expert Student Tells All',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_5'
));
td_demo_content::add_post(array(
    'title' => 'Team U.S.A Rugby’s Quest to Defend Gold',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_6'
));
td_demo_content::add_post(array(
    'title' => 'The NYC Girls Dominating Youth Chess',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/post_default.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_7'
));
td_demo_content::add_post(array(
    'title' => 'Where Does a College Coach Have You Ranked',
    'file' => td_global::$get_template_directory . '/includes/demos/college/pages/smart_list.txt',
    'categories_id_array' => array($demo_cat_9_id),
    'featured_image_td_id' => 'td_pic_8',
    'template' => 'single_template_5',
    'smart_list' => 'td_smart_list_7'
));
