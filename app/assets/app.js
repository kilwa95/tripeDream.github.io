import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';

import 'bootstrap';

import './custom-js/custom-app.js';

import $ from 'jquery';

if ($(window).width() > 992) {
	$(window).scroll(function() {
		if ($(this).scrollTop() > 40) {
			$('#navbar_top').addClass('fixed-top');
			// add padding top to show content behind navbar
			$('body').css('padding-top', $('.navbar').outerHeight() + 'px');
		} else {
			$('#navbar_top').removeClass('fixed-top');
			// remove padding top from body
			$('body').css('padding-top', '0');
		}
	});
} // end if

$(document).on('click', '.dropdown-menu', function(e) {
	e.stopPropagation();
});

$('.animated').addClass('delay-1s');

// add au favorie

// $('.far.fa').on('click', function(e) {
// 	const id = $('#favorie-icon').data('id');
// 	if ($(this).hasClass('fa-heart-o')) {
// 		$.ajax({
// 			type: 'GET',
// 			url: `/favorie/new/${id}`,
// 			success: function(data) {
// 				console.log(data);
// 			}
// 		});
// 	} else {
// 		$.ajax({
// 			type: 'GET',
// 			url: `/favorie/${id}`,
// 			success: function(data) {
// 				console.log(data);
// 			}
// 		});
// 	}
// 	$(this).toggleClass('fa-heart fa-heart-o');
// 	// document.location.reload();
// });
