<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Textarea 
	function insprvw_sanitize_textarea( $input ) {
		// Find line replaces and replace them with text
		// Note: line break \r\n must have double quotes around it
	    $replaced_input = str_replace( "\r\n", '**--KEEPNEWLINES--**', $input );

	    // Sanitize the replaced text
	    $sanitized_input = sanitize_text_field( $replaced_input );

	    // Then add line breaks back in with new replacement on sanitized string
	    $new_input = str_replace( '**--KEEPNEWLINES--**', "\r\n", $sanitized_input );

	    // Return input
	    return $new_input;
	}
	
	// Date validation
    function insprvw_sanitize_date( $input ) {
    	// Get each value in the date - month, day, year
        $date = preg_match( '/(\d{2})\/(\d{2})\/(\d{4})/', $input, $match );

        if ( $date == '1' && checkdate( $match[1], $match[2], $match[3] ) ) {
        	return $input;
        } else {
        	return null;
        }
    }

    // For santizing numbers
    function insprvw_sanitize_number( $input ) {
	    if ( $input === '0' ) {
	    	return '0';
	    } elseif ( is_numeric( $input ) ) {
    		return floatval( $input );
	    } else {
	    	return null;
	    }
	}

	// If a number is over a certain amount, don't update (for ratings)
    function insprvw_sanitize_rating( $input ) {
	    if ( $input === '0' ) {
	    	return '0';
	    } elseif ( is_numeric( $input ) && $input <= 5 ) {
    		return floatval( $input );
	    } elseif ( is_numeric( $input ) && $input > 5 ) {
    		return 5;
	    } else {
	    	return null;
	    }	    
	}