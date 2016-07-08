<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Max values
	$max_width = get_term_meta( $term_id, 'opc-max-width', true );
	$max_width_unit = ( get_term_meta( $term_id, 'opc-max-width-unit', true ) == 'Percentage') ? '%' : 'px';
	$max_height = get_term_meta( $term_id, 'opc-max-height', true );

	// Autoplay
	$disable_ap= get_term_meta( $term_id, 'opc-disable-autoplay', true );

	// Slide speed
	$slide_speed = get_term_meta( $term_id, 'opc-slide-speed', true );

	// Navigation and pagination
	$disable_navigation = get_term_meta( $term_id, 'opc-disable-navigation', true );
	$disable_pagination = get_term_meta( $term_id, 'opc-disable-pagination', true );
	$pagination_speed = get_term_meta( $term_id, 'opc-pagination-speed', true );	