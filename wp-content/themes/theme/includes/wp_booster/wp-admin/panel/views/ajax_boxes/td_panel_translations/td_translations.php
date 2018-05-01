<?php
/**
 * Created by ra on 1/13/2015.
 */

global $td_translation_map;

?>

<!-- HELP THE COMMUNITY -->
    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">HELP THE COMMUNITY</span>
            <p>If you fixed a word or if you have a better translation for a phrase feel free to share it with the community.</p>
            <p>
                <a id="send_translation" class="td-big-button thickbox"
                   href="#TB_inline?width=400&height=300&inlineId=modal_window_send_tranlation_language"
                   onclick="td_translation.select_loaded_language(); return false">Share your translation or correction</a>

                <div id="modal_window_send_tranlation_language" title="test" style="display: none;">

                    <h2>Send your translation or correction</h2>
                    <p>Your translations will be sent to our server and after a review process it will be available to all of the members of the community. Please make sure that you sent it for the correct language.</p>

                        <?php

                        // 'tds_language' is the value of the 'option_id' parameter used for the next td_panel_generator::dropdown
                        // 'tds_language' option is cleared before usage, for not saving a language in the select input
                        td_util::update_option('tds_language', '');

                        $languages[] = array(
                            'text' => 'Translation language...',
                            'val' => ''
                        );

                        foreach (td_global::$translate_languages_list as $language_code => $language_name){
                            $languages[] = array(
                                'text' => $language_name,
                                'val' => $language_code
                            );
                        }

                        echo td_panel_generator::dropdown(array(
                            'ds' => 'td_option',
                            'option_id' => 'tds_language',
                            'values' => $languages
                        ));
                        ?>
                    <p>By clicking the button you authorize us (tagDiv) to share your translation with other users of the theme. Thank you for your trust and contribution and we will do our best to give back.</p>

                    <a id="send_translation" class="td-big-button" href="" onclick="td_translation.send_translation('<?php echo TD_THEME_NAME ?>', '<?php echo TD_THEME_VERSION ?>', '<?php echo td_util::get_option('td_cake_status') ?>'); return false;">Send translation or correction</a>

                    <p id="thanks_send_translation" style="display: none">Thank you!</p>
                </div>
            </p>
        </div>
    </div>





<!-- THE TRANSLATION LIST -->
    <?php

    foreach($td_translation_map as $key_id => $value) {

        // for each word in the $key_id array, not starting with (%) percent (internal variables like %CURRENT_PAGE% ),
        // we need to replace '_' with (') apostrophe
        //
        // we can't use $value instead of $key_id, because $value is a translated value
        //
        $arr_words = explode(' ', $key_id);

        foreach ($arr_words as &$word) {
            if (preg_match('/^%/', $word))
                continue;

            $word = str_replace('_', '\'', $word);
        }

        $key = implode(' ', $arr_words);

        ?>
        <div class="td-box-row">
            <div class="td-box-description">
                <span class="td-box-title td-title-on-row"><?php echo $key;?></span>
                <p></p>
            </div>
            <div class="td-box-control-full">
                <?php
                echo td_panel_generator::input(array(
                    'ds' => 'td_translate',
                    'option_id' => $key_id,
                    'placeholder' => $value
                ));
                ?>
            </div>
        </div>
        <?php
    }
    ?>
