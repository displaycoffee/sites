<?php
	/**
	* Template for displaying entry footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer">
	<div class="categories" itemprop="keywords">
		<?php _e( '<strong>Categories:</strong> ', 'musescircle' ); ?><?php the_category( ', ' ); ?>
	</div>
	<?php echo the_tags( '<div class="tags" itemprop="keywords"><strong>' . __( 'Tags', 'musescircle' ) . ':</strong> ', ', ', '</div>' ); ?>
	<?php
		// Check if we're on a single post page
		if ( !is_single() ) {
			// Alter text based on number of comments or no comments
			if ( comments_open() ) {					
				echo '<div class="comments"><a href="' . esc_url( get_comments_link() ) . '">';
				comments_number( __( 'No comments', 'musescircle' ), __( 'One comment', 'musescircle' ), __( '% comments', 'musescircle') );
				echo '</a></div>';
			}
		} else {
			edit_post_link( __( 'Edit', 'musescircle' ), '<div class="edit">', '</div>' );
		}
	?>
</footer>