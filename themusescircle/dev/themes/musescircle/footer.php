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
				<div class="row">
					<?php if ( is_active_sidebar( 'footer-column01' ) ) : ?>
						<div id="footer-column01" class="column">
							<?php dynamic_sidebar( 'footer-column01' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-column02' ) ) : ?>
						<div id="footer-column02" class="column">
							<?php dynamic_sidebar( 'footer-column02' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-column03' ) ) : ?>
						<div id="footer-column03" class="column">
							<?php dynamic_sidebar( 'footer-column03' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</footer>
	<?php endif; ?>	
	<?php wp_footer(); ?>
	<a href="#" class="scroll-to-top"><span class="icon icon-chevron-up"></span></a>
	<a href="#" class="scroll-to-bottom"><span class="icon icon-chevron-down"></span></a>
</body>
</html>