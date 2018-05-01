<?php
/** @var $this WPBakeryShortCode_VC_Row */

global $td_row_count, $td_column_count;
$td_row_count ++;


$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $full_width = $el_id = $parallax_image = $parallax = '';
extract( shortcode_atts( array(
    'el_class' => '',
    'bg_image' => '',
    'bg_color' => '',
    'bg_image_repeat' => '',
    'font_color' => '',
    'padding' => '',
    'margin_bottom' => '',
    'full_width' => false,
    'parallax' => false,
    'parallax_image' => false,
    'css' => '',
    'el_id' => '',
), $atts ) );
$parallax_image_id = '';
$parallax_image_src = '';

// wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row ' . ( $this->settings( 'base' ) === 'vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$style = $this->buildStyle( $bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom );
?>
    <div <?php echo isset( $el_id ) && ! empty( $el_id ) ? "id='" . esc_attr( $el_id ) . "'" : ""; ?> <?php
?>class="<?php echo esc_attr( $css_class ); ?><?php if ( $full_width == 'stretch_row_content_no_spaces' ): echo ' vc_row-no-padding'; endif; ?><?php if ( ! empty( $parallax ) ): echo ' vc_general vc_parallax vc_parallax-' . $parallax; endif; ?><?php if ( ! empty( $parallax ) && strpos( $parallax, 'fade' ) ): echo ' js-vc_parallax-o-fade'; endif; ?><?php if ( ! empty( $parallax ) && strpos( $parallax, 'fixed' ) ): echo ' js-vc_parallax-o-fixed'; endif; ?>"<?php if ( ! empty( $full_width ) ) {
    echo ' data-vc-full-width="true" data-vc-full-width-init="false" ';
    if ( $full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces' ) {
        echo ' data-vc-stretch-content="true"';
    }
} ?>
<?php
// parallax bg values

$bgSpeed = 1.5;
?>
<?php
if ( $parallax ) {
    wp_enqueue_script( 'vc_jquery_skrollr_js' );

    echo '
            data-vc-parallax="' . $bgSpeed . '"
        ';
}
if ( strpos( $parallax, 'fade' ) ) {
    echo '
            data-vc-parallax-o-fade="on"
        ';
}
if ( $parallax_image ) {
    $parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
    $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
    if ( ! empty( $parallax_image_src[0] ) ) {
        $parallax_image_src = $parallax_image_src[0];
    }
    echo '
                data-vc-parallax-image="' . $parallax_image_src . '"
            ';
}
?>
<?php echo $style; ?>><?php

echo wpb_js_remove_wpautop( $content );
?></div><?php echo $this->endBlockComment( 'row' );
if ( ! empty( $full_width ) ) {
    echo '<div class="vc_row-full-width"></div>';
}
$td_row_count--;