<?php
$options = get_option('find_duplicates_data');
?>
<link rel="stylesheet" type="text/css" href="<?= plugins_url('/', __FILE__) ?>../css/styles.css"/>
<div class="wrap metabox-holder"><h2>Find duplicates</h2>
    <?php include(plugin_dir_path(__FILE__) . 'donation.php') ?>

    <div id="logtabs" class="container">
        <h3>Log:</h3>

        <div id="log"></div>
    </div>
    <div class="postbox" id="options">
        <h3 class="hndle"><?php echo __('Search settings', 'find-duplicates') ?></h3>

        <div class="inside">
            <form method="POST">
                <ul id="settings">
                    <li><?php echo __('Get all posts with an <strong>content-similarity</strong> of more than:', 'find-duplicates') ?>
                        <strong><span id="similarity_amount"><?php echo $options['search']['similarity'] ?></span>%</strong>
                        <div id="similarity"></div>
                    </li>
                    <input type="hidden" value="<?php echo $options['search']['similarity'] ?>" name="similarity">
                    <li id="types"><label
                            for="types"><?php echo __('Compare this <strong>type</strong>:', 'find-duplicates') ?></label><br/>
                        <?php
                        $post_types = get_post_types(array(), 'objects');
                        foreach ($post_types as $post_type) {
                            echo '<input type="radio" value="' . $post_type->name . '" name="types"';
                            if ($post_type->name == $options['search']['types'])
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
                            echo '<input name="status[]" type="checkbox" value="' . $key . '"';
                            if(!is_array($options['search']['statuses'])) {
                                $options['search']['statuses'] = array();
                            }
                            if (in_array($key, $options['search']['statuses']))
                                echo ' checked';
                            echo '> ' . $value . '<br />';
                        }
                        ?>
                    </li>
                    <li id="dates"><?php echo __('Limit by <strong>post date</strong>:', 'find-duplicates') ?><br/>
                        <?php echo __('from', 'find-duplicates') ?> <input id="datefrom" name="datefrom" class="datepicker" type="text" value="<?php echo $options['search']['datefrom'] ?>" readonly="readonly"> <?php echo __('until', 'find-duplicates') ?>
                        <input
                            id="dateto" name="dateto" class="datepicker" type="text"
                            value="<?php echo $options['search']['dateto'] ?>" readonly="readonly">
                    </li>
                    <li>
                        <?php echo __("Compare", 'find-duplicates') ?> <select name="search_field" id="search_field">
                            <option value="0" <?php echo ($options['search']['field'] == 0) ? ' selected="selected"' : "" ?>>
                                <?php echo __("content (post_content)", 'find-duplicates') ?>
                            </option>
                            <option value="1" <?php echo ($options['search']['field'] == 1) ? ' selected="selected"' : "" ?>>
                                <?php echo __("title (post_title)", 'find-duplicates') ?>
                            </option>
                            <option value="2" <?php echo ($options['search']['field'] == 2) ? ' selected="selected"' : "" ?>>
                                <?php echo __("content and title", 'find-duplicates') ?>
                            </option>
                        </select><br/>
                        <input name="filterhtml" id="filterhtml" type="checkbox" value="1"<?php echo ($options['search']['filterhtml'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Filter out HTML-Tags while comparing", 'find-duplicates') ?>
                        <br/>
                        <input name="filterhtmlentities" id="filterhtmlentities" type="checkbox" value="1"<?php echo ($options['search']['filterhtmlentities'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Decode HTML-Entities before comparing", 'find-duplicates') ?>
                        <br/>
                        <?php echo __("How much comparisons per Server-Request?", 'find-duplicates') ?> <input name="comparelimit" id="comparelimit" type="text" value="<?php echo $options['search']['comparelimit'] ?>">
                    </li>
                    <li>
                        <?php echo __("Ignore these words while comparing", 'find-duplicates') ?> <input
                            name="filterwords" id="filterwords" type="text"
                            value="<?php echo $options['search']['filterwords'] ?>">
                    </li>
                </ul>


                <div id='ajax-loader' style="display:none"><img
                        src="<?php echo plugins_url('/', __FILE__) ?>../img/ajax-loader.gif"/> <?php echo __('loading', 'find-duplicates') ?>
                </div>
                <input id="startbutton" class="button button-highlighted" type="button"
                       value="<?php echo __('Start new search', 'find-duplicates') ?>">
                <input class="button" type="button" value="<?php echo __('cancel', 'find-duplicates') ?>" id="cancel"
                       style="display:none">

                <input id="continuebutton" <?php
                if (count($options['search']['done']) > 0) {
                    echo 'display: none';
                }
                ?> class="button" type="button" value="<?php echo __('Continue old search', 'find-duplicates') ?>">

                <div class="clear"></div>
            </form>


            <div class="clear"></div>

            <br/>
            <?php
            printf(__('Compared %2$s of %3$s posts<br />Found %1$s duplicates', 'find-duplicates'), '<span id="found">0</span>', '<span id="done">0</span>', '<span id="count">0</span>');
            ?>
            <br/><input id="deletebutton" style="<?php if (count($options['search']['found']) == 0) {
                echo 'display: none';
            } ?>" class="button" type="button"
                        value="<?php echo __('Move selected posts to', 'find-duplicates') ?> <?php echo __($options['settings']['target'], 'find-duplicates') ?>">
        </div>
    </div>
    <table id="results" class="widefat">
        <thead>
        <tr>
            <th class="column-title"><?php echo __('similarity', 'find-duplicates') ?></th>
            <th><input type="checkbox" id="delete-all-new" value="0"> <?php echo __('newer post', 'find-duplicates') ?>
            </th>
            <th><input type="checkbox" id="delete-all-old" value="0"> <?php echo __('older post', 'find-duplicates') ?>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($options['search']['found'] as $element) {
            echo '<tr class="resultrow" id="' . $element[0] . '" olderid="' . $element[1] . '">' .
                '<td>' . $element[2] . '%</td>' .
                '<td><input type="checkbox" class="delete-new-checkbox" postid="' . $element[0] . '" value="1"> <a href="' . get_admin_url() . 'post.php?post=' . $element[0] . '&action=edit">' . get_the_title($element[0]) . ' (ID: ' . $element[0] . ')</a></td>' .
                '<td><input type="checkbox" class="delete-old-checkbox" postid="' . $element[1] . '" value="1"> <a href="' . get_admin_url() . 'post.php?post=' . $element[1] . '&action=edit">' . get_the_title($element[1]) . ' (ID: ' . $element[1] . ')</a></td>' .
                '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    jQuery(function () {
        jQuery('#delete-all-new').on('click', function () {
            jQuery("#results").find('.delete-new-checkbox:checkbox').prop('checked', this.checked);
        });
        jQuery('#delete-all-old').on('click', function () {
            jQuery("#results").find('.delete-old-checkbox:checkbox').prop('checked', this.checked);
        });
    });
</script>