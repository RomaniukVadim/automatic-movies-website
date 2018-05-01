<?php
get_header();

?>
	<div class="td-main-content-wrap td-main-page-wrap">
		<div class="td-container">
            <div class="td-main-content">
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
		</div> <!-- /.td-container -->
	</div>
<?php

get_footer();
?>