$(document).foundation();

$(document).ready(function(){
	// Homepage code
	if( $('body').hasClass('home') ){
		$('.homepage_slider_container').slick({
			prevArrow: '<button type="button" class="slick-prev"><img src="/wp-content/themes/farmerjohn/assets/img/home/left-arrow.png"></button>',
			nextArrow: '<button type="button" class="slick-next"><img src="/wp-content/themes/farmerjohn/assets/img/home/right-arrow.png"></button>',
			dots: true
		});
		// Auto-rotate for slider
		var autoRotate = setInterval(function(){
			$('.homepage_slider_container').slick('slickNext');
		},5000);
		$('.slick-prev, .slick-next').click(function(){
			clearTimeout(autoRotate);
		});
	} else if ( $('body').hasClass('post-type-archive-recipes') ) {
		// There's an external js file for this page template's scripts.
	} else if ( $('body').hasClass('single-recipes') ) {
		$('.recipe_share').click(function(event){
			$('.hide-for-large-up .recipe_sharing, .hide-for-large-up .recipe_triangle').fadeToggle();
		});
		$('.load-comments-button').click(function(){
			$('.hide-for-large-up .recipes_single_comments').slideDown(function(){
				$('.load-comments-button').slideUp();
			});
		});
		
		var addthis_share = { email_template: "RecipesShare", email_vars: { post_title: $('h1.title:visible').text() } };
	} else if ( $('.careers_slider_container').length > 0 ) {
		if( $( window ).width() > 1025 ){
			$('.careers_slider_container').slick({
				prevArrow: '<button type="button" class="slick-prev"><img src="/wp-content/themes/farmerjohn/assets/img/home/left-arrow.png"></button>',
				nextArrow: '<button type="button" class="slick-next"><img src="/wp-content/themes/farmerjohn/assets/img/home/right-arrow.png"></button>',
				dots: false,
				centerMode: true,
				asNavFor: '.careers_slider_quote_container',
				slidesToShow: 3,
				centerpadding: '150px'
			});
		} else {
			$('.careers_slider_container').slick({
				prevArrow: '<button type="button" class="slick-prev"><img src="/wp-content/themes/farmerjohn/assets/img/home/left-arrow.png"></button>',
				nextArrow: '<button type="button" class="slick-next"><img src="/wp-content/themes/farmerjohn/assets/img/home/right-arrow.png"></button>',
				dots: false,
				centerMode: true,
				asNavFor: '.careers_slider_quote_container'
			});
		}
		$('.careers_slider_quote_container').slick({
			arrows: false,
			dots: true,
			asNavFor: '.careers_slider_container'
		});
		$('.careers_job_openings .hide-for-large-up a.green-button').click(function(){
			$('.hide-for-large-up .careers_job_openings_department').hide();
			var department = $(this).attr('data-target-department');
			$('.green-triangle').hide();
			if( $('.hide-for-large-up .careers_job_openings_department.department-'+department).css('display') == "none" ){
				$(this).siblings('.green-triangle').show();
			} else {
				$('.green-triangle').hide();
			}
			$('.hide-for-large-up .careers_job_openings_department.department-'+department).slideDown();
		});
		$('.careers_job_openings .show-for-large-up a.green-button').click(function(){
			$('.show-for-large-up .careers_job_openings_department').hide();
			var department = $(this).attr('data-target-department');
			$('.green-triangle').hide();
			if( $('.show-for-large-up .careers_job_openings_department.department-'+department).css('display') == "none" ){
				$(this).siblings('.green-triangle').show();
			} else {
				$('.green-triangle').hide();
			}
			$('.show-for-large-up .careers_job_openings_department.department-'+department).slideDown();
		});
		$('body').append( $('.careers_job_openings_modal_container').html() );
		$('.careers_job_openings_modal_container').remove();
		$('.careers_job_openings_department .close-reveal-modal').click(function(){
			$(this).closest('.careers_job_openings_department').hide();
			$('.green-triangle').hide();
		});
	} else if ( $('.food_safety_slider_container').length > 0 ) {
		$('.food_safety_slider_container').slick({
			prevArrow: '<button type="button" class="slick-prev"><img src="/wp-content/themes/farmerjohn/assets/img/home/left-arrow.png"></button>',
			nextArrow: '<button type="button" class="slick-next"><img src="/wp-content/themes/farmerjohn/assets/img/home/right-arrow.png"></button>'
		});
	} else if ( $('section.page-csr').length > 0 ) {
		$('a.red-button').click(function(){
			$('section.community, section.sustainability, section.donation_request').slideUp(1);
			$('section.'+$(this).attr('data-reveal-class')).slideDown();
			$('a.red-button').removeClass('active');
			$(this).addClass('active');
		});
		$('.close-reveal-modal').click(function(){
			$( ".donation-request-form" ).html('');
			$( ".donation-request-form" ).load( "/wp-content/themes/farmerjohn/parts/csr_form_ajax.php" );
		});
		$('.donation-request-form input[type="submit"]').click(function(){
			$('#donation-request-form-container > header > p').slideUp();
		});
	} else if ( $('section.page-health').length > 0 ) {
		// Now in the health-slider.php template
	} else if ( $('.our_story_hero').length > 0 ) {
		$('.our_story_slider_container').slick({
			prevArrow: '<button type="button" class="slick-prev"><img src="/wp-content/themes/farmerjohn/assets/img/our-story/left-arrow.png"></button>',
			nextArrow: '<button type="button" class="slick-next"><img src="/wp-content/themes/farmerjohn/assets/img/our-story/right-arrow.png"></button>',
			dots: false,
			asNavFor: '.time-traveler-container',
			infinite: false
		});
		$('.time-traveler-container').slick({
			arrows: false,
			dots: false,
			centerMode: true,
			slidesToShow: 3,
			centerpadding: '150px',
			focusOnSelect: true,
			asNavFor: '.our_story_slider_container',
			infinite: false
		});
	} else if ( $('.faq_content').length > 0 ) {
		$('.faq_content li').click(function(){
			$(this).toggleClass('active');
			$(document).foundation('equalizer', 'reflow');
		});
	} else if ( $('.page-contact').length > 0 ) {
		$('.first-hidden-form-text').clone().prependTo('#field_6_2');
		$('.second-hidden-form-text').clone().prependTo('#field_6_18');
		$('.third-hidden-form-text').clone().appendTo('#field_6_20');
	}  else if ( $('.newsroom_hero').length > 0 ) {
		$('.green-button').click(function(){
			$('.newsroom_three_up > .row > .column[data-category-container="'+$(this).attr('data-category')+'"] .newsroom_category_post').show();
			$(document).foundation('equalizer', 'reflow');
		});
	}
});

// This code enabled the functionality for hiding the mobile recipe sharing overlay when you click outside of it
$(document).click(function (e){
    var container = $('.recipe_share');
    if ( !container.is(e.target) && container.has(e.target).length === 0 )
    {
        $('.hide-for-large-up .recipe_sharing, .hide-for-large-up .recipe_triangle').fadeOut();
    }
});