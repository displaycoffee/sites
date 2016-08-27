<?php
	/**
	* Template for displaying the front page
	*
	* Settings > Reading > Static page > Front page
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Include header	
	get_header(); 
?>
<div id="front-page-sections">
	<?php 
		// Get "About" customizations
		$about_hide = get_theme_mod( 'themusescircle_about_hide' );
		$about_title = get_theme_mod( 'themusescircle_about_title' );
		$about_left = get_theme_mod( 'themusescircle_about_left' );
		$about_right = get_theme_mod( 'themusescircle_about_right' );
		$about_more_text = get_theme_mod( 'themusescircle_about_more_text' );
		$about_more_url = get_theme_mod( 'themusescircle_about_more_url' );

		// Create "About" block - START
		$about_section = '<section id="about-site"><div class="wrapper">';
		$about_section .= '<h2>';
		$about_section .= $about_title ? esc_html( $about_title ) : __( 'About', 'themusescircle' );
		$about_section .= '</h2>';
		$about_section .= '<div class="row"><div class="column">';
		$about_section .= $about_left ? wpautop( esc_textarea ( $about_left ) ) : __( '<p>Welcome to our site! We\'re just getting started, but be sure to check back for more information soon.</p>', 'themusescircle' );
		$about_section .= '</div>';

		// Check if the right column has content
		if ( $about_right ) {
			$about_section .= '<div class="column">';
			$about_section .= wpautop( esc_textarea ( $about_right ) );
			$about_section .= '</div>';
		}				

		// Create "About" block - END
		$about_section .= '</div><div class="read-more">';
		$about_section .= '<a href="' . ( $about_more_url ? esc_url( $about_more_url ) : esc_url ( get_bloginfo( 'url' ) . '/about' ) ) . '">';
		$about_section .= $about_more_text ? esc_html( $about_more_text ) : __( 'Read More', 'themusescircle' );
		$about_section .= '</a></div>';		
		$about_section .= '</div></section>';

		// Display "About" section (only if not marked as hidden)
		if ( !$about_hide ) {
			echo $about_section;
		}
	?>
	<?php 
		// Get "Recent Review" customizations
		$recent_reviews_hide = get_theme_mod( 'themusescircle_recent_reviews_hide' );
		$recent_reviews_title = get_theme_mod( 'themusescircle_recent_reviews_title' );
		$recent_reviews_number = get_theme_mod( 'themusescircle_recent_reviews_number' );
		$recent_reviews_hide_books = get_theme_mod( 'themusescircle_recent_reviews_hide_books' );
		$recent_reviews_hide_movies = get_theme_mod( 'themusescircle_recent_reviews_hide_movies' );
		$recent_reviews_hide_tv = get_theme_mod( 'themusescircle_recent_reviews_hide_tv' );

		// Create default type array for reviews
		$recent_reviews_types = 'insprvw-book-review, insprvw-movie-review, insprvw-tv-review';

		// Remove book reviews if checked
		if ( $recent_reviews_hide_books ) {
			$recent_reviews_types = str_replace ( 'insprvw-book-review, ', '', $recent_reviews_types );
		}

		// Remove movie reviews if checked
		if ( $recent_reviews_hide_movies ) {
			$recent_reviews_types = str_replace ( 'insprvw-movie-review, ', '', $recent_reviews_types );
		}	

		// Remove tv reviews if checked
		if ( $recent_reviews_hide_tv ) {
			$recent_reviews_types = str_replace ( 'insprvw-tv-review', '', $recent_reviews_types );
		}	

		// Create "Recent Review" block
		$recent_reviews_section = '<section id="recent-reviews"><div class="wrapper">';
		$recent_reviews_section .= '<h2>';
		$recent_reviews_section .= $recent_reviews_title ? esc_html( $recent_reviews_title ) : __( 'Recent Reviews', 'themusescircle' );
		$recent_reviews_section .= '</h2>';		
		$recent_reviews_section .= do_shortcode( '[recent-reviews amount="' . ( $recent_reviews_number ? esc_html( $recent_reviews_number ) : 15 ) . '" types="' . $recent_reviews_types . '"]' );		
		$recent_reviews_section .= '</div></section>';

		// Display "Recent Review" section (only if not marked as hidden)
		if ( !$recent_reviews_hide ) {
			echo $recent_reviews_section;
		}
	?>
	<?php 
		// Get "Review Buttons" customizations
		$review_buttons_hide = get_theme_mod( 'themusescircle_review_buttons_hide' );
		$review_buttons_title = get_theme_mod( 'themusescircle_review_buttons_title' );
		$review_buttons_book_url = get_theme_mod( 'themusescircle_review_buttons_book_url' );
		$review_buttons_hide_books = get_theme_mod( 'themusescircle_review_buttons_hide_books' );
		$review_buttons_movie_url = get_theme_mod( 'themusescircle_review_buttons_movie_url' );
		$review_buttons_hide_movies = get_theme_mod( 'themusescircle_review_buttons_hide_movies' );
		$review_buttons_tv_url = get_theme_mod( 'themusescircle_review_buttons_tv_url' );
		$review_buttons_hide_tv = get_theme_mod( 'themusescircle_review_buttons_hide_tv' );
		$review_buttons_everything_url = get_theme_mod( 'themusescircle_review_buttons_everything_url' );
		$review_buttons_hide_everything = get_theme_mod( 'themusescircle_review_buttons_hide_everything' );

		// Create "Review Buttons" block - START
		$review_buttons_section = '<section id="review-buttons"><div class="wrapper">';
		$review_buttons_section .= '<h3>';
		$review_buttons_section .= $review_buttons_title ? esc_html( $review_buttons_title ) : __( 'Looking for more reviews?', 'themusescircle' );
		$review_buttons_section .= '</h3>';

		// Check if book review button is not hidden
		if ( !$review_buttons_hide_books ) {
			$review_buttons_section .= '<a href="' . ( $review_buttons_book_url ? esc_url( $review_buttons_book_url ) : esc_url ( get_bloginfo( 'url' ) . '/insprvw-book-review' ) ) . '" class="book button-simple">';
			$review_buttons_section .= __( 'Books', 'themusescircle' );
			$review_buttons_section .= '</a>';	
		}

		// Check if movie review button is not hidden
		if ( !$review_buttons_hide_movies ) {
			$review_buttons_section .= '<a href="' . ( $review_buttons_movie_url ? esc_url( $review_buttons_movie_url ) : esc_url ( get_bloginfo( 'url' ) . '/insprvw-movie-review' ) ) . '" class="movie button-simple">';
			$review_buttons_section .= __( 'Movies', 'themusescircle' );
			$review_buttons_section .= '</a>';	
		}

		// Check if tv review button is not hidden
		if ( !$review_buttons_hide_tv ) {
			$review_buttons_section .= '<a href="' . ( $review_buttons_tv_url ? esc_url( $review_buttons_tv_url ) : esc_url ( get_bloginfo( 'url' ) . '/insprvw-tv-review' ) ) . '" class="tv button-simple">';
			$review_buttons_section .= __( 'TV', 'themusescircle' );
			$review_buttons_section .= '</a>';	
		}

		// Check if everything review button is not hidden
		if ( !$review_buttons_hide_everything ) {
			$review_buttons_section .= '<a href="' . ( $review_buttons_everything_url ? esc_url( $review_buttons_everything_url ) : esc_url ( get_bloginfo( 'url' ) . '/all-reviews' ) ) . '" class="everything button-simple">';
			$review_buttons_section .= __( 'Everything', 'themusescircle' );
			$review_buttons_section .= '</a>';	
		}						

		// Create "Review Buttons" block - END
		$review_buttons_section .= '</div></section>';

		// Display "Review Buttons" section (only if not marked as hidden)
		if ( !$review_buttons_hide ) {
			echo $review_buttons_section;
		}
	?>
	<?php 
		// Get "From the Blog" customizations
		$from_blog_hide = get_theme_mod( 'themusescircle_from_blog_hide' );
		$from_blog_title = get_theme_mod( 'themusescircle_from_blog_title' );
	?>
	<?php if ( !$from_blog_hide ) : ?>
		<section id="from-the-blog">
			<div class="wrapper">
				<h2><?php echo $from_blog_title ? esc_html( $from_blog_title ) : __( 'From the Blog', 'themusescircle' ); ?></h2>
				<?php get_template_part( 'loop', 'index' ); ?>
			</div>	
		</section>
	<?php endif; ?>
</div>
<?php get_footer(); ?>