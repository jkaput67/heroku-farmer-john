<?php
/**
 * The homepage recipes template
 */
?>
<div class="row">
	<section class="homepage_recipes text-center hide-for-large-up">
		<div class="homepage_recipes_header">
			<h2><?php _e('RECIPES','foundationpress')?></h2>
			<h3><?php _e('GET INSPIRED','foundationpress')?></h3>
		</div>
<?php

$args = array(
	'post_type' => 'recipes',
	'orderby' => 'date',
  	'order' => 'DESC',
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		if( $the_query->current_post < 8 ){
			$recipe_image = get_field('inset_image');
			if( !empty($recipe_image) ) {
				$recipe_image_url =  $recipe_image['url'];
			} else {
				$recipe_image_url = get_template_directory_uri()."/assets/img/products/product_image_not_found.png";
			}
			get_template_part( 'parts/recipes', 'archive-recipe' );
	 	}
	}
} ?>
	</section>
	<section class="homepage_recipes text-center show-for-large-up">
		<div class="column large-4 homepage_recipes_recipe submit_a_recipe" style="background-image:url(<?php echo $recipe_image_url; ?>); display: none;">
			<a class="recipes_color_overlay absolute-block opaque-green" data-reveal-id="submit-a-recipe">
				<div>
					<h2 class="homepage_recipes_recipe_title"><?php _e('SUBMIT A<br>RECIPE!','foundationpress')?></h2>
					<div class="see_recipe_cta"><?php _e('CLICK HERE','foundationpress')?></div>
				</div>
			</a>
		</div>
<?php
// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
			$the_query->the_post();
		if( $the_query->current_post < 9 ){
			get_template_part( 'parts/recipes', 'archive-recipe' );
		}
	}
} ?>
	</section>
	<div class="clearfix"></div>
</div>
<div class="all-recipes-container">
<?php
// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$recipe_image = get_field('inset_image');
		if( !empty($recipe_image) ) {
			$recipe_image_url =  $recipe_image['url'];
		} else {
			$recipe_image_url = get_template_directory_uri()."/assets/img/products/product_image_not_found.png";
		}
		get_template_part( 'parts/recipes', 'archive-recipe' );
	}
} ?>
</div>
<div id="submit-a-recipe" class="reveal-modal careers_job_openings_modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
<?php
$submit_a_recipe_page = get_page_by_title( 'Submit A Recipe' );
setup_postdata( $submit_a_recipe_page );
the_content();
wp_reset_postdata(); ?>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<script src="<?php echo get_template_directory_uri(); ?>/js/custom/recipes-archive.js?v=1"></script>
<?php /* Restore original Post Data */
wp_reset_postdata(); ?>
