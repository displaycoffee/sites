// Site URL from theme funtions.php file
var url = wpurl.siteurl;

jQuery( document ).ready( function( $ ) {
    toggleNavSubMenus( '#header-nav .menu-main-container .menu > li' );
    hideNavigation( 'body.attachment .navigation-links' );
    addSwipeBoxGallery( '.gallery' );
    initializeCountdown();
    
    $( '#front-page-sections #recent-reviews .insprvw-recent-reviews' ).owlCarousel({
    	pagination     : false,
    	navigation     : true,
    	navigationText : [
    		'<span class="icon icon-chevron-left"></span>',
    		'<span class="icon icon-chevron-right"></span>'
    	]
    });
});