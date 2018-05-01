<?php
/*  ----------------------------------------------------------------------------
    the search template
 */

get_header();

td_global::$custom_no_posts_message = __td('No results for your search', TD_THEME_NAME);

?>
<div class="td-main-content-wrap">
    <div class="td-container">
        <div class="td-crumb-container">
            <?php echo td_page_generator_mob::get_search_breadcrumbs(); ?>
        </div>
        <div class="td-main-content">
            <div class="td-page-header">
                <?php

                /**
                 * @note:
                 * we use esc_url(home_url( '/' )) instead of the WordPress @see get_search_link function because that's what the internal
                 * WordPress widget it's using and it was creating duplicate links like: yoursite.com/search/search_query and yoursite.com?s=search_query
                 */
                ?>

	            <h1 class="entry-title td-page-title">
		            <span class="td-search-query"><?php echo get_search_query(); ?></span> - <span> <?php  echo __td('search results', TD_THEME_NAME);?></span>
	            </h1>

	            <div class="search-page-search-wrap">
		            <form method="get" class="td-search-form-widget" action="<?php echo esc_url(home_url( '/' )); ?>">
			            <div role="search">
				            <input class="td-widget-search-input" type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" /><input class="wpb_button wpb_btn-inverse btn" type="submit" id="searchsubmit" value="<?php _etd('Search', TD_THEME_NAME)?>" />
			            </div>
		            </form>
		            <div class="td_search_subtitle">
			            <?php _etd('If you_re not happy with the results, please do another search', TD_THEME_NAME);?>
		            </div>
	            </div>
            </div>

            <?php locate_template('loop.php', true);?>
            <?php echo td_page_generator_mob::get_pagination(); ?>

        </div>
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();