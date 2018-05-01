<div class="misc-pub-section misc-pub-section-last" style="padding-top: 10px;border-top: 1px solid #DFDFDF;">
<?php
echo'<a class="button" title="' . __('Similarity', 'find-duplicates') . ': ' . $options['meta']['similarity'] . '% | ' . __('Date', 'find-duplicates') . ': ' . $options['meta']['datefrom'] . '-' . $options['meta']['dateto'] . ' | ' . __('Status', 'find-duplicates') . ': ' . implode(",", $options['meta']['statuses']) . '" id="fd-meta-start">Find duplicates</a><!--<input type="checkbox" name="field" id="field" value="1"> ' . __('only compare title', 'find-duplicates')."-->";
    echo '<div id="ajax-loader" style="display:none;margin-top:10px"><img src="' . plugins_url('/',__FILE__) . '../img/ajax-loader.gif" /> ' . __('loading', 'find-duplicates') . '</div>';
    echo '<ul id="fd-meta-results">';
        echo '</ul>
    <script>
        jQuery("#fd-meta-start").click(function(){
            jQuery("#ajax-loader").show();
            find_meta("' . get_post_type($post) . '");
        });
    </script>
    ';
?>
</div>