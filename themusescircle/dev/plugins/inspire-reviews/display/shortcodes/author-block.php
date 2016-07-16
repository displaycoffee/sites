<?php
	/**
	* Shortcode for display book author information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Loop through post type and create a shortcode for slider display
	function insprvw_display_author( $atts ) {	
		// Get arguments for shortcode
	    $a = shortcode_atts( array(
	        'names' => '',
	        'title' => 'true'
	    ), $atts );	

	    // If there's no names defined, stop and don't do anything
	    if ( strlen( $a['names'] ) > 0 ) {
			// Create names array from comma separated list
			$names_array = explode( ',', $a['names'] );

			// Get arguments for shortcode (mostly name)
			$args = array(
				'name'       => $names_array,
			    'hide_empty' => false
			); 

			// Get term data for chosen names
			$author_terms = get_terms( 'insprvw-book-author', $args );

			// Create blank variable to store author block
			$author_html = '';

			foreach ( $author_terms as $author ) {
				// Get author id
				$author_id = $author->term_id;

				// Get author meta
				$author_name = $author->name;
				$author_description = $author->description;
				$author_image = get_term_meta( $author_id, 'author-image', true );
				$author_website = get_term_meta( $author_id, 'author-website', true );
				$author_goodreads = get_term_meta( $author_id, 'author-goodreads', true );
				$author_facebook = get_term_meta( $author_id, 'author-facebook', true );
				$author_twitter = get_term_meta( $author_id, 'author-twitter', true );
				$author_pinterest = get_term_meta( $author_id, 'author-pinterest', true );
				$author_google = get_term_meta( $author_id, 'author-google', true );
				$author_tumblr = get_term_meta( $author_id, 'author-tumblr', true );

				// Create author image block
				$author_image_html = '<div class="author-image">';
				$author_image_html .= '<div class="image-wrap"><img src="' . esc_url( $author_image ) . '" alt="' . esc_attr( $author_name ) . '" /></div>';
				$author_image_html .= '</div>';			

				// Create author description block
				$author_description_html = '<div class="author-description">';
				$author_description_html .= wpautop( esc_textarea ( $author_description ) );
				$author_description_html .= '</div>';

				// Create author social links
				$author_social_links = $author_website ? insprvw_create_link( 'website', $author_website, 'Website' ) : '';
				$author_social_links .= $author_goodreads ? insprvw_create_link( 'goodreads', $author_goodreads, 'Goodreads' ) : '';
				$author_social_links .= $author_facebook ? insprvw_create_link( 'facebook', $author_facebook, 'Facebook' ) : '';
				$author_social_links .= $author_twitter ? insprvw_create_link( 'twitter', $author_twitter, 'Twitter' ) : '';
				$author_social_links .= $author_pinterest ? insprvw_create_link( 'pinterest', $author_pinterest, 'Pinterest' ) : '';
				$author_social_links .= $author_google ? insprvw_create_link( 'google', $author_google, 'Google+' ) : '';
				$author_social_links .= $author_tumblr ? insprvw_create_link( 'tumblr', $author_tumblr, 'Tumblr' ) : '';

				// Create author block - START
				$author_html .= '<div class="author-information">';
				$author_html .= $a['title'] == 'true' ? '<h3>' . __( 'About', 'inspire-reviews' ) . ' ' . $author_name . '</h3>' : '';
				$author_html .= $author_image ? $author_image_html : '';
				$author_html .= '<div class="author-details">';				
				$author_html .= $author_description ? $author_description_html : '';

				// Display author social links
				if ( strlen( $author_social_links ) > 0 ) {
					$author_html .= '<div class="author-social">';
					$author_html .= '<h4 class="social-title">' . __( 'Connect', 'inspire-reviews' ) . '</h4>';
					$author_html .= '<div class="social-list">' . rtrim( $author_social_links, ', ' ) . '</div>';
					$author_html .= '</div>';
				}

				// Create author block - END
				$author_html .= '</div></div>';
			}

			// Display final author block
			return $author_html;
		}
	}
	add_shortcode( 'book-author', 'insprvw_display_author' );