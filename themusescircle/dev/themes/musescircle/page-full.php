<?php
	/**
	* Template Name: Full Width Page
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<?php get_template_part( 'page', 'title' ); ?>
<section class="content full-width">
	<div class="wrapper">
		<article>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="entry-single">	
					<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry page">
						<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
						<div class="entry-content"><?php the_content(); ?></div>
						<?php edit_post_link( __( 'Edit Content', 'musescircle' ), '<p class="edit">', '</p>' ); ?>							
					</div>
				</div>
			<?php endwhile; wp_reset_postdata(); endif; ?>
		</article>
	</div>
</section>			
<?php get_footer(); ?>