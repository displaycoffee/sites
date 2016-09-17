<?php
	/**
	* Template for displaying 404 pages (not found)
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Include header
	get_header(); 
?>
<section class="content">
	<div class="wrapper">
		<article>
			<div id="error-404" class="not-found">
				<p><?php _e( 'Nothing found for the requested page.', 'musescircle' ); ?></p>
				<p><?php echo sprintf( __( 'Return to %1$s%2$s%3$s?', 'musescircle' ), '<a href="',  esc_url( home_url( '/' ) ), '">home</a>' ); ?></p>
			</div>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>