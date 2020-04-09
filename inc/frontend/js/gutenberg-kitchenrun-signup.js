/**
 * Will be used later for Kitchen Run Gutenberg Block
 */
/**( function( blocks, i18n, element ) {
    var el = element.createElement;
    var __ = i18n.__;

    var blockStyle = {
        backgroundColor: '#900',
        color: '#fff',
        padding: '20px',
    };

    blocks.registerBlockType( 'gutenberg-kitchenrun/kitchenrun-signup', {
        title: __( 'Kitchenrun: Sign Up Form', 'gutenberg-kitchenrun' ),
        icon: 'universal-access-alt',
        category: 'widgets',
        example: {},
        edit: function() {
            return el(
                'p',
                { style: blockStyle },
                'Hello World, step 1 (from the editor).'
            );
        },
        save: function() {
            return el(
                'p',
                { style: blockStyle },
                'Hello World, step 1 (from the frontend).'
            );
        },
    } );
} )( window.wp.blocks, window.wp.i18n, window.wp.element ); **/