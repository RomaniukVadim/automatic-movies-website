<?php


class td_api_base {


    // flag marked by get_by_id and get_key function. It's used just for debugging
    const USED_ON_PAGE = 'used_on_page';

    const CLASS_AUTOLOADED = 'class_autoloaded'; // flag for marking autoloaded classes

    const TYPE = 'type';

    // the main array settings
    private static $components_list = array();



    /**
     * This method adds settings in the main settings array (self::$component_list)
     * An array of settings is set for the ($class_name, $id) key.
     * If there already exists the ($class_name, $id) key in the main settings array, an error exception is thrown. The update
     * method must be used instead, which ensures the settings are not previously loaded using self::get_by_id or self::get_key
     * method.
     *
     * @param $class_name string The array key in the self::$component_list
     * @param $id string string The array key in the self::$component_list[$class_name]
     * @param $params_array array The value set for the self::$component_list[$class_name][$id]
     * @throws ErrorException The exception thrown if the self::$component_list[$class_name][$id] is already set
     */
    protected static function add_component($class_name, $id, $params_array) {
        if (!isset(self::$components_list[$id])) {

            $params_array[self::TYPE] = $class_name;
	        self::$components_list[$id] = $params_array;

        } else {
            td_util::error(__FILE__, "td_api_base: A component with the ID: $id it's already registered in td_api_base", self::$components_list[$id]);
        }
    }



    /**
     * This method gets the value set for ($class_name) in the main settings array (self::$component_list)
     * This method does not set the self::USED_ON_PAGE flag, as self::get_by_id or self::get_key method does
     *
     * Important! As the flag self::USED_ON_PAGE is not marked, the 'file' parameter is removed to ensure that nobody can use (require) the component
     *
     * @param $class_name string The array key in the self::$component_list
     * @return mixed The value of the self::$component_list[$class_name]
     */
    static function get_all_components_metadata($class_name) {
        $final_array = array();

        foreach (self::$components_list as $component_key => $component_value) {
            if (isset($component_value[self::TYPE])
                and $component_value[self::TYPE] == $class_name) {

	            if (isset($component_value['file'])) {
		            unset($component_value['file']);
	            }

                $final_array[$component_key] = $component_value;
            }
        }
        return $final_array;
    }



