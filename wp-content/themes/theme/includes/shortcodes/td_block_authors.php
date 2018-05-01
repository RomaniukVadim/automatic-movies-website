<?php
class td_block_authors extends td_block {


	/**
	 * Disable loop block features. This block does not use a loop and it dosn't need to run a query.
	 */
	function __construct() {
		parent::disable_loop_block_features();
	}



    function render($atts, $content = null) {
	    parent::render($atts);
        global $wpdb;

        $sort = '';

        extract(shortcode_atts(
            array(
                'roles' => '',
                'sort' => '',
                'exclude' => '',
                'include' => ''
            ), $atts));



        //print_r($atts);
        //die;

        $get_users_array = array();

        if (!empty($exclude)) {
            $exclude_array = explode(',', $exclude);
            $get_users_array['exclude'] = $exclude_array;
        }

        if (!empty($include)) {
            $include_array = explode(',', $include);
            $get_users_array['include'] = $include_array;
        }


        if (empty($sort)) {
            $get_users_array['orderby'] = 'display_name';
            //$td_authors = get_users(array('orderby' => 'display_name'));
        } else {
            $get_users_array['orderby'] = 'post_count';
            $get_users_array['order'] = 'DESC';
            //$td_authors = get_users(array('orderby' => 'post_count', 'order' => 'DESC'));
        }

        if (!empty($roles)) {
            $roles_in = array();
            $roles_buffer = explode(',', $roles);
            foreach ($roles_buffer as $role) {
                //clear the empty space
                $roles_in[] = trim($role);
            }
            //role__in was added in wp 4.4
            $get_users_array['role__in'] = $roles_in;
        }

        $td_authors = get_users($get_users_array);


        $buffy = '';
        $buffy .= '<div class="' . $this->get_block_classes(array('td_top_authors')) . '" ' . $this->get_block_html_atts() . '>';
        $buffy .= $this->get_block_title();


        if (!empty($td_authors)) {
            foreach ($td_authors as $td_author) {
                //echo td_global::$current_author_obj->ID;
                //echo $td_author->ID;
                //print_r($td_author);

                $current_author_class = '';
                if (!empty(td_global::$current_author_obj->ID) and td_global::$current_author_obj->ID == $td_author->ID) {
                    $current_author_class = ' td-active';
                }
                $buffy .= '<div class="td_mod_wrap td-pb-padding-side' . $current_author_class . '">';
                $buffy .= '<a href="' . get_author_posts_url($td_author->ID) . '">' . get_avatar($td_author->user_email, '70') . '</a>';
                $buffy .= '<div class="item-details">';

                $buffy .= '<div class="td-authors-name">';
                $buffy .= '<a href="' . get_author_posts_url($td_author->ID) . '">' . $td_author->display_name . '</a>';
                $buffy .= '</div>';


                $buffy .= '<span class="td-author-post-count">';
                $buffy .= count_user_posts($td_author->ID). ' '  . __td('POSTS', TD_THEME_NAME);
                $buffy .= '</span>';

                $buffy .= '<span class="td-author-comments-count">';
                $comment_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) AS total FROM $wpdb->comments WHERE comment_approved = 1 AND user_id = %d", $td_author->ID));
                $buffy .= $comment_count . ' '  . __td('COMMENTS', TD_THEME_NAME);
                $buffy .= '</span>';

                $buffy .= '<div class="td-authors-url">';
                $buffy .= '<a href="' . $td_author->user_url . '">' . $td_author->user_url .'</a>';
                $buffy .= '</div>';

                $buffy .= '</div>';

                $buffy .= '</div>';
            }
        }



        $buffy .= '</div>';


        return $buffy;

    }
}