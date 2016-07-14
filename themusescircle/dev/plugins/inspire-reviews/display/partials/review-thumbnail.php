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
		$thumbnail_html .= '<div class="image-wrap">' . get_the_post_thumbnail() . '</div>';	
		$thumbnail_html .= '</div>';	
	} else {	
		// Create thumbnail block
		$thumbnail_html = '<div class="entry-thumbnail" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';	
		$thumbnail_html .= '<meta itemprop="url" content="' . plugins_url( 'inspire-reviews/assets/images/default-portrait-thumbnail.jpg', '' ) . '">';
		$thumbnail_html .= '<div class="image-wrap default-image">';
		$thumbnail_html .= '<img width="400" height="600" src="' . plugins_url( 'inspire-reviews/assets/images/default-portrait-thumbnail.jpg', '' ) . '" alt="Image Coming Soon" />';	
		$thumbnail_html .= '</div></div>';	
	}

	// Display thumbnail block
	echo $thumbnail_html;	
?>