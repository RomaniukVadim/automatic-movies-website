<?php

/**
 * The theme's css buffer. Has a _hook method that is called at the end of this file.
 * Class td_css_buffer
 */
class td_css_buffer {


	// here we hold the two buffers
    private static $css_header_buffer = '';
    private static $css_footer_buffer = '';

	// this flags is used to make sure we don't add css AFTER it already rendered -> is true ONLY when the buffer was echoed
	private static $css_header_buffer_has_rendered = false;
	private static $css_footer_buffer_has_rendered = false;


	// we use them to make sure we hook ONLY ONCE
	private static $css_header_buffer_hooked = false; // is true WHEN the hook was registered to wordpress, NOT when the buffer is rendered
	private static $css_footer_buffer_hooked = false;



    /**
     * - add css to the buffer. Must be called before wp_head hook.
     * - if called on wp_head hook, it must be called with priority < 15
     * - if defined('TD_SPEED_BOOSTER'), this css will appear at the bottom, else it will appear in the header
     * @param $css - the css WITHOUT THE <style> TAG
     * @throws ErrorException - if it's called to late you will get this message
     */
    static function add_to_header($css) {
        if (self::$css_header_buffer_has_rendered === true) {
            throw new ErrorException("td_css_buffer::add - css was already rendered when you called td_css_buffer::add() (ex: add was called to late)");
        }
        self::$css_header_buffer .= "\n" . $css;

	    self::schedule_css_header_buffer_render();
    }



    /**
     * - adds the css to the footer. Must be called before wp_footer hook
     * - if called on wp_head hook, it must be called with priority < 100
     * @param $css - the css WITHOUT THE <style> TAG
     * @throws ErrorException - if it's called to late you will get this message
     */
    static function add_to_footer($css) {
        if (self::$css_footer_buffer_has_rendered === true) {
            throw new ErrorException("td_css_buffer::add_to_footer - css was already rendered when you called td_css_buffer::add_to_footer() (ex: add was called to late)");
        }
        self::$css_footer_buffer .= "\n" . $css;

	    self::schedule_css_footer_buffer_render();
    }



	/**
	 * schedules a buffer render for the header CSS. It makes sure to register the hook only once via the flag self::$css_header_buffer_hooked
	 */
	static function schedule_css_header_buffer_render() {
		if (self::$css_header_buffer_hooked === true) {
			return;
		}

		// render the header css section according to the speed booster plugin
		if (defined('TD_SPEED_BOOSTER')) {
			add_action('wp_footer',  array('td_css_buffer', 'on_wp_header_render_header_css'), 100);
		} else {
			add_action('wp_head', array('td_css_buffer', 'on_wp_header_render_header_css'), 15); //priority 10 is used by the css compiler, that means that on 10 we don't have the css ready
		}

		self::$css_header_buffer_hooked = true;
	}



	/**
	 * schedules a buffer render for the footer CSS. It makes sure to register the hook only once via the flag self::$css_header_buffer_hooked
	 */
	static function schedule_css_footer_buffer_render() {
		if (self::$css_footer_buffer_hooked === true) {
			return;
		}

		// render the bottom section always at the end
		add_action('wp_footer',  array('td_css_buffer', 'on_wp_footer_render_footer_css'), 100);

		self::$css_footer_buffer_hooked = true;
	}


	/**
	 * trims and renders the css for the header. If wp-booster is installed, it will render in footer @see td_css_buffer::schedule_css_header_buffer_render
	 */
	static function on_wp_header_render_header_css() {
		self::$css_header_buffer_has_rendered = true;

		if (trim(self::$css_header_buffer) != '') {
			self::$css_header_buffer = "\n<!-- Header style compiled by theme -->" . "\n\n<style>\n    " . self::$css_header_buffer . "\n</style>\n\n";
			echo self::$css_header_buffer; // echo out the buffer
		}
	}


	/**
	 * trims and renderes the css for the footer. as of 21/10/2015 it's used only on categories? When we have to output custom css but we are after wp_header()
	 */
	static function on_wp_footer_render_footer_css() {
		self::$css_footer_buffer_has_rendered = true;
		if (trim(self::$css_footer_buffer) != '') {
			self::$css_footer_buffer = "\n<!-- Footer style compiled by theme -->" . "\n\n<style>\n    " . self::$css_footer_buffer . "\n</style>\n\n";
			echo self::$css_footer_buffer; // echo out the buffer
		}
	}
}