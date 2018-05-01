<?php

/**
* Class td_block_widget - used to create widgets from our blocks.
* AUTOLOAD STATUS: cannot be autoloaded because WordPress needs to know at all times what widgets are registered
*/
class td_block_widget extends WP_Widget {
	var $td_block_id = 0; // this is changed by td_blockx_widget s

	private $map_array;
	private $map_param_default_array;

	/**
	 * overwrite the default WordPress constructor
	 */
	function __construct() {

		// read our map_array
		$this->map_array = td_api_block::get_by_id($this->td_block_id);


	    $widget_ops = array('classname' => 'td_pb_widget', 'description' => '[tagDiv] ' . $this->map_array['name']);

	    /**
	    * overwrite the widget settings, we emulate the WordPress settings. Before WP 4.3 we called the old php4 constructor again :(
		* @see \WP_Widget::__construct
		*/
	    $id_base = $this->map_array['base'] . '_widget';
	    $name = '[tagDiv] ' . $this->map_array['name'];
	    $widget_options = $widget_ops;
	    $control_options = array();

	    $this->id_base = strtolower($id_base);
	    $this->name = $name;
	    $this->option_name = 'widget_' . $this->id_base;
	    $this->widget_options = wp_parse_args( $widget_options, array('classname' => $this->option_name) );
	    $this->control_options = wp_parse_args( $control_options, array('id_base' => $this->id_base) );

		// build the default values?
	    $this->map_param_default_array = $this->build_param_default_values();
	}


	/**
	* build the default values array
	* @return array
	*/
	private function build_param_default_values() {
	    $buffy_array = array();
	    if (!empty($this->map_array['params'])) {
	        foreach ($this->map_array['params'] as $param) {
	            if ($param['type'] == 'dropdown') {
	                $buffy_array[$param['param_name']] = '';
	            } else {
	                $buffy_array[$param['param_name']] = $param['value'];
	            }
	        }
	    }
	    return $buffy_array;
	}



	function form($instance) {
	    $instance = wp_parse_args((array) $instance, $this->map_param_default_array);


	    //print_r($instance);

	    if (!empty($this->map_array['params'])) {
	        foreach ($this->map_array['params'] as $param) {
	            switch ($param['type']) {

	                case 'textarea_html':
	                    //print_r($param);


	                    ?>
	                    <p>
	                        <label for="<?php echo $this->get_field_id($param['param_name']); ?>"><?php echo $param['heading']; ?></label>

	                        <textarea  class="widefat" name="<?php echo $this->get_field_name($param['param_name']); ?>" id="<?php echo $this->get_field_id($param['param_name']); ?>" cols="30" rows="10"><?php echo esc_textarea($instance[$param['param_name']]); ?></textarea>


	                        <div class="td-wpa-info">
	                            <?php echo $param['description']; ?>
	                        </div>

	                    </p>
	                    <?php
	                    break;

	                case 'textfield':
	                    // we have to change custom_title to custom-title to have "-title" at the end. That's what
	                    // WordPress uses to put the title of the widget on post @see widgets.js
	                    // suggested at: http://forum.tagdiv.com/topic/please-add-block-title-to-backend-widget-title/#post-58087
	                    if ($param['param_name'] == 'custom_title') {
	                        $field_id = $this->get_field_id('custom-title');
	                    } else {
	                        $field_id = $this->get_field_id($param['param_name']);
	                    }

	                    ?>
	                    <p>
	                        <label for="<?php echo $this->get_field_id($param['param_name']); ?>"><?php echo $param['heading']; ?></label>
	                        <input class="widefat" id="<?php echo $field_id; ?>"
	                               name="<?php echo $this->get_field_name($param['param_name']); ?>" type="text"
	                               value="<?php echo $instance[$param['param_name']]; ?>" />

	                        <div class="td-wpa-info">
	                            <?php echo $param['description']; ?>
	                        </div>

	                    </p>
	                    <?php
	                    break;



	                case 'dropdown':
	                    ?>
	                    <p>
	                        <label for="<?php echo $this->get_field_id($param['param_name']); ?>"><?php echo $param['heading']; ?></label>
	                        <select name="<?php echo $this->get_field_name($param['param_name']); ?>" id="<?php echo $this->get_field_id($param['param_name']); ?>" class="widefat">
	                            <?php
	                            foreach ($param['value'] as $param_name => $param_value) {
	                                ?>
	                                <option value="<?php echo $param_value; ?>"<?php selected($instance[$param['param_name']], $param_value); ?>><?php echo $param_name; ?></option>
	                            <?php
	                            }
	                            ?>
	                        </select>

	                        <div class="td-wpa-info">
	                            <?php echo $param['description']; ?>
	                        </div>
	                    </p>
	                    <?php
	                    break;



	                case 'colorpicker':
	                    $empty_color_fix = '#';
	                    if (!empty($instance[$param['param_name']])) {
	                        $empty_color_fix = $instance[$param['param_name']];
	                    }


	                    $widget_color_picker_id = td_global::td_generate_unique_id();
	                    ?>
	                    <p>
	                        <label for="<?php echo $this->get_field_id($param['param_name']); ?>"><?php echo $param['heading']; ?></label>
	                        <input data-td-w-color="<?php echo $widget_color_picker_id?>" class="widefat td-color-picker-field" id="<?php echo $this->get_field_id($param['param_name']); ?>"
	                               name="<?php echo $this->get_field_name($param['param_name']); ?>" type="text"
	                               value="<?php echo $empty_color_fix; ?>" />
	                        <div id="<?php echo $widget_color_picker_id?>" class="td-color-picker-widget" rel="<?php echo $this->get_field_id($param['param_name']); ?>"></div>
	                    </p>

	                    <div class="td-wpa-info">
	                        <?php echo $param['description']; ?>
	                    </div>

	                    <script>
	                        td_widget_attach_color_picker();
	                    </script>


	                    <?php
	                    break;
	            }
	        }
	    }
	}


	/**
	* Update the settings of the widget
	* @param array $new_instance
	* @param array $old_instance
	* @return array
    */
	function update($new_instance, $old_instance) {

	    $instance = $old_instance;

	    foreach ($this->map_param_default_array as $param_name => $param_value) {
	        //if we need aditional procesing, we will do it here
	        $instance[$param_name] = $new_instance[$param_name];
	    }

	    return $instance;

	}


	/**
	* render the widget
	* @param array $args
	* @param array $instance
	*/
	function widget($args, $instance) {
	    /**
	      * add the td_block_widget class to the block via the short code atts, we can add td_block_widget multiple times because array_unique in  @see td_block::get_block_classes
	     */
	    if (!empty($instance['class'])) {
	        $instance['class'] =  $instance['class'] . ' td_block_widget';
	    } else {
	        $instance['class'] = 'td_block_widget';
	    }

	    if (!empty($instance['content'])) {
	        //render the instance - but also send the content parameter to the shortcode
	        echo td_global_blocks::get_instance($this->td_block_id)->render($instance, $instance['content']);
	    } else {
	        //render the instance without the content parameter
	        echo td_global_blocks::get_instance($this->td_block_id)->render($instance);
	    }


	}






}
