<?php
/**
 * The Products Index template
 *
 */

get_header(); ?>

<section class="products_archive">
	<div class="products_archive_hero"></div>
	<div class="products_archive_filter_nav show-for-large-up light-yellow-bg">
		<div class="row">
			<div class="column products_archive_filter_item">
				<a class="filter-all active">ALL</a>
			</div>
			<div class="column products_archive_filter_item">
				<a class="filter-california-natural-fresh-pork">CALIFORNIA NATURAL FRESH PORK</a>
			</div>
			<div class="column products_archive_filter_item">
				<a class="filter-bacon">BACON</a>
			</div>
			<div class="column products_archive_filter_item">
				<a class="filter-breakfast-sausage">BREAKFAST SAUSAGE</a>
			</div>
			<div class="column products_archive_filter_item">
				<a class="filter-ham">HAM</a>
			</div>
			<div class="column products_archive_filter_item">
				<a class="filter-hot-dogs">HOT DOGS</a>
			</div>
			<div class="column products_archive_filter_item">
				<a class="filter-lunch-meat">LUNCH MEAT</a>
			</div>
			<div class="column products_archive_filter_item">
				<a class="filter-smoked-sausage">SMOKED SAUSAGE</a>
			</div>
		</div>
	</div>
	<div class="products_archive_filter_nav hide-for-large-up light-yellow-bg">
		<a class="products_archive_filter_dropdown_toggle text-center">
			<h2 class="filter-all active">ALL PRODUCTS</h2>
			<h2 class="filter-california-natural-fresh-pork">CALIFORNIA NATURAL FRESH PORK</h2>
			<h2 class="filter-bacon">BACON</h2>
			<h2 class="filter-breakfast-sausage">BREAKFAST SAUSAGE</h2>
			<h2 class="filter-ham">HAM</h2>
			<h2 class="filter-hot-dogs">HOT DOGS</h2>
			<h2 class="filter-lunch-meat">LUNCH MEAT</h2>
			<h2 class="filter-smoked-sausage">SMOKED SAUSAGE</h2>
			<div class="right dropdown-toggle collapsed"></div>
		</a>
		<div class="products_archive_filter_dropdown row">
			<div class="vertical-divider"></div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-all active">ALL PRODUCTS</a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-california-natural-fresh-pork">CALIFORNIA NATURAL FRESH PORK</a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-bacon">BACON</a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-breakfast-sausage">BREAKFAST SAUSAGE</a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-ham">HAM</a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-hot-dogs">HOT DOGS</a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-lunch-meat">LUNCH MEAT</a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-smoked-sausage">SMOKED SAUSAGE</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="column small-12">
			<div class="category_label_and_diet_filter_container show-for-large-up">
				<h2 class="products_archive_category_filter_label filter-all active">ALL FARMER JOHN PRODUCTS</h2>
				<h2 class="products_archive_category_filter_label filter-california-natural-fresh-pork">CALIFORNIA NATURAL FRESH PORK</h2>
				<h2 class="products_archive_category_filter_label filter-bacon">BACON</h2>
				<h2 class="products_archive_category_filter_label filter-breakfast-sausage">BREAKFAST SAUSAGE</h2>
				<h2 class="products_archive_category_filter_label filter-ham">HAM</h2>
				<h2 class="products_archive_category_filter_label filter-hot-dogs">HOT DOGS</h2>
				<h2 class="products_archive_category_filter_label filter-lunch-meat">LUNCH MEAT</h2>
				<h2 class="products_archive_category_filter_label filter-smoked-sausage">SMOKED SAUSAGE</h2>
<?php 
$taxonomies = array( 
    'diet',
);
$args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
); 
$terms = get_terms($taxonomies, $args); ?>
 				<div class="right diet_filter">
					<select class="diet_dropdown">
						<optgroup label="DIET">
							<option value="none" selected="selected">No Dietary Restrictions</option>
<?php foreach ($terms as $term) { ?>
						<option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?>&nbsp;&nbsp;&nbsp;</option>
<?php } ?>
						</optgroup>
					</select>
				</div>
			</div>
			<div class="category_label_and_diet_filter_container hide-for-large-up text-center">
				<h2 class="products_archive_category_filter_label filter-all active">ALL FARMER JOHN PRODUCTS</h2>
				<h2 class="products_archive_category_filter_label filter-california-natural-fresh-pork">CALIFORNIA NATURAL FRESH PORK</h2>
				<h2 class="products_archive_category_filter_label filter-bacon">BACON</h2>
				<h2 class="products_archive_category_filter_label filter-breakfast-sausage">BREAKFAST SAUSAGE</h2>
				<h2 class="products_archive_category_filter_label filter-ham">HAM</h2>
				<h2 class="products_archive_category_filter_label filter-hot-dogs">HOT DOGS</h2>
				<h2 class="products_archive_category_filter_label filter-lunch-meat">LUNCH MEAT</h2>
				<h2 class="products_archive_category_filter_label filter-smoked-sausage">SMOKED SAUSAGE</h2>
 				<div class="diet_filter">
					<select class="diet_dropdown">
						<optgroup label="DIET">
							<option value="none" selected="selected">No Dietary Restrictions</option>
<?php foreach ($terms as $term) { ?>
							<option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?>&nbsp;&nbsp;&nbsp;</option>
<?php } ?>
						</optgroup>
					</select>
				</div>
			</div>
			<div data-alert class="alert-box alert no-results-text">
			  No products match your search filter. Click 'All' to see all Farmer John&reg; products.
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
<script src="<?php echo get_template_directory_uri(); ?>/js/custom/products-archive.js"></script>
<?php get_footer(); ?>
