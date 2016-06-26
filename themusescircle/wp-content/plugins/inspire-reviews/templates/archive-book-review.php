<?php
	/**
	* Template for displaying book review archive
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
			<?php 
				// Check if we are on an author category
				// If so, display information about the author
				if ( is_tax('insprvw-book-author') ) {
					include '/../partials/book-author-information.php';
				} else {
					the_archive_description( '<div class="category-description">', '</div>' );
				}
			?>
			<h2><?php _e( 'Reviews', 'inspire-reviews' ); ?></h2>
			<?php if ( have_posts() ) : ?>	
				<div class="entry-multiple">
					<?php while ( have_posts() ) : the_post(); ?>
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-book-review" itemscope itemtype="http://schema.org/Review">
							<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
							<?php 
								// Since the string is long, create variables for title before/after
								$title_before = '<header class="entry-header"><h3 itemprop="name"><a href="' . esc_url( get_the_permalink() ) . '">';
								$title_after = '</a></h3></header>';

								// Display the title
								the_title( $title_before, $title_after );
							?>
							<?php include '/../partials/book-review-meta.php'; ?>
							<?php include '/../partials/book-review-thumbnail.php'; ?>								
							<div class="book-information" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Book">
								<?php 
									// Get the book title
									$book_title = get_post_meta( $post->ID, '_insprvw-book-title', true );

									// Display book meta title for schema
									echo $book_title_meta = $book_title ? '<meta itemprop="name" content="' . esc_html( $book_title ) . '">' : '';					
								?>
								<?php 
									// Get the author name title
									$author_terms = get_the_terms( $post->ID, 'insprvw-book-author' );
									
									// Create an array to store author names
									$author_names = array();

									// Loop through autor term meta and push name values to array
									foreach ( $author_terms as $author ) {
										array_push( $author_names, $author->name );
									}

									// Display author meta name for schema
									echo ( count( $author_names ) > 0 ) ? '<meta itemprop="author" content="' . esc_html( join( ', ', $author_names ) ) . '">' : '';					
								?>																
							</div>
							<div class="entry-content" itemprop="reviewBody"><?php echo insprvw_excerpt(); ?></div>
							<?php include '/../partials/book-review-footer.php'; ?>
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
							'prev_text' => __( 'Previous', 'inspire-reviews' ),
							'next_text' => __( 'Next', 'inspire-reviews' ),
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
								_e( 'No posts match your search.', 'inspire-reviews' );
							} else {
								_e( 'No posts found.', 'inspire-reviews' );
							}
						?>
					</p>
					<p><?php echo sprintf( __( 'Return to %1$s%2$s%3$s?', 'inspire-reviews' ), '<a href="', esc_url( home_url( '/' ) ), '">home</a>' ); ?></p>
				</div>
			<?php endif; ?>					
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>		