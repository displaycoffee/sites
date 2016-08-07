function toggleSearchBar() {
	var searchItem = '#search-menu-container .menu-item';
	var searchButton = '#search-menu-container .search-button';
	var searchForm = '#search-menu-container .search-form';

	// Toggle show/hide class if search button is clicked on
    jQuery( searchButton ).click( function() {
        jQuery( searchForm ).toggleClass( 'show' );
    });

    // If anything outside search-button is clicked on, hide the search bar
	jQuery( document ).on( 'click', function( event ) {
		if ( !jQuery( event.target ).closest( searchItem ).length ) {
			jQuery( searchForm ).removeClass( 'show' );
		}
	});    
}
jQuery( document ).ready( function( $ ) {
    toggleSearchBar();
});