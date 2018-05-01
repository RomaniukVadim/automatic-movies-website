<?php

/**
 * Class td_block - base class for blocks
 * v 5.1 - td-composer edition :)
 */


class td_block {
	var $block_uid; // the block unique id on the page, it changes on every render
	var $td_query; //the query used to rendering the current block
	protected $td_block_template_data;

	private $atts = array(); //the atts used for rendering the current block
	private $td_block_template_instance; // the current block template instance that this block is using


	// by default all the blocks are loop blocks
	private $is_loop_block = true; // if it's a loop block, we will generate AJAX js, pulldown items and other stuff




    /**
     * the base render function. This is called by all the child classes of this class
     * this function also ECHOES the block specific css to the buffer (for hover and stuff)
     * WARNING! THIS FUNCTIONS ECHOs THE CSS - it was made to work this way as a hack because the blocks do not get the returned value of render in a buffer
     * @param $atts
     * @param $content
     * @return string ''
     */
    function render($atts, $content = null) {
	    // build the $this->atts

	    // print_r($atts);

	    $atts = $this->add_live_filter_atts($atts); // add live filter atts


	    // WARNING! all the atts MUST BE DEFINED HERE !!! It's easier to maintain and we always have a list of them all
	    $this->atts = shortcode_atts ( // add defaults (if an att is not in this list, it will be removed!)
		    array(
			    'limit' => 5,  // @todo trebuie refactoriata partea cu limita, in paginatie e hardcodat tot 5 si deja este setat in constructor aici
			    'sort' => '',
			    'post_ids' => '', // post id's filter (separated by commas)
			    'tag_slug' => '', // tag slug filter (separated by commas)
			    'autors_id' => '', // filter by authors ID ?
			    'installed_post_types' => '', // filter by custom post types
			    'category_id' => '',
			    'category_ids' => '',
			    'custom_title' => '',       // used in td_block_template_1.php
			    'custom_url' => '',         // used in td_block_template_1.php
			    'show_child_cat' => '',
			    'sub_cat_ajax' => '',
			    'ajax_pagination' => '',
			    'header_color' => '',       // used in td_block_template_1.php + here for js -> loading color
			    'header_text_color' => '',  // used in td_block_template_1.php

			    'ajax_pagination_infinite_stop' => '',
			    'td_column_number' => td_util::vc_get_column_number(), // if no column number passed, get from VC

			    // ajax preloader
			    'td_ajax_preloading' => '',


			    // drop down list + other live filters?
			    'td_ajax_filter_type' => '',
                'td_ajax_filter_ids' => '',
                'td_filter_default_txt' => __td('All', TD_THEME_NAME),

			    // classes?  @see get_block_classes
			    'color_preset' => '',
			    'border_top' => '',
			    'class' => '',
			    'offset' => '', // the offset


			    // live filters
			    // $atts['live_filter'] is set by the 'user'. cur_post_same_tags | cur_post_same_author | cur_post_same_categories
			    'live_filter' => '',

			    // the two live filters are set by @see td_block::add_live_filter_atts
			    'live_filter_cur_post_id' => '',      /** @see td_block::add_live_filter_atts */
			    'live_filter_cur_post_author' => '',  /** @see td_block::add_live_filter_atts */
		    ),
		    $atts
	    );




		/*// @todo vezi daca e necesara chestia asta! si daca merge cum trebuie
	    if (!empty($this->atts['custom_title'])) {
		    $this->atts['custom_title'] = htmlspecialchars($this->atts['custom_title'], ENT_QUOTES );
	    }
	    if (!empty($this->atts['custom_url'])) {
			$this->atts['custom_url'] = htmlspecialchars($this->atts['custom_url'], ENT_QUOTES );
		}*/


	    //update unique id on each render
        $this->block_uid = td_global::td_generate_unique_id();

	    /** add the unique class to the block. The _rand class is used by the blocks js. @see tdBlocks.js  */
	    $unique_block_class = $this->block_uid . '_rand';
	    $this->add_class($unique_block_class);


	    $td_pull_down_items = array();




	    // do the query and make the AJAX filter only on loop blocks
		if ($this->is_loop_block() === true) {

			//by ref do the query
			$this->td_query = &td_data_source::get_wp_query($this->atts);

			// get the pull down items
			$td_pull_down_items = $this->block_loop_get_pull_down_items();
		}





        /**
         * Make a new block template instance (NOTE: ON EACH RENDER WE GENERATE A NEW BLOCK TEMPLATE)
         * td_block_template_x - Loaded via autoload
         * @see td_autoload_classes::loading_classes
         */
        $td_block_template_id = 'td_block_template_1';

        $this->td_block_template_data = array(
            'atts' => $this->atts,
            'block_uid' => $this->block_uid,
            'unique_block_class' => $unique_block_class,
            'td_pull_down_items' => $td_pull_down_items,
        );
        $this->td_block_template_instance = new $td_block_template_id($this->td_block_template_data);





        // echo the default style of the block
        echo $this->block_template()->get_css();

        return '';
    }


