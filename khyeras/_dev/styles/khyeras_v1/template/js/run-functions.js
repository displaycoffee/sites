/* JavaScript Functionality
========================================================================== */

addBodyClass();
updateforumImage();
addFieldsetClasses();
addNoPaginationClass();
noContentListing();
addSearchIgnoredClass();
checkForNewPM();
addImageWrapper( '.notification_list .list-inner > img' );
addImageWrapper( '.notification_list .notification-block > img' );
checkForEmpty( '.section-mcp-post-details .pagination ul' );
checkForEmpty( '.section-mcp-post-details .postbody .content pre' );
removeHTMLFromDraft();
checkImageDimensions( '.excerpt .excerpt-image img' );

// Run all jquery functions on document ready
jQuery( document ).ready( function( $ ) {

	/* Main jQuery Functionality
	========================================================================== */

	checkForSpace( 'fieldset dl dt' );
	checkForSpace( 'dl.details dt' );
	addScrollableArea( $( '.topicreview' ), 400, $( '.review .right-box' ) );
	addScrollableArea( $( '.mcp-main #post_details' ), 400, $( '.mcp-main .post-buttons #expand' ) );
	addAttachmentIcon();
	updateaAttachmentDisplay( '.image-open' );
	updateaAttachmentDisplay( '.attach-image img' );
	formatDisplayActions();
	hidePMPostBox();
	addCPWrapper();
	toggleMobileContent( '.toggle-links a', '#page-welcome .site-callouts .site-links' );
	toggleMobileContent( '.toggle-featured a', '#featured-content' );
	toggleMemberDisplay();

	// Check if the theme is in overall_header then add sticky or scroll functionality
	if ( !$( 'body' ).hasClass( 'simple-phpbb' ) ) {
		addOnScroll( '#page-header .navbar', '.header-overlay', 'sticky' );
		scrollOnPage( '.scroll-to-top', 100, 0 );
		scrollOnPage( '.scroll-to-bottom', 100, bottomDistance );
	}

	// Start the mobile menu
	initializeMobileMenu({
	    menu          : '#page-header .navbar > ul',
	    menuContainer : '#page-header .navbar',
	    mobileButton  : '.mobile-menu-button',
	    mobileMenu    : '#mobile-menu',
	    width         : 768
	});

	/* Profile Field Functionality
	========================================================================== */

	updateProfileFields();
});
