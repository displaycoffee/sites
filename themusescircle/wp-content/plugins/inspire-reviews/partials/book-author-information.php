<?php
	/**
	* Template for displaying book author information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 
	// Create social media links
	function author_social( $class, $url, $text ) {
		return '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '" target="_blank">' . __( esc_html( $text ), 'inspire-reviews' ) . '</a>';
	}

	// Get author term details
	$author_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$author_term_id = $author_term->term_id;

	// Get author meta
	$author_name = $author_term->name;
	$author_description = $author_term->description;
	$author_image = get_term_meta( $author_term_id, 'author-image', true );
	$author_website = get_term_meta( $author_term_id, 'author-website', true );
	$author_goodreads = get_term_meta( $author_term_id, 'author-goodreads', true );
	$author_facebook = get_term_meta( $author_term_id, 'author-facebook', true );
	$author_twitter = get_term_meta( $author_term_id, 'author-twitter', true );
	$author_pinterest = get_term_meta( $author_term_id, 'author-pinterest', true );
	$author_google = get_term_meta( $author_term_id, 'author-google', true );
	$author_tumblr = get_term_meta( $author_term_id, 'author-tumblr', true );

	// Create author image HTML
	$author_image_html = '<div class="author-image">';
	$author_image_html .= '<div class="image-wrap"><img src="' . esc_url( $author_image ) . '" alt="' . esc_attr( $author_name ) . '" /></div>';
	$author_image_html .= '</div>';

	// Create author social HTML
	$author_social_html = '<div class="author-social">';
	$author_social_html .= $author_website ? author_social( 'website', $author_website, 'Website' ) : '';
	$author_social_html .= $author_goodreads ? author_social( 'goodreads', $author_goodreads, 'Goodreads' ) : '';
	$author_social_html .= $author_facebook ? author_social( 'facebook', $author_facebook, 'Facebook' ) : '';
	$author_social_html .= $author_twitter ? author_social( 'twitter', $author_twitter, 'Twitter' ) : '';
	$author_social_html .= $author_pinterest ? author_social( 'pinterest', $author_pinterest, 'Pinterest' ) : '';
	$author_social_html .= $author_google ? author_social( 'google', $author_google, 'Google+' ) : '';
	$author_social_html .= $author_tumblr ? author_social( 'tumblr', $author_tumblr, 'Tumblr' ) : '';
	$author_social_html .= '</div>';

	// Create author description HTML
	$author_description_html = '<div class="author-description">';
	$author_description_html .= wpautop( esc_html( $author_description ) );
	$author_description_html .= '</div>';

	// Create author display HTML
	$author_html = '<div class="author-information">';
	$author_html .= $author_image ? $author_image_html : '';
	$author_html .= '<div class="author-details">';
	$author_html .= $author_description ? $author_description_html : '';
	$author_html .= ( $author_social_html != '<div class="author-social"></div>' ) ? $author_social_html : '';
	$author_html .= '</div></div>';

	// Display final HTML
	echo $author_html;
?>