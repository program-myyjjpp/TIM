$(document).ready(function() {
	$('#vegasslider').vegas({
		overlay: true,
		transition: 'fade', 
		transitionDuration: 4000,
		delay: 10000,
		animation: 'random',
		animationDuration: 20000,
		slides:[
			{ src: "assets/img/slider-1.jpg" },
			{ src: "assets/img/slider-2.jpg" },
			{ src: "assets/img/slider-3.jpg" },
			{ src: "assets/img/slider-4.jpg" }
		]
	});
});