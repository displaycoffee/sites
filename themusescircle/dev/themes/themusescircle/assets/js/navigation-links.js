// Check if simple-navigation on attachment.php is empty. If so, remove it
function checkSimpleNav() {
	if ( jQuery( 'body' ).hasClass( 'attachment' ) || jQuery( 'body' ).hasClass( 'single' ) ) {
		// Get length of child elements in previous and next
		var previous = jQuery( '.navigation-links .prev' ).children().length;
		var next = jQuery( '.navigation-links .next' ).children().length;
		
		// Hide simple-navigation elements if they are empty
		if ( !previous && !next ) {
			jQuery( '.navigation-links' ).remove();
		} else if ( !previous ) {
			jQuery( '.navigation-links .prev' ).remove();
		} else if ( !next ) {
			jQuery( '.navigation-links .next' ).remove();
		}
	}
}