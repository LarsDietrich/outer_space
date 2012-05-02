// #############################################
(function($) {
	$(document).ready(function() {
		window.pulse_image = null;
		window.pulse_continue_loop = false;

		$('.pulse_image').animate(function() {
			// User is hovering over the image.
			window.pulse_continue_loop = true;
			window.pulse_image = $(this);

			PulseAnimation(); // start the loop
		}).mouseout(function() {
			window.pulse_continue_loop = false;
			window.pulse_image.stop();
			window.pulse_image.css('opacity',1);
		});
	});
})(jQuery);

// #############################################
function PulseAnimation()
{
	var minOpacity = .33;
	var fadeOutDuration = 650;
	var fadeInDuration = 650;

	window.pulse_image.animate({
		opacity: minOpacity
	}, fadeOutDuration, function() {
		window.pulse_image.animate({
			opacity: 1
		}, fadeInDuration, function() {
			if(window.pulse_continue_loop) {
				PulseAnimation();
			}
		})
	});
}