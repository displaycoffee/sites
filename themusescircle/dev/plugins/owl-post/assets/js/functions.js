// Reset image that's been selected
function opcResetImage( resetButton, selector ) {
    jQuery( resetButton ).click( function() {
        jQuery( selector ).val( '' );
        jQuery( selector ).prev( '.image-preview' ).remove();
    });
}
// WordPress Media Library
function opcSelectImage( selectButton, selector ) {
    // Instantiates the variable that holds the media library frame    
    var opcSelectImageFrame;
 
    // Runs when the image button is clicked
    jQuery( selectButton ).click( function( e ) { 
        // Prevents the default action from occuring
        e.preventDefault();
 
        // If the frame already exists, re-open it
        if ( opcSelectImageFrame ) {
            opcSelectImageFrame.open();
            return;
        }
 
        // Sets up the media library frame
        opcSelectImageFrame = wp.media.frames.opcSelectImageFrame = wp.media({
            title: opcSelectImage.title,
            button: { text: opcSelectImage.selectButton },
            library: { type: 'image' }
        });
 
        // Runs when an image is selected
        opcSelectImageFrame.on( 'select', function() { 
            // Grabs the attachment selection and creates a JSON representation of the model
            var mediaAttachment = opcSelectImageFrame.state().get( 'selection' ).first().toJSON();
 
            // Sends the attachment URL to our custom image input field
            jQuery( selector ).val( mediaAttachment.url );
        });
 
        // Opens the media library frame
        opcSelectImageFrame.open();
    });
}
jQuery( document ).ready( function( $ ) {
    $( '.media-field' ).each( function() {
        var selectButton = $( this ).find( '.image-select' );
        var resetButton = $( this ).find( '.image-reset' );
        var selector = $( this ).find( 'input[type="url"]' );
        opcSelectImage( selectButton, selector );
        opcResetImage( resetButton, selector );
    });    

    $( '.color-select' ).wpColorPicker();

    $( '.opc-options .form-table' ).each( function() {
        $( this ).find( 'tr' ).addClass( 'form-field' );
    });

    $( '.date-picker' ).datepicker();
});