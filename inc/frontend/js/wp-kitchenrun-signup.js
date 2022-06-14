/**
 * Java Script that is used for the signup, jQuery and jQuery Validation are needed!!
 */

(function($) {

    $(document).ready(function(){
        var current = 1,current_step,next_step,steps,current_progress;
        steps = $("fieldset.kr_tab").length;
        current_progress = $(".kr_progressbar li:first-child");

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

        $(".kr_btn_next").click(function(){
            var form = $('#kr_signup');
            form.validate({
                ignore: ':hidden:not("#kr_food_pref"):not("#kr_course_pref"):not("#kr_privacy_aggreement"):not("#kr_photos_yes"):not("kr_photos_no")', // ignore all hidden fields except these three
                rules: {

                    //@TODO: Phone Number Validation

                    food_pref: {
                        required: function () {
                            var boxes = $('.kr_chbox .kr_food');
                            if ($('#kr_tab_4').is(":visible") && boxes.filter(':checked').length == 0) return true;
                            else false;
                        }
                    },
                    /*course_pref: {
                        required: function () {
                            var boxes = $('.kr_chbox .kr_course');
                            if ($('#kr_tab_5').is(":visible") && boxes.filter(':checked').length == 0) return true;
                            else false;
                        }
                    },*/
                    kr_team_privacy_aggreement: {
                        required: function (){
                            if ($('#kr_tab_6').is(":visible")) return true;
                            else false;
                        },
                    },

                    kr_team_photos: {
                        required: function (){
                            if ($('#kr_tab_5').is(":visible") )return true;
                            else false;
                        },
                    },
                },
                messages: {
                    food_pref: "Please select at least one preference of food!",
                    course_pref: "Please select at least one course preference!",
                },
                errorPlacement: function(error, element) {
                    if(element.attr("type") == "checkbox" && element.parent().hasClass("kr_check")) error.insertAfter(element.next());
                    else error.insertAfter(element);
                }
            });

            if (form.valid() === true) {
                current_step = $(this).parent();
                next_step = $(this).parent().next();
                next_step.show();
                current_step.hide();

                current_progress.addClass("kr_active");
                current_progress = current_progress.next();
            }
        });

        $(".kr_btn_prev").click(function(){
            current_step = $(this).parent();
            next_step = $(this).parent().prev();
            next_step.show();
            current_step.hide();

            current_progress = current_progress.prev();
        });

        $('.kr_txtb input, textarea').on("focus", function (){
            $(this).addClass("focus");
        });

        $(".kr_txtb input, textarea").on("blur",function(){
            if($(this).val() == "")
                $(this).removeClass("focus");
        });
    });

})( jQuery );