	/**
	 * This runs only on loop blocks!
	 * @return array the $td_pull_down_items
	 */
	private function block_loop_get_pull_down_items() {



		$td_pull_down_items = array();


		$td_ajax_filter_type   = $this->get_att('td_ajax_filter_type');
		$td_filter_default_txt = $this->get_att('td_filter_default_txt');
		$td_ajax_filter_ids    = $this->get_att('td_ajax_filter_ids');


		// td_block_mega_menu has it's own pull down implementation!
		if (get_class($this) != 'td_block_mega_menu') {
			// prepare the array for the td_pull_down_items, we send this array to the block_template

			if (!empty($td_ajax_filter_type)) {

				// make the default current pull down item (the first one is the default)
				$td_pull_down_items[0] = array (
					'name' => $td_filter_default_txt,
					'id' => ''
				);

				switch($td_ajax_filter_type) {
					case 'td_category_ids_filter': // by category
						$td_categories = get_categories(array(
							'include' => $td_ajax_filter_ids,
							'exclude' => '1',
							'number' => 100 //limit the number of categories shown in the drop down
						));

						// check if there's any id in the list
						if (!empty($td_ajax_filter_ids)) {
							// break the categories string
							$td_ajax_filter_ids = explode(',', $td_ajax_filter_ids);

							// order the categories - match the order set in the block settings
							foreach ($td_ajax_filter_ids as $td_category_id) {
								$td_category_id = trim($td_category_id);

								foreach ($td_categories as $td_category) {

									// retrieve the category
									if ($td_category_id == $td_category->cat_ID) {
										$td_pull_down_items [] = array(
											'name' => $td_category->name,
											'id' => $td_category->cat_ID,
										);
										break;
									}
								}
							}

							// if no category ids are added
						} else {
							foreach ($td_categories as $td_category) {
								$td_pull_down_items [] = array(
									'name' => $td_category->name,
									'id' => $td_category->cat_ID,
								);
							}
						}
						break;

					case 'td_author_ids_filter': // by author
						$td_authors = get_users(array('who' => 'authors', 'include' => $td_ajax_filter_ids));
						foreach ($td_authors as $td_author) {
							$td_pull_down_items []= array (
								'name' => $td_author->display_name,
								'id' => $td_author->ID,
							);
						}
						break;

					case 'td_tag_slug_filter': // by tag slug
						$td_tags = get_tags(array(
							'include' => $td_ajax_filter_ids
						));
						foreach ($td_tags as $td_tag) {
							$td_pull_down_items []= array (
								'name' => $td_tag->name,
								'id' => $td_tag->term_id,
							);
						}
						break;

					case 'td_popularity_filter_fa': // by popularity
						$td_pull_down_items []= array (
							'name' => __td('Featured', TD_THEME_NAME),
							'id' => 'featured',
						);
						$td_pull_down_items []= array (
							'name' => __td('All time popular', TD_THEME_NAME),
							'id' => 'popular',
						);
						break;
				}
			}
		}
		return $td_pull_down_items;
	}




