<?php
	/**
	* Custom validation functions for customizer
	*/	

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Sanitize textarea 
	function themusescircle_sanitize_textarea( $input ) {
	    return esc_textarea( $input );
	}

	// Checkbox
	function themusescircle_sanatize_checkbox( $input ) {
	    if ( $input == 1 || $input == '1' ) {
	        return 1;
	    } else {
	        return '';
	    }
	}

	// Select
	function themusescircle_sanitize_select( $input ) {
		// Get select choices
	    $valid = themusescircle_select_choices();	

	    // Check if choices are in array 
	    if ( array_key_exists( $input, $valid ) ) {
	        return $input;
	    } else {
	        return '';
	    }
	}

	// Radio
	function themusescircle_sanitize_radio( $input ) {
		// Get radio choices
	    $valid = themusescircle_radio_choices();

	    // Check if choices are in array	 
	    if ( array_key_exists( $input, $valid ) ) {
	        return $input;
	    } else {
	        return '';
	    }
	}	

	// Numbers
    function themusescircle_sanitize_number( $input ) {
	    if ( is_numeric( $input ) ) {
    		return intval( $input );
	    } else {
	    	return '';
	    }
	}

	// Date validation
    function themusescircle_sanitize_date( $input ) {
    	// Get each value in the date - month, day, year
        $date = preg_match( '/(\d{4})-(\d{2})-(\d{2})/', $input, $match );

        if ( $date == '1' && checkdate( $match[2], $match[3], $match[1] ) ) {
        	return $input;
        } else {
        	return '';
        }
    }		