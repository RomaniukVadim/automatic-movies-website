<?php

class td_autoload_classes {


    /**
     * register the spl hook
     */
	public function __construct() {
		spl_autoload_register(array($this, 'loading_classes'));
	}

	/**
	 * The callback function used by spl_autoload_register
	 * @param $class_name string - The class name
	 */
	private function loading_classes($class_name) {
        $path_regex = 'td';

        // foreach regex path, the class name is verified for a start matching
        if ((strpos($class_name, $path_regex) !== false) and (strpos($class_name, $path_regex) === 0)) {

            $class_settings = td_api_base::get_by_id($class_name);

            if (!empty($class_settings)) {
                if (array_key_exists('file', $class_settings)) {
                    $class_file_path = $class_settings['file'];

                    if (isset($class_file_path) and !empty($class_file_path)) {
                        // set the autoloaded key for that component
                        td_api_base::_debug_set_class_is_autoloaded($class_name);


//	                    if ($class_name == 'td_page_views') {
//		                    print_r(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 4)); //return only 4 call stack frames
//		                    die;
//	                    }

                        // require_once($class_file_path); - we need to use load_template to make our single_templates work like wordpress
                        // with load_template we prepare the globals ($post etc for the files)
                        // we should not use the global $post or any other globals in our classes without explicit declaration
                        load_template($class_file_path, true);
                    }
                } else {
                    td_util::error(__FILE__, "Missing parameter: 'file'");
                }
            }
        }
	}
}

new td_autoload_classes();