    /**
     * returns the default component key value for a particular class. As of now, the default component is the first one that was added
     * we usually use this value when there is no setting in the database
     * Note: it marks the component as used on page
     *
     * @param $class_name
     * @param $key
     * @return mixed
     * @throws ErrorException
     */
    protected static function get_default_component_key($class_name, $key) {
	    foreach (self::$components_list as $component_id => $component_value) {

		    if (isset($component_value[self::TYPE])
		        and $component_value[self::TYPE] == $class_name) {

			    self::mark_used_on_page($component_id);

			    if ($key == 'file') {
				    self::locate_the_file($component_id);
			    }
			    return $component_value[$key];
		    }
	    }
	    td_util::error(__FILE__, "td_api_base::get_default_component_key : no component of type $class_name . Wp booster tried to get
        the default component (the first registered component) but there are no components registered.");
    }



	/**
	 * - returns the id of the default component for a particular class.
	 *
	 * @param $class_name - the class name of the component @see self::$components_list
	 *
	 * @return int|string - the id of the component @see self::$components_list
	 */
    protected static function get_default_component_id($class_name) {
        foreach (self::$components_list as $component_id => $component_value) {

            if (isset($component_value[self::TYPE])
                and $component_value[self::TYPE] == $class_name) {

                self::mark_used_on_page($component_id);
                return $component_id;
            }
        }
        td_util::error(__FILE__, "td_api_base::get_default_component_id  : no component of type $class_name . Wp booster tried to get
        the default component (the first registered component) but there are no components registered.");
    }



    /**
     * This method gets the value set for ($class_name, $id) in the main settings array (self::$component_list)
     * The self::USED_ON_PAGE flag is set accordingly, as updating and deleting operations using the same ($class_name, $id, $key) key
     * know about it and do not fulfill operations.
     * Updating or deleting must be done prior of this method or self::get_key method usage.
     *
     * @param $class_name string The array key in the self::$component_list
     * @param $id string string The array key in the self::$component_list[$class_name]
     * @return mixed The value of the self::$component_list[$class_name][$id]
     */
    static function get_by_id($id) {
        self::mark_used_on_page($id);
	    self::locate_the_file($id);
        return self::$components_list[$id];
    }



    /**
     * This method gets the value set for the ($class_name, $id, $key) key in the main array settings (self::$component_list)
     * The self::USED_ON_PAGE flag is set accordingly, as updating and deleting operations using the same ($class_name, $id, $key) key
     * know about it and do not fulfill operations.
     * Updating or deleting must be done prior of this method or self::get_key method usage.
     *
     * @param $class_name string The array key in the self::$component_list
     * @param $id string The array key in the self::$component_list[$class_name]
     * @param $key string The array key in the self::$component_list[$class_name][$id]
     * @return mixed mixed The value of the self::$component_list[$class_name][$id][$key]
     * @throws ErrorException The error exception thrown by check_used_on_page method call
     */
    static function get_key($id, $key) {
        self::mark_used_on_page($id);

	    if ($key == 'file') {
		    self::locate_the_file($id);
	    }

	    return self::$components_list[$id][$key];
    }



    /**
     * This method update the value for ($class_name, $id) in the main array settings (self::$component_list)
     * Updating and deleting a key value in the main settings array ensures that the value of the key is not already loaded by the theme.
     * Loaded by the theme means that is's used to set or to build some components.
     * So, the $id and the $key parameter must no be used previously by self::get_by_id or by self::get_key
     * method, otherwise it means that the settings are already loaded to build a component, and an error exception is thrown
     * informing the end user about it.
     *
     * @param $class_name string The array key in the self::$component_list
     * @param $id string The array key in the self::$component_list[$class_name]
     * @param $params_array array The array value set for the self::$component_list[$class_name][$id]
     * @throws ErrorException The error exception thrown by check_used_on_page method call
     */
    static function update_component($class_name, $id, $params_array) {
        self::check_used_on_page($id, 'update');
	    $params_array[self::TYPE] = $class_name;
        self::$components_list[$id] = $params_array;
    }



    /**
     * This method updates the value for the ($class_name, $id, $key) key in the main settings array (self::$component_list).
     * Updating and deleting a key value in the main settings array ensures that the value of the key is not already loaded by the theme.
     * Loaded by the theme means that is's used to set or to build some components.
     * So, the $id and the $key parameter must no be used previously by self::get_by_id or by self::get_key
     * method, otherwise it means that the settings are already loaded to build a component, and an error exception is thrown
     * informing the end user about it.
     *
     * @param $class_name string The array key in self::$component_list
     * @param $id string The array key in the self::$component_list[$class_name]
     * @param $key string The array key in the self::$component_list[$class_name][$id]
     * @param $value mixed The value set for the specified $key
     * @throws ErrorException The error exception thrown by check_used_on_page method call
     */
    static function update_key($id, $key, $value) {
        self::check_used_on_page($id, 'update_key');
        self::$components_list[$id][$key] = $value;
    }



    /**
     * This method unset value for the ($class_name, $id) key in the main settings array (self::$component_list).
     * Updating and deleting a key value in the main settings array ensures that the value of the key is not already loaded by the theme.
     * Loaded by the theme means that is's used to set or to build some components.
     * So, the $id and the $key parameter must no be used previously by self::get_by_id or by self::get_key
     * method, otherwise it means that the settings are already loaded to build a component, and an error exception is thrown
     * informing the end user about it.
     *
     * @param $class_name string The array key in self::$component_list
     * @param $id string The array key in the self::$component_list[$class_name]
     * @throws ErrorException The error exception thrown by check_used_on_page method call
     */
    static function delete($id) {
        self::check_used_on_page($id, 'delete');
        unset(self::$components_list[$id]);
    }



    /**
     * This is an internal function used just for debugging
     * @internal
     * @return array with all theme settings
     */
    static function _debug_get_components_list() {
        return self::$components_list;
    }




    /**
     * returns only the used on page component - useful for debug
     * @return array
     */
    static function _debug_show_autoloaded_components() {
        $buffy_array = array();
        foreach (self::$components_list as $component_id => $component) {

            if (isset($component[self::CLASS_AUTOLOADED]) and $component[self::CLASS_AUTOLOADED] === true) {
                $buffy_array [$component_id]= $component;
            }
        }


        ob_start();
        ?>

	    <script>
		    console.log('_debug_show_autoloaded_components is called');
            <?php
            foreach ($buffy_array as $component_id => $component) {
	            ?>
			    console.log(<?php echo json_encode(str_pad($component_id, 20)) ?>);
	            <?php
            }
            ?>
	    </script>

        <?php
        echo ob_get_clean();



        return $buffy_array;
    }



    /**
     * sets the component's td_api_base::CLASS_AUTOLOADED key to true at runtime.
     * @param $component_id
     */
    static function _debug_set_class_is_autoloaded($component_id) {
        self::$components_list[$component_id][td_api_base::CLASS_AUTOLOADED] = true;
    }







    /**
     * This method sets the self::USED_ON_PAGE flag for the ($class_name, $id) key.
     * It's used by the get_by_id and get_key methods to mark settings as being loaded on page.
     * The main purpose of using this flag is for debugging the loaded components.
     *
     * @param $class_name string The array key in self::$component_list
     * @param $id string The array key in the self::$component_list[$class_name]
     * @throws ErrorException The error thrown when the ($class_name, id) key is not already set
     */
    private static function mark_used_on_page($id) {
        if (!isset(self::$components_list[$id])) {


            /**
             * @deprecated @todo should be removed in v2  compatiblity for social counter old old
             */

            if (($id == 'td_social_counter' or $id == 'td_block_social_counter')) {
                if (is_user_logged_in()) {
                    td_util::error('', "Please update your [tagDiv social counter] Plugin!");
                }
                return;
            }

            /**
             * show a soft error if
             * - the user is logged in
             * - the user is on the login page / register
             * - the user tries to log in via wp-admin (that is why is_admin() is required)
             */
            td_util::error(__FILE__, "td_api_base::mark_used_on_page : a component with the ID: $id is not set.");
        }
        self::$components_list[$id][self::USED_ON_PAGE] = true;
    }


	/**
	 * - it replaces the theme path with the child path, if the file api registered exists in the child theme
	 * - it tries to find the file in the child theme and if it's found, the 'located_in_child' is set
	 * - the check is done only when the child theme is activated and the 'located_in_child' hasn't set yet
	 * - the check is done only for the theme registered paths (those having TEMPLATEPATH), letting the plugins to register themselves paths
	 *
	 * @param string $id - the id of the component
	 * @param string $component - the component value
	 */
	private static function locate_the_file($id = '') {
		if (!is_child_theme()) {
			return;
		}

		$the_component = null;

		if (!empty($id)) {
			$the_component = &self::$components_list[$id];
		}

		if (($the_component != null)
		    and (stripos($the_component['file'], TEMPLATEPATH) == 0)
		    and !empty($the_component['file'])
            and !isset($the_component['located_in_child'])) {

			$child_path = STYLESHEETPATH . str_replace(TEMPLATEPATH, '', $the_component['file']);

			if (file_exists($child_path)) {
				$the_component['file'] = $child_path;
			}
			$the_component['located_in_child'] = true;
		}
	}




    /**
     * This method check the self::USED_ON_PAGE flag for the ($class_name, $id) key and it throws an exception
     * if it's already set, that means the settings are already used to build a component in the user interface.
     *
     * @param $id string The array key in the self::$component_list[$class_name]
     * @param $requested_operation string (delete|update|update_key)
     * @internal param string $class_name The array key in self::$component_list
     */
    private static function check_used_on_page($id, $requested_operation) {
        if ( array_key_exists( $id, self::$components_list ) and array_key_exists( self::USED_ON_PAGE, self::$components_list[$id] ) ) {
            td_util::error(__FILE__, "td_api_base::check_used_on_page: You requested a $requested_operation for ID: $id BUT it's already used on page. This usually means that you are using a wrong hook - you are trying to modify the component after it already rendered / was used.", self::$components_list[$id]);
        }
    }

}
/**
 * Created by ra on 2/13/2015.
 */



/**
 * The theme's block api, usable via the td_global_after hook
 * Class td_api_block static block api
 */
class td_api_block extends td_api_base {

    /**
     * This method to register a new block
     *
     * @param $id string The block id. It must be unique
     * @param $params_array array The block_parameter array
     *
     *      $params_array = array( - A wp_map array @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     *          'map_in_visual_composer' => ,
     *          'file' => '',                   - Where we can find the shortcode class
     *          'name' => '',                   - string Name of your shortcode for human reading inside element list
     *          'base' => '',                   - string Shortcode tag. For [my_shortcode] shortcode base is my_shortcode
     *          'class' => '',                  - string CSS class which will be added to the shortcode's content element in the page edit screen in Visual Composer backend edit mode
     *          'controls' => '',               - string ?? no used?
     *          'category' => '',               - string Category which best suites to describe functionality of this shortcode. Default categories: Content, Social, Structure. You can add your own category, simply enter new category title here
     *          'icon' => '',                   - URL or CSS class with icon image
     *          'params' => array ()            - array List of shortcode attributes. Array which holds your shortcode params, these params will be editable in shortcode settings page
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($block_id, $params_array = '') {
        parent::add_component(__CLASS__, $block_id, $params_array);
    }


	static function update($block_id, $params_array = '') {
		parent::update_component(__CLASS__, $block_id, $params_array);
	}


    /**
     * This method gets the value for the ('td_api_block') key in the main settings array of the theme.
     *
     * @return mixed array The value set for the 'td_api_block' in the main settings array of the theme
     */
    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }
}


/**
 * Created by ra on 2/13/2015.
 */


/**
 * The theme's block template api, usable via the td_global_after hook
 * Class td_api_block static block api
 */
class td_api_block_template extends td_api_base{