    /**
     * this function adds the live filters atts when $atts['live_filter'] is set. The attributs are imidiatly available to all
     * after the render method is called
     *   - $atts['live_filter_cur_post_id'] - the current post id
     *   - $atts['live_filter_cur_post_author'] - the current post author
     * @param $atts
     * @return mixed
     */
    private function add_live_filter_atts($atts) {
        if (!empty($atts['live_filter'])) {
            $atts['live_filter_cur_post_id'] = get_queried_object_id(); //add the current post id
            $atts['live_filter_cur_post_author'] =  get_post_field( 'post_author', $atts['live_filter_cur_post_id']); //get the current author
        }
        return $atts;
    }



    /**
     * Used by blocks that need auto generated titles
     * @return string
     */
    function get_block_title() {
        return $this->block_template()->get_block_title();
    }


    /**
     * shows a pull down filter based on the $this->atts
     * @return string
     */
    function get_pull_down_filter() {
        return $this->block_template()->get_pull_down_filter();
    }


	/**
	 * retrivs the block pagination
	 * @return string
	 */
    function get_block_pagination() {

	    $offset = 0;

	    if (isset($this->atts['offset'])) {
		    $offset = $this->atts['offset'];
	    }

	    $buffy = '';


	    $ajax_pagination = $this->get_att('ajax_pagination');
	    $limit = $this->get_att('limit');


        switch ($ajax_pagination) {

            case 'next_prev':
                    $buffy .= '<div class="td-next-prev-wrap">';
                    $buffy .= '<a href="#" class="td-ajax-prev-page ajax-page-disabled" id="prev-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '"><i class="td-icon-font td-icon-menu-left"></i></a>';

					//if ($this->td_query->found_posts <= $limit) {
					if ($this->td_query->found_posts - $offset <= $limit) {
                        //hide next page because we don't have enough results
                        $buffy .= '<a href="#"  class="td-ajax-next-page ajax-page-disabled" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '"><i class="td-icon-font td-icon-menu-right"></i></a>';
                    } else {
                        $buffy .= '<a href="#"  class="td-ajax-next-page" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '"><i class="td-icon-font td-icon-menu-right"></i></a>';
                    }

                    $buffy .= '</div>';
                break;

            case 'load_more':
	            //if ($this->td_query->found_posts > $limit) {
	            if ($this->td_query->found_posts - $offset > $limit) {
		            $buffy .= '<div class="td-load-more-wrap">';
                    $buffy .= '<a href="#" class="td_ajax_load_more td_ajax_load_more_js" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '">' . __td('Load more', TD_THEME_NAME);
		            $buffy .= '<i class="td-icon-font td-icon-menu-down"></i>';
		            $buffy .= '</a>';
		            $buffy .= '</div>';
	            }
                break;

            case 'infinite':
				// show the infinite pagination only if we have more posts
		        if ($this->td_query->found_posts - $offset > $limit) {
		            $buffy .= '<div class="td_ajax_infinite" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '">';
		            $buffy .= ' ';
		            $buffy .= '</div>';


		            $buffy .= '<div class="td-load-more-wrap td-load-more-infinite-wrap" id="infinite-lm-' . $this->block_uid . '">';
                    $buffy .= '<a href="#" class="td_ajax_load_more td_ajax_load_more_js" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '">' . __td('Load more', TD_THEME_NAME);
		            $buffy .= '<i class="td-icon-font td-icon-menu-down"></i>';
		            $buffy .= '</a>';
		            $buffy .= '</div>';
	            }
                break;

        }

        return $buffy;
    }















