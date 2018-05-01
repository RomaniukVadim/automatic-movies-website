<?php
/*  ----------------------------------------------------------------------------
    the blog index template
 */

get_header();
?>

<div class="td-main-content-wrap td-blog-index">
	<div class="td-container">
		<div class="td-crumb-container">
			<?php

			// Important! The main theme breadcrumbs settings are used
			echo td_page_generator_mob::get_home_breadcrumbs();

			?>
		</div>
		<div class="td-main-content">
			<?php
			locate_template('loop.php', true);

			echo td_page_generator_mob::get_pagination();

			?>
		</div>
	</div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();