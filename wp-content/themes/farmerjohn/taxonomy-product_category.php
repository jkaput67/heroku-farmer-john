<?php
/**
 * The Products Index template
 *
 */

get_header();

if( is_tax() ) {
    global $wp_query;
    $term = $wp_query->get_queried_object();
    $cat_title = $term->name;
    $cat_slug = $term->slug;
}

?>

<section class="products_archive">
	<div class="products_archive_hero <?php echo $cat_slug; ?>"></div>
	<div class="products_archive_filter_nav show-for-large-up light-yellow-bg">
		<div class="row">
			<div class="column products_archive_filter_item">
				<a href="/products" class="filter-all"><?php _e('ALL','foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item">
				<a href="/product_category/all-natural" class="<?php if( is_tax( 'product_category', 'all-natural' ) ){ echo "active "; } ?>filter-all-natural"><?php _e('ALL NATURAL','foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item">
				<a href="/product_category/bacon" class="<?php if( is_tax( 'product_category', 'bacon' ) ){ echo "active "; } ?>filter-bacon"><?php _e('BACON','foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item">
				<a href="/product_category/breakfast-sausage" class="<?php if( is_tax( 'product_category', 'breakfast-sausage' ) ){ echo "active "; } ?>filter-breakfast-sausage"><?php _e('BREAKFAST SAUSAGE','foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item">
				<a href="/product_category/ham" class="<?php if( is_tax( 'product_category', 'ham' ) ){ echo "active "; } ?>filter-ham"><?php _e('HAM','foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item">
				<a href="/product_category/hot-dogs" class="<?php if( is_tax( 'product_category', 'hot-dogs' ) ){ echo "active "; } ?>filter-hot-dogs"><?php _e('HOT DOGS','foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item">
				<a href="/product_category/lunch-meat" class="<?php if( is_tax( 'product_category', 'lunch-meat' ) ){ echo "active "; } ?>filter-lunch-meat"><?php _e('LUNCH MEAT','foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item">
				<a href="/product_category/smoked-sausage" class="<?php if( is_tax( 'product_category', 'smoked-sausage' ) ){ echo "active "; } ?>filter-smoked-sausage"><?php _e('SMOKED SAUSAGE','foundationpress')?></a>
			</div>
		</div>
	</div>
	<div class="products_archive_filter_nav hide-for-large-up light-yellow-bg">
		<a class="products_archive_filter_dropdown_toggle text-center">
			<h2 href="/products" class="filter-all"><?php _e('ALL PRODUCTS','foundationpress')?></h2>
			<h2 href="/product_category/all-natural" class="<?php if( is_tax( 'product_category', 'all-natural' ) ){ echo "active "; } ?>filter-all-natural"><?php _e('ALL NATURAL','foundationpress')?></h2>
			<h2 href="/product_category/bacon" class="<?php if( is_tax( 'product_category', 'bacon' ) ){ echo "active "; } ?>filter-bacon"><?php _e('BACON','foundationpress')?></h2>
			<h2 href="/product_category/breakfast-sausage" class="<?php if( is_tax( 'product_category', 'breakfast-sausage' ) ){ echo "active "; } ?>filter-breakfast-sausage"><?php _e('BREAKFAST SAUSAGE','foundationpress')?></h2>
			<h2 href="/product_category/ham" class="<?php if( is_tax( 'product_category', 'ham' ) ){ echo "active "; } ?>filter-ham"><?php _e('HAM','foundationpress')?></h2>
			<h2 href="/product_category/hot-dogs" class="<?php if( is_tax( 'product_category', 'hot-dogs' ) ){ echo "active "; } ?>filter-hot-dogs"><?php _e('HOT DOGS','foundationpress')?></h2>
			<h2 href="/product_category/lunch-meat" class="<?php if( is_tax( 'product_category', 'lunch-meat' ) ){ echo "active "; } ?>filter-lunch-meat"><?php _e('LUNCH MEAT','foundationpress')?></h2>
			<h2 href="/product_category/smoked-sausage" class="<?php if( is_tax( 'product_category', 'smoked-sausage' ) ){ echo "active "; } ?>filter-smoked-sausage"><?php _e('SMOKED SAUSAGE','foundationpress')?></h2>
			<div class="right dropdown-toggle collapsed"></div>
		</a>
		<div class="products_archive_filter_dropdown row">
			<div class="vertical-divider"></div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-all active"><?php _e('ALL PRODUCTS','foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item">
				<a href="/product_category/all-natural" class="<?php if( is_tax( 'product_category', 'all-natural' ) ){ echo "active "; } ?>filter-all-natural"><?php _e('ALL NATURAL','foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a href="/product_category/bacon" class="filter-bacon"><?php _e('BACON','foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a href="/product_category/breakfast-sausage" class="filter-breakfast-sausage"><?php _e('BREAKFAST SAUSAGE','foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a href="/product_category/ham" class="filter-ham"><?php _e('HAM','foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a href="/product_category/hot-dogs" class="filter-hot-dogs"><?php _e('HOT DOGS','foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a href="/product_category/lunch-meat" class="filter-lunch-meat"><?php _e('LUNCH MEAT','foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a href="/product_category/smoked-sausage" class="filter-smoked-sausage"><?php _e('SMOKED SAUSAGE','foundationpress')?></a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="column small-12">
			<div class="category_label_and_diet_filter_container show-for-large-up">
				<h2 class="products_archive_category_filter_label filter-all active"><?php echo strtoupper($cat_title); ?></h2>
			</div>
			<div class="category_label_and_diet_filter_container hide-for-large-up text-center">
				<h2 class="products_archive_category_filter_label filter-all active"><?php echo strtoupper($cat_title); ?></h2>
			</div>
			<div data-alert class="alert-box alert no-results-text">
			  <?php _e('No products match your search filter. Click \'All\' to see all Farmer John&reg; products.','foundationpress')?>
			</div>
		</div>
		<div class="products-results-container"></div>
		<div class="all-products-container">
		<?php if ( have_posts() ) : ?>

			<?php do_action( 'foundationpress_before_content' ); ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'products' ); ?>
			<?php endwhile; ?>
			<div class="clearfix"></div>

			<?php do_action( 'foundationpress_before_pagination' ); ?>

		<?php endif;?>
		</div>

		<?php do_action( 'foundationpress_after_content' ); ?>

	</div>
</section>
<?php get_template_part( 'parts/tips' ); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/custom/products-category.js"></script>
<?php get_footer(); ?>
