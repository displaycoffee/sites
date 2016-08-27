<?php
	/**
	* Template for displaying the footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
	<footer id="footer">
		<p id="copyright">
			<?php echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved.', 'musescircle' ), '&copy;', date( 'Y' ), get_bloginfo( 'name' ) ); ?>
		</p>
		<p id="credits">
			<?php printf( __( 'Theme by %s', 'musescircle' ), '<a href="//neverend.org/adria" target="_blank">Adria Murphy</a>' ); ?>
		</p>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>