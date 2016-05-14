<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Loop through post type and custom meta
	function insprvwf_options_page() {
		$option = get_option( 'insprvwf-options' );
		echo '<h3>' . __( 'Display Options', 'custom-stuff' ) . '</h3>';
		echo '<ul>';		
		echo '<li>' . esc_html( $option['insprvwf-text'] ) . '</li>';
		echo '<li>' . esc_url( $option['insprvwf-url'] ) . '</li>';
		echo '<li>' . wpautop( esc_html( $option['insprvwf-textarea'] ) ) . '</li>';
		echo '<li>' . esc_html( $option['insprvwf-select'] ) . '</li>';
		echo '<li>' . esc_html( $option['insprvwf-radio'] ) . '</li>';
		echo '<li>' . esc_html( $option['insprvwf-checkbox'] ) . '</li>';
		echo '<li>' . esc_html( $option['insprvwf-color'] ) . '</li>';
		echo '<li>' . esc_html( $option['insprvwf-image'] ) . '</li>';
		echo '</ul>';
		echo '<hr />';
	}
	add_shortcode( 'display-options', 'insprvwf_options_page' );