<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Get meta for books
	function insprvw_book_meta( $id, $type ) {
		switch ( $type ) {
			case 'rating':
				$meta = '_insprvw-book-rating'; break;

			case 'title':
				$meta = '_insprvw-book-title'; break;

			case 'isbn': 
				$meta = '_insprvw-book-isbn'; break;

			case 'binding':
				$meta = '_insprvw-book-binding'; break;
					
			case 'goodreads':
				$meta = '_insprvw-book-goodreads'; break;
			
			case 'length':
				$meta = '_insprvw-book-length'; break;
			
			case 'date':
				$meta = '_insprvw-book-pub-date'; break;
			
			case 'series':
				$meta = '_insprvw-book-series'; break;
			
			case 'synopsis':
				$meta = '_insprvw-book-synopsis'; break;
			
			case 'amazon':
				$meta = '_insprvw-book-amazon'; break;
					
			case 'amazonpb':
				$meta = '_insprvw-book-amazon-paperback'; break;
			
			case 'amazonca':
				$meta = '_insprvw-book-amazon-canada'; break;
			
			case 'amazonuk':
				$meta = '_insprvw-book-amazon-uk'; break;
			
			case 'bn':
				$meta = '_insprvw-book-bn'; break;
			
			case 'kobo':
				$meta = '_insprvw-book-kobo'; break;
			
			case 'ibook':
				$meta = '_insprvw-book-ibook'; break;
			
			case 'gplay':
				$meta = '_insprvw-book-gplay'; break;
			
			case 'smashwords':
				$meta = '_insprvw-book-smashwords'; break;

			default: 
				$meta = '';
		}
		
		return get_post_meta( $id, $meta, true );
	}

	// Get meta for movies
	function insprvw_movie_meta( $id, $type ) {
		switch ( $type ) {
			case 'rating':
				$meta = '_insprvw-movie-rating'; break;

			case 'title':
				$meta = '_insprvw-movie-title'; break;

			case 'director': 
				$meta = '_insprvw-movie-director'; break;

			case 'release-date':
				$meta = '_insprvw-movie-release-date'; break;
					
			case 'link':
				$meta = '_insprvw-movie-link'; break;
			
			case 'rated':
				$meta = '_insprvw-movie-rated'; break;
			
			case 'hours':
				$meta = '_insprvw-movie-hours'; break;
			
			case 'minutes':
				$meta = '_insprvw-movie-minutes'; break;
			
			case 'screenwriter':
				$meta = '_insprvw-movie-screenwriter'; break;
			
			case 'synopsis':
				$meta = '_insprvw-movie-synopsis'; break;

			default: 
				$meta = '';
		}
		
		return get_post_meta( $id, $meta, true );
	}	

	// Get meta for movies
	function insprvw_tv_meta( $id, $type ) {
		switch ( $type ) {
			case 'rating':
				$meta = '_insprvw-tv-rating'; break;

			case 'title':
				$meta = '_insprvw-tv-title'; break;

			case 'creator': 
				$meta = '_insprvw-tv-creator'; break;

			case 'release-date':
				$meta = '_insprvw-tv-release-date'; break;
					
			case 'link':
				$meta = '_insprvw-tv-link'; break;
			
			case 'seasons':
				$meta = '_insprvw-tv-seasons'; break;
			
			case 'episodes':
				$meta = '_insprvw-tv-episodes'; break;
			
			case 'network':
				$meta = '_insprvw-tv-network'; break;
			
			case 'rated':
				$meta = '_insprvw-tv-rated'; break;

			case 'hours':
				$meta = '_insprvw-tv-hours'; break;

			case 'minutes':
				$meta = '_insprvw-tv-minutes'; break;								
			
			case 'synopsis':
				$meta = '_insprvw-tv-synopsis'; break;

			default: 
				$meta = '';
		}
		
		return get_post_meta( $id, $meta, true );
	}		