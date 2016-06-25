<?php
	/**
	* Template for displaying all single posts
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
				<div class="entry-single" itemtype="http://schema.org/Blog">
					<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry post" itemscope itemtype="http://schema.org/BlogPosting">
						<meta itemprop="headline" content="<?php echo get_the_title(); ?>"/>
						<meta itemprop="mainEntityOfPage" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
						<?php get_template_part( 'partials/entry', 'meta' ); ?>	
						<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
						<div class="entry-content" itemprop="text"><?php the_content(); ?></div>
						<?php get_template_part( 'partials/entry', 'footer' ); ?>
					</div>
				</div>
				<?php 
					// Don't print empty markup if there's nowhere to navigate.
					$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
					$next = get_adjacent_post( false, '', false );

					if ( $next || $previous ) {				
						// Start navigation html
						$single_navigation = '<nav class="navigation-links"><ul>';

						// Check if previous is there
						if ( $previous ) {
							$single_navigation .= '<li class="prev">' . get_previous_post_link( '%link', __( 'Previous: %title', 'themusescircle' ) ) . '</li>';
						}

						// Check if next is there
						if ( $next ) {
							$single_navigation .= '<li class="next">' . get_next_post_link( '%link', __( 'Next: %title', 'themusescircle' ) ) . '</li>';
						}

						// End navigation html
						$single_navigation .= '</ul></nav>';	

						// Display navigation
						echo $single_navigation;
					}
				?>
				<?php comments_template(); ?>
			<?php endwhile; endif; ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>