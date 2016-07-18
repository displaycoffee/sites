<?php
	/**
	* Archive page template for displaying all reviews
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 	
?>
<?php the_archive_title( '<header class="main-title"><div class="wrapper"><h1>', '</h1></div></header>' ); ?>
<section class="content">
	<div class="wrapper">
		<article>	
			<?php the_archive_description( '<div class="category-description">', '</div>' ); ?>	
			<h2><?php _e( 'Reviews', 'inspire-reviews' ); ?></h2>
			<?php 
		    	// Query args for review types
				$args = array(
					'post_type' => array( 'insprvw-book-review', 'insprvw-movie-review', 'insprvw-tv-review' )
				);
				$insprvw_query = new WP_Query( $args );	
			?>			
			<?php if ( $insprvw_query->have_posts() ) : ?>	
				<div class="entry-multiple">
					<?php while ( $insprvw_query->have_posts() ) : $insprvw_query->the_post(); ?>				
						<?php
							// Conditionals for book versus movies/tv	
							if ( get_post_type() == 'insprvw-book-review' ) {
								$schema_link = 'http://schema.org/Book';
							} else if ( get_post_type() == 'insprvw-movie-review' || get_post_type() == 'insprvw-tv-review' ) {
								$schema_link = insprvw_video_type( true );
							}
						?>						
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
							<div class="entry-item-reviewed" itemprop="itemReviewed" itemscope itemtype="<?php echo $schema_link; ?>">
								review stuff goes here
							</div>							
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<?php include '/partials/review-pagination.php'; ?>
			<?php else : ?>
				<?php include '/partials/review-no-posts.php'; ?>
			<?php endif; ?>	
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>				