/**
 * Java Script that is used for the signup, jQuery and jQuery Validation are needed!!
 */

(function($) {

    $(document).ready(function(){
        var current, current_step, next_step, steps, current_progress, form;

        // initalize values
        current = 1;
        steps = $("fieldset.kr_tab").length;
        current_progress = $(".kr_progressbar li:first-child");
        form = $('#kr_signup');


        // validate the form input -> TODO: use AJAX to validate the email during the step
        $(".kr_btn_next, .kr_btn_submit").click(function(){

            form.validate({
                ignore: ':hidden:not("#kr_food_pref"):not("#kr_course_pref"):not("#kr_privacy_aggreement")', // ignore all hidden fields except these three
                rules: {

                    //@TODO: Phone Number Validation

                    food_pref: {
                        required: function () { // field only required when it is shown
                            var boxes = $('.kr_chbox .kr_food');
                            if ($('#kr_tab_4').is(":visible") && boxes.filter(':checked').length == 0) return true;
                            else false;
                        }
                    },
                    course_pref: {
                        required: function () { // field only required when it is shown
                            var boxes = $('.kr_chbox .kr_course');
                            if ($('#kr_tab_5').is(":visible") && boxes.filter(':checked').length == 0) return true;
                            else false;
                        }
                    },
                    kr_team_privacy_aggreement: {
                        required: function (){ // field only required when it is shown
                            if ($('#kr_tab_5').is(":visible")) return true;
                            else false;
                        },
                    }
                },
                messages: {
                    food_pref: "Please select at least one preference of food!", //TODO: make text translateable via wordpress localization
                    course_pref: "Please select at least one course preference!",
                },
                errorPlacement: function(error, element) {
                    if(element.attr("type") == "checkbox" && element.parent().hasClass("kr_check")) error.insertAfter(element.next());  // place error message for checkboxes above
                    else error.insertAfter(element); // place error message for other fields after the field
                }
            });

            if(form.valid() === true && $(this).hasClass("kr_btn_submit")) { //submit form

                var submit_button = $(this);

                $.post(
                    kr_signup_ajax_obj.ajax_url,
                    {         //POST request
                        _ajax_nonce: kr_signup_ajax_obj.nonce,  //nonce
                        action: "kr_signup_submit",            //action
                        form_data: ConvertFormToJSON(form)     //data
                    }
                ).done(function(data) {
                        nextStep(submit_button);
                        incProgress();
                    }
                ).fail(function(data) {
                        alert("Error"); // TODO: create a step for errors
                    }
                );

            } else if (form.valid() === true) {

                nextStep($(this));
                incProgress();

            }
        });

        // set back one step
        $(".kr_btn_prev").click(function(){

            prevStep($(this));
            decProgress();

        });

        // Change form to next step
        function nextStep(button) {
            current_step = button.parent();
            next_step = button.parent().next();
            next_step.show();
            current_step.hide();
        }

        // Change form to previous step
        function prevStep(button) {
            current_step = button.parent();
            next_step = button.parent().prev();
            next_step.show();
            current_step.hide();
        }

        // set the progressbar to the next step
        function incProgress() {
            current_progress.addClass("kr_active");
            current_progress = current_progress.next();
        }

        // set the progressbar to the previous step
        function decProgress() {
            current_progress = current_progress.prev();
        }


        // Accordion
        $('.kr_acord_label').click(function () {
            var acord_text = $('.kr_acord_text');
            if (acord_text.hasClass('active'))
                acord_text.removeClass('active');
            else
                acord_text.addClass('active');

            var dash_icon = $('.kr_acord_label > span.dashicons');

            if (dash_icon.hasClass("dashicons-arrow-right")) {
                dash_icon.removeClass("dashicons-arrow-right");
                dash_icon.addClass("dashicons-arrow-up");
            } else {
                dash_icon.removeClass("dashicons-arrow-up");
                dash_icon.addClass("dashicons-arrow-right");
            }
        });

        // Check at the beginning if some fields already have content
        $('.kr_txtb input, textarea').each(function (){
            if ($(this).val() != '') $(this).addClass("focus");
        });

        // Textarea/Input focus
        $('.kr_txtb input, textarea').on("focus", function (){
            $(this).addClass("focus");
        });

        // Textarea/Input unfocus
        $(".kr_txtb input, textarea").on("blur",function(){
            if($(this).val() == "")
                $(this).removeClass("focus");
        });
    });

    // converts a form to a JSON
    function ConvertFormToJSON(form){
        var array = $(form).serializeArray();
        var json = {};
        
        $.each(array, function() {
            json[this.name] = this.value || '';
        });
        
        return json;
    }


})( jQuery );


