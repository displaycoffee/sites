<?php
	/**
	* Template for displaying front page "From the Blog" section
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Grab all the variables we need for this page	
	$from_blog_hide = get_theme_mod( 'musescircle_from_blog_hide' );
	$from_blog_title = get_theme_mod( 'musescircle_from_blog_title' );
	$from_blog_number = get_theme_mod( 'musescircle_from_blog_number' );

	// Set up args for custom loop query
	$args = array(
		'post_type' 	 => 'post',
		'posts_per_page' => $from_blog_number ? esc_html( $from_blog_number ) : 6
	);
	$home_query = new WP_Query( $args ); 

	// Create empty json-ld string to store data
	$json_block = '';
?>
<?php if ( !$from_blog_hide ) : ?>
	<section id="from-the-blog">
		<div class="wrapper">
			<h2><?php echo $from_blog_title ? esc_html( $from_blog_title ) : __( 'From the Blog', 'musescircle' ); ?></h2>
			<?php if ( $home_query->have_posts() ) : ?>
				<div class="entry-multiple">
					<?php while ( $home_query->have_posts() ) : $home_query->the_post(); ?>	
						<?php get_template_part( 'partials/entry', 'multiple' ); ?>
						<?php 
							// Create json-ld string for blog schema
							$json_block .= musescircle_blog_json( $post ) . ',';
						?>					
					<?php endwhile; ?>
					<script type="application/ld+json">
						{"@context": "http://schema.org","@graph": [<?php echo rtrim( $json_block, ',' ); ?>]}	
					</script>						
				</div>
				<?php wp_reset_postdata(); ?>	
			<?php else : ?>
				<div id="no-post" class="not-found">
					<p><?php _e( 'No posts found.', 'musescircle' ); ?></p>
				</div>
			<?php endif; ?>
		</div>	
	</section>
<?php endif; ?>