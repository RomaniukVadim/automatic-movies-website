
<!-- Menu background color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">MENU BACKGROUND COLOR</span>
        <p>Select menu background color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_menu_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>

<!-- Submenu Hover color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">ACTIVE & HOVER COLOR</span>
        <p>Select the active and hover color for menu and submenu</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_submenu_hover_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>

<!-- Menu text color -->
<div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title">MENU TEXT COLOR</span>
        <p>Select menu text color</p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::color_picker(array(
            'ds' => 'td_option',
            'option_id' => 'tds_menu_text_color',
            'default_color' => ''
        ));
        ?>
    </div>
</div>