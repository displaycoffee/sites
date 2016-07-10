<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Get author term details
	$author_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$author_term_id = $author_term->term_id;

	// Get author meta
	$author_name = $author_term->name;
	$author_description = $author_term->description;
	$author_image = get_term_meta( $author_term_id, 'author-image', true );
	$author_website = get_term_meta( $author_term_id, 'author-website', true );
	$author_goodreads = get_term_meta( $author_term_id, 'author-goodreads', true );
	$author_facebook = get_term_meta( $author_term_id, 'author-facebook', true );
	$author_twitter = get_term_meta( $author_term_id, 'author-twitter', true );
	$author_pinterest = get_term_meta( $author_term_id, 'author-pinterest', true );
	$author_google = get_term_meta( $author_term_id, 'author-google', true );
	$author_tumblr = get_term_meta( $author_term_id, 'author-tumblr', true );	