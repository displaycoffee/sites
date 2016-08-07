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
	<section id="top-bar">
		<div class="wrapper">
			<div class="social-media">
				<a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a>
				<a href=""><i class="fa fa-google-plus" aria-hidden="true"></i></a>
				<a href=""><i class="fa fa-youtube" aria-hidden="true"></i></a>
				<a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a>
				<a href=""><span class="custom-icon goodreads"></span></a>
				<a href=""><span class="custom-icon library-thing"></span></a>
			</div>
			<?php get_search_form(); ?>	
		</div>
	</section>
	<nav id="header-nav" class="navigation">
		<div class="wrapper">
			<?php 
				// Display main menu
				wp_nav_menu( array( 
					'theme_location'  => 'main-menu', 
					'container_id' 	  => 'main-menu-container', 
					'container_class' => 'menu-container' 
				) ); 
			?>
			<?php 
				// Get hide search setting
				$hide_search = get_theme_mod( 'themusescircle_hide_search' ); 

				// Create search button block
				$search_button = '<div id="search-menu-container" class="menu-container">';
				$search_button .= '<ul id="menu-search" class="menu">';
				$search_button .= '<li class="menu-item">';
				$search_button .= '<a class="search-button"><i class="fa fa-search" aria-hidden="true"></i>Search</a>';
				$search_button .= '<form class="search-form" method="get" action="' . esc_url( home_url( '/' ) ) . '">';
				$search_button .= '<input class="text" id="s" name="s" type="text" value="' . esc_attr( get_search_query() ) . '" placeholder="' . __( 'What are you looking for?', 'themusescircle' ) . '" />';
				$search_button .= '</form></li></ul></div>';

				// Display search button block (if setting is checked, don't display it)
				echo $hide_search ? '' : $search_button;
			?>
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