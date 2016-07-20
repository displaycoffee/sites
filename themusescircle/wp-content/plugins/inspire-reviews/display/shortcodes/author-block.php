<?php
	/**
	* Shortcode to display book author information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Loop through post type and create a shortcode for author information
	function insprvw_display_author( $atts ) {	
		// Get arguments for shortcode
	    $a = shortcode_atts( array(
	        'names' => '',
	        'title' => 'true',
	        'order' => 'asc'
	    ), $atts );	

	    // If there's no names defined, stop and don't do anything
	    if ( strlen( $a['names'] ) > 0 ) {
			// Create names array from comma separated list
			$names_array = explode( ',', $a['names'] );

			// Get arguments for shortcode (mostly name)
			$args = array(
				'name'       => $names_array,
			    'hide_empty' => false,
			    'order'      => $a['order']
			); 

			// Get term data for chosen names
			$author_terms = get_terms( 'insprvw-book-author', $args );

			// Create blank variable to store author block
			$author_html = '';

			// Loop through each author terms
			foreach ( $author_terms as $author ) {
				// Get author id
				$author_id = $author->term_id;

				// Get author meta
				$author_name = $author->name;
				$author_description = $author->description;
				$author_image = get_term_meta( $author_id, 'author-image', true );

				// Get author social media
				$author_website = get_term_meta( $author_id, 'author-website', true );
				$author_facebook = get_term_meta( $author_id, 'author-facebook', true );
				$author_gplus = get_term_meta( $author_id, 'author-gplus', true );
				$author_linkedin = get_term_meta( $author_id, 'author-linkedin', true );
				$author_twitter = get_term_meta( $author_id, 'author-twitter', true );
				$author_instagram = get_term_meta( $author_id, 'author-instagram', true );
				$author_youtube = get_term_meta( $author_id, 'author-youtube', true );
				$author_pinterest = get_term_meta( $author_id, 'author-pinterest', true );
				$author_tumblr = get_term_meta( $author_id, 'author-tumblr', true );
				$author_goodreads = get_term_meta( $author_id, 'author-goodreads', true );

				// Create author image block
				$author_image_html = '<div class="book-author-thumbnail">';
				$author_image_html .= '<div class="image-wrap"><img src="' . esc_url( $author_image ) . '" alt="' . esc_attr( $author_name ) . '" /></div>';
				$author_image_html .= '</div>';			

				// Create author social links
				$author_social_links = $author_website ? insprvw_create_link( 'website', $author_website, 'Website' ) : '';
				$author_social_links .= $author_facebook ? insprvw_create_link( 'facebook', $author_facebook, 'Facebook' ) : '';
				$author_social_links .= $author_gplus ? insprvw_create_link( 'gplus', $author_gplus, 'Google+' ) : '';
				$author_social_links .= $author_linkedin ? insprvw_create_link( 'linkedin', $author_linkedin, 'LinkedIn' ) : '';
				$author_social_links .= $author_twitter ? insprvw_create_link( 'twitter', $author_twitter, 'Twitter' ) : '';			
				$author_social_links .= $author_instagram ? insprvw_create_link( 'instagram', $author_instagram, 'Instagram' ) : '';
				$author_social_links .= $author_youtube ? insprvw_create_link( 'youtube', $author_youtube, 'YouTube' ) : '';
				$author_social_links .= $author_pinterest ? insprvw_create_link( 'pinterest', $author_pinterest, 'Pinterest' ) : '';
				$author_social_links .= $author_tumblr ? insprvw_create_link( 'goodreads', $author_pinterest, 'Goodreads' ) : '';
				$author_social_links .= $author_goodreads ? insprvw_create_link( 'tumblr', $author_pinterest, 'Tumblr' ) : '';

				// Create author social block
				$author_social_html = '<div class="book-author-social">';
				$author_social_html .= rtrim( $author_social_links, ', ' );
				$author_social_html .= '</div>';

				// Create author description block
				$author_description_html = '<div class="book-author-description">';
				$author_description_html .= wpautop( esc_textarea ( $author_description ) );
				$author_description_html .= '</div>';

				// Create author block - START
				$author_html .= '<div class="book-author">';
				$author_html .= $a['title'] == 'true' ? '<h3>' . __( 'About', 'inspire-reviews' ) . ' ' . $author_name . '</h3>' : '';
				$author_html .= $author_image ? $author_image_html : '';
				$author_html .= '<div class="book-author-details">';				
				$author_html .= $author_description ? $author_description_html : '';
				$author_html .= ( strlen( $author_social_links ) > 0 ) ? $author_social_html : '';
				$author_html .= '</div></div>';
			}
			
			// Display final author block
			return $author_html;
		}
	}
	add_shortcode( 'book-author', 'insprvw_display_author' );