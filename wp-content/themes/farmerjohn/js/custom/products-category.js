function renderProducts(){
	//Empty the results container
	$('.products-results-container').empty();
	// Add all the products into the results container
	$('.products-results-container').html( $('.all-products-container').html() );
	setProductsHeight();
	bookEnd();
	if( $('.products-archive-product:visible').length === 0 ){
		$('.no-results-text').show();
	} else {
		$('.no-results-text').hide();
	}
}

function setProductsHeight(){
	// Finds the tallest product and sets the height of all products to that height so that all products stack in a uniform fashion
	var tallestProductHeight = 0;
	$('.products-results-container .products-archive-product').each(function(){
		if( $(this).height() > tallestProductHeight ) {
			tallestProductHeight = $(this).height();
		}
	});
	$('.products-results-container .products-archive-product').css('height',tallestProductHeight+'px');
}

function bookEnd(){
	// Clear out the 'end' class from products and make the last item an end
	$('.products-results-container .products-archive-product').removeClass('end');
	$('.products-results-container .products-archive-product:last-child').addClass('end');
}

$(document).ready(function(){
	// Click handler to toggle the active states of categories and run the category filter (desktop)
	$('.products_archive_filter_nav.show-for-large-up .products_archive_filter_item a').click(function(){
		$('.products_archive_filter_item a').removeClass('active');
		$(this).addClass('active');
	});
	// Click handler to toggle the mobile products category filter dropdown
	$('.products_archive_filter_dropdown_toggle').click(function(){
		$('.products_archive_filter_dropdown').toggleClass('active');
		$('.dropdown-toggle').toggleClass('collapsed');
	});
	renderProducts();
	$('select.diet_dropdown').on('change', function() {
		renderProducts();
	});
	setProductsHeight();
	bookEnd();
	$('select').each(function(){
		$(this).select2();
	});
});