<?php
/*  ----------------------------------------------------------------------------
    the author template
 */

get_header();

//read the current author object - used by here in title and by /parts/author-header.php
$part_cur_auth_obj = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

//set the global current author object, used by widgets (author widget)
td_global::$current_author_obj = $part_cur_auth_obj;

?>

<div class="td-main-content-wrap">
    <div class="td-container">
        <div class="td-crumb-container">
            <?php echo td_page_generator_mob::get_author_breadcrumbs($part_cur_auth_obj); // generate the breadcrumbs ?>
        </div>
        <div class="td-main-content">
            <div class="td-page-header">
                <h1 class="entry-title td-page-title">
                    <span><?php echo $part_cur_auth_obj->display_name; ?></span>
                </h1>
            </div>

	        <div class="author-box-wrap td-author-page">

		        <?php  echo get_avatar($part_cur_auth_obj->user_email, '96'); ?>

		        <div class="desc">

			        <div class="td-author-counters">
			            <span class="td-author-post-count">
			                <?php echo count_user_posts($part_cur_auth_obj->ID). ' '  . __td('POSTS', TD_THEME_NAME);?>
			            </span>

			            <span class="td-author-comments-count">

			                <?php
			                $comment_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) AS total FROM $wpdb->comments WHERE comment_approved = 1 AND user_id = %d", $part_cur_auth_obj->ID));

			                echo $comment_count . ' '  . __td('COMMENTS', TD_THEME_NAME);
			                ?>

			            </span>
			        </div>

			        <?php
			        if (!empty($part_cur_auth_obj->user_url)) {
				        echo '<div class="td-author-url"><a href="' . esc_url($part_cur_auth_obj->user_url) . '">' . esc_url($part_cur_auth_obj->user_url) . '</a></div>';
			        }
			        ?>

			        <div class="td-author-description">
				        <?php echo $part_cur_auth_obj->description; ?>
			        </div>

			        <div class="td-author-social">

				        <?php
				        foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
					        //echo get_the_author_meta($td_social_id) . '<br>';
					        $authorMeta = get_the_author_meta($td_social_id, $part_cur_auth_obj->ID);
					        if (!empty($authorMeta)) {
						        echo td_social_icons::get_icon($authorMeta, $td_social_id, true);
					        }
				        }
				        ?>

			        </div>
		        </div>

		        <div class="clearfix"></div>
	        </div>

            <?php
            locate_template('loop.php', true);

            echo td_page_generator_mob::get_pagination();
            ?>

        </div>
    </div>
</div>

<?php
get_footer();