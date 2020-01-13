<?php
/**
 * The homepage recipes template
 */
?>
    <section class="homepage_recipes text-center hide-for-large-up">
      <div class="homepage_recipes_header">
        <h2>BACON PARTY RECIPES</h2>
        <h3 class="dark-grey-button">GET INSPIRED</h3>
      </div>
<?php
$args = array(
  'post_type' => 'recipes',
  'tax_query' => array(
    array(
      'taxonomy' => 'recipe_categories',
      'field' => 'slug', 
      'terms' => array( 'featured-on-baconparty')
    )
  )
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
  while ( $the_query->have_posts() ) {
      $the_query->the_post();
      if( $the_query->current_post < 11 ){
        $recipe_image = get_field('inset_image');
        if( !empty($recipe_image) ) {
          $recipe_image_url =  $recipe_image['url'];
        } else {
          $recipe_image_url = get_template_directory_uri()."/assets/img/products/product_image_not_found.png";
        } ?>
      <div class="column small-6 homepage_recipes_recipe" style="background-image:url(<?php echo $recipe_image_url; ?>);">
        <a href="<?php the_permalink(); ?>" class="recipes_color_overlay absolute-block <?php the_field('recipes_color_overlay'); ?>">
          <div>
            <h2 class="homepage_recipes_recipe_title"><?php the_title(); ?></h2>
          </div>
        </a>
      </div>
<?php   }
  }
} ?>
    </section>
    <section class="homepage_recipes text-center show-for-large-up">
<?php
// The Loop
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
      <div class="column large-4 homepage_recipes_recipe" style="background-image:url(<?php echo $recipe_image_url; ?>);">
        <div class="absolute-block">
          <a href="<?php the_permalink(); ?>" class="recipes_color_overlay absolute-block <?php the_field('recipes_color_overlay'); ?>">
            <div>
              <h2 class="homepage_recipes_recipe_title"><?php the_title(); ?></h2>
              <div class="see_recipe_cta">SEE RECIPE</div>
            </div>
          </a>
        </div>
      </div>
<?php   }
  } ?>
      <div class="column large-4 homepage_recipes_recipe show-for-large-up homepage_recipes_center_recipe">
        <a href="/recipes" class="recipes_color_overlay absolute-block yellow">
          <div>
            <h2>BACON PARTY RECIPES</h2>
            <h3>GET INSPIRED</h3>
          </div>
        </a>
      </div>
<?php
  while ( $the_query->have_posts() ) {
      $the_query->the_post();
    if( $the_query->current_post > 3 && $the_query->current_post < 11 ){
      $recipe_image = get_field('inset_image');
      if( !empty($recipe_image) ) {
        $recipe_image_url =  $recipe_image['url'];
      } else {
        $recipe_image_url = get_template_directory_uri()."/assets/img/products/product_image_not_found.png";
      } ?>
        <div class="column large-4 homepage_recipes_recipe" style="background-image:url(<?php echo $recipe_image_url; ?>);">
          <div class="absolute-block">
            <a href="<?php the_permalink(); ?>" class="recipes_color_overlay absolute-block <?php the_field('recipes_color_overlay'); ?>">
              <div>
                <h2 class="homepage_recipes_recipe_title"><?php the_title(); ?></h2>
                <div class="see_recipe_cta">SEE RECIPE</div>
              </div>
            </a>
          </div>
        </div>
<?php   }
  }
}
/* Restore original Post Data */
wp_reset_postdata();
?>
      <div class="clearfix"></div>
    </section>
    <div class="clearfix"></div>
<?php ?>