    /**
     * This method to register a new block
     *
     * @param $id string The block template id. It must be unique
     * @param $params_array array The block template array
     *
     *      $params_array = array(
     *          'file' => '',           - Where we can find the shortcode class
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($id, $params_array) {
        parent::add_component(__CLASS__, $id, $params_array);
    }


	static function update($id, $params_array) {
		parent::update_component(__CLASS__, $id, $params_array);
	}


    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }
}


/**
 * Created by ra on 2/13/2015.
 */


/**
 * The theme's category template api, usable via the td_global_after hook
 * Class td_api_category_template
 */
class td_api_category_template extends td_api_base {

    /**
     * This method to register a new category template
     *
     * @param $id string The category template id. It must be unique
     * @param $params_array array The category template array
     *
     *      $params_array = array(
     *          'file' => '',           - Where we can find the file
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($id, $params_array) {
        parent::add_component(__CLASS__, $id, $params_array);
    }


	static function update($id, $params_array) {
		parent::update_component(__CLASS__, $id, $params_array);
	}


    static function get_all($group = '') {
		$components = parent::get_all_components_metadata(__CLASS__);
		foreach ($components as $component_key => $component_value) {
			if (array_key_exists('group', $component_value) && $component_value['group'] !== $group) {
				unset($components[$component_key]);
			}
		}
		return $components;
	}



    static function _helper_get_active_id() {

	    $tdc_option_key = 'tdc_category_template';
	    $tds_option_key = 'tds_category_template';

	    $template_id = td_util::get_category_option(td_global::$current_category_obj->cat_ID, $tdc_option_key);  // read the category setting

        if (empty($template_id)) { // if no category setting, read the global template setting
            $template_id = td_util::get_option($tds_option_key);
        }

        if (empty($template_id)) { // nothing is set, check the default value
            $template_id = parent::get_default_component_id(__CLASS__);
        }

        return $template_id;
    }



    static function render_category_template_by_id($template_id) {
        if (class_exists($template_id)) {
            /** @var $td_category_template td_category_template */
            $td_category_template = new $template_id();
            $td_category_template->render();
        } else {
            td_util::error(__FILE__, "The category template $template_id doesn't exist. Did you disable a tagDiv plugin?");
        }
    }

