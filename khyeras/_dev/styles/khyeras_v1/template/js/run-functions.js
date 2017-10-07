// Get distance for scroll to bottom
var bottomDistance =  jQuery( document ).height() + jQuery( window ).height();

// Base font size for responsive comparisons
var baseFontSize = 16;

// Add class to body tag
var body = document.getElementsByTagName( 'body' );
if ( body[0].getAttribute( 'data-class' ) ) {
	var bodyClass = body[0].getAttribute( 'data-class' ).replace( /[^a-zA-Z ]/g,'' ).trim().replace( / /g,'-' ).replace( /-+/g,'-' );
}

if ( bodyClass ) {
	body[0].className = body[0].className + ( ' ' + bodyClass );
}

// If forum has image, add a class to parent
var forumImage = document.querySelectorAll( '.list-inner .forum-image' );

if ( forumImage.length ) {
	for ( var i = 0; i < forumImage.length; i++ ) {
		forumImage[i].parentNode.className = forumImage[i].parentNode.className + ( ' has-forum-image' );
	}
}

// Run all functions on document ready
jQuery( document ).ready( function( $ ) {
	// Add wrapper around topic review if height is bigger than 400px
	var topicReview = $( '.topicreview' );
	addScrollableArea( topicReview, 400, $( '.review .right-box' ) );

	// Check if post details in mcp should be scrollable
	var mcpPostDetails = $( '.mcp-main #post_details' );
	addScrollableArea( mcpPostDetails, 400, $( '.mcp-main .post-buttons #expand' ) );

	// If postingbox in ucp is empty, hide it
	var pmPostBox = $( '#pmheader-postingbox' );

	if ( $( pmPostBox ).find( 'fieldset.fields1' ).children().length == 0 ) {
		$( pmPostBox ).hide();
	}

	// If pagination in mcp is empty, hide it
	var mcpPagination = $( '.mcp-main .pagination' );

	if ( $( mcpPagination ).find( 'ul' ).children().length == 0 ) {
		$( mcpPagination ).hide();
	}

	// Add wrapper around control panel elements
	var cpMenu = $( '.cp-menu' );
	var cpMain = $( '.cp-main' );

	if ( cpMenu || cpMain ) {
		cpMenu.parent().addClass('cp-wrapper');
		cpMain.parent().addClass('cp-wrapper');
	}

	scrollOnPage( '.scroll-to-top', 100, 0 );
	scrollOnPage( '.scroll-to-bottom', 100, bottomDistance );

	initializeMobileMenu({
	    menu          : '#page-header .navbar > ul',
	    menuContainer : '#page-header .navbar',
	    mobileButton  : '.mobile-menu-button',
	    mobileMenu    : '#mobile-menu',
	    width         : 768
	});
});
