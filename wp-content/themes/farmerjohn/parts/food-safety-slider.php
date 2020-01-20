<?php
/**
 * The food safety slider template
 */
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'food_safety_sliders',
	'orderby' => 'menu_order',
	'order' => 'ASC',
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {?>
	<section class="food_safety_slider_container">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post(); ?>
		<div class="food-safety-tip">
			<div class="row">
				<div class="column small-12 large-6 large-offset-5 relative-block">
					<div class="tip_icon_bg absolute-block">
						<h2><?php _e('SAFETY TIP','foundationpress')?> #<?php echo ($the_query->current_post+1); ?></h2>
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
	$('.food_safety_slider_container').slick({
		prevArrow: '<button type="button" class="slick-prev"><img src="/wp-content/themes/farmerjohn/assets/img/home/left-arrow.png"></button>',
		nextArrow: '<button type="button" class="slick-next"><img src="/wp-content/themes/farmerjohn/assets/img/home/right-arrow.png"></button>',
	});
});
</script>