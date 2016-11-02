// Toggle navigation sub menus
function toggleNavSubMenus( selector ) {
	jQuery( selector ).each( function() {
		// Get current nav selector
		var currentNav = jQuery( this );

		// Check if selector has a sub menu
		if ( currentNav.hasClass( 'menu-item-has-children' ) ) {
			// Add a toggle icon after main link element
			jQuery( '<span class="icon icon-chevron-down toggle-submenu"></span>' ).insertAfter( currentNav.find( '> a' ) ); 

			// Create sub menu variables for targetting			
			var subMenuButton = currentNav.find( '.toggle-submenu' );
			var subMenu = currentNav.find( '.sub-menu' );

			// Toggle show/hide class if search button is clicked on
		    jQuery( subMenuButton ).click( function() {
		        jQuery( subMenu ).toggleClass( 'show' );
		        jQuery( subMenuButton ).toggleClass( 'show' );
		    });

		    // If anything outside search-button is clicked on, hide the search bar
			jQuery( document ).on( 'click', function( event ) {
				if ( !jQuery( event.target ).closest( currentNav ).length ) {
					jQuery( subMenu ).removeClass( 'show' );
					jQuery( subMenuButton ).removeClass( 'show' );
				}
			}); 
		}
	});
}

// Remove navigation when empty - mostly for attachment.php navigation
function hideNavigation( selector ) {
	var previous = jQuery( selector ).find( '.prev' );
	var next = jQuery( selector ).find( '.next' );

	// Remove previous link there's nothing there
	if ( previous.children().length == 0 ) {
		previous.remove();
	}

	// Remove next link there's nothing there
	if ( next.children().length == 0 ) {
		next.remove();
	}

	// If previous and next links are empty, remove pagination/selector container
	if ( ( previous.children().length == 0 ) && ( next.children().length == 0 ) ) {
		jQuery( selector ).remove();
	}
}

// Convert WordPress galleries with images into a swipebox gallery
function addSwipeBoxGallery( selector ) {
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
            // Loop through links and add necessary elements for swipebox
            jQuery( galleryImageLink ).each( function() {
                // Get the current image link
                currentImageLink = jQuery( this );

                // Add rel attribute for image links to galleries can be connected
                currentImageLink.attr( 'rel', galleryID );

                // Add swipebox class to add swipebox
                currentImageLink.attr( 'class', 'swipebox' );

                // Get the alt attribute on the image element and add as a title to the link for a caption
                var galleryCaption = currentImageLink.find( 'img' ).attr( 'alt' );
                currentImageLink.attr( 'title', galleryCaption );

	            // Intitalize swipebox
	            jQuery( '.swipebox' ).swipebox({
	                loopAtEnd     : true
	            });
            });
        }
    });
}

// Countdown functions modified from http://www.sitepoint.com/build-javascript-countdown-timer-no-dependencies
// Dates can be entered as... month/day/year, month-day-year, or Month Day, Year

// Get remaining time from an end date
function getRemainingTime( endTime ) {
	// Get remaining time by subtracting end and current date
	var remainingTime = Date.parse( endTime ) - Date.parse( new Date() );	

	// Create total number of seconds for time calculations
	var totalSeconds = Math.floor( remainingTime / 1000 );

	// Create object to store time data
	return {
		'remaining' : remainingTime,
		'days'      : Math.floor( totalSeconds / 60 / 60 / 24 ),
		'hours'     : Math.floor( totalSeconds / 60 / 60 ) % 24,
		'minutes'   : Math.floor( totalSeconds / 60 ) % 60,
		'seconds'   : totalSeconds % 60
	};
}

// Initialize countdown
function initializeCountdown() {
	// Loop through all countdown elements on the page
	jQuery( '.countdown-timer' ).each( function() {
		// Countdown selector 
		var countdown = jQuery( this );

		// Get end date
		var end = this.dataset.endDate;

		// Get time values
		var time = getRemainingTime( end );

		// Check if there is any remaining time left
		if ( time.remaining > 0 ) {
			// Create inner countdown markup
			function createCountdownMarkup( text ) {
				return '<div class="' + text + '"><span class="countdown-value"></span><span class="countdown-label">' + text + '</span></div>'
			}

			// Add timer elements to countdown div
			countdown.append( createCountdownMarkup( 'days' ), createCountdownMarkup( 'hours' ), createCountdownMarkup( 'minutes' ), createCountdownMarkup( 'seconds' ) );

			// Selectors for time elements
			var daysSelector = countdown.find( '.days .countdown-value' );
			var hoursSelector = countdown.find( '.hours .countdown-value' );
			var minutesSelector = countdown.find( '.minutes .countdown-value' );
			var secondsSelector = countdown.find( '.seconds .countdown-value' );

			// Add values to countdown
			daysSelector.append( ( '0' + time.days ).slice( -2 ) );
			hoursSelector.append( ( '0' + time.hours ).slice( -2 ) );
			minutesSelector.append( ( '0' + time.minutes ).slice( -2 ) );
			secondsSelector.append( ( '0' + time.seconds ).slice( -2 ) );			

			// Update the clock values
			function updateClock() {
				// Get latest time
				var time = getRemainingTime( end );

				// Check if time values have changed 
				if ( daysSelector.text() != time.days ) {
					daysSelector.text( ( '0' + time.days ).slice( -2 ) );
				}
				if ( hoursSelector.text() != time.hours ) {
					hoursSelector.text( ( '0' + time.hours ).slice( -2 ) );
				}
				if ( minutesSelector.text() != time.minutes ) {
					minutesSelector.text( ( '0' + time.minutes ).slice( -2 ) );
				}
				if ( secondsSelector.text() != time.seconds ) {
					secondsSelector.text( ( '0' + time.seconds ).slice( -2 ) );
				}

				// If there is no remaining time, stop the countdown
				if ( time.remaining <= 0 ) {
					clearInterval( timeinterval );
				}
			}

			// Run update clock on one second intervals
			updateClock();
			var timeinterval = setInterval( updateClock, 1000 );
		} else {
			countdown.remove();
		}
	});
}

initializeCountdown();