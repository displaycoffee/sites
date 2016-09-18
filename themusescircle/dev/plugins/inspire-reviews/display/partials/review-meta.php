<?php
	/**
	* Template for displaying review meta
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div class="entry-meta">
	<?php 
		// Create publisher block
		$publisher_schema = '<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
		$publisher_schema .= '<meta itemprop="name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
		$publisher_schema .= '</div>';

		// Display publisher block
		echo $publisher_schema;
	?>
	<?php 
		// Check if author is available
		if ( !is_author() ) {
			// Get the author website and set fallback
			$author_website = get_the_author_meta( 'user_url' ) ? get_the_author_meta( 'user_url' ) : home_url( '/' );

			// Create author block
			$author_schema = '<p class="author" itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$author_schema .= '<strong>' .  __( 'By', 'inspire-reviews' ) . ':</strong> ';
			$author_schema .= '<span itemprop="name">' .  get_the_author_posts_link() . '</span>';
			$author_schema .= '<meta itemprop="sameAs" content="' . esc_url( $author_website ) . '">';
			$author_schema .= '</p>';
			
			// Display author block
			echo $author_schema;
		}
	?>
	<span class="bullet">&bull;</span>
	<?php 
		// Display the date
		echo '<p class="date" itemprop="datePublished"><strong>' .  __( 'Date', 'inspire-reviews' ) . ':</strong> ' .  get_the_time( get_option( 'date_format' ) ) . '</p>';
	?>
	<span class="bullet">&bull;</span>
	<?php 
		// Set up star icons
		$star = '<span class="icon icon-star"></span>';

		// Get the review rating
		$review_rating = get_post_meta( $post->ID, '_insprvw-' . insprvw_review_type( true ) . '-rating', true );

		// Set values depending on whether or not a rating is set 
		if ( $review_rating || $review_rating == '0' ) {
			$rating_value = esc_html( $review_rating );
			$rating_width = ( esc_html( $review_rating ) * 20 ) . '%';
		} else {
			$rating_value = 0;
			$rating_width = 0 . '%';			
		}

		// Create rating block
		$rating_html = '<p class="rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">';
		$rating_html .= '<strong>' .  __( 'Rating', 'inspire-reviews' ) . ':</strong> ';
		$rating_html .= '<span class="rating-wrapper">';
		$rating_html .= '<span class="rating-text">' . $rating_value . ' out of 5</span>';
		$rating_html .= '<span class="rating-out-of" title="' . $rating_value . ' out of 5">';
		$rating_html .= $star . $star . $star . $star . $star;		
		$rating_html .= '<span class="rating-value" style="width: ' . $rating_width . '">' . $star . $star . $star . $star . $star . '</span>';		
		$rating_html .= '</span>';
		$rating_html .= '<meta itemprop="ratingValue" content="' . $rating_value . '">';
		$rating_html .= '<meta itemprop="worstRating" content="0">';
		$rating_html .= '<meta itemprop="bestRating" content="5">';
		$rating_html .= '</span>';

		// Display rating block
		echo $rating_html;
	?>
	<?php 
		// Display list of categories if not on single page
		if ( !is_single() ) {			
			echo get_the_term_list( $post->ID, 'insprvw-' . insprvw_review_type( false ) . '-category', '<p class="categories" itemprop="keywords"><strong>' . __( 'Categories', 'inspire-reviews' ) . ':</strong> ', ', ', '</p>' );
		}
	?>	
</div>