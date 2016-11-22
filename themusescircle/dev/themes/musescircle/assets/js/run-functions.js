// Site URL from theme funtions.php file
var url = wpurl.siteurl;

// Get distance for scroll to bottom
var bottomDistance =  jQuery( document ).height() + jQuery( window ).height();

jQuery( document ).ready( function( $ ) {
    toggleNavSubMenus( '#header-nav .menu-main-container .menu > li' );
    hideNavigation( 'body.attachment .navigation-links' );
    addSwipeBoxGallery( '.gallery' );
    initializeCountdown();
    hideCountdown();
    scrollOnPage( '.scroll-to-top', 100, 0 );
    scrollOnPage( '.scroll-to-bottom', 100, bottomDistance );
    toggleSpoilerContent();

    var mobile_once = false;
    if ( !mobile_once ) {
        initializeMobileMenu( '.menu-main-container', 767 );
        mobile_once = true;
    };

    $( '#front-page-sections #recent-reviews .insprvw-recent-reviews' ).owlCarousel({
    	pagination     : false,
    	navigation     : true,
    	navigationText : [
    		'<span class="icon icon-chevron-left"></span>',
    		'<span class="icon icon-chevron-right"></span>'
    	]
    });
});