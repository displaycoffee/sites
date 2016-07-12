<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Common tv meta that we'll need archive and single pages	
	$tv_title = get_post_meta( $post->ID, '_insprvw-tv-title', true );		
	$tv_seasons = get_post_meta( $post->ID, '_insprvw-tv-seasons', true );
	$tv_episodes = get_post_meta( $post->ID, '_insprvw-tv-episodes', true );
	$tv_creator = get_post_meta( $post->ID, '_insprvw-tv-creator', true );
	$tv_network = get_post_meta( $post->ID, '_insprvw-tv-network', true );
	$tv_link = get_post_meta( $post->ID, '_insprvw-tv-link', true );	
	$tv_release_date = get_post_meta( $post->ID, '_insprvw-tv-release-date', true );
	$tv_runtime = get_post_meta( $post->ID, '_insprvw-tv-runtime', true );
	$tv_synopsis = get_post_meta( $post->ID, '_insprvw-tv-synopsis', true );	

	if ( is_single() ) {
	}