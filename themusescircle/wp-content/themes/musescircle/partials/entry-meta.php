<?php
	/**
	* Template for displaying entry meta
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div class="entry-meta">
	<?php 
		echo '<p class="author"><strong>' .  __( 'By', 'musescircle' ) . ':</strong> ' .  get_the_author_posts_link() . '</p>';
	?>
	<span class="bullet">&bull;</span>
	<?php 
		echo '<p class="date"><strong>' .  __( 'Date', 'musescircle' ) . ':</strong> ' .  get_the_time( get_option( 'date_format' ) ) . '</p>';
	?>
	<?php 
		// Don't display these top category lists on single pages
		if ( !is_single() ) {
			// Get post type to generate dyanmic categories
			$post_type = get_post_type();			

			// Check what type of post we're viewing and display the right categories (mostly setup for search archive)
			if ( $post_type == 'post' ) {
				echo musescircle_term_list( $post->ID, 'category', ', ', '<p class="categories"><strong>' . __( 'Categories', 'musescircle' ) . ':</strong> ', '</p>' );
			} else if ( $post_type == 'insprvw-book-review' ) {
				echo musescircle_term_list( $post->ID, 'insprvw-book-category', ', ', '<p class="categories"><strong>' . __( 'Categories', 'musescircle' ) . ':</strong> ', '</p>' );
			} else if ( $post_type == 'insprvw-movie-review' ||  $post_type == 'insprvw-tv-review' ) {
				echo musescircle_term_list( $post->ID, 'insprvw-video-category', ', ', '<p class="categories"><strong>' . __( 'Categories', 'musescircle' ) . ':</strong> ', '</p>' );
			} 
		}
	?>
</div>