<?php
	/**
	* Functions specific to musescircle theme
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Set up theme options
	function musescircle_setup() {
		// Load theme text domain
		load_theme_textdomain( 'musescircle', get_template_directory() . '/languages' );

		// Add them support options
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );	

		// Add support for posts/pages
		add_post_type_support( 'page', 'excerpt' );

		// Register navigation menus
		register_nav_menus( array(
			'main-menu'   => __( 'Main Menu', 'musescircle' ),
			'footer-menu' => __( 'Footer Menu', 'musescircle' ),
			'social-menu' => __( 'Social Media Menu', 'musescircle' )
		) );
	}
	add_action( 'after_setup_theme', 'musescircle_setup' );	

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

	// Enable shortcodes in text widgets
	add_filter( 'widget_text', 'do_shortcode' );

	// Add theme related scripts
	function musescircle_load_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'functions', get_template_directory_uri () . '/assets/js/functions.js', 'jquery', '', true );

		// Get blog url to use in JavaScript
		wp_localize_script( 'functions', 'wpurl', array( 'siteurl' => get_option( 'siteurl' ) ) );
	}
	add_action( 'wp_enqueue_scripts', 'musescircle_load_scripts' );

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

	// Add user contact methods
	function musescircle_user_contact_methods( $user_contact ) {		
		$user_contact['facebook']  = __( 'Facebook', 'musescircle' );
		$user_contact['gplus']     = __( 'Google+', 'musescircle' );
		$user_contact['linkedin']  = __( 'LinkedIn', 'musescircle' );
		$user_contact['twitter']   = __( 'Twitter', 'musescircle' );
		$user_contact['instagram'] = __( 'Instagram', 'musescircle' );
		$user_contact['youtube']   = __( 'YouTube', 'musescircle' );
		$user_contact['pinterest'] = __( 'Pinterest', 'musescircle' );
		$user_contact['tumblr']    = __( 'Tumblr', 'musescircle' );
		$user_contact['goodreads'] = __( 'Goodreads', 'musescircle' );
		return $user_contact;
	}
	add_filter( 'user_contactmethods', 'musescircle_user_contact_methods' );

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
	function musescircle_excerpt() {
		if ( has_excerpt() ) {	    
		    return '<p>' . wp_trim_words( get_the_excerpt(), 50 ) . '</p>' . musescircle_read_more();
		} else {
			// Check the length of the excerpt
			if ( strlen( get_the_excerpt() ) > 0 ) {
				return '<p>' . get_the_excerpt() . '</p>' . musescircle_read_more();
			} else {
				return '<p>' . __( 'For additional information, click the title or', 'musescircle' ) . '</p>' . musescircle_read_more() . '.';
			}
		}
	}

	// Create generic links
	function musescircle_create_link( $class, $url, $text ) {
		return '<a class="' . $class . '" href="' . esc_url( $url ) . '" target="_blank">' . __( $text, 'musescircle' ) . '</a>, ';
	}

	// Create catergory lists
	function musescircle_create_category_list( $id, $category ) {
		return get_the_term_list( $id, $category, '<p class="categories" itemprop="keywords"><strong>' . __( 'Categories', 'musescircle' ) . ':</strong> ', ', ', '</p>' );
	}	

    // Parse date into an array to check values
    function musescircle_parse_date( $date ) {
		$date_array = date_parse( $date );

		// Check if the date contains a parseable month, year, and day, and there's no errors
		if ( $date_array['year'] && $date_array['month'] && $date_array['day'] && $date_array['error_count'] <= 0 ) {
			return true;
		} else {
			return false;
		}
	}

	// Include customizer choices
	require_once( 'customizer/customizer-choices.php' );

	// Include custom controls
	require_once( 'customizer/customizer-date-picker.php' );

	// Include customizer validation
	require_once( 'customizer/customizer-validation.php' );

	// Include customizer file
	require_once( 'customizer/customizer.php' );

	// Include shortcode file
	require_once( 'includes/shortcodes.php' );	