<?php

/**
 * tagDiv Help Pointer, based on https://github.com/rawcreative/wp-help-pointers
 * GPL LICENSE
 * @version 1.0
 *
 *
 * Original author:
 * @version 0.1
 * @author Tim Debo <tim@rawcreativestudios.com>
 * @copyright Copyright (c) 2012, Raw Creative Studios
 * @link https://github.com/rawcreative/wp-help-pointers
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class td_help_pointers {

    public $screen_id;
    public $valid;
    public $pointers;

    public function __construct( $pntrs = array() ) {

        // Don't run on WP < 3.3
        if ( get_bloginfo( 'version' ) < '3.3' ) {
            return;
        }


        $screen = get_current_screen();
        $this->screen_id = $screen->id;

        $this->register_pointers($pntrs);

        add_action( 'admin_enqueue_scripts', array( &$this, 'add_pointers' ), 1000 );
        add_action( 'admin_head', array( &$this, 'add_scripts' ) );
    }

    public function register_pointers( $pntrs ) {
        $pointers ='';
        foreach( $pntrs as $ptr ) {

            if( $ptr['screen'] == $this->screen_id ) {

                $pointers[$ptr['id']] = array(
                    'screen' => $ptr['screen'],
                    'target' => $ptr['target'],
                    'options' => array(
                        'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
                            $ptr['title'],
                            $ptr['content']
                        ),
                        'position' => $ptr['position']
                    )
                );

            }
        }

        $this->pointers = $pointers;

    }

    public function add_pointers() {

        $pointers = $this->pointers;

        if ( ! $pointers || ! is_array( $pointers ) )
            return;

        // Get dismissed pointers

        $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
        $valid_pointers = array();

        // Check pointers and remove dismissed ones.
        foreach ( $pointers as $pointer_id => $pointer ) {

            // Make sure we have pointers & check if they have been dismissed
            if ( in_array( $pointer_id, $dismissed ) || empty( $pointer )  || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) )
                continue;

            $pointer['pointer_id'] = $pointer_id;

            // Add the pointer to $valid_pointers array
            $valid_pointers['pointers'][] =  $pointer;
        }

        // No valid pointers? Stop here.
        if ( empty( $valid_pointers ) )
            return;

        $this->valid = $valid_pointers;

        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
    }

    public function add_scripts() {
        // pointer js : https://github.com/WordPress/WordPress/blob/3.4.1/wp-includes/js/wp-pointer.dev.js
        $pointers = $this->valid;

        if( empty( $pointers ) )
            return;

        $pointers = json_encode( $pointers );

        echo <<<HTML
        <script>
        jQuery(window).load( function() {


             var WPHelpPointer = {$pointers};

            jQuery.each(WPHelpPointer.pointers, function(i) {
                setTimeout(function(){
                    pointer = WPHelpPointer.pointers[i];
                    options = jQuery.extend( pointer.options, {
                        close: function() {
                            jQuery.post( ajaxurl, {
                                pointer: pointer.pointer_id,
                                action: 'dismiss-wp-pointer'
                            });
                        },
                        pointerClass: 'wp-pointer',
                        pointerWidth: 467
                    });
                    jQuery(pointer.target).pointer( options ).pointer('open');
                }, 1000);

            });



        });
        </script>
HTML;

    }

} // end class