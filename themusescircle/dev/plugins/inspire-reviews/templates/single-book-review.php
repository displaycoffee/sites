<?php
	/**
	* Template for displaying single book review
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<article  itemprop="mainEntity" itemscope itemtype="http://schema.org/Book">
	<?php the_title( '<header class="main-title"><h1 itemprop="name">', '</h1></header>' ); ?>	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="entry-single">
			<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-book-review">		
				<?php include '/../partials/book-review-thumbnail.php'; ?>
				<div class="entry-details" itemprop="review" itemscope itemtype="http://schema.org/Review">
					<?php include '/../partials/book-review-meta.php'; ?>
					<div class="entry-content" itemprop="description"><?php the_content(); ?></div>					
				</div>
				<?php include '/../partials/book-review-footer.php'; ?>
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
<?php get_footer(); ?>