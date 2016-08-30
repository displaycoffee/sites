<?php
	/**
	* Template for displaying the footer
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
	<?php if ( is_active_sidebar( 'footer-column01' ) || is_active_sidebar( 'footer-column02' ) || is_active_sidebar( 'footer-column03' ) ) : ?>
		<footer id="footer">
			<div class="wrapper">
				<?php if ( is_active_sidebar( 'footer-column01' ) ) : ?>
					<?php dynamic_sidebar( 'footer-column01' ); ?>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-column02' ) ) : ?>
					<?php dynamic_sidebar( 'footer-column02' ); ?>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-column03' ) ) : ?>
					<?php dynamic_sidebar( 'footer-column03' ); ?>
				<?php endif; ?>
			</div>
		</footer>
	<?php endif; ?>	
	<?php wp_footer(); ?>
</body>
</html>