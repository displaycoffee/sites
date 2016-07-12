<?php
	/**
	* Template for displaying movie information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Include movie meta
	include( 'movie-post-meta.php' ); 
?>
<?php 
	// Check if we're on an archive versus single post	
	if ( is_archive() ) {

	} elseif ( is_single() ) {
		// Create list items of movie information
		$movie_list_item = $movie_title ? insprvw_item_details_schema( 'movie-title', 'Title', 'name', $movie_title ) : '';
		$movie_list_item .= $movie_director ? insprvw_item_details_schema( 'movie-director', 'Director', 'director', $movie_director ) : '';
		$movie_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-actor', 'movie-actors', 'Actors', 'actor' );
		$movie_list_item .= $movie_mpaa_rating ? insprvw_item_details_schema( 'movie-mpaa-rating', 'MPAA Rating', 'contentRating', $movie_mpaa_rating ) : '';		
		$movie_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-genre', 'movie-genre', 'Genres', 'genre' );
		$movie_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-theme', 'movie-theme', 'Themes', 'genre' );
		$movie_list_item .= $movie_screenwriter ? insprvw_item_details_schema( 'movie-screenwriter', 'Screenwriter', 'author', $movie_screenwriter ) : '';
		$movie_list_item .= $movie_release_date ? insprvw_item_details_schema( 'movie-release-date', 'Release Date', 'dateCreated', $movie_release_date ) : '';
		$movie_list_item .= $movie_runtime ? insprvw_item_details_schema( 'movie-runtime', 'Runtime', 'duration', $movie_runtime ) : '';

		// Add movie link
		if ( $movie_link ) {
			$movie_list_item .= '<li class="movie-link">';
			$movie_list_item .= '<span class="review-label">Link:</span> ';
			$movie_list_item .= '<span class="review-value"><a itemprop="sameAs" href="' . esc_url( $movie_link ) . '" target="_blank">Link</a></span>';
			$movie_list_item .= '</li>';
		}
	
		// Display movie information
		$movie_info_list = '<ul class="movie-information">';
		$movie_info_list .= $movie_list_item;
		$movie_info_list .= '</ul>';
		echo $movie_info_list;

		// Display movie synopsis
		echo $movie_synopsis ? '<div class="movie-synopsis" itemprop="description">' . wpautop( esc_textarea ( $movie_synopsis ) ) . '</div>' : '';
	}
?>