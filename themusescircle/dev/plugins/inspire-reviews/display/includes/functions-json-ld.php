<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

    // Generate json-ld data for book schema
    function insprvw_book_json( $post ) {
		// Get the post author website and set fallback
		$author_website = get_the_author_meta( 'user_url' ) ? get_the_author_meta( 'user_url' ) : home_url( '/' ); 

		// Get list of book authors to grab websites
		$author_terms = get_the_terms( $post->ID, 'insprvw-book-author' );

		// Create an array to store book author websites
		$author_websites = array();

		// Loop through book autor term meta and push website values to array
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

		// Check for thumbnails
		if ( has_post_thumbnail() ) {
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[0];
		} else {	
			$thumbnail_src = plugins_url( 'inspire-reviews/assets/images/default-image-rectangle.png', '' );
		}

		// Set a comma sepator if there are category terms
		$categories = insprvw_term_list( $post->ID, 'insprvw-book-category', '', ', ', '' );
		$categories = $categories ? $categories . ', ' : '';

		// Get category and tags for keywords
		$keywords = $categories . insprvw_term_list( $post->ID, 'insprvw-book-tag', '', ', ', '' );

		// Update synopsis to remove possible shortcodes and shorten it
		$synopsis_remove = array( 'review-bold-italic', 'review-italic', 'review-bold', '[]', '[/]' );
		$synopsis_replace = '';
		$synopsis = wp_trim_words( str_replace( $synopsis_remove, $synopsis_replace, insprvw_book_meta( $post->ID, 'synopsis' ) ), 40 ); 
		   	
		// Create json-ld block - START
		$json_ld = '{';
		$json_ld .= '"@type": "Review",';
		$json_ld .= '"name": "' . esc_html( get_the_title() ) . '",';
		$json_ld .= '"url": "' . esc_url( get_the_permalink() ) . '",';

		// Post author
		$json_ld .= '"author": {';
		$json_ld .= '"@type": "Person",';
		$json_ld .= '"name": "' . esc_html( get_the_author() ) . '",';
		$json_ld .= '"sameAs": "' . esc_url( $author_website ) . '"';
		$json_ld .= '},';

		// Publisher
		$json_ld .= '"publisher": {';
		$json_ld .= '"@type": "Organization",';
		$json_ld .= '"name": "' . esc_html( get_bloginfo( 'name' ) ) . '"';
		$json_ld .= '},';

		// Dates
		$json_ld .= '"datePublished": "' . esc_html( get_the_time( get_option( 'date_format' ) ) ) . '",';
		$json_ld .= '"dateModified": "' . esc_html( get_the_modified_date( get_option( 'date_format' ) ) ) . '",';

		// Rating
		$json_ld .= '"reviewRating": {';
		$json_ld .= '"@type": "Rating",';
		$json_ld .= '"ratingValue": "' . esc_html( insprvw_book_meta( $post->ID, 'rating' ) ) . '",';
		$json_ld .= '"worstRating": "0",';
		$json_ld .= '"bestRating": "5"';
		$json_ld .= '},';

		// Keywords
		$json_ld .= '"keywords": "' . esc_html( rtrim( $keywords, ', ' ) ) . '",';

		// Description
		$json_ld .= '"description": "' . esc_html( substr( insprvw_excerpt( false ), 0, 192 ) ) . '...",';

		// Item type - Book
		$json_ld .= '"itemReviewed": {';
		$json_ld .= '"@type": "http://schema.org/Book",';
		$json_ld .= '"name": "' . esc_html( insprvw_book_meta( $post->ID, 'title' ) ) . '",';
		$json_ld .= '"position": "' . esc_html( insprvw_book_meta( $post->ID, 'series' ) ) . '",';
		$json_ld .= '"image": "' . esc_url( $thumbnail_src ) . '",';

		//  Item type - Book - author
		$json_ld .= '"author": {';
		$json_ld .= '"@type": "Person",';
		$json_ld .= '"name": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-book-author', '', ', ', '' ) ) . '",';
		$json_ld .= '"sameAs": "' . esc_html( join( ', ', $author_websites ) ) . '"';
		$json_ld .= '},';

		// Item type - Book
		$json_ld .= '"isbn": "' . esc_html( insprvw_book_meta( $post->ID, 'isbn' ) ) . '",';
		$json_ld .= '"genre": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-book-genre', '', ', ', '' ) ) . '",';
		$json_ld .= '"numberOfPages": "' . esc_html( insprvw_book_meta( $post->ID, 'length' ) ) . '",';
		$json_ld .= '"bookFormat": "' . esc_html( insprvw_book_meta( $post->ID, 'binding' ) ) . '",';
		$json_ld .= '"datePublished": "' . esc_html( insprvw_book_meta( $post->ID, 'date' ) ) . '",';
		$json_ld .= '"publisher": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-book-publisher', '', ', ', '' ) ) . '",';
		$json_ld .= '"description": "' . esc_html( $synopsis ) . '"';
		$json_ld .= '}';

		// Create json-ld block - END		
		$json_ld .= '}';

		return $json_ld;
	}