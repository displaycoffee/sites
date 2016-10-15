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