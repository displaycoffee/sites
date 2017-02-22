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
			<?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="//browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.', 'musescircle' ); ?>
		</p>
	<![endif]-->	
	<?php 
		// Get hide search setting
		$hide_search = get_theme_mod( 'musescircle_header_hide_search' ); 

		// Get social menu
		$social_menu = wp_nav_menu( array( 
			'theme_location' => 'social-menu',
			'echo' 			 => false
		) ); 

		// Create header top bar
		$top_bar = '<section id="top-bar">';
		$top_bar .= '<div class="wrapper">';
		$top_bar .= $social_menu;
		$top_bar .= '<div class="mobile-menu-button"><span class="icon icon-lines"></span><span class="mobile-menu-text">Menu</span></div>';
		$top_bar .= $hide_search ? '' : get_search_form( false );
		$top_bar .= '<a class="home-link" href="' . esc_url( get_bloginfo( 'url' ) ) . '">';
		$top_bar .= '<span class="icon icon-home"></span>';
		$top_bar .= '</a>';
		$top_bar .= '</div>';
		$top_bar .= '</section>';

		// Display top bar
		echo $top_bar;
	?>
	<nav id="header-nav" class="navigation">
		<div class="wrapper">
			<?php if ( !is_front_page() ) : ?>
				<h2 class="site-name"><a class="home-link" href="<?php echo esc_url( get_bloginfo( 'url' ) ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></h2>
			<?php endif; ?>				
			<?php 
				wp_nav_menu( array( 
					'theme_location' => 'main-menu',
				) ); 
			?>
		</div>
	</nav>
	<nav id="mobile-menu"></nav>