<?php
	/**
	* Template for displaying front page "Review Buttons" section
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Grab all the variables we need for this page	
	$review_buttons_hide = get_theme_mod( 'musescircle_review_buttons_hide' );
	$review_buttons_title = get_theme_mod( 'musescircle_review_buttons_title' );
	$review_buttons_book_url = get_theme_mod( 'musescircle_review_buttons_book_url' );
	$review_buttons_hide_books = get_theme_mod( 'musescircle_review_buttons_hide_books' );
	$review_buttons_movie_url = get_theme_mod( 'musescircle_review_buttons_movie_url' );
	$review_buttons_hide_movies = get_theme_mod( 'musescircle_review_buttons_hide_movies' );
	$review_buttons_tv_url = get_theme_mod( 'musescircle_review_buttons_tv_url' );
	$review_buttons_hide_tv = get_theme_mod( 'musescircle_review_buttons_hide_tv' );
	$review_buttons_everything_url = get_theme_mod( 'musescircle_review_buttons_everything_url' );
	$review_buttons_hide_everything = get_theme_mod( 'musescircle_review_buttons_hide_everything' );	
?>
<?php 
	// Create "Review Buttons" block - START
	$review_buttons_section = '<section id="review-buttons"><div class="wrapper">';
	$review_buttons_section .= '<h3>';
	$review_buttons_section .= $review_buttons_title ? esc_html( $review_buttons_title ) : __( 'Looking for more reviews?', 'musescircle' );
	$review_buttons_section .= '</h3>';

	// Check if book review button is not hidden
	if ( !$review_buttons_hide_books ) {
		$review_buttons_section .= '<a href="' . ( $review_buttons_book_url ? esc_url( $review_buttons_book_url ) : esc_url ( get_option( 'siteurl' ) . '/insprvw-book-review' ) ) . '" class="book button-simple">';
		$review_buttons_section .= __( 'Books', 'musescircle' );
		$review_buttons_section .= '</a>';	
	}

	// Check if movie review button is not hidden
	if ( !$review_buttons_hide_movies ) {
		$review_buttons_section .= '<a href="' . ( $review_buttons_movie_url ? esc_url( $review_buttons_movie_url ) : esc_url ( get_option( 'siteurl' ) . '/insprvw-movie-review' ) ) . '" class="movie button-simple">';
		$review_buttons_section .= __( 'Movies', 'musescircle' );
		$review_buttons_section .= '</a>';	
	}

	// Check if tv review button is not hidden
	if ( !$review_buttons_hide_tv ) {
		$review_buttons_section .= '<a href="' . ( $review_buttons_tv_url ? esc_url( $review_buttons_tv_url ) : esc_url ( get_option( 'siteurl' ) . '/insprvw-tv-review' ) ) . '" class="tv button-simple">';
		$review_buttons_section .= __( 'TV', 'musescircle' );
		$review_buttons_section .= '</a>';	
	}

	// Check if everything review button is not hidden
	if ( !$review_buttons_hide_everything ) {
		$review_buttons_section .= '<a href="' . ( $review_buttons_everything_url ? esc_url( $review_buttons_everything_url ) : esc_url ( get_option( 'siteurl' ) . '/all-reviews' ) ) . '" class="everything button-simple">';
		$review_buttons_section .= __( 'Everything', 'musescircle' );
		$review_buttons_section .= '</a>';	
	}						

	// Create "Review Buttons" block - END
	$review_buttons_section .= '</div></section>';

	// Display "Review Buttons" section (only if not marked as hidden)
	if ( !$review_buttons_hide ) {
		echo $review_buttons_section;
	}
?>