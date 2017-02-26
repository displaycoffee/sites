<?php
	/**
	* Archive page template for displaying all reviews
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 

	// Create empty json-ld string to store data
	$json_block = '';	
?>
<?php include INSPRVW_DIR . 'display/partials/review-title.php'; ?>
<section class="content">
	<div class="wrapper">
		<article>	
			<?php 
				//Protect against arbitrary paged values
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		    	// Query args for review types
				$args = array(
					'post_type' => array( 'insprvw-book-review', 'insprvw-movie-review', 'insprvw-tv-review' ),
					'paged'     => $paged
				);
				$insprvw_query = new WP_Query( $args );	
			?>			
			<?php if ( $insprvw_query->have_posts() ) : ?>	
				<div class="entry-multiple">
					<?php while ( $insprvw_query->have_posts() ) : $insprvw_query->the_post(); ?>
						<?php 
							// Get post type to generate dyanmic content
							$post_type = get_post_type();

							// Check what type of post we're viewing and set type variable and json-ld schema
							if ( $post_type == 'insprvw-book-review' ) {
								$post_type = 'book';
								$json_block .= insprvw_book_json( $post ) . ',';
							} else if ( $post_type == 'insprvw-movie-review' ) {
								$post_type = 'movie';
								$json_block .= insprvw_movie_json( $post ) . ',';
							} else if ( $post_type == 'insprvw-tv-review' ) {
								$post_type = 'tv';
								$json_block .= insprvw_tv_json( $post ) . ',';
							}
						?>
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-<?php echo $post_type; ?>-review">
							<?php include INSPRVW_DIR . 'display/partials/review-thumbnail.php'; ?>
							<div class="entry-wrapper">
								<?php 
									// Since the string is long, create variables for title before/after
									$title_before = '<header class="entry-header"><h3><a href="' . esc_url( get_the_permalink() ) . '">';
									$title_after = '</a></h3></header>';

									// Display the title
									the_title( $title_before, $title_after );
								?>	
								<?php include INSPRVW_DIR . 'display/partials/review-meta.php'; ?>
								<div class="entry-content"><?php echo insprvw_excerpt( true ); ?></div>
							</div>	
						</div>						
					<?php endwhile; ?>
					<script type="application/ld+json">
						{"@context": "http://schema.org","@graph": [<?php echo rtrim( $json_block, ',' ); ?>]}	
					</script>	
				</div>
				<?php 
					// Check if pages are greater than 1
					if ( $insprvw_query->max_num_pages > 1 ) {
						
						// Pagination arguments
						$args = array(
							'end_size'	=> 1,
							'mid_size'	=> 3,
							'prev_text' => '<span class="icon icon-chevron-left"></span>',
							'next_text' => '<span class="icon icon-chevron-right"></span>',
							'type'		=> 'list',
							'total'     => $insprvw_query->max_num_pages		
						);

						// Display pagination
						echo '<nav class="pagination">' . paginate_links( $args ) . '</nav>';
					}
				?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php include '/partials/review-no-posts.php'; ?>
			<?php endif; ?>	
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>	