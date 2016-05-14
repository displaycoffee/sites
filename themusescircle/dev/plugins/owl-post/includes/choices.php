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

    // Max width choices
    function opc_max_width_unit_choices() {
        return array(
            array(
                'label'   => __( 'Pixels', 'owl-post' ), 
                'id'      => 'opc-max-width-pixels', 
                'name'    => 'opc-max-width-pixels',
                'default' => 'yes'
            ),
            array(
                'label' => __( 'Percentage', 'owl-post' ), 
                'id'    => 'opc-max-width-percentage',
                'name'  => 'opc-max-width-percentage',
            )
        );
    }       