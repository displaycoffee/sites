<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Common movie meta that we'll need archive and single pages	
	$movie_title = get_post_meta( $post->ID, '_insprvw-movie-title', true );	
	$movie_director = get_post_meta( $post->ID, '_insprvw-movie-director', true );	
	$movie_release_date = get_post_meta( $post->ID, '_insprvw-movie-release-date', true );
	$movie_link = get_post_meta( $post->ID, '_insprvw-movie-link', true );

	// Movie information meta for single pages
	if ( is_single() ) {					
		$movie_rated = get_post_meta( $post->ID, '_insprvw-movie-rated', true );		
		$movie_hours = get_post_meta( $post->ID, '_insprvw-movie-hours', true );
		$movie_minutes = get_post_meta( $post->ID, '_insprvw-movie-minutes', true );
		$movie_screenwriter = get_post_meta( $post->ID, '_insprvw-movie-screenwriter', true );
		$movie_synopsis = get_post_meta( $post->ID, '_insprvw-movie-synopsis', true );	
	}