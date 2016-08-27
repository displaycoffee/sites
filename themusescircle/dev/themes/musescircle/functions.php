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

	// Create social links with icons
	function musescircle_social_link( $link, $class, $fa ) {
		$social_link = '<a href="' . esc_url( $link ) . '" target="_blank">';

		// Check if the icon should be fontawesone or not
		if ( $fa == 'true' || $fa == 'yes' ) {
			$social_link .= '<i class="fa ' . $class . '" aria-hidden="true"></i>';
		} else {
			$social_link .= '<span class="custom-icon ' . $class . '"></span>';
		}

		$social_link .= '</a>';
		return $social_link;					
	}

	// Include customizer choices
	require_once( 'includes/customizer-choices.php' );

	// Include custom controls
	require_once( 'includes/customizer-date-picker.php' );

	// Include customizer validation
	require_once( 'includes/customizer-validation.php' );

	// Include customizer file
	require_once( 'includes/customizer.php' );