<?php
	/**
	* Template for displaying entry footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer">
	<div class="categories" itemprop="keywords">
		<?php _e( '<strong>Categories:</strong> ', 'themusescirle' ); ?><?php the_category( ', ' ); ?>
	</div>
	<?php echo the_tags( '<div class="tags" itemprop="keywords"><strong>Tags:</strong> ', ', ', '</div>' ); ?>
	<?php
		// Check if we're on a single post page
		if ( !is_single() ) {
			// Alter text based on number of comments or no comments
			if ( comments_open() ) {					
				echo '<div class="comments"><a href="' . esc_url( get_comments_link() ) . '">';
				comments_number( __( 'No comments', 'themusescirle' ), __( 'One comment', 'themusescirle' ), __( '% comments', 'themusescirle') );
				echo '</a></div>';
			}
		} else {
			edit_post_link( __( 'Edit', 'themusescirle' ), '<div class="edit">', '</div>' );
		}
	?>
</footer>