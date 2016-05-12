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
		<div class="post-single">	
			<div id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>
				<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
				<div class="entry-content"><?php the_content(); ?></div>
				<footer class="entry-footer">
					<?php edit_post_link( __('Edit', 'themusescircle'), '<div class="edit">', '</div>' ); ?>
				</footer>
			</div>
		</div>
	<?php endwhile; endif; ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>