// Check if area should be scrollable
function addScrollableArea( selector, selectorHeight, selectorHide ) {
	if ( selector.length && selector[0].scrollHeight > selectorHeight ) {
		selector.addClass( 'scrollable' );
		selector.wrapInner( '<div class="scrollable-wrapper"></div>' );
	} else {
		selectorHide.hide();
	}
}

// Scroll to top functionality
// Modified from https://paulund.co.uk/how-to-create-an-animated-scroll-to-top-with-jquery
function scrollOnPage( selector, distance, position ) {
	// Check to see if the window is top if not then display button
	jQuery( window ).scroll( function() {
		if ( jQuery( this ).scrollTop() > distance ) {
			jQuery( selector ).fadeIn();
		} else {
			jQuery( selector ).fadeOut();
		}
	});

	// Click event to scroll to top
	jQuery( selector ).on( 'click', function() {
		jQuery( 'html, body' ).animate({
			scrollTop : position
		}, 1000 );
		return false;
	});
}

// Function to show/hide certain elements on mobile
function toggleMobileContent( button, selector ) {
	jQuery( button ).off().on( 'click', function() {
		if ( jQuery( selector ).hasClass( 'toggle-show' ) ) {
			jQuery( selector ).removeClass( 'toggle-show' );
		} else {
			jQuery( selector ).addClass( 'toggle-show' );
		}
	});
}

// Debounce function from underscore.js and https://davidwalsh.name/javascript-debounce-function
function debounce( func, wait, immediate ) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if ( !immediate ) {
				func.apply( context, args );
			}
		};
		var callNow = immediate && !timeout;
		clearTimeout( timeout );
		timeout = setTimeout( later, wait );
		if ( callNow ) {
			func.apply( context, args );
		}
	};
};
// Initialize Mobile Menu
function initializeMobileMenu( options ) {
	// Variables from mobile object
	var menu = jQuery( options.menu );
	var menuContainer = jQuery( options.menuContainer );
	var mobileButton = jQuery( options.mobileButton );
	var mobileMenu = jQuery( options.mobileMenu );
	var width = options.width;

	// Set a mobile false state (for window resize mainly)
	var mobileOnce = false;

	// Create open / close function
	function toggleMobileMenu() {
		if ( mobileMenu.hasClass( 'show' ) ) {
			mobileMenu.removeClass( 'show' );
			jQuery( 'body, html' ).removeClass( 'mobile-open' );
		} else {
			mobileMenu.addClass( 'show' );
			jQuery( 'body, html' ).addClass( 'mobile-open' );
		}
	}

	// Add/remove classes when mobile menu button is clicked on
	mobileButton.off().on( 'click', function() {
		toggleMobileMenu();
	});

	// Resize actions for mobile menu
	function mobileResizeAction() {
		// Widths for em comparison
		var windowWidth = ( window.innerWidth / baseFontSize );
		var docWidth = ( document.documentElement.clientWidth / baseFontSize );
		var bodyWidth = ( document.body.clientWidth / baseFontSize );
		var responseWidth = ( width / baseFontSize );

		// Check all sorts of window and document widths to make sure resizing is consistent across browsers
		if ( ( windowWidth || docWidth || bodyWidth ) <= responseWidth ) {
			// Check if mobile ones is false, meaning we haven't activated the mobile menu yet
			if ( !mobileOnce ) {
				// Close menu when button is clicked on
				jQuery( '.mobile-menu-header .fa-times' ).off().on( 'click', function() {
					toggleMobileMenu();
				});

				// Move menu to menu container
				menu.detach().appendTo( mobileMenu );

				// In that mobile menu container, look for first level list and its items
				menu.children( '.dropdown-container' ).each( function() {
					jQuery('<i class="icon fa-chevron-right slide-submenu"></i>').appendTo( this );
				});

				// Add/remove classes to slide second level menu open
				var mainMenuLinks = jQuery( options.mobileMenu + ' > ul > li' );
				mainMenuLinks.find( ' .slide-submenu' ).off().on( 'click', function() {
					var parentElement = jQuery( this ).parent();
					if ( parentElement.hasClass( 'dropdown-open' ) ) {
						mainMenuLinks.removeClass( 'dropdown-close' );
						parentElement.removeClass( 'dropdown-open' );
					} else {
						mainMenuLinks.addClass( 'dropdown-close' );
						parentElement.removeClass( 'dropdown-close' ).addClass( 'dropdown-open' );
					}
				});

				// After everything has been done, set mobile to true so it's not run again on resize
				mobileOnce = true;
			}
		} else {
			// Check if mobile is true, meaning we're resizing and want to clean up on resize
			if ( mobileOnce ) {
				// Remove close button, replace menu, remove slide menu toggle, and remove any extra slide-open class
				menu.detach().appendTo( menuContainer );
				jQuery( '.slide-submenu' ).remove();
				jQuery( 'li' ).removeClass( 'dropdown-close' ).removeClass( 'dropdown-open' );
				jQuery( 'body, html' ).removeClass( 'mobile-open' );
				mobileMenu.removeClass( 'show' );
				// Then set mobile to false again so we can start over
				mobileOnce = false;
			}
		}
	}

	// Call mobile menu once if browser is brought up or refreshed
	mobileResizeAction();

	// Then run mobile menu on resizing using debounce
	var resizeForMobile = debounce(function() {
		mobileResizeAction();
	}, 100 );
	window.addEventListener( 'resize', resizeForMobile );
}