    function get_block_js() {
	    // td-composer PLUGIN uses this hook to call $this->js_callback_ajax
	    // @see tdc_ajax.php -> on_ajax_render_shortcode in td-composer
	    do_action('td_block__get_block_js', array(&$this));

	    if (td_util::tdc_is_live_editor_iframe()) {
		    td_js_buffer::add_to_footer($this->js_tdc_get_composer_block());
		    return '';
	    }

		// do not run in ajax requests
	    if (td_util::tdc_is_live_editor_ajax()) {
		    return '';
	    }

        //get the js for this block - do not load it in inline mode in visual composer
        if (td_util::vc_is_inline()) {
            return '';
        }


	    // do not output the block js if it's not a loop block
	    if ($this->is_loop_block() === false) {
		    return '';
	    }



	    // new tdBlock() item for ajax blocks / loop_blocks
	    // we don't get here on blocks that are not loop blocks

	    $block_item = 'block_' . $this->block_uid;

	    $buffy = '<script>';
		    $atts = $this->atts;
		    $buffy .= 'var ' . $block_item . ' = new tdBlock();' . "\n";
		    $buffy .= $block_item . '.id = "' . $this->block_uid . '";' . "\n";
		    $buffy .= $block_item . ".atts = '" . str_replace("'", "\u0027", json_encode($this->atts)) . "';" . "\n";
		    $buffy .= $block_item . '.td_column_number = "' . $atts['td_column_number'] . '";' . "\n";
		    $buffy .= $block_item . '.block_type = "' . get_class($this) . '";' . "\n";

		    //wordpress wp query parms
		    $buffy .= $block_item . '.post_count = "' . $this->td_query->post_count . '";' . "\n";
		    $buffy .= $block_item . '.found_posts = "' . $this->td_query->found_posts . '";' . "\n";

		    $buffy .= $block_item . '.header_color = "' . $atts['header_color'] . '";' . "\n"; // the header_color is needed for the animated loader
		    $buffy .= $block_item . '.ajax_pagination_infinite_stop = "' . $atts['ajax_pagination_infinite_stop'] . '";' . "\n";


		    // The max_num_pages is computed so it considers the offset and the limit atts settings
		    // There were necessary these changes because on the user interface there are js scripts that use the max_num_pages js variable to show/hide some ui components
		    if (!empty($this->atts['offset'])) {

			    if ($this->atts['limit'] != 0) {
				    $buffy .= $block_item . '.max_num_pages = "' . ceil( ( $this->td_query->found_posts - $this->atts['offset'] ) / $this->atts['limit'] ) . '";' . "\n";

			    } else if (get_option('posts_per_page') != 0) {
				    $buffy .= $block_item . '.max_num_pages = "' . ceil( ( $this->td_query->found_posts - $this->atts['offset'] ) / get_option('posts_per_page') ) . '";' . "\n";
			    }
		    } else {
			    $buffy .= $block_item . '.max_num_pages = "' . $this->td_query->max_num_pages . '";' . "\n";
		    }

		    $buffy .= 'tdBlocksArray.push(' . $block_item . ');' . "\n";
	    $buffy .= '</script>';





        $td_column_number = $this->get_att('td_column_number');
        if (empty($td_column_number)) {
            $td_column_number = td_util::vc_get_column_number(); // get the column width of the block so we can sent it to the server. If the shortcode already has a user defined column number, we use that
        }







        // ajax subcategories preloader
        // @todo preloading "all" filter content should happen regardless of the setting
        if (
            !empty($this->td_block_template_data['td_pull_down_items'])
            and !empty($this->atts['td_ajax_preloading'])
        ) {


	        /*  -------------------------------------------------------------------------------------
	            add 'ALL' item to the cache
	        */
            // pagination - we need to compute the pagination for each cache entry
            $td_hide_next = false;
            if (!empty($this->atts['offset']) && !empty($this->atts['limit']) && ($this->atts['limit'] != 0)) {
                if (1 >= ceil(($this->td_query->found_posts - $this->atts['offset']) / $this->atts['limit'])) {
                    $td_hide_next = true; //hide link on last page
                }
            } else if (1 >= $this->td_query->max_num_pages) {
                $td_hide_next = true; //hide link on last page
            }

            // this will be send to JS bellow
            $buffyArray = array (
                'td_data' => $this->inner($this->td_query->posts, $td_column_number),
                'td_block_id' => $this->block_uid,
                'td_hide_prev' => true,  // this is the first page
                'td_hide_next' => $td_hide_next
            );



	        /*  -------------------------------------------------------------------------------------
	            add the rest of the items to the local cache
	        */
            ob_start();
            // we need to clone the object to set is_ajax_running to true
            // first we set an object for the all filter
            ?>
            <script>
                var tmpObj = JSON.parse(JSON.stringify(<?php echo $block_item ?>));
                tmpObj.is_ajax_running = true;
                var currentBlockObjSignature = JSON.stringify(tmpObj);
                tdLocalCache.set(currentBlockObjSignature, JSON.stringify(<?php echo json_encode($buffyArray) ?>));
                <?php
                    foreach ($this->td_block_template_data['td_pull_down_items'] as $count => $item) {
                        if (empty($item['id'])) {
                            continue;
                        }

                        // preload only 6 or 20 items depending on the setting
                        if ($this->atts['td_ajax_preloading'] == 'preload_all' and $count > 20) {
                            break;
                        }
                        else if ($this->atts['td_ajax_preloading'] == 'preload' and $count > 6) {
                            break;
                        }

                        $ajax_parameters = array (
                            'td_atts' => $this->atts,            // original block atts
                            'td_column_number' => $td_column_number,    // should not be 0 (1 - 2 - 3)
                            'td_current_page' => 1,    // the current page of the block
                            'td_block_id' => $this->block_uid,        // block uid
                            'block_type' => get_class($this),         // the type of the block / block class
                            'td_filter_value' => $item['id']     // the id for this specific filter type. The filter type is in the td_atts
                        );
                        ?>
                            tmpObj = JSON.parse(JSON.stringify(<?php echo $block_item ?>));
                            tmpObj.is_ajax_running = true;
                            tmpObj.td_current_page = 1;
                            tmpObj.td_filter_value = <?php echo $item['id'] ?>;
                            var currentBlockObjSignature = JSON.stringify(tmpObj);
                            tdLocalCache.set(currentBlockObjSignature, JSON.stringify(<?php echo td_ajax::on_ajax_block($ajax_parameters) ?>));
                        <?php
                    }
                ?>
            </script>
            <?php
            //ob_clean();
            $buffy.= ob_get_clean();
        } // end preloader if





        return $buffy;
    }


