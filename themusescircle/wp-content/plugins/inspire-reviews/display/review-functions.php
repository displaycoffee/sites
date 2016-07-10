<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Get custom archive templates
	function insprvw_get_archive_template( $archive ) {
		// Book review
		if ( get_post_type() == 'insprvw-book-review' ) {
			$archive = dirname( __FILE__ ) . '/templates/archive-book-review.php';
		}
		return $archive;
	}
	add_filter( 'archive_template', 'insprvw_get_archive_template' ) ;

	// Get custom single template
	function insprvw_get_single_template( $single ) {
		// Book review 
		if ( get_post_type() == 'insprvw-book-review' ) {
			$single = dirname( __FILE__ ) . '/templates/single-book-review.php';
		}
		return $single;
	}
	add_filter( 'single_template', 'insprvw_get_single_template' );

	// Trim default excerpt length
	function insprvw_excerpt_length( $length ) {
	    return 50;
	}
	add_filter( 'excerpt_length', 'insprvw_excerpt_length' );

	// Change text if excerpt length is reached
	function insprvw_excerpt_more( $more ) {
	    return '...';
	}
	add_filter( 'excerpt_more', 'insprvw_excerpt_more' );

	// Custom read more link for excerpts
	function insprvw_read_more() {
	    return '<div class="read-more"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read More', 'inspire-reviews' ) . '</a></div>';
	}

	// Check if there is a custom excerpt and if so, make sure it's not too long
	function insprvw_excerpt() {
		if ( has_excerpt() ) {	    
		    return '<p>' . wp_trim_words( get_the_excerpt(), 50 ) . '</p>' . insprvw_read_more();
		} else {
			return '<p>' . get_the_excerpt() . '</p>' . insprvw_read_more();
		}
	}