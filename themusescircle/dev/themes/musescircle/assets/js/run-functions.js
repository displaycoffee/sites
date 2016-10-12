// Site URL from theme funtions.php file
var url = wpurl.siteurl;

jQuery( document ).ready( function( $ ) {
    toggleNavSubMenus( '#header-nav .menu-main-container .menu > li' );
    hideNavigation( 'body.attachment .navigation-links' );

    $( '#front-page-sections #recent-reviews .insprvw-recent-reviews' ).owlCarousel({
    	pagination     : false,
    	navigation     : true,
    	navigationText : [
    		'<span class="icon icon-chevron-left"></span>',
    		'<span class="icon icon-chevron-right"></span>'
    	]
    });

    jQuery( '.gallery' ).each( function() {
        var currentGallery = $( this );
        var galleryID = $(this).attr('id');
        var galleryImageLink = $( currentGallery ).find( '.gallery-item .gallery-icon a' );

        $( galleryImageLink ).attr( 'rel', galleryID );

//        console.log(galleryID);

        //$( galleryImageLink ).swipebox();

        $( galleryImageLink ).swipebox({
            loopAtEnd: true
        });

        //$( '.swipebox' ).swipebox();
    });
});