<?php
/*  ----------------------------------------------------------------------------
    the tag template
 */

get_header();

$current_tag_name = single_tag_title( '', false );
?>

<div class="td-main-content-wrap">
    <div class="td-container">
        <div class="td-crumb-container">
            <?php echo td_page_generator_mob::get_tag_breadcrumbs($current_tag_name);?>
        </div>
        <div class="td-main-content">
            <div class="td-page-header">
                <h1 class="entry-title td-page-title">
                    <span><?php echo $current_tag_name ?></span>
                </h1>
            </div>

            <?php
            $td_tag_description = tag_description();
            if (!empty($td_tag_description)) {
                echo '<div class="entry-content">';
                echo $td_tag_description;
                echo '</div>';
            }
            locate_template('loop.php', true);

            echo td_page_generator_mob::get_pagination();
            ?>
        </div>
    </div>
</div>

<?php
get_footer();