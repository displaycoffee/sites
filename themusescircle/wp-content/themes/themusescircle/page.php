<?php
	/**
	* Template for displaying pages
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<article>
	<?php the_title( '<header class="main-title"><h1>', '</h1></header>' ); ?>	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="entry-single">	
			<div id="page-<?php esc_attr( the_ID() ); ?>" class="entry page">
				<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
				<div class="entry-details">
					<div class="entry-content"><?php the_content(); ?></div>
				</div>
				<footer class="entry-footer">
					<?php edit_post_link( __('Edit', 'themusescircle'), '<div class="edit">', '</div>' ); ?>
				</footer>
			</div>
		</div>
	<?php endwhile; endif; ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>