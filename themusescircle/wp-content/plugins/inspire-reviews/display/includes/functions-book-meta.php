<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Get meta for books
	function insprvw_book_meta( $id, $type ) {
		switch ( $type ) {
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