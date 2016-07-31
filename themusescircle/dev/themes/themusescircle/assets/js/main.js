function toggleSearchBar() {
	// Toggle show/hide class if search button is clicked on
    jQuery( '.search-button a' ).click( function() {
        jQuery( '.search-header-bar' ).toggleClass( 'show' );
    });

    // If anything outside search-button is clicked on, hide the search bar
	jQuery( document ).on( 'click', function( event ) {
		if ( !jQuery( event.target ).closest( '.search-button' ).length ) {
			jQuery( '.search-header-bar' ).removeClass( 'show' );
		}
	});    
}