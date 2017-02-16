<?php
	/**
	* Template for displaying all single posts
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 

	// Create empty json-ld string to store data
	$json_block = '';
?>
<?php get_template_part( 'page', 'title' ); ?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php if ( have_posts() ) : ?>
				<div class="entry-single">
					<?php while ( have_posts() ) : the_post(); ?>						
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry post">
							<?php get_template_part( 'partials/entry', 'meta' ); ?>	
							<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
							<div class="entry-content"><?php the_content(); ?></div>
							<?php get_template_part( 'partials/entry', 'footer' ); ?>				
						</div>	
						<?php 
							// Create json-ld string for blog schema
							$json_block .= musescircle_blog_json( $post );
						?>											
					<?php endwhile; ?>
					<script type="application/ld+json">
						{"@context": "http://schema.org","@graph": [<?php echo $json_block; ?>]}	
					</script>	
				</div>												
				<?php comments_template(); ?>
				<?php 
					// Don't print empty markup if there's nowhere to navigate.
					$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
					$next = get_adjacent_post( false, '', false );

					if ( $next || $previous ) {				
						// Creat navigation block - START
						$single_navigation = '<nav class="navigation-links"><ul>';

						// Check if previous is there
						if ( $previous ) {
							$single_navigation .= '<li class="prev">' . get_previous_post_link( '%link', '<span class="icon icon-chevron-left"></span>' . __( '%title', 'musescircle' ) ) . '</li>';
						}

						// Check if next is there
						if ( $next ) {
							$single_navigation .= '<li class="next">' . get_next_post_link( '%link', __( '%title', 'musescircle' ) . '<span class="icon icon-chevron-right"></span>' ) . '</li>';
						}

						// Creat navigation block - END
						$single_navigation .= '</ul></nav>';	

						// Display navigation block
						echo $single_navigation;
					}
				?>
				<?php wp_reset_postdata(); ?>	
			<?php endif; ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>