    /**
     * get the category template, this function has to look at the global theme setting and at the category setting
     */
    static function _helper_show_category_template() {
        $template_id = self::_helper_get_active_id();
        self::render_category_template_by_id($template_id);
    }






    static function _helper_to_panel_values($view_name = 'get_all') {
        $buffy_array = array();


        switch ($view_name) {
            case 'default+get_all':

                //add default style
                $buffy_array[] = array(
                    'text' => 'Default',
                    'title' => '',
                    'val' => '',
                    'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/module-default.png'
                );

                // add the rest
                foreach (self::get_all() as $id => $config) {
                    $buffy_array[] = array(
                        'text' => $config['text'],
                        'title' => '',
                        'val' => $id,
                        'img' => $config['img']
                    );
                }
                break;

            case 'get_all':

                //get all the top post styles, the first one is with an empty value
                foreach (self::get_all() as $id => $config) {
                    $buffy_array[] = array(
                        'text' => $config['text'],
                        'title' => '',
                        'val' => $id,
                        'img' => $config['img']
                    );
                }

                // the first template is the default one, ex: it has no value in the database
                $buffy_array[0]['val'] = '';
                break;
        }



        return $buffy_array;
    }
}




/**
 * Created by ra on 2/13/2015.
 */



/**
 * The theme's category toop loop style api, usable via the td_global_after hook
 * Class td_api_category_top_posts_style
 */
class td_api_category_top_posts_style extends td_api_base {

    /**
     * This method to register a new category template
     *
     * @param $id string The category template id. It must be unique
     * @param $params_array array The category template array
     *
     *      $params_array = array(
     *          'file' => '',           - Where we can find the file
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($id, $params_array) {
        parent::add_component(__CLASS__, $id, $params_array);
    }


	static function update($id, $params_array) {
		parent::update_component(__CLASS__, $id, $params_array);
	}


	static function get_all($group = '') {
		$components = parent::get_all_components_metadata(__CLASS__);
		foreach ($components as $component_key => $component_value) {
			if (array_key_exists('group', $component_value) && $component_value['group'] !== $group) {
				unset($components[$component_key]);
			}
		}
		return $components;
	}



    static function _helper_get_active_id() {

	    $tdc_option_key = 'tdc_category_top_posts_style';
	    $tds_option_key = 'tds_category_top_posts_style';

	    $template_id = td_util::get_category_option(td_global::$current_category_obj->cat_ID, $tdc_option_key); // first check the category setting

        if (empty($template_id)) { // now check the global setting - we have "default" selected on the category, the theme now looks for the global setting
            $template_id = td_util::get_option($tds_option_key);
        }

        if (empty($template_id)) { // nothing is set, check the default value
            $template_id = parent::get_default_component_id(__CLASS__);
        }

        return $template_id;
    }


    /**
     * get the category template, this function has to look at the global theme setting and at the category setting
     */
    static function _helper_show_category_top_posts_style() {
        $template_id = self::_helper_get_active_id();

        if (class_exists($template_id)) {

            /** @var $td_category_template td_category_top_posts_style */
            $td_category_template = new $template_id();
            $td_category_template->show_top_posts();
        } else {
            td_util::error(__FILE__, "The category template $template_id doesn't exist. Did you disable a tagDiv plugin?");
        }

    }


    static function _helper_get_posts_shown_in_the_loop() {

        $template_id = self::_helper_get_active_id(); //@todo we may need a 'better' error checking here
        return parent::get_key($template_id, 'posts_shown_in_the_loop');
    }



