<?php
	/**
	* Custom validation functions for customizer
	*/	

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Textarea 
	function musescircle_sanitize_textarea( $input ) {
		// Find line replaces and replace them with text
		// Note: line break \r\n must have double quotes around it
	    $replaced_input = str_replace( "\n", '**--KEEPNEWLINES--**', $input );

	    // Sanitize the replaced text
	    $sanitized_input = sanitize_text_field( $replaced_input );

	    // Then add line breaks back in with new replacement on sanitized string
	    $new_input = str_replace( '**--KEEPNEWLINES--**', "\n", $sanitized_input );

	    // Return input
	    return $new_input;
	}
	
	// Checkbox
	function musescircle_sanitize_checkbox( $input ) {
		// Check if input is a string or integer of 1
	    if ( $input == 1 || $input == '1' ) {
	        return 1;
	    } else {
	        return '';
	    }
	}

	// Select
	function musescircle_sanitize_select( $input ) {
		// Get select choices
	    $valid = musescircle_select_choices();	

	    // Check if choices are in array 
	    if ( array_key_exists( $input, $valid ) ) {
	        return $input;
	    } else {
	        return '';
	    }
	}

	// Radio
	function musescircle_sanitize_radio( $input ) {
		// Get radio choices
	    $valid = musescircle_radio_choices();

	    // Check if choices are in array	 
	    if ( array_key_exists( $input, $valid ) ) {
	        return $input;
	    } else {
	        return '';
	    }
	}	

	// Numbers
    function musescircle_sanitize_number( $input ) {
    	// Check if input is numeric
	    if ( is_numeric( $input ) ) {
    		return intval( $input );
	    } else {
	    	return '';
	    }
	}

	// Date validation
    function musescircle_sanitize_date( $input ) {
    	// Get each value in the date - month, day, year
        $date = preg_match( '/(\d{2})\/(\d{2})\/(\d{4})/', $input, $match );

        if ( $date == '1' && checkdate( $match[1], $match[2], $match[3] ) ) {
        	return $match[1] . '/' . $match[2] . '/' . $match[3];
        } else {
        	return null;
        }        
    }		