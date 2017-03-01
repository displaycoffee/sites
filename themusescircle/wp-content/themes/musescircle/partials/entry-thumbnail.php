<?php
	/**
	* Template for displaying entry thumbnail
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 
	// Check if there is a thumbnail
	if ( has_post_thumbnail() ) {
		// Create thumbnail block
		$thumbnail_html = '<div class="entry-thumbnail">';		
		$thumbnail_html .= !is_single() ? '<a href="' . esc_url( get_the_permalink() ) . '">' : '';
		$thumbnail_html .= '<div class="image-wrap image-wrap-border">' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>';
		$thumbnail_html .= !is_single() ? '</a>' : '';
		$thumbnail_html .= '</div>';	

		// Display thumbnail block
		echo $thumbnail_html;
	}
?>