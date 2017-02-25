<?php
	/**
	* Template for displaying book information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Title
	$title = insprvw_book_meta( $post->ID, 'title' );
	$title = $title ? insprvw_item_details( 'Title', $title ) : '';

	// Series
	$series = insprvw_book_meta( $post->ID, 'series' );
	$series = $series ? insprvw_item_details( 'Series', $series ) : '';

	// Isbn
	$isbn = insprvw_book_meta( $post->ID, 'isbn' );
	$isbn = $isbn ? insprvw_item_details( 'ISBN', $isbn ) : '';

	// Length
	$length = insprvw_book_meta( $post->ID, 'length' );
	$length = $length ? insprvw_item_details( 'Length', $length ) : '';

	// Binding
	$binding = insprvw_book_meta( $post->ID, 'binding' ); 
	$binding = $binding ? insprvw_item_details( 'Binding', $binding ) : '';

	// Publication date
	$pub_date = insprvw_book_meta( $post->ID, 'date' );

	// Update format of date
	if ( $pub_date ) {
		$pub_date_match = preg_match( '/(\d{2})\/(\d{2})\/(\d{4})/', $pub_date, $date_match );
		$pub_date = date( 'F', mktime( 0, 0, 0, $date_match[1] ) ) . ' ' . date( 'j', mktime( 0, 0, 0, $date_match[1], $date_match[2] ) ) . ', ' . $date_match[3];
		$pub_date = insprvw_item_details( 'Publication Date', $pub_date );
	}

	// Goodreads
	$goodreads = insprvw_book_meta( $post->ID, 'goodreads' );
	if ( $goodreads ) {
		$goodreads = '<li>';
		$goodreads .= '<span class="review-label">' . __( 'Goodreads', 'inspire-reviews' ) . ':</span> ';
		$goodreads .= '<span class="review-value"><a href="' . esc_url( $goodreads ) . '" target="_blank">Link</a></span>';
		$goodreads .= '</li>';
	}

	// Buy links	
	$buy_amazon = insprvw_book_meta( $post->ID, 'amazon' );
	$buy_amazon_paperback = insprvw_book_meta( $post->ID, 'amazonpb' );
	$buy_amazon_canada = insprvw_book_meta( $post->ID, 'amazonca' );
	$buy_amazon_uk = insprvw_book_meta( $post->ID, 'amazonuk' );
	$buy_bn = insprvw_book_meta( $post->ID, 'bn' );
	$buy_kobo = insprvw_book_meta( $post->ID, 'kobo' );
	$buy_ibook = insprvw_book_meta( $post->ID, 'ibook' );
	$buy_gplay = insprvw_book_meta( $post->ID, 'gplay' );
	$buy_smashwords = insprvw_book_meta( $post->ID, 'smashwords' );

	// Create list of buy links
	$buy_links = $buy_amazon ? insprvw_create_link( 'amazon', $buy_amazon, 'Amazon' ) : '';
	$buy_links .= $buy_amazon_paperback ? insprvw_create_link( 'amazon-paperback', $buy_amazon_paperback, 'Amazon Paperback' ) : '';
	$buy_links .= $buy_amazon_canada ? insprvw_create_link( 'amazon-canada', $buy_amazon_canada, 'Amazon Canada' ) : '';
	$buy_links .= $buy_amazon_uk ? insprvw_create_link( 'amazon-uk', $buy_amazon_uk, 'Amazon UK' ) : '';
	$buy_links .= $buy_bn ? insprvw_create_link( 'bn', $buy_bn, 'Barnes & Noble' ) : '';
	$buy_links .= $buy_kobo ? insprvw_create_link( 'kobo', $buy_kobo, 'Kobo' ) : '';
	$buy_links .= $buy_ibook ? insprvw_create_link( 'ibook', $buy_ibook, 'iBook' ) : '';
	$buy_links .= $buy_gplay ? insprvw_create_link( 'gplay', $buy_gplay, 'Google Play' ) : '';
	$buy_links .= $buy_smashwords ? insprvw_create_link( 'smashwords', $buy_smashwords, 'Smashwords' ) : '';

	// Create buy links list item
	if ( strlen( $buy_links ) > 0 ) {
		$buy_list_item = '<li>';
		$buy_list_item .= '<span class="review-label">' . __( 'Buy', 'inspire-reviews' ) . ':</span> ';
		$buy_list_item .= '<span class="review-value">' . rtrim( $buy_links, ', ' ) . '</span>';
		$buy_list_item .= '</li>';
	} else {
		$buy_list_item = '';
	}

	// Create book information block
	$book_information = '<ul class="book-information review-information">';
	$book_information .= $title;
	$book_information .= $series;
	$book_information .= insprvw_term_list( $post->ID, 'insprvw-book-author', '<li><span class="review-label">' . __( 'Author', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );
	$book_information .= $isbn;
	$book_information .= insprvw_term_list( $post->ID, 'insprvw-book-genre', '<li><span class="review-label">' . __( 'Genres', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );;
	$book_information .= $length;
	$book_information .= $binding;
	$book_information .= $pub_date;
	$book_information .= insprvw_term_list( $post->ID, 'insprvw-book-publisher', '<li><span class="review-label">' . __( 'Publisher', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );
	$book_information .= $goodreads;
	$book_information .= $buy_list_item;
	$book_information .= '</ul>';
	
	// Display book information block
	echo $book_information;

	// Display book synopsis
	$book_synopsis = insprvw_book_meta( $post->ID, 'synopsis' );
	echo $book_synopsis ? '<div class="book-synopsis review-synopsis"><h4>' . __( 'Synopsis', 'inspire-reviews' ) . '</h4>' . insprvw_display_shortcodes( wpautop( esc_textarea ( $book_synopsis ) ) ) . '</div>' : '';