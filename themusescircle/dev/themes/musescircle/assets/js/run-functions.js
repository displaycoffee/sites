jQuery( document ).ready( function( $ ) {
    toggleNavSubMenus( '#menu-main > li' );

    $( '#front-page-sections #recent-reviews .insprvw-recent-reviews' ).owlCarousel({
    	pagination     : false,
    	navigation     : true,
    	navigationText : ['', '']
    });
});