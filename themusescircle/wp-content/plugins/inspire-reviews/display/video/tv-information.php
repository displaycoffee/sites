<?php
	/**
	* Template for displaying tv information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Include tv meta
	include INSPRVW_DIR . 'display/video/tv-post-meta.php';
?>
<?php 
	// Check if we're on an archive versus single post	
	if ( is_archive() || is_page( 'All Reviews' ) || is_page( 'all-reviews' ) ) {
		// Add title
		$tv_schema = $tv_title ? '<meta itemprop="name" content="' . esc_attr( $tv_title ) . '">' : '';
		$tv_schema .= $tv_creator ? '<meta itemprop="creator" content="' . esc_attr( $tv_creator ) . '">' : '';
		$tv_schema .= $tv_link ? '<meta itemprop="sameAs" content="' . esc_url( $tv_link ) . '">' : '';
		$tv_schema .= $tv_release_date ? '<meta itemprop="dateCreated" content="' . esc_attr( $tv_release_date ) . '">' : '';

		// Display movie information
		echo $tv_schema;
	} elseif ( is_single() ) {
		// Create list items of tv information
		$tv_list_item = $tv_title ? insprvw_item_details_schema( 'tv-title', 'Title', 'name', $tv_title ) : '';
		$tv_list_item .= $tv_creator ? insprvw_item_details_schema( 'tv-creator', 'Creator', 'creator', $tv_creator ) : '';
		$tv_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-actor', 'tv-actors', 'Actors', 'actor' );
		$tv_list_item .= $tv_seasons ? insprvw_item_details_schema( 'tv-seasons', 'Seasons', 'numberOfSeasons', $tv_seasons ) : '';
		$tv_list_item .= $tv_episodes ? insprvw_item_details_schema( 'tv-episodes', 'Episodes', 'numberOfEpisodes', $tv_episodes ) : '';
		$tv_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-genre', 'tv-genre', 'Genres', 'genre' );
		$tv_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-theme', 'tv-theme', 'Themes', 'genre' );
		$tv_list_item .= $tv_rated ? insprvw_item_details_schema( 'tv-rated', 'Rated', 'contentRating', $tv_rated ) : '';	

		// Add tv link
		if ( $tv_link ) {
			$tv_list_item .= '<li class="tv-link">';
			$tv_list_item .= '<span class="review-label">' . __( 'Link', 'inspire-reviews' ) . ':</span> ';
			$tv_list_item .= '<span class="review-value"><a itemprop="sameAs" href="' . esc_url( $tv_link ) . '" target="_blank">Link</a></span>';
			$tv_list_item .= '</li>';
		}

		// Continue list items of tv information
		$tv_list_item .= $tv_release_date ? insprvw_item_details_schema( 'tv-release-date', 'Release Date', 'dateCreated', $tv_release_date ) : '';
		$tv_list_item .= $tv_network ? insprvw_item_details( 'tv-network', 'Network', $tv_network ) : '';

		// Add tv runtime
		if ( $tv_hours || $tv_minutes ) {
			// Plural and singular time conversions
			$hours = ( $tv_hours > 1 ) ? __( 'hours', 'inspire-reviews' ) : __( 'hour', 'inspire-reviews' );
			$minutes = ( $tv_minutes > 1 ) ? __( 'minutes', 'inspire-reviews' ) : __( 'minute', 'inspire-reviews' );

			// Conditional space if hours and minutes are available
			$spacing = ( $tv_hours || $tv_minutes ) ? ' ' : '';

			// Hours for display
			$tv_hours_display = $tv_hours ? $tv_hours . ' ' . $hours : '';

			// Minutes for display
			$tv_minutes_display = $tv_minutes ? $tv_minutes . ' ' . $minutes : '';

			// Display tv runtime block
			$tv_list_item .= '<li class="tv-runtime">';
			$tv_list_item .= '<span class="review-label">' . __( 'Runtime', 'inspire-reviews' ) . ':</span> ';
			$tv_list_item .= '<span class="review-value">' . esc_html( $tv_hours_display ) . $spacing . esc_html( $tv_minutes_display ) . '</span>';
			$tv_list_item .= '</li>';
		}
			
		// Display tv information
		$tv_info_list = '<ul class="tv-information">';
		$tv_info_list .= $tv_list_item;
		$tv_info_list .= '</ul>';
		echo $tv_info_list;

		// Display tv synopsis
		echo $tv_synopsis ? '<div class="tv-synopsis" itemprop="description">' . wpautop( esc_textarea ( $tv_synopsis ) ) . '</div>' : '';
	}
?>