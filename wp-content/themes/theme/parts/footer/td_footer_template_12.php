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
            <div class="td-pb-span12">
                <?php
                    td_util::vc_set_column_number(3);

                    dynamic_sidebar('Footer 1');
                ?>
            </div>
        </div>
    </div>
</div>