<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
    
    // Post array for all sections and fields
    $postMetaBoxes = array();

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-book-rating',
        'title'    => __( 'Book Rating', 'inspire-reviews' ),
        'page'     => 'insprvw-book-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Rating', 'inspire-reviews' ),
                'desc'     => __( 'The rating of the book for this review. Can be 0 - 5; decimals allowed.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-rating',
                'name'     => '_insprvw-book-rating',
                'type'     => 'text',
                'validate' => 'insprvw_sanitize_rating'
            )
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-book-information',
        'title'    => __( 'Book Information', 'inspire-reviews' ),
        'page'     => 'insprvw-book-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Title', 'inspire-reviews' ),
                'desc'     => __( 'The title of the book.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-title',
                'name'     => '_insprvw-book-title',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),
            array(
                'label'    => __( 'Series', 'inspire-reviews' ),
                'desc'     => __( 'The series the book is in if any.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-series',
                'name'     => '_insprvw-book-series',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'Publication Date', 'inspire-reviews' ),
                'desc'     => __( 'Date  of book\'s publication.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-pub-date',
                'name'     => '_insprvw-book-pub-date',
                'type'     => 'date',
                'validate' => 'insprvw_sanitize_date'
            ),               
            array(
                'label'    => __( 'Length', 'inspire-reviews' ),
                'desc'     => __( 'The length of the book.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-length',
                'name'     => '_insprvw-book-length',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),  
            array(
                'label'    => __( 'Binding', 'inspire-reviews' ),
                'desc'     => __( 'The binding of the book.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-binding',
                'name'     => '_insprvw-book-binding',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),  
            array(
                'label'    => __( 'Goodreads', 'inspire-reviews' ),
                'desc'     => __( 'URL to the books Goodread\'s page.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-goodreads',
                'name'     => '_insprvw-book-goodreads',
                'type'     => 'url',
                'validate' => 'esc_url'
            ), 
            array(
                'label'    => __( 'Synopsis', 'inspire-reviews' ),
                'desc'     => __( 'A short description or plot on the book.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-synopsis',
                'name'     => '_insprvw-book-synopsis',
                'type'     => 'textarea',
                'validate' => 'sanitize_text_field'
            )
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-buy-links',
        'title'    => __( 'Buy Links', 'inspire-reviews' ),
        'page'     => 'insprvw-book-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Amazon', 'inspire-reviews' ),
                'desc'     => __( 'URL to purchase the book on Amazon.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-amazon',
                'name'     => '_insprvw-book-amazon',
                'type'     => 'url',
                'validate' => 'esc_url'
            ),
            array(
                'label'    => __( 'Barnes & Noble', 'inspire-reviews' ),
                'desc'     => __( 'URL to purchase the book on Barnes & Noble.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-bn',
                'name'     => '_insprvw-book-bn',
                'type'     => 'url',
                'validate' => 'esc_url'
            ),
            array(
                'label'    => __( 'Kobo', 'inspire-reviews' ),
                'desc'     => __( 'URL to purchase the book on Kobo.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-kobo',
                'name'     => '_insprvw-book-kobo',
                'type'     => 'url',
                'validate' => 'esc_url'
            ),
            array(
                'label'    => __( 'iBook', 'inspire-reviews' ),
                'desc'     => __( 'URL to purchase the book on iBook.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-ibook',
                'name'     => '_insprvw-book-ibook',
                'type'     => 'url',
                'validate' => 'esc_url'
            ),
            array(
                'label'    => __( 'Google Play', 'inspire-reviews' ),
                'desc'     => __( 'URL to purchase the book on Google Play.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-gplay',
                'name'     => '_insprvw-book-gplay',
                'type'     => 'url',
                'validate' => 'esc_url'
            ),
            array(
                'label'    => __( 'Smashwords', 'inspire-reviews' ),
                'desc'     => __( 'URL to purchase the book on Smashwords.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-smashwords',
                'name'     => '_insprvw-book-smashwords',
                'type'     => 'url',
                'validate' => 'esc_url'
            )                                                            
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-movie-rating',
        'title'    => __( 'Movie Rating', 'inspire-reviews' ),
        'page'     => 'insprvw-movie-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Rating', 'inspire-reviews' ),
                'desc'     => __( 'The rating of the movie for this review. Can be 0 - 5; decimals allowed.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-rating',
                'name'     => '_insprvw-movie-rating',
                'type'     => 'text',
                'validate' => 'insprvw_sanitize_rating'
            )
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-movie-information',
        'title'    => __( 'Movie Information', 'inspire-reviews' ),
        'page'     => 'insprvw-movie-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Title', 'inspire-reviews' ),
                'desc'     => __( 'The title of the movie.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-title',
                'name'     => '_insprvw-movie-title',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),
            array(
                'label'    => __( 'Director', 'inspire-reviews' ),
                'desc'     => __( 'The director of the movie.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-director',
                'name'     => '_insprvw-movie-director',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'Screenwriter', 'inspire-reviews' ),
                'desc'     => __( 'The screenwriter of the movie.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-screenwriter',
                'name'     => '_insprvw-movie-screenwriter',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),                         
            array(
                'label'    => __( 'Release Date', 'inspire-reviews' ),
                'desc'     => __( 'Date of movie\'s release.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-release-date',
                'name'     => '_insprvw-book-release-date',
                'type'     => 'date',
                'validate' => 'insprvw_sanitize_date'
            ),  
            array(
                'label'    => __( 'Runtime', 'inspire-reviews' ),
                'desc'     => __( 'The runtime of the movie.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-runtime',
                'name'     => '_insprvw-movie-runtime',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),  
            array(
                'label'    => __( 'Synopsis', 'inspire-reviews' ),
                'desc'     => __( 'A short description or plot on the movie.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-synopsis',
                'name'     => '_insprvw-movie-synopsis',
                'type'     => 'textarea',
                'validate' => 'sanitize_text_field'
            )
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-show-rating',
        'title'    => __( 'Show Rating', 'inspire-reviews' ),
        'page'     => 'insprvw-show-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Rating', 'inspire-reviews' ),
                'desc'     => __( 'The rating of the show for this review. Can be 0 - 5; decimals allowed.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-rating',
                'name'     => '_insprvw-show-rating',
                'type'     => 'text',
                'validate' => 'insprvw_sanitize_rating'
            )
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-show-information',
        'title'    => __( 'Show Information', 'inspire-reviews' ),
        'page'     => 'insprvw-show-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Title', 'inspire-reviews' ),
                'desc'     => __( 'The title of the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-title',
                'name'     => '_insprvw-show-title',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),
            array(
                'label'    => __( 'Seasons', 'inspire-reviews' ),
                'desc'     => __( 'The number of seasons in the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-seasons',
                'name'     => '_insprvw-show-seasons',
                'type'     => 'text',
                'validate' => 'insprvw_sanitize_number'
            ),
            array(
                'label'    => __( 'Episodes', 'inspire-reviews' ),
                'desc'     => __( 'The number of episodes in the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-episodes',
                'name'     => '_insprvw-show-episodes',
                'type'     => 'text',
                'validate' => 'insprvw_sanitize_number'
            ),
            array(
                'label'    => __( 'Creator', 'inspire-reviews' ),
                'desc'     => __( 'The creator of the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-creator',
                'name'     => '_insprvw-show-creator',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'Network', 'inspire-reviews' ),
                'desc'     => __( 'The network the show is on.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-network',
                'name'     => '_insprvw-show-network',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),                         
            array(
                'label'    => __( 'Release Date', 'inspire-reviews' ),
                'desc'     => __( 'Date of show\'s release.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-release-date',
                'name'     => '_insprvw-show-release-date',
                'type'     => 'date',
                'validate' => 'insprvw_sanitize_date'
            ),   
            array(
                'label'    => __( 'Runtime', 'inspire-reviews' ),
                'desc'     => __( 'The runtime of the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-runtime',
                'name'     => '_insprvw-show-runtime',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),  
            array(
                'label'    => __( 'Synopsis', 'inspire-reviews' ),
                'desc'     => __( 'A short description or plot on the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-show-synopsis',
                'name'     => '_insprvw-show-synopsis',
                'type'     => 'textarea',
                'validate' => 'sanitize_text_field'
            )
        )
    );