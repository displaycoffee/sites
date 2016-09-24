<?php
	/**
	* Template for displaying entry footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer">
	<div class="categories" itemprop="keywords">
		<?php echo musescircle_create_category_list( $post->ID, 'category' ); ?>
	</div>
	<?php echo the_tags( '<div class="tags" itemprop="keywords"><strong>' . __( 'Tags', 'musescircle' ) . ':</strong> ', ', ', '</div>' ); ?>
	<?php
		// Check if we're on a single post page
		if ( is_single() ) {
			edit_post_link( __( 'Edit', 'musescircle' ), '<p class="edit">', '</p>' );
		}
	?>
</footer>