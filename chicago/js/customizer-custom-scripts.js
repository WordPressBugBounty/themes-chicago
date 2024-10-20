/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 */
( function( api ) {
    api.controlConstructor.radio = api.Control.extend( {
        ready: function() {
            if ( 'color_scheme' === this.id ) {
                this.setting.bind( 'change', function( color_scheme ) {
                    jQuery.each( chicago_misc_links.color_list, function( index, value ) {
                        if ( 'light' == color_scheme ) {
                            api( index ).set( value.light );
                            api.control( index ).container.find( '.color-picker-hex' )
                            .data( 'data-default-color', value.light )
                            .wpColorPicker( 'defaultColor', value.light );
                        }
                        else if ( 'dark' == color_scheme ) {
                            api( index ).set( value.dark );
                            api.control( index ).container.find( '.color-picker-hex' )
                            .data( 'data-default-color', value.dark )
                            .wpColorPicker( 'defaultColor', value.dark );
                        }
                        else if ( 'pink' == color_scheme ) {
                            api( index ).set( value.pink );
                            api.control( index ).container.find( '.color-picker-hex' )
                            .data( 'data-default-color', value.pink )
                            .wpColorPicker( 'defaultColor', value.pink );
                        }
                    });
                });
            }
        }
    });
} )( wp.customize );