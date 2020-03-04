<?php
/**
 * The homepage products template
 */
if (get_locale() == 'es_MX') {
	$bacon = '/es/product_category/tocino';
	$sausage = '/es/product_category/salchica-ahumada';
	$ham = '/es/product_category/jamon';
	$hotdogs = '/es/product_category/hot-dogs';
} else {
	$bacon = '/product_category/bacon';
	$sausage = '/product_category/smoked-sausage';
	$ham = '/product_category/ham';
	$hotdogs = '/product_category/hot-dogs';
}
?>
	<section class="homepage_products light-yellow-bg text-center">
		<h2><?php _e('OUR PRODUCTS','foundationpress')?></h2>
		<div class="row text-center">
			<a href="<?php echo $bacon?>" class="homepage-product-column">
				<?php if (get_locale() == 'es_MX'): ?>
					<img src="/es/wp-content/uploads/sites/2/2020/02/baconblack-ES.png">
				<?php else: ?>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/products/baconblack.png">
				<?php endif; ?>
			</a>
			<a href="<?php echo $sausage?>" class="homepage-product-column">
			<?php if (get_locale() == 'es_MX'): ?>
				<img src="/es/wp-content/uploads/sites/2/2020/02/smokedsausageblack-ES.png">
			<?php else: ?>
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/products/smokedsausageblack.png">
			<?php endif; ?>
			</a>
			<a href="<?php echo $ham?>" class="homepage-product-column">
			<?php if (get_locale() == 'es_MX'): ?>
				<img src="/es/wp-content/uploads/sites/2/2020/02/hamblack-ES.png">
			<?php else: ?>
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/products/hamblack.png">
			<?php endif; ?>
			</a>
			<a href="<?php echo $hotdogs?>" class="homepage-product-column">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/products/hotdogsblack.png">
			</a>
		</div>
	</section>
	<div class="clearfix"></div>

	<style>
		@media (min-width: 768px) {
			.homepage-product-column {
				width: 25%!important;
			}
		}
	</style>