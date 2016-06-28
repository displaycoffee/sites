<?php
	/**
	* Template for displaying book information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Common book meta that we'll need archive and single pages
	$book_isbn = get_post_meta( $post->ID, '_insprvw-book-isbn', true );
	$book_series = get_post_meta( $post->ID, '_insprvw-book-series', true );
	$book_title = get_post_meta( $post->ID, '_insprvw-book-title', true );		
?>
<?php 
	// Check if we're on an archive versus single post	
	if ( is_archive() ) {


	} elseif ( is_single() ) {
		// Create list items with schema
		function insprvw_book_item_details( $class, $label, $itemprop, $value ) {
			// Create list item with details about book
			$book_item_details = '<li class="book-' . $class . '">';
			$book_item_details .= '<span class="review-label">' . __( $label, 'inspire-reviews' ) . ':</span> ';
			$book_item_details .= '<span class="review-value" itemprop="' . $itemprop . '">' . esc_html( $value ) . '</span>';
			$book_item_details .= '</li>';

			// Return list item
			return $book_item_details;
		}

		// Create list of book terms
		function insprvw_book_item_terms( $pid, $term, $class, $label, $itemprop ) {
			// Get the list of linked terns
			$term_list = get_the_term_list( $pid, $term, '', ', ' );

			// Create list item HTML
			$term_list_item = '<li class="book-' . $class . '" itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$term_list_item .= '<span class="review-label">' . __( $label, 'inspire-reviews' ) . ':</span> ';
			$term_list_item .= '<span class="review-value" itemprop="' . $itemprop . '">' . $term_list . '</span>';
			$term_list_item .= '</li>';

			// Return term list item is there is terms
			if ( strlen( $term_list ) > 0 ) {
				return $term_list_item;
			}
		}

		// Book information meta for single pages
		$book_binding = get_post_meta( $post->ID, '_insprvw-book-binding', true );		
		$book_goodreads = get_post_meta( $post->ID, '_insprvw-book-goodreads', true );
		$book_length = get_post_meta( $post->ID, '_insprvw-book-length', true );
		$book_pub_date = get_post_meta( $post->ID, '_insprvw-book-pub-date', true );
		$book_synopsis = get_post_meta( $post->ID, '_insprvw-book-synopsis', true );

		// Create list items of book information
		$book_list_item = $book_title ? insprvw_book_item_details( 'title', 'Title', 'name', $book_title ) : '';
		$book_list_item .= $book_series ? insprvw_book_item_details( 'series', 'Series', 'position', $book_series ) : '';

		// Get list of author names
		$author_names = get_the_term_list( $post->ID, 'insprvw-book-author', '', ', ' );

		// Add author list item
		if ( strlen( $author_names ) > 0 ) {
			// Get the information about the author categories
			$author_terms = get_the_terms( $post->ID, 'insprvw-book-author' );

			// Create an array to store author websites
			$author_websites = array();

			// Loop through autor term meta and push website values to array
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

			// Tie together all author information
			$book_list_item .= '<li class="book-author" itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$book_list_item .= '<span class="review-label">Author:</span> ';
			$book_list_item .= '<span class="review-value" itemprop="name">' . $author_names . '</span>';
			$book_list_item .= '<meta itemprop="sameAs" content="' . esc_html( join( ', ', $author_websites ) ) . '">';
			$book_list_item .= '</li>';
		}
		
		$book_list_item .= $book_isbn ? insprvw_book_item_details( 'isbn', 'ISBN', 'isbn', $book_isbn ) : '';		
		$book_list_item .= insprvw_book_item_terms( $post->ID, 'insprvw-book-genre', 'genre', 'Genres', 'genre' );		
		$book_list_item .= $book_length ? insprvw_book_item_details( 'length', 'Length', 'numberOfPages', $book_length ) : '';
		$book_list_item .= $book_binding ? insprvw_book_item_details( 'binding', 'Binding', 'bookFormat', $book_binding ) : '';
		$book_list_item .= $book_pub_date ? insprvw_book_item_details( 'publication-date', 'Publication Date', 'datePublished', $book_pub_date ) : '';
		$book_list_item .= insprvw_book_item_terms( $post->ID, 'insprvw-book-publisher', 'publisher', 'Publisher', 'publisher' );

		// Add goodreads link
		if ( $book_goodreads ) {
			$book_list_item .= '<li class="book-goodreads">';
			$book_list_item .= '<span class="review-label">Goodreads:</span> ';
			$book_list_item .= '<span class="review-value"><a href="' . esc_url( $book_goodreads ) . '" target="_blank">Link</a></span>';
			$book_list_item .= '</li>';
		}

		// Create buy links
		function insprvw_book_buy_link( $class, $url, $text ) {
			return '<a class="' . $class . '" href="' . esc_url( $url ) . '" target="_blank">' . __( $text, 'inspire-reviews' ) . '</a>, ';
		}

		// Book buy links for single pages
		$book_buy_amazon = get_post_meta( $post->ID, '_insprvw-book-amazon', true );		
		$book_buy_bn = get_post_meta( $post->ID, '_insprvw-book-bn', true );
		$book_buy_kobo = get_post_meta( $post->ID, '_insprvw-book-kobo', true );
		$book_buy_ibook = get_post_meta( $post->ID, '_insprvw-book-ibook', true );
		$book_buy_gplay = get_post_meta( $post->ID, '_insprvw-book-gplay', true );
		$book_buy_smashwords = get_post_meta( $post->ID, '_insprvw-book-smashwords', true );

		// Create buy links
		$book_buy_links = $book_buy_amazon ? insprvw_book_buy_link( 'amazon', $book_buy_amazon, 'Amazon' ) : '';
		$book_buy_links .= $book_buy_bn ? insprvw_book_buy_link( 'bn', $book_buy_bn, 'Barnes & Noble' ) : '';
		$book_buy_links .= $book_buy_kobo ? insprvw_book_buy_link( 'kobo', $book_buy_kobo, 'Kobo' ) : '';
		$book_buy_links .= $book_buy_ibook ? insprvw_book_buy_link( 'ibook', $book_buy_ibook, 'iBook' ) : '';
		$book_buy_links .= $book_buy_gplay ? insprvw_book_buy_link( 'gplay', $book_buy_gplay, 'Google Play' ) : '';
		$book_buy_links .= $book_buy_smashwords ? insprvw_book_buy_link( 'smashwords', $book_buy_smashwords, 'Smashwords' ) : '';

		// Create buy links list item
		$book_buy_list_item = '<li class="book-buy-links">';
		$book_buy_list_item .= '<span class="review-label">' . __( 'Buy:', 'inspire-reviews' ) . '</span> ';
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