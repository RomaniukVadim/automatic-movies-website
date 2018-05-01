<?php
abstract class td_smart_list {

    private $counting_order_asc = false;    //how to count the items in the list
    private $counting_start = 1;            //start from 1 or 0 ? - As of 31 July 2015 IT'S NOT USED :(

    protected $use_pagination = false;      // if true: tells our render function to only output the current item


    private $list_items; // we keep the items on render here


    abstract protected function render_list_item($item_array, $current_item_id, $current_item_number, $total_items_number); //child classes must implement this :)

    /**
     * renders a smart list form content. This should be the ONLY public thing for now
     * @param $smart_list_settings array of settings for the smart list
     * @return string
     */
    function render_from_post_content($smart_list_settings) {

        $this->counting_order_asc = $smart_list_settings['counting_order_asc'];


        // make a new tokenizer
        $td_tokenizer = new td_tokenizer();
        $td_tokenizer->token_title_start = $smart_list_settings['td_smart_list_h'];
        $td_tokenizer->token_title_end = $smart_list_settings['td_smart_list_h'];


        // get the list items
        $list_items = $td_tokenizer->split_to_list_items(array(
	            'content' => $smart_list_settings['post_content'],
		        'extract_first_image' => $smart_list_settings['extract_first_image']
	        )
        );


	    //print_r($list_items);

        // no items found, we return the content as is
        if (empty($list_items['list_items'])) {
            return $smart_list_settings['post_content'];
        }

        // we need to number all the items before pagination because item 2 can have number 4 if the counting method is desc
        $list_items = $this->add_numbers_to_list_items($list_items);

        if ($this->use_pagination === true) {
            $current_page = $this->get_current_page($list_items);
            return $this->render($list_items, $current_page);
        } else {
            return $this->render($list_items);
        }

    }


    /**
     * Calculate the total item number and the current item number
     *  current item number can be asc, desc and start from 0 or 1 etc.
     * @param $list_items
     * @return array - $list_items with added 'current_item_number' and 'total_items_number' keys
     */
    private function add_numbers_to_list_items($list_items) {

        $total_items_number = count($list_items['list_items']) - 1 + $this->counting_start; // fix for 0 base counting (0 of 3 - to -  3 of 3)

        //render each item using the render_list_item method from the child class
        foreach ($list_items['list_items'] as $list_item_key => &$list_item) {

            //how to count (asc or desc)
            if ($this->counting_order_asc === true) {
                $current_item_index = $list_item_key + $this->counting_start;
            } else {
                $current_item_index = $total_items_number - ($list_item_key);
            }

            $list_item['current_item_number'] = $current_item_index;
            $list_item['total_items_number'] = $total_items_number;
        }

        return $list_items;
    }

    /**
     * This is the rendering function. It gets a list of items and it outputs HTML
     * @param $list_items - the smart list list of items
     * @return string - the smart list's HTML
     */
    private function render($list_items, $current_page = false) {
        /*
        $total_pages = count($this->list_items['list_items']);
        if ($current_page > $total_pages) {
            status_header(404);
            nocache_headers();
            include( get_404_template() );
            exit;
        }
        */

        // we make the list items available to other functions (like pagination)
        $this->list_items = $list_items;

        $buffy = '';

        /*  ----------------------------------------------------------------------------
            add the before_list content
         */
        if (!empty($list_items['before_list'])) {
            $buffy .= implode('', $list_items['before_list']);
        }

        /*  ----------------------------------------------------------------------------
            add the list
         */
        $buffy .= $this->render_before_list_wrap();  //from child class

        if ($current_page === false) {
            //render each item using the render_list_item method from the child class
            foreach ($list_items['list_items'] as $list_item_key => $list_item) {
                $buffy .= $this->render_list_item($list_item, $list_item_key + 1, $list_item['current_item_number'], $list_item['total_items_number']);
            }
        } else {

            $array_id_from_paged = $current_page - 1;
            $buffy .= $this->render_list_item(
                $list_items['list_items'][$array_id_from_paged],
                $array_id_from_paged,
                $list_items['list_items'][$array_id_from_paged]['current_item_number'],
                $list_items['list_items'][$array_id_from_paged]['total_items_number']
            );
        }

        $buffy .= $this->render_after_list_wrap(); //from child class - render the list wrap end


        /*  ----------------------------------------------------------------------------
            add the after_list content
         */
        if (!empty($list_items['after_list'])) {
            $buffy .= implode('', $list_items['after_list']);
        }

        return $buffy;
    }


