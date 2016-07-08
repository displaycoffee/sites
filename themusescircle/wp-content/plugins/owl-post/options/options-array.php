<?php 
    // Exit if accessed directly
    if ( !defined( 'ABSPATH' ) ) { exit; }
    
    // Option array for all sections and fields
    $optionPages = array();
 
    $optionPages[] = array(
        'slug'          => 'edit.php?post_type=opc-slide',
        'title'         => __( 'Options', 'owl-post' ),
        'capability'    => 'manage_options',
        'menu-slug'     => 'opc-options.php',
        'options-group' => 'opc-options',
        'fields'        => array(
            array(
                'id'    => 'opc-option-section-01',
                'title' => __( 'Assets', 'owl-post' ),
                'desc'  => __( 'Remove extra assets like Owl Carousel JavaScript and CSS here.', 'owl-post' ),
                'type'  => 'section'
            ),                                        
            array(
                'label'    => __( 'Remove JS', 'owl-post' ),
                'desc'     => __( 'If you already have Owl Carousel JS, check this so duplicate assets don\'t load.', 'owl-post' ),
                'id'       => 'opc-remove-js',
                'name'     => 'opc-options[opc-remove-js]',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanatize_checkbox',
                'section'  => 'opc-option-section-01'
            ),  
            array(
                'label'    => __( 'Remove CSS', 'owl-post' ),
                'desc'     => __( 'If you already have Owl Carousel CSS, check this so duplicate assets don\'t load. <strong>Not recommended!</strong>', 'owl-post' ),
                'id'       => 'opc-remove-css',
                'name'     => 'opc-options[opc-remove-css]',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanatize_checkbox',
                'section'  => 'opc-option-section-01'
            )                       
        )
    );