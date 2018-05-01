/**
 * Created by tagdiv on 26.11.2015.
 */

/* global jQuery:{} */

(function($){

    'use strict';

    $(document).ready(function(){

        $( 'body' )
            .off( 'click', '.td_access_token' )
            .on( 'click', '.td_access_token', function(event) {
            event.preventDefault();
            var $this = $(this);

            if ( $this.hasClass( 'facebook' ) ) {
                var td_social_counter_panel = $this.closest( '.vc_edit_form_elements' ),
                    facebook_app_id,
                    facebook_security_key,
                    facebook_access_token;

                if ( td_social_counter_panel.length ) {
                    facebook_app_id = td_social_counter_panel.find( 'input[name="facebook_app_id"]' );
                    facebook_security_key = td_social_counter_panel.find( 'input[name="facebook_security_key"]' );
                    facebook_access_token = td_social_counter_panel.find( 'input[name="facebook_access_token"]' );
                } else {

                    // Try to see if we are in widget admin panel
                    td_social_counter_panel= $this.closest( '.widget-inside' );

                    if ( td_social_counter_panel.length ) {
                        facebook_app_id = td_social_counter_panel.find('input[id$="facebook_app_id"]');
                        facebook_security_key = td_social_counter_panel.find('input[id$="facebook_security_key"]');
                        facebook_access_token = td_social_counter_panel.find('input[id$="facebook_access_token"]');
                    }
                }

                if ( facebook_app_id.length && facebook_security_key.length && facebook_access_token.length ) {

                    var td_access_token_info = $this.next( '.td_access_token_info'),
                        // values extracted to sanitize them
                        val_facebook_app_id = facebook_app_id.val(),
                        val_facebook_security_key = facebook_security_key.val();

                    $.ajax({
                        url: 'https://graph.facebook.com/oauth/access_token',
                        data: {
                            client_id: val_facebook_app_id,
                            client_secret: val_facebook_security_key,
                            grant_type: 'client_credentials'
                        },
                        beforeSend: function( jqXHR ) {
                            if ( td_access_token_info.length ) {
                                td_access_token_info.show();
                            }
                        }
                    }).done(function( data, textStatus, jqXHR ) {
                        facebook_access_token.val( data.replace( 'access_token=' , '' ) );
                    }).fail(function( jqXHR, textStatus, errorThrown ) {
                        window.alert( 'Incorrect data, please check each field.' + '\n\n' + 'Info Message: ' + jqXHR.responseJSON.error.message );
                    }).always(function( data, textStatus, jqXHR ) {
                        if ( td_access_token_info.length ) {
                            td_access_token_info.hide();
                        }
                    });
                }
            }
        });
    });

})(jQuery);