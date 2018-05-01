<?php
$options = get_option('find_duplicates_data');
?>
<link rel="stylesheet" type="text/css" href="<?= plugins_url('/', __FILE__) ?>../css/styles.css"/>
<div class="wrap"><h2>Find duplicates - <?php echo __('Settings', 'find-duplicates') ?></h2>
    <?php include(plugin_dir_path(__FILE__) . 'donation.php') ?>
    <form method="POST">
        <div class="postbox">
            <h3 class="hndle"><?php echo __('Common Settings','find-duplicates') ?></h3>
            <div class="inside">
                <?php echo __('Default target for duplicates','find-duplicates') ?>: <select name="settings_target" id="settings_target">
                    <option value="trash"<?php echo ($options['settings']['target'] == 'trash') ? ' selected="selected"' : "" ?>><?php echo __('Trash','find-duplicates') ?></option>
                    <option value="pending"<?php echo ($options['settings']['target'] == 'pending') ? ' selected="selected"' : "" ?>><?php echo __('Pending','find-duplicates') ?></option>
                    <option value="draft"<?php echo ($options['settings']['target'] == 'draft') ? ' selected="selected"' : "" ?>><?php echo __('Draft','find-duplicates') ?></option>
                </select>
            </div>
        </div>

        <div class="container" id="options" class="form-wrap">
            <h3><?php echo __('Automatic duplicate handling', 'find-duplicates') ?></h3>
            <ul id="settings">

                <li>
                    <input name="auto_active" id="auto_active" type="checkbox" value="1"<?php echo ($options['auto']['active'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __('Activate automatic post handling', 'find-duplicates') ?>
                    <p><?php echo __('Set all posts matching the following criteria as "pending" directly after publishing it.', 'find-duplicates') ?></p>
                </li>

                <li><?php echo __('Delete all posts with an <strong>content-similarity</strong> of more than:', 'find-duplicates') ?>
                    <strong><span id="auto_similarity_amount"><?php echo $options['auto']['similarity'] ?></span>%</strong>
                    <div id="auto_similarity"></div>
                    <input type="hidden" value="<?php echo $options['auto']['similarity'] ?>" name="auto_similarity">
                </li>

                <li id="types"><label for="types"><?php echo __('Activate for these <strong>types</strong>:', 'find-duplicates') ?></label><br/>
                    <?php
                    $post_types = get_post_types(array(), 'objects');
                    foreach ($post_types as $post_type) {
                        echo '<input type="checkbox" value="' . $post_type->name . '" name="auto_types[]"';
                        if (in_array($post_type->name, $options['auto']['types']))
                            echo " checked";
                        echo '> ' . $post_type->label . '<br /> ';
                    }
                    ?>
                </li>

                <li id="statuses"><?php echo __('Include these <strong>statuses</strong>:', 'find-duplicates') ?>
                    <br/>
                    <?php
                    $statuses = get_post_statuses();
                    foreach ($statuses as $key => $value) {
                        echo '<input name="auto_status[]" type="checkbox" value="' . $key . '"';
                        if (in_array($key, $options['auto']['statuses']))
                            echo ' checked';
                        echo '> ' . $value . '<br />';
                    }
                    ?>
                </li>

                <li id="dates"><?php echo __('Limit by <strong>post date</strong>:', 'find-duplicates') ?><br/>
                    <?php echo __('from', 'find-duplicates') ?> <input id="auto_datefrom" name="auto_datefrom"
                                                                       class="datepicker" type="text"
                                                                       value="<?php echo $options['auto']['datefrom'] ?>"
                                                                       readonly="readonly"> <?php echo __('until', 'find-duplicates') ?>
                    <input
                        id="auto_dateto" name="auto_dateto" class="datepicker" type="text"
                        value="<?php echo $options['auto']['dateto'] ?>" readonly="readonly">
                    <br />
                    <?php echo __('or the last', 'find-duplicates') ?> <input size="5" type="text" id="auto_days" name="auto_days" value="<?php echo $options['auto']['days'] ?>"> <?php echo __('days', 'find-duplicates') ?>
                </li>

                <li>
                    <?php echo __("Compare", 'find-duplicates') ?> <select name="auto_field" id="auto_field">
                        <option value="0" <?php echo ($options['auto']['field'] == 0) ? ' selected="selected"' : "" ?>>
                            <?php echo __("content (post_content)", 'find-duplicates') ?>
                        </option>
                        <option value="1" <?php echo ($options['auto']['field'] == 1) ? ' selected="selected"' : "" ?>>
                            <?php echo __("title (post_title)", 'find-duplicates') ?>
                        </option>
                        <option value="2" <?php echo ($options['auto']['field'] == 2) ? ' selected="selected"' : "" ?>>
                            <?php echo __("content and title", 'find-duplicates') ?>
                        </option>
                    </select><br/>
                    <input name="auto_filterhtml" id="auto_filterhtml" type="checkbox"
                           value="1"<?php echo ($options['auto']['filterhtml'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Filter out HTML-Tags while comparing", 'find-duplicates') ?>
                    <br /><input name="auto_filterhtmlentities" id="auto_filterhtmlentities" type="checkbox"
                           value="1"<?php echo ($options['auto']['filterhtmlentities'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Decode HTML-Entities before comparing", 'find-duplicates') ?>
                </li>

                <li>
                    <?php echo __("Ignore these words while comparing", 'find-duplicates') ?> <input
                        name="auto_filterwords" id="auto_filterwords" type="text"
                        value="<?php echo $options['auto']['filterwords'] ?>">
                </li>

                <li>
                    <div style="height:100px;overflow: scroll;">
                        LOG:<br/>
                        <?php
                        $log = get_option('find_duplicates_auto_log', "");
                        echo $log;
                        ?>
                    </div>
                </li>

            </ul>
        </div>

        <div class="container" id="options" class="form-wrap">
            <h3><?php echo __('Manual duplicate handling', 'find-duplicates') ?></h3>
            <ul id="settings">
                <li>
                    <input name="meta_active" id="meta_active" type="checkbox"
                           value="1"<?php echo ($options['meta']['active'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __('Activate manual post handling', 'find-duplicates') ?>
                    <p><?php echo __('Allows you to check for similar entries before publishing an post.', 'find-duplicates') ?></p>
                </li>

                <li><?php echo __('Include all posts with an <strong>content-similarity</strong> of more than:', 'find-duplicates') ?>
                    <strong><span id="meta_similarity_amount"><?php echo $options['meta']['similarity'] ?></span>%</strong>

                    <div id="meta_similarity"></div>
                    <input type="hidden" value="<?php echo $options['meta']['similarity'] ?>" name="meta_similarity">
                </li>

                <li id="types"><label for="types"><?php echo __('Activate for these <strong>types</strong>:', 'find-duplicates') ?></label><br/>
                    <?php
                    $post_types = get_post_types(array(), 'objects');
                    foreach ($post_types as $post_type) {
                        echo '<input type="checkbox" value="' . $post_type->name . '" name="meta_types[]"';
                        if (in_array($post_type->name, $options['meta']['types']))
                            echo " checked";
                        echo '> ' . $post_type->label . '<br /> ';
                    }
                    ?>
                </li>

                <li id="statuses"><?php echo __('Include these <strong>statuses</strong>:', 'find-duplicates') ?>
                    <br/>
                    <?php
                    $statuses = get_post_statuses();
                    foreach ($statuses as $key => $value) {
                        echo '<input name="meta_status[]" type="checkbox" value="' . $key . '"';
                        if (in_array($key, $options['meta']['statuses']))
                            echo ' checked';
                        echo '> ' . $value . '<br />';
                    }
                    ?>
                </li>

                <li id="dates"><?php echo __('Limit by <strong>post date</strong>:', 'find-duplicates') ?><br/>
                    <?php echo __('from', 'find-duplicates') ?> <input id="meta_datefrom" name="meta_datefrom"
                                                                       class="datepicker" type="text"
                                                                       value="<?php echo $options['meta']['datefrom'] ?>"
                                                                       readonly="readonly"> <?php echo __('until', 'find-duplicates') ?>
                    <input
                        id="meta_dateto" name="meta_dateto" class="datepicker" type="text"
                        value="<?php echo $options['meta']['dateto'] ?>" readonly="readonly">
                    <br />
                    <?php echo __('or the last', 'find-duplicates') ?> <input type="text" size="5" id="meta_days" name="meta_days" value="<?php echo $options['meta']['days'] ?>"> <?php echo __('days', 'find-duplicates') ?>
                </li>

                <li>
                    <?php echo __("Compare", 'find-duplicates') ?> <select name="meta_field" id="meta_field">
                        <option value="0" <?php echo ($options['meta']['field'] == 0) ? ' selected="selected"' : "" ?>>
                            <?php echo __("content (post_content)", 'find-duplicates') ?>
                        </option>
                        <option value="1" <?php echo ($options['meta']['field'] == 1) ? ' selected="selected"' : "" ?>>
                            <?php echo __("title (post_title)", 'find-duplicates') ?>
                        </option>
                        <option value="2" <?php echo ($options['meta']['field'] == 2) ? ' selected="selected"' : "" ?>>
                            <?php echo __("content and title", 'find-duplicates') ?>
                        </option>
                    </select><br/>
                    <input name="meta_filterhtml" id="meta_filterhtml" type="checkbox"
                           value="1"<?php echo ($options['meta']['filterhtml'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Filter out HTML-Tags while comparing", 'find-duplicates') ?><br />
                    <input name="filterhtmlentities" id="meta_filterhtmlentities" type="checkbox"
                           value="1"<?php echo ($options['meta']['filterhtmlentities'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Decode HTML-Entities before comparing", 'find-duplicates') ?>
                    <br/>
                    <?php echo __("How much comparisons per Server-Request?", 'find-duplicates') ?> <input
                        name="meta_comparelimit" id="meta_comparelimit" type="text"
                        value="<?php echo $options['meta']['comparelimit'] ?>">
                </li>

                <li>
                    <?php echo __("Ignore these words while comparing", 'find-duplicates') ?> <input
                        name="meta_filterwords" id="meta_filterwords" type="text"
                        value="<?php echo $options['meta']['filterwords'] ?>">
                </li>

            </ul>
        </div>

        <div class="clear"></div>
        <input id="save" title="for searching while editing posts" class="button button-highlighted" type="submit" name="save" value="<?php echo __('Save settings', 'find-duplicates') ?>">
    </form>
</div>

<script>
    jQuery(document).ready(function () {
        jQuery("#auto_similarity").slider({
            min: 50,
            max: 100,
            value: jQuery("input[name='auto_similarity']").val(),
            change: function (event, ui) {
                jQuery("#auto_similarity_amount").html(ui.value);
                jQuery("input[name='auto_similarity']").val(ui.value);
            }
        });
        jQuery("#meta_similarity").slider({
            min: 50,
            max: 100,
            value: jQuery("input[name='meta_similarity']").val(),
            change: function (event, ui) {
                jQuery("#meta_similarity_amount").html(ui.value);
                jQuery("input[name='meta_similarity']").val(ui.value);
            }
        });
        jQuery("#auto_similarity_amount").html(jQuery("#auto_similarity").slider("value"));
        jQuery("#meta_similarity_amount").html(jQuery("#meta_similarity").slider("value"));

            var dates = jQuery("#auto_datefrom, #auto_dateto").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                dateFormat: "yy-mm-dd",
                clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
                showOn: "button",
                buttonImage: "images/date-button.gif",
                buttonImageOnly: true,
                showButtonPanel: true,
                beforeShow: function (input) {
                    setTimeout(function () {
                        var buttonPane = jQuery(input)
                            .datepicker("widget")
                            .find(".ui-datepicker-buttonpane");

                        var btn = jQuery('<button class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" type="button">Clear</button>');
                        btn
                            .unbind("click")
                            .bind("click", function () {
                                jQuery.datepicker._clearDate(input);
                                jQuery(input).val("");
                            });

                        btn.appendTo(buttonPane);

                    }, 1);
                },
                //numberOfMonths: 1,
                onSelect: function (selectedDate) {
                    var option = this.id == "auto_datefrom" ? "minDate" : "maxDate",
                        instance = jQuery(this).data("datepicker"),
                        date = jQuery.datepicker.parseDate(
                            instance.settings.dateFormat ||
                                jQuery.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings);
                    dates.not(this).datepicker("option", option, date);
                }
            });


            var dates = jQuery("#meta_datefrom, #meta_dateto").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                dateFormat: "yy-mm-dd",
                clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
                showOn: "button",
                buttonImage: "images/date-button.gif",
                buttonImageOnly: true,
                showButtonPanel: true,
                beforeShow: function (input) {
                    setTimeout(function () {
                        var buttonPane = jQuery(input)
                            .datepicker("widget")
                            .find(".ui-datepicker-buttonpane");

                        var btn = jQuery('<button class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" type="button">Clear</button>');
                        btn
                            .unbind("click")
                            .bind("click", function () {
                                jQuery.datepicker._clearDate(input);
                                jQuery(input).val("");
                            });

                        btn.appendTo(buttonPane);

                    }, 1);
                },
                //numberOfMonths: 1,
                onSelect: function (selectedDate) {
                    var option = this.id == "meta_datefrom" ? "minDate" : "maxDate",
                        instance = jQuery(this).data("datepicker"),
                        date = jQuery.datepicker.parseDate(
                            instance.settings.dateFormat ||
                                jQuery.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings);
                    dates.not(this).datepicker("option", option, date);
                }
            });
    });
</script>