    /**
     * callback function, it's used by smart lists child to render the pagination
     * @uses td_smart_list::list_items
     * @return string
     */
    protected function callback_render_pagination() {


        $buffy = '';

        $current_page = $this->get_current_page($this->list_items);
        $total_pages = count($this->list_items['list_items']);




        // no pagination if we have one page!
        if ($total_pages == 1) {
            return '';
        }

        //        echo $paged;
        //        echo $total_pages;

        if ($current_page == 1) {
            // first page
            $buffy .= '<div class="td-smart-list-pagination">';
                $buffy .= '<span class="td-smart-list-button td-smart-back td-smart-disable"><i class="td-icon-left"></i>' .__td('Back', TD_THEME_NAME). '</span>';
                $buffy .= '<a class="td-smart-list-button td-smart-next" rel="next" href="' . $this->_wp_link_page($current_page + 1) . '">' .__td('Next', TD_THEME_NAME). '<i class="td-icon-right"></i></a>';
            $buffy .= '</div>';
        }
        elseif ($current_page == $total_pages) {
            // last page
            $buffy .= '<div class="td-smart-list-pagination">';
                $buffy .= '<a class="td-smart-list-button td-smart-back" rel="prev" href="' . $this->_wp_link_page($current_page - 1) . '"><i class="td-icon-left"></i>' .__td('Back', TD_THEME_NAME). '</a>';
                $buffy .= '<span class="td-smart-list-button td-smart-next td-smart-disable">' .__td('Next', TD_THEME_NAME). '<i class="td-icon-right"></i></span>';
            $buffy .= '</div>';
        }
        else {
            // middle page
            $buffy .= '<div class="td-smart-list-pagination">';
                $buffy .= '<a class="td-smart-list-button td-smart-back" rel="prev" href="' . $this->_wp_link_page($current_page - 1) . '"><i class="td-icon-left"></i>' .__td('Back', TD_THEME_NAME). '</a>';
                $buffy .=  '<a class="td-smart-list-button td-smart-next" rel="next" href="' . $this->_wp_link_page($current_page + 1) . '">' .__td('Next', TD_THEME_NAME). '<i class="td-icon-right"></i></a>';
            $buffy .= '</div>';
        }

        return $buffy;
    }


    protected function callback_render_drop_down_pagination() {
        $buffy = '';


        $current_page = $this->get_current_page($this->list_items);
        $total_pages = count($this->list_items['list_items']);

        // no pagination if we have one page!
        if ($total_pages == 1) {
            return '';
        }


        $buffy .= '<div class="td-smart-list-dropdown-wrap">';


        // render back page button
        if ($current_page == 1) {
            // is first page
            $buffy .= '<span class="td-smart-list-button td-smart-back td-smart-disable"><i class="td-icon-left"></i><span>' .__td('Back', TD_THEME_NAME). '</span></span>';
        } else {
            $buffy .= '<a class="td-smart-list-button td-smart-back" href="' . $this->_wp_link_page($current_page - 1) . '"><i class="td-icon-left"></i><span>' .__td('Back', TD_THEME_NAME). '</span></a>';
        }


        // render the drop down
        $buffy .= '<div class="td-smart-list-container"><select class="td-smart-list-dropdown">';
        foreach ($this->list_items['list_items'] as $index => $list_item) {
            $list_item_page_nr = $index + 1;
            $selected = '';

            if ($current_page == $list_item_page_nr) {
                $selected = 'selected';
            }

            $buffy .= '<option ' . $selected . ' value="' . esc_attr($this->_wp_link_page($list_item_page_nr)) . '">' . $list_item['current_item_number'] . ' - ' . $list_item['title'] . '</option>';
        }
        $buffy .= '<select></div>';


        // render next page button
        if ($current_page == $total_pages) {
            // is last page
            $buffy .= '<span class="td-smart-list-button td-smart-next td-smart-disable"><span>' .__td('Next', TD_THEME_NAME). '</span><i class="td-icon-right"></i></span>';
        } else {
            $buffy .=  '<a class="td-smart-list-button td-smart-next" href="' . $this->_wp_link_page($current_page + 1) . '"><span>' .__td('Next', TD_THEME_NAME). '</span><i class="td-icon-right"></i></a>';
        }


        $buffy .= '</div>';

        return $buffy;
    }


