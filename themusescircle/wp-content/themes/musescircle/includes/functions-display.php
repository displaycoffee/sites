<?php
	/**
	* Functions related to front end display
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Add classes to body_class	
	function musescircle_body_classes( $classes ) {	
		if ( is_page() || is_single() ) {
			if ( has_post_thumbnail() ) {
				$classes[] = 'has-thumbnail';
			} else {
				$classes[] = 'no-thumbnail';
			}
		}
		return $classes;
	}
	add_filter( 'body_class', 'musescircle_body_classes' );

	// Remove certain classes from post entries
	function musescircle_post_classes( $classes ) {
	    $class_key = array_search( 'hentry', $classes );	 
	    if ( false !== $class_key ) {
	        unset( $classes[ $class_key ] );
	    }	 
	    return $classes;
	}
	add_filter( 'post_class', 'musescircle_post_classes' );

	// Register sidebars
	function musescircle_widgets_init() {
		register_sidebar( array(
			'name'			=> __( 'Default Sidebar', 'musescircle' ),
			'id'			=> 'default-widget-area',
			'description'	=> __( 'Widgets in this area will be shown on all posts and pages.', 'musescircle' ),
			'before_widget' => '<div id="' . esc_attr( '%1$s' ) . '" class="widget-container ' . esc_attr( '%2$s' ) . '">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h3 class="widget-title">',
			'after_title'	=> '</h3>',
		) );
		register_sidebar( array(
			'name'			=> __( 'Footer Column 01', 'musescircle' ),
			'id'			=> 'footer-column01',
			'description'	=> __( 'A widget for the footer columns.', 'musescircle' ),
			'before_widget' => '<div id="' . esc_attr( '%1$s' ) . '" class="widget-container ' . esc_attr( '%2$s' ) . '">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4>',
			'after_title'	=> '</h4>',
		) );	
		register_sidebar( array(
			'name'			=> __( 'Footer Column 02', 'musescircle' ),
			'id'			=> 'footer-column02',
			'description'	=> __( 'A widget for the footer columns.', 'musescircle' ),
			'before_widget' => '<div id="' . esc_attr( '%1$s' ) . '" class="widget-container ' . esc_attr( '%2$s' ) . '">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4>',
			'after_title'	=> '</h4>',
		) );
		register_sidebar( array(
			'name'			=> __( 'Footer Column 03', 'musescircle' ),
			'id'			=> 'footer-column03',
			'description'	=> __( 'A widget for the footer columns.', 'musescircle' ),
			'before_widget' => '<div id="' . esc_attr( '%1$s' ) . '" class="widget-container ' . esc_attr( '%2$s' ) . '">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4>',
			'after_title'	=> '</h4>',
		) );					
	}
	add_action( 'widgets_init', 'musescircle_widgets_init' );

	// Update the output of the wordpress caption
	function musescircle_caption( $empty, $attr, $content ) {		
		if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
			return '';
		}

		if ( $attr['id'] ) {
			$attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '" ';
		}

		// Create figure block
		$caption = '<figure ' . esc_attr( $attr['id'] ) . ' class="wp-caption ' . esc_attr( $attr['align'] ) . '">';
		$caption .= '<div class="wp-caption-wrap">';
		$caption .= do_shortcode( $content );
		$caption .= '<figcaption class="wp-caption-text">' . esc_html( $attr['caption'] ) . '</figcaption>';
		$caption .= '</div>';
		$caption .= '</figure>';

		// Display figure block
		return $caption;
	}
	add_filter( 'img_caption_shortcode', 'musescircle_caption', 10, 3 );

	// Custom comments template
	function musescircle_custom_comments( $comment, $args, $depth ) {
	    if ( 'div' === $args['style'] ) {
	        $add_below = 'comment';
	    } else {
	        $add_below = 'div-comment';
	    }
    ?>
    	<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php esc_attr( comment_ID() ) ?>">
	        <?php 
	        	if ( $args['avatar_size'] != 0 ) {
	        		echo '<div class="comment-thumbnail"><div class="image-wrap">' . get_avatar( $comment, 50 ) . '</div></div>';
	        	} 
	        ?>
	        <div class="comment-wrapper">
		    	<div class="comment-meta">
			    	<p class="author"><?php printf( __( 'Comment by %s', 'musescircle' ), get_comment_author_link() ); ?></p>
				    <p class="date"><?php printf( __( 'on %1$s at %2$s', 'musescircle' ), get_comment_date(), get_comment_time() ); ?></p>
				</div>
				<div class="comment-content">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'musescircle' ); ?></em></p>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div>
	    		<footer class="comment-footer">
	    			<?php edit_comment_link( __( 'Edit', 'musescircle' ), '<p class="edit">', '</p><span class="bullet">&bull;</span>' ); ?>
	    			<?php 
	    				comment_reply_link( 
	    					array_merge( $args, array( 
	    						'add_below' => $add_below, 
	    						'depth'		=> $depth, 
	    						'max_depth' => $args['max_depth'],
	    						'before'	=> '<p class="reply">',
	    						'after'		=> '</p>' 
	    					) ) 
	    				); 
	    			?>
	    		</footer>
	    	</div>
    <?php
	}

	// Add comment reply script
	function musescircle_enqueue_comment_reply_script() {
		if ( get_option( 'thread_comments' ) ) { 
			wp_enqueue_script( 'comment-reply' ); 
		}
	}
	add_action( 'comment_form_before', 'musescircle_enqueue_comment_reply_script' );

	// Get number of comments
	function musescircle_comments_number( $count ) {
		if ( !is_admin() ) {
			global $id;
			$get_comments = get_comments( 'status=approve&post_id=' . $id ); 
			$comments_by_type = separate_comments( $get_comments );
			return count( $comments_by_type['comment'] );
		} else {
			return $count;
		}
	}
	add_filter( 'get_comments_number', 'musescircle_comments_number' );

	// Trim default excerpt length
	function musescircle_excerpt_length( $length ) {
	    return 50;
	}
	add_filter( 'excerpt_length', 'musescircle_excerpt_length' );

	// Change text if excerpt length is reached
	function musescircle_excerpt_more( $more ) {
	    return '...';
	}
	add_filter( 'excerpt_more', 'musescircle_excerpt_more' );

	// Custom read more link for excerpts
	function musescircle_read_more() {
	    return '<div class="read-more"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read More', 'musescircle' ) . '</a></div>';
	}

	// Check if there is a custom excerpt and if so, make sure it's not too long
	function musescircle_excerpt( $html ) {
		// Set defauly message if there is no excerpt or page body text
		if ( strlen( get_the_excerpt() ) > 0 ) {
			$message = get_the_excerpt();
		} else {
			$message = __( 'For additional information, please read post or page.', 'musescircle' );
		}	

		if ( $html == true ) {
			if ( has_excerpt() ) {	    
			    return '<p>' . wp_trim_words( get_the_excerpt(), 50 ) . '</p>' . musescircle_read_more();
			} else {
				return '<p>' . $message . '</p>' . musescircle_read_more();
			}
		} else {
			if ( has_excerpt() ) {	    
			    return wp_trim_words( get_the_excerpt(), 50 );
			} else {
				return $message;
			}			
		}
	}

	// Create generic links
	function musescircle_create_link( $class, $url, $text ) {
		return '<a class="' . $class . '" href="' . esc_url( $url ) . '" target="_blank">' . __( $text, 'musescircle' ) . '</a>, ';
	}

	// Create taxonomy lists
	function musescircle_term_list( $id, $taxonomy, $separator, $before = '', $after = '' ) {
		// Loop through categories and push to array
		$terms = get_the_terms( $id, $taxonomy ); 
		$display = '';
		$list = '';

		// Check if the terms are in an array and if the array is greater than or equal to 1
		if ( gettype( $terms ) == 'array' && count( $terms ) >= 1 ) {
			// Are both before and after defined?
			if ( $before && $after ) {
				// Use wordpress get_the_term list to display all html
				$display .= get_the_term_list( $id, $taxonomy, $before, $separator, $after );
			} else {
				foreach( $terms as $term ) {
					// Get each term name
					$list .= $term->name . esc_html( $separator );
				}

				$display .= rtrim( $list, $separator );
			}

			return $display;
		}		
	}