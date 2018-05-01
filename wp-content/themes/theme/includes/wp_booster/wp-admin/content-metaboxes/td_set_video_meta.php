<?php
$td_last_td_video = '';
?>
<p class="td_help_section">
    <?php $mb->the_field('td_video'); ?>
    <input style="width: 100%;" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
    <?php
    echo td_global::$td_wp_admin_text_list['text_featured_video'];
    $td_last_td_video = $mb->get_the_value();
    ?>
</p>


<?php $mb->the_field('td_last_video'); ?>
<input type="hidden" name="<?php $mb->the_name(); ?>" value="<?php echo $td_last_td_video ?>">


