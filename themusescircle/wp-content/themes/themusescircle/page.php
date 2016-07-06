<?php
	/**
	* Template for displaying pages
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<?php the_title( '<header class="main-title"><div class="wrapper"><h1>', '</h1></div></header>' ); ?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="entry-single">	
					<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry page">
						<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
						<div class="entry-content"><?php the_content(); ?></div>
						<?php edit_post_link( __( 'Edit', 'themusescircle' ), '<footer class="entry-footer"><div class="edit">', '</div></footer>' ); ?>				
					</div>
				</div>
			<?php endwhile; endif; ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>