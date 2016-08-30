<?php
	/**
	* Template for displaying front page "Recent Reviews" section
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Grab all the variables we need for this page	
	$recent_reviews_hide = get_theme_mod( 'musescircle_recent_reviews_hide' );
	$recent_reviews_title = get_theme_mod( 'musescircle_recent_reviews_title' );
	$recent_reviews_number = get_theme_mod( 'musescircle_recent_reviews_number' );
	$recent_reviews_hide_books = get_theme_mod( 'musescircle_recent_reviews_hide_books' );
	$recent_reviews_hide_movies = get_theme_mod( 'musescircle_recent_reviews_hide_movies' );
	$recent_reviews_hide_tv = get_theme_mod( 'musescircle_recent_reviews_hide_tv' );
?>
<?php 
	// Create default type array for reviews
	$recent_reviews_types = 'insprvw-book-review, insprvw-movie-review, insprvw-tv-review';

	// Remove book reviews if checked
	if ( $recent_reviews_hide_books ) {
		$recent_reviews_types = str_replace ( 'insprvw-book-review, ', '', $recent_reviews_types );
	}

	// Remove movie reviews if checked
	if ( $recent_reviews_hide_movies ) {
		$recent_reviews_types = str_replace ( 'insprvw-movie-review, ', '', $recent_reviews_types );
	}	

	// Remove tv reviews if checked
	if ( $recent_reviews_hide_tv ) {
		$recent_reviews_types = str_replace ( 'insprvw-tv-review', '', $recent_reviews_types );
	}	

	// Create "Recent Review" block
	$recent_reviews_section = '<section id="recent-reviews"><div class="wrapper">';
	$recent_reviews_section .= '<h2>';
	$recent_reviews_section .= $recent_reviews_title ? esc_html( $recent_reviews_title ) : __( 'Recent Reviews', 'musescircle' );
	$recent_reviews_section .= '</h2>';		
	$recent_reviews_section .= do_shortcode( '[recent-reviews amount="' . ( $recent_reviews_number ? esc_html( $recent_reviews_number ) : 15 ) . '" types="' . $recent_reviews_types . '"]' );		
	$recent_reviews_section .= '</div></section>';

	// Display "Recent Review" section (only if not marked as hidden)
	if ( !$recent_reviews_hide ) {
		echo $recent_reviews_section;
	}
?>