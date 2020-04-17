/**
 * Not Used YET;
 */

//(function( $ ) {
//	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
         * 
         * The file is enqueued from inc/frontend/class-frontend.php.
	 */


//})( jQuery );

/*( function( blocks, i18n, element, blockEditor, serverSideRender ) {
    var el = element.createElement;
    var __ = i18n.__;

    var RichText = blockEditor.RichText;
    var AlignmentToolbar = blockEditor;
    var InspectorControls = blockEditor;

    var disabled;

    blocks.registerBlockType( 'gutenberg-kitchenrun/kitchenrun-signup', {
        title: __( 'Kitchenrun: Sign Up Form', 'gutenberg-kitchenrun' ),
        icon: 'universal-access-alt',
        category: 'widgets',
        attributes: {
            content: {
                type: 'array',
                source: 'children',
                selector: 'p',
            },
            alignment: {
                type: 'string',
                default: 'none',
            },
        },
        example: {},
        edit: function ( props ) {

            var content = props.attributes.content;
            var alignment = props.attributes.alignment;

            function onChangeContent( newContent ) {
                props.setAttributes( { content: newContent } );
            }

            function onChangeAlignment( newAlignment ) {
                props.setAttributes( { alignment: newAlignment === undefined ? 'none' : newAlignment } );
            }


            return [
                el(
                    InspectorControls,
                    { key: 'controls' },
                    el(
                        AlignmentToolbar,
                        {
                            value: alignment,
                            onChange: onChangeAlignment,
                        }
                    )
                ),
                render_singup_page('', 'gutenberg-kitchenrun', '', true)];
        },

        save: function( props ) {
            return (
                el( serverSideRender, {
                    block: 'gutenberg-kitchenrun/kitchenrun-signup',
                    attributes: props.attributes,
                } )
            );
        },
    } );

    function render_singup_page(event, text_domain, properties, edit) {

        if (edit) {
            disabled = 'disabled';
        } else {
            disabled = '';
        }
        var out = el('form', {class: 'kr_signup_form_edit', id: 'kr_signup_edit'},

            el('p',{class: 'kr_edit_text'}, 'Here will be some text that gives Information about the current status of the current Kitchen Run Event. ' +
                'The Sign Up Form below will only be seen when the Event is open for registration.'),

            el('label', {class: 'kr_edit_label', for: 'team_name'}, 'Team Name'),
            el('input', {class: 'kr_edit_input_text', type: 'text', id: 'team_name', disabled }),

            el('label', {class: 'kr_edit_label', for: 'team_member_1'}, 'Team Member 1'),
            el('input', {class: 'kr_edit_input_text', type: 'text', id: 'team_member_1', disabled}),

            el('label', {class: 'kr_edit_label', for: 'team_member_2'}, 'Team Member 2'),
            el('input', {class: 'kr_edit_input_text', type: 'text', id: 'team_member_2', disabled}),

            el('label', {class: 'kr_edit_label', for: 'team_address'}, 'Address'),
            el('input', {class: 'kr_edit_input_text', type: 'text', id: 'team_address', disabled}),

            el('label', {class: 'kr_edit_label', for: 'team_city'}, 'City'),
            el('input', {class: 'kr_edit_input_text', type: 'text', id: 'team_city', disabled, value: "Ilmenau"}),

            el('label', {class: 'kr_edit_label', for: 'team_email'}, 'E-Mail'),
            el('input', {class: 'kr_edit_input_text', type: 'email', id: 'team_email', disabled}),

            el('label', {class: 'kr_edit_label', for: 'team_phone'}, 'Phone Number'),
            el('input', {class: 'kr_edit_input_text', type: 'tel', id: 'team_phone', disabled}),


            el('div', {class: 'kr_field_food_pref'},
                el('p',{class: 'kr_edit_text'}, 'Do you have any food preferences?'),

                el('label', {class: 'kr_edit_label', for: 'team_vegan'}, 'Vegan'),
                el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_vegan', disabled: 'true'}),

                el('label', {class: 'kr_edit_label', for: 'team_vegetarian'}, 'Vegetarian'),
                el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_vegetarian', disabled: 'true'}),

                el('label', {class: 'kr_edit_label', for: 'team_kosher'}, 'Kosher'),
                el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_kosher', disabled: 'true'}),

                el('label', {class: 'kr_edit_label', for: 'team_halal'}, 'Halal'),
                el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_halal', disabled: 'true'}),

                el('label', {class: 'kr_edit_label', for: 'team_all'}, 'Everything'),
                el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_all', disabled: 'true'}),
            ),

            el('label', {class: 'kr_edit_label', for: 'team_food_request'}, 'Other special request for food, they will be sent to the cooking team'),
            el('textarea', {class: 'kr_edit_textarea', form: 'kr_signup_edit', id: 'team_food_request', disabled: 'true'}),

            el('label', {class: 'kr_edit_label', for: 'team_find_place'}, 'Other special request for food, they will be sent to the cooking team'),
            el('textarea', {class: 'kr_edit_textarea', form: 'kr_signup_edit', id: 'team_food_request', disabled: 'true'}),
        );

        return out;
    }

} )( window.wp.blocks, window.wp.i18n, window.wp.element, window.wp.blockEditor, window.wp.ServerSideRender); */