    static function _helper_to_panel_values($view_name = 'get_all') {
        $buffy_array = array();

        switch ($view_name) {
            case 'default+get_all':

                //add default style
                $buffy_array[] = array(
                    'text' => 'Default',
                    'title' => '',
                    'val' => '',
                    'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/module-default.png'
                );

                // add the rest
                foreach (self::get_all() as $id => $config) {
                    $buffy_array[] = array(
                        'text' => $config['text'],
                        'title' => '',
                        'val' => $id,
                        'img' => $config['img']
                    );
                }
                break;

            case 'get_all':

                //get all the top post styles, the first one is with an empty value
                foreach (self::get_all() as $id => $config) {
                    $buffy_array[] = array(
                        'text' => $config['text'],
                        'title' => '',
                        'val' => $id,
                        'img' => $config['img']
                    );
                }

                // the first template is the default one, ex: it has no value in the database
                $buffy_array[0]['val'] = '';
                break;
        }

        return $buffy_array;
    }
}







/**
 * Created by ra on 2/13/2015.
 */


class td_api_footer_template extends td_api_base {
    static function add($template_id, $params_array = '') {
        parent::add_component(__CLASS__, $template_id, $params_array);
    }

	static function update($template_id, $params_array = '') {
		parent::update_component(__CLASS__, $template_id, $params_array);
	}

    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }

    static function _helper_show_footer() {

        $template_path = '';

        // find the current active template's id
        $template_id = self::_helper_get_active_id();
        try {
            $template_path = self::get_key($template_id, 'file');
        } catch (ErrorException $ex) {
            td_util::error(__FILE__, "td_api_footer_template::_helper_show_footer : $template_id isn't set. Did you disable a tagDiv plugin?");  //does not stop execution
        }

        // load the template
        if (!empty($template_path) and file_exists($template_path)) {
            load_template($template_path);
        } else {
            td_util::error(__FILE__, "The path $template_path of the template id: $template_id not found.");   //shoud be fatal?
        }

    }

    static function _helper_to_panel_values() {
        // add the rest
        foreach (self::get_all() as $id => $config) {
            $buffy_array[] = array(
                'text' => $config['text'],
                'title' => '',
                'val' => $id,
                'img' => $config['img']
            );
        }

        // the first template is the default one, ex: it has no value in the database
        $buffy_array[0]['val'] = '';

        return $buffy_array;
    }




    private static function _helper_get_active_id() {
        $template_id = td_util::get_option('tds_footer_template');
        if (empty($template_id)) { // nothing is set, check the default value
            $template_id = parent::get_default_component_id(__CLASS__);
        }

        return $template_id;
    }

}
/**
 * Created by ra on 2/13/2015.
 */

class td_api_header_style extends td_api_base {

    /**
     * This method to register a new header style
     *
     * @param $id string The header style id. It must be unique
     * @param $params_array array The heade style parameter array
     *
     *      $params_array = array (
     *          'text' => '',   - [string] the text used inside
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($thumb_id, $params_array = '') {
        parent::add_component(__CLASS__, $thumb_id, $params_array);
    }

	static function update($thumb_id, $params_array = '') {
		parent::update_component(__CLASS__, $thumb_id, $params_array);
	}

    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }


    /**
     * get all the header styles as a array for the panel ui controll. It also adds the default value
     *
     * @internal
     * @return array
     */
    static function _helper_generate_tds_header_style() {
        $buffy_array = array();


        //add each value
        foreach (self::get_all() as $id => $config) {
            $buffy_array[] = array(
                'text' => $config['text'],
                'val' => $id,
            );
        }

        // the first template is the default one, ex: it has no value in the database
        $buffy_array[0]['val'] = '';
        return $buffy_array;
    }


    /**
     * helper function to show the header of the theme.
     *
     * @internal
     */
    static function _helper_show_header() {
        $tds_header_style = self::_helper_get_active_id();
        $template_path = '';

        // look for the user selected template
        try {
            $template_path = self::get_key($tds_header_style, 'file');
        } catch (ErrorException $ex) {
            td_util::error(__FILE__, "The header style: $tds_header_style isn't set. Did you disable a tagDiv plugin?");  //does not stop execution
        }


        // load the template
        if (!empty($template_path) and file_exists($template_path)) {
            load_template($template_path);
        } else {
            td_util::error(__FILE__, "The path $template_path of the $tds_header_style header style not found. Did you disable a tagDiv plugin?");
        }
    }


    private static function _helper_get_active_id() {
        $tds_header_style = td_util::get_option('tds_header_style');

        if (empty($tds_header_style)) { // nothing is set, check the default value
            $tds_header_style = parent::get_default_component_id(__CLASS__);
        }

        return $tds_header_style;
    }
}


/**
 * Created by ra on 2/13/2015.
 */



/**
 * The theme's module api, usable via the td_global_after hook
 * Class td_api_module static module api
 */
class td_api_module extends td_api_base {

