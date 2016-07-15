<?php
	/**
	* Template for displaying book information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Include book meta
	include( 'book-post-meta.php' ); 

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
	// Check if we're on an archive versus single post	
	if ( is_archive() ) {
		// Add title and isbn schema
		$book_schema = $book_title ? '<meta itemprop="name" content="' . esc_attr( $book_title ) . '">' : '';
		$book_schema .= $book_isbn ? '<meta itemprop="isbn" content="' . esc_attr( $book_isbn ) . '">' : '';

		// Create an array to store author names
		$author_names = array();

		// Loop through autor term meta and push name values to array
		if ( $author_terms ) {
			foreach ( $author_terms as $author ) {
				// Get term meta for author names
				$author_name_meta = $author->name;

				// Check if names are there and then push
				if ( $author_name_meta ) {
					array_push( $author_names, $author_name_meta );
				}
			}
		}

		// Create author name meta if it is available
		if ( $author_names ) {
			$book_schema .= '<div itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$book_schema .= '<meta itemprop="name" content="' . esc_attr( join( ', ', $author_names ) ) . '">';
			$book_schema .= '<meta itemprop="sameAs" content="' . esc_attr( join( ', ', $author_websites ) ) . '">';
			$book_schema .= '</div>';
		}

		// Display book information
		echo $book_schema;
	} elseif ( is_single() ) {
		// Create list items of book information
		$book_list_item = $book_title ? insprvw_item_details_schema( 'book-title', 'Title', 'name', $book_title ) : '';
		$book_list_item .= $book_series ? insprvw_item_details_schema( 'book-series', 'Series', 'position', $book_series ) : '';
		
		// Get list of author names
		$author_names = get_the_term_list( $post->ID, 'insprvw-book-author', '', ', ' );	

		// Add author list item
		if ( strlen( $author_names ) > 0 ) {
			$book_list_item .= '<li class="book-author" itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$book_list_item .= '<span class="review-label">' . __( 'Author', 'inspire-reviews' ) . ':</span> ';
			$book_list_item .= '<span class="review-value" itemprop="name">' . $author_names . '</span>';
			$book_list_item .= '<meta itemprop="sameAs" content="' . esc_attr( join( ', ', $author_websites ) ) . '">';
			$book_list_item .= '</li>';
		}
		
		// Continue list items of book information
		$book_list_item .= $book_isbn ? insprvw_item_details_schema( 'book-isbn', 'ISBN', 'isbn', $book_isbn ) : '';		
		$book_list_item .= insprvw_item_terms( $post->ID, 'insprvw-book-genre', 'book-genre', 'Genres', 'genre' );		
		$book_list_item .= $book_length ? insprvw_item_details_schema( 'book-length', 'Length', 'numberOfPages', $book_length ) : '';
		$book_list_item .= $book_binding ? insprvw_item_details_schema( 'book-binding', 'Binding', 'bookFormat', $book_binding ) : '';
		$book_list_item .= $book_pub_date ? insprvw_item_details_schema( 'book-publication-date', 'Publication Date', 'datePublished', $book_pub_date ) : '';
		$book_list_item .= insprvw_item_terms( $post->ID, 'insprvw-book-publisher', 'book-publisher', 'Publisher', 'publisher' );

		// Add goodreads link
		if ( $book_goodreads ) {
			$book_list_item .= '<li class="book-goodreads">';
			$book_list_item .= '<span class="review-label">' . __( 'Goodreads', 'inspire-reviews' ) . ':</span> ';
			$book_list_item .= '<span class="review-value"><a href="' . esc_url( $book_goodreads ) . '" target="_blank">Link</a></span>';
			$book_list_item .= '</li>';
		}

		// Create buy links
		$book_buy_links = $book_buy_amazon ? insprvw_create_link( 'amazon', $book_buy_amazon, 'Amazon' ) : '';
		$book_buy_links .= $book_buy_bn ? insprvw_create_link( 'bn', $book_buy_bn, 'Barnes & Noble' ) : '';
		$book_buy_links .= $book_buy_kobo ? insprvw_create_link( 'kobo', $book_buy_kobo, 'Kobo' ) : '';
		$book_buy_links .= $book_buy_ibook ? insprvw_create_link( 'ibook', $book_buy_ibook, 'iBook' ) : '';
		$book_buy_links .= $book_buy_gplay ? insprvw_create_link( 'gplay', $book_buy_gplay, 'Google Play' ) : '';
		$book_buy_links .= $book_buy_smashwords ? insprvw_create_link( 'smashwords', $book_buy_smashwords, 'Smashwords' ) : '';

		// Create buy links list item
		$book_buy_list_item = '<li class="book-buy-links">';
		$book_buy_list_item .= '<span class="review-label">' . __( 'Buy', 'inspire-reviews' ) . ':</span> ';
		$book_buy_list_item .= '<span class="review-label">';
		$book_buy_list_item .= rtrim( $book_buy_links, ', ' );
		$book_buy_list_item .= '</span>';
		$book_buy_list_item .= '</li>';
	
		// Display book information
		$book_info_list = '<ul class="book-information">';
		$book_info_list .= $book_list_item;
		$book_info_list .= ( strlen( $book_buy_links ) > 0 ) ? $book_buy_list_item : '';
		$book_info_list .= '</ul>';
		echo $book_info_list;

		// Display book synopsis
		echo $book_synopsis ? '<div class="book-synopsis" itemprop="description">' . wpautop( esc_textarea ( $book_synopsis ) ) . '</div>' : '';
	}
?>