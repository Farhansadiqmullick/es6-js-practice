jQuery( document ).ready( function( $ ) {
    $( '.colorpicker' ).wpColorPicker(); 

    function initColorPicker( widget ) {
        widget.find( '.widget-colorpicker' ).not('[id*="__i__"]').wpColorPicker( {
            change: _.throttle( function() {
                $(this).trigger( 'change' );
            }, 3000 )
        });
    }

    function onFormUpdate( event, widget ) {
        initColorPicker( widget );
    }

    $( document ).on( 'widget-added widget-updated', onFormUpdate );

    $( '.widget-inside:has(.widget-colorpicker)' ).each( function () {
        initColorPicker( $( this ) );
    } );
} ); 