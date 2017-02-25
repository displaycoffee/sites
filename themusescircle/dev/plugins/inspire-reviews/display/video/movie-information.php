<?php
	/**
	* Template for displaying movie information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Title
	$title = insprvw_movie_meta( $post->ID, 'title' );
	$title = $title ? insprvw_item_details( 'Title', $title ) : '';

	// Director
	$director = insprvw_movie_meta( $post->ID, 'director' );
	$director = $director ? insprvw_item_details( 'Director', $director ) : '';

	// Screenwriter
	$screenwriter = insprvw_movie_meta( $post->ID, 'screenwriter' );
	$screenwriter = $screenwriter ? insprvw_item_details( 'Screenwriter', $screenwriter ) : '';

	// Rated
	$rated = insprvw_movie_meta( $post->ID, 'rated' );
	$rated = $rated ? insprvw_item_details( 'Rated', $rated ) : '';	

	// Movie link
	$link = insprvw_movie_meta( $post->ID, 'insprvw-movie-link' );
	if ( $link ) {
		$link = '<li>';
		$link .= '<span class="review-label">' . __( 'Link', 'inspire-reviews' ) . ':</span> ';
		$link .= '<span class="review-value"><a href="' . esc_url( $link ) . '" target="_blank">Link</a></span>';
		$link .= '</li>';
	}

	// Release date
	$release_date = insprvw_movie_meta( $post->ID, 'release-date' );

	// Update format of date
	if ( $release_date ) {
		$release_date_match = preg_match( '/(\d{2})\/(\d{2})\/(\d{4})/', $release_date, $date_match );
		$release_date = date( 'F', mktime( 0, 0, 0, $date_match[1] ) ) . ' ' . date( 'j', mktime( 0, 0, 0, $date_match[1], $date_match[2] ) ) . ', ' . $date_match[3];
		$release_date = insprvw_item_details( 'Release Date', $release_date );
	}

	// Runtime - Hours
	$hours = insprvw_movie_meta( $post->ID, 'hours' );
	if ( $hours && $hours > 1 ) {
		$hours = $hours . ' ' . __( 'hours', 'inspire-reviews' );
	} else if ( $hours ) {
		$hours = $hours . ' ' . __( 'hour', 'inspire-reviews' );
	}

	// Runtime - Minutes
	$minutes = insprvw_movie_meta( $post->ID, 'minutes' );
	if ( $minutes && $minutes > 1 ) {
		$minutes = $minutes . ' ' . __( 'minutes', 'inspire-reviews' );
	} else if ( $minutes ) {
		$minutes = $minutes . ' ' . __( 'minute', 'inspire-reviews' );
	}

	// Runtime joined
	$runtime = '';
	if ( $hours || $minutes ) {
		// Conditional space if hours and minutes are available
		$spacing = ( $hours || $minutes ) ? ' ' : '';

		$runtime .= '<li>';
		$runtime .= '<span class="review-label">' . __( 'Runtime', 'inspire-reviews' ) . ':</span> ';
		$runtime .= '<span class="review-value">' . esc_html( $hours ) . $spacing . esc_html( $minutes ) . '</span>';
		$runtime .= '</li>';		
	}

	// Create mobie information block
	$movie_information = '<ul class="movie-information review-information">';
	$movie_information .= $title;
	$movie_information .= $director;
	$movie_information .= $screenwriter;
	$movie_information .= insprvw_term_list( $post->ID, 'insprvw-video-actor', '<li><span class="review-label">' . __( 'Actors', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );
	$movie_information .= insprvw_term_list( $post->ID, 'insprvw-video-genre', '<li><span class="review-label">' . __( 'Genres', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );
	$movie_information .= insprvw_term_list( $post->ID, 'insprvw-video-theme', '<li><span class="review-label">' . __( 'Themes', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );	
	$movie_information .= $rated;
	$movie_information .= $link;
	$movie_information .= $release_date;
	$movie_information .= $runtime;
	$movie_information .= '</ul>';
	
	// Display movie information block
	echo $movie_information;

	// Display movie synopsis
	$synopsis = insprvw_movie_meta( $post->ID, 'synopsis' );
	echo $synopsis ? '<div class="movie-synopsis review-synopsis"><h4>' . __( 'Synopsis', 'inspire-reviews' ) . '</h4>' . insprvw_display_shortcodes( wpautop( esc_textarea ( $synopsis ) ) ) . '</div>' : '';