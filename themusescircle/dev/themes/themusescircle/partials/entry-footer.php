<?php
	/**
	* Template for displaying post footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer">
	<div class="categories" itemprop="keywords">
		<?php _e( '<strong>Categories:</strong> ', 'themusescircle' ); ?><?php the_category( ', ' ); ?>
	</div>
	<?php echo the_tags( '<div class="tags" itemprop="keywords"><strong>Tags:</strong> ', ', ', '</div>' ); ?>
	<?php
		// Check if we're on a single post page
		if ( !is_single() ) {
			// Alter text based on number of comments or no comments
			if ( comments_open() ) {					
				echo '<div class="comments"><a href="' . esc_url( get_comments_link() ) . '">';
				comments_number( __( 'No comments', 'themusescircle' ), __( 'One comment', 'themusescircle' ), __( '% comments', 'themusescircle') );
				echo '</a></div>';
			}
		} else {
			edit_post_link( __('Edit', 'themusescircle'), '<div class="edit">', '</div>' );
		}
	?>
</footer>