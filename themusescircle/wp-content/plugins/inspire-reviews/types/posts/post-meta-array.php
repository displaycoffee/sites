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
                'label'    => __( 'ISBN', 'inspire-reviews' ),
                'desc'     => __( 'The 13 digit ISBN-13 of the book.', 'inspire-reviews' ),
                'id'       => '_insprvw-book-isbn',
                'name'     => '_insprvw-book-isbn',
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
                'desc'     => __( 'URL to the book\'s Goodreads page.', 'inspire-reviews' ),
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
                'validate' => 'insprvw_sanitize_textarea'
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
                'label'    => __( 'Rated', 'inspire-reviews' ),
                'desc'     => __( 'The Motion Picture Rating (MPAA) of the movie.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-rated',
                'name'     => '_insprvw-movie-rated',
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
                'id'       => '_insprvw-movie-release-date',
                'name'     => '_insprvw-movie-release-date',
                'type'     => 'date',
                'validate' => 'insprvw_sanitize_date'
            ),              
            array(
                'label'    => __( 'Runtime', 'inspire-reviews' ),
                'desc'     => __( 'The runtime of the movie.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-runtime',
                'type'     => 'multitext',
                'validate' => 'insprvw_sanitize_number',
                'options'  => array(
                    array(
                        'label' => __( 'Hours', 'inspire-reviews' ), 
                        'id'    => '_insprvw-movie-hours', 
                        'name'  => '_insprvw-movie-hours'
                    ),
                    array(
                        'label' => __( 'Minutes', 'inspire-reviews' ), 
                        'id'    => '_insprvw-movie-minutes', 
                        'name'  => '_insprvw-movie-minutes'
                    )
                )
            ),                 
            array(
                'label'    => __( 'Link', 'inspire-reviews' ),
                'desc'     => __( 'URL to the movie\'s website, imdb.com, or wikipedia page.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-link',
                'name'     => '_insprvw-movie-link',
                'type'     => 'url',
                'validate' => 'esc_url'
            ),            
            array(
                'label'    => __( 'Synopsis', 'inspire-reviews' ),
                'desc'     => __( 'A short description or plot on the movie.', 'inspire-reviews' ),
                'id'       => '_insprvw-movie-synopsis',
                'name'     => '_insprvw-movie-synopsis',
                'type'     => 'textarea',
                'validate' => 'insprvw_sanitize_textarea'
            )
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-tv-rating',
        'title'    => __( 'TV Rating', 'inspire-reviews' ),
        'page'     => 'insprvw-tv-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Rating', 'inspire-reviews' ),
                'desc'     => __( 'The rating of the show for this review. Can be 0 - 5; decimals allowed.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-rating',
                'name'     => '_insprvw-tv-rating',
                'type'     => 'text',
                'validate' => 'insprvw_sanitize_rating'
            )
        )
    );

    $postMetaBoxes[] = array(
        'id'       => 'insprvw-tv-information',
        'title'    => __( 'TV Information', 'inspire-reviews' ),
        'page'     => 'insprvw-tv-review',
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label'    => __( 'Title', 'inspire-reviews' ),
                'desc'     => __( 'The title of the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-title',
                'name'     => '_insprvw-tv-title',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),
            array(
                'label'    => __( 'Rated', 'inspire-reviews' ),
                'desc'     => __( 'The rating of the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-rated',
                'name'     => '_insprvw-tv-rated',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),             
            array(
                'label'    => __( 'Seasons', 'inspire-reviews' ),
                'desc'     => __( 'The number of seasons in the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-seasons',
                'name'     => '_insprvw-tv-seasons',
                'type'     => 'text',
                'validate' => 'insprvw_sanitize_number'
            ),
            array(
                'label'    => __( 'Episodes', 'inspire-reviews' ),
                'desc'     => __( 'The number of episodes in the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-episodes',
                'name'     => '_insprvw-tv-episodes',
                'type'     => 'text',
                'validate' => 'insprvw_sanitize_number'
            ),
            array(
                'label'    => __( 'Creator', 'inspire-reviews' ),
                'desc'     => __( 'The creator of the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-creator',
                'name'     => '_insprvw-tv-creator',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ), 
            array(
                'label'    => __( 'Network', 'inspire-reviews' ),
                'desc'     => __( 'The network the show is on.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-network',
                'name'     => '_insprvw-tv-network',
                'type'     => 'text',
                'validate' => 'sanitize_text_field'
            ),                         
            array(
                'label'    => __( 'Release Date', 'inspire-reviews' ),
                'desc'     => __( 'Date of show\'s release.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-release-date',
                'name'     => '_insprvw-tv-release-date',
                'type'     => 'date',
                'validate' => 'insprvw_sanitize_date'
            ),   
            array(
                'label'    => __( 'Runtime', 'inspire-reviews' ),
                'desc'     => __( 'The runtime of the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-runtime',
                'type'     => 'multitext',
                'validate' => 'insprvw_sanitize_number',
                'options'  => array(
                    array(
                        'label' => __( 'Hours', 'inspire-reviews' ), 
                        'id'    => '_insprvw-tv-hours', 
                        'name'  => '_insprvw-tv-hours'
                    ),
                    array(
                        'label' => __( 'Minutes', 'inspire-reviews' ), 
                        'id'    => '_insprvw-tv-minutes', 
                        'name'  => '_insprvw-tv-minutes'
                    )
                )
            ), 
            array(
                'label'    => __( 'Link', 'inspire-reviews' ),
                'desc'     => __( 'URL to the tv\'s website, imdb.com, or wikipedia page.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-link',
                'name'     => '_insprvw-tv-link',
                'type'     => 'url',
                'validate' => 'esc_url'
            ),              
            array(
                'label'    => __( 'Synopsis', 'inspire-reviews' ),
                'desc'     => __( 'A short description or plot on the show.', 'inspire-reviews' ),
                'id'       => '_insprvw-tv-synopsis',
                'name'     => '_insprvw-tv-synopsis',
                'type'     => 'textarea',
                'validate' => 'insprvw_sanitize_textarea'
            )
        )
    );