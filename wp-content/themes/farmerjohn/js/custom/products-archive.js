function renderProducts(){
	// Figure out which products category group is selected
	var $activeCatButton = $('.products_archive_filter_nav:visible .products_archive_filter_item a.active');
	$('.products_archive_category_filter_label').removeClass('active');
	if( $activeCatButton.hasClass('filter-all') ){
		// Display All Products
		category_class = "all";
		$('.products_archive_category_filter_label.filter-all').addClass('active');
		$('.diet_filter').show();
	} else {
		var category_class = $activeCatButton.attr('class');
		category_class_stripped_of_active_class = category_class.replace(" active", "");
		category_class = category_class_stripped_of_active_class.replace("filter", "category");
		$('.products_archive_category_filter_label.'+category_class_stripped_of_active_class).addClass('active');
		// category_class is the category class
		$('.diet_filter').hide();
		$("select").select2("val", "none");
	}
	//Figure out if we're in mobile or desktop view
	if( $('.category_label_and_diet_filter_container.hide-for-large-up .select2-container.diet_dropdown').is(':visible') ){
		// Figure out the dietary filters, if any:
		var dietFilterSlug = $('.category_label_and_diet_filter_container.hide-for-large-up select.diet_dropdown').val();
		var dietFilterClass = "diet-"+dietFilterSlug;
	} else {
		// Figure out the dietary filters, if any:
		var dietFilterSlug = $('.category_label_and_diet_filter_container.show-for-large-up select.diet_dropdown').val();
		var dietFilterClass = "diet-"+dietFilterSlug;
	}
	//Empty the results container
	$('.products-results-container').empty();
	// Add all the products into the results container
	$('.products-results-container').html( $('.all-products-container').html() );
	// Hide products not in the selected category
	if( category_class != "all" ){
		$('.products-results-container article').not('.'+category_class).remove();
	}
	// Hide products not in the selected 
	if( dietFilterSlug != "none" ){
		$('.products-results-container article').not('.'+dietFilterClass).remove();
	}
	setProductsHeight();
	bookEnd();
	if( $('.products-archive-product:visible').length === 0 ){
		$('.no-results-text').show();
	} else {
		$('.no-results-text').hide();
	}
	// Set Products Hero image class
	$('.products_archive_hero').attr('class','products_archive_hero');
	if( category_class != "all" ){
		var category_slug = category_class_stripped_of_active_class.replace("filter-","");
		console.log(category_slug);
		$('.products_archive_hero').addClass(category_slug);
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
		renderProducts();
	});
	// Click handler to toggle the mobile products category filter dropdown
	$('.products_archive_filter_dropdown_toggle').click(function(){
		$('.products_archive_filter_dropdown').toggleClass('active');
		$('.dropdown-toggle').toggleClass('collapsed');
	});
	// Click handler to toggle the active states of categories and run the category filter (mobile)
	$('.products_archive_filter_nav.hide-for-large-up .products_archive_filter_item a').click(function(){
		$('.products_archive_filter_item a').removeClass('active');
		$(this).addClass('active');
		// Hide the Dropdown menu after a selection is made
		$('.products_archive_filter_dropdown').toggleClass('active');
		// Change out the dropdown selection text
		$('.products_archive_filter_dropdown_toggle h2').removeClass('active');
		var filter_class = $(this).attr('class');
		filter_class = filter_class.replace(" active", "");
		$('.products_archive_filter_dropdown_toggle h2.'+filter_class ).addClass('active');
		$('.dropdown-toggle').toggleClass('collapsed');
		renderProducts();
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