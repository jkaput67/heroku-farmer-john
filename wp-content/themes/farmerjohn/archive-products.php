<?php
/**
 * The Products Index template
 *
 */

get_header(); 

if (get_locale() == 'es_MX') {
	$filter_all_natural = 'filter-todo-natural';
	$filter_bacon = 'filter-tocino';
	$filter_breakfast_sausage = 'filter-salchichas-desayuno';
	$filter_ham = 'filter-jamon';
	$filter_lunch_meat = 'filter-carne-almuerzo';
	$filter_smoked_sausage = 'filter-salchicha-ahumada';
} else {
	$filter_all_natural = 'filter-all-natural';
	$filter_bacon = 'filter-bacon';
	$filter_breakfast_sausage = 'filter-breakfast-sausage';
	$filter_ham = 'filter-ham';
	$filter_lunch_meat = 'filter-lunch-meat';
	$filter_smoked_sausage = 'filter-smoked-sausage';
}
?>

<style>
	.filter_centered > .row {
		display: flex;
		justify-content: center;
	}
</style>

<section class="products_archive">
	<div class="products_archive_hero"></div>
	<div class="products_archive_filter_nav show-for-large-up light-yellow-bg filter_centered">
		<div class="row">
			<div class="column products_archive_filter_item" style="width:10%">
				<a class="filter-all active"><?php _e('ALL', 'foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item" style="width:10%">
				<a class="<?php echo $filter_all_natural?>"><?php _e('ALL NATURAL', 'foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item" style="width:10%">
				<a class="<?php echo $filter_bacon?>"><?php _e('BACON', 'foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item" style="width:10%">
				<a class="<?php echo $filter_breakfast_sausage?>"><?php _e('BREAKFAST SAUSAGE', 'foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item" style="width:10%">
				<a class="<?php echo $filter_ham?>"><?php _e('HAM', 'foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item" style="width:10%">
				<a class="filter-hot-dogs"><?php _e('HOT DOGS', 'foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item" style="width:10%">
				<a class="<?php echo $filter_lunch_meat?>"><?php _e('LUNCH MEAT', 'foundationpress')?></a>
			</div>
			<div class="column products_archive_filter_item" style="width:10%; border: 0">
				<a class="<?php echo $filter_smoked_sausage?>"><?php _e('SMOKED SAUSAGE', 'foundationpress')?></a>
			</div>
		</div>
	</div>
	<div class="products_archive_filter_nav hide-for-large-up light-yellow-bg">
		<a class="products_archive_filter_dropdown_toggle text-center">
			<h2 class="filter-all active"><?php _e('ALL PRODUCTS', 'foundationpress')?></h2>
			<h2 class="<?php echo $filter_all_natural?>"><?php _e('ALL NATURAL', 'foundationpress')?></h2>
			<h2 class="<?php echo $filter_bacon?>"><?php _e('BACON', 'foundationpress')?></h2>
			<h2 class="<?php echo $filter_breakfast_sausage?>"><?php _e('BREAKFAST SAUSAGE', 'foundationpress')?></h2>
			<h2 class="<?php echo $filter_ham?>"><?php _e('HAM', 'foundationpress')?></h2>
			<h2 class="filter-hot-dogs"><?php _e('HOT DOGS', 'foundationpress')?></h2>
			<h2 class="<?php echo $filter_lunch_meat?>"><?php _e('LUNCH MEAT', 'foundationpress')?></h2>
			<h2 class="<?php echo $filter_smoked_sausage?>"><?php _e('SMOKED SAUSAGE', 'foundationpress')?></h2>
			<div class="right dropdown-toggle collapsed"></div>
		</a>
		<div class="products_archive_filter_dropdown row">
			<div class="vertical-divider"></div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-all active"><?php _e('ALL PRODUCTS', 'foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="<?php echo $filter_all_natural?>"><?php _e('ALL NATURAL', 'foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="<?php echo $filter_bacon?>"><?php _e('BACON', 'foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="<?php echo $filter_breakfast_sausage?>"><?php _e('BREAKFAST SAUSAGE', 'foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="<?php echo $filter_ham?>"><?php _e('HAM', 'foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="filter-hot-dogs"><?php _e('HOT DOGS', 'foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="<?php echo $filter_lunch_meat?>"><?php _e('LUNCH MEAT', 'foundationpress')?></a>
			</div>
			<div class="column small-12 products_archive_filter_item text-center">
				<a class="<?php echo $filter_smoked_sausage?>"><?php _e('SMOKED SAUSAGE', 'foundationpress')?></a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="column small-12">
			<div class="category_label_and_diet_filter_container show-for-large-up">
				<h2 class="products_archive_category_filter_label filter-all active"><?php _e('ALL FARMER JOHN PRODUCTS', 'foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_all_natural?>"><?php _e('ALL NATURAL', 'foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_bacon?>"><?php _e('BACON', 'foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_breakfast_sausage?>"><?php _e('BREAKFAST SAUSAGE', 'foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_ham?>"><?php _e('HAM', 'foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label filter-hot-dogs"><?php _e('HOT DOGS', 'foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_lunch_meat?>"><?php _e('LUNCH MEAT', 'foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_smoked_sausage?>"><?php _e('SMOKED SAUSAGE', 'foundationpress')?></h2>
<?php
$taxonomies = array(
    'diet',
);
$args = array(
    'orderby'           => 'name',
    'order'             => 'ASC',
);
$terms = get_terms($taxonomies, $args); ?>
 				<div class="right diet_filter" style="visibility: hidden;">
					<select class="diet_dropdown" data-placeholder="FILTER">
						<option value="none"><?php _e('FILTER','foundationpress')?></option>
						<option value="none" selected="selected"><?php _e('SHOW ALL','foundationpress')?></option>
<?php foreach ($terms as $term) { ?>
						<option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?>&nbsp;&nbsp;&nbsp;</option>
<?php } ?>
					</select>
				</div>
			</div>
			<div class="category_label_and_diet_filter_container hide-for-large-up text-center" style="visibility: hidden;">
				<h2 class="products_archive_category_filter_label filter-all active"><?php _e('ALL FARMER JOHN PRODUCTS','foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_all_natural?>"><?php _e('ALL NATURAL','foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_bacon?>"><?php _e('BACON','foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_breakfast_sausage?>"><?php _e('BREAKFAST SAUSAGE','foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_ham?>"><?php _e('HAM','foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label filter-hot-dogs"><?php _e('HOT DOGS','foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_lunch_meat?>"><?php _e('LUNCH MEAT','foundationpress')?></h2>
				<h2 class="products_archive_category_filter_label <?php echo $filter_smoked_sausage?>"><?php _e('SMOKED SAUSAGE','foundationpress')?></h2>
 				<div class="diet_filter">
					<select class="diet_dropdown" data-placeholder="FILTER">
						<option value="none"><?php _e('FILTER','foundationpress')?></option>
						<option value="none" selected="selected"><?php _e('SHOW ALL','foundationpress')?></option>
<?php foreach ($terms as $term) { ?>
						<option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?>&nbsp;&nbsp;&nbsp;</option>
<?php } ?>
					</select>
				</div>
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
<script src="<?php echo get_template_directory_uri(); ?>/js/custom/products-archive.js"></script>

<script>

    $(document).ready(function() {

        setTimeout('$("select").select2("val", "none");',500);

    });

</script>
<?php get_footer(); ?>
