<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
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
	    return '<div class="read-more"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read Review', 'inspire-reviews' ) . '</a></div>';
	}

	// Check if there is a custom excerpt and if so, make sure it's not too long
	function insprvw_excerpt( $html ) {

		// Set defauly message if there is no excerpt or page body text
		if ( strlen( get_the_excerpt() ) > 0 ) {
			$message = get_the_excerpt();
		} else {
			$message = __( 'For additional information, please read review.', 'inspire-reviews' );
		}	

		if ( $html == true ) {
			if ( has_excerpt() ) {	    
			    return '<p>' . wp_trim_words( get_the_excerpt(), 50 ) . '</p>' . insprvw_read_more();
			} else {
				return '<p>' . $message . '</p>' . insprvw_read_more();
			}
		} else {
			if ( has_excerpt() ) {	    
			    return wp_trim_words( get_the_excerpt(), 50 );
			} else {
				return $message;
			}			
		}
	}

	// Check if there is a custom excerpt and if so, make sure it's not too long
	function insprvw_short_excerpt() {
		return '<p>' . substr( get_the_excerpt(), 0, 125 ) . '...</p>' . insprvw_read_more();
	}

	// Create list items (without schema)
	function insprvw_item_details( $label, $value ) {
		// Create list item with details about review item
		$review_item_details = '<li>';
		$review_item_details .= '<span class="review-label">' . __( $label, 'inspire-reviews' ) . ':</span> ';
		$review_item_details .= '<span class="review-value">' . esc_html( $value ) . '</span>';
		$review_item_details .= '</li>';

		// Return list item
		return $review_item_details;
	}

	// Create list items (with schema)
	function insprvw_item_details_schema( $label, $itemprop, $value ) {
		// Create list item with details about review item
		$review_item_details_schema = '<li>';
		$review_item_details_schema .= '<span class="review-label">' . __( $label, 'inspire-reviews' ) . ':</span> ';
		$review_item_details_schema .= '<span class="review-value" itemprop="' . $itemprop . '">' . esc_html( $value ) . '</span>';
		$review_item_details_schema .= '</li>';

		// Return list item
		return $review_item_details_schema;
	}

	// Create list of book terms
	function insprvw_item_terms( $pid, $term, $label, $itemprop ) {
		// Get the list of linked terns
		$term_list = get_the_term_list( $pid, $term, '', ', ' );

		// Create list item HTML
		$term_list_item = '<li>';
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

	// Create taxonomy lists
	function insprvw_term_list( $id, $taxonomy, $before, $separator, $after ) {
		// Loop through categories and push to array
		$terms = get_the_terms( $id, $taxonomy ); 
		$display = '';
		$list = '';

		// Check if the terms are in an array and if the array is greater than or equal to 1
		if ( gettype( $terms ) == 'array' && count( $terms ) >= 1 ) {
			// Are both before and after defined?
			if ( $before && $after ) {
				// Use wordpress get_the_term list to display all html
				$display .= get_the_term_list( $id, $taxonomy, $before, $separator, $after );
			} else {
				foreach( $terms as $term ) {
					// Get each term name
					$list .= $term->name . esc_html( $separator );
				}

				$display .= rtrim( $list, $separator );
			}

			return $display;
		}		
	}