    /**
     * This method to register a new module
     *
     * @param $id string The module id. It must be unique
     * @param $params_array array The module_parameter array
     *
     *      $params_array = array (
     *          'file' => '',                               - [string] the path to the module class
     *          'text' => '',                               - [string] module name text used in the theme panel
     *          'img' => '',                                - [string] the path to the image icon
     *          'used_on_blocks' => array(),                - [array of strings] block names where this module is used or leave blank if it's used internally (ex. it's not used on any category)
     *          'excerpt_title' => '',                      - [int] leave empty '' if you don't want a setting in the panel -> excerpts for this module
     *          'excerpt_content' => '',                    - [int] leave empty ''  ----||----
     *          'enabled_on_more_articles_box' => ,         - [boolean] show the module in the more articles box in panel -> post settings -> more articles box
     *          'enabled_on_loops' => ,                     - [boolean] show the module in panel on loops
     *          'uses_columns' => ,                         - [boolean] if the module uses columns on the page template + loop (if the modules has columns, enable this)
     *          'category_label' =>                         - [boolean] show the module in panel -> block_settings -> category label ?
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($module_id, $params_array = '') {
        parent::add_component(__CLASS__, $module_id, $params_array);
    }

	static function update($module_id, $params_array = '') {
		parent::update_component(__CLASS__, $module_id, $params_array);
	}


    /**
     * This method gets the value for the ('td_api_module') key in the main settings array of the theme.
     * It filters the settings using the 'group' key, to allow extracting only the modules info for the desired theme.
     * The parameter $group could have the following values '' (the main theme), 'mob' (the mobile theme), 'woo' (the woo theme), etc.
     *
     * @param string $group The group of the module.
     *
     * @return mixed array The value set for the 'td_api_module' in the main settings array of the theme
     */
    static function get_all($group = '') {
        $components = parent::get_all_components_metadata(__CLASS__);
	    foreach ($components as $component_key => $component_value) {
		    if (array_key_exists('group', $component_value) && $component_value['group'] !== $group) {
			    unset($components[$component_key]);
		    }
	    }
	    return $components;
    }


    /**
     * This method is an internal helper function used to check 'excerpt_title' property of a module
     *
     * @internal
     * @param $module_id string Unique module id
     * @return bool True if the 'excerpt_title' property is set, false otherwise
     */
    static function _helper_check_excerpt_title($module_id) {
        $module_settings = self::get_by_id($module_id);

        if (isset($module_settings) and !empty($module_settings['excerpt_title'])) {
            return true;
        }
        return false;
    }



    /**
     * This method is an internal helper function used to check 'excerpt_content' property of a module
     *
     * @internal
     * @param $module_id string Unique module id
     * @return bool True if the 'excerpt_content' property is set, false otherwise
     */

    static function _helper_check_excerpt_content($module_id) {
        $module_settings = self::get_by_id($module_id);

        if (isset($module_settings) and !empty($module_settings['excerpt_content'])) {
            return true;
        }
        return false;
    }


	/**
	 * converts module classes to module id's for loop settings. td_module_2 -> 2 (we store the 2 in the database)
	 *
	 * WARNING (2 now 2015): we tried to refactor this multiple times. It is not worth it because all the theme including the panel
	 * have to work with the new and old settings - resulting in added complexity without any real benefits
	 * @param $module_class
	 * @return mixed id of the module td_module_2 returns 2
	 */
	static function _helper_get_module_loop_id ($module_class){
		return filter_var($module_class, FILTER_SANITIZE_NUMBER_INT);
	}


	/**
	 * WARNING (2 now 2015): we tried to refactor this multiple times. It is not worth it because all the theme including the panel
	 * have to work with the new and old settings - resulting in added complexity without any real benefits
	 * @param $module_class
	 * @return string
	 */
	static function _helper_get_module_name_from_class($module_class) {
		return str_replace('td_', '', $module_class);
	}


	/**
	 * Gets the class from a loop id that is stored in the database. ex: 2 -> td_module_2
	 *
 	 * WARNING (2 now 2015): we tried to refactor this multiple times. It is not worth it because all the theme including the panel
	 * have to work with the new and old settings - resulting in added complexity without any real benefits
	 * @param $module_id
	 * @return string
	 */
	static function _helper_get_module_class_from_loop_id ($module_id) {
		return 'td_module_'  . $module_id;
	}
}

/**
 * Created by ra on 2/13/2015.
 */


class td_api_single_template extends td_api_base {