	/**
	 * tagDiv composer specific code:
	 * This is a callback that is retrieve and injected into the iFrame by td-composer on Ajax operations
	 * This js runs on the client after a drag and drop operation in td-composer
	 * @return string JS code that is sent straight to an eval() on the client side
	 */
	function js_tdc_callback_ajax() {

		$buffy = '';


		$buffy .= $this->js_tdc_get_composer_block();



		// If this is not a loop block or if we don't have pull down ajax filters, do not run. This is just to fix the pulldown items on
		// content blocks
		if ($this->is_loop_block() === true && !empty($this->td_block_template_data['td_pull_down_items'])) {
			ob_start();
			?>
			<script>


				// block subcategory ajax filters!
				var jquery_object_container = jQuery('.<?php echo $this->block_uid ?>_rand .td-subcat-filter');
				var horizontal_jquery_obj = jquery_object_container.find('.td-subcat-list:first');

				// make a new item
				var pulldown_item_obj = new tdPullDown.item();
				pulldown_item_obj.blockUid = jquery_object_container.parent().data('td-block-uid'); // get the block UID
				pulldown_item_obj.horizontal_jquery_obj = horizontal_jquery_obj;
				pulldown_item_obj.vertical_jquery_obj = jquery_object_container.find('.td-subcat-dropdown:first');
				pulldown_item_obj.horizontal_element_css_class = 'td-subcat-item';
				pulldown_item_obj.container_jquery_obj = horizontal_jquery_obj.parents('.td_block_wrap:first');
				pulldown_item_obj.excluded_jquery_elements = [horizontal_jquery_obj.parent().siblings('.block-title:first')];
				tdPullDown.add_item(pulldown_item_obj); // add the item

			</script>
			<?php
			$buffy .= td_util::remove_script_tag(ob_get_clean());
		}



		return $buffy;

	}





	/**
	 * tagDiv composer specific code:
	 *  - it's added to the end of the iFrame when the live editor is active (when @see td_util::tdc_is_live_editor_iframe()  === true)
	 *  - it is injected int he iFrame and evaluated there in the global scoupe when a new block is added to the page via AJAX!
	 * @return string the JS without <script> tags
	 */
	function js_tdc_get_composer_block() {
		ob_start();
		?>
		<script>
			(function () {
				var tdComposerBlockItem = new tdcComposerBlocksApi.item();
				tdComposerBlockItem.blockUid = '<?php echo $this->block_uid ?>';
				tdComposerBlockItem.callbackDelete = function(blockUid) {

					// delete the existing pulldown if it exists
					tdPullDown.deleteItem(blockUid);

					// delete the animation sprite if it exits
					tdAnimationSprite.deleteItem(blockUid);

					// delete the weather item if available NOTE USED YET
					//tdWeather.deleteItem(blockUid);

					tdcDebug.log('td_block.php js_tdc_get_composer_block  -  callbackDelete(' + blockUid + ') - td_block base callback runned');
				};
				tdcComposerBlocksApi.addItem(tdComposerBlockItem);
			})();
		</script>
		<?php
		return td_util::remove_script_tag(ob_get_clean());
	}






