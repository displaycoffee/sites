// Site URL from theme funtions.php file
var url = wpurl.siteurl;

// Get distance for scroll to bottom
var bottomDistance =  jQuery( document ).height() + jQuery( window ).height();

// Base font size for responsive comparisons
var baseFontSize = 16;

// Run all functions on document ready
jQuery( document ).ready( function( $ ) {
    toggleNavSubMenus( '#header-nav .menu-main-container .menu > li' );
    hideNavigation( 'body.attachment .navigation-links' );
    addSwipeBoxGallery( '.gallery' );
    initializeCountdown();
    hideCountdown();
    scrollOnPage( '.scroll-to-top', 100, 0 );
    scrollOnPage( '.scroll-to-bottom', 100, bottomDistance );
    toggleSpoilerContent();

    initializeMobileMenu({
        menu          : '.menu-main-container',
        menuContainer : '#header-nav .wrapper',
        mobileButton  : '.mobile-menu-button',
        mobileMenu    : '#mobile-menu',
        width         : 768
    });

    $( '#front-page-sections #recent-reviews .insprvw-recent-reviews' ).owlCarousel({
    	pagination     : false,
    	navigation     : true,
    	navigationText : [
    		'<span class="icon icon-chevron-left"></span>',
    		'<span class="icon icon-chevron-right"></span>'
    	]
    });
});