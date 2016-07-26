<?php 
    // Exit if accessed directly
    if ( !defined( 'ABSPATH' ) ) { exit; }
    
    // Post array for all sections and fields
    $postMetaBoxes = array();

    $postMetaBoxes[] = array(
        'id'       => 'opc-image',
        'title'    => __( 'Image', 'owl-post' ),
        'page'     => 'opc-slide',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Image URL', 'owl-post' ),
                'desc'     => __( 'Select an image or enter a valid image URL. <strong>Note:</strong> Images should typically be as wide the slider area.', 'owl-post' ),
                'id'       => '_opc-image-url',
                'name'     => '_opc-image-url',
                'type'     => 'media',
                'validate' => 'esc_url'
            ),
            array(
                'label'    => __( 'Image Alignment', 'owl-post' ),
                'desc'     => __( 'Change the image alignment here. The default is "center".', 'owl-post' ),
                'id'       => '_opc-image-alignment',
                'name'     => '_opc-image-alignment',
                'type'     => 'select',
                'validate' => 'opc_sanitize_image_alignment',
                'options'  => opc_image_alignment_choices()                
            ),
            array(
                'label'    => __( 'Background Color', 'owl-post' ),
                'desc'     => __( 'Background color for behind the image. You may not see this if the image takes up the width of the slider.', 'owl-post' ),
                'id'       => '_opc-image-bg-color',
                'name'     => '_opc-image-bg-color',
                'type'     => 'color',
                'validate' => 'opc_sanitize_hex'
            )                        
        )       
    );
 
    $postMetaBoxes[] = array(
        'id'       => 'opc-position',
        'title'    => __( 'Content Position', 'owl-post' ),
        'page'     => 'opc-slide',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Position', 'owl-post' ),
                'desc'     => __( 'Where should the content be positioned? If there are no values, it will be 20 pixels from the bottom and 20 pixels from the left. You can use numbers or "auto". Numeric values are in pixels.', 'owl-post' ),
                'id'       => '_opc-content-pos',
                'type'     => 'multitext',
                'validate' => 'opc_sanitize_pos',
                'options'  => array(
                    array(
                        'label' => __( 'Top', 'owl-post' ), 
                        'id'    => '_opc-content-pos-top', 
                        'name'  => '_opc-content-pos-top'
                    ),
                    array(
                        'label' => __( 'Right', 'owl-post' ), 
                        'id'    => '_opc-content-pos-right', 
                        'name'  => '_opc-content-pos-right'
                    ),
                    array(
                        'label' => __( 'Bottom', 'owl-post' ), 
                        'id'    => '_opc-content-pos-bottom', 
                        'name'  => '_opc-content-pos-bottom'
                    ),
                    array(
                        'label' => __( 'Left', 'owl-post' ), 
                        'id'    => '_opc-content-pos-left', 
                        'name'  => '_opc-content-pos-left'
                    )
                )
            )
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'opc-header',
        'title'    => __( 'Header', 'owl-post' ),
        'page'     => 'opc-slide',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array( 
            array(
                'label'    => __( 'Content', 'owl-post' ),
                'desc'     => __( 'Largest text on the rotator. Coded as a h3 tag.', 'owl-post' ),
                'id'       => '_opc-header-content',
                'name'     => '_opc-header-content',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'Color', 'owl-post' ),
                'desc'     => __( 'Color for the header text.', 'owl-post' ),
                'id'       => '_opc-header-color',
                'name'     => '_opc-header-color',
                'type'     => 'color',
                'validate' => 'opc_sanitize_hex'
            ), 
            array(
                'label'    => __( 'Text Shadow', 'owl-post' ),
                'desc'     => __( 'If a text shadow is needed, check this box.', 'owl-post' ),
                'id'       => '_opc-header-shadow',
                'name'     => '_opc-header-shadow',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanitize_checkbox',
            ),
        )       
    );

    $postMetaBoxes[] = array(
        'id'       => 'opc-subheader',
        'title'    => __( 'Sub-Header', 'owl-post' ),
        'page'     => 'opc-slide',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array( 
            array(
                'label'    => __( 'Content', 'owl-post' ),
                'desc'     => __( 'Optional sub-header. Coded as a h3 tag.', 'owl-post' ),
                'id'       => '_opc-subheader-content',
                'name'     => '_opc-subheader-content',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'Color', 'owl-post' ),
                'desc'     => __( 'Color for the sub-header text.', 'owl-post' ),
                'id'       => '_opc-subheader-color',
                'name'     => '_opc-subheader-color',
                'type'     => 'color',
                'validate' => 'opc_sanitize_hex'
            ), 
            array(
                'label'    => __( 'Text Shadow', 'owl-post' ),
                'desc'     => __( 'If a text shadow is needed, check this box.', 'owl-post' ),
                'id'       => '_opc-subheader-shadow',
                'name'     => '_opc-subheader-shadow',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanitize_checkbox',
            ),
        )       
    );

    $postMetaBoxes[] = array(
        'id'       => 'opc-normal-text',
        'title'    => __( 'Normal Text', 'owl-post' ),
        'page'     => 'opc-slide',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array( 
            array(
                'label'    => __( 'Content', 'owl-post' ),
                'desc'     => __( 'Optional text. Coded as a p tag.', 'owl-post' ),
                'id'       => '_opc-normal-text-content',
                'name'     => '_opc-normal-text-content',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'Color', 'owl-post' ),
                'desc'     => __( 'Color for the normal text.', 'owl-post' ),
                'id'       => '_opc-normal-text-color',
                'name'     => '_opc-normal-text-color',
                'type'     => 'color',
                'validate' => 'opc_sanitize_hex'
            ), 
            array(
                'label'    => __( 'Text Shadow', 'owl-post' ),
                'desc'     => __( 'If a text shadow is needed, check this box.', 'owl-post' ),
                'id'       => '_opc-normal-text-shadow',
                'name'     => '_opc-normal-text-shadow',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanitize_checkbox',
            ),
        )       
    );

    $postMetaBoxes[] = array(
        'id'       => 'opc-btn',
        'title'    => __( 'Button', 'owl-post' ),
        'page'     => 'opc-slide',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array( 
            array(
                'label'    => __( 'Position', 'owl-post' ),
                'desc'     => __( 'Where should the button be positioned? If there are no values, it will be 20 pixels from the bottom and 20 pixels from the right. You can use numbers or "auto". Numeric values are in pixels.', 'owl-post' ),
                'id'       => '_opc-btn-pos',
                'type'     => 'multitext',
                'validate' => 'opc_sanitize_pos',
                'options'  => array(
                    array(
                        'label' => __( 'Top', 'owl-post' ), 
                        'id'    => '_opc-btn-pos-top', 
                        'name'  => '_opc-btn-pos-top'
                    ),
                    array(
                        'label' => __( 'Right', 'owl-post' ), 
                        'id'    => '_opc-btn-pos-right', 
                        'name'  => '_opc-btn-pos-right'
                    ),
                    array(
                        'label' => __( 'Bottom', 'owl-post' ), 
                        'id'    => '_opc-btn-pos-bottom', 
                        'name'  => '_opc-btn-pos-bottom'
                    ),
                    array(
                        'label' => __( 'Left', 'owl-post' ), 
                        'id'    => '_opc-btn-pos-left', 
                        'name'  => '_opc-btn-pos-left'
                    )
                )                
            ),
            array(
                'label'    => __( 'Text', 'owl-post' ),
                'desc'     => __( 'Text for the button. Maximum of 50 characters allowed. Anything beyond that will not show!', 'owl-post' ),
                'id'       => '_opc-btn-content',
                'name'     => '_opc-btn-content',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'Text Color', 'owl-post' ),
                'desc'     => __( 'Text color for the button.', 'owl-post' ),
                'id'       => '_opc-btn-text-color',
                'name'     => '_opc-btn-text-color',
                'type'     => 'color',
                'validate' => 'opc_sanitize_hex'
            ),
            array(
                'label'    => __( 'Background Color', 'owl-post' ),
                'desc'     => __( 'Background color for the button text.', 'owl-post' ),
                'id'       => '_opc-btn-bg-color',
                'name'     => '_opc-btn-bg-color',
                'type'     => 'color',
                'validate' => 'opc_sanitize_hex'
            ), 
            array(
                'label'    => __( 'Button URL', 'owl-post' ),
                'desc'     => __( 'URL for the button.', 'owl-post' ),
                'id'       => '_opc-btn-url',
                'name'     => '_opc-btn-url',
                'type'     => 'url',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'New Window', 'owl-post' ),
                'desc'     => __( 'If checked, the URL in a new window.', 'owl-post' ),
                'id'       => '_opc-btn-new-window',
                'name'     => '_opc-btn-new-window',
                'type'     => 'checkbox',
                'value'    => 1,
                'validate' => 'opc_sanitize_checkbox',
            )                                                                        
        )
    );