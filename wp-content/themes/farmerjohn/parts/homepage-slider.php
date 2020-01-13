<?php
/**
 * The homepage slider template
 */
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'homepage_sliders',
	'orderby' => 'menu_order',
	'order' => 'ASC',
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {?>
	<section class="homepage_slider_container hide-for-large-up">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post();
		if( get_field('mobile_slider_image') ){
		?>
		<div>
			<a href="<?php the_field('slider_link'); ?>" class="homepage_slider" style="background-image:url(<?php the_field('mobile_slider_image'); ?>);background-size:cover;"></a>
		</div>
<?php 	}
	} ?>
	</section>
<?php } ?>
<div class="clearfix"></div>

<?php
if ( $the_query->have_posts() ) {?>
	<section class="homepage_slider_container show-for-large-up">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post();
		if( get_field('slider_image') ){ ?>
		<div>
			<a href="<?php the_field('slider_link'); ?>" class="homepage_slider" style="background-image:url(<?php the_field('slider_image'); ?>);background-size:cover;"></a>
		</div>
<?php 	}
	} ?>
	</section>
<?php } ?>
<div class="clearfix"></div>