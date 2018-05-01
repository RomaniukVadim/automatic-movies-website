<div class="td-footer-wrapper">
    <div class="td-container">

	    <div class="td-pb-row">
		    <div class="td-pb-span12">
			    <?php
			    // ad spot
			    echo td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'footer_top'));
			    ?>
		    </div>
	    </div>

        <div class="td-pb-row">

            <div class="td-pb-span8">
                <?php
                    td_util::vc_set_column_number(2);

                    dynamic_sidebar('Footer 1');
                ?>
            </div>

            <div class="td-pb-span4">
                <?php
                    td_util::vc_set_column_number(1);

                    dynamic_sidebar('Footer 2');
                ?>
            </div>
        </div>
    </div>

    <div class="td-footer-bottom-full">
        <div class="td-container">
            <div class="td-pb-row">
                <?php locate_template('parts/footer/td_footer_extra_bottom.php', true); ?>
            </div>
        </div>
    </div>
</div>