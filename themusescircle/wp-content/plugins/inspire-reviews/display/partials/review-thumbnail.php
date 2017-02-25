<?php
	/**
	* Template for displaying review thumbnail
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 	
	// Check if thumbnail is available
	if ( has_post_thumbnail() ) {

		// Create thumbnail block
		$thumbnail_html = '<div class="entry-thumbnail">';
		$thumbnail_html .= '<div class="image-wrap image-wrap-border">' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>';
		$thumbnail_html .= '</div>';

		// Display thumbnail block
		echo $thumbnail_html;		
	}
?>