<?php
	/**
	* Template for displaying review footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Set the type for what type of review page we're on
	if ( get_post_type() == 'insprvw-book-review' ) {
		$review_type_footer = 'book';
	} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
		$review_type_footer = 'video';
	} else {
		$review_type_footer = null;
	}
?>
<footer class="entry-footer">
	<?php 
		// Display list of categories
		echo get_the_term_list( $post->ID, 'insprvw-' . $review_type_footer . '-category', '<div class="categories" itemprop="keywords"><strong>' . __( 'Categories', 'inspire-reviews' ) . ':</strong> ', ', ', '</div>' );

		// Display list of tags
		echo get_the_term_list( $post->ID, 'insprvw-' . $review_type_footer . '-tag', '<div class="tags" itemprop="keywords"><strong>' . __( 'Tags', 'inspire-reviews' ) . ':</strong> ', ', ', '</div>' );
	?>
	<?php
		// Check if we're on a single post page
		if ( !is_single() ) {
			// Alter text based on number of comments or no comments
			if ( comments_open() ) {					
				echo '<div class="comments"><a href="' . esc_url( get_comments_link() ) . '">';
				comments_number( __( 'No comments', 'inspire-reviews' ), __( 'One comment', 'inspire-reviews' ), __( '% comments', 'inspire-reviews') );
				echo '</a></div>';
			}
		} else {
			edit_post_link( __('Edit', 'inspire-reviews'), '<div class="edit">', '</div>' );
		}
	?>
</footer>