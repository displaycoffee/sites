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
	body[0].className = body[0].className + (' ' + bodyClass);
}

// Check if submit buttons have a parent "panel" class and if so, remove it
var submitButtons = document.querySelectorAll( '.submit-buttons' );

for ( var i = 0; i < submitButtons.length; i++ ) {
	var inner = submitButtons[i].parentNode.className;
	var panel = submitButtons[i].parentNode.parentNode.className;

	// Do the parent elements have an inner or panel class?
	if ( inner.indexOf( 'inner' ) >= 0 || panel.indexOf( 'panel' ) >= 0 ) {
		submitButtons[i].parentNode.parentNode.classList.remove( 'panel' );
	}
}

// Run all functions on document ready
jQuery( document ).ready( function( $ ) {
	// Add wrapper around topic review if height is bigger than 400px
	var topicReview = $( '.section-posting .topicreview' );

	if ( topicReview.length && topicReview[0].scrollHeight > 400 ) {
		topicReview.wrapInner( '<div class="topicreview-wrapper"></div>' );
	}

	// Check if topic review in ucp/mcp should be scrollable
	var ucpTopicReview = $( '.cp-main .topicreview' );

	if ( ucpTopicReview.length && ucpTopicReview[0].scrollHeight > 375 ) {
		ucpTopicReview.addClass( 'scrollable' );
	} else {
		$( '.cp-main .review .right-box' ).hide();
	}

	// Check if post details in mcp should be scrollable
	var mcpPostDetails = $( '.mcp-main #post_details' );

	if ( mcpPostDetails.length && mcpPostDetails[0].scrollHeight > 375 ) {
		mcpPostDetails.addClass( 'scrollable' );
	} else {
		$( '.mcp-main .post-buttons #expand' ).hide();
	}

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

	// If search has no results, hide "0 matches" pagination text
	var pagination = $( '.section-search .pagination' );

	jQuery( pagination ).each( function() {
		var paginationText = $( this ).text();

		if ( paginationText.indexOf( 'Search found 0 matches' ) >= 0 ) {
			$( this ).parent( '.action-bar' ).hide();
		}
	});

	// Add wrapper around control panel elements
	var cpMenu = $( '.cp-menu' );
	var cpMain = $( '.cp-main' );

	if ( cpMenu || cpMain ) {
		cpMenu.parent().addClass('cp-wrapper');
		cpMain.parent().addClass('cp-wrapper');
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
