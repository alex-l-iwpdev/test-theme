/* global jQuery, Swiper */
jQuery( document ).ready( function( $ ) {
	const swiper = new Swiper( '.swiper', {
		pagination: {
			el: '.swiper-pagination',
			type: 'fraction',
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	} );
} );
