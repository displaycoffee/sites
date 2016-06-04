<?php
	/**
	* Template for displaying book review archive pages
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<article>
	<?php the_archive_title( '<header class="main-title"><h1>', '</h1></header>' ); ?>
	<?php 
		// Check if we are on an author category
		// If so, display information about the author
		if (is_tax('insprvw-book-author')) {
			include( '/../partials/entry-book-author.php' );
		} else {
			the_archive_description( '<div class="category-description">', '</div>' );
		}
	?>
	<h2><?php _e( 'Reviews', 'inspire-reviews' ); ?></h2>
	<?php if ( have_posts() ) : ?>
		<div class="post-multiple">
			<?php while ( have_posts() ) : the_post(); ?>	
				<div id="post-<?php esc_attr( the_ID() ); ?>" class="insprvw-book-review" itemscope itemtype="http://schema.org/Blog">
					<?php 
						// Since the string is long, create variables for title before/after
						$title_before = '<header class="entry-header"><h3 itemprop="name"><a href="' . esc_url( get_the_permalink() ) . '">';
						$title_after = '</a></h3></header>';

						// Display the title
						the_title($title_before, $title_after);
					?>
					<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ) ?>">
					<?php include( '/../partials/entry-meta.php' ); ?>
					<?php include( '/../partials/entry-thumbnail.php' ); ?>
					<div class="entry-content" itemprop="text"><?php echo insprvw_excerpt(); ?></div>
					<?php include( '/../partials/entry-footer.php' ); ?>
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
<?php get_footer(); ?>