<?php
/**
 * Created by PhpStorm.
 * User: tagdiv
 * Date: 30.12.2014
 * Time: 13:27
 */


require_once(td_global::$get_template_directory . '/includes/wp_booster/td_video_playlist_render.php');


//class for vimeo playlist shortcode
class td_block_video_vimeo extends td_block {

	/**
	 * Disable loop block features. This block does not use a loop and it dosn't need to run a query.
	 */
	function __construct() {
		parent::disable_loop_block_features();
	}



    function render($atts, $content = null) {
        return td_video_playlist_render::render_generic($atts, 'vimeo');
    }
}