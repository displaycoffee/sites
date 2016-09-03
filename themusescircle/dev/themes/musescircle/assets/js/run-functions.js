// Site URL from theme funtions.php file
var url = wpurl.siteurl;

jQuery( document ).ready( function( $ ) {
    toggleNavSubMenus( '#menu-main > li' );

    $( '#front-page-sections #recent-reviews .insprvw-recent-reviews' ).owlCarousel({
    	pagination     : false,
    	navigation     : true,
    	navigationText : [
    		'<svg class="icon icon-chevron-left" viewBox="0 0 24 32"><use xlink:href="' + url + '/wp-content/themes/musescircle/assets/images/icons.svg#icon-chevron-left"></use></svg>',
    		'<svg class="icon icon-chevron-right" viewBox="0 0 22 32"><use xlink:href="' + url + '/wp-content/themes/musescircle/assets/images/icons.svg#icon-chevron-right"></use></svg>'
    	]
    });
});