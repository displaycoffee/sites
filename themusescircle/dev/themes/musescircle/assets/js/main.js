var url = wpurl.siteurl;

// Toggle navigation sub menus
function toggleNavSubMenus( selector ) {
	jQuery( selector ).each( function() {
		// Check if selector has a sub menu
		if ( jQuery( this ).hasClass( 'menu-item-has-children' ) ) {
			// Get current selector
			var current = this;

			// Add a toggle icon after main link element
			jQuery( '<svg class="icon icon-chevron-down toggle-submenu" viewBox="0 0 32 32"><use xlink:href="' + url + '/wp-content/themes/musescircle/assets/images/icons.svg#icon-chevron-down"></use></svg>' ).insertAfter( jQuery( current ).find( '> a' ) ); 

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