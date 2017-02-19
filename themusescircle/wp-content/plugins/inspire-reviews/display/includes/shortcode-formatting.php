<?php
	/**
	* Shortcodes to display special formatting
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Create bold shortcode for use in textareas
	function insprvw_bold_content( $atts, $content = null ) {
		return '<strong>' . esc_html ( $content ) . '</strong>';
	}
	add_shortcode( 'review-bold', 'insprvw_bold_content' );

	// Create italic shortcode for use in textareas
	function insprvw_italic_content( $atts, $content = null ) {
		return '<em>' . esc_html ( $content ) . '</em>';
	}
	add_shortcode( 'review-italic', 'insprvw_italic_content' );	

	// Create bold/italic shortcode for use in textareas
	function insprvw_bold_italic_content( $atts, $content = null ) {
		return '<strong><em>' . esc_html ( $content ) . '</em></strong>';
	}
	add_shortcode( 'review-bold-italic', 'insprvw_bold_italic_content' );		