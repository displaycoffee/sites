<?php
	/**
	* Shortcode to display recent reviews
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Loop through post type and create a shortcode for recent reviews
	function insprvw_recent_reviews( $atts ) {	
		// Get arguments for shortcode
	    $a = shortcode_atts( array(
	        'names' => '',
	        'title' => 'true'
	    ), $atts );	

	}
	add_shortcode( 'recent-reviews', 'insprvw_recent_reviews' );