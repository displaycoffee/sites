// Function for scrollable areas
function addScrollableArea( selector ) {
	selector.addClass( 'scrollable' );
	selector.wrapInner( '<div class="scrollable-wrapper"></div>' );
}

// Convert WordPress galleries with images into a featherlight gallery
function addFeatherLightGallery( selector ) {
	jQuery( selector ).each( function() {
		// Get variables for the galleries
		var currentGallery = jQuery( this );
		var galleryID = currentGallery.attr( 'id' );
		var galleryImageLink = currentGallery.find( '.gallery-item .gallery-icon a' );
		var galleryValid;

		// Check all links in a gallery to see if they link to valid image file extensions
		jQuery( galleryImageLink ).each( function() {
			// Get the current image link
			var currentImageLink = jQuery( this );

			// Check if the link has a valid image extension
			var srcCheck = ( /\.(gif|jpg|jpeg|tiff|png|bmp|svg)$/i ).test( currentImageLink.attr( 'href' ) );

			// If gallery has all valid links, set gallery to valid
			if ( srcCheck == false ) {
				galleryValid = false;
				return false;
			} else {
				galleryValid = galleryID;
			}
		});

		// If the gallery is valid...
		if ( galleryValid == galleryID ) {
			jQuery( galleryImageLink ).featherlightGallery({
				previousIcon  : '<span class="icon icon-chevron-left"></span>',
				nextIcon	  : '<span class="icon icon-chevron-right"></span>',
				closeIcon	  : '<span class="icon icon-close"></span>',
				galleryFadeIn : 300,
				openSpeed	  : 300,
				afterOpen	  : function(event){
					jQuery( 'body, html' ).addClass( 'featherlight-open' );
				},
				afterClose	  : function(event){
					jQuery( 'body, html' ).removeClass( 'featherlight-open' );
				}
			});
		}
	});
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
	jQuery( selector ).click( function() {
		jQuery( 'html, body' ).animate({
			scrollTop : position
		}, 1000 );
		return false;
	});
}

// Spoiler toggle functionality
function toggleSpoilerContent() {
	// Loop through any spoiler codes on page
	jQuery( '.spoiler' ).each( function() {
		// Get variables for spoiler
		var currentSpoiler = jQuery( this );
		var spoilerClose = currentSpoiler.find( '.spoiler-close' );
		var spoilerOpen = currentSpoiler.find( '.spoiler-open' );
		var spoilerContent = currentSpoiler.find( '.spoiler-content' );

		// Hide spoiler close tag and content by default
		spoilerClose.add( spoilerContent ).addClass( 'spoiler-hide' );

		// Click event for showing spoiler content
		jQuery( spoilerOpen ).click( function() {
			spoilerClose.add( spoilerContent ).addClass( 'spoiler-show' ).removeClass( 'spoiler-hide' );
			spoilerOpen.addClass( 'spoiler-hide' ).removeClass( 'spoiler-show' );
		});

		// Click event for hiding spoiler content
		jQuery( spoilerClose ).click( function() {
			spoilerClose.add( spoilerContent ).addClass( 'spoiler-hide' ).removeClass( 'spoiler-show' );
			spoilerOpen.addClass( 'spoiler-show' ).removeClass( 'spoiler-hide' );
		});

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
	mobileButton.click( function() {
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
				// Create a mobile header and insert it at the top
				var mobileButton = '<header class="mobile-menu-header"><span class="mobile-header">Menu</span><span class="icon icon-remove"></span></header>';
				jQuery( mobileButton ).appendTo( mobileMenu );

				// Close menu when button is clicked on
				jQuery( '.mobile-menu-header .icon-remove' ).click( function() {
					toggleMobileMenu();
				});

				// Move menu to menu container
				menu.detach().appendTo( mobileMenu );

				// In that mobile menu container, look for first level list and its items
				menu.children( 'ul' ).children( 'li' ).each( function() {
					// Get current selector and check if there are any second level lists
					var current = jQuery( this );
					var children = current.children( 'ul' );

					// If there is a second level list, add a menu toggle icon
					if ( children.length > 0 ) {
						jQuery('<span class="icon icon-chevron-right slide-submenu"></span>').insertBefore( children );
					}
				});

				// Add/remove classes to slide second level menu open
				jQuery( '.slide-submenu' ).click( function() {
					if ( jQuery( this ).next().hasClass( 'slide-open' ) ) {
						menu.children( 'ul' ).children( 'li' ).removeClass( 'slide-close' );
						jQuery( this ).next().add( jQuery( this ).parent() ).removeClass( 'slide-open' );
					} else {
						menu.children( 'ul' ).children( 'li' ).addClass( 'slide-close' );
						jQuery( this ).next().add( jQuery( this ).parent() ).addClass( 'slide-open' ).removeClass('slide-close');
					}
				});

				// After everything has been done, set mobile to true so it's not run again on resize
				mobileOnce = true;
			}
		} else {
			// Check if mobile is true, meaning we're resizing and want to clean up on resize
			if ( mobileOnce ) {
				// Remove close button, replace menu, remove slide menu toggle, and remove any extra slide-open class
				jQuery( '.mobile-menu-header' ).remove()
				menu.detach().appendTo( menuContainer );
				jQuery( '.slide-submenu' ).remove();
				jQuery( 'ul, li' ).removeClass( 'slide-open' );
				jQuery( 'li' ).removeClass( 'slide-close' );
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
