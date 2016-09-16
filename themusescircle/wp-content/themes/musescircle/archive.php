<?php
	/**
	* Template for displaying archive pages (dates, categories and tags)
	*
	* @link https://codex.wordpress.org/Template_Hierarchy
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<?php get_template_part( 'page', 'title' ); ?>
<section class="content">
	<div class="wrapper">
		<article>			
			<?php the_archive_description( '<div class="category-description">', '</div>' ); ?>
			<?php get_template_part( 'loop', 'index' ); ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>