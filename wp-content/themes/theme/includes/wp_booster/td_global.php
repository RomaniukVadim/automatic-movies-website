<?php



/**
 * td_global_blocks.php
 * Here we store the global state of the theme. All globals are here (in theory)
 *  - no td_util loaded, no access to settings
 */

class td_global {


	static $feature_locked = false; // lock features that are not ready


    static $td_options; //here we store all the options of the theme will be used in td_first_install.php
	static $td_options_changed_flag = false;

    static $current_template = ''; //used by page-homepage-loop, 404

    static $current_author_obj; //set by the author page template, used by widgets

    static $cur_url_page_id; //the id of the main page (if we have loop in loop, it will return the id of the page that has the uri)

    static $load_sidebar_from_template; //used by some templates for custom sidebars (setted by page-homepage-loop.php etc)

    static $load_featured_img_from_template; //used by single.php to instruct td_module_single to load the full with thumb when necessary (ex. no sidebars)

    static $cur_single_template_sidebar_pos = ''; // set in single.php - used by the gallery short code to show appropriate images

    static $cur_single_template = ''; /** @var string set here: @see  */


    static $is_woocommerce_installed = false; // at the end of this file we check if woo commerce is installed


    /**
     * @var stdClass holds the category object
     *      - it's set on pre_get_posts hook @see td_modify_main_query_for_category_page
     *      - WARNING: it can be null on category pages that request a category ID that dosn't exists
     */
    static $current_category_obj;

    //this is used to check for if we are in loop
    //also used for quotes in blocks - check isf the module is displayed on blocks or not
    static $is_wordpress_loop = '';

    static $custom_no_posts_message = '';  /** used to set a custom post message for the template. If this is set to false, the default message will not show @see td_page_generator::no_posts */


    /**
     * @var string used to store texts for: includes/wp_booster/wp-admin/content-metaboxes/td_set_video_meta.php
     * is set in td_config @see td_wp_booster_config::td_global_after
     */
    static $td_wp_admin_text_list = array();


    static $http_or_https = 'http'; //is set below with either http or https string  @see EOF


	//@todo refactor all code to use TEMPLATEPATH instead
    static $get_template_directory = '';  // here we store the value from get_template_directory(); - it looks like the wp function does a lot of stuff each time is called

	//@todo refactor all code to use STYLESHEETPATH instead
    static $get_template_directory_uri = ''; // here we store the value from get_template_directory_uri(); - it looks like the wp function does a lot of stuff each time is called


	static $td_viewport_intervals = array(); // the tdViewport intervals are stored


    /**
     * the js files that the theme uses on the front end (file_id - filename) @see td_wp_booster_config
     * @see td_wp_booster_hooks
     * @var array
     */
    static $js_files = array ();

	// the plugins that are installable via the theme > plugins panel & tgma
    static $theme_plugins_list = array();

	// the plugins that are just for information porpuses (the plugin cannot be installed with tgma, usually because the plugin is to big so we included it in the -tf/plugins folder)
	static $theme_plugins_for_info_list = array();

	static $td_animation_stack_effects = array();


