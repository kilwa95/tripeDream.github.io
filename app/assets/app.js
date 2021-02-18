import './styles/app.css';
import './styles/menu.css';
import './styles/slides.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import './custom-js/custom-app.js';
import './slides.js';
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
