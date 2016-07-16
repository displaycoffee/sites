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
	        'category' => '',
	        'posts'    => '5'
	    ), $atts );	

    	// Query args
		$args = array(
			'post_type'      => array( 'insprvw-book-review', 'insprvw-movie-review', 'insprvw-tv-review' ),
			'posts_per_page' => $a['posts']
			// 'tax_query' => array(
			// 	array(
			// 		'taxonomy' => 'insprvw-category',
			// 		'field'    => 'slug',
			// 		'terms'    => esc_attr( $a['category'] )
			// 	),
			// ),
		);
		$insprvw_query = new WP_Query( $args );	

		$recent_reviews = '';

		// If the query has posts
		if ( $insprvw_query->have_posts() ) {	

			$recent_reviews .= '<div class="insprvw-recent-reviews">';

			// While loop to query posts - for content and button
			while ( $insprvw_query->have_posts() ) {

				// Query the post
				$insprvw_query->the_post();
				$postID = get_the_ID();

				$recent_reviews .= '<div id="entry-' . esc_attr( $postID ) . '" class="entry insprvw-review">';
				$recent_reviews .= '<div class="date">';
				$recent_reviews .= '<span class="month">' .  get_the_date( 'M', $postID ) . ' </span>';
				$recent_reviews .= '<span class="day">' .  get_the_date( 'd', $postID ) . ', </span>';
				$recent_reviews .= '<span class="year">' .  get_the_date( 'Y', $postID ) . '</span>';
				$recent_reviews .= '</div>';
				$recent_reviews .= '</div>';
				
			}

			$recent_reviews .= '</div>';

			// Reset post data
			wp_reset_postdata();
		}

		return $recent_reviews;
	}
	add_shortcode( 'recent-reviews', 'insprvw_recent_reviews' );