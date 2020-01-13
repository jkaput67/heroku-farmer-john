<?php
			$recipe_classes = array('column','small-6','large-4','homepage_recipes_recipe');
			$recipe_categories = wp_get_post_terms( $post->ID, 'recipe_categories' );
			if(!empty($recipe_categories)){
				foreach ($recipe_categories as $recipe_category){
					$recipe_classes[] = $recipe_category->slug;
				}
			}
			$meals = wp_get_post_terms( $post->ID, 'meals' );
			if(!empty($meals)){
				foreach ($meals as $meal){
					$recipe_classes[] = $meal->slug;
				}
			}
		
			$recipe_image = get_field('inset_image');
			if( !empty($recipe_image) ) {
				$recipe_image_url =  $recipe_image['url'];
			} else {
				$recipe_image_url = get_template_directory_uri()."/assets/img/products/product_image_not_found.png";
			} ?>
		<div <?php post_class($recipe_classes); ?> style="background-image:url(<?php echo $recipe_image_url; ?>);">
			<a href="<?php the_permalink(); ?>" class="recipes_color_overlay absolute-block <?php if( get_field('recipes_color_overlay') ) { the_field('recipes_color_overlay'); } else { echo 'blue'; } ?>">
				<div>
					<h2 class="homepage_recipes_recipe_title"><?php the_title(); ?></h2>
					<div class="see_recipe_cta">SEE RECIPE</div>
				</div>
			</a>
		</div>
