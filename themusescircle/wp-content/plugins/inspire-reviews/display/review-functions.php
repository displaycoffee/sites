<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Get custom archive templates
	function insprvw_get_archive_template( $archive ) {
		// Book review
		if ( get_post_type() == 'insprvw-book-review' ) {
			$archive = dirname( __FILE__ ) . '/book/book-review-archive.php';
		}
		return $archive;
	}
	add_filter( 'archive_template', 'insprvw_get_archive_template' ) ;

	// Get custom single template
	function insprvw_get_single_template( $single ) {
		// Book review 
		if ( get_post_type() == 'insprvw-book-review' ) {
			$single = dirname( __FILE__ ) . '/book/book-review-single.php';
		} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
			$single = dirname( __FILE__ ) . '/video/video-review-single.php';
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

	// Create list items (without schema)
	function insprvw_item_details( $class, $label, $value ) {
		// Create list item with details about review item
		$review_item_details = '<li class="book-' . $class . '">';
		$review_item_details .= '<span class="review-label">' . __( $label, 'inspire-reviews' ) . ':</span> ';
		$review_item_details .= '<span class="review-value">' . esc_html( $value ) . '</span>';
		$review_item_details .= '</li>';

		// Return list item
		return $review_item_details;
	}

	// Create list items (with schema)
	function insprvw_item_details_schema( $class, $label, $itemprop, $value ) {
		// Create list item with details about review item
		$review_item_details_schema = '<li class="book-' . $class . '">';
		$review_item_details_schema .= '<span class="review-label">' . __( $label, 'inspire-reviews' ) . ':</span> ';
		$review_item_details_schema .= '<span class="review-value" itemprop="' . $itemprop . '">' . esc_html( $value ) . '</span>';
		$review_item_details_schema .= '</li>';

		// Return list item
		return $review_item_details_schema;
	}

	// Create list of book terms
	function insprvw_item_terms( $pid, $term, $class, $label, $itemprop ) {
		// Get the list of linked terns
		$term_list = get_the_term_list( $pid, $term, '', ', ' );

		// Create list item HTML
		$term_list_item = '<li class="book-' . $class . '">';
		$term_list_item .= '<span class="review-label">' . __( $label, 'inspire-reviews' ) . ':</span> ';
		$term_list_item .= '<span class="review-value" itemprop="' . $itemprop . '">' . $term_list . '</span>';
		$term_list_item .= '</li>';

		// Return term list item is there is terms
		if ( strlen( $term_list ) > 0 ) {
			return $term_list_item;
		}
	}	

	// Create links
	function insprvw_create_link( $class, $url, $text ) {
		return '<a class="' . $class . '" href="' . esc_url( $url ) . '" target="_blank">' . __( $text, 'inspire-reviews' ) . '</a>, ';
	}	