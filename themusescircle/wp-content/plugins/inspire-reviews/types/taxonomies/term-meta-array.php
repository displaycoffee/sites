<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
    
    // Term array for all sections and fields
    $termMetaBoxes = array();
 
    $termMetaBoxes[] = array(
        'category' => 'insprvw-book-author',
        'fields'   => array( 
            array(
                'label'    => __( 'Image', 'inspire-reviews' ),
                'desc'     => __( 'An image of the author.', 'inspire-reviews' ),
                'id'       => 'author-image',
                'name'     => 'author-image',
                'type'     => 'media',
                'validate' => 'esc_url',
                'column'   => 'no'
            ),  
            array(
                'label'    => __( 'Website', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s website.', 'inspire-reviews' ),
                'id'       => 'author-website',
                'name'     => 'author-website',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'yes'
            ), 
            array(
                'label'    => __( 'Facebook', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s Facebook.', 'inspire-reviews' ),
                'id'       => 'author-facebook',
                'name'     => 'author-facebook',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            ), 
            array(
                'label'    => __( 'Google+', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s Google+.', 'inspire-reviews' ),
                'id'       => 'author-gplus',
                'name'     => 'author-gplus',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            ), 
            array(
                'label'    => __( 'LinkedIn', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s LinkedIn.', 'inspire-reviews' ),
                'id'       => 'author-linkedin',
                'name'     => 'author-linkedin',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            ), 
            array(
                'label'    => __( 'Twitter', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s Twitter.', 'inspire-reviews' ),
                'id'       => 'author-twitter',
                'name'     => 'author-twitter',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            ),  
            array(
                'label'    => __( 'Instagram', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s Instagram.', 'inspire-reviews' ),
                'id'       => 'author-instagram',
                'name'     => 'author-instagram',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            ),  
            array(
                'label'    => __( 'YouTube', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s YouTube.', 'inspire-reviews' ),
                'id'       => 'author-youtube',
                'name'     => 'author-youtube',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            ),  
            array(
                'label'    => __( 'Pinterest', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s Pinterest.', 'inspire-reviews' ),
                'id'       => 'author-pinterest',
                'name'     => 'author-pinterest',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            ),
            array(
                'label'    => __( 'Tumblr', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s Tumblr.', 'inspire-reviews' ),
                'id'       => 'author-tumblr',
                'name'     => 'author-tumblr',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            ),              
            array(
                'label'    => __( 'Goodreads', 'inspire-reviews' ),
                'desc'     => __( 'URL of the author\'s Goodreads.', 'inspire-reviews' ),
                'id'       => 'author-goodreads',
                'name'     => 'author-goodreads',
                'type'     => 'url',
                'validate' => 'esc_url',
                'column'   => 'no'
            )          
        )
    );