	// get atts
	protected function get_block_html_atts() {
		return ' data-td-block-uid="' . $this->block_uid . '" ';
	}


    /**
     * @param $additional_classes_array array - of classes to add to the block
     * @return string
     */
    function get_block_classes($additional_classes_array = array()) {


	    $class = $this->get_att('class');
	    $color_preset = $this->get_att('color_preset');
		$ajax_pagination = $this->get_att('ajax_pagination');
	    $border_top = $this->get_att('border_top');




        //add the block wrap and block id class
        $block_classes = array(
            'td_block_wrap',
	        get_class($this)
        );

        //add the classes that we receive via shortcode
        if (!empty($class)) {
            $class_array = explode(' ', $class);
            $block_classes = array_merge(
                $block_classes,
                $class_array
            );
        }

        //marge the additional classes received from blocks code
        if (!empty($additional_classes_array)) {
            $block_classes = array_merge(
                $block_classes,
                $additional_classes_array
            );
        }


        //add the full cell class + the color preset class
        if (!empty($color_preset)) {
            $block_classes[]= 'td-pb-full-cell';
            $block_classes[]= $color_preset;
        }


	    /**
	     * - used to add td_block_loading css class on the blocks having pagination
	     * - the class has a force css transform for lazy devices
	     */
	    if (!empty($ajax_pagination)) {
		    $block_classes[]= 'td_with_ajax_pagination';
	    }


        /**
         * add the border top class - this one comes from the atts
         */
        if (empty($border_top)) {
            $block_classes[]= 'td-pb-border-top';
        }


        //remove duplicates
        $block_classes = array_unique($block_classes);


	    // @warning :) we also append the data block uid here. Ugly hack but it should work for now
        return implode(' ', $block_classes);
    }


    /**
     * adds a class to the current block's ats
     * @param $raw_class_name string the class name is not sanitized, so make sure you send a sanitized one
     */
    private function add_class($raw_class_name) {
        if (!empty($this->atts['class'])) {
            $this->atts['class'] = $this->atts['class'] . ' ' . $raw_class_name;
        } else {
            $this->atts['class'] = $raw_class_name;
        }
    }


    /**
     * gets the current template instance, if no instance it's found throws error
     * @return mixed the template instance
     * @throws ErrorException - no template instance found
     */
    private function block_template() {
        if (isset($this->td_block_template_instance)) {
            return $this->td_block_template_instance;
        } else {
	        td_util::error(__FILE__, "td_block: " . get_class($this) . " did not call render, no td_block_template_instance in td_block");
	        die;
        }
    }


	/**
	 * Safe way to read $this->atts. It makes sure that you read them when they are ready and set! For now, the class is not refactorized to use this
	 * @param $att_name
	 * @return mixed
	 */
	private function get_att($att_name) {
		if (empty($this->atts)) {
			td_util::error(__FILE__, get_class($this) . '->get_att(' . $att_name . ') Internal error: The atts are not set yet(AKA: the render method was not called yet and the system tried to read an att)');
			die;
		}

		if (!isset($this->atts[$att_name])) {
			td_util::error(__FILE__, 'Internal error: The system tried to use an att that does not exists! The list with available atts is in td_block::render');
			die;
		}

		return $this->atts[$att_name];
	}



	/**
 	 * Disable loop block features. If this is disable, the block does not use a loop and it dosn't need to run a query.
 	 *  - no query
	 *  - no pulldown items lis (ajax filters)
	 *  - no ajax JS ex: NO new tdBlock()
	 */
	protected function disable_loop_block_features() {
		$this->is_loop_block = false;
	}


	private function is_loop_block() {
		return $this->is_loop_block;
	}

}