    /**
     * Hax to intercept the current page of the post
     * @return int|mixed
     */
    private function get_current_page($list_items) {
        $td_page = (get_query_var('page')) ? get_query_var('page') : 1; //rewrite the global var
        $td_paged = (get_query_var('paged')) ? get_query_var('paged') : 1; //rewrite the global var
        //paged works on single pages, page - works on homepage
        if ($td_paged > $td_page) {
            $current_page = $td_paged;
        } else {
            $current_page = $td_page;
        }
        // if no pages, we are on the first page
        if (empty($current_page)) {
            return 1;
        }

        // if the requested page is bigger than our number of items, return the last page
        // this is how the default wordpress post pagination works!
        $total_pages = count($list_items['list_items']);
        if ($current_page > $total_pages) {
            $current_page = $total_pages;
        }

        return $current_page;
    }



	/*
	 * @todo The next _wp_link_page function should be moved to td_util class, this being a custom helper function.
	 * The access specifier was changed from 'private' to 'public'
	 *
	 */

    /**
     * This function returns the pagination link for the current post
     * TAGDIV: - taken from wordpress wp-includes/post-template.php
     *         - we removed the wrapping <a>
     *         - original name: _wp_link_page
     *
     * Helper function for wp_link_pages().
     *
     * @since 3.1.0
     * @access private
     *
     * @param int $i Page number.
     * @return string Link.
     */
    public function _wp_link_page( $i ) {
        global $wp_rewrite;
        $post = get_post();

        if ( 1 == $i ) {
            $url = get_permalink();
        } else {
            if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
                $url = add_query_arg( 'page', $i, get_permalink() );
            elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID )
                $url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
            else
                $url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
        }

        if ( is_preview() ) {
            $url = add_query_arg( array(
                'preview' => 'true'
            ), $url );

            if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
                $url = add_query_arg( array(
                    'preview_id'    => wp_unslash( $_GET['preview_id'] ),
                    'preview_nonce' => wp_unslash( $_GET['preview_nonce'] )
                ), $url );
            }
        }

        return esc_url( $url );
    }

    /**
     * what to render at the start of the smart list (usually it's overwritten by child classes)
     */
    protected function render_before_list_wrap() {
        return '';
    }

    /**
     * what to render at the end of the list (usually it's overwritten by child classes)
     */
    protected function render_after_list_wrap() {
        return '';
    }


	/**
	 * Split the content into items and return the item list.
	 * For the moment it's used to compute the canonical links by a wp_head callback function.
	 *
	 * Obs. It's too late to hook on wp_head from here, that's why this helper function is called
	 * from a wp_head callback function early registered in booster functions.
	 *
	 * @param $smart_list_settings
	 *
	 * @return array
	 */
	function get_formatted_list_items($smart_list_settings) {
		$this->counting_order_asc = $smart_list_settings['counting_order_asc'];

		// make a new tokenizer
		$td_tokenizer = new td_tokenizer();
		$td_tokenizer->token_title_start = $smart_list_settings['td_smart_list_h'];
		$td_tokenizer->token_title_end = $smart_list_settings['td_smart_list_h'];


		// get the list items
		$list_items = $td_tokenizer->split_to_list_items(array(
				'content' => $smart_list_settings['post_content'],
				'extract_first_image' => $smart_list_settings['extract_first_image']
			)
		);

		// no items found, we return the content as is
		if (empty($list_items['list_items'])) {
			return $smart_list_settings['post_content'];
		}

		// we need to number all the items before pagination because item 2 can have number 4 if the counting method is desc
		$list_items = $this->add_numbers_to_list_items($list_items);

		return $list_items;
	}

}


