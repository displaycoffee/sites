<?php
	/**
	* Template for displaying review thumbnail
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 	
	// Check if thumbnail is available

	// If there's not a thumbnail, don't add thumbnail class
	$thumbnail_class = has_post_thumbnail() ? ' class="entry-thumbnail"' : '';

	// Create thumbnail block - START
	$thumbnail_html = '<div' . $thumbnail_class . ' itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';		

	if ( has_post_thumbnail() ) {
		// Thumbnail image src for schema
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];

		// Create thumbnail block
		$thumbnail_html .= '<meta itemprop="url" content="' . esc_url( $thumbnail_src ) . '">';
		$thumbnail_html .= '<div class="image-wrap image-wrap-border">' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</div>';	
	} else {	
		// Create thumbnail block
		$thumbnail_html .= '<meta itemprop="url" content="' . esc_url ( plugins_url( 'inspire-reviews/assets/images/default-image-rectangle.png', '' ) ) . '">';
	}

	// Create thumbnail block - END
	$thumbnail_html .= '</div>';

	// Display thumbnail block
	echo $thumbnail_html;
?>