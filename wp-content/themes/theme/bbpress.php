<?php
//for sidebar
td_global::$current_template = 'bbpress';


get_header();

//set the template id, used to get the template specific settings
$template_id = 'bbpress';


$loop_sidebar_position = td_util::get_option('tds_' . $template_id . '_sidebar_pos'); //sidebar right is default (empty)


//read the custom single post settings - this setting overids all of them
$td_page = get_post_meta($post->ID, 'td_page', true);
if (!empty($td_page['td_sidebar_position'])) {
	$loop_sidebar_position = $td_page['td_sidebar_position'];
}

// sidebar position used to align the breadcrumb on sidebar left + sidebar first on mobile issue
$td_sidebar_position = '';
if($loop_sidebar_position == 'sidebar_left') {
	$td_sidebar_position = 'td-sidebar-left';
}
?>

	<div class="td-main-content-wrap td-main-page-wrap">
		<div class="td-container">
			<div class="td-pb-row">
				<?php
				switch ($loop_sidebar_position) {
					default:
						?>
						<div class="td-pb-span8 td-main-content">
							<div class="td-ss-main-content">
								<?php
								if (have_posts()) {
									while ( have_posts() ) : the_post();
										?>
										<h1 class="entry-title td-page-title">
											<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
										</h1>
										<?php
										the_content();
									endwhile; //end loop
								}
								?>
							</div>
						</div>
						<div class="td-pb-span4 td-main-sidebar">
							<div class="td-ss-main-sidebar">
								<?php get_sidebar(); ?>
							</div>
						</div>
						<?php
						break;

					case 'sidebar_left':
						?>
						<div class="td-pb-span8 td-main-content  <?php echo $td_sidebar_position; ?>-content">
							<div class="td-ss-main-content">
								<?php

								if (have_posts()) {
									while ( have_posts() ) : the_post();
										?>
										<h1 class="entry-title td-page-title">
											<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
										</h1>
										<?php
										the_content();
									endwhile; //end loop
								}
								?>
							</div>
						</div>
						<div class="td-pb-span4 td-main-sidebar">
							<div class="td-ss-main-sidebar">
								<?php get_sidebar(); ?>
							</div>
						</div>
						<?php
						break;

					case 'no_sidebar':
						?>
						<div class="td-pb-span12 td-main-content">
							<div class="td-ss-main-content">
								<?php
								if (have_posts()) {
									while ( have_posts() ) : the_post();
										?>
										<h1 class="entry-title td-page-title">
											<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
										</h1>
										<?php
										the_content();
									endwhile; //end loop
								}
								?>
							</div>
						</div>
						<?php
						break;
				}
				?>
			</div> <!-- /.td-pb-row -->
		</div> <!-- /.td-container -->
	</div>
<?php
get_footer();
?>