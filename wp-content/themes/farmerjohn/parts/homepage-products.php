<?php
/**
 * The homepage products template
 */
?>
	<section class="homepage_products light-yellow-bg text-center">
		<h2>OUR PRODUCTS</h2>
		<div class="row text-center">
			<a href="/product_category/bacon" class="homepage-product-column">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/products/baconblack.png">
			</a>
			<a href="/product_category/smoked-sausage" class="homepage-product-column">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/products/smokedsausageblack.png">
			</a>
<!-- 			<a href="/product_category/california-natural-fresh-pork" class="homepage-product-column">
				<img src="<?php //echo get_template_directory_uri(); ?>/assets/img/home/products/freshporkblack.png">
			</a> -->
			<a href="/product_category/ham" class="homepage-product-column">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/products/hamblack.png">
			</a>
			<a href="/product_category/hot-dogs" class="homepage-product-column">
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