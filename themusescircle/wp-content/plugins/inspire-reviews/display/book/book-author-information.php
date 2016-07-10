<?php
	/**
	* Template for displaying author information
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Include book meta
	include( 'book-term-meta.php' ); 
?>
<?php 
	// Create author image block
	$author_image_html = '<div class="author-image">';
	$author_image_html .= '<div class="image-wrap"><img src="' . esc_url( $author_image ) . '" alt="' . esc_attr( $author_name ) . '" /></div>';
	$author_image_html .= '</div>';

	// Create author social links
	$author_social_links = $author_website ? insprvw_create_link( 'website', $author_website, 'Website' ) : '';
	$author_social_links .= $author_goodreads ? insprvw_create_link( 'goodreads', $author_goodreads, 'Goodreads' ) : '';
	$author_social_links .= $author_facebook ? insprvw_create_link( 'facebook', $author_facebook, 'Facebook' ) : '';
	$author_social_links .= $author_twitter ? insprvw_create_link( 'twitter', $author_twitter, 'Twitter' ) : '';
	$author_social_links .= $author_pinterest ? insprvw_create_link( 'pinterest', $author_pinterest, 'Pinterest' ) : '';
	$author_social_links .= $author_google ? insprvw_create_link( 'google', $author_google, 'Google+' ) : '';
	$author_social_links .= $author_tumblr ? insprvw_create_link( 'tumblr', $author_tumblr, 'Tumblr' ) : '';

	// Create author description block
	$author_description_html = '<div class="author-description">';
	$author_description_html .= wpautop( esc_textarea ( $author_description ) );
	$author_description_html .= '</div>';

	// Create author block
	$author_html = '<div class="author-information">';
	$author_html .= $author_image ? $author_image_html : '';
	$author_html .= '<div class="author-details">';
	$author_html .= $author_description ? $author_description_html : '';
	$author_html .= ( strlen( $author_social_links ) > 0 ) ? '<div class="author-social">' . rtrim( $author_social_links, ', ' ) . '</div>' : '';
	$author_html .= '</div></div>';

	// Display final author block
	echo $author_html;
?>