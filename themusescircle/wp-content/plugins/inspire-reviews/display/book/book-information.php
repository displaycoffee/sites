<?php
	/**
	* Template for displaying book information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Get the information about the author categories
	$author_terms = get_the_terms( $post->ID, 'insprvw-book-author' );

	// Create an array to store author websites
	$author_websites = array();

	// Loop through autor term meta and push website values to array
	if ( $author_terms ) {
		foreach ( $author_terms as $author ) {
			// Get term meta for author websites
			$author_website_meta = get_term_meta( $author->term_id, 'author-website', true );

			// Check if website meta is there and then push
			if ( $author_website_meta ) {
				array_push( $author_websites, $author_website_meta );
			} else {
				array_push( $author_websites, home_url( '/' ) );
			}
		}
	}
?>
<?php 
	$book_title = insprvw_book_meta( $post->ID, 'title' );
	$book_series = insprvw_book_meta( $post->ID, 'series' );
	$book_isbn = insprvw_book_meta( $post->ID, 'isbn' );
	$book_length = insprvw_book_meta( $post->ID, 'length' );
	$book_binding = insprvw_book_meta( $post->ID, 'binding' ); 
	$book_pub_date = insprvw_book_meta( $post->ID, 'date' );
	$book_goodreads = insprvw_book_meta( $post->ID, 'goodreads' );
	$book_buy_amazon = insprvw_book_meta( $post->ID, 'amazon' );
	$book_buy_amazon_paperback = insprvw_book_meta( $post->ID, 'amazonpb' );
	$book_buy_amazon_canada = insprvw_book_meta( $post->ID, 'amazonca' );
	$book_buy_amazon_uk = insprvw_book_meta( $post->ID, 'amazonuk' );
	$book_buy_bn = insprvw_book_meta( $post->ID, 'bn' );
	$book_buy_kobo = insprvw_book_meta( $post->ID, 'kobo' );
	$book_buy_ibook = insprvw_book_meta( $post->ID, 'ibook' );
	$book_buy_gplay = insprvw_book_meta( $post->ID, 'gplay' );
	$book_buy_smashwords = insprvw_book_meta( $post->ID, 'smashwords' );
	$book_synopsis = insprvw_book_meta( $post->ID, 'synopsis' );


	// Check if we're on an archive versus single post	
	if ( is_single() ) {
		// Create list items of book information
		$book_list_item = $book_title ? insprvw_item_details( 'Title', $book_title ) : '';
		$book_list_item .= $book_series ? insprvw_item_details( 'Series', $book_series ) : '';
		
		// Get list of author names
		$author_names = get_the_term_list( $post->ID, 'insprvw-book-author', '', ', ' );	

		// Add author list item
		if ( strlen( $author_names ) > 0 ) {
			$book_list_item .= '<li itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$book_list_item .= '<span class="review-label">' . __( 'Author', 'inspire-reviews' ) . ':</span> ';
			$book_list_item .= '<span class="review-value" itemprop="name">' . $author_names . '</span>';
			$book_list_item .= '<meta itemprop="sameAs" content="' . esc_attr( join( ', ', $author_websites ) ) . '">';
			$book_list_item .= '</li>';
		}

		// Update format of date
		if ( $book_pub_date ) {
			$book_pub_date_match = preg_match( '/(\d{2})\/(\d{2})\/(\d{4})/', $book_pub_date, $date_match );
			$book_pub_date_formatted = date( 'F', mktime( 0, 0, 0, $date_match[1] ) ) . ' ' . date( 'j', mktime( 0, 0, 0, $date_match[1], $date_match[2] ) ) . ', ' . $date_match[3];
		}
		
		// Continue list items of book information
		$book_list_item .= $book_isbn ? insprvw_item_details( 'ISBN', $book_isbn ) : '';
		$book_list_item .= insprvw_term_list( $post->ID, 'insprvw-book-genre', '<li><span class="review-label">' . __( 'Genres', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );
		$book_list_item .= $book_length ? insprvw_item_details( 'Length', $book_length ) : '';
		$book_list_item .= $book_binding ? insprvw_item_details( 'Binding', $book_binding ) : '';
		$book_list_item .= $book_pub_date ? insprvw_item_details( 'Publication Date', $book_pub_date_formatted ) : '';
		$book_list_item .= insprvw_term_list( $post->ID, 'insprvw-book-publisher', '<li><span class="review-label">' . __( 'Publisher', 'inspire-reviews' ) . ':</span> <span class="review-value">', ', ', '</span>' );

		// Add goodreads link
		if ( $book_goodreads ) {
			$book_list_item .= '<li>';
			$book_list_item .= '<span class="review-label">' . __( 'Goodreads', 'inspire-reviews' ) . ':</span> ';
			$book_list_item .= '<span class="review-value"><a href="' . esc_url( $book_goodreads ) . '" target="_blank">Link</a></span>';
			$book_list_item .= '</li>';
		}

		// Create buy links
		$book_buy_links = $book_buy_amazon ? insprvw_create_link( 'amazon', $book_buy_amazon, 'Amazon' ) : '';
		$book_buy_links .= $book_buy_amazon_paperback ? insprvw_create_link( 'amazon-paperback', $book_buy_amazon_paperback, 'Amazon Paperback' ) : '';
		$book_buy_links .= $book_buy_amazon_canada ? insprvw_create_link( 'amazon-canada', $book_buy_amazon_canada, 'Amazon Canada' ) : '';
		$book_buy_links .= $book_buy_amazon_uk ? insprvw_create_link( 'amazon-uk', $book_buy_amazon_uk, 'Amazon UK' ) : '';
		$book_buy_links .= $book_buy_bn ? insprvw_create_link( 'bn', $book_buy_bn, 'Barnes & Noble' ) : '';
		$book_buy_links .= $book_buy_kobo ? insprvw_create_link( 'kobo', $book_buy_kobo, 'Kobo' ) : '';
		$book_buy_links .= $book_buy_ibook ? insprvw_create_link( 'ibook', $book_buy_ibook, 'iBook' ) : '';
		$book_buy_links .= $book_buy_gplay ? insprvw_create_link( 'gplay', $book_buy_gplay, 'Google Play' ) : '';
		$book_buy_links .= $book_buy_smashwords ? insprvw_create_link( 'smashwords', $book_buy_smashwords, 'Smashwords' ) : '';

		// Create buy links list item
		$book_buy_list_item = '<li>';
		$book_buy_list_item .= '<span class="review-label">' . __( 'Buy', 'inspire-reviews' ) . ':</span> ';
		$book_buy_list_item .= '<span class="review-value">';
		$book_buy_list_item .= rtrim( $book_buy_links, ', ' );
		$book_buy_list_item .= '</span>';
		$book_buy_list_item .= '</li>';
	
		// Display book information
		$book_info_list = '<ul class="book-information review-information">';
		$book_info_list .= $book_list_item;
		$book_info_list .= ( strlen( $book_buy_links ) > 0 ) ? $book_buy_list_item : '';
		$book_info_list .= '</ul>';
		echo $book_info_list;

		// Display book synopsis
		echo $book_synopsis ? '<div class="book-synopsis review-synopsis"><h4>' . __( 'Synopsis', 'inspire-reviews' ) . '</h4>' . insprvw_display_shortcodes( wpautop( esc_textarea ( $book_synopsis ) ) ) . '</div>' : '';
	}
?>