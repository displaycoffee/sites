<?php
	/**
	* Template for displaying front page "Countdown" section
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Grab all the variables we need for this page	
	$countdown_hide = get_theme_mod( 'musescircle_countdown_promotion_hide' );
	$countdown_date = get_theme_mod( 'musescircle_countdown_promotion_date' );
	$countdown_content = get_theme_mod( 'musescircle_countdown_promotion_content' );
	$countdown_url = get_theme_mod( 'musescircle_countdown_promotion_url' );
	$countdown_new_window = get_theme_mod( 'musescircle_countdown_promotion_new_window' );
?>
<?php 
	// Create "Countdown" block - START
	$countdown_section = '<section id="countdown-promotion"><div class="wrapper">';
	$countdown_section .= do_shortcode( '[countdown date="11/05/2016" url="http://www.google.com" window="new"]<b>html???</b>[/countdown]' );
	// $countdown_section .= '<h2>';
	// $countdown_section .= $countdown_title ? esc_html( $countdown_title ) : __( 'About', 'musescircle' );
	// $countdown_section .= '</h2>';
	// $countdown_section .= '<div class="row"><div class="column">';
	// $countdown_section .= $countdown_left ? wpautop( esc_textarea ( $countdown_left ) ) : __( $countdown_default_text, 'musescircle' );
	// $countdown_section .= '</div>';

	// // Check if the right column has content
	// if ( $countdown_right ) {
	// 	$countdown_section .= '<div class="column">';
	// 	$countdown_section .= wpautop( esc_textarea ( $countdown_right ) );
	// 	$countdown_section .= '</div>';
	// }				

	// Create "Countdown" block - END
	// $countdown_section .= '</div><div class="read-more">';
	// $countdown_section .= '<a href="' . ( $countdown_more_url ? esc_url( $countdown_more_url ) : esc_url ( get_option( 'siteurl' ) . '/about' ) ) . '">';
	// $countdown_section .= $countdown_more_text ? esc_html( $countdown_more_text ) : __( 'Read More', 'musescircle' );
	// $countdown_section .= '</a></div>';		
	$countdown_section .= '</div></section>';

	// Display "Countdown" section (only if not marked as hidden)
	if ( !$countdown_hide ) {
	 	echo $countdown_section;
	}
?>