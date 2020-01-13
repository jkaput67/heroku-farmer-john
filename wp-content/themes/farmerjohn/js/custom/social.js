function trigger_juicer(what) {
	$('[data-filter="'+what+'"]').click();
}

function renderSocial(){
	// Figure out which social category group is selected
	var $activeCatButton = $('.social_archive_filter_nav:visible .social_archive_filter_item a.active');
	$('.social_archive_category_filter_label').removeClass('active');
	if( $activeCatButton.hasClass('filter-all') ){
		// Display All Social
		category_class = "all";
		$('.social_archive_category_filter_label.filter-all').addClass('active');
	} else {
		var category_class = $activeCatButton.attr('class');
		category_class_stripped_of_active_class = category_class.replace(" active", "");
		category_class = category_class_stripped_of_active_class.replace("filter", "category");
		$('.social_archive_category_filter_label.'+category_class_stripped_of_active_class).addClass('active');
		// category_class is the category class
	}
}

$(document).ready(function(){
	// Click handler to toggle the active states of categories and run the category filter (desktop)
	$('.social_archive_filter_nav.show-for-large-up .social_archive_filter_item a').click(function(){
		$('.social_archive_filter_item a').removeClass('active');
		$(this).addClass('active');
		renderSocial();
	});
	// Click handler to toggle the mobile social category filter dropdown
	$('.social_archive_filter_dropdown_toggle').click(function(){
		$('.social_archive_filter_dropdown').toggleClass('active');
		$('.dropdown-toggle').toggleClass('collapsed');
	});
	// Click handler to toggle the active states of categories and run the category filter (mobile)
	$('.social_archive_filter_nav.hide-for-large-up .social_archive_filter_item a').click(function(){
		$('.social_archive_filter_item a').removeClass('active');
		$(this).addClass('active');
		// Hide the Dropdown menu after a selection is made
		$('.social_archive_filter_dropdown').toggleClass('active');
		// Change out the dropdown selection text
		$('.social_archive_filter_dropdown_toggle h2').removeClass('active');
		var filter_class = $(this).attr('class');
		filter_class = filter_class.replace(" active", "");
		$('.social_archive_filter_dropdown_toggle h2.'+filter_class ).addClass('active');
		$('.dropdown-toggle').toggleClass('collapsed');
		renderSocial();
	});
	renderSocial();
});