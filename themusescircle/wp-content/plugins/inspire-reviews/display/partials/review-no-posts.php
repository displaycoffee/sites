<?php
	/**
	* Template for displaying no reviews found
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div id="no-post" class="not-found">
	<p>
		<?php
			// Display different text for search versus other pages if no posts are found 
			if ( is_search() ) { 
				_e( 'No posts match your search.', 'inspire-reviews' );
			} else {
				_e( 'No posts found.', 'inspire-reviews' );
			}
		?>
	</p>
	<p><?php echo sprintf( __( 'Return to %1$s%2$s%3$s?', 'inspire-reviews' ), '<a href="', esc_url( home_url( '/' ) ), '">home</a>' ); ?></p>
</div>