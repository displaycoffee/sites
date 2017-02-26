<?php
	/**
	* Template for displaying a basic post loop
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Create empty json-ld string to store data
	$json_block = '';
?>
<?php if ( have_posts() ) : ?>
	<div class="entry-multiple">
		<?php while ( have_posts() ) : the_post(); ?>	
			<?php 
				// Create json-ld string for blog schema
				$json_block .= musescircle_blog_json( $post ) . ',';
			?>
			<?php get_template_part( 'partials/entry', 'multiple' ); ?>		
		<?php endwhile; ?>
		<script type="application/ld+json">
			{"@context": "http://schema.org","@graph": [<?php echo rtrim( $json_block, ',' ); ?>]}	
		</script>					
	</div>
	<?php 
		// Check if pages are greater than 1
		if ( $wp_query->max_num_pages > 1 ) {

			// Pagination arguments
			$args = array(
				'end_size'	=> 1,
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