    /**
     * the js files that are used in wp-admin
     * @var array
     */
    static $js_files_for_wp_admin = array (
        'td_wp_admin' => array(
	        'url' => '/includes/wp_booster/wp-admin/js/td_wp_admin.js',
	        'show_only_on_page_slugs' => ''
        ),
        'td_wp_admin_color_picker' => array (
	        'url' => '/includes/wp_booster/wp-admin/js/td_wp_admin_color_picker.js',
	        'show_only_on_page_slugs' => ''
        ),
        'td_wp_admin_panel' => array (
	        'url' => '/includes/wp_booster/wp-admin/js/td_wp_admin_panel.js',
	        'show_only_on_page_slugs' => ''
        ),
        'td_edit_page' => array (
	        'url' => '/includes/wp_booster/wp-admin/js/td_edit_page.js',
	        'show_only_on_page_slugs' => ''
        ),


	    // install demos scripts
        'tdDemoFullInstaller' => array (
	        'url' => '/includes/wp_booster/wp-admin/js/tdDemoFullInstaller.js',
	        'show_only_on_page_slugs' => array('td_theme_demos')
        ),

        'td_wp_admin_demos' => array (
	        'url' => '/includes/wp_booster/wp-admin/js/td_wp_admin_demos.js',
	        'show_only_on_page_slugs' => array('td_theme_demos')
        ),
        'tdDemoProgressBar' => array (
	        'url' => '/includes/wp_booster/wp-admin/js/tdDemoProgressBar.js',
	        'show_only_on_page_slugs' => array('td_theme_demos')
        ),



        'td_page_options' => array (
	        'url' => '/includes/wp_booster/wp-admin/js/td_page_options.js',
	        'show_only_on_page_slugs' => ''
        ),
        'td_tooltip' => array (
	        'url' => '/includes/wp_booster/wp-admin/js/tooltip.js',
	        'show_only_on_page_slugs' => ''
        ),

		// ace code editor
	    'td_ace' => array (
		    'url' => '/includes/wp_booster/wp-admin/external/ace/ace.js',
		    'show_only_on_page_slugs' => array('td_theme_panel')
	    ),
        'td_ace_ext_language_tools' => array (
	        'url' => '/includes/wp_booster/wp-admin/external/ace/ext-language_tools.js',
	        'show_only_on_page_slugs' => array('td_theme_panel')
        )

    );


    /**
     * @var array the tinyMCE style formats
     */
    static $tiny_mce_style_formats = array();


    /**
     * @var array
     *
     *  'td_full_width' => array(           - id used in the drop down in tinyMCE
     *      'text' => 'Full width',         - the text that will appear in the dropdown in tinyMCE
     *      'class' => 'td-post-image-full' - the class tha this image style will add to the image
     *  )
     *
     */
    static $tiny_mce_image_style_list = array();


    /**
     * here we store the fields form td-panel -> custom css
     * @var array
     */
    static $theme_panel_custom_css_fields_list = array();


    /**
     * the big grid styles used by the theme. This styles will show up in the panel @see td_panel_categories.php and on each big grid block
     */
    static $big_grid_styles_list = array();


    /**
     * @var array
     */
    static $all_theme_panels_list = array();



    static $translate_languages_list = array(
        'en' => 'English (default)',
        'af' => 'Afrikaans',
        'sq' => 'Albanian',
        'ar' => 'Arabic',
        'hy' => 'Armenian',
        'az' => 'Azerbaijani',
        'eu' => 'Basque',
        'be' => 'Belarusian',
        'bn' => 'Bengali',
        'bs' => 'Bosnian',
        'bg' => 'Bulgarian',
        'ca' => 'Catalan',
        'ceb' => 'Cebuano',
        'ny' => 'Chichewa',
        'zh' => 'Chinese (Simplified)',
        'zh-TW' => 'Chinese (Traditional)',
        'hr' => 'Croatian',
        'cs' => 'Czech',
        'da' => 'Danish',
        'nl' => 'Dutch',
        'eo' => 'Esperanto',
        'et' => 'Estonian',
        'tl' => 'Filipino',
        'fi' => 'Finnish',
        'fr' => 'French',
        'gl' => 'Galician',
        'ka' => 'Georgian',
        'de' => 'German',
        'el' => 'Greek',
        'gu' => 'Gujarati',
        'ht' => 'Haitian Creole',
        'ha' => 'Hausa',
        'iw' => 'Hebrew',
        'hi' => 'Hindi',
        'hmn' => 'Hmong',
        'hu' => 'Hungarian',
        'is' => 'Icelandic',
        'ig' => 'Igbo',
        'id' => 'Indonesian',
        'ga' => 'Irish',
        'it' => 'Italian',
        'ja' => 'Japanese',
        'jw' => 'Javanese',
        'kn' => 'Kannada',
        'kk' => 'Kazakh',
        'km' => 'Khmer',
        'ko' => 'Korean',
        'lo' => 'Lao',
        'la' => 'Latin',
        'lv' => 'Latvian',
        'lt' => 'Lithuanian',
        'mk' => 'Macedonian',
        'mg' => 'Malagasy',
        'ms' => 'Malay',
        'ml' => 'Malayalam',
        'mt' => 'Maltese',
        'mi' => 'Maori',
        'mr' => 'Marathi',
        'mn' => 'Mongolian',
        'my' => 'Myanmar (Burmese)',
        'ne' => 'Nepali',
        'no' => 'Norwegian',
        'fa' => 'Persian',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'pa' => 'Punjabi',
        'ro' => 'Romanian',
        'ru' => 'Russian',
        'sr' => 'Serbian',
        'st' => 'Sesotho',
        'si' => 'Sinhala',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'so' => 'Somali',
        'es' => 'Spanish',
        'su' => 'Sundanese',
        'sw' => 'Swahili',
        'sv' => 'Swedish',
        'tg' => 'Tajik',
        'ta' => 'Tamil',
        'te' => 'Telugu',
        'th' => 'Thai',
        'tr' => 'Turkish',
        'uk' => 'Ukrainian',
        'ur' => 'Urdu',
        'uz' => 'Uzbek',
        'vi' => 'Vietnamese',
        'cy' => 'Welsh',
        'yi' => 'Yiddish',
        'yo' => 'Yoruba',
        'zu' => 'Zulu'
    );



