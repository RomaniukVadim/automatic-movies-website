<!-- CUSTOM FONTS SECTION -->
<div class="td-section-separator">Custom Fonts</div>

<!-- Custom fonts files -->
<?php echo td_panel_generator::box_start('Documentation on how to use custom fonts', true); ?>

<!-- info text -->
<div class="td-box-row">
	<div class="td-box-description td-box-full">
		<p><?php echo TD_THEME_NAME ?> supports custom fonts files, typekit fonts and google fonts. Please refresh the main panel to see the fonts after you add them here!</p>
		<p><a href="http://forum.tagdiv.com/using-custom-fonts/" target="_blank">Read more</a> about the font system</p>
	</div>
</div>

<?php echo td_panel_generator::box_end();?>

<!-- Custom fonts files -->
<?php echo td_panel_generator::box_start('Custom font files', false); ?>


<!-- info text -->
<div class="td-box-row">
	<div class="td-box-description td-box-full">
		<p>To use custom font files:</p>

		<ul>
			<li>Add the link to the font file in .woff format, and the font-face name  in the Custom Font Files section and click save settings.</li>
			<li>You can convert your font files from any format into .woff format using <a href="http://www.fontsquirrel.com/tools/webfont-generator">fontsquirrel</a> (free tool)</li>
			<li>Once a font file url and a font family name are added, the font family will appear in the dropdown and it can be selected</li>
		</ul>
	</div>
</div>

<!-- Custom Font file 1 -->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FILE 1</span>
		<p>Add the link to the file ( .woff format )</p>
	</div>
	<div class="td-box-control-full td-panel-input-wide">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'font_file_1'
		));
		?>
	</div>
</div>


<!-- Custom Font name 1 -->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FAMILY 1</span>
		<p>Type your desired name for this font</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'font_family_1'
		));
		?>
	</div>
</div>


<div class="td-box-row">
	<div class="td-box-description"></div>
	<div class="td-box-control-full"></div>
</div>



<!-- Custom Font file 2 -->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FILE 2</span>
		<p>Add the link to the file ( .woff format )</p>
	</div>
	<div class="td-box-control-full td-panel-input-wide">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'font_file_2'
		));
		?>
	</div>
</div>


<!-- Custom Font name 2 -->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FAMILY 2</span>
		<p>Type your desired name for this font</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'font_family_2'
		));
		?>
	</div>
</div>


<div class="td-box-row">
	<div class="td-box-description"></div>
	<div class="td-box-control-full"></div>
</div>



<!-- Custom Font file 3 -->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FILE 3</span>
		<p>Add the link to the file ( .woff format )</p>
	</div>
	<div class="td-box-control-full td-panel-input-wide">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'font_file_3'
		));
		?>
	</div>
</div>


<!-- Custom Font name 3 -->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FAMILY 3</span>
		<p>Type your desired name for this font</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'font_family_3'
		));
		?>
	</div>
</div>


<?php echo td_panel_generator::box_end();?>




<!-- typekit.com fonts -->
<?php echo td_panel_generator::box_start('Typekit.com Fonts', false); ?>

<!-- javascript from typekit.com-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">Javascript Code</span>
		<p>Copy the javascript code from typekit.com and paste it here</p>
	</div>
	<div class="td-box-control-full td-panel-input-wide">
		<?php
		echo td_panel_generator::textarea(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'typekit_js',
		));
		?>
	</div>
</div>


<!-- typekit.com Custom Font font family 1-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FAMILY 1</span>
		<p>Type your desired name for this font</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'type_kit_font_family_1'
		));
		?>
	</div>
</div>


<!-- typekit.com Custom Font font family 2-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FAMILY 2</span>
		<p>Type your desired name for this font</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'type_kit_font_family_2'
		));
		?>
	</div>
</div>


<!-- typekit.com Custom Font font family 3-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CUSTOM FONT FAMILY 3</span>
		<p>Type your desired name for this font</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::input(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'type_kit_font_family_3'
		));
		?>
	</div>
</div>

<?php echo td_panel_generator::box_end();?>




<!-- google fonts settings-->
<?php echo td_panel_generator::box_start('Google Fonts Settings', false); ?>


<!-- info text -->
<div class="td-box-row">
	<div class="td-box-description td-box-full">
		<p>You can select from here what character subsets will be loaded for each google font. The character subset will be loaded only if the font supports the specific glyphs. Try to enable only the subsets that you use because the site will load slower with each additional subset.</p>
	</div>
</div>

<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">ARABIC SUPPORT</span>
		<p>Load the font file with support for arabic charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_arabic',
			'true_value' => 'arabic',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">BENGALI SUPPORT</span>
		<p>Load the font file with support for bengali charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_bengali',
			'true_value' => 'bengali',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CYRILLIC SUPPORT</span>
		<p>Load the font file with support for cyrillic charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_cyrillic',
			'true_value' => 'cyrillic',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">CYRILLIC EXTENDED SUPPORT</span>
		<p>Load the font file with support for cyrillic extended charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_cyrillic-ext',
			'true_value' => 'cyrillic-ext',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">DEVANAGARI SUPPORT</span>
		<p>Load the font file with support for devanagari charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_devanagari',
			'true_value' => 'devanagari',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">GREEK SUPPORT</span>
		<p>Load the font file with support for greek charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_greek',
			'true_value' => 'greek',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">GREEK EXTENDED SUPPORT</span>
		<p>Load the font file with support for greek extended charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_greek-ext',
			'true_value' => 'greek-ext',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">GUJARATI SUPPORT</span>
		<p>Load the font file with support for gujarati charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_gujarati',
			'true_value' => 'gujarati',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">HEBREW SUPPORT</span>
		<p>Load the font file with support for hebrew charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_hebrew',
			'true_value' => 'hebrew',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">KHMER SUPPORT</span>
		<p>Load the font file with support for khmer charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_khmer',
			'true_value' => 'khmer',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">LATIN SUPPORT</span>
		<p>Load the font file with support for latin charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_latin',
			'true_value' => 'latin',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">LATIN EXTENDED SUPPORT</span>
		<p>Load the font file with support for latin extended charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_latin-ext',
			'true_value' => 'latin-ext',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">TAMIL SUPPORT</span>
		<p>Load the font file with support for tamil charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_tamil',
			'true_value' => 'tamil',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">TELUGU SUPPORT</span>
		<p>Load the font file with support for telugu charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_telugu',
			'true_value' => 'telugu',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">THAI SUPPORT</span>
		<p>Load the font file with support for thai charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_thai',
			'true_value' => 'thai',
			'false_value' => ''
		));
		?>
	</div>
</div>


<!-- google fonts settings-->
<div class="td-box-row">
	<div class="td-box-description">
		<span class="td-box-title">VIETNAMESE SUPPORT</span>
		<p>Load the font file with support for vietnamese charset if possible</p>
	</div>
	<div class="td-box-control-full">
		<?php
		echo td_panel_generator::checkbox(array(
			'ds' => 'td_fonts_user_insert',
			'option_id' => 'g_vietnamese',
			'true_value' => 'vietnamese',
			'false_value' => ''
		));
		?>
	</div>
</div>


<?php echo td_panel_generator::box_end();?>


<div class="td-clear"></div>
