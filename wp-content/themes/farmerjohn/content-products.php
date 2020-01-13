<?php
/**
 * The default template for displaying Products
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

if ( has_post_thumbnail( $post->ID ) ) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
} else {
	$image = array( get_template_directory_uri().'/assets/img/products/product_image_not_found.png' );
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('column','small-6','large-3','products-archive-product','text-center')); ?>>
	<a href="<?php the_permalink(); ?>">
		<div class="products-archive-photo" style="background:url(<?php echo $image[0]; ?>);"></div>
		<footer>
<?php

if ( has_category( 'california-natural-fresh-pork', $post->ID ) ) { ?>
			<div class="text-center">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/products/california-natural.png">
			</div>
<?php } ?>
			<h2 class="products-archive-product-title"><?php the_title(); ?></h2>
		</footer>
	</a>
	
</article>