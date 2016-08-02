<?php
	/**
	* Template for displaying movie information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Include movie meta
	include INSPRVW_DIR . 'display/video/movie-post-meta.php';
?>
<?php 
	// Check if we're on an archive versus single post	
	if ( is_archive() || is_page( 'All Reviews' ) || is_page( 'all-reviews' ) ) {
		// Add title
		$movie_schema = $movie_title ? '<meta itemprop="name" content="' . esc_attr( $movie_title ) . '">' : '';
		$movie_schema .= $movie_director ? '<meta itemprop="director" content="' . esc_attr( $movie_director ) . '">' : '';
		$movie_schema .= $movie_link ? '<meta itemprop="sameAs" content="' . esc_url( $movie_link ) . '">' : '';
		$movie_schema .= $movie_release_date ? '<meta itemprop="dateCreated" content="' . esc_attr( $movie_release_date ) . '">' : '';

		// Display movie information
		echo $movie_schema;
	} elseif ( is_single() ) {
		// Create list items of movie information
		$movie_list_item = $movie_title ? insprvw_item_details_schema( 'movie-title', 'Title', 'name', $movie_title ) : '';
		$movie_list_item .= $movie_director ? insprvw_item_details_schema( 'movie-director', 'Director', 'director', $movie_director ) : '';
		$movie_list_item .= $movie_screenwriter ? insprvw_item_details_schema( 'movie-screenwriter', 'Screenwriter', 'author', $movie_screenwriter ) : '';
		$movie_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-actor', 'movie-actors', 'Actors', 'actor' );
		$movie_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-genre', 'movie-genre', 'Genres', 'genre' );
		$movie_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-theme', 'movie-theme', 'Themes', 'genre' );		
		$movie_list_item .= $movie_rated ? insprvw_item_details_schema( 'movie-rated', 'Rated', 'contentRating', $movie_rated ) : '';		

		// Add movie link
		if ( $movie_link ) {
			$movie_list_item .= '<li class="movie-link">';
			$movie_list_item .= '<span class="review-label">' . __( 'Link', 'inspire-reviews' ) . ':</span> ';
			$movie_list_item .= '<span class="review-value"><a itemprop="sameAs" href="' . esc_url( $movie_link ) . '" target="_blank">Link</a></span>';
			$movie_list_item .= '</li>';
		}
	
		// Continue list items of movie information
		$movie_list_item .= $movie_release_date ? insprvw_item_details_schema( 'movie-release-date', 'Release Date', 'dateCreated', $movie_release_date ) : '';
		
		// Add movie runtime
		if ( $movie_hours || $movie_minutes ) {
			// Plural and singular time conversions
			$hours = ( $movie_hours > 1 ) ? __( 'hours', 'inspire-reviews' ) : __( 'hour', 'inspire-reviews' );
			$minutes = ( $movie_minutes > 1 ) ? __( 'minutes', 'inspire-reviews' ) : __( 'minute', 'inspire-reviews' );

			// Conditional space if hours and minutes are available
			$spacing = ( $movie_hours || $movie_minutes ) ? ' ' : '';

			// Hours for display and schema
			$movie_hours_display = $movie_hours ? $movie_hours . ' ' . $hours : '';
			$movie_hours_schema = $movie_hours ? $movie_hours . 'H': '';

			// Minutes for display and schema
			$movie_minutes_display = $movie_minutes ? $movie_minutes . ' ' . $minutes : '';
			$movie_minutes_schema = $movie_minutes ? $movie_minutes . 'M': '';

			// Display movie runtime block
			$movie_list_item .= '<li class="movie-runtime">';
			$movie_list_item .= '<meta itemprop="duration" content="' . esc_attr( $movie_hours_schema ) . esc_attr( $movie_minutes_schema ) . '" />';
			$movie_list_item .= '<span class="review-label">' . __( 'Runtime', 'inspire-reviews' ) . ':</span> ';
			$movie_list_item .= '<span class="review-value">' . esc_html( $movie_hours_display ) . $spacing . esc_html( $movie_minutes_display ) . '</span>';
			$movie_list_item .= '</li>';
		}		

		// Display movie information
		$movie_info_list = '<ul class="movie-information">';
		$movie_info_list .= $movie_list_item;
		$movie_info_list .= '</ul>';
		echo $movie_info_list;

		// Display movie synopsis
		echo $movie_synopsis ? '<div class="movie-synopsis" itemprop="description">' . insprvw_display_shortcodes( wpautop( esc_textarea ( $movie_synopsis ) ) ) . '</div>' : '';
	}
?>