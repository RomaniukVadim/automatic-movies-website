<?php
/*  ----------------------------------------------------------------------------
    the author template
 */

get_header();

//set the template id, used to get the template specific settings
$template_id = 'author';

//prepare the loop variables
global $loop_module_id, $loop_sidebar_position, $part_cur_auth_obj;
$loop_module_id = td_util::get_option('tds_' . $template_id . '_page_layout', 1); //module 1 is default
$loop_sidebar_position = td_util::get_option('tds_' . $template_id . '_sidebar_pos'); //sidebar right is default (empty)

// sidebar position used to align the breadcrumb on sidebar left + sidebar first on mobile issue
$td_sidebar_position = '';
if($loop_sidebar_position == 'sidebar_left') {
	$td_sidebar_position = 'td-sidebar-left';
}
//read the current author object - used by here in title and by /parts/author-header.php
$part_cur_auth_obj = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));


//set the global current author object, used by widgets (author widget)
td_global::$current_author_obj = $part_cur_auth_obj;

?>

<div class="td-main-content-wrap">
    <div class="td-container <?php echo $td_sidebar_position; ?>">
        <div class="td-crumb-container">
            <?php echo td_page_generator::get_author_breadcrumbs($part_cur_auth_obj); // generate the breadcrumbs ?>
        </div>
        <div class="td-pb-row">
            <?php
            switch ($loop_sidebar_position) {

                /*  ----------------------------------------------------------------------------
                    This is the default option
                    If you set the author template with the right sidebar the theme will use this part
                */
                default:
                    ?>
                        <div class="td-pb-span8 td-main-content">
                            <div class="td-ss-main-content">
                                <div class="td-page-header">
                                    <h1 class="entry-title td-page-title">
                                        <span><?php echo $part_cur_auth_obj->display_name; ?></span>
                                    </h1>
                                </div>

                                <?php
                                //load the author box located in - parts/page-author-box.php - can be overwritten by the child theme
                                locate_template('parts/page-author-box.php', true);
                                ?>

                                <?php locate_template('loop.php', true);?>

                                <?php echo td_page_generator::get_pagination(); // the pagination?>
                            </div>
                        </div>
                        <div class="td-pb-span4 td-main-sidebar">
                            <div class="td-ss-main-sidebar">
                                <?php get_sidebar(); ?>
                            </div>
                        </div>
                    <?php
                    break;



                /*  ----------------------------------------------------------------------------
                    If you set the author template with sidebar left the theme will render this part
                */
                case 'sidebar_left':
                    ?>
                        <div class="td-pb-span8 td-main-content <?php echo $td_sidebar_position; ?>-content">
                            <div class="td-ss-main-content">
                                <div class="td-page-header">
                                    <h1 class="entry-title td-page-title">
                                        <span><?php echo $part_cur_auth_obj->display_name; ?></span>
                                    </h1>
                                </div>

                                <?php
                                //load the author box located in - parts/page-author-box.php - can be overwritten by the child theme
                                locate_template('parts/page-author-box.php', true);
                                ?>

                                <?php locate_template('loop.php', true);?>

                                <?php echo td_page_generator::get_pagination(); // the pagination?>
                            </div>
                        </div>
		                <div class="td-pb-span4 td-main-sidebar">
			                <div class="td-ss-main-sidebar">
				                <?php get_sidebar(); ?>
			                </div>
		                </div>
                    <?php
                    break;



                /*  ----------------------------------------------------------------------------
                    If you set the author template with no sidebar the theme will use this part
                */
                case 'no_sidebar':
                    ?>
                        <div class="td-pb-span12 td-main-content">
                            <div class="td-ss-main-content">
                                <div class="td-page-header">
                                    <h1 class="entry-title td-page-title">
                                        <span><?php echo $part_cur_auth_obj->display_name; ?></span>
                                    </h1>
                                </div>

                                <?php
                                //load the author box located in - parts/page-author-box.php - can be overwritten by the child theme
                                locate_template('parts/page-author-box.php', true);
                                ?>

                                <?php locate_template('loop.php', true);?>

                                <?php echo td_page_generator::get_pagination(); // the pagination?>
                            </div>
                        </div>
                    <?php
                    break;
            }
            ?>
        </div> <!-- /.td-pb-row -->
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();
?>