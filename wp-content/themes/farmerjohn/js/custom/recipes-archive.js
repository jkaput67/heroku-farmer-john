function filterRecipes(){
	loadAllRecipes();
	// Show all recipes
	$('.homepage_recipes:visible .homepage_recipes_recipe').show();
	// Apply dropdown and search filters
	$('.recipes_archive_filters:visible select.filter-dropdown').each(function(){
		// Product/Category dropdown
		if( $(this).hasClass('filter-product') ){
			// For each visible select dropdown, find the value, and if it's not empty, apply the filter to the results container
			var value = $(this).val();
			if( value != "" && value != "all" ) {
				// For each of the items in the recipes container, see if it has the filter flag, and if not, remove it.
				$('.homepage_recipes:visible .homepage_recipes_recipe').not( '.recipe_categories-'+$(this).val() ).hide();
			}
		} else {
			// For each visible select dropdown, find the value, and if it's not empty, apply the filter to the results container
			var value = $(this).val();
			if( value != "" && value != "all" ) {
				// For each of the items in the recipes container, see if it has the filter flag, and if not, remove it.
				$('.homepage_recipes:visible .homepage_recipes_recipe').not( '.'+$(this).val() ).hide();
			}
		}
	});
	var searchValue = $('.recipes_archive_search:visible').val();
	if( searchValue != "" ){
		console.log('YAAA');
		$('.homepage_recipes:visible .homepage_recipes_recipe').each(function(){
			var recipeTitle = $(this).find('.homepage_recipes_recipe_title').html();
			var re = new RegExp(searchValue,"i");
			if( recipeTitle.search(re) == -1 ){
				$(this).hide();
			}
		});
	}
	// If the search box isn't empty, apply the search box's value to the search filter
	bookEnd();
}

function addRecipes(){
	// Count the number of objects in the recipes container
	numRecipesDisplayedMobile = $('.homepage_recipes.hide-for-large-up .homepage_recipes_recipe').length-1;
	numRecipesDisplayedDesktop = $('.homepage_recipes.show-for-large-up .homepage_recipes_recipe').not('.submit_a_recipe').length;
	//numRecipesDisplayedDesktop = $('.homepage_recipes.show-for-large-up .homepage_recipes_recipe').length;
	// Add the new recipes into the results container for mobile
	$('.all-recipes-container > div.homepage_recipes_recipe').each(function(){
		if( $(this).index() > numRecipesDisplayedMobile && $(this).index() < (numRecipesDisplayedMobile+9) ){
			$(this).clone().appendTo('.homepage_recipes.hide-for-large-up');
		}
		if( $(this).index() > numRecipesDisplayedDesktop && $(this).index() < (numRecipesDisplayedDesktop+10) ){
			$(this).clone().appendTo('.homepage_recipes.show-for-large-up');
		}
	});
	numRecipesDisplayed = $('.homepage_recipes:visible .homepage_recipes_recipe').length;
	numTotalRecipes = $('.all-recipes-container > div.homepage_recipes_recipe').length;
	if( numRecipesDisplayed == numTotalRecipes ){
		$('.load-more-button-container').css('opacity','0.4');
		$('.load-more-button-container').off();
	}
	bookEnd();
}

function loadAllRecipes(){
	numRecipesDisplayed = $('.homepage_recipes:visible .homepage_recipes_recipe').length;
	numTotalRecipes = $('.all-recipes-container > div.homepage_recipes_recipe').length;
	while ( numRecipesDisplayed != numTotalRecipes ){
		addRecipes();
	}
}

function bookEnd(){
	// Clear out the 'end' class from recipes and make the last item an end
	$('.homepage_recipes > div.homepage_recipes_recipe ').removeClass('end');
	$('.homepage_recipes').find('div.homepage_recipes_recipe:visible:last').addClass('end');
	$('.submit_a_recipe').hide();
}

$(document).ready(function(){
	// Click handler for Load More buttons
	$('.load-more-button').click(function(){
		// addRecipes();
		loadAllRecipes();
	});
	$('select').change(filterRecipes);
	$('input').keyup(filterRecipes);
	bookEnd();
	$('.recipes_slider_actual_container').slick({
		prevArrow: '<button type="button" class="slick-prev"><img src="/wp-content/themes/farmerjohn/assets/img/home/left-arrow.png"></button>',
		nextArrow: '<button type="button" class="slick-next"><img src="/wp-content/themes/farmerjohn/assets/img/home/right-arrow.png"></button>',
		dots: true
	});
	$('select').each(function(){
		$(this).select2();
	});
	$('.gform_heading').append('<p>Think you have a great recipe to share? Farmer John products can enhance all sorts of recipes. That\'s why we\'re always looking to try new Farmer John-inspired dishes. Tell us some of your favorite recipes and with your permission, we\'d love to feature them on our website.</p><p><small>* required</small></p>');
	$('#field_3_14 .gfield_label').addClass('orange-button');
	$('#field_3_14 .gfield_label').addClass('upload-photo-button');
});