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
            		$selected = ( $value == $option ) ? ' selected="selected"' : '';
					echo '<option' . $selected . '>';
					echo $field['validate']( $option );
					echo '</option>'; 
            	}
            	echo '</select>';
            	break;

            //  Radio option
            case 'radio':
                echo '<div class="options">';
                foreach ( $field['options'] as $option ) {
                    if ( isset( $option['default'] ) ) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = ( $value == $option['label'] ) ? ' checked="checked"' : '';
                    }
			        echo '<div class="radio">';
			        echo '<input type="radio" name="' . $field['name'] . '" id="' . $option['id'] . '" value="' . $field['validate']( $option['label'] ) . '"' . $checked . ' />';
			        echo '<label for=' . $option['id'] . '>';
			        echo $option['label'];
			        echo '</label>';        
			        echo '</div>';                   
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
                $color = $value ? $field['validate']( $value ) : __( 'No color selected.', 'custom-stuff' );
		        echo '<input type="text" name="' . $field['name'] . '" id="' . $field['id'] . '" value="' . $field['validate']( $value ) . '" class="color-select" />';
		        echo '<div class="current-color"><strong>' . __( 'Current Color:', 'custom-stuff' ) . '</strong> ' . $color . '</div>';
                break;

            // Wordpress Media library    
            case 'media':
                $image = $value ? '<div class="image-preview"><strong>' . __( 'Current Image:', 'custom-stuff' ) . '</strong><img src="' . $field['validate']( $value ) . '" /></div>' : '';
				echo '<div class="media-field">';
		        echo $image;        
		        echo '<input type="url" name="' . $field['name'] . '" id="' . $field['id'] . '" value="' . $field['validate']( $value ) . '" /><br />';
		        echo '<input type="button" class="image-select button" value="' . __( 'Choose or Upload an Image', 'custom-stuff' ) . '" />';
		        echo '<input type="button" class="image-reset button" value="' . __( 'Clear Image', 'custom-stuff' ) . '" />';
		        echo '</div>';
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
        echo '<div class="text">';
        echo '<label for=' . $option['id'] . '>';
        echo $option['label'];
        echo '</label>';
        echo '<input type="text" name="' . $option['name'] . '" id="' . $option['id'] . '" value="' . $field['validate']( $value ) . '" />';
        echo '</div>';
	}

	// Display multiple checkboxes
	function opc_display_multicheck( $field, $option, $checked ) {
        echo '<div class="check">';
        echo '<input type="checkbox" name="' . $option['name'] . '" value="' . $field['validate']( $option['value'] ) . '" id="' . $option['id'] . '"' . $checked . ' />';
        echo '<label for=' . $option['id'] . '>';
        echo $option['label'];
        echo '</label>';
        echo '</div>';
	}

	// Display description if one is there
	function opc_display_description( $field ) {
        $description = $field['desc'] ? '<p class="description">' . $field['desc'] . '</p>' : '';
        echo $description;		
	}