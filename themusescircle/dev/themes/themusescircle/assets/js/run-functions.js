jQuery( document ).ready( function( $ ) {
    toggleNavSubMenus( '#menu-main-menu > li' );

    $( '.insprvw-recent-reviews' ).owlCarousel({
    	pagination     : false,
    	navigation     : true,
    	navigationText : ['', '']
    });
});