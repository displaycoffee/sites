<?php
	/**
	* Template for displaying the header
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php esc_attr( bloginfo( 'charset' ) ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">        
    <meta name="description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<!--[if lte IE 9]>
		<p class="browserupgrade">
			<?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.', 'themusescircle' ); ?>
		</p>
	<![endif]-->
	<?php 
		// Get social media links
		$social_facebook = get_theme_mod( 'themusescircle_facebook' );
		$social_gplus = get_theme_mod( 'themusescircle_gplus' );
		$social_youtube = get_theme_mod( 'themusescircle_youtube' );
		$social_twitter = get_theme_mod( 'themusescircle_twitter' );
		$social_goodreads = get_theme_mod( 'themusescircle_goodreads' );
		$social_librarything = get_theme_mod( 'themusescircle_librarything' );

		// Create social media links
		$social_media_links = $social_facebook ? themusescircle_social_link( $social_facebook, 'fa-facebook', 'true' ) : '';
		$social_media_links .= $social_gplus ? themusescircle_social_link( $social_gplus, 'fa-google-plus', 'true' ) : '';
		$social_media_links .= $social_youtube ? themusescircle_social_link( $social_youtube, 'fa-youtube', 'true' ) : '';
		$social_media_links .= $social_twitter ? themusescircle_social_link( $social_twitter, 'fa-twitter', 'true' ) : '';
		$social_media_links .= $social_goodreads ? themusescircle_social_link( $social_goodreads, 'goodreads', 'false' ) : '';
		$social_media_links .= $social_librarything ? themusescircle_social_link( $social_librarything, 'library-thing', 'false' ) : '';

		// Get hide search setting
		$hide_search = get_theme_mod( 'themusescircle_hide_search' ); 

		// Check if social media links or hide search is not checked
		if ( strlen( $social_media_links ) > 0 || !$hide_search ) {
			// Create header top bar
			$top_bar = '<section id="top-bar">';
			$top_bar .= '<div class="wrapper">';
			$top_bar .= ( strlen( $social_media_links ) > 0 ) ? '<div class="social-media">' . $social_media_links . '</div>' : '';;
			$top_bar .= $hide_search ? '' : get_search_form( false );
			$top_bar .= '</div>';
			$top_bar .= '</section>';

			// Display top bar
			echo $top_bar;
		}
	?>
	<nav id="header-nav" class="navigation">
		<div class="wrapper">
			<?php wp_nav_menu( array( 'theme_location'  => 'main-menu' ) ); ?>
		</div>
	</nav>
	<header id="header">
		<div class="wrapper">
			<div class="header-content">
				<h1 class="site-name"><?php echo get_bloginfo( 'name' ); ?></h1>
				<p class="site-description"><?php echo get_bloginfo( 'description' ); ?></p>
			</div>
		</div>
	</header>		