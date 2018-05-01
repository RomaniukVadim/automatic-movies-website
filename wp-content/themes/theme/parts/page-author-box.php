<?php

/*  ----------------------------------------------------------------------------
    The author box - used only on the author.php template ( ! this is not the same box as the one used in the single post template ! )
 */

global $part_cur_auth_obj;



?>
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

        echo $part_cur_auth_obj->description;

        ?>



        <div class="td-author-social">
            <?php

            foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                //echo get_the_author_meta($td_social_id) . '<br>';
                $authorMeta = get_the_author_meta($td_social_id, $part_cur_auth_obj->ID);
                if (!empty($authorMeta)) {
                    echo td_social_icons::get_icon($authorMeta, $td_social_id, true );
                }
            }
            ?>
        </div>
    </div>

    <div class="clearfix"></div>
</div>