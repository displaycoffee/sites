<?php
	/**
	* Template for displaying review footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer<?php echo ( current_user_can( 'edit_posts' ) ? ' edit-allowed' : '' ) ?>">
	<?php 
		// Get the categories and tags based on review type
		if ( get_post_type() == 'insprvw-book-review' ) {

			// Categories
			echo insprvw_term_list( $post->ID, 'insprvw-book-category', '<p class="categories"><strong>' . __( 'Categories', 'inspire-reviews' ) . ':</strong> ', ', ', '</p>' );

			// Tags
			echo insprvw_term_list( $post->ID, 'insprvw-book-tag', '<p class="tags"><strong>' . __( 'Tags', 'inspire-reviews' ) . ':</strong> ', ', ', '</p>' );
		} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {

			// Categories
			echo insprvw_term_list( $post->ID, 'insprvw-video-category', '<p class="categories"><strong>' . __( 'Categories', 'inspire-reviews' ) . ':</strong> ', ', ', '</p>' ); 

			// Tags	
			echo insprvw_term_list( $post->ID, 'insprvw-video-tag', '<p class="tags"><strong>' . __( 'Tags', 'inspire-reviews' ) . ':</strong> ', ', ', '</p>' ); 
		}

		// sharing buttons
		include INSPRVW_DIR . 'display/partials/sharing-buttons.php';

		// Display edit post link
		edit_post_link( __( 'Edit Content', 'inspire-reviews' ), '<p class="edit">', '</p>' );
	?>
</footer>