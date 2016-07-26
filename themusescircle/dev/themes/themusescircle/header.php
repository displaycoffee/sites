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
	<!--[if lt IE 9]>
		<p class="browserupgrade">
			<?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.', 'themusescircle' ); ?>
		</p>
	<![endif]-->
	<nav id="header-nav" class="navigation">
		<div class="wrapper cf">
			<?php 
				// Get hide search setting
				$hide_search = get_theme_mod( 'themusescircle_hide_search' ); 

				// Create search button block
				$search_button = '<div class="search-button">';
				$search_button .= '<a><i class="fa fa-search" aria-hidden="true"></i>Search</a>';
				$search_button .= '</div>';

				// Display search button block (if setting is checked, don't display it)
				echo $hide_search ? '' : $search_button;
			?>
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		</div>
	</nav>
	<header id="header">
		<p class="site-name">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo( 'name' ); ?></a>
		</p>
		<p class="site-description"><?php echo get_bloginfo( 'description' ); ?></p>
	</header>
	<?php get_search_form(); ?>		