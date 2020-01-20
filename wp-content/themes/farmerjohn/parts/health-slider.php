<?php
/**
 * The food safety slider template
 */
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'health_sliders',
	'orderby' => 'menu_order',
	'order' => 'ASC',
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {?>
	<section class="health_slider_container">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post(); ?>
		<div class="health-tip">
			<div class="row">
				<div class="column small-12 large-6 large-offset-5 relative-block">
					<div class="tip_icon_bg absolute-block">
						<h2><?php _e('HEALTH TIP','foundationpress')?> #<?php echo ($the_query->current_post+1); ?></h2>
						<div class="homepage-tip-divider"></div>
						<p><?php the_field('tip_copy'); ?></p>
					</div>
				</div>
			</div>
		</div>
<?php } ?>
	</section>
<?php } ?>
	<div class="clearfix"></div>
<script>
$(document).ready(function(){
	$('.health_slider_container').slick({
		prevArrow: '<button type="button" class="slick-prev"><img src="/wp-content/themes/farmerjohn/assets/img/home/left-arrow.png"></button>',
		nextArrow: '<button type="button" class="slick-next"><img src="/wp-content/themes/farmerjohn/assets/img/home/right-arrow.png"></button>',
	});
	$('div.vs').each(function(){
		var height = $('.health_pork_comparison .row:nth-child(2) .small-5:first-child .comparison_bg').innerHeight();
		var myheight = $(this).height();
		$(this).css('padding-top', ( (height / 2) - (myheight / 2) ) );
	});
	$('.comparison_answer').click(function(){
		$(this).closest('.row').find('.answered').removeClass('answered');
		$(this).addClass('answered');
	});
	$('.comparison_bg').click(function(){
		$(this).closest('.row').find('.answered').removeClass('answered');
		$(this).children('.comparison_answer').addClass('answered');
	});
	$('.health_more_button').click(function(){
		var elevation = $('.up-your-protein').offset().top;
		$('.expandable_content_area').slideUp();
		$('.expanded-content-area-diamond').fadeOut();
		$('.expanded-content-area-diamond.'+$(this).attr('data-button-color')).fadeIn();
		$('.'+$(this).attr('data-reaveal-class') ).slideDown();
		$('html, body').animate({
			scrollTop: elevation
		}, 500);				
	});
	$('.exit_expandable_content_area').click(function(){
		$('.expandable_content_area').slideUp();
		$('.expanded-content-area-diamond').fadeOut();
	});
});
</script>