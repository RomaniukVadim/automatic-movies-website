<?php


//read the logo + retina logo
$td_customLogo = td_util::get_option('tds_logo_upload');
$td_customLogoR = td_util::get_option('tds_logo_upload_r');

$td_logo_text = td_util::get_option('tds_logo_text');
$td_tagline_text = td_util::get_option('tds_tagline_text');

$td_logo_alt = td_util::get_option('tds_logo_alt');
$td_logo_title = td_util::get_option('tds_logo_title');

if (!empty($td_logo_title)) {
	$td_logo_title = ' title="' . $td_logo_title . '"';
}

// if true make the logo in H1
$td_use_h1_logo = false;
if( is_home() || is_front_page() ) {
	$td_use_h1_logo = true;
}


if (!empty($td_customLogoR)) {
	if($td_use_h1_logo === true) {
		echo '<h1 class="td-logo">';
	};
	?>
		<a class="td-main-logo" href="<?php echo esc_url(home_url( '/' )); ?>">
			<img class="td-retina-data"  data-retina="<?php echo esc_attr($td_customLogoR) ?>" src="<?php echo $td_customLogo?>" alt="<?php echo $td_logo_alt ?>"<?php echo $td_logo_title ?>/>
			<span class="td-visual-hidden"><?php bloginfo('name'); ?></span>
		</a>
	<?php
	if($td_use_h1_logo === true) {
		echo '</h1>';
	};
} else {
	if (!empty($td_customLogo)) {
		if($td_use_h1_logo === true) {
			echo '<h1 class="td-logo">';
		};
		?>
			<a class="td-main-logo" href="<?php echo esc_url(home_url( '/' )); ?>">
				<img src="<?php echo $td_customLogo?>" alt="<?php echo $td_logo_alt ?>"<?php echo $td_logo_title ?>/>
				<span class="td-visual-hidden"><?php bloginfo('name'); ?></span>
			</a>
		<?php
		if($td_use_h1_logo === true) {
			echo '</h1>';
		};
	} else { ?>
    <span class="td-logo-text-container">
		<a class="td-logo-wrap" href="<?php echo esc_url(home_url( '/' )); ?>">
			<?php
			if($td_use_h1_logo === true) {
				echo '<h1 class="td-logo">';
			};
			?>
				<span class="td-logo-text"><?php if(!$td_logo_text) { echo "NEWSPAPER"; } else { echo $td_logo_text; } ?></span>
			<?php
			if($td_use_h1_logo === true) {
				echo '</h1>';
			};
			?>
			<span class="td-tagline-text"><?php if(!$td_tagline_text) { echo "DISCOVER THE ART OF PUBLISHING"; } else { echo $td_tagline_text; } ?></span>
		</a>
    </span>
	<?php
	}
}
?>