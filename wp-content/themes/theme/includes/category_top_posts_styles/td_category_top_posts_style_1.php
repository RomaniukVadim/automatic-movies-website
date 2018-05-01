<?php
class td_category_top_posts_style_1 extends td_category_top_posts_style {
    function show_top_posts() {

        parent::render_posts_to_buffer();


        if (parent::get_rendered_post_count() == 0) {
            // echo daca vrei sa arate ceva cand nu sunt posturi
            //echo '<div class="td_line_above_cat_big_grid"> </div>';
            return; // die here
        }
        ?>

        <!-- big grid -->
        <div class="td-category-grid">
            <div class="td-container">
                <div class="td-pb-row">
                    <div class="td-pb-span12">
                        <?php
                        echo parent::get_buffer();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}