    /**
     * stack_filename => stack_name
     * @var array
     */
    public static $demo_list = array ();


    /**
     * the list of fonts used by the theme by default
     * @var array
     */
    public static $default_google_fonts_list = array();


    /**
     * @var string here we keep the typography settings from the THEME FONTS panel.
     * this is also used by the css compiler
     */
    public static $typography_settings_list = array ();




    // @todo clean this up
    private static $post = '';
    private static $primary_category = '';


    static function load_single_post($post) {

            self::$post = $post;


        /*  ----------------------------------------------------------------------------
            update the primary category Only on single posts :0
         */
        if (is_single()) {
            //read the post setting
            $td_post_theme_settings = get_post_meta(self::$post->ID, 'td_post_theme_settings', true);
            if (!empty($td_post_theme_settings['td_primary_cat'])) {
                self::$primary_category = $td_post_theme_settings['td_primary_cat'];
                return;
            }

            $categories = get_the_category(self::$post->ID);
            foreach($categories as $category) {
                if ($category->name != TD_FEATURED_CAT) { //ignore the featured category name
                    self::$primary_category = $category->cat_ID;
                    break;
                }
            }
        }
    }


    //used on single posts
    static function get_primary_category_id() {
        if (empty(self::$post->ID)) {
            return get_queried_object_id();
        }
        return self::$primary_category;
    }


    //generate unique_ids
    private static $td_unique_counter = 0;

    static function td_generate_unique_id() {
        self::$td_unique_counter++;
        return 'td_uid_' . self::$td_unique_counter . '_' . uniqid();
    }



}


if (is_ssl()) {
    td_global::$http_or_https = 'https';
}


require_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('woocommerce/woocommerce.php')) {
    td_global::$is_woocommerce_installed = true;
}


/**
 * td_global::$get_template_directory must be used instead of get_template_directory()
 * td_global::$get_template_directory_uri must be used instead of get_template_directory_uri()
 *
 * They supplies the get_template_directory() and get_template_directory_uri() if the mobile theme is not activated (actually, the mobile plugin is not activated).
 *
 * If the mobile plugin is activated, they will return the same values, but for doing this it needs to consider the td_mobile_theme class who saves these values. In this case,
 * the get_template_directory() and get_template_directory_uri() returns values corresponding to the mobile theme, and not to the main theme.
 */

$current_theme_name = get_template();

if (empty($current_theme_name) and class_exists('td_mobile_theme')) {
	td_global::$get_template_directory = td_mobile_theme::$main_dir_path;
	td_global::$get_template_directory_uri = td_mobile_theme::$main_uri_path;
} else {
	td_global::$get_template_directory = get_template_directory();
	td_global::$get_template_directory_uri = get_template_directory_uri();
}

