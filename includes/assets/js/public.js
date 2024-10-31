(function ( $ ) {
	"use strict";

	$(function () {
		$('.curatedquotes-widget-social a').click(function(e){
			e.preventDefault();
			window.open($(this).attr('href'), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
		});
	});

}(jQuery));