<?php
	/**
	* Template for displaying review meta
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div class="entry-meta">
	<?php 
		// Check if author is available
		if ( !is_author() ) {

			// Create author block
			$author_html = '<p class="author">';
			$author_html .= '<strong>' .  __( 'By', 'inspire-reviews' ) . ':</strong> ';
			$author_html .= '<span>' .  get_the_author_posts_link() . '</span>';
			$author_html .= '</p>';
			
			// Display author block
			echo $author_html;
		}
	?>
	<span class="bullet">&bull;</span>
	<?php 
		// Display the date
		echo '<p class="date"><strong>' .  __( 'Date', 'inspire-reviews' ) . ':</strong> ' .  get_the_time( get_option( 'date_format' ) ) . '</p>';
	?>
	<?php 
		// Display bullet if on single page
		if ( is_single() ) {			
			echo '<span class="bullet">&bull;</span>';
		}
	?>	
	<?php 
		// Set up star icons
		$star = '<span class="icon icon-star"></span>';

		// Get the rating based on review type
		if ( get_post_type() == 'insprvw-book-review' ) {
			$review_rating = insprvw_book_meta( $post->ID, 'rating' );
		} else if ( get_post_type() == 'insprvw-movie-review' ) {
			$review_rating = insprvw_movie_meta( $post->ID, 'rating' ); 	
		} else if ( get_post_type() == 'insprvw-tv-review' ) {
			$review_rating = insprvw_tv_meta( $post->ID, 'rating' ); 	 
		} else {
			$review_rating = ''; 
		}

		// Set values depending on whether or not a rating is set 
		if ( $review_rating || $review_rating == '0' ) {
			$rating_value = esc_html( $review_rating );
			$rating_width = ( esc_html( $review_rating ) * 20 ) . '%';
		} else {
			$rating_value = 0;
			$rating_width = 0 . '%';			
		}

		// Create rating block
		$rating_html = '<p class="rating">';
		$rating_html .= '<strong>' .  __( 'Rating', 'inspire-reviews' ) . ':</strong> ';
		$rating_html .= '<span class="rating-wrapper">';
		$rating_html .= '<span class="rating-text">' . $rating_value . ' out of 5</span>';
		$rating_html .= '<span class="rating-out-of" title="' . $rating_value . ' out of 5">';
		$rating_html .= $star . $star . $star . $star . $star;		
		$rating_html .= '<span class="rating-value" style="width: ' . $rating_width . '">' . $star . $star . $star . $star . $star . '</span>';		
		$rating_html .= '</span>';
		$rating_html .= '</span>';

		// Display rating block
		echo $rating_html;
	?>
	<?php 
		// Display list of categories if not on single page
		if ( !is_single() ) {		

			// Get the categories based on review type
			if ( get_post_type() == 'insprvw-book-review' ) {
				echo insprvw_term_list( $post->ID, 'insprvw-book-category', ', ', '<p class="categories"><strong>' . __( 'Categories', 'musescircle' ) . ':</strong> ', '</p>' );
			} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
				echo insprvw_term_list( $post->ID, 'insprvw-video-category', ', ', '<p class="categories"><strong>' . __( 'Categories', 'musescircle' ) . ':</strong> ', '</p>' ); 	
			}
		}
	?>	
</div>