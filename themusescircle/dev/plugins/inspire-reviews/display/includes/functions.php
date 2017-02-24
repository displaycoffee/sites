<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Get custom archive templates
	function insprvw_get_archive_template( $archive ) {
		// Book review
		if ( get_post_type() == 'insprvw-book-review' ) {
			$archive = INSPRVW_DIR . 'display/book/book-review-archive.php';
		} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
			$archive = INSPRVW_DIR . 'display/video/video-review-archive.php';
		}
		return $archive;
	}
	add_filter( 'archive_template', 'insprvw_get_archive_template' ) ;

	// Get custom single template
	function insprvw_get_single_template( $single ) {
		// Book review 
		if ( get_post_type() == 'insprvw-book-review' ) {
			$single = INSPRVW_DIR . 'display/book/book-review-single.php';
		} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
			$single = INSPRVW_DIR . 'display/video/video-review-single.php';
		}
		return $single;
	}
	add_filter( 'single_template', 'insprvw_get_single_template' );

	// Get custom archive page template for all reviews
	function insprvw_all_reviews_template( $template ) {
		// Looks for page title ('All Reviews') or slug ('all-reviews')
		if ( is_page( 'All Reviews' ) || is_page( 'all-reviews' )  ) {
			$template = INSPRVW_DIR . 'display/all-reviews.php';
		}
		return $template;
	}
	add_filter( 'template_include', 'insprvw_all_reviews_template' );

	// Create review type based on get_post_type
	function insprvw_review_type( $all_types ) {
		if ( get_post_type() == 'insprvw-book-review' ) {
			$review_type = 'book'; 			
		} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
			if ( $all_types == true ) {
				if ( get_post_type() == 'insprvw-movie-review' ) {
					$review_type = 'movie';
				} else if ( get_post_type() == 'insprvw-tv-review' ) {
					$review_type = 'tv';
				}
			} else {
				$review_type = 'video';
			}
		} else {
			$review_type = null;
		}
		return $review_type;		
	}

	// Create video type based on get_post_type
	function insprvw_video_type( $schema ) {
		if ( get_post_type() == 'insprvw-movie-review' ) {
			if ( $schema == true ) {
				$video_type = 'http://schema.org/Movie';
			} else {
				$video_type = 'movie';
			}
		} else if ( get_post_type() == 'insprvw-tv-review' ) {
			if ( $schema == true ) {
				$video_type = 'http://schema.org/TVSeries';
			} else {
				$video_type = 'tv';
			}
		} else {
			$video_type = null;
		}
		return $video_type;		
	}

	// Display certain shortcodes
	function insprvw_display_shortcodes( $content ) {
		$pattern = get_shortcode_regex( array(
			'review-bold',
			'review-italic',
			'review-bold-italic'
		) );
		$content = preg_replace_callback( "/$pattern/", 'do_shortcode_tag', $content );
		return $content;
	}	