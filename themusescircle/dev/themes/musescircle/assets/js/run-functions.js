// Site URL from theme funtions.php file
var url = wpurl.siteurl;

jQuery( document ).ready( function( $ ) {
    toggleNavSubMenus( '.menu-main-container .menu > li' );

    $( '#front-page-sections #recent-reviews .insprvw-recent-reviews' ).owlCarousel({
    	pagination     : false,
    	navigation     : true,
    	navigationText : [
    		'<span class="icon icon-chevron-left"></span>',
    		'<span class="icon icon-chevron-right"></span>'
    	]
    });
});