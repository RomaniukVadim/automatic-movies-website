// JavaScript Document

/* global tinymce:{} */
/* global tinyMCE:{} */

( function() {

    'use strict';

    tinymce.PluginManager.add( 'td_shortcode_plugin', function( editor, url ) {
        editor.addButton( 'td_button_key', {
            type: 'listbox',
            text: 'Shortcodes',
            classes: 'td_tinymce_shortcode_dropdown widget btn td-tinymce-dropdown',
            icon: false,
            values: [

                {text: 'Video Playlists', value: 1, classes: 'td_tinymce_dropdown_title'},
                {text: 'Youtube playlist', value: 2, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[td_block_video_youtube playlist_title="" playlist_yt="" playlist_auto_play="0"]' + tinyMCE.activeEditor.selection.getContent());
                }},
                {text: 'Vimeo playlist', value: 3, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[td_block_video_vimeo playlist_title="" playlist_v="" playlist_auto_play="0"]' + tinyMCE.activeEditor.selection.getContent());
                }},


                {text: 'Smart lists',  value: 4, classes: 'td_tinymce_dropdown_title'},
                {text: 'Smart list end',  value: 5, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[td_smart_list_end]' + tinyMCE.activeEditor.selection.getContent());
                }},


                {text: 'Button', value: 6, classes: 'td_tinymce_dropdown_title'},
                {text: 'Default', value: 7, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[button color="" size="" type="" target="" link=""]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
                }},
                {text: 'Square', value: 8, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[button color="" size="" type="square" target="" link=""]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
                }},
                {text: 'Round', value: 9, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[button color="" size="" type="round" target="" link=""]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
                }},
                {text: 'Outlined', value: 10, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[button color="" size="" type="outlined" target="" link=""]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
                }},
                {text: '3d', value: 11, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[button color="" size="" type="3d" target="" link=""]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
                }},
                {text: 'Square outlined', value: 12, onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[button color="" size="" type="square_outlined" target="" link=""]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
                }},

            ]

        });

    } );

} )();


