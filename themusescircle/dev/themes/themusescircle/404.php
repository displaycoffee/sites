<?php
	/**
	* Template for displaying 404 pages (not found)
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Include header
	get_header(); 
?>
<article>
	<header class="main-title">
		<h1><?php _e( 'Not Found', 'themusescircle' ); ?></h1>
	</header>
	<div id="error-404" class="not-found">
		<p><?php _e( 'Nothing found for the requested page.', 'themusescircle' ); ?></p>
		<p><?php echo sprintf( __( 'Return to %1$s%2$s%3$s?', 'themusescircle' ), '<a href="',  esc_url( home_url( '/' ) ), '">home</a>' ); ?></p>
	</div>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>