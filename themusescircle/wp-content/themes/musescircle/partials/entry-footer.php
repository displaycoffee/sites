<?php
	/**
	* Template for displaying entry footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer<?php echo ( current_user_can( 'edit_posts' ) ? ' edit-allowed' : '' ) ?>">
	<?php 
		// Display list of categories
		echo musescircle_term_list( $post->ID, 'category', ', ', '<p class="categories"><strong>' . __( 'Categories', 'musescircle' ) . ':</strong> ', '</p>' );
		
		// Display list of tags
		echo musescircle_term_list( $post->ID, 'post_tag', ', ', '<p class="tags"><strong>' . __( 'Tags', 'musescircle' ) . ':</strong> ', '</p>' );

		// sharing buttons
		get_template_part( 'partials/sharing', 'buttons' );

		// Display edit post link
		edit_post_link( __( 'Edit Content', 'musescircle' ), '<p class="edit">', '</p>' );
	?>
</footer>