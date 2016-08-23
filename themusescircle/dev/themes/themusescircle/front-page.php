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
		$about_section .= $about_left ? wpautop( esc_textarea ( $about_left ) ) : __( '<p>Welcome to our site!</p><p>There will be more information here soon.</p>', 'themusescircle' );
		$about_section .= '</div>';

		// Check if the right column has content
		if ( $about_right ) {
			$about_section .= '<div class="column">';
			$about_section .= wpautop( esc_textarea ( $about_right ) );
			$about_section .= '</div>';
		}				

		// Create "About" block - END
		$about_section .= '</div><div class="read-more">';
		$about_section .= '<a href="';
		$about_section .= $about_more_url ? esc_url( $about_more_url ) : esc_url ( get_bloginfo( 'url' ) . '/about' );
		$about_section .= '">';
		$about_section .= $about_more_text ? esc_html( $about_more_text ) : __( 'Read More', 'themusescircle' );
		$about_section .= '</a></div>';		
		$about_section .= '</div></section>';

		// Display "About" section (only if not marked as hidden)
		if ( !$about_hide ) {
			echo $about_section;
		}
	?>
	<section id="latest-reviews">
		<div class="wrapper">stuff</div>	
	</section>
	<section id="more-reviews">
		<div class="wrapper">stuff</div>	
	</section>
	<section id="blog-roll">
		<div class="wrapper">stuff</div>	
	</section>
</div>
<?php get_footer(); ?>