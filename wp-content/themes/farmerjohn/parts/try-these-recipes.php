<?php
/**
 * The Try These Recipes template
 */
?>
		<section class="try_these_recipes row text-center">
<?php
$posts = get_field('try_these_recipes');
if( !empty($posts) && count($posts) > 4 ):
	foreach( $posts as $p):
		$recipe_image = get_field('inset_image', $p->ID);
		if( !empty($recipe_image) ) {
			$recipe_image_url =  $recipe_image['url'];	
		} else {
			$recipe_image_url = get_template_directory_uri()."/assets/img/products/product_image_not_found.png";
		} ?>
			<div class="try_these_recipes_recipe relative-block" style="background-image:url(<?php echo $recipe_image_url; ?>);">
				<a href="<?php echo get_permalink($p->ID); ?>" class="recipes_color_overlay absolute-block <?php the_field('recipes_color_overlay', $p->ID); ?>">
					<div>
						<h2 class="try_these_recipes_recipe_title"><?php echo get_the_title($p->ID); ?></h2>
						<div class="see_recipe_cta show-for-large-up">SEE RECIPE</div>
					</div>
				</a>
			</div>
<?php endforeach;
else:
	$args = array(
		'post_type' => 'recipes',
		'orderby'	=> 'rand',
		'order'		=> 'ASC',
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			if( $the_query->current_post < 4 ){
				$recipe_image = get_field('inset_image');
				if( !empty($recipe_image) ) {
					$recipe_image_url =  $recipe_image['url'];	
				} else {
					$recipe_image_url = get_template_directory_uri()."/assets/img/products/product_image_not_found.png";
				} ?>
			<div class="try_these_recipes_recipe relative-block" style="background-image:url(<?php echo $recipe_image_url; ?>);">
				<a href="<?php the_permalink(); ?>" class="recipes_color_overlay absolute-block <?php the_field('recipes_color_overlay'); ?>">
					<div>
						<h2 class="try_these_recipes_recipe_title"><?php the_title(); ?></h2>
						<div class="see_recipe_cta show-for-large-up">SEE RECIPE</div>
					</div>
				</a>
			</div>
	<?php 	}
		}
		wp_reset_postdata();
	}
endif; ?>
			<div class="clearfix"></div>
		</section>
		<div class="clearfix"></div>