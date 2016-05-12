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
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">        
    <meta name="description" content="<?php echo get_bloginfo( 'description' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!--[if lt IE 9]>
        <p class="browserupgrade">
            You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
        </p>
    <![endif]-->
	<header id="header">
		<p class="site-name">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo( 'name' ); ?></a>
		</p>
		<p class="site-description"><?php echo get_bloginfo( 'description' ); ?></p>
	</header>
	<nav id="header-nav" class="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
	</nav>
	<?php get_search_form(); ?>
	<div class="customizer-options">
		<p>This is only here to show how customizer options work.</p>
		<h2>Section 01</h2>
		<p><?php echo esc_html( get_theme_mod( 'themusescircle_text', __( 'Default text field', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_url( get_theme_mod( 'themusescircle_url', __( 'http://www.wordpress.com', 'themusescircle' ) ) ); ?></p>
		<?php echo wpautop( esc_html( get_theme_mod( 'themusescircle_textarea', __( 'Default textarea field', 'themusescircle' ) ) ) ); ?>
		<p><?php echo esc_html( get_theme_mod( 'themusescircle_select', __( 'Option 01', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_html( get_theme_mod( 'themusescircle_radio', __( 'Yes', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_html( get_theme_mod( 'themusescircle_checkbox', __( '1', 'themusescircle' ) ) ); ?></p>
		<h2>Section 02</h2>
		<p><?php echo esc_html( get_theme_mod( 'themusescircle_date', __( '2017-01-01', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_html( get_theme_mod( 'themusescircle_page', __( '0', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_html( get_theme_mod( 'themusescircle_color', __( '#000000', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_url( get_theme_mod( 'themusescircle_file', __( 'No file selected.', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_url( get_theme_mod( 'themusescircle_image', __( 'No image selected.', 'themusescircle' ) ) ); ?></p>
		<h2>Social Media Fields</h2>
		<p><?php echo esc_url( get_theme_mod( 'themusescircle_facebook', __( 'http://www.facebook.com', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_url( get_theme_mod( 'themusescircle_gplus', __( 'http://www.google.com', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_url( get_theme_mod( 'themusescircle_linkedin', __( 'http://www.linkedin.com', 'themusescircle' ) ) ); ?></p>
		<p><?php echo esc_url( get_theme_mod( 'themusescircle_twitter', __( 'http://www.twitter.com', 'themusescircle' ) ) ); ?></p>
	</div>
	<section class="content">
		<div class="wrapper">		