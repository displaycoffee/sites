<?php
	/**
	* Template for displaying review footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer">
	<?php 
		// Display list of book categories
		echo get_the_term_list( $post->ID, 'insprvw-book-category', '<div class="categories" itemprop="keywords"><strong>' . __( 'Categories', 'inspire-reviews' ) . ':</strong> ', ', ', '</div>' );

		// Display list of book genres
		echo get_the_term_list( $post->ID, 'insprvw-book-genre', '<div class="genres" itemprop="keywords"><strong>' . __( 'Genres', 'inspire-reviews' ) . ':</strong> ', ', ', '</div>' );

		// Display list of book tags
		echo get_the_term_list( $post->ID, 'insprvw-book-tag', '<div class="tags" itemprop="keywords"><strong>' . __( 'Tags', 'inspire-reviews' ) . ':</strong> ', ', ', '</div>' );
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
		}
	?>
</footer>