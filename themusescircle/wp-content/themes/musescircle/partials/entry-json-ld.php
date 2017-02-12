<?php
	/**
	* Template for displaying schema.org json-ld data
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Create counting variables to not add comma on last iteration
	$total_posts = ( is_single() ) ? 1 : get_option( 'posts_per_page' );
	$post_count = 0;
?>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@graph": [
			<?php while ( have_posts() ) : the_post(); ?>
				<?php 
					// Increase post count
					$post_count++;

					// Variables for thumbnails
					if ( has_post_thumbnail() ) {
						$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[0];
						$thumbnail_width = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[1];
						$thumbnail_height = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[2];
					} else {
						$thumbnail_src = get_template_directory_uri() . '/assets/images/default-image-square.png';
						$thumbnail_width = 700;
						$thumbnail_height = 700;					
					}	

					// Create blank array to store keywords for tags and categories
					$keywords = array();

					// Loop through categories and push to array
					$categories = get_the_terms( $post->ID, 'category' ); 
					if ( $categories ) {
						foreach( $categories as $category ) {
							array_push( $keywords, $category->name );
						}
					}

					// Loop through tags and push to array
					$tags = get_the_terms( $post->ID, 'post_tag' ); 
					if ( $tags ) {
						foreach( $tags as $tag ) {
							array_push( $keywords, $tag->name );
						}
					}

					// Implode keywords to get a comma separated string
					$final_keywords = implode(', ', $keywords);	
				?>
				{
					"@type": "BlogPosting",
					"mainEntityOfPage": {
						"@type": "WebPage",
						"@id": "<?php echo esc_url( get_the_permalink() ); ?>"
					},
					"headline": "<?php echo esc_js( get_the_title() ); ?>",
					"image": {
						"@type": "ImageObject",
						"url": "<?php echo esc_url( $thumbnail_src ) ;?>",
						"height": <?php echo esc_js( $thumbnail_height ); ?>,
						"width": <?php echo esc_js( $thumbnail_width ); ?>
					},
					"datePublished": "<?php echo esc_js( get_the_time( get_option( 'date_format' ) ) ); ?>",
					"dateModified": "<?php echo esc_js( get_the_modified_date( get_option( 'date_format' ) ) ); ?>",
					"author": {
						"@type": "Person",
						"name": "<?php echo esc_js( get_the_author() ); ?>"
					},
					"publisher": {
						"@type": "Organization",
						"name": "<?php echo esc_js( get_bloginfo( 'name' ) ); ?>",
						"logo": {
							"@type": "ImageObject",
							"url": "<?php echo esc_url( get_template_directory_uri() . '/assets/images/publisher-logo.png' ); ?>",
							"width": 600,
							"height": 60
						}
					},
					"keywords": "<?php echo esc_js( $final_keywords );?>",
					"text": "<?php echo esc_js ( wp_strip_all_tags ( musescircle_excerpt( true ) ) ); ?>"
				}				
				<?php echo ( $post_count != $total_posts ) ? ',' : ''; ?>
			<?php endwhile; ?>				
		]
	}	
</script>