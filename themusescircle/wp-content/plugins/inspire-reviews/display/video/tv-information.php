<?php
	/**
	* Template for displaying tv information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Include tv meta
	include( 'tv-post-meta.php' ); 
?>
<?php 
	// Check if we're on an archive versus single post	
	if ( is_archive() ) {

	} elseif ( is_single() ) {
		// Create list items of tv information
		$tv_list_item = $tv_title ? insprvw_item_details_schema( 'tv-title', 'Title', 'name', $tv_title ) : '';
		$tv_creator .= $tv_creator ? insprvw_item_details_schema( 'tv-creator', 'Creator', 'creator', $tv_creator ) : '';
		$tv_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-actor', 'tv-actors', 'Actors', 'actor' );
		$tv_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-genre', 'tv-genre', 'Genres', 'genre' );
		$tv_list_item .= insprvw_item_terms( $post->ID, 'insprvw-video-theme', 'tv-theme', 'Themes', 'genre' );
		$tv_list_item .= $tv_release_date ? insprvw_item_details_schema( 'tv-release-date', 'Release Date', 'dateCreated', $tv_release_date ) : '';
		$tv_list_item .= $tv_seasons ? insprvw_item_details_schema( 'tv-seasons', 'Seasons', 'numberOfSeasons', $tv_seasons ) : '';
		$tv_list_item .= $tv_episodes ? insprvw_item_details_schema( 'tv-episodes', 'Episodes', 'numberOfEpisodes', $tv_episodes ) : '';
		$tv_list_item .= $tv_runtime ? insprvw_item_details( 'tv-runtime', 'Runtime', $tv_runtime ) : '';
		$tv_list_item .= $tv_network ? insprvw_item_details( 'tv-network', 'Network', $tv_network ) : '';

		// Add tv link
		if ( $tv_link ) {
			$tv_list_item .= '<li class="tv-link">';
			$tv_list_item .= '<span class="review-label">Link:</span> ';
			$tv_list_item .= '<span class="review-value"><a itemprop="sameAs" href="' . esc_url( $tv_link ) . '" target="_blank">Link</a></span>';
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