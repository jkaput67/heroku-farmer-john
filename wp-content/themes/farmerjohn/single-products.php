<?php
/**
 * The template for displaying all single Products posts
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

/* Mobile Start */
$this_items_product_category = '';
$terms = get_the_terms( $post->ID, 'product_category' );
if ( !empty( $terms ) ){
    $term = array_shift( $terms );
    $this_items_product_category = ' '.$term->slug;
}

// Hero image code:

$hero_image = get_field('hero_image');

if( !empty($hero_image) ):
	$hero_image_url =  $hero_image['url'];
endif; ?>
<div class="hide-for-large-up">
	<div class="products_single_hero<?php echo $this_items_product_category; ?>"<?php if( !empty($hero_image) ){ ?> style="background:url(<?php echo $hero_image_url; ?>);"<?php } ?>></div>
	<div class="products_single_product_image_container text-center row">
		<div class="products_single_product_image_background column small-8 small-offset-2 light-blue-bg">
			<div class="products_single_product_image">
<?php
			if ( has_post_thumbnail() ) { ?>
						<img src="<?php $featured_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $featured_image_url; ?>">
<?php
			} else { ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/product_image_not_found.png">
			<?php } ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="small-10 small-offset-1" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<header>
					<h1 class="title"><?php the_title(); ?></h1>
					<div id="myxx_lp_tgt"></div>
				</header>
	<?php if ( get_field('product_tagline') ){ ?>
				<div class="tagline"><?php the_field('product_tagline'); ?></div>
	<?php }
	if( get_field('cooking_suggestion') ){ ?>
				<div class="cooking_suggestion">
					<div class="cooking_suggestion_header">
						<div class="cooking_suggestion_heading"><?php _e('COOKING SUGGESTION','foundationpress')?></div>
						<div class="cooking_suggestion_content"><?php the_field('cooking_suggestion'); ?></div>
					</div>
				</div>
	<?php } ?>
			</article>
		</div>
	</div>

	<div class="row">
		<table class = "nutrition-table">
			<tr>
				<td class = "td-label td-header" colspan = 2>
					<h1>NUTRITIONAL INFORMATION</h1>
				</td>
			</tr>
			<tr>
				<td class = "td-label">SERVING SIZE</td>
				<td class = "td-value"><?php the_field('serving_size')?></td>
			</tr>
			<tr class = "tr-dark">
				<td class = "td-label">SERVINGS PER CONTAINER</td>
				<td class = "td-value"><?php the_field('servings_per_container')?></td>
			</tr>
			<tr>
				<td class = "td-label">&nbsp;</td>
				<td class = "td-value">&nbsp;</td>
			</tr>
			<tr class = "tr-dark">
				<td class = "td-label">AMOUNT PER SERVING</td>
				<td class = "td-value">&nbsp;</td>
			</tr>
			<tr>
				<td class = "td-label">CALORIES</td>
				<td class = "td-value"><?php the_field('calories')?></td>
			</tr>
			<tr class = "tr-dark">
				<td class = "td-label">CALORIES FROM FAT</td>
				<td class = "td-value"><?php the_field('calories_from_fat')?></td>
			</tr>
			<tr>
				<td class = "td-label td-header" colspan = "2">
					<h2>% DAILY VALUE*</h2>
				</td>
			</tr>
			<tr class = "tr-dark">
				<td class = "td-label no-upper">TOTAL FAT <?php the_field('total_fat_amount')?></td>
				<td class = "td-value"><?php the_field('total_fat_percentage')?>%</td>
			</tr>
			<tr>
				<td class = "td-label no-upper sub-label">SATURATED FAT <?php the_field('saturated_fat_amount')?></td>
				<td class = "td-value"><?php the_field('saturated_fat_percentage')?>%</td>
			</tr>
			<tr class = "tr-dark">
				<td class = "td-label no-upper sub-label">TRANS FAT <?php the_field('trans_fat_amount')?></td>
				<td class = "td-value"><?php if (!empty(get_field('trans_fat_percentage'))) { echo get_field('trans_fat_percentage') . '%'; } ?></td>
			</tr>
			<tr>
				<td class = "td-label no-upper">CHOLESTEROL <?php the_field('cholesterol_amount')?></td>
				<td class = "td-value"><?php the_field('cholesterol_percentage')?>%</td>
			</tr>
			<tr class = "tr-dark">
				<td class = "td-label no-upper">SODIUM <?php the_field('sodium_amount')?></td>
				<td class = "td-value"><?php the_field('sodium_percentage')?>%</td>
			</tr>
			<tr>
				<td class = "td-label no-upper">TOTAL CARB <?php the_field('total_carbohydrates_amount')?></td>
				<td class = "td-value"><?php if (!empty(get_field('total_carbohydrates_percentage'))) { echo get_field('total_carbohydrates_percentage') . '%'; } ?></td>
			</tr>
			<tr class = "tr-dark">
				<td class = "td-label no-upper sub-label">DIETARY FIBER <?php the_field('dietary_fiber_amount')?></td>
				<td class = "td-value"><?php the_field('dietary_fiber_percentage')?>%</td>
			</tr>
			<tr>
				<td class = "td-label no-upper sub-label">SUGARS <?php the_field('sugars_amount')?></td>
				<td class = "td-value"><?php if (!empty(get_field('sugars_percentage'))) { echo get_field('sugars_percentage') . '%'; } ?></td>
			</tr>
			<tr class = "tr-dark">
				<td class = "td-label no-upper">PROTEIN <?php the_field('protein_amount')?></td>
				<td class = "td-value"><?php if (!empty(get_field('protein_percentage'))) { echo get_field('protein_percentage') . '%'; } ?></td>
			</tr>
			<tr>
				<td class = "td-label" colspan = "2">
					VITAMIN A <?php the_field('vitamin_a')?>% &nbsp;&nbsp;&nbsp;VITAMIN C <?php the_field('vitamin_c')?>% &nbsp;&nbsp;&nbsp;CALCIUM <?php the_field('calcium')?>% &nbsp;&nbsp;&nbsp;IRON <?php the_field('iron')?>%<br/>
					<span class = "dv-label">* PERCENT DAILY VALUES (DV) ARE BASED ON A 2,000 CALORIE DIET</span>
				</td>
			</tr>

		</table>
	</div>
	<div class="clearfix"></div>
	<div class="try_these_recipes row text-center" style="margin-top:50px;">
		<div class="try_these_recipes_black_line"></div>
		<h3><?php _e('TRY THESE RECIPES','foundationpress')?></h3>
	</div>
	<?php get_template_part( 'parts/try', 'these-recipes' ); ?>
