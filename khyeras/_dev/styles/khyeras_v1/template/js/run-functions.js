/* JavaScript Functionality
========================================================================== */

addBodyClass();
addForumImageClass();
addFieldsetClasses();
addNoPaginationClass();
addImageWrapper( '.notification_list .list-inner > img' );
addImageWrapper( '.notification_list .notification-block > img' );

/* jQuery Functionality
========================================================================== */

// Get distance for scroll to bottom
var bottomDistance =  jQuery( document ).height() + jQuery( window ).height();

// Base font size for responsive comparisons
var baseFontSize = 16;

// Run all functions on document ready
jQuery( document ).ready( function( $ ) {
	// Check if the dt contains a single empty space
	checkForSpace( 'fieldset dl dt' );
	checkForSpace( 'dl.details dt' );

	// Add wrapper around topic review if height is bigger than 400px
	addScrollableArea( $( '.topicreview' ), 400, $( '.review .right-box' ) );

	// Check if post details in mcp should be scrollable
	addScrollableArea( $( '.mcp-main #post_details' ), 400, $( '.mcp-main .post-buttons #expand' ) );

	// Add icon for image attachment expansion
	var attachImage = '.attach-image';
	$( attachImage ).each( function() {
		$( this ).prepend( '<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>' );
	});

	// Then add more click events to image attachment expansion
	updateaAttachmentDisplay( '.image-open' );
	updateaAttachmentDisplay( attachImage + ' img' );

	// Update display-actions div formatting
	formatDisplayActions();

	// If postingbox in ucp is empty, hide it
	var pmPostBox = $( '#pmheader-postingbox' );

	if ( $( pmPostBox ).find( 'fieldset.fields1' ).children().length == 0 ) {
		$( pmPostBox ).hide();
	}

	// Add wrapper around control panel elements
	var cpMenu = $( '.cp-menu' );
	var cpMain = $( '.cp-main' );

	if ( cpMenu || cpMain ) {
		cpMenu.parent().addClass('cp-wrapper');
		cpMain.parent().addClass('cp-wrapper');
	}

	if ( !$( 'body' ).hasClass( 'simple-phpbb' ) ) {
		addOnScroll( '#page-header .navbar', '.header-overlay', 'sticky' );
		scrollOnPage( '.scroll-to-top', 100, 0 );
		scrollOnPage( '.scroll-to-bottom', 100, bottomDistance );
	}

	toggleMobileContent( '.toggle-links a', '#page-welcome .site-callouts .site-links' );
	toggleMobileContent( '.toggle-featured a', '#featured-content' );

	initializeMobileMenu({
	    menu          : '#page-header .navbar > ul',
	    menuContainer : '#page-header .navbar',
	    mobileButton  : '.mobile-menu-button',
	    mobileMenu    : '#mobile-menu',
	    width         : 768
	});
});
