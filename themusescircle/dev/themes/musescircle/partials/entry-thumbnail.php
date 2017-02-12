<?php
	/**
	* Template for displaying entry thumbnail
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 
	// Variables for thumbnails
	$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' )[0];
	$thumbnail_src_large = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[0];
	$thumbnail_width = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' )[1];
	$thumbnail_height = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' )[2];

	// Check if we're on a page or not
	if ( !is_page() || is_front_page() ) { 
		// Check if there is a thumbnail
		if ( has_post_thumbnail() ) {
			// Create thumbnail block
			$thumbnail_html = '<div class="entry-thumbnail">';		
			$thumbnail_html .= '<div class="image-wrap image-wrap-border">' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>';
			$thumbnail_html .= '</div>';	

			// Display thumbnail block
			echo $thumbnail_html;			
		}
	} else if ( is_page() && has_post_thumbnail() ) {
		// Create thumbnail block
		$thumbnail_html = '<div class="entry-thumbnail">'; 
		$thumbnail_html .= '<div class="image-wrap image-wrap-border">' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>';
		$thumbnail_html .= '</div>';

		// Display thumbnail block
		echo $thumbnail_html;
	}
?>