// Get distance for scroll to bottom
var bottomDistance =  jQuery( document ).height() + jQuery( window ).height();

// Base font size for responsive comparisons
var baseFontSize = 16;

// Run all functions on document ready
jQuery( document ).ready( function( $ ) {
	// Check forum listing for no topics and add a class
	var noTopics = $( '.action-bar.bar-top + .panel > .inner > strong' );
	var noTopicsText = noTopics.text();
	
	if ( noTopicsText == 'There are no topics or posts in this forum.' ) {
		noTopics.closest( '.panel' ).addClass( 'no-topics' );
	}

	// Add wrapper around topic review if height is bigger than 400px
	var topicReview = $( '.topicreview' );

	if ( topicReview.length && topicReview[0].scrollHeight > 400 ) {
		topicReview.wrapInner( '<div class="topicreview-wrapper"></div>' );
	}

	// If search has no results, hide "0 matches" pagination text
	var pagination = $( '.section-search .pagination' );

	jQuery( pagination ).each( function() {
		var paginationText = $( this ).text();

		if ( paginationText.indexOf( 'Search found 0 matches' ) >= 0 ) {
			$( this ).parent( '.action-bar' ).hide();
		}
	});

	//console.log(pagination);

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