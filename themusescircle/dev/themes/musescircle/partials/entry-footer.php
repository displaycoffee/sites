<?php
	/**
	* Template for displaying entry footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<footer class="entry-footer">
	<?php echo musescircle_create_category_list( $post->ID, 'category' ); ?>
	<?php echo the_tags( '<p class="tags" itemprop="keywords"><strong>' . __( 'Tags', 'musescircle' ) . ':</strong> ', ', ', '</p>' ); ?>
</footer>