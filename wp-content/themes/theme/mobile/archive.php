<?php
/*  ----------------------------------------------------------------------------
    the archive(s) template
 */

get_header();

//read the current author object - used by here in title and by /parts/author-header.php
$part_cur_auth_obj = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

//prepare the archives page title
if (is_day()) {
    $td_archive_title = __td('Daily Archives:', TD_THEME_NAME). ' ' . get_the_date();
} elseif (is_month()) {
    $td_archive_title = __td('Monthly Archives:', TD_THEME_NAME) . ' ' . get_the_date('F Y');
} elseif (is_year()) {
    $td_archive_title = __td('Yearly Archives:', TD_THEME_NAME) . ' ' . get_the_date('Y');
} else {
    $td_archive_title = __td('Archives', TD_THEME_NAME);
}
?>
<div class="td-main-content-wrap">
    <div class="td-container">
        <div class="td-crumb-container">
            <?php echo td_page_generator_mob::get_archive_breadcrumbs(); ?>
        </div>
        <div class="td-main-content">
            <div class="td-page-header">
                <h1 class="entry-title td-page-title">
                    <span><?php echo $td_archive_title; ?></span>
                </h1>
            </div>
            <?php locate_template('loop.php', true); ?>
            <?php echo td_page_generator_mob::get_pagination(); ?>
        </div>
    </div>
</div>

<?php
get_footer();