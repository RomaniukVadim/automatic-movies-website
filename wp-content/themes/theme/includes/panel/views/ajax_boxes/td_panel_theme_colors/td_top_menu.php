<!-- BACKGROUND COLOR -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">BACKGROUND COLOR</span>
        <p>Select top menu background color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_top_menu_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>


<!-- TOP MENU TEXT COLOR -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title td-title-on-row">TOP MENU TEXT COLOR</span>
        <p>Select top menu text color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_top_menu_text_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>


<!-- TOP MENU TEXT HOVER COLOR -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title td-title-on-row">TOP MENU TEXT HOVER COLOR</span>
        <p>Select top menu text color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_top_menu_text_hover_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>

<!-- SOCIAL ICONS COLOR -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">SOCIAL ICONS COLOR</span>
        <p>Select social icons color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_top_social_icons_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>

<!-- SOCIAL ICONS HOVER COLOR -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title td-title-on-row">SOCIAL ICONS HOVER COLOR</span>
        <p>Select social icons hover color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_top_social_icons_hover_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>