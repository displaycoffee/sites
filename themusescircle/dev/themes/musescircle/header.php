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
			<?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.', 'musescircle' ); ?>
		</p>
	<![endif]-->	
	<?php 
		// Get hide search setting
		$hide_search = get_theme_mod( 'musescircle_header_hide_search' ); 

		// Check if social media links or hide search is not checked
		if ( has_nav_menu( 'social-menu' ) || !$hide_search ) {
			// Create header top bar
			$top_bar = '<section id="top-bar">';
			$top_bar .= '<div class="wrapper">';
			$top_bar .= musescircle_social_menu( 'social-menu' );
			$top_bar .= $hide_search ? '' : get_search_form( false );
			$top_bar .= '</div>';
			$top_bar .= '</section>';

			// Display top bar
			echo $top_bar;
		}
	?>
	<nav id="header-nav" class="navigation">
		<div class="wrapper">
			<?php 
				wp_nav_menu( array( 
					'theme_location' => 'main-menu',
					'container_class' => 'menu-main-container'
				) ); 
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