/**
 * used in wp-admin -> edit page, not on posts
 * this class hides and shows the metaboxes acording to the selected template
 * @type {{init: Function, show_template_settings: Function, change_content: Function}}
 */
var td_edit_page = {

    init: function () {
        jQuery().ready(function() {
            td_edit_page.show_template_settings();

            jQuery('#page_template').change(function() {
                td_edit_page.show_template_settings();
            });
        });

    },


    show_template_settings: function () {
        if (jQuery('#post_type').val() == 'post') {
            return;
        }


        //text and image after template drop down
        td_edit_page.change_content();


        //hide all elements

        var cur_template = jQuery('#page_template option:selected').text();

        // the show only unique articles box is always visible
        switch (cur_template) {
            case 'Pagebuilder + latest articles + pagination':
                jQuery('#td_page_metabox').hide();
                jQuery('#td_homepage_loop_metabox').slideDown();
                td_edit_page.change_content('<span class="td-wpa-info"><strong>Tip:</strong> Homepage made from a pagebuilder section and a loop below. <ul><li>The loop supports an optional sidebar and advanced filtering options. </li> <li>You can find all the options of this template if you scroll down.</li></ul></span>');
                break;

            case 'Pagebuilder + page title':
                jQuery('#td_homepage_loop_metabox').hide();
                jQuery('#td_page_metabox').slideDown();
                td_edit_page.change_content('<span class="td-wpa-info"><strong>Tip:</strong> Useful when you want to create a page that has a standard title using visual composer. We recommend that you select a <span style="color:#ff6a5e; text-decoration: underline">no sidebar</span> layout for best results.</span>');
                break;

            default: //default template
                jQuery('#td_homepage_loop_metabox').hide();
                jQuery('#td_page_metabox').slideDown();
                td_edit_page.change_content('<span class="td-wpa-info"><strong>Tip:</strong> Default template, perfect for visual composer or content pages. <ul><li>If visual composer is used, the page will be without a title.</li> <li>If it\'s a content page the template will generate a title</li></ul></span>');
                break;
        }
    },


    change_content: function (the_text) {
        if(document.getElementById("td_after_template_container_id")) {
            var after_element = document.getElementById("td_after_template_container_id");
            after_element.innerHTML = "";
            if(typeof the_text != 'undefined') {
                after_element.innerHTML = the_text;
            }
        } else {
            if(document.getElementById("page_template")) {
                //create the container
                var after_element = document.createElement("div");
                after_element.setAttribute("id", "td_after_template_container_id");
                //insert the element in DOM, after template pull down
                document.getElementById("page_template").parentNode.insertBefore(after_element, document.getElementById("page_template").nextSibling);
            }
        }
    }
};

td_edit_page.init();
