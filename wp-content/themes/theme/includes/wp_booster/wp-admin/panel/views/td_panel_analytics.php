<!-- Analitycs -->
<?php echo td_panel_generator::box_start('Analitycs'); ?>

    <!-- GOOGLE ASYNCHRONOUS ADS -->
    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">GOOGLE ANALYTICS CODE</span>
            <p>
	            Google analytics helps track your site traffic

            </p>
        </div>
    </div>


    <!-- paste your code here -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">PASTE YOUR CODE HERE</span>
            <p>
	            Google Analytics code
	            <?php td_util::tooltip_html('
                        <h3>Google analytics tracking code:</h3>
                        <p>Paste here the Universal Analytics tracking code for this property. The code will be added to the body tag on all the sites pages</p>
                ', 'right')?>
            </p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::textarea(array(
                'ds' => 'td_option',
                'option_id' => 'td_analytics',
            ));
            ?>
        </div>
    </div>

<?php echo td_panel_generator::box_end();?>