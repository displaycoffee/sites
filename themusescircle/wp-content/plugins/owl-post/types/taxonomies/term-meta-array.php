<?php 
    // Exit if accessed directly
    if ( !defined( 'ABSPATH' ) ) { exit; }
    
    // Term array for all sections and fields
    $termMetaBoxes = array();
 
    $termMetaBoxes[] = array(
        'category' => 'opc-category',
        'fields'   => array(           
            array(
                'label'    => __( 'Max Width', 'owl-post' ),
                'desc'     => __( 'Max width of the slider. Numeric values are in pixels.', 'owl-post' ),
                'id'       => 'opc-max-width',
                'name'     => 'opc-max-width',
                'type'     => 'text',
                'validate' => 'opc_sanitize_number',
                'column'   => 'no'
            ),
            array(
                'label'    => __( 'Max Width Unit', 'owl-post' ),
                'desc'     => __( 'Should the max width unit use pixels or percentage? The default is pixels.', 'owl-post' ),
                'id'       => 'opc-max-width-unit',
                'name'     => 'opc-max-width-unit',
                'type'     => 'radio',
                'validate' => 'opc_sanitize_max_width_unit',
                'column'   => 'yes',                
                'options'  => opc_max_width_unit_choices()
            ),
            array(
                'label'    => __( 'Max Height', 'owl-post' ),
                'desc'     => __( 'Max height of images in the slider. Numeric values are in pixels.', 'owl-post' ),
                'id'       => 'opc-max-height',
                'name'     => 'opc-max-height',
                'type'     => 'text',
                'validate' => 'opc_sanitize_number',
                'column'   => 'no'
            ),                        
            array(
                'label'    => __( 'Autoplay', 'owl-post' ),
                'desc'     => __( 'To disable autoplay on slides, check this.', 'owl-post' ),
                'id'       => 'opc-disable-autoplay',
                'name'     => 'opc-disable-autoplay',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanatize_checkbox',
                'column'   => 'no'
            ),  
            array(
                'label'    => __( 'Slide Speed', 'owl-post' ),
                'desc'     => __( 'You can change the speed of the transition between slides here. Numeric values are in milliseconds. The default is 200 milliseconds (0.2 seconds).', 'owl-post' ),
                'id'       => 'opc-slide-speed',
                'name'     => 'opc-slide-speed',
                'type'     => 'text',
                'validate' => 'opc_sanitize_number',
                'column'   => 'no'
            ),                      
            array(
                'label'    => __( 'Navigation', 'owl-post' ),
                'desc'     => __( 'To disable navigation on slides, check this.', 'owl-post' ),
                'id'       => 'opc-disable-navigation',
                'name'     => 'opc-disable-navigation',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanatize_checkbox',
                'column'   => 'no'
            ),
            array(
                'label'    => __( 'Pagination', 'owl-post' ),
                'desc'     => __( 'To disable pagination on slides, check this.', 'owl-post' ),
                'id'       => 'opc-disable-pagination',
                'name'     => 'opc-disable-pagination',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanatize_checkbox',
                'column'   => 'no'
            ),   
            array(
                'label'    => __( 'Pagination Speed', 'owl-post' ),
                'desc'     => __( 'You can change the speed of the transition between pagination here. Numeric values are in milliseconds. The default is 800 milliseconds (0.8 seconds).', 'owl-post' ),
                'id'       => 'opc-pagination-speed',
                'name'     => 'opc-pagination-speed',
                'type'     => 'text',
                'validate' => 'opc_sanitize_number',
                'column'   => 'no'
            )                    
        )
    );