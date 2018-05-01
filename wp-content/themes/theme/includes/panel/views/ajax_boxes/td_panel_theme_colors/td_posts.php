<!-- Article title -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">POST TITLE COLOR</span>
        <p>Select post title color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_post_title_color',
            'default_color' => '#111111'
        ));
        ?>
    </div>
</div>

<!-- Author name -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">POST & BLOCK AUTHOR NAME COLOR</span>
        <p>Select author name color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_post_author_name_color',
            'default_color' => '#000000'
        ));
        ?>
    </div>
</div>

<!-- Post content color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">POST TEXT COLOR</span>
        <p>Select post content color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_post_content_color',
            'default_color' => '#444444'
        ));
        ?>
    </div>
</div>

<!-- Post h color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">POST H1, H2, H3, H4, H5, H6 COLOR</span>
        <p>Select in post h color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_post_h_color',
            'default_color' => '#222222'
        ));
        ?>
    </div>
</div>

<!-- Post blockquote color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">POST BLOCKQUOTE COLOR</span>
        <p>Select in post blockquote color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_post_blockquote_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>