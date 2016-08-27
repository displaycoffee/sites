<?php
	/**
	* Template for displaying entry thumbnail
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 
	// Check if we're on a page or not
	if ( !is_page() || is_front_page() ) { 
		// Variables for thumbnail schema
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
		$thumbnail_width = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[1];
		$thumbnail_height = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[2];

		// If there's not a thumbnail, don't add thumbnail class
		$thumbnail_class = has_post_thumbnail() ? ' class="entry-thumbnail"' : '';

		// Create thumbnail block - START
		$thumbnail_html = '<div' . $thumbnail_class . ' itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';		

		// Check if there is a thumbnail
		if ( has_post_thumbnail() ) {
			$thumbnail_html .= '<meta itemprop="url" content="' . esc_url( $thumbnail_src ) . '">';
			$thumbnail_html .= '<meta itemprop="width" content="' . esc_attr( $thumbnail_width ) . '">';
			$thumbnail_html .= '<meta itemprop="height" content="' . esc_attr( $thumbnail_height ) . '">';
			$thumbnail_html .= '<div class="image-wrap">' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>';		
		} else {
			$thumbnail_html .= '<meta itemprop="url" content="' . esc_url( get_template_directory_uri() . '/assets/images/default-square-thumbnail.png' ) . '">';
			$thumbnail_html .= '<meta itemprop="width" content="400">';
			$thumbnail_html .= '<meta itemprop="height" content="400">';
			$thumbnail_html .= '<div class="image-wrap default-image">';
			$thumbnail_html .= '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/default-square-thumbnail.png' ) . '" width="400" height="400" alt="Image Coming Soon" />';	
			$thumbnail_html .= '</div>';	
		}

		// Create thumbnail block - END
		$thumbnail_html .= '</div>';

		// Display thumbnail block
		echo $thumbnail_html;
	} else if ( is_page() && has_post_thumbnail() ) {
		// Create thumbnail block
		$thumbnail_html = '<div class="entry-thumbnail">'; 
		$thumbnail_html .= '<div class="image-wrap">' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>';
		$thumbnail_html .= '</div>';

		// Display thumbnail block
		echo $thumbnail_html;
	}
?>