    /**
     * This method to register a new single template
     *
     * @param $id string The single template id. It must be unique
     * @param $params_array array The single_template_parameter array
     *
     *      $params_array = array (
     *          'file' => '',                               - [string] the path to the template file
     *          'text' => '',                               - [string] name text used in the theme panel
     *          'img' => '',                                - [string] the path to the image icon
     *          'show_featured_image_on_all_pages' => ''    - [boolean]
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($single_template_id, $params_array = '') {
        parent::add_component(__CLASS__, $single_template_id, $params_array);
    }

	static function update($single_template_id, $params_array = '') {
		parent::update_component(__CLASS__, $single_template_id, $params_array);
	}

    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }

    /**
     * checks the show_featured_image_on_all_pages for a template
     *
     * @internal
     * @param $single_template_id
     * @return bool true if we have to show the featured image on all pages
     */
    static function _check_show_featured_image_on_all_pages($single_template_id) {
        // on the default template, hide the featured image on page 2
        if (empty($single_template_id)) {  //$single_template_id is empty if we're on the default template
            return false;
        }

        // check the show_featured_image_on_all_pages key of each template
        if (self::get_key($single_template_id, 'show_featured_image_on_all_pages') === false) {
            return false;
        }

        return true;
    }


    /**
     *  returns all the single post templates in a format that is usable for the panel
     *
     *  @internal
     *  @return array
     *
     *      array(
     *          array('text' => '', 'title' => '', 'val' => 'single_template_6', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/post-templates/post-templates-icons-6.png'),
     *      )
     */
    static function _helper_td_global_list_to_panel_values() {
        $buffy_array = array();

        foreach (self::get_all() as $template_value => $template_config) {
	        if ($template_value == 'single_template') {
		        $buffy_array[] = array(
			        'text' => '',
			        'title' => '',
			        'val' => '',
			        'img' => $template_config['img']
		        );
		        continue;
	        }
            $buffy_array[] = array(
                'text' => '',
                'title' => '',
                'val' => $template_value,
                'img' => $template_config['img']
            );
        }

//        // add the default template at the beginning
//        array_unshift (
//            $buffy_array,
//            array(
//                'text' => '',
//                'title' => '',
//                'val' => '',
//                'img' => td_global::$get_template_directory_uri . '/images/panel/single_templates/single_template_default.png'
//            )
//        );
        return $buffy_array;
    }


	static function _helper_td_global_list_to_metaboxes() {
		$buffy_array = array();

		foreach (self::get_all() as $template_value => $template_config) {
			$buffy_array[] = array(
				'text' => '',
				'title' => '',
				'val' => $template_value,
				'img' => $template_config['img']
			);
		}

        // add the default template at the beginning
        array_unshift (
            $buffy_array,
            array(
                'text' => '',
                'title' => '',
                'val' => '',
                'img' => td_global::$get_template_directory_uri . '/images/panel/single_templates/single_template_default.png'
            )
        );
		return $buffy_array;
	}


    /**
     * @deprecated Important! Its functionality was replaced by the booster 'template_include' wordpress hook. It's susceptible to be removed in the next api versions.
     *
     * shows a single template (echos it). NOTE: it also loads the WordPress globals in that template!
     *
     * @internal
     * @param $template_id
     */
    static function _helper_show_single_template($template_id) {
        $template_path = '';

        // try to get the key from the api
        try {
            $template_path = self::get_key($template_id, 'file');
        } catch (ErrorException $ex) {
            td_util::error(__FILE__, "The template $template_id isn't set. Did you disable a tagDiv plugin?"); // this does not stop execution
        }


        // load the template
        if (!empty($template_path) and file_exists($template_path)) {
            load_template($template_path);
        } else {
            td_util::error(__FILE__, "The path $template_path of the $template_id template not found. Did you disable a tagDiv plugin?");  // this does not stop execution
        }


    }
}




/**
 * Created by ra on 2/13/2015.
 */

/**
 * Note: the smart lists are loaded via autoload
 * Class td_api_smart_list
 */
class td_api_smart_list extends td_api_base {

    /**
     * This method to register a new smart list
     *
     * @param $id string The smart list id. It must be unique
     * @param $params_array array The smart_list_parameter array
     *
     *      $params_array = array (
     *          'file' => '',                               - [string] the path to the smart list file
     *          'text' => '',                               - [string] name text used in the theme panel
     *          'img' => '',                                - [string] the path to the image icon
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($smart_list_id, $params_array = '') {
        parent::add_component(__CLASS__, $smart_list_id, $params_array);
    }

	static function update($smart_list_id, $params_array = '') {
		parent::update_component(__CLASS__, $smart_list_id, $params_array);
	}

    static function get_all($group = '') {
	    $components = parent::get_all_components_metadata(__CLASS__);
	    foreach ($components as $component_key => $component_value) {
		    if (array_key_exists('group', $component_value) && $component_value['group'] !== $group) {
			    unset($components[$component_key]);
		    }
	    }
	    return $components;
    }

    /**
     *  returns all the single post templates in a format that is usable for the panel
     *
     *  @internal
     *  @return array
     *
     *      array(
     *          array('text' => '', 'title' => '', 'val' => 'single_template_6', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/post-templates/post-templates-icons-6.png'),
     *      )
     */
    static function _helper_td_smart_list_api_to_panel_values() {
        $buffy_array = array();

        // add the default smart list
        $buffy_array[] =  array(
            'text' => '',
            'title' => '',
            'val' => '',
            'img' => td_global::$get_template_directory_uri . '/images/panel/smart_lists/td_smart_list_default.png'
        );

        foreach (self::get_all() as $template_value => $template_config) {
            $buffy_array[] = array(
                'text' => '',
                'title' => '',
                'val' => $template_value,
                'img' => $template_config['img']
            );
        }



        return $buffy_array;
    }
}


