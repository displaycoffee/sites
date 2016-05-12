<?php
    // Exit if accessed directly
    if ( !defined( 'ABSPATH' ) ) { exit; }
    
    // Image alignment choices
    function opc_image_alignment_choices() {
        return array(
            __( 'Center', 'owl-post' ), 
            __( 'Left', 'owl-post' ), 
            __( 'Right', 'owl-post' )
        );
    }   