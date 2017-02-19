<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

    // Generate json-ld data for book schema
    function insprvw_book_json( $post ) {
		// Get the author website and set fallback
		$author_website = get_the_author_meta( 'user_url' ) ? get_the_author_meta( 'user_url' ) : home_url( '/' );

		// Get the description
		$description = wp_strip_all_tags( insprvw_excerpt() );

		// Create json-ld block - START
		$json_ld = '{' . '<br />';
		$json_ld .= '"@type": "Review",' . '<br />';
		$json_ld .= '"name": "' . esc_html( get_the_title() ) . '",' . '<br />';
		$json_ld .= '"url": "' . esc_url( get_the_permalink() ) . '",' . '<br />';

		// Post author
		$json_ld .= '"author": {' . '<br />';
		$json_ld .= '"@type": "Person",' . '<br />';
		$json_ld .= '"name": "' . esc_html( get_the_author() ) . '",' . '<br />';
		$json_ld .= '"sameAs": "' . esc_url( $author_website ) . '"' . '<br />';
		$json_ld .= '},' . '<br />';

		// Date
		$json_ld .= '"datePublished": "' . esc_html( get_the_time( get_option( 'date_format' ) ) ) . '",' . '<br />';

		// Description
		$json_ld .= '"description": "' . esc_html( str_replace( 'Read Review', '', $description ) ) . '"' . '<br />';

		// Create json-ld block - END		
		$json_ld .= '}';

		return $json_ld;
	}