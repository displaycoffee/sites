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