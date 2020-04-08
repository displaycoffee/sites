/* JavaScript Functionality
========================================================================== */

addFieldsetClasses();
addForumImageClass();
addImageBackground( '.page-welcome .image-wrap img', false );
addImageBackground( '.postprofile .avatar img', false );
addImageBackground( '.dropdown-container .user-avatar img', false );
addImageBackground( '.forum-image img', '1000x500' );
addImageBackground( '.excerpt .excerpt-image img', '1000x500' );
addImageBackground( '.section-page-character-listing .user-avatar img', false );
addImageWrapper( '.notification_list .list-inner > img' );
addImageWrapper( '.notification_list .notification-block > img' );
addNoPaginationClass();
addQuickLinks();
addSearchIgnoredClass();
addThanksClass();
bannerCodeGenerator('.link-banners img', '#link-banner-code code');
checkForEmpty( '#viewprofile .user-contact .contact-icons', false );
checkForEmpty( '#viewprofile .user-contact .details', false );
checkForEmpty( '#viewprofile .extra-details', false );
checkForEmpty( '.section-mcp-post-details .pagination ul', true );
checkForNewPM();
detectiPhone();
moveRankText();
noContentListing();
toggleElements( '.bbcode-hidden-container .toggle-button', '.bbcode-hidden-text', 'bbcode-hidden-container', false );
toggleElements( '.forabg .toggle-button', '.topiclist.forums', 'inner', true );
toggleElements( '.toggle-links .toggle-button', '.site-links', 'user-information', false );
toggleElements( '.toggle-featured .toggle-button', '.featured-content', 'wrap', false );
toggleElements( '.toggleable-section .toggle-button', '.card-grid', 'toggleable-section', true );
addFiltering();

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
	toggleContent( '.card-filter-button', '.card-changed', 'toggle-hide', '' );
	toggleMemberDisplay();
	toggleMapDisplay();

	// Check if the theme is in overall_header then add sticky or scroll functionality
	if ( !$( 'body' ).hasClass( 'simple-phpbb' ) ) {
		addOnScroll( '#page-header .navbar', '.header-overlay', 'sticky' );
		addOnScroll( '.quick-links', '.site-description', 'quick-links-visible' );
		scrollOnPage( '.scroll-to-top', 100, 0 );
		scrollOnPage( '.scroll-to-bottom', 100, khy.variables.bottom );
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
