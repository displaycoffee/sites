<?php
	/**
	* Template part for displaying an author archive
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header
	get_header(); 
?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php get_template_part( 'partials/entry', 'author' ); ?>
			<h2><?php printf( __( 'Posts by %s', 'musescircle' ), get_the_author() ) ?></h2>
			<?php get_template_part( 'loop', 'index' ); ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>