<!-- Background color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">MENU BAR - BACKGROUND COLOR</span>
        <p>Select menu background color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_menu_color',
            'default_color' => '#222222'
        ));
        ?>
    </div>
</div>

<!-- Icons color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">MENU BAR - ICONS COLOR</span>
        <p>Select the icons color for the menu</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_icons_color',
            'default_color' => '#ffffff'
        ));
        ?>
    </div>
</div>

<!-- Menu gradient color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">BACKGROUND GRADIENT COLOR</span>
        <p>Select menu/search panel background gradient</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_gradient_one_mob',
            'default_color' => '#333145'
        ));
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_gradient_two_mob',
            'default_color' => '#b8333e'
        ));
        ?>
    </div>
</div>

<!-- Menu text color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">TEXT/ICONS COLOR</span>
        <p>Select a text/icons color for the opened menu/search</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_text_color',
            'default_color' => '#ffffff'
        ));
        ?>
    </div>
</div>

<!-- Open menu text active and hover color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">ACTIVE/HOVER TEXT COLOR</span>
        <p>Select a text active/hover color for the opened menu</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_text_active_color',
            'default_color' => '#73C7E3'
        ));
        ?>
    </div>
</div>

<!-- Buttons color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">BUTTONS BACKGROUND/TEXT COLOR</span>
        <p>Select background and text color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_button_background_mob',
            'default_color' => '#ffffff'
        ));
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_mobile_button_color_mob',
            'default_color' => '#000000'
        ));
        ?>
    </div>
</div>