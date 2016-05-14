<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Loop through post type and custom meta
	function insprvwf_cat_public() {
		$taxonomies = array( 
		    'insprvwf-cat-public'
		);

		$args = array(
		    'hide_empty' => 0
		); 

		$terms = get_terms( $taxonomies, $args );

		echo '<h3>' . __( 'Display Category Public', 'custom-stuff' ) . '</h3>';
		echo '<ul>';
		foreach ( $terms as $term ) {
			echo '<li>' . esc_html( $term->name ) . '</li>';
			echo '<li>' . esc_html( $term->term_id ) . '</li>';
			echo '<li>' . esc_html( $term->slug ) . '</li>';
			echo '<li>' . esc_html( $term->description ) . '</li>';
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-text', true ) ) . '</li>';
			echo '<li>' . esc_url( get_term_meta( $term->term_id, 'insprvwf-url', true ) ) . '</li>'; 
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-multitext01', true ) ) . '</li>';
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-multitext02', true ) ) . '</li>';
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-multitext03', true ) ) . '</li>';
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-multitext04', true ) ) . '</li>';
			echo '<li>' . wpautop( esc_html( get_term_meta( $term->term_id, 'insprvwf-textarea', true ) ) ) . '</li>'; 
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-select', true ) ) . '</li>'; 
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-radio', true ) ) . '</li>'; 
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-checkbox', true ) ) . '</li>'; 
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-multicheck01', true ) ) . '</li>';
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-multicheck02', true ) ) . '</li>';
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-multicheck03', true ) ) . '</li>';
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-multicheck04', true ) ) . '</li>';			
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-color', true ) ) . '</li>'; 
			echo '<li>' . esc_url( get_term_meta( $term->term_id, 'insprvwf-image', true ) ) . '</li>'; 
			echo '<li>' . esc_html( get_term_meta( $term->term_id, 'insprvwf-editor', true ) ) . '</li>'; 
		}
		echo '</ul>';
		echo '<hr />';
	}
	add_shortcode( 'display-cat-public', 'insprvwf_cat_public' );	