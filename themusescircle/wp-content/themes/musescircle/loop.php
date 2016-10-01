<?php
	/**
	* Template for displaying a basic post loop
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php if ( have_posts() ) : ?>
	<div class="entry-multiple" itemtype="http://schema.org/Blog">
		<?php while ( have_posts() ) : the_post(); ?>	
			<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry post" itemscope itemtype="http://schema.org/BlogPosting">
				<meta itemprop="mainEntityOfPage" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
				<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
				<div class="entry-wrapper">
					<?php 
						// Since the string is long, create variables for title before/after
						$title_before = '<header class="entry-header"><h3 itemprop="headline"><a href="' . esc_url( get_the_permalink() ) . '">';
						$title_after = '</a></h3></header>';

						// Display the title
						the_title( $title_before, $title_after );
					?>
					<?php get_template_part( 'partials/entry', 'meta' ); ?>			
					<div class="entry-content" itemprop="text"><?php echo musescircle_excerpt(); ?></div>
				</div>
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
				'prev_text' => '<span class="icon icon-chevron-left"></span>',
				'next_text' => '<span class="icon icon-chevron-right"></span>',
				'type'		=> 'list'			
			);

			// Display pagination
			echo '<nav class="pagination">' . paginate_links( $args ) . '</nav>';
		}
	?>
	<?php wp_reset_postdata(); ?>	
<?php else : ?>
	<div id="no-post" class="not-found">
		<p>
			<?php
				// Display different text for search versus other pages if no posts are found 
				if ( is_search() ) { 
					_e( 'No posts match your search.', 'musescircle' );
				} else {
					_e( 'No posts found.', 'musescircle' );
				}
			?>
		</p>
		<p><?php echo sprintf( __( 'Return to %1$s%2$s%3$s?', 'musescircle' ), '<a href="', esc_url( home_url( '/' ) ), '">home</a>' ); ?></p>
	</div>
<?php endif; ?>