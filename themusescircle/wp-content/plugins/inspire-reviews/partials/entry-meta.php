<?php
	/**
	* Template for displaying review meta
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div class="entry-meta">
	<?php 
		// Display the review rating
		$review_rating = get_post_meta( $post->ID, '_insprvw-book-rating', true );

		// Create rating display HTML
		$rating_html = '<p class="rating" itemprop="">';
		$rating_html .= ( $review_rating || $review_rating == '0' ) ? esc_html( $review_rating ) : '0';
		$rating_html .= ' of 5</p>';

		// Display rating HTML
		echo $rating_html;
	?>
	<?php 
		// Check if author is available
		if ( !is_author() ) {
			echo '<p class="author" itemprop="author">' .  get_the_author_posts_link() . '</p>';
		}
	?>
	<?php 
		// Display the date
		echo '<p class="date" itemprop="datePublished">' .  get_the_time( get_option( 'date_format' ) ) . '</p>';
	?>
</div>