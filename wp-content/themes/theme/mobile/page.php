<?php
/*  ----------------------------------------------------------------------------
    the default page template
 */

get_header();

//get theme panel variable for page comments side wide
$td_enable_or_disable_page_comments = td_util::get_option('tds_disable_comments_pages');

// the page is rendered using the page builder template (no sidebars)
if (have_posts()) {
	while ( have_posts() ) : the_post(); ?>

		<div class="td-main-content-wrap td-main-page-wrap">
			<div class="td-container">
				<div class="td-crumb-container">
					<?php echo td_page_generator_mob::get_page_breadcrumbs(get_the_title()); ?>
				</div>
				<div class="td-main-content">
					<div class="td-page-header">
						<h1 class="entry-title td-page-title">
							<span><?php the_title() ?></span>
						</h1>
					</div>
					<div class="td-page-content">
						<?php the_content(); ?>
					</div>
					<?php
					if($td_enable_or_disable_page_comments == 'show_comments') {
						comments_template('', true);
					}?>
				</div>
			</div>
		</div> <!-- /.td-main-content-wrap -->
	<?php endwhile;
}
get_footer();
