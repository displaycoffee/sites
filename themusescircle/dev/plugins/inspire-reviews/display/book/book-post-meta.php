<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Common book meta that we'll need archive and single pages
	$book_isbn = get_post_meta( $post->ID, '_insprvw-book-isbn', true );	
	$book_title = get_post_meta( $post->ID, '_insprvw-book-title', true );		

	if ( is_single() ) {
		// Book information meta for single pages
		$book_binding = get_post_meta( $post->ID, '_insprvw-book-binding', true );		
		$book_goodreads = get_post_meta( $post->ID, '_insprvw-book-goodreads', true );
		$book_length = get_post_meta( $post->ID, '_insprvw-book-length', true );
		$book_pub_date = get_post_meta( $post->ID, '_insprvw-book-pub-date', true );
		$book_series = get_post_meta( $post->ID, '_insprvw-book-series', true );
		$book_synopsis = get_post_meta( $post->ID, '_insprvw-book-synopsis', true );	

		// Book buy links for single pages
		$book_buy_amazon = get_post_meta( $post->ID, '_insprvw-book-amazon', true );		
		$book_buy_bn = get_post_meta( $post->ID, '_insprvw-book-bn', true );
		$book_buy_kobo = get_post_meta( $post->ID, '_insprvw-book-kobo', true );
		$book_buy_ibook = get_post_meta( $post->ID, '_insprvw-book-ibook', true );
		$book_buy_gplay = get_post_meta( $post->ID, '_insprvw-book-gplay', true );
		$book_buy_smashwords = get_post_meta( $post->ID, '_insprvw-book-smashwords', true );
	}