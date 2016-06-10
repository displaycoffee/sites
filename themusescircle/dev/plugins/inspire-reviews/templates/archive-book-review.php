<?php
	/**
	* Template for displaying book review archive
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
			// Create social media links
			function author_social($class, $url, $text) {
				return '<a class="' . $class . '" href="' . $url . '" target="_blank">' . __( $text, 'inspire-reviews' ) . '</a>';
			}

			// Get author term details
			$author_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$author_term_id = $author_term->term_id;

			// Get author meta
			$author_name = $author_term->name;
			$author_description = $author_term->description;
			$author_image = get_term_meta( $author_term_id, 'author-image', true );
			$author_website = get_term_meta( $author_term_id, 'author-website', true );
			$author_goodreads = get_term_meta( $author_term_id, 'author-goodreads', true );
			$author_facebook = get_term_meta( $author_term_id, 'author-facebook', true );
			$author_twitter = get_term_meta( $author_term_id, 'author-twitter', true );
			$author_pinterest = get_term_meta( $author_term_id, 'author-pinterest', true );
			$author_google = get_term_meta( $author_term_id, 'author-google', true );
			$author_tumblr = get_term_meta( $author_term_id, 'author-tumblr', true );

			// Create author image HTML
			$author_image_html = '<div class="author-image">';
			$author_image_html .= '<div class="image-wrap">';
			$author_image_html .= '<img src="' . esc_url( $author_image ) . '" alt="' . esc_attr( $author_name ) . '" />';
			$author_image_html .= '</div>';
			$author_image_html .= '</div>';

			// Create author social HTML
			$author_social_html = '<div class="author-social">';
			$author_social_html .= $author_website ? author_social( esc_attr( 'website' ), esc_url( $author_website ), 'Website' ) : '';
			$author_social_html .= $author_goodreads ? author_social( esc_attr( 'goodreads' ), esc_url( $author_goodreads ), 'Goodreads' ) : '';
			$author_social_html .= $author_facebook ? author_social( esc_attr( 'facebook' ), esc_url( $author_facebook ), 'Facebook' ) : '';
			$author_social_html .= $author_twitter ? author_social( esc_attr( 'twitter' ), esc_url( $author_twitter ), 'Twitter' ) : '';
			$author_social_html .= $author_pinterest ? author_social( esc_attr( 'pinterest' ), esc_url( $author_pinterest ), 'Pinterest' ) : '';
			$author_social_html .= $author_google ? author_social( esc_attr( 'google' ), esc_url( $author_google ), 'Google+' ) : '';
			$author_social_html .= $author_tumblr ? author_social( esc_attr( 'tumblr' ), esc_url( $author_tumblr ), 'Tumblr' ) : '';
			$author_social_html .= '</div>';

			// Create author description HTML
			$author_description_html = '<div class="author-description">';
			$author_description_html .= wpautop( esc_html( $author_description ) );
			$author_description_html .= '</div>';

			// Create author display HTML
			$author_html = '<div class="author-information">';
			$author_html .= $author_image ? $author_image_html : '';
			$author_html .= '<div class="author-details">';
			$author_html .= $author_description ? $author_description_html : '';
			$author_html .= ( $author_social_html != '<div class="author-social"></div>' ) ? $author_social_html : '';
			$author_html .= '</div></div>';

			// Display final HTML
			echo $author_html;
		} else {
			the_archive_description( '<div class="category-description">', '</div>' );
		}
	?>
	<h2><?php _e( 'Reviews', 'inspire-reviews' ); ?></h2>
	<?php if ( have_posts() ) : ?>
		<div class="entry-multiple">
			<?php while ( have_posts() ) : the_post(); ?>
				<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-book-review" itemprop="mainEntity" itemscope itemtype="http://schema.org/Book">
					<?php 
						// Get the book title
						$book_title = get_post_meta( $post->ID, '_insprvw-book-title', true );

						// Display book meta title for schema
						echo $book_title_meta = $book_title ? '<meta itemprop="name" content="' . $book_title . '">' : '';					
					?>
					<?php 
						// Get the author name title
						$author_terms = get_the_terms ( $post->ID, 'insprvw-book-author' );
						
						// Create an array to store author names
						$author_names = array();

						// Loop through autor term meta and push name values to array
						foreach ( $author_terms as $author ) {
							array_push( $author_names, $author->name );
						}

						// Display author meta name for schema
						echo ( count( $author_names ) > 0 ) ? '<meta itemprop="author" content="' . join( ', ', $author_names ) . '">' : '';					
					?>
					<?php 
						// Since the string is long, create variables for title before/after
						$title_before = '<header class="entry-header"><h3><a href="' . esc_url( get_the_permalink() ) . '">';
						$title_after = '</a></h3></header>';

						// Display the title
						the_title($title_before, $title_after);
					?>					
					<?php include '/../partials/book-review-thumbnail.php'; ?>				
					<div class="entry-details" itemprop="review" itemscope itemtype="http://schema.org/Review">
						<?php include '/../partials/book-review-meta.php'; ?>					
						<div class="entry-content" itemprop="description"><?php echo insprvw_excerpt(); ?></div>
					</div>
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
<?php get_footer(); ?>