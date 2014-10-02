jQuery(document).ready(function($) {
	
	$('#lightbox .boxClose').live('click', function() { //must use live, as the lightbox element is inserted into the DOM
		$('#lightbox').hide();
	});

});