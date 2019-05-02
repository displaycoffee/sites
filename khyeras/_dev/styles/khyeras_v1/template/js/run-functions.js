/* JavaScript Functionality
========================================================================== */

addForumImageClass();
addFieldsetClasses();
addNoPaginationClass();
addThanksClass();
moveRankText();
noContentListing();
addSearchIgnoredClass();
checkForNewPM();
checkForEmpty( '.section-mcp-post-details .pagination ul' );
bannerCodeGenerator('.link-banners img', '#link-banner-code code');
addImageWrapper( '.notification_list .list-inner > img' );
addImageWrapper( '.notification_list .notification-block > img' );
checkImageDimensions( '.page-welcome .image-wrap img' );
checkImageDimensions( '.postprofile .avatar img' );
detectiPhone();

var forumImage = '.forum-image img';
checkImageDimensions( forumImage );
addImageBackground( forumImage, '1000x500' );

var excerptImage = '.excerpt .excerpt-image img';
checkImageDimensions( excerptImage );
addImageBackground( excerptImage, '1000x500' );

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
	toggleContent( '.toggle-links a', '#page-welcome .site-links', 'toggle-show', '' );
	toggleContent( '.toggle-featured a', '#featured-content', 'toggle-show', '' );
	toggleContent( '.bbcode-hidden-toggle', '.bbcode-hidden-text', 'toggle-show', 'prev' );
	toggleContent( '.card-filter-button', '.card-changed', 'toggle-hide', '' )
	toggleMemberDisplay();
	toggleMapDisplay();

	// Check if the theme is in overall_header then add sticky or scroll functionality
	if ( !$( 'body' ).hasClass( 'simple-phpbb' ) ) {
		addOnScroll( '#page-header .navbar', '.header-overlay', 'sticky' );
		addOnScroll( '.quick-links', '.site-description', 'quick-links-visible' );
		scrollOnPage( '.scroll-to-top', 100, 0 );
		scrollOnPage( '.scroll-to-bottom', 100, bottomDistance );
	}

	// Start the discord list build
	initializeDiscordList();

	// Start navigation dropdown menus
	initializeDropdownMenu( '.menu-trigger', '.menu > li' );

	// Start the mobile menu
	initializeMobileMenu({
		menu          : '#page-header .navbar .wrapper > ul',
		menuContainer : '#page-header .navbar .wrapper',
		mobileButton  : '.mobile-menu-button',
		mobileMenu    : '#mobile-menu',
		mobileContent : '.mobile-menu-content',
		mobileOverlay : '#mobile-overlay',
		width         : 768
	});

	/* Profile Field Functionality
	========================================================================== */

	updateProfileFields();
});
