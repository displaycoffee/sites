<?php
	/**
	* Template for displaying review footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer">
	<?php 
		// Display list of categories
		echo get_the_term_list( $post->ID, 'insprvw-' . insprvw_review_type( false ) . '-category', '<p class="categories" itemprop="keywords"><strong>' . __( 'Categories', 'inspire-reviews' ) . ':</strong> ', ', ', '</p>' );

		// Display list of tags
		echo get_the_term_list( $post->ID, 'insprvw-' . insprvw_review_type( false ) . '-tag', '<p class="tags" itemprop="keywords"><strong>' . __( 'Tags', 'inspire-reviews' ) . ':</strong> ', ', ', '</p>' );
	?>	
</footer>