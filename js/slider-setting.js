 jQuery(document).ready(function(){

	jQuery('.big-slider').bxSlider({
		mode: 'fade',
		speed: 1500,
		auto: true,
		pause: 5000,
		adaptiveHeight: true,
		nextText: '',
		prevText: '',
		nextSelector: '.slide-next',
		prevSelector: '.slide-prev',
		pager: false,
		autoHover: true
	});
});
