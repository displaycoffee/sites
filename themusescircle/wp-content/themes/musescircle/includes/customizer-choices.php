<?php
	/**
	* Funtions for customizer fields that have choices
	*/	

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Select choices
	function musescircle_select_choices() {
		return array(
	        'Option 01' => __( 'Option 01', 'musescircle' ),
	        'Option 02' => __( 'Option 02', 'musescircle' ),
	        'Option 03' => __( 'Option 03', 'musescircle' )
	    );
	}

	// Radio choices
	function musescircle_radio_choices() {
		return array(
            'Yes' => __( 'Yes', 'musescircle' ),
            'No'  => __( 'No', 'musescircle' )
	    );
	}	
