<?php   
    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit;
    
    // Loop through basic field types
    function opc_display_fields( $field, $value ) {
        switch ( $field['type'] ) {
            // Text and url
            case 'text':
            case 'url':
                echo '<input type="' . $field['type'] . '" name="' . $field['name'] . '" id="' . $field['id'] . '" value="' . $field['validate']( $value ) . '" />';
                break;

            // Text area
            case 'textarea':
                echo '<textarea name="' . $field['name'] . '" id="' . $field['id'] . '">' . $field['validate']( $value ) . '</textarea>';
                break;

            // Select drop down  
            case 'select':
                echo '<select name="' . $field['name'] . '" id="' . $field['id'] . '">';
                foreach ( $field['options'] as $option ) {
                    // Check for selected option and set as value
                    $selected = ( $value == $option ) ? ' selected="selected"' : '';

                    // Create option items block
                    $option_items = '<option' . $selected . '>';
                    $option_items .= $field['validate']( $option );
                    $option_items .= '</option>'; 

                    // Display option items block
                    echo $option_items;
                }
                echo '</select>';
                break;

            //  Radio option
            case 'radio':
                echo '<div class="options">';
                foreach ( $field['options'] as $option ) {
                    // Check for checked checkbox and set as value
                    if ( isset( $option['default'] ) ) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = ( $value == $option['label'] ) ? ' checked="checked"' : '';
                    }

                    // Create radio choices block
                    $radio_choices =  '<div class="radio">';
                    $radio_choices .= '<input type="radio" name="' . $field['name'] . '" id="' . $option['id'] . '" value="' . $field['validate']( $option['label'] ) . '"' . $checked . ' />';
                    $radio_choices .=  '<label for=' . $option['id'] . '>';
                    $radio_choices .=  $option['label'];
                    $radio_choices .=  '</label>';        
                    $radio_choices .=  '</div>'; 

                    // Display radio choices block
                    echo $radio_choices;                                      
                }
                echo '</div>';             
                break;

            // Checkbox    
            case 'checkbox':
                $checked = $value ? ' checked="checked"' : '';
                echo '<input type="checkbox" name="' . $field['name'] . '" value="' . $field['validate']( $field['value'] )  . '" id="' . $field['id'] . '"' . $checked . ' />';
                break;

            // Date
            case 'date': 
                echo '<input type="text" name="' . $field['name'] . '" id="' . $field['id'] . '" value="' . $field['validate']( $value ) . '" class="date-picker" />';
                break;

            // Hex color color selection
            case 'color':
                // Check if color is selected already
                $color = $value ? $field['validate']( $value ) : __( 'No color selected.', 'custom-stuff' );

                 // Create color selection block
                $color_selection = '<input type="text" name="' . $field['name'] . '" id="' . $field['id'] . '" value="' . $field['validate']( $value ) . '" class="color-select" />';
                $color_selection .= '<div class="current-color"><strong>' . __( 'Current Color:', 'custom-stuff' ) . '</strong> ' . $color . '</div>';

                // Display color selection block
                echo $color_selection;
                break;

            // Wordpress Media library    
            case 'media':
                // Check if there's an image already
                $image = $value ? '<div class="image-preview"><strong>' . __( 'Current Image:', 'custom-stuff' ) . '</strong><img src="' . $field['validate']( $value ) . '" /></div>' : '';

                // Create media selection block
                $media_selection = '<div class="media-field">';
                $media_selection .= $image;        
                $media_selection .= '<input type="url" name="' . $field['name'] . '" id="' . $field['id'] . '" value="' . $field['validate']( $value ) . '" /><br />';
                $media_selection .= '<input type="button" class="image-select button" value="' . __( 'Choose or Upload an Image', 'custom-stuff' ) . '" />';
                $media_selection .= '<input type="button" class="image-reset button" value="' . __( 'Clear Image', 'custom-stuff' ) . '" />';
                $media_selection .= '</div>';

                // Display media selection block
                echo $media_selection;
                break; 
 
            // Wordpress Editor    
            case 'editor':
                $settings = array( 
                    'textarea_name' => $field['name'],
                    'editor_class'  => 'opc-editor'
                );
                wp_editor( $value, $field['id'], $settings );
                break;
        }
    }

    // Display multiple text fields
    function opc_display_multitext( $field, $option, $value ) {
        // Create multi text block
        $multi_text = '<div class="text">';
        $multi_text .= '<label for=' . $option['id'] . '>';
        $multi_text .= $option['label'];
        $multi_text .= '</label>';
        $multi_text .= '<input type="text" name="' . $option['name'] . '" id="' . $option['id'] . '" value="' . $field['validate']( $value ) . '" />';
        $multi_text .= '</div>';

        // Display multi text block
        echo $multi_text;
    }

    // Display multiple checkboxes
    function opc_display_multicheck( $field, $option, $checked ) {
        // Create multi check block
        $multi_check = '<div class="check">';
        $multi_check .= '<input type="checkbox" name="' . $option['name'] . '" value="' . $field['validate']( $option['value'] ) . '" id="' . $option['id'] . '"' . $checked . ' />';
        $multi_check .= '<label for=' . $option['id'] . '>';
        $multi_check .= $option['label'];
        $multi_check .= '</label>';
        $multi_check .= '</div>';

        // Display multi check block
        echo $multi_check;        
    }

    // Display description if one is there
    function opc_display_description( $field ) {
        echo $field['desc'] ? '<p class="description">' . $field['desc'] . '</p>' : '';
    }