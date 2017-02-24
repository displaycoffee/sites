<?php
	/**
	* Template for displaying book review archive
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
				// Check if we are on an author category and display information about the author
				if ( is_tax( 'insprvw-book-author' ) ) {
					// Get author term details
					$author_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

					// Get author name
					$author_name = $author_term->name;

					// Use author shortcode to display author information and create header
					$author_header = do_shortcode( '[book-author names="' . $author_name . '" title="false"]' );				
					$author_header .= '<h2>' . sprintf( __( 'Books by %1$s', 'inspire-reviews' ), $author_name ) . '</h2>';
					echo $author_header;
				} else {
					the_archive_description( '<div class="category-description">', '</div>' );
				}
			?>		
			<?php if ( have_posts() ) : ?>	
				<div class="entry-multiple">
					<?php while ( have_posts() ) : the_post(); ?>
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-book-review" itemscope itemtype="http://schema.org/Review">
							<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
							<?php 
								// If there's not a thumbnail, don't add thumbnail class
								$item_reviewed_class = has_post_thumbnail() ? 'class="entry-item-reviewed"' : '';
							?>
							<div <?php echo $item_reviewed_class; ?> itemprop="itemReviewed" itemscope itemtype="http://schema.org/Book">	
								<?php include INSPRVW_DIR . 'display/partials/review-thumbnail.php'; ?>
								<?php include INSPRVW_DIR . 'display/book/book-information.php'; ?>
							</div>							
							<div class="entry-wrapper">
								<?php 
									// Since the string is long, create variables for title before/after
									$title_before = '<header class="entry-header"><h3 itemprop="name"><a href="' . esc_url( get_the_permalink() ) . '">';
									$title_after = '</a></h3></header>';

									// Display the title
									the_title( $title_before, $title_after );
								?>
								<?php include INSPRVW_DIR . 'display/partials/review-meta.php'; ?>	
								<div class="entry-content">
									<meta itemprop="description" content="<?php echo esc_attr( substr( strip_tags( get_the_content() ), 0, 197 ) . '...' ); ?>"/>
									<?php echo insprvw_excerpt( true ); ?>
								</div>
							</div>
						</div>
						<?php 
							// Create json-ld string for blog schema
							$json_block .= insprvw_book_json( $post ) . ',';
						?>						
					<?php endwhile; ?>		
					<script type="application/ld+json">
						{"@context": "http://schema.org","@graph": [<?php echo rtrim( $json_block, ',' ); ?>]}	
					</script>									
				</div>
				<?php include INSPRVW_DIR . 'display/partials/review-pagination.php'; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php include INSPRVW_DIR . 'display/partials/review-no-posts.php'; ?>
			<?php endif; ?>	
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>				