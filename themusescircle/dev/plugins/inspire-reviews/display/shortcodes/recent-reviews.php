<?php
	/**
	* Shortcode to display recent reviews
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Loop through post type and create a shortcode for recent reviews
	function insprvw_recent_reviews( $atts ) {	
		// Default review types
		$default_types = array( 'insprvw-book-review', 'insprvw-movie-review', 'insprvw-tv-review' );

		// Get arguments for shortcode
	    $a = shortcode_atts( array(
	        'types'     => $default_types,
	        'amount'    => '5',
	        'thumbnail' => 'true',
	        'excerpt'   => 'true',
	        'line'      => 'true',
	        'orderby'   => '',
	        'order'     => ''
	    ), $atts );	

	    // Empty post type array
	    $review_types = array();

	    // Create a new query based on shortcode input
	    if ( gettype( $a['types'] ) == 'string' ) {
	    	// Check for book matches and push book post type
	    	if ( preg_match( '/(book)/', $a['types'] ) ) {
	    		array_push ( $review_types, 'insprvw-book-review' );
	    	}

	    	// Check for movie matches and push movie post type
	    	if ( preg_match( '/(movie)/', $a['types'] ) ) {
	    		array_push ( $review_types, 'insprvw-movie-review' );
	    	}

	    	// Check for tv matches and push tv post type
	    	if ( preg_match( '/\b(tv)\b/', $a['types'] ) || preg_match( '/(show)/', $a['types'] ) ) {
	    		array_push ( $review_types, 'insprvw-tv-review' );
	    	}
	    } else {
	    	$review_types = $a['types'];
	    }

    	// Query args
		$args = array(
			'post_type'      => $review_types ? $review_types : $default_types,
			'posts_per_page' => $a['amount'],
			'orderby'		 => $a['orderby'],
			'order'			 => $a['order']
		);
		$insprvw_query = new WP_Query( $args );	

		// Create empty review variable to store reviews from post loop below
		$review = '';

		// If the query has posts
		if ( $insprvw_query->have_posts() ) {	
			// Create review wrapper block - START			
			$recent_reviews = '<div class="insprvw-recent-reviews">';

			// While loop to query reviews
			while ( $insprvw_query->have_posts() ) {
				// Query the post
				$insprvw_query->the_post();
				$postID = get_the_ID();

				// Create date block
				$review_date = '<div class="review-date">';
				$review_date .= '<span class="month">' . get_the_date( 'M', $postID ) . ' </span>';
				$review_date .= '<span class="day">' . get_the_date( 'd', $postID ) . ', </span>';
				$review_date .= '<span class="year">' . get_the_date( 'Y', $postID ) . '</span>';
				$review_date .= '</div>';

				// Create thumbnail block - START
				$review_thumbnail = '<div class="review-thumbnail"><div class="image-wrap">';

				// Check if thumbnail is available
				if ( has_post_thumbnail() ) {				
					$review_thumbnail .= get_the_post_thumbnail( $postID, 'thumbnail' );
				} else {	
					$review_thumbnail .= '<svg viewBox="0 0 400 400"><use xlink:href="' . plugins_url( 'inspire-reviews/assets/images/default-image.svg#default-image', '' ) . '"></use></svg>';
				}

				// Create thumbnail block - END
				$review_thumbnail .= '</div></div>';

				// Create title block - START
				$review_title = '<div class="entry-title">';
				$review_title .= '<h4><a href="' . esc_url( get_the_permalink() ) . '">';

				// Create sub-title based on post type
				if ( get_post_type() == 'insprvw-book-review' ) {
					// Get book title meta 
					$book_title = get_post_meta( $postID, '_insprvw-book-title', true );
					
					// Break up the title based on a match from book title meta
					$new_title = str_replace( esc_html( $book_title ), '', get_the_title() );

					// If there is book title meta, display it
					$review_title .= '<span class="main-title">' . ( $book_title ? esc_html( $book_title ) : get_the_title() ) . '</span>';

					// Then display the sub-title
					$review_title .= '<span class="sub-title">' . $new_title . '</span>';	
				} else {
					$review_title .= '<span class="main-title">' . get_the_title() . '</span>';		
				}

				// Create title block - END
				$review_title .= '</a></h4>';
				$review_title .= '</div>';

				// Create single review block
				$review .= '<div id="review-' . esc_attr( $postID ) . '" class="review insprvw-review">';				
				$review .= $a['thumbnail'] == 'true' ? $review_thumbnail : '';
				$review .= $review_title;
				$review .= $review_date;
				$review .= $a['line'] == 'true' ? '<hr />' : '';
				$review .= $a['excerpt'] == 'true' ? '<div class="review-excerpt">' . insprvw_short_excerpt() . '</div>' : '';
				$review .= '</div>';
			}
			
			// Reset post data
			wp_reset_postdata();

			// Create review wrapper block - END
			$recent_reviews .= $review;
			$recent_reviews .= '</div>';

			// Display review wrapper block
			return $recent_reviews;
		}
	}
	add_shortcode( 'recent-reviews', 'insprvw_recent_reviews' );