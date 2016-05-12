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