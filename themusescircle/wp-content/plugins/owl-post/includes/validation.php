<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Checkbox validation
	function opc_sanatize_checkbox( $input ) {
	    if ( $input == 1 || $input == '1' ) {
	        return 1;
	    } else {
	        return null;
	    }
	}

	// Image alignment select
	function opc_sanatize_image_alignment( $input ) {
		// Get select choices
	    $valid = opc_image_alignment_choices();	

	    // Check if choices are in array 
	    if ( in_array( $input, $valid ) ) {
	        return $input;
	    } else {
	        return null;
	    }
	}

	// Hex color validation
    function opc_sanitize_hex( $input ) {
        if ( '' ===  $input ) {
            return '';
        }  
           
        // 3 or 6 hex digits, or the empty string.
        if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $input ) ) {
            return $input;
        }
        return null;
    }

	// For santizing numbers
    function opc_sanitize_number( $input ) {
	    if ( $input === '0' ) {
	    	return '0';
	    } elseif ( is_numeric( $input ) ) {
    		return floatval( $input );
	    } else {
	    	return null;
	    }
	}

	// If the value is a number or auto (for positioning content)
	function opc_sanitize_pos( $input ) {
	    if ( $input  === '0' ) {
	    	return '0';
	    } elseif ( is_numeric( $input ) ) {
    		return floatval( $input );
	    } elseif ( strtolower( $input ) == 'auto' ) {
	    	return 'auto';
	    } else {
	    	return null;
	    }			
	}		