/**
 * Created by ra on 2/13/2015.
 */

class td_api_thumb extends td_api_base {

    /**
     * This method to register a new thumb
     *
     * @param $id string The single template id. It must be unique
     * @param $params_array array The single_template_parameter array
     *
     *      $params_array = array (
     *          'name' => 'td_0x420',                       - [string] the thumb name
     *          'width' => ,                                - [int] the thumb width
     *          'height' => ,                               - [int] the thumb height
     *          'crop' => array('center', 'top'),           - [array of string] what crop to use (center, top, etc)
     *          'post_format_icon_size' => '',              - [string] what play icon to load (small or normal)
     *          'used_on' => array('')                      - [array of string] description where the thumb is used
     *      )
     *
     * @throws ErrorException new exception, fatal error if the $id already exists
     */
    static function add($thumb_id, $params_array = '') {
        parent::add_component(__CLASS__, $thumb_id, $params_array);
    }

	static function update($thumb_id, $params_array = '') {
		parent::update_component(__CLASS__, $thumb_id, $params_array);
	}

    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }
}




/**
 * Created by ra on 2/13/2015.
 */

class td_api_top_bar_template extends td_api_base {
    static function add($template_id, $params_array = '') {
        parent::add_component(__CLASS__, $template_id, $params_array);
    }

	static function update($template_id, $params_array = '') {
		parent::update_component(__CLASS__, $template_id, $params_array);
	}

    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }

    static function _helper_show_top_bar() {

        // find the current active template's id
        $template_id = self::_helper_get_active_id();
        try {
            $template_path = self::get_key($template_id, 'file');
        } catch (ErrorException $ex) {
            td_util::error(__FILE__, "td_api_top_bar_template::_helper_show_top_bar : $template_id isn't set. Did you disable a tagDiv plugin?");  //does not stop execution
        }

        // load the template
        if (!empty($template_path) and file_exists($template_path)) {
            load_template($template_path);
        } else {
            td_util::error(__FILE__, "The path $template_path of the template id: $template_id not found.");   //shoud be fatal?
        }

    }

    static function _helper_to_panel_values() {
        // add the rest
        foreach (self::get_all() as $id => $config) {
            $buffy_array[] = array(
                'text' => '',
                'title' => '',
                'val' => $id,
                'img' => $config['img']
            );
        }

        // the first template is the default one, ex: it has no value in the database
        $buffy_array[0]['val'] = '';

        return $buffy_array;
    }






    private static function _helper_get_active_id() {
        $template_id = td_util::get_option('tds_top_bar_template');

        if (empty($template_id)) { // nothing is set, check the default value
            $template_id = parent::get_default_component_id(__CLASS__);
        }

        return $template_id;
    }

}


/**
 * Created by ra on 2/13/2015.
 */



class td_api_tinymce_formats extends td_api_base {

    private static $tiny_mce_format_list = array ();


    static function add($tinymce_format_id, $params_array = '') {
        parent::add_component(__CLASS__, $tinymce_format_id, $params_array);
    }


    static function update($tinymce_format_id, $params_array = '') {
        parent::update_component(__CLASS__, $tinymce_format_id, $params_array);
    }


    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }


	/**
	 * sets @see td_global::$tiny_mce_style_formats with settings from the api
	 */
    static function _helper_get_tinymce_format() {
	    self::$tiny_mce_format_list = self::get_all();

        array_walk(self::$tiny_mce_format_list, array('td_api_tinymce_formats', '_connect_to_parent'));

	    td_global::$tiny_mce_style_formats = array_filter(self::$tiny_mce_format_list, array('td_api_tinymce_formats', '_get_root_elements'));
    }


	/**
	 * callback for array_walk @see td_api_tinymce_formats::_helper_get_tinymce_format
	 * @param $value
	 * @param $key
	 */
	static function _connect_to_parent($value, $key) {

		if (!empty($value['parent_id'])
		    && isset(self::$tiny_mce_format_list[$value['parent_id']])
		    && isset(self::$tiny_mce_format_list[$key])) {

			self::$tiny_mce_format_list[$value['parent_id']]['items'][] = &self::$tiny_mce_format_list[$key];
		}
	}


	/**
	 * callback for array_filter @see td_api_tinymce_formats::_helper_get_tinymce_format
	 * @param $value
	 * @return bool
	 */
	static function _get_root_elements($value) {
		return empty($value['parent_id']);
	}

}





class td_api_autoload extends td_api_base {
    static function add($class_id, $file) {
        $params_array['file'] = $file;
        parent::add_component(__CLASS__, $class_id, $params_array);
    }



    static function get_all() {
        return parent::get_all_components_metadata(__CLASS__);
    }







}