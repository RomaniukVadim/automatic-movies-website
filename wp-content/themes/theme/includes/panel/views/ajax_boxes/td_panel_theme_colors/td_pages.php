
<!-- Page title -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">PAGE TITLE COLOR</span>
        <p>Select page title color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_page_title_color',
            'default_color' => '#111111'
        ));
        ?>
    </div>
</div>

<!-- Page content -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">PAGE TEXT COLOR</span>
        <p>Select page text color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_page_content_color',
            'default_color' => '#444444'
        ));
        ?>
    </div>
</div>

<!-- Page content h -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">PAGE H1, H2, H3, H4, H5, H6 COLOR</span>
        <p>Select page h color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_page_h_color',
            'default_color' => '#111111'
        ));
        ?>
    </div>
</div>