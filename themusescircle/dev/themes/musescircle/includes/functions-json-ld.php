<?php
	/**
	* Functions for adding schema.org json-ld
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
    // Generate json-ld data for blog schema
    function musescircle_blog_json( $post ) {
		// Variables for thumbnails
		if ( has_post_thumbnail() ) {
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[0];
			$thumbnail_width = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[1];
			$thumbnail_height = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[2];
		} else {
			$thumbnail_src = get_template_directory_uri() . '/assets/images/default-image-square.png';
			$thumbnail_width = 700;
			$thumbnail_height = 700;					
		}		

		// Get category and tags for keywords
		$keywords = musescircle_term_list( $post->ID, 'category', '', ', ', '' ) . ', ' . musescircle_term_list( $post->ID, 'post_tag', '', ', ', '' );

		// Create json-ld block - START
		$json_ld = '{';
		$json_ld .= '"@type": "BlogPosting",';

		// Main entity 
		$json_ld .= '"mainEntityOfPage": {';
		$json_ld .= '"@type": "WebPage",';
		$json_ld .= '"@id": "' . esc_url( get_the_permalink() ) . '"';
		$json_ld .= '},';

		// Headline
		$json_ld .= '"headline": "' . esc_html( get_the_title() ) . '",';

		// Image
		$json_ld .= '"image": {';
		$json_ld .= '"@type": "ImageObject",';
		$json_ld .= '"url": "' . esc_url( $thumbnail_src ) . '",';
		$json_ld .= '"height": ' . esc_html( $thumbnail_height ) . ',';
		$json_ld .= '"width": ' . esc_html( $thumbnail_width ) . '';
		$json_ld .= '},';

		// Dates
		$json_ld .= '"datePublished": "' . esc_html( get_the_time( get_option( 'date_format' ) ) ) . '",';
		$json_ld .= '"dateModified": "' . esc_html( get_the_modified_date( get_option( 'date_format' ) ) ) . '",';

		// Author
		$json_ld .= '"author": {';
		$json_ld .= '"@type": "Person",';
		$json_ld .= '"name": "' . esc_html( get_the_author() ) . '"';
		$json_ld .= '},';

		// Publisher
		$json_ld .= '"publisher": {';
		$json_ld .= '"@type": "Organization",';
		$json_ld .= '"name": "' . esc_html( get_bloginfo( 'name' ) ) . '",';
		$json_ld .= '"logo": {';
		$json_ld .= '"@type": "ImageObject",';
		$json_ld .= '"url": "' . esc_url( get_template_directory_uri() . '/assets/images/publisher-logo.png' ) . '",';
		$json_ld .= '"width": 600,';
		$json_ld .= '"height": 60';
		$json_ld .= '}';
		$json_ld .= '},';

		// Keywords
		$json_ld .= '"keywords": "' . esc_html( rtrim( $keywords, ', ' ) ) . '",';

		// Text / description
		$json_ld .= '"text": "' . esc_html( musescircle_excerpt( false ) ) . '"';

		// Create json-ld block - END		
		$json_ld .= '}';

		return $json_ld;
	}	