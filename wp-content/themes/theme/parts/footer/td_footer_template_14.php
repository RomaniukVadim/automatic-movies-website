<div class="td-footer-wrapper td-footer-template-14">
    <div class="td-container td-footer-bottom-full">
        <div class="td-pb-row">
            <?php
            // ad spot
            echo td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'footer_top'));

            locate_template('parts/footer/td_footer_extra_bottom.php', true);
            ?>
        </div>
    </div>
</div>