<?php
	/**
	* Template for displaying review navigation
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( $next || $previous ) {				
		// Start navigation html
		$single_navigation = '<nav class="navigation-links"><ul>';

		// Check if previous is there
		if ( $previous ) {
			$single_navigation .= '<li class="prev">' . get_previous_post_link( '%link', '<span class="icon icon-chevron-left"></span>' . __( '%title', 'inspire-reviews' ) ) . '</li>';
		}

		// Check if next is there
		if ( $next ) {
			$single_navigation .= '<li class="next">' . get_next_post_link( '%link', __( '%title', 'inspire-reviews' ) . '<span class="icon icon-chevron-right"></span>' ) . '</li>';
		}

		// End navigation html
		$single_navigation .= '</ul></nav>';	

		// Display navigation
		echo $single_navigation;
	}
?>