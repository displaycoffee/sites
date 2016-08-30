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

		// Register navigation menus
		register_nav_menus( array(
			'main-menu'   => __( 'Main Menu', 'musescircle' ),
			'social-menu' => __( 'Social Media Menu', 'musescircle' )
		) );
	}
	add_action( 'after_setup_theme', 'musescircle_setup' );	

	// Add theme related scripts
	function musescircle_load_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'functions', get_template_directory_uri () . '/assets/js/functions.js', 'jquery', '', true );

		// Get blog url to use in JavaScript
		wp_localize_script( 'functions', 'wpurl', array( 'siteurl' => get_option( 'siteurl' ) ) );
	}
	add_action( 'wp_enqueue_scripts', 'musescircle_load_scripts' );

	// Custom social media menu
	function musescircle_social_menu( $menu_name ) {
		// Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			// Get nav menu object
		    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		 
		 	// Get id of menu
		    $menu_items = wp_get_nav_menu_items( $menu->term_id );

			// Create menu block - START	 
		    $menu_list = '<div class="menu-' . esc_html ( $menu->slug ) . '-container"><ul id="menu-' . esc_html ( $menu->slug ) . '" class="menu">';
		
			// Loop through list items 
		    foreach ( ( array ) $menu_items as $key => $menu_item ) {
	    		// Check if link should open in a new window
		    	$menu_target = $menu_item->target ? ' target="_blank"' : '';

	    		// Create svg properties	    		
				if ( strpos( esc_url( $menu_item->url ), 'facebook.com' ) !== false ) {
					$svg_name = 'facebook';
					$svg_attributes = 'viewBox="0 0 19 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'plus.google.com' ) !== false ) {
					$svg_name = 'google-plus';
					$svg_attributes = 'viewBox="0 0 41 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'linkedin.com' ) !== false ) {
					$svg_name = 'linkedin';
					$svg_attributes = 'viewBox="0 0 27 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'twitter.com' ) !== false ) {
					$svg_name = 'twitter';
					$svg_attributes = 'viewBox="0 0 30 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'instagram.com' ) !== false ) {
					$svg_name = 'instagram';
					$svg_attributes = 'viewBox="0 0 27 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'youtube.com' ) !== false ) {
					$svg_name = 'youtube';
					$svg_attributes = 'viewBox="0 0 27 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'pinterest.com' ) !== false ) {
					$svg_name = 'pinterest';
					$svg_attributes = 'viewBox="0 0 32 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'tumblr.com' ) !== false ) {
					$svg_name = 'tumblr';
					$svg_attributes = 'viewBox="0 0 19 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'goodreads.com' ) !== false ) {
					$svg_name = 'goodreads';
					$svg_attributes = 'viewBox="0 0 32 32"';
				} elseif ( strpos( esc_url( $menu_item->url ), 'librarything.com' ) !== false ) {
					$svg_name = 'library-thing';
					$svg_attributes = 'viewBox="0 0 32 32"';
				} else {
					$svg_name = 'heart';
					$svg_attributes = 'viewBox="0 0 32 32"';
				}

				// Create svg	
				$menu_svg = '<svg class="icon icon-' . $svg_name . '" ' . $svg_attributes . '><use xlink:href="' . get_option( 'siteurl' ) . '/wp-content/themes/musescircle/assets/images/icons.svg#icon-' . $svg_name . '"></use></svg>';

				// Check if menu item has a parent and if not, create list item elements
		    	if ( !$menu_item->menu_item_parent ) {
			        $menu_list .= '<li id="menu-item-' . esc_html ( $menu_item->ID ) .'" class="menu-item menu-item-' . esc_html ( $menu_item->ID ) .'">';
			        $menu_list .= '<a href="' . esc_url ( $menu_item->url ) . '"' . $menu_target . '>';
			        $menu_list .= '<span class="social-icon">' . $menu_svg . '</span>';
			        $menu_list .= '<span class="social-text">' . esc_html ( $menu_item->title ) . '</span>';
			        $menu_list .= '</a>';
			        $menu_list .= '</li>';
			    }
		    }
		    // Create menu block - END
		    $menu_list .= '</ul></div>';
		} else {
			$menu_list = null;
		}
		// Display menu block
		return $menu_list;		
	}

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
			'before_widget' => '<div id="footer-column01" class="column widget-container ' . esc_attr( '%2$s' ) . '">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4>',
			'after_title'	=> '</h4>',
		) );	
		register_sidebar( array(
			'name'			=> __( 'Footer Column 02', 'musescircle' ),
			'id'			=> 'footer-column02',
			'description'	=> __( 'A widget for the footer columns.', 'musescircle' ),
			'before_widget' => '<div id="footer-column02" class="column widget-container ' . esc_attr( '%2$s' ) . '">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4>',
			'after_title'	=> '</h4>',
		) );
		register_sidebar( array(
			'name'			=> __( 'Footer Column 03', 'musescircle' ),
			'id'			=> 'footer-column03',
			'description'	=> __( 'A widget for the footer columns.', 'musescircle' ),
			'before_widget' => '<div id="footer-column03" class="column widget-container ' . esc_attr( '%2$s' ) . '">',
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
	    	<div class="comment-meta">
		    	<p class="author"><?php printf( __( 'Comment by %s', 'musescircle' ), get_comment_author_link() ); ?></p>
			    <p class="date"><?php printf( __( 'on %1$s at %2$s', 'musescircle' ), get_comment_date(), get_comment_time() ); ?></p>
			</div>
	        <?php 
	        	if ( $args['avatar_size'] != 0 ) {
	        		echo '<div class="comment-thumbnail"><div class="image-wrap">' . get_avatar( $comment, $args['avatar_size'] ) . '</div></div>';
	        	} 
	        ?>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'musescircle' ); ?></em></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
    		<footer class="comment-footer">
    			<?php edit_comment_link( __( 'Edit', 'musescircle' ), '<div class="edit">', '</div>' ); ?>
    			<?php 
    				comment_reply_link( 
    					array_merge( $args, array( 
    						'add_below' => $add_below, 
    						'depth'		=> $depth, 
    						'max_depth' => $args['max_depth'],
    						'before'	=> '<div class="reply">',
    						'after'		=> '</div>' 
    					) ) 
    				); 
    			?>
    		</footer>
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
			return '<p>' . get_the_excerpt() . '</p>' . musescircle_read_more();
		}
	}

	// Create generic links
	function musescircle_create_link( $class, $url, $text ) {
		return '<a class="' . $class . '" href="' . esc_url( $url ) . '" target="_blank">' . __( $text, 'musescircle' ) . '</a>, ';
	}

	// Include customizer choices
	require_once( 'includes/customizer-choices.php' );

	// Include custom controls
	require_once( 'includes/customizer-date-picker.php' );

	// Include customizer validation
	require_once( 'includes/customizer-validation.php' );

	// Include customizer file
	require_once( 'includes/customizer.php' );