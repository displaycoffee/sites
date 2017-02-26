<?php
	/**
	* Template for displaying tv information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Title
	$title = insprvw_tv_meta( $post->ID, 'title' );
	$title = $title ? insprvw_item_details( 'Title', $title ) : '';

	// Creator
	$creator = insprvw_tv_meta( $post->ID, 'creator' );
	$creator = $creator ? insprvw_item_details( 'Creator', $creator ) : '';

	// Seasons
	$seasons = insprvw_tv_meta( $post->ID, 'seasons' );
	$seasons = $seasons ? insprvw_item_details( 'Seasons', $seasons ) : '';

	// Episodes
	$episodes = insprvw_tv_meta( $post->ID, 'episodes' );
	$episodes = $episodes ? insprvw_item_details( 'Episodes', $episodes ) : '';

	// Rated
	$rated = insprvw_tv_meta( $post->ID, 'rated' );
	$rated = $rated ? insprvw_item_details( 'Rated', $rated ) : '';	

	// TV link
	$link = insprvw_tv_meta( $post->ID, 'insprvw-tv-link' );
	if ( $link ) {
		$link = '<li>';
		$link .= '<span class="review-label">' . __( 'Link', 'inspire-reviews' ) . ':</span> ';
		$link .= '<span class="review-value"><a href="' . esc_url( $link ) . '" target="_blank">Link</a></span>';
		$link .= '</li>';
	}

	// Release date
	$release_date = insprvw_tv_meta( $post->ID, 'release-date' );

	// Update format of date
	if ( $release_date ) {
		$release_date_match = preg_match( '/(\d{2})\/(\d{2})\/(\d{4})/', $release_date, $date_match );
		$release_date = date( 'F', mktime( 0, 0, 0, $date_match[1] ) ) . ' ' . date( 'j', mktime( 0, 0, 0, $date_match[1], $date_match[2] ) ) . ', ' . $date_match[3];
		$release_date = insprvw_item_details( 'Release Date', $release_date );
	}

	// Network
	$network = insprvw_tv_meta( $post->ID, 'network' );
	$network = $network ? insprvw_item_details( 'Network', $network ) : '';	

	// Runtime - Hours
	$hours = insprvw_tv_meta( $post->ID, 'hours' );
	if ( $hours && $hours > 1 ) {
		$hours = $hours . ' ' . __( 'hours', 'inspire-reviews' );
	} else if ( $hours ) {
		$hours = $hours . ' ' . __( 'hour', 'inspire-reviews' );
	}

	// Runtime - Minutes
	$minutes = insprvw_tv_meta( $post->ID, 'minutes' );
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
	$tv_information = '<ul class="tv-information review-information">';
	$tv_information .= $title;
	$tv_information .= $creator;
	$tv_information .= $seasons;
	$tv_information .= $episodes;
	$tv_information .= insprvw_term_list( $post->ID, 'insprvw-video-actor', '<li><span class="review-label">' . __( 'Actors', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );
	$tv_information .= insprvw_term_list( $post->ID, 'insprvw-video-genre', '<li><span class="review-label">' . __( 'Genres', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );
	$tv_information .= insprvw_term_list( $post->ID, 'insprvw-video-theme', '<li><span class="review-label">' . __( 'Themes', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );	
	$tv_information .= $rated;
	$tv_information .= $link;
	$tv_information .= $release_date;
	$tv_information .= $network;
	$tv_information .= $runtime;
	$tv_information .= '</ul>';
	
	// Display TV information block
	echo $tv_information;

	// Display TV synopsis
	$synopsis = insprvw_tv_meta( $post->ID, 'synopsis' );
	echo $synopsis ? '<div class="tv-synopsis review-synopsis"><h4>' . __( 'Synopsis', 'inspire-reviews' ) . '</h4>' . insprvw_display_shortcodes( wpautop( esc_textarea ( $synopsis ) ) ) . '</div>' : '';