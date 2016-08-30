<?php
	/**
	* Template for displaying the main page
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Include header	
	get_header(); 
?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php get_template_part( 'loop', 'index' ); ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>