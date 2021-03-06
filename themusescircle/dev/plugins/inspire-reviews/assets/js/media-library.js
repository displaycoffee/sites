// WordPress Media Library
function insprvwSelectImage( selectButton, selector ) {
    // Instantiates the variable that holds the media library frame    
    var insprvwSelectImageFrame;
 
    // Runs when the image button is clicked
    jQuery( selectButton ).click( function( e ) { 
        // Prevents the default action from occuring
        e.preventDefault();
 
        // If the frame already exists, re-open it
        if ( insprvwSelectImageFrame ) {
            insprvwSelectImageFrame.open();
            return;
        }
 
        // Sets up the media library frame
        insprvwSelectImageFrame = wp.media.frames.insprvwSelectImageFrame = wp.media({
            title: insprvwSelectImage.title,
            button: { text: insprvwSelectImage.selectButton },
            library: { type: 'image' }
        });
 
        // Runs when an image is selected
        insprvwSelectImageFrame.on( 'select', function() { 
            // Grabs the attachment selection and creates a JSON representation of the model
            var mediaAttachment = insprvwSelectImageFrame.state().get( 'selection' ).first().toJSON();
 
            // Sends the attachment URL to our custom image input field
            jQuery( selector ).val( mediaAttachment.url );
        });
 
        // Opens the media library frame
        insprvwSelectImageFrame.open();
    });
}