<?php
/**
 * The recipes slider template
 */
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'recipes_sliders',
	'orderby' => 'menu_order',
	'order' => 'ASC',
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {?>
	<section class="recipes_slider_container relative-block hide-for-large-up">
		<div class="absolute-block">
			<div class="recipes_slider_actual_container relative-block">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post();
		if( get_field('mobile_slider_image') ){ ?>
		<div>
			<a style="position:relative;" href="<?php if( get_field('slider_link') != '' ){ the_field('slider_link'); } else {
	$posts = get_field('associated_recipe');
	if( $posts ):
		foreach( $posts as $p ):
			echo get_permalink( $p->ID );
		endforeach;
	endif;
} ?>" class="recipes_slider" style="background-image:url(<?php the_field('slider_image'); ?>);background-size:cover;">
				<div class="absolute-block flex-block" style="background-image:url(<?php the_field('mobile_slider_image'); ?>);background-size:cover;background-repeat:no-repeat;">
					<div style="float:left;margin-left:5%;background-color: rgba(103, 103, 103, 0.5); width:100%; margin:0 auto; text-align:center;">
						<!-- <img style="max-width:40%;height:auto;" src="<?php echo get_template_directory_uri(); ?>/assets/img/recipes/featured-recipe-label.png"> -->
						<h2 style="color:#fff;font-size:2.5rem;text-align:center;padding:1rem;line-height:100%;text-transform:uppercase;font-family:'DIN OT Bold';">
<?php
if( get_field('recipe_title_line_1') != '' && get_field('recipe_title_line_1') != '' ){
	echo get_field('recipe_title_line_1').'<br>'.get_field('recipe_title_line_2');
} else {
	the_title();
}
?>
						</h2>
					</div>
				</div>
			</a>
		</div>
<?php 	}
	} ?>
			</div>
		</div>
	</section>
<?php } ?>
<div class="clearfix"></div>

<?php
if ( $the_query->have_posts() ) {?>
	<section class="recipes_slider_container relative-block show-for-large-up">
		<div class="absolute-block">
			<div class="recipes_slider_actual_container relative-block">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post();
		if( get_field('slider_image') ){ ?>
			<div>
				<a style="position:relative;" href="<?php if( get_field('slider_link') != '' ){ the_field('slider_link'); } else {
	$posts = get_field('associated_recipe');
	if( $posts ):
		foreach( $posts as $p ):
			echo get_permalink( $p->ID );
		endforeach;
	endif;
} ?>" class="recipes_slider" style="background-image:url(<?php the_field('slider_image'); ?>);background-size:cover;">
					<div class="absolute-block flex-block" style="background-image:url(<?php the_field('slider_image'); ?>);background-size:cover;background-repeat:no-repeat;">
						<div style="float:left;margin-left:10%; background-color: rgba(103, 103, 103, 0.5); width:100%; margin:0 auto; text-align:center;>
							<!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/recipes/featured-recipe-label.png"> -->
							<h2 style="color:#fff;font-size:3rem;padding:1rem;line-height:100%;text-transform:uppercase;font-family:'DIN OT Bold';">
<?php
if( get_field('recipe_title_line_1') != '' && get_field('recipe_title_line_1') != '' ){
	echo get_field('recipe_title_line_1').'<br>'.get_field('recipe_title_line_2');
} else {
	the_title();
}
?>
							</h2>
							<div class="see_recipe_cta left" style="display:block;color:#fff;border-color:#fff;">SEE RECIPE</div>
						</div>
					</div>
				</a>
			</div>
<?php 	}
	} ?>
			</div>
		</div>
	</section>
<?php } ?>
<div class="clearfix"></div>