/**
 * Class td_tokenizer - the magic tokenizer
 */
class td_tokenizer {


    private $log = false; //enable or disable the log
    private $last_log_function = '';
    private $last_log_token = '';
    private $last_token_id = 0;


    var $token_title_start = 'h3';
    var $token_title_end = 'h3';
    private $token_title_is_open = false; //are we in the title tag?
    private $token_td_smart_list_end = false; //did we reach the end of the list




    private $current_list_item = array(); //here we keep the current list item

    private $buffy = array();



    function __construct() {
        $this->current_list_item = $this->get_empty_list_item();



    }




    function split_to_list_items ($params) {

	    $content = $params['content'];
	    $extract_first_image = $params['extract_first_image'];

        //(<figure.*<\/figure>) - html5 image + caption
        //(<p>.*<a.*<img.*<\/a>.*<\/p>) - p a img
        //(<a.*<img.*\/a>) - a img
        //(<p>.*<img.*\/>.*<\/p>) - p img
        //(<img.*\/>) - img
        //(<p>.*[.*td_smart_list_end.*].*<\/p>) - <p> [td_smartlist_end] </p>
        //([.*td_smart_list_end.*]) - [td_smartlist_end] without p


	    // add the image regex ONLY if we want to also extract the image
	    $img_regex = '';
	    if ($extract_first_image === true) {
		    $img_regex = "(<figure.*</figure>)|" .
		                 "(<p>.*<a.*<img.*</a>.*</p>)|" .  //two step - checks for image + description
		                 "(<a.*<img.*</a>)|" .
		                 "(<p>.*<img.*/>.*</p>)|" .
		                 "(<img.*/>)|";
	    }


        $td_magic_regex = $this->fix_regex(
            "(<$this->token_title_start.*?>)|" .
            "(</$this->token_title_end>)|" .
            $img_regex .
            "(<p>.*[.*td_smart_list_end.*].*</p>)|" .
            "([.*td_smart_list_end.*])");
        //echo $td_magic_regex;

        $tokens_list = preg_split('/' . $td_magic_regex . '/', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $tokens_list = array_map('trim', $tokens_list); //trim elements
        $tokens_list = array_filter( $tokens_list, 'strlen'); //filter empty, null etc except 0 (may be a bug 0)


        //print_r($tokens_list);


        foreach($tokens_list as $token) {

            if ($this->is_title_open($token)) {
            }

            elseif($this->is_content_after_smart_list($token)) {
            }

            elseif ($this->is_content_before_smart_list($token)) {

            }

            elseif ($this->is_title_close($token)) {
            }

            elseif ($this->is_title_text($token)) {
            }

            // note that is_first_image also manipulates the 'description' - so it has to be last in this elseif
            elseif ($extract_first_image === true and $this->is_first_image($token)) {
            }

            elseif($this->is_smart_list_end($token)) {
            }

            elseif ($this->is_description($token)) {
            }

            else {
                //normal content?
                $this->log_step('no match', $token);
            }

            $this->log_loop_complete();
        }


        //add the remaining element (last one)
        if (!empty($this->current_list_item['title'])) {
            $this->buffy['list_items'][] = $this->current_list_item;
        }


        return $this->buffy;
    }




    private function get_empty_list_item () {
        return array(
            'title' => '',
            'first_img_id' => '',
            'description' => '',
            'read_more_link' => '',
            'first_img_link' => '',
            'first_img_link_target' => '',
            'first_img_caption' => ''
        );
    }




    private function is_title_open($token) {
        $this->log_step(__FUNCTION__, $token);
        $matches = array();
        preg_match('/<' . $this->token_title_start . '.*?>/', $token, $matches); //match <h3 class="with_optional_class">


        if (!empty($matches)) {
            $this->token_title_is_open = true;
            return true;
        } else {
            return false;
        }


    }

    private function is_title_close($token) {
        $this->log_step(__FUNCTION__, $token);
        if ($token == '</' . $this->token_title_end . '>') {
            $this->token_title_is_open = false; //make sure we change the h3 state
            return true;
        } else {
            return false;
        }
    }

    /**
     * this function also pushes the working buffer ($this->current_list_item) to $this->buffy
     * @param $token
     * @return bool
     */
    private function is_title_text($token) {
        $this->log_step(__FUNCTION__, $token);
        if ($this->token_title_is_open === true) {


            //if the last list item is not empty, we add it to the list_items buffer
            if (!empty($this->current_list_item['title'])) {
                $this->buffy['list_items'][] = $this->current_list_item;
            }

            //empty the list - RESET

            $this->current_list_item = $this->get_empty_list_item();
            $this->current_list_item['title'] = $token; //put the new title

            $this->token_title_is_open = false; //make sure we change the h3 state - this is a fix for cases when we don't have h3

            return true;
        } else {
            return false;
        }
    }

    private function is_smart_list_end($token) {
        $this->log_step(__FUNCTION__, $token);

        $matches = array();
        preg_match('/\[.*td_smart_list_end.*\]/', $token, $matches);

        if (!empty($matches[0])) {
            $this->token_td_smart_list_end = true;
            return true;
        } else {
            return false;
        }
    }

    /**
     * returns true if the content is before the smart list
     */
    private function is_content_before_smart_list($token) {
        $this->log_step(__FUNCTION__, $token);
        if (($this->token_title_is_open === true or !empty($this->current_list_item['title']) ) and $this->token_td_smart_list_end === false) {
            return false;

        } else {
            $this->buffy['before_list'][] = $token;
            return true;

        }
    }

    /**
     * returns true if the content is after the smart list
     */
    private function is_content_after_smart_list($token) {
        $this->log_step(__FUNCTION__, $token);
        if ($this->token_td_smart_list_end === true) {
            $this->buffy['after_list'][] = $token;
            return true;

        } else {
            return false;
        }
    }


    /**
     * returns true only if it's the first image
     * @param $token
     * @return bool
     */
    private function is_first_image($token) {
        $this->log_step(__FUNCTION__, $token);
        if (!empty($this->current_list_item['first_img_id'])) { //we already have the first image for this item
            return false;
        }




        $matches = array();
        preg_match('/wp-image-([0-9]+)/', $token, $matches);

        //do we have an image?
        if (!empty($matches[1])) {

            //do we have also some description in the same paragraph with the image?
            $tmp_description = $this->extract_description_from_first_image($token);

            /*
            echo '


            -----x-----------

            ';

            echo $token;

            echo '
            ---->
            ';

            echo $tmp_description;

            echo '
            --
            ';

            */
            if ($tmp_description != '') {
                $this->current_list_item['description'] .= $tmp_description;
            }


            $this->current_list_item['first_img_id'] = $this->get_image_id_from_token($token);
            $this->current_list_item['first_img_link'] = $this->get_image_link_from_token($token);
            $this->current_list_item['first_img_link_target'] = $this->get_image_link_target_from_token($token);
            $this->current_list_item['first_img_caption'] = $this->get_caption_from_token($token);

            return true;
        } else {
            return false;
        }
    }

    /**
     * It takes a paragraph <p> and:
     * 1. it extracts all the links and searches each one for images. If an image is found, it is removed from the text because it's already used as a first_image
     * 2. if no links with images are found, it searches for raw images without any link. It also removes the first one.
     * @param $token
     * @return mixed
     */
    private function extract_description_from_first_image($token) {
        $matches = '';
        $buffy = '';


        //0. check if we have a figure in the token. Figures are USUALLY alone (not in paragraph)
        if (strpos($token,'<figure') !== false) {
            return '';
        }


        //1. search for all the links in this toke / block of text - if this steps retuns something, the second step doesn't run
        preg_match_all('/<a.*\/a>/U', $token, $matches); //extract all links
        if (!empty($matches[0]) and is_array($matches[0])) {
            foreach ($matches[0] as $match) {
                if (strpos($match, '<img') !== false) { //check each link if we have an image in it
                    // we need the extra str_replace because the $match is user entered in tinymce
                    // special chars added in the image alternative text must be escaped - [\^$.|?*+(){}
                    $special_chars = array("(", ")", "^", "$", "|", "?", "*", "+", "{", "}");
                    foreach ($special_chars as $char) {
                        $escaped_char = '\\' . $char;
                        $match = str_replace($char, $escaped_char, $match);
                    }
//                    $match = str_replace('(', '\(', $match);
//                    $match = str_replace(')', '\)', $match);
                    $buffy = preg_replace('/' . $this->fix_regex($match) . '/', '', $token, 1); //remove the first image because that will be used as first_image
                    break;
                }
            }
        }

        //2. no match found
        if ($buffy == '') {
            //search for the FIRST img if we didn't find any links in the block of text
            $matches = '';
            preg_match('/<img.*\/>/U', $token, $matches); //extract first image
            if (!empty($matches[0])) {
                // we need the extra str_replace because the $matches[0] is user entered in tinymce
                // special chars added in the image alternative text must be escaped - [\^$.|?*+(){}
                $special_chars = array("(", ")", "^", "$", "|", "?", "*", "+", "{", "}");
                $char_count = 0;
                foreach ($special_chars as $char) {
                    $escaped_char = '\\' . $char;
                    if ($char_count == 0) {
                        // first time target the matches array
                        $input_regex = str_replace($char, $escaped_char, $matches[0]);
                        $char_count++;
                    } else {
                        $input_regex = str_replace($char, $escaped_char, $input_regex);
                    }
                }
//                $input_regex = str_replace('(', '\(', $matches[0]);
//                $input_regex = str_replace(')', '\)', $input_regex);
                $buffy = preg_replace('/' . $this->fix_regex($input_regex) . '/', '', $token, 1); //remove the first image because that will be used as first_image
            }
        }

        $buffy = trim($buffy);

        return $buffy;
    }


    /**
     * returns true only if the current item has a title
     * @param $token
     * @return bool
     */
    private function is_description($token) {
        $this->log_step(__FUNCTION__, $token);
        if (!empty($this->current_list_item['title']) and $this->token_td_smart_list_end === false) {  //if we have a item with title and the list did not ended, it's a description if not it's random text
            $this->current_list_item['description'] .= $token;
            return true;
        } else {
            return false;
        }
    }




    private function get_image_id_from_token($token) {
        $matches = array();
        preg_match('/wp-image-([0-9]+)/', $token, $matches);
        if (!empty($matches[1])) {
            return $matches[1];
        } else {
            return '';
        }
    }


    private function get_image_link_from_token($token) {
        $matches = array();
        preg_match('/href="([^\\"]+)"/', $token, $matches);
        if (!empty($matches[1])) {
            return $matches[1];
        } else {
            return '';
        }
    }


    private function get_image_link_target_from_token($token) {
        $matches = array();
        preg_match('/target="([^\\"]+)"/', $token, $matches);
        if (!empty($matches[1])) {
            return 'target="' . $matches[1] . '"';
        } else {
            return '';
        }
    }


    private function get_caption_from_token($token) {
        $matches = array();
        preg_match('/<figcaption[^<>]*>([^<]*)<\/figcaption>/', $token, $matches);
        if (!empty($matches[1])) {
            return $matches[1];
        } else {
            return '';
        }
    }


    private function log_step($function_name, $token = '') {
        if ($this->log === true) {
            $this->last_log_function = $function_name;
            $this->last_log_token = $token;

        }
    }

    private function log_loop_complete() {
        if ($this->log === true) {
            //echo "\n -- Step complete -- \n\n";
            echo $this->last_token_id . ' ' . $this->last_log_function . ' -- token: ' . $this->last_log_token . "\n";

            $this->last_log_token = '';
            $this->last_log_function = '';

            $this->last_token_id++;
        }
    }


    /**
     * fix the regex string
     * @param $input_regex
     * @return mixed
     */
    private function fix_regex($input_regex) {
        $input_regex = str_replace('/', '\/', $input_regex);
        $input_regex = str_replace(']', '\]', $input_regex);
        $input_regex = str_replace('[', '\[', $input_regex);
        return $input_regex;
    }


}