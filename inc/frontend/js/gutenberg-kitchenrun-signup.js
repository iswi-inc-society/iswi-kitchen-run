( function( blocks, i18n, element, blockEditor , apiFetch, components) {
    let el = element.createElement;
    let __ = i18n.__;

    let InspectorControls = blockEditor.InspectorControls;
    let SelectControl = components.SelectControl;

    let disabled;

    let SVG = components.SVG;
    let Path = components.Path;
    let G = components.G;

    // chef hat icon
    const icon = el(SVG, {viewBox: "0 0 389.092 389.092", xmlns: "http://www.w3.org/2000/svg"},
            el(G, {},
                el(Path, {d: "M388.609,151.183c-4.448-40.866-38.761-71.945-79.866-72.339h-0.16c-2.886,0.007-5.771,0.168-8.64,0.48"+
                    "c-17.669-55.673-77.124-86.482-132.798-68.813c-33.291,10.566-59.219,36.886-69.283,70.333c-5.751-1.283-11.627-1.927-17.52-1.92"+
                    "c-44.799,0.429-80.768,37.094-80.339,81.894c0.394,41.105,31.473,75.418,72.339,79.866v78.96h244.4v-79.04"+
                    "C361.281,235.756,393.457,195.721,388.609,151.183z"}),
            ),
            el(G, {},
                el(Path, {d: "M308.743,335.564H72.423v40c0,4.418,3.582,8,8,8h228.4c4.418,0,8-3.582,8-8v-40H308.743z"}),
            ),
        );

    blocks.registerBlockType( 'kitchenrun/signup', {
        title: __( 'Kitchenrun: Sign Up Form', 'gutenberg-kitchenrun' ),
        icon: icon,
        category: 'widgets',
        edit: function ( props ) {

            return [
                el( InspectorControls,
                    { key: 'controls' },
                    el( SelectControl, {
                            label: __('Event', 'kitchen-run'),
                            value: 1,
                            options: [
                                {value: 1, label: 'FOR LATER'},
                                {value: 2, label: 'FOR LATER'},
                            ]}
                    )
                ),

                render_signup_page('', 'kitchenrun', props, true),
            ];
        },
    } );


    function render_signup_page(event, text_domain, properties, edit) {

        if (edit) {
            disabled = 'disabled';
        } else {
            disabled = '';
        }
        return el('form', {class: 'kr_signup_form_edit', id: 'kr_signup_edit'},

            el('p', {class: 'kr_preview'}, 'This is just a preview look, the real block will look different. Click on Preview for that.'),

            el('p',{class: 'kr_edit_text'}, 'Here will be some text that gives Information about the current status of the current Kitchen Run Event. ' +
                'The Sign Up Form below will only be seen when the Event is open for registration.'),

            // Team Name
            el('div', {class: 'kr_form_text'},
                el('label', {class: 'kr_label_text', for: 'team_name'}, 'Team Name'),
                el('input', {class: 'kr_input_text', type: 'text', id: 'team_name', disabled }),
            ),

            // Team Member 1
            el('div', {class: 'kr_form_text'},
                el('label', {class: 'kr_label_text', for: 'team_member_1'}, 'Team Member 1'),
                el('input', {class: 'kr_input_text', type: 'text', id: 'team_member_1', disabled}),
            ),

            // Team Member 2
            el('div', {class: 'kr_form_text'},
                el('label', {class: 'kr_label_text', for: 'team_member_2'}, 'Team Member 2'),
                el('input', {class: 'kr_input_text', type: 'text', id: 'team_member_2', disabled}),
            ),

            // Address
            el('div', {class: 'kr_form_text'},
                el('label', {class: 'kr_label_text', for: 'team_address'}, 'Address'),
                el('input', {class: 'kr_input_text', type: 'text', id: 'team_address', disabled}),
            ),

            // City
            el('div', {class: 'kr_form_text'},
                el('label', {class: 'kr_label_text', for: 'team_city'}, 'City'),
                el('input', {class: 'kr_input_text', type: 'text', id: 'team_city', disabled }),
            ),

            // E-Mail
            el('div', {class: 'kr_form_text'},
                el('label', {class: 'kr_label_text', for: 'team_email'}, 'E-Mail'),
                el('input', {class: 'kr_input_text', type: 'email', id: 'team_email', disabled}),
            ),

            // Phone Number
            el('div', {class: 'kr_form_text'},
                el('label', {class: 'kr_label_text', for: 'team_phone'}, 'Phone Number'),
                el('input', {class: 'kr_input_text', type: 'tel', id: 'team_phone', disabled}),
            ),

            // Food Prefernces
            el('div', {class: 'kr_form_checkboxes'},
                el('span',{}, 'Do you have any food preferences?'),

                // Vegan
                el('div', {class: 'kr_form_radio'},
                    el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_vegan', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'team_vegan'}, 'Vegan'),
                ),

                // Vegetarian
                el('div', {class: 'kr_form_radio'},
                    el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_vegetarian', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'team_vegetarian'}, 'Vegetarian'),
                ),

                // Kosher
                el('div', {class: 'kr_form_radio'},
                    el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_kosher', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'team_kosher'}, 'Kosher'),
                ),

                // Halal
                el('div', {class: 'kr_form_radio'},
                    el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_halal', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'team_halal'}, 'Halal'),
                ),

                // Everything
                el('div', {class: 'kr_form_radio'},
                    el('input', {class: 'kr_edit_input_radio', type: 'radio', id: 'team_all', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'team_all'}, 'Everything'),
                ),
            ),

            // Food Request
            el('div', {class: 'kr_form_textarea'},
                el('label', {class: 'kr_edit_label', for: 'team_food_request'}, 'Other special request for food, they will be sent to the cooking team'),
                el('textarea', {class: 'kr_edit_textarea', form: 'kr_signup_edit', id: 'team_food_request', disabled}),
            ),

            // Find Place
            el('div', {class: 'kr_form_textarea'},
                el('label', {class: 'kr_edit_label', for: 'team_find_place'}, 'If it is not easy, give hints on how to find your place'),
                el('textarea', {class: 'kr_edit_textarea', form: 'kr_signup_edit', id: 'team_find_place', disabled}),
            ),

            // Course Preferences
            el('div', {class: 'kr_form_checkboxes'},
                el('span',{}, 'We are able to cook following courses'),

                // Appetizer
                el('div', {class: 'kr_form_check'},
                    el('input', {class: 'kr_edit_input_checkbox', type: 'checkbox', id: 'team_appetizer', checked: 'true', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'team_appetizer'}, 'Appetizer'),
                ),

                // Main Course
                el('div', {class: 'kr_form_check'},
                    el('input', {class: 'kr_edit_input_checkbox', type: 'checkbox', id: 'team_main_course', checked: 'true', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'team_main_course'}, 'Main Course'),
                ),

                // Dessert
                el('div', {class: 'kr_form_check'},
                    el('input', {class: 'kr_edit_input_checkbox', type: 'checkbox', id: 'team_dessert', checked: 'true', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'team_dessert'}, 'Dessert'),
                ),
            ),

            // Comment
            el('div', {class: 'kr_form_textarea'},
                el('label', {class: 'kr_edit_label', for: 'team_comment'}, 'Comments for the organization (they will not be shared)'),
                el('textarea', {class: 'kr_edit_textarea', form: 'kr_signup_edit', id: 'team_comment', disabled}),
            ),

            // Upcoming Events
            el('div', {class: 'kr_form_checkboxes'},
                el('div', {class: 'kr_form_check'},
                    el('input', {class: 'kr_edit_input_checkbox', type: 'checkbox', id: 'iswi_events', checked: 'true', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'iswi_events'}, 'We would like to receive e-mails informing us about upcoming events'),
                ),
            ),

            // General Information
            el('div', {class: 'kr_form_checkboxes'},
                el('div', {class: 'kr_form_check'},
                    el('input', {class: 'kr_edit_input_checkbox', type: 'checkbox', id: 'iswi_general', checked: 'true', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'iswi_general'}, 'We would like to receive e-mails informing us about ISWI e.V. in general'),
                ),
            ),

            // Privacy
            el('div', {class: 'kr_form_checkboxes'},
                el('div', {class: 'kr_form_check'},
                    el('input', {class: 'kr_edit_input_checkbox', type: 'checkbox', id: 'privacy', checked: 'true', disabled}),
                    el('label', {class: 'kr_edit_label', for: 'privacy'}, 'We have read and understood the privacy agreement'),
                ),
            ),

            // submit
            el('div', {class: 'kr_form_submit'},
                el('input', {class: 'kr_input_submit', type: 'submit', id: 'submit', value: 'Send', disabled}),
            ),
        );
    }

} )( window.wp.blocks, window.wp.i18n, window.wp.element, window.wp.blockEditor, window.wp, window.wp.components);