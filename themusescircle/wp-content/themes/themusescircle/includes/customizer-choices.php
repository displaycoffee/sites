<?php
	/**
	* Funtions for customizer fields that have choices
	*/	

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Select choices
	function themusescircle_select_choices() {
		return array(
	        'Option 01' => __( 'Option 01', 'themusescircle' ),
	        'Option 02' => __( 'Option 02', 'themusescircle' ),
	        'Option 03' => __( 'Option 03', 'themusescircle' )
	    );
	}

	// Radio choices
	function themusescircle_radio_choices() {
		return array(
            'Yes' => __( 'Yes', 'themusescircle' ),
            'No'  => __( 'No', 'themusescircle' )
	    );
	}	
