<?php
	/**
	* Template for displaying review thumbnail
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 
	if ( has_post_thumbnail() ) {
		// Variables for display
		$thumbnail_main = 'entry-thumbnail';
		$thumbnail_wrap = 'image-wrap';
		$thumbnail_image = get_the_post_thumbnail();

		// Check if we're on a page or not
		if ( !is_page() ) { 
			// Start thumbnail html
			$thumbnail_start = '<div class="' . $thumbnail_main . '" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">'; 
			$thumbnail_start .= '<div class="' . $thumbnail_wrap . '">';
			$thumbnail_start .= $thumbnail_image;
			$thumbnail_start .= '</div>';
			$thumbnail_start .= '<meta itemprop="url" content="';
			echo $thumbnail_start;

			// Display the thumbnail url inside the meta tag
			esc_url( the_post_thumbnail_url() );

			// End thumbnail html
			$thumbnail_end = '">';
			$thumbnail_end .= '</div>';
			echo $thumbnail_end;
		} else if ( is_page() ) {
			$thumbnail_page = '<div class="' . $thumbnail_main . '"><div class="' . $thumbnail_wrap . '">'; 
			$thumbnail_page .= $thumbnail_image;
			$thumbnail_page .= '</div></div>';
			echo $thumbnail_page;
		}
	}
?>