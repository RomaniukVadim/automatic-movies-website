<!-- Social Networks -->
<?php echo td_panel_generator::box_start('Social Networks', true); ?>




<?php
foreach(td_social_icons::$td_social_icons_array as $panel_social_id => $panel_social_name) {
    ?>
    <div class="td-box-row">
    <div class="td-box-description">
        <span class="td-box-title"><?php echo strtoupper($panel_social_name);?></span>
        <p>Link to : <?php echo $panel_social_name;?></p>
    </div>
    <div class="td-box-control-full">
        <?php
        echo td_panel_generator::input(array(
            'ds' => 'td_social_networks',
            'option_id' => $panel_social_id
        ));
        ?>
    </div>
    </div><?php
}
?>

<?php echo td_panel_generator::box_end();?>