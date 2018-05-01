<div class="td-page-options-tab-wrap">
    <div class="td-page-options-tab td-page-options-tab-active" data-panel-class="td-page-option-general"><a href="#">General</a></div>
    <div class="td-page-options-tab" data-panel-class="td-page-option-unique-articles-2"><a href="#">Unique articles</a></div>
</div>
<div class="td-meta-box-inside">



    <!-- page option general -->
    <div class="td-page-option-panel td-page-option-panel-active td-page-option-general">
        <p><strong>Note:</strong> The settings from this box only work if you do not use visual composer on this template. The template detects if visual composer is used and it removes the title and sidebars if that's the case. </p>


        <!-- sidebar position -->
        <div class="td-meta-box-row">
            <span class="td-page-o-custom-label">
                Sidebar position:
                <?php
                td_util::tooltip_html('
                        <h3>Sidebar position:</h3>
                        <p>From here you can set the sidebar position for this page only.</p>
                        <ul>
                            <li><strong>This setting overrides</strong> the Theme panel setting from <i>Template settings > Page template</i></li>
                            <li><strong>On default</strong> - the template will load the sidebar position that is set in the Theme panel: <i>Template settings > Page template</i></li>
                            <li>This setting is intended to be use for content pages, When this template detects
                            that Visual Composer is used, it will switch to a full width layout (with no sidebar). </li>
                            <li>If you want to use a sidebar with Visual Composer please use the Widgetised Sidebar block</li>

                        </ul>
                    ', 'right')
                ?>
            </span>
            <div class="td-inline-block-wrap">
                <?php
                echo td_panel_generator::visual_select_o(array(
                    'ds' => 'td_page',
                    'item_id' => '',
                    'option_id' => 'td_sidebar_position',
                    'values' => array(
                        array('text' => '', 'title' => '', 'val' => '', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-default.png'),
                        array('text' => '', 'title' => '', 'val' => 'sidebar_left', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-left.png'),
                        array('text' => '', 'title' => '', 'val' => 'no_sidebar', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-full.png'),
                        array('text' => '', 'title' => '', 'val' => 'sidebar_right', 'img' => get_template_directory_uri() . '/includes/wp_booster/wp-admin/images/panel/sidebar-right.png')
                    ),
                    'selected_value' => $mb->get_the_value('td_sidebar_position')
                ));
                ?>
            </div>
        </div>


        <!-- custom sidebar -->
        <div class="td-meta-box-row">
            <span class="td-page-o-custom-label">
                Custom sidebar:
                <?php
                td_util::tooltip_html('
                        <h3>Custom sidebar:</h3>
                        <p>From here you can set a custom sidebar for this page only.</p>
                        <ul>
                            <li><strong>This setting overrides</strong> the Theme panel setting from <i>Template settings > Page template</i></li>
                            <li><strong>On default</strong> - the template will load the sidebar that is set in the Theme panel: <i>Template settings > Page template</i></li>
                            <li>This setting is intended to be use for content pages, When this template detects
                            that Visual Composer is used, it will switch to a full width layout (with no sidebar). </li>
                            <li>If you want to use a sidebar with Visual Composer please use the Widgetised Sidebar block</li>
                        </ul>
                    ', 'right')
                ?>
            </span>
            <?php
            echo td_panel_generator::sidebar_pulldown(array(
                'ds' => 'td_page',
                'item_id' => '',
                'option_id' => 'td_sidebar',
                'selected_value' => $mb->get_the_value('td_sidebar')
            ));
            ?>
        </div>
    </div> <!-- /page option general -->




    <!-- unique articles tab -->
    <div class="td-page-option-panel td-page-option-unique-articles-2">

        <p>
            <strong>Note:</strong> We recommand to not use the Unique articles feature if you plan to use ajax blocks that have sub categories or pagination. This feature will make sure that only unique articles are loaded on the initial page load.
        </p>

        <div class="td-meta-box-row">
            <span class="td-page-o-custom-label">
                Unique articles:
            </span>
            <?php $mb->the_field('td_unique_articles'); ?>
            <div class="td-select-style-overwrite td-inline-block-wrap">
                <select name="<?php $mb->the_name(); ?>" class="td-panel-dropdown">
                    <option value=""> - Disabled - </option>
                    <option value="enabled"<?php $mb->the_select_state('enabled'); ?>>Enabled</option>
                </select>
            </div>
        </div>
    </div><!-- /page option general -->
</div>



