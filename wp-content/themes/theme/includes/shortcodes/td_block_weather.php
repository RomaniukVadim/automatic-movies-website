<?php

class td_block_weather extends td_block {


	/**
	 * Disable loop block features. This block does not use a loop and it dosn't need to run a query.
	 */
	function __construct() {
		parent::disable_loop_block_features();
	}



	function render($atts, $content = null) {
		parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)
		//$atts['w_location'] = 'Alba Iulia';




		$buffy = $this->get_block_js(); //output buffer


		if (empty($td_column_number)) {
			$td_column_number = td_util::vc_get_column_number(); // get the column width of the block from the page builder API
		}


		$buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';
			//get the block title
			$buffy .= $this->get_block_title();
			$buffy .= '<div id=' . $this->block_uid . ' class="td-weather-wrap td_block_inner td-column-' . $td_column_number . '">';
				$buffy.= td_weather::render_generic($atts, $this->block_uid);
			$buffy .= '</div>';
		$buffy .= '</div> <!-- ./block -->';
		return $buffy;
	}

	/**
	 * tagDiv composer specific code:
	 *  - it's added to the end of the iFrame when the live editor is active (when @see td_util::tdc_is_live_editor_iframe()  === true)
	 *  - it is injected int he iFrame and evaluated there in the global scoupe when a new block is added to the page via AJAX!
	 * @return string the JS without <script> tags
	 */
	/*
		function js_tdc_get_composer_block() {
			ob_start();
			?>
			<script>

				(function () {
					var tdComposerBlockItem = new tdcComposerBlocksApi.item();
					tdComposerBlockItem.blockUid = '<?php echo $this->block_uid ?>';
					tdComposerBlockItem.callbackDelete = function(blockUid) {
						tdAnimationSprite.deleteItem(blockUid);
						tdcDebug.log('tdComposerBlockItem.callbackDelete(' + blockUid + ') - for weather');
					};
					tdcComposerBlocksApi.addItem(tdComposerBlockItem);
				})();
			</script>
			<?php
			return td_util::remove_script_tag(ob_get_clean());
		}
	*/


	/**
	 * tagDiv composer specific code:
	 *  - it's added to the end of the iFrame when the live editor is active (when @see td_util::tdc_is_live_editor_iframe()  === true)
	 *  - it is injected int he iFrame and evaluated there in the global scoupe when a new block is added to the page via AJAX!
	 * @return string the JS without <script> tags
	 */
	function js_tdc_callback_ajax() {
		$buffy = '';

		// add a new composer block - that one has the delete callback
		$buffy .= $this->js_tdc_get_composer_block();

		ob_start();
		?>
		<script>
			(function () {
				var tdAnimationSpriteItem = new tdAnimationSprite.item();

				tdAnimationSpriteItem.jqueryObj = jQuery('.<?php echo $this->block_uid ?>_rand span[class^="td_animation_sprite"]');;
				tdAnimationSpriteItem.blockUid = tdAnimationSpriteItem.jqueryObj.data('td-block-uid');   // the block uid is used on the front end editor when we want to delete this item via it's blockuid
				tdAnimationSprite.addItem( tdAnimationSpriteItem );
			})();
		</script>
		<?php
		return $buffy . td_util::remove_script_tag(ob_get_clean());
	}




}