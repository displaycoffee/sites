// Check for spaces inside elements
function checkForSpace( selector ) {
	jQuery( selector ).each( function() {
		var selectorHTML = jQuery( this );

		if ( selectorHTML.html() == '&nbsp;' || selectorHTML.html() == '<label>&nbsp;</label>' ) {
			selectorHTML.addClass( 'empty-space' );
		} else {
			selectorHTML.removeClass( 'empty-space' );
		}
	});
}

// Check if area should be scrollable
function addScrollableArea( selector, selectorHeight, selectorHide ) {
	if ( selector.length && selector[0].scrollHeight > selectorHeight ) {
		selector.addClass( 'scrollable' );
		selector.wrapInner( '<div class="scrollable-wrapper"></div>' );
	} else {
		selectorHide.hide();
	}
}

// Add class for image attachments adjustments
function updateaAttachmentDisplay( selector ) {
	jQuery( selector ).on( 'click', function( e ) {
		var parentImageContainer = jQuery( this ).closest( '.file' ).parent();

		if ( parentImageContainer.hasClass( 'image-expanded' ) ) {
			parentImageContainer.removeClass( 'image-expanded' );
		} else {
			parentImageContainer.addClass( 'image-expanded' );
		}
	});
}

// Function display-actions div because the markup is a mess
// This prevents editting a number of templates
function formatDisplayActions() {
	jQuery( '.display-actions' ).each( function() {
		var current = jQuery( this );

		// Remove spaces
		current.html( current.html().replace( /&nbsp;/g, '' ).replace( /::/g, '&bull;' ) );

		// Find mark / unmark buttons
		var markButtons = current.find( ' div a' );

		if ( markButtons.text().toLowerCase().indexOf( 'mark' ) !== -1 ) {
			markButtons.parent( 'div' ).addClass( 'mark-actions' );
		}

		// Find select menus with a button and wrap a div around
		var selectMenu = current.children( 'select' );

		selectMenu.each( function() {
			jQuery( this ).next( '.button1, .button2' ).addBack().wrapAll( '<div class="select-actions"></div>' );
		});

		// Add a new inner wrapper
		// Keep at the bottom to do this last
		current.wrapInner( '<div class="display-actions-wrapper"></div>' );
	});
}

// Add sticky class to navigation when scroll
function addOnScroll( selector, anchor, class ) {
	// Variables for scroll logic
	var anchor = jQuery( anchor ).offset().top;
	var windowSelector = jQuery( window );
	var scrollCheck = false;

	windowSelector.scroll( function() {
		if (scrollCheck == false) {
			if ( windowSelector.scrollTop() > anchor ) {
				jQuery( selector ).addClass( class );
				scrollCheck = true;
			}
		} else {
			if ( windowSelector.scrollTop() <= anchor ) {
				jQuery( selector ).removeClass( class );
				scrollCheck = false;
			}
		}
	});
}

function addStickyNav( selector, anchor ) {
	// Variables for scroll logic
	var anchor = jQuery( anchor ).offset().top;
	var windowSelector = jQuery( window );
	var scrollCheck = false;

	windowSelector.scroll( function() {
		if (scrollCheck == false) {
			if ( windowSelector.scrollTop() > anchor ) {
				jQuery( selector ).addClass( 'sticky' );
				scrollCheck = true;
			}
		} else {
			if ( windowSelector.scrollTop() <= anchor ) {
				jQuery( selector ).removeClass( 'sticky' );
				scrollCheck = false;
			}
		}
	});
}

// Scroll to top functionality
// Modified from https://paulund.co.uk/how-to-create-an-animated-scroll-to-top-with-jquery
function scrollOnPage( selector, distance, position ) {
	// Check to see if the window is top if not then display button
	addOnScroll( selector, '.site-description', 'scroll-to-visible' );

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

// Initialize Dropdown Resize for mobile
function initializeDropDownResize() {
	var dropdownToggle = jQuery( '.page-body .dropdown-toggle' );
	var lastPosition = false;
	var visibleSelector = '.page-body .dropdown-container.dropdown-visible';

	dropdownToggle.on( 'click', function( event ) {
		var onMobile = isMobile( baseFontSize, ( 600 / baseFontSize ) );
		var toggle = jQuery( this );
		var dropdown = toggle.parent().find( '.dropdown' );

		// Check if dropdown is visible
		if ( jQuery( visibleSelector ).length ) {
			// If initially on mobile, add dropdown position
			if ( onMobile ) {
				addDropdownPosition( toggle, dropdown );
			}

			// Otherwise, watch for browser resize
			window.addEventListener( 'resize', resizeDropDownForMobile );
		} else {
			// If dropdown is toggled close, reset position and remove resize event
			resetDropdownPosition( dropdown, true );
		}

		// If clicked outside dropdown, reset position and remove resize event
		jQuery( document ).on( 'click', function( event ) {
			resetDropdownPosition( dropdown, true );
		});
	});

	var resizeDropDownForMobile = function() {
		var onMobile = isMobile( baseFontSize, ( 600 / baseFontSize ) );
		var toggle = jQuery( visibleSelector ).find( '.dropdown-toggle' );
		var dropdown = jQuery( visibleSelector ).find( '.dropdown' );

		// Add and remove dropdown positions based on browser width
		if ( onMobile ) {
			addDropdownPosition( toggle, dropdown );
		} else {
			resetDropdownPosition( dropdown, false );
		}
	};

	// Function to add position styles
	function addDropdownPosition( anchor, dropdown ) {
		var position = -( anchor.offset().left - 20 );
		var dropdownPosition = ( dropdown.offset().left - 20 );

		if ( dropdownPosition != 0 ) {
			dropdown.css( 'left', position  );
		}
	}

	// Function to reset position styles
	function resetDropdownPosition( dropdown, eventRemove ) {
		dropdown.css( 'left', ''  );
		if ( eventRemove ) {
			window.removeEventListener( 'resize', resizeDropDownForMobile );
		}
	}
}

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
		// Check if we are on mobile
		var onMobile = isMobile( baseFontSize, ( width / baseFontSize ) );

		// Check all sorts of window and document widths to make sure resizing is consistent across browsers
		if ( onMobile ) {
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
	var resizeMenuForMobile = debounce( function() {
		mobileResizeAction();
	}, 100 );
	window.addEventListener( 'resize', resizeMenuForMobile );
}
