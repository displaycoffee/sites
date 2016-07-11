<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Common movie meta that we'll need archive and single pages	
	$movie_title = get_post_meta( $post->ID, '_insprvw-movie-title', true );		
	$movie_director = get_post_meta( $post->ID, '_insprvw-movie-director', true );
	$movie_link = get_post_meta( $post->ID, '_insprvw-movie-link', true );	
	$movie_mpaa_rating = get_post_meta( $post->ID, '_insprvw-movie-mpaa', true );
	$movie_release_date = get_post_meta( $post->ID, '_insprvw-movie-release-date', true );
	$movie_runtime = get_post_meta( $post->ID, '_insprvw-movie-runtime', true );
	$movie_screenwriter = get_post_meta( $post->ID, '_insprvw-movie-screenwriter', true );
	$movie_synopsis = get_post_meta( $post->ID, '_insprvw-movie-synopsis', true );	

	if ( is_single() ) {
	}