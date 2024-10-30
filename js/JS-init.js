//Image Hover
jQuery(document).ready(function(){
	jQuery(function() {
		jQuery('ul.da-thumbs > li').hoverdir();
	});
});


jQuery(function(){
	// init Isotope
	var $grid = jQuery('#MMDportfoliocontainer').isotope({
	itemSelector: '.MMDportfolio', 
	transitionDuration: 500
	});

	// bind filter click
	jQuery('#MMDfilters').on( 'click', 'li', function() {
	var filterValue = jQuery( this ).attr('data-filter');
	$grid.isotope({ filter: filterValue });
	});
	// change active class on buttons
	jQuery('.MMDfilterGroup').each( function( i, buttonGroup ) {
	var $buttonGroup = jQuery( buttonGroup );
	$buttonGroup.on( 'click', 'li', function() {
		$buttonGroup.find('.active').removeClass('active');
		jQuery( this ).addClass('active');
	});
	});

});