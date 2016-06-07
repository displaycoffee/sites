<?php
	/**
	* Template for displaying a basic post loop
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php if ( have_posts() ) : ?>
	<div class="entry-multiple">
		<?php while ( have_posts() ) : the_post(); ?>	
			<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry post" itemscope itemtype="http://schema.org/Blog">
				<?php 
					// Since the string is long, create variables for title before/after
					$title_before = '<header class="entry-header"><h3 itemprop="name"><a href="' . esc_url( get_the_permalink() ) . '" itemprop="url" content="' . esc_url( get_the_permalink() ) . '">';
					$title_after = '</a></h3></header>';

					// Display the title
					the_title($title_before, $title_after);
				?>
				<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
				<div class="entry-details">
					<?php get_template_part( 'partials/entry', 'meta' ); ?>						
					<div class="entry-content" itemprop="text"><?php echo themusescircle_excerpt(); ?></div>
				</div>
				<?php get_template_part( 'partials/entry', 'footer' ); ?>
			</div>
		<?php endwhile; ?>
	</div>
	<?php 
		// Check if pages are greater than 1
		if ( $wp_query->max_num_pages > 1 ) {

			// Pagination arguments
			$args = array(
				'end_size'	=> 2,
				'mid_size'	=> 3,
				'prev_text' => __( 'Previous', 'themusescircle' ),
				'next_text' => __( 'Next', 'themusescircle' ),
				'type'		=> 'list'			
			);

			// Display pagination
			echo '<nav class="pagination">' . paginate_links( $args ) . '</nav>';
		}
	?>	
<?php else : ?>
	<div id="no-post" class="not-found">
		<p>
			<?php
				// Display different text for search versus other pages if no posts are found 
				if ( is_search() ) { 
					_e( 'No posts match your search.', 'themusescircle' );
				} else {
					_e( 'No posts found.', 'themusescircle' );
				}
			?>
		</p>
		<p><?php echo sprintf( __( 'Return to %1$s%2$s%3$s?', 'themusescircle' ), '<a href="', esc_url( home_url( '/' ) ), '">home</a>' ); ?></p>
	</div>
<?php endif; ?>