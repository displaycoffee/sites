<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Date for name and url
	function insprvw_json_name_url() {
		$name_url = '"name": "' . esc_html( get_the_title() ) . '",';
		$name_url .= '"url": "' . esc_url( get_the_permalink() ) . '",';		

		return $name_url;
	}

	// Data for post author
	function insprvw_json_post_author() {
		$author_website = get_the_author_meta( 'user_url' ) ? get_the_author_meta( 'user_url' ) : home_url( '/' );

		$post_author = '"author": {';
		$post_author .= '"@type": "Person",';
		$post_author .= '"name": "' . esc_html( get_the_author() ) . '",';
		$post_author .= '"sameAs": "' . esc_url( $author_website ) . '"';
		$post_author .= '},';	

		return $post_author;
	}

	// Data for publisher
	function insprvw_json_publisher() {
		$publisher = '"publisher": {';
		$publisher .= '"@type": "Organization",';
		$publisher .= '"name": "' . esc_html( get_bloginfo( 'name' ) ) . '"';
		$publisher .= '},';		

		return $publisher;
	}

	// Data for publisher
	function insprvw_json_dates() {
		$dates = '"datePublished": "' . esc_html( get_the_time( get_option( 'date_format' ) ) ) . '",';
		$dates .= '"dateModified": "' . esc_html( get_the_modified_date( get_option( 'date_format' ) ) ) . '",';	

		return $dates;
	}

	// Data for description
	function insprvw_json_description() {
		$description = '"description": "' . esc_html( substr( insprvw_excerpt( false ), 0, 192 ) ) . '...",';

		return $description;
	}

	// Date for thumbnails
	function insprvw_json_thumbnail( $post ) {		
		if ( has_post_thumbnail() ) {
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'large' )[0];
		} else {	
			$thumbnail_src = plugins_url( 'inspire-reviews/assets/images/default-image-rectangle.png', '' );
		}

		return $thumbnail_src;
	}


    // Generate json-ld data for book schema
    function insprvw_book_json( $post ) {
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
		$json_ld .= insprvw_json_name_url();
		$json_ld .= insprvw_json_post_author();
		$json_ld .= insprvw_json_publisher();
		$json_ld .= insprvw_json_dates();
		$json_ld .= insprvw_json_description();

		// Rating
		$json_ld .= '"reviewRating": {';
		$json_ld .= '"@type": "Rating",';
		$json_ld .= '"ratingValue": "' . esc_html( insprvw_book_meta( $post->ID, 'rating' ) ) . '",';
		$json_ld .= '"worstRating": "0",';
		$json_ld .= '"bestRating": "5"';
		$json_ld .= '},';

		// Keywords
		$json_ld .= '"keywords": "' . esc_html( rtrim( $keywords, ', ' ) ) . '",';

		// Item type - Book
		$json_ld .= '"itemReviewed": {';
		$json_ld .= '"@type": "http://schema.org/Book",';
		$json_ld .= '"name": "' . esc_html( insprvw_book_meta( $post->ID, 'title' ) ) . '",';
		$json_ld .= '"position": "' . esc_html( insprvw_book_meta( $post->ID, 'series' ) ) . '",';
		$json_ld .= '"image": "' . esc_url( insprvw_json_thumbnail( $post->ID ) ) . '",';

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

    // Generate json-ld data for book schema
    function insprvw_movie_json( $post ) {
		// Set a comma sepator if there are category terms
		$categories = insprvw_term_list( $post->ID, 'insprvw-video-category', '', ', ', '' );
		$categories = $categories ? $categories . ', ' : '';

		// Get category and tags for keywords
		$keywords = $categories . insprvw_term_list( $post->ID, 'insprvw-video-tag', '', ', ', '' );

		// Update synopsis to remove possible shortcodes and shorten it
		$synopsis_remove = array( 'review-bold-italic', 'review-italic', 'review-bold', '[]', '[/]' );
		$synopsis_replace = '';
		$synopsis = wp_trim_words( str_replace( $synopsis_remove, $synopsis_replace, insprvw_movie_meta( $post->ID, 'synopsis' ) ), 40 ); 
		   	
		// Create json-ld block - START
		$json_ld = '{';
		$json_ld .= '"@type": "Review",';
		$json_ld .= insprvw_json_name_url();
		$json_ld .= insprvw_json_post_author();
		$json_ld .= insprvw_json_publisher();
		$json_ld .= insprvw_json_dates();
		$json_ld .= insprvw_json_description();

		// Rating
		$json_ld .= '"reviewRating": {';
		$json_ld .= '"@type": "Rating",';
		$json_ld .= '"ratingValue": "' . esc_html( insprvw_movie_meta( $post->ID, 'rating' ) ) . '",';
		$json_ld .= '"worstRating": "0",';
		$json_ld .= '"bestRating": "5"';
		$json_ld .= '},';

		// Keywords
		$json_ld .= '"keywords": "' . esc_html( rtrim( $keywords, ', ' ) ) . '",';

		// Item type - Movie
		$json_ld .= '"itemReviewed": {';
		$json_ld .= '"@type": "http://schema.org/Movie",';
		$json_ld .= '"name": "' . esc_html( insprvw_movie_meta( $post->ID, 'title' ) ) . '",';
		$json_ld .= '"image": "' . esc_url( insprvw_json_thumbnail( $post->ID ) ) . '",';
		$json_ld .= '"director": "' . esc_html( insprvw_movie_meta( $post->ID, 'director' ) ) . '",';
		$json_ld .= '"author": "' . esc_html( insprvw_movie_meta( $post->ID, 'screenwriter' ) ) . '",';
		$json_ld .= '"actor": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-video-actor', '', ', ', '' ) ) . '",';
		$json_ld .= '"genre": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-video-genre', '', ', ', '' ) ) . '",';
		$json_ld .= '"genre": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-video-theme', '', ', ', '' ) ) . '",';
		$json_ld .= '"contentRating": "' . esc_html( insprvw_movie_meta( $post->ID, 'rated' ) ) . '",';
		$json_ld .= '"sameAs": "' . esc_html( insprvw_movie_meta( $post->ID, 'link' ) ) . '",';
		$json_ld .= '"dateCreated": "' . esc_html( insprvw_movie_meta( $post->ID, 'release-date' ) ) . '",';

		// Item type - Movie - Hours
		$hours = insprvw_movie_meta( $post->ID, 'hours' );
		$hours = $hours ? $hours . __( 'H', 'inspire-reviews' ) : '';

		// Item type - Movie - Minutes
		$minutes = insprvw_movie_meta( $post->ID, 'minutes' );
		$minutes = $minutes ? $minutes . __( 'M', 'inspire-reviews' ) : '';

		// Item type - Movie
		$json_ld .= '"duration": "' . esc_html( $hours . $minutes ) . '",';
		$json_ld .= '"description": "' . esc_html( $synopsis ) . '"';
		$json_ld .= '}';

		// Create json-ld block - END		
		$json_ld .= '}';

		return $json_ld;
	}

    // Generate json-ld data for book schema
    function insprvw_tv_json( $post ) {
		// Set a comma sepator if there are category terms
		$categories = insprvw_term_list( $post->ID, 'insprvw-video-category', '', ', ', '' );
		$categories = $categories ? $categories . ', ' : '';

		// Get category and tags for keywords
		$keywords = $categories . insprvw_term_list( $post->ID, 'insprvw-video-tag', '', ', ', '' );

		// Update synopsis to remove possible shortcodes and shorten it
		$synopsis_remove = array( 'review-bold-italic', 'review-italic', 'review-bold', '[]', '[/]' );
		$synopsis_replace = '';
		$synopsis = wp_trim_words( str_replace( $synopsis_remove, $synopsis_replace, insprvw_tv_meta( $post->ID, 'synopsis' ) ), 40 ); 
		   	
		// Create json-ld block - START
		$json_ld = '{';
		$json_ld .= '"@type": "Review",';
		$json_ld .= insprvw_json_name_url();
		$json_ld .= insprvw_json_post_author();
		$json_ld .= insprvw_json_publisher();
		$json_ld .= insprvw_json_dates();
		$json_ld .= insprvw_json_description();

		// Rating
		$json_ld .= '"reviewRating": {';
		$json_ld .= '"@type": "Rating",';
		$json_ld .= '"ratingValue": "' . esc_html( insprvw_tv_meta( $post->ID, 'rating' ) ) . '",';
		$json_ld .= '"worstRating": "0",';
		$json_ld .= '"bestRating": "5"';
		$json_ld .= '},';

		// Keywords
		$json_ld .= '"keywords": "' . esc_html( rtrim( $keywords, ', ' ) ) . '",';

		// Item type - TVSeries
		$json_ld .= '"itemReviewed": {';
		$json_ld .= '"@type": "http://schema.org/TVSeries",';
		$json_ld .= '"name": "' . esc_html( insprvw_tv_meta( $post->ID, 'title' ) ) . '",';
		$json_ld .= '"image": "' . esc_url( insprvw_json_thumbnail( $post->ID ) ) . '",';
		$json_ld .= '"creator": "' . esc_html( insprvw_tv_meta( $post->ID, 'creator' ) ) . '",';
		$json_ld .= '"actor": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-video-actor', '', ', ', '' ) ) . '",';
		$json_ld .= '"genre": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-video-genre', '', ', ', '' ) ) . '",';
		$json_ld .= '"genre": "' . esc_html( insprvw_term_list( $post->ID, 'insprvw-video-theme', '', ', ', '' ) ) . '",';
		$json_ld .= '"contentRating": "' . esc_html( insprvw_tv_meta( $post->ID, 'rated' ) ) . '",';
		$json_ld .= '"sameAs": "' . esc_html( insprvw_tv_meta( $post->ID, 'link' ) ) . '",';
		$json_ld .= '"dateCreated": "' . esc_html( insprvw_tv_meta( $post->ID, 'release-date' ) ) . '",';

		// Item type - TVSeries
		$json_ld .= '"description": "' . esc_html( $synopsis ) . '"';
		$json_ld .= '}';

		// Create json-ld block - END		
		$json_ld .= '}';

		return $json_ld;
	}