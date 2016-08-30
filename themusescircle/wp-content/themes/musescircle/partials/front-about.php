<?php
	/**
	* Template for displaying front page "About" section
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Grab all the variables we need for this page	
	$about_hide = get_theme_mod( 'musescircle_about_hide' );
	$about_title = get_theme_mod( 'musescircle_about_title' );
	$about_left = get_theme_mod( 'musescircle_about_left' );
	$about_right = get_theme_mod( 'musescircle_about_right' );
	$about_more_text = get_theme_mod( 'musescircle_about_more_text' );
	$about_more_url = get_theme_mod( 'musescircle_about_more_url' );	
?>
<?php 
	// Default text for left column
	$about_default_text = '<p>Welcome to our site! We\'re just getting started, but be sure to check back for more information soon.</p>';

	// Create "About" block - START
	$about_section = '<section id="about-site"><div class="wrapper">';
	$about_section .= '<h2>';
	$about_section .= $about_title ? esc_html( $about_title ) : __( 'About', 'musescircle' );
	$about_section .= '</h2>';
	$about_section .= '<div class="row"><div class="column">';
	$about_section .= $about_left ? wpautop( esc_textarea ( $about_left ) ) : __( $about_default_text, 'musescircle' );
	$about_section .= '</div>';

	// Check if the right column has content
	if ( $about_right ) {
		$about_section .= '<div class="column">';
		$about_section .= wpautop( esc_textarea ( $about_right ) );
		$about_section .= '</div>';
	}				

	// Create "About" block - END
	$about_section .= '</div><div class="read-more">';
	$about_section .= '<a href="' . ( $about_more_url ? esc_url( $about_more_url ) : esc_url ( get_option( 'siteurl' ) . '/about' ) ) . '">';
	$about_section .= $about_more_text ? esc_html( $about_more_text ) : __( 'Read More', 'musescircle' );
	$about_section .= '</a></div>';		
	$about_section .= '</div></section>';

	// Display "About" section (only if not marked as hidden)
	if ( !$about_hide ) {
		echo $about_section;
	}
?>