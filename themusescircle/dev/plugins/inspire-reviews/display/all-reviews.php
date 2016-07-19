<?php
	/**
	* Archive page template for displaying all reviews
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
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-<?php echo insprvw_review_type( true ); ?>-review" itemscope itemtype="http://schema.org/Review">
							<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
							<?php 
								// Since the string is long, create variables for title before/after
								$title_before = '<header class="entry-header"><h3 itemprop="name"><a href="' . esc_url( get_the_permalink() ) . '">';
								$title_after = '</a></h3></header>';

								// Display the title
								the_title( $title_before, $title_after );
							?>	
							<?php include '/partials/review-meta.php'; ?>
							<?php
								// Schema link for book versus movies/tv	
								if ( get_post_type() == 'insprvw-book-review' ) {
									$schema_link = 'http://schema.org/Book';
								} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
									$schema_link = insprvw_video_type( true );
								}
							?>											
							<div class="entry-item-reviewed" itemprop="itemReviewed" itemscope itemtype="<?php echo $schema_link; ?>">
								<?php include '/partials/review-thumbnail.php'; ?>
								<?php 
									// Include for book versus movies/tv	
									if ( get_post_type() == 'insprvw-book-review' ) {
										include '/book/book-information.php';
									} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
										include '/video/' . insprvw_video_type( false ) . '-information.php';
									}
								?>
							</div>
							<div class="entry-content">
								<meta itemprop="description" content="<?php echo esc_attr( substr( strip_tags( get_the_content() ), 0, 197 ) . '...' ); ?>"/>
								<?php echo insprvw_excerpt(); ?>
							</div>
							<?php include '/partials/review-footer.php'; ?>	
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<?php 
					// Check if pages are greater than 1
					if ( $insprvw_query->max_num_pages > 1 ) {
						
						// Pagination arguments
						$args = array(
							'end_size'	=> 2,
							'mid_size'	=> 3,
							'prev_text' => __( 'Previous', 'inspire-reviews' ),
							'next_text' => __( 'Next', 'inspire-reviews' ),
							'type'		=> 'list',
							'total'     => $insprvw_query->max_num_pages		
						);

						// Display pagination
						echo '<nav class="pagination">' . paginate_links( $args ) . '</nav>';
					}
				?>
			<?php else : ?>
				<?php include '/partials/review-no-posts.php'; ?>
			<?php endif; ?>	
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>				