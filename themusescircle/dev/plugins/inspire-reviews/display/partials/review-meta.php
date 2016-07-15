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
			$author_schema .= '<span itemprop="name">' .  get_the_author_posts_link() . '</span>';
			$author_schema .= '<meta itemprop="sameAs" content="' . esc_url( $author_website ) . '">';
			$author_schema .= '</p>';
			
			// Display author block
			echo $author_schema;
		}
	?>
	<?php 
		// Display the date
		echo '<p class="date" itemprop="datePublished">' .  get_the_time( get_option( 'date_format' ) ) . '</p>';
	?>
	<?php 
		// Get the review rating
		$review_rating = get_post_meta( $post->ID, '_insprvw-' . insprvw_review_type( true ) . '-rating', true );

		// Create rating block
		$rating_html = '<p class="rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">';
		$rating_html .= ( $review_rating || $review_rating == '0' ) ? '<span class="rating-value" itemprop="ratingValue">' . esc_html( $review_rating ) . '</span>' : '<span class="rating-value" itemprop="worstRating">0</span>';
		$rating_html .= ' of <span class="rating-value" itemprop="bestRating">5</span></p>';

		// Display rating block
		echo $rating_html;
	?>
</div>