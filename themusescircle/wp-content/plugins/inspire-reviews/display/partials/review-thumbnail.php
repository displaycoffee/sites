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
		// Thumbnail image src for schema
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
		
		// Create thumbnail block
		$thumbnail_html = '<div class="entry-thumbnail" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';	
		$thumbnail_html .= '<meta itemprop="url" content="' . esc_url( $thumbnail_src ) . '">';
		$thumbnail_html .= '<div class="image-wrap">' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>';	
		$thumbnail_html .= '</div>';	
	} else {	
		// Create thumbnail block
		$thumbnail_html = '<div class="entry-thumbnail" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';	
		$thumbnail_html .= '<meta itemprop="url" content="' . esc_url ( plugins_url( 'inspire-reviews/assets/images/default-image.svg', '' ) ) . '">';
		$thumbnail_html .= '<div class="image-wrap default-image">';
		$thumbnail_html .= '<svg viewBox="0 0 400 400"><use xlink:href="' . plugins_url( 'inspire-reviews/assets/images/default-image.svg#default-image', '' ) . '"></use></svg>';
		$thumbnail_html .= '</div></div>';	
	}

	// Display thumbnail block
	echo $thumbnail_html;	
?>