</div>
<?php /* Desktop Start */ ?>
<div class="show-for-large-up">
	<?php

	$hero_image = get_field('hero_image');

	if( !empty($hero_image) ):
		$hero_image_url =  $hero_image['url'];
	endif; ?>
	<div class="products_single_hero<?php echo $this_items_product_category; ?>"<?php if( !empty($hero_image) ){ ?> style="background-image:url(<?php echo $hero_image_url; ?>);"<?php } ?>></div>
	<div class="row">
		<div class="column large-6">
			<h1 class="title"><?php the_title(); ?></h1>
			<div id="myxx_lp_tgt"></div>
	<?php if ( get_field('product_tagline') ){ ?>
			<div class="tagline"><?php the_field('product_tagline'); ?></div>
	<?php }
	if( get_field('cooking_suggestion') ){ ?>
			<div class="cooking_suggestion">
				<div class="cooking_suggestion_header">
					<div class="cooking_suggestion_green_divider"></div>
					<div class="cooking_suggestion_heading"><?php _e('COOKING SUGGESTION','foundationpress')?></div>
					<div class="cooking_suggestion_content"><?php the_field('cooking_suggestion'); ?></div>
				</div>
			</div>
	<?php } ?>
		</div>
		<div class="column large-1">&nbsp;</div>
		<div class="column large-5">
			<div class="products_single_product_image_container relative-block text-center light-blue-bg">
				<div class="absolute-block flex-block">
					<div class="products_single_product_image">
			<?php
			if ( has_post_thumbnail() ) { ?>
						<img src="<?php $featured_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $featured_image_url; ?>">
<?php
			} else { ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/product_image_not_found.png">
			<?php } ?>
					</div>
				</div>
			</div>

			<div>
				<table class = "nutrition-table">
					<tr>
						<td class = "td-label td-header" colspan = 2>
							<h1>NUTRITIONAL INFORMATION</h1>
						</td>
					</tr>
					<tr>
						<td class = "td-label">SERVING SIZE</td>
						<td class = "td-value"><?php the_field('serving_size')?></td>
					</tr>
					<tr class = "tr-dark">
						<td class = "td-label">SERVINGS PER CONTAINER</td>
						<td class = "td-value"><?php the_field('servings_per_container')?></td>
					</tr>
					<tr>
						<td class = "td-label">&nbsp;</td>
						<td class = "td-value">&nbsp;</td>
					</tr>
					<tr class = "tr-dark">
						<td class = "td-label">AMOUNT PER SERVING</td>
						<td class = "td-value">&nbsp;</td>
					</tr>
					<tr>
						<td class = "td-label">CALORIES</td>
						<td class = "td-value"><?php the_field('calories')?></td>
					</tr>
					<tr class = "tr-dark">
						<td class = "td-label">CALORIES FROM FAT</td>
						<td class = "td-value"><?php the_field('calories_from_fat')?></td>
					</tr>
					<tr>
						<td class = "td-label td-header" colspan = "2">
							<h2>% DAILY VALUE*</h2>
						</td>
					</tr>
					<tr class = "tr-dark">
						<td class = "td-label no-upper">TOTAL FAT <?php the_field('total_fat_amount')?></td>
						<td class = "td-value"><?php the_field('total_fat_percentage')?>%</td>
					</tr>
					<tr>
						<td class = "td-label no-upper sub-label">SATURATED FAT <?php the_field('saturated_fat_amount')?></td>
						<td class = "td-value"><?php the_field('saturated_fat_percentage')?>%</td>
					</tr>
					<tr class = "tr-dark">
						<td class = "td-label no-upper sub-label">TRANS FAT <?php the_field('trans_fat_amount')?></td>
						<td class = "td-value"><?php if (!empty(get_field('trans_fat_percentage'))) { echo get_field('trans_fat_percentage') . '%'; } ?></td>
					</tr>
					<tr>
						<td class = "td-label no-upper">CHOLESTEROL <?php the_field('cholesterol_amount')?></td>
						<td class = "td-value"><?php the_field('cholesterol_percentage')?>%</td>
					</tr>
					<tr class = "tr-dark">
						<td class = "td-label no-upper">SODIUM <?php the_field('sodium_amount')?></td>
						<td class = "td-value"><?php the_field('sodium_percentage')?>%</td>
					</tr>
					<tr>
						<td class = "td-label no-upper">TOTAL CARB <?php the_field('total_carbohydrates_amount')?></td>
						<td class = "td-value"><?php if (!empty(get_field('total_carbohydrates_percentage'))) { echo get_field('total_carbohydrates_percentage') . '%'; } ?></td>
					</tr>
					<tr class = "tr-dark">
						<td class = "td-label no-upper sub-label">DIETARY FIBER <?php the_field('dietary_fiber_amount')?></td>
						<td class = "td-value"><?php the_field('dietary_fiber_percentage')?>%</td>
					</tr>
					<tr>
						<td class = "td-label no-upper sub-label">SUGARS <?php the_field('sugars_amount')?></td>
						<td class = "td-value"><?php if (!empty(get_field('sugars_percentage'))) { echo get_field('sugars_percentage') . '%'; } ?></td>
					</tr>
					<tr class = "tr-dark">
						<td class = "td-label no-upper">PROTEIN <?php the_field('protein_amount')?></td>
						<td class = "td-value"><?php if (!empty(get_field('protein_percentage'))) { echo get_field('protein_percentage') . '%'; } ?></td>
					</tr>
					<tr>
						<td class = "td-label" colspan = "2">
							VITAMIN A <?php the_field('vitamin_a')?>% &nbsp;&nbsp;&nbsp;VITAMIN C <?php the_field('vitamin_c')?>% &nbsp;&nbsp;&nbsp;CALCIUM <?php the_field('calcium')?>% &nbsp;&nbsp;&nbsp;IRON <?php the_field('iron')?>%<br/>
							<span class = "dv-label">* PERCENT DAILY VALUES (DV) ARE BASED ON A 2,000 CALORIE DIET</span>
						</td>
					</tr>

				</table>
			</div>
<?php
	// Ingredients
	if( get_field('ingredients') ): ?>
			<div class="ingredients">
				<?php the_field('ingredients'); ?>
			</div>
	<?php endif; ?>

		</div>
	</div>
	<div class="try_these_recipes row text-center"  style="margin-top:50px;">
		<div class="try_these_recipes_black_line"></div>
	</div>
	<?php endwhile;?>
</div>
<?php get_footer(); ?>