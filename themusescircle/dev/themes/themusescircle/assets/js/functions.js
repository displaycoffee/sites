function toggleSearchBar() {
	// Toggle show/hide class if search button is clicked on
    jQuery( '.search-toggle .search-button a' ).click( function() {
        jQuery( '.search-toggle .search-bar' ).toggleClass( 'show' );
    });

    // If anything outside search-button is clicked on, hide the search bar
	jQuery( document ).on( 'click', function( event ) {
		if ( !jQuery( event.target ).closest( '.search-toggle' ).length ) {
			jQuery( '.search-toggle .search-bar' ).removeClass( 'show' );
		}
	});    
}
jQuery( document ).ready( function( $ ) {
    toggleSearchBar();
});