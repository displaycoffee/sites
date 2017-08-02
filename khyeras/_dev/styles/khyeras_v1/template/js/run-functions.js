// Get distance for scroll to bottom
var bottomDistance =  jQuery( document ).height() + jQuery( window ).height();

// Base font size for responsive comparisons
var baseFontSize = 16;

// Run all functions on document ready
jQuery( document ).ready( function( $ ) {
	// Check forum listing for no topics and add a class
	var noTopics = $( '.section-viewforum .forum-title ~ .panel > .inner > strong' );
	var noTopicsText = noTopics.text();

	if ( noTopicsText == 'There are no topics or posts in this forum.' ) {
		noTopics.closest( '.panel' ).addClass( 'no-topics' );
	}

	// If there are posting buttons, add a wrapper for button adjustments
	var postingButtons = $( '.section-posting #postform .submit-buttons' );

	if ( postingButtons.length ) {
		postingButtons.closest( '.panel' ).add( '.section-posting #postform #postingbox' ).wrapAll('<div class="posting-wrapper panel"></div>');
	} 

	// Add wrapper around topic review if height is bigger than 400px
	var topicReview = $( '.topicreview' );

	if ( topicReview.length && topicReview[0].scrollHeight > 400 ) {
		topicReview.wrapInner( '<div class="topicreview-wrapper"></div>' );
	}

	// addFeatherLightGallery( '.gallery' );
	scrollOnPage( '.scroll-to-top', 100, 0 );
	scrollOnPage( '.scroll-to-bottom', 100, bottomDistance );
	// toggleSpoilerContent();

	// initializeMobileMenu({
	//     menu          : '#header-nav .menu-main-container',
	//     menuContainer : '#header-nav .wrapper',
	//     mobileButton  : '.mobile-menu-button',
	//     mobileMenu    : '#mobile-menu',
	//     width         : 768
	// });
});