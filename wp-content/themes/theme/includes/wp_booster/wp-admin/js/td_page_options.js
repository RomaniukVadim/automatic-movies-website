/**
 * Created by ra on 2/18/2015.
 */


var td_page_options = {
    init: function () {

        jQuery().ready(function() {

            jQuery('.td-page-options-tab a').click(function(event){
                event.preventDefault();
                var link_parent = jQuery(this).parent();

                // add class to the tab
                jQuery(link_parent).parent().find('.td-page-options-tab-active').removeClass('td-page-options-tab-active');
                link_parent.addClass('td-page-options-tab-active');

                //return;
                // add class to the panel
                var panel_class = link_parent.data('panel-class');
                //alert(panel_class);
                jQuery(link_parent).parent().parent().find('.td-page-option-panel-active').removeClass('td-page-option-panel-active');
                jQuery('.' + panel_class).addClass('td-page-option-panel-active');

            });

            jQuery('.td-page-options-tab-active').click(function(event){
                event.preventDefault();
            });
        });

    }
};


td_page_options.init();










