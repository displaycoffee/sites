// Toggle navigation sub menus
function toggleNavSubMenus( selector ) {
	jQuery( selector ).each( function() {
		// Check if selector has a sub menu
		if ( jQuery( this ).hasClass( 'menu-item-has-children' ) ) {
			// Get current selector
			var current = this;

			// Add a toggle icon after main link element
			jQuery( '<span class="icon icon-chevron-down toggle-submenu"></span>' ).insertAfter( jQuery( current ).find( '> a' ) ); 

			// Create sub menu variables for targetting			
			var subMenuButton = jQuery( current ).find( '.toggle-submenu' );
			var subMenu = jQuery( current ).find( '.sub-menu' );

			// Toggle show/hide class if search button is clicked on
		    jQuery( subMenuButton ).click( function() {
		        jQuery( subMenu ).toggleClass( 'show' );
		        jQuery( subMenuButton ).toggleClass( 'show' );
		    });

		    // If anything outside search-button is clicked on, hide the search bar
			jQuery( document ).on( 'click', function( event ) {
				if ( !jQuery( event.target ).closest( current ).length ) {
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
	// Get variables for the galleries	
    var currentGallery = jQuery( selector );
    var galleryID = jQuery( selector ).attr( 'id' );
    var galleryImageLink = jQuery( selector ).find( '.gallery-item .gallery-icon a' );

    // For each link in a gallery
    jQuery( galleryImageLink ).each( function() {
    	// Check if the link has a valid image extension
		var srcCheck = ( /\.(gif|jpg|jpeg|tiff|png|bmp|svg)$/i ).test( this );     
      
      	// Only add swipebox if links check out to true
		if ( srcCheck == true ) {
			// Add rel attribute for image links to galleries can be connected
			jQuery( this ).attr( 'rel', galleryID );

			// Get the alt attribute on the image element and add as a title to the link for a caption
			var galleryCaption = jQuery( this ).find( 'img' ).attr( 'alt' );
			jQuery( this ).attr( 'title', galleryCaption );

			// Intitalize swipebox
		    jQuery( galleryImageLink ).swipebox({
		        loopAtEnd     : true
		    });
		}
    });
}