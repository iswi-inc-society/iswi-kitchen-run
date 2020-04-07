/**
 * All of the JS for your admin-specific functionality should be included in this file.
 * The file is enqueued from inc/admin/class-admin.php.
 */

(function( $ ) {
	'use strict';

	/**
	 * Adds functionality to choose two guests of the same course and exchange their current position.
	 */
	$('.pair-guest').on("click", function () {

		let check1 = $('.checked-1');
		let check2 = $('.checked-2');

		if ($(this).hasClass('checked-1')) { // remove check from a guest
			if (check2.length > 0) { check2.addClass('checked-1').removeClass('checked-2') }
			$(this).removeClass('checked-1')
		} else if ($(this).hasClass('checked-2')) { // remove check from a guest
			$(this).removeClass('checked-2');
		} else { // add a check to a guest
			if (check1.length > 0) {
				if (haveSameClass(check1, $(this), 'appetizer') || haveSameClass(check1, $(this), 'main-course') || haveSameClass(check1, $(this), 'dessert')) {
					// wenn nächster check in der gleichen Reihe ist
					if (check2.length > 0) {check2.removeClass('checked-2');}
					check1.addClass('checked-2').removeClass('checked-1');
				} else {
					if (check2.length > 0) {check2.removeClass('checked-2');}
					check1.removeClass('checked-1');
				}
			}
			$(this).addClass('checked-1');
		}

		// new init of variables
		let afterCheck1 = $('.checked-1');
		let afterCheck2 = $('.checked-2');
		let submit = $('#exg_pairs_action');

		// get checked guests to input form
		if (afterCheck1.length > 0) {
			$('input.guest-exg-1').val(afterCheck1.attr('id'));
		}
		if (afterCheck2.length > 0) {
			$('input.guest-exg-2').val(afterCheck2.attr('id'));
		}
		if (afterCheck1.length > 0 && afterCheck2.length > 0) {
			submit.removeAttr('disabled')
		} else {
			submit.attr('disabled', 'true')
		}

	});


})( jQuery );

/**
 * Checks if two html elements have the same class.
 *
 * @param obj1
 * @param obj2
 * @param css_class
 * @returns {boolean}
 */
function haveSameClass(obj1, obj2, css_class) {
	return (obj1.hasClass(css_class) && obj2.hasClass(css_class));

}
