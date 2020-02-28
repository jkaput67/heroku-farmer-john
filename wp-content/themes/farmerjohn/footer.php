<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */
?>

<html>
<body>
<footer class="row show-for-large-up">
	<div class="column large-8">
		<div class="row footer-nav">
			<div class="column large-3">
				<a href="<?php echo get_locale() == 'es_MX' ? '/es/productos' : '/products' ?>"><?php _e('PRODUCTS', 'foundationpress')?></a>
				<a href="<?php echo get_locale() == 'es_MX' ? '/es/recetas' : '/recipes' ?>"><?php _e('RECIPES', 'foundationpress')?></a>
				<a href="<?php echo get_page_link(414)?>"><?php _e('OUR STORY', 'foundationpress')?></a>
			</div>
			<div class="column large-3">
				<a href="<?php echo get_page_link(380)?>"><?php _e('HEALTH', 'foundationpress')?></a>
				<a href="<?php echo get_page_link(376)?>"><?php _e('PARTNERS', 'foundationpress')?></a>
				<a href="http://productlocator.infores.com/productlocator/keg/keg.pli?client_id=156&productfamilyid=RIOJ" target="_blank"><?php _e('WHERE TO BUY', 'foundationpress')?></a>
			</div>
			<div class="column large-3">
				<a href="<?php echo get_page_link(403)?>"><?php _e('CA TRANSPARENCY ACT', 'foundationpress')?></a>
				<a href="<?php echo get_page_link(399)?>"><?php _e('PRIVACY POLICY', 'foundationpress')?></a>
				<a href="https://www.smithfieldfoods.com/ca-privacy-policy"><?php _e('CALIFORNIA PRIVACY', 'foundationpress')?></a>
			</div>
			<div class="column large-3">
				<a target="_blank" href="http://www.smithfieldfoods.com/terms-of-use"><?php _e('TERMS OF USE', 'foundationpress')?></a>
				<a href="<?php echo get_page_link(405)?>"><?php _e('CONTACT', 'foundationpress')?></a>
				<a href="https://www.smithfieldfoods.com/careers" target="_blank"><?php _e('CAREERS', 'foundationpress')?></a>
			</div>
		</div>
	</div>
	<div class="column large-4 text-center">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/logo_lg.png">
        </a>
        <div class="footer-social">
	        <a target="_blank" href="http://facebook.com/farmerjohn">
	            <i class="fa fa-facebook"></i>
	        </a>
	        <a target="_blank" href="http://pinterest.com/farmerjohnLA">
	            <i class="fa fa-pinterest-p"></i>
	        </a>
	        <a target="_blank" href="http://instagram.com/farmerjohnla">
	            <i class="fa fa-instagram"></i>
	        </a>
	        <a target="_blank" href="https://www.linkedin.com/company/clougherty-packing-llc">
	            <i class="fa fa-linkedin"></i>
	        </a>
	        <a target="_blank" href="http://twitter.com/farmerjohnla">
	            <i class="fa fa-twitter"></i>
	        </a>
        </div>
        <div class="copyright">&copy; <?php echo date("Y"); ?> Farmer John, LLC</div>
	</div>
</footer>

<footer class="hide-for-large-up">
	<div class="row footer-nav">
		<div class="column small-7">
			<a href="<?php echo get_locale() == 'es_MX' ? '/es/productos' : '/products' ?>"><?php _e('PRODUCTS', 'foundationpress')?></a>
			<a href="<?php echo get_locale() == 'es_MX' ? '/es/recetas' : '/recipes' ?>"><?php _e('RECIPES', 'foundationpress')?></a>
			<a href="<?php echo get_page_link(414)?>"><?php _e('OUR STORY', 'foundationpress')?></a>
		</div>
		<div class="column small-5">
			<a href="<?php echo get_page_link(380)?>"><?php _e('HEALTH', 'foundationpress')?></a>
			<a href="<?php echo get_page_link(376)?>"><?php _e('PARTNERS', 'foundationpress')?></a>
			<a href="http://productlocator.infores.com/productlocator/keg/keg.pli?client_id=156&productfamilyid=RIOJ" target="_blank"><?php _e('WHERE TO BUY', 'foundationpress')?></a>
		</div>
	</div>
	<div class="row footer-nav">
		<div class="column small-7">
			<a href="<?php echo get_page_link(403)?>" class="ca_transparency_act"><?php _e('CA TRANSPARENCY ACT', 'foundationpress')?></a>
			<a href="<?php echo get_page_link(399)?>"><?php _e('PRIVACY POLICY', 'foundationpress')?></a>
			<a href="https://www.smithfieldfoods.com/ca-privacy-policy"><?php _e('CALIFORNIA PRIVACY', 'foundationpress')?></a>

		</div>
		<div class="column small-5">
			<a target="_blank" href="http://www.smithfieldfoods.com/terms-of-use"><?php _e('TERMS OF USE', 'foundationpress')?></a>
			<a href="<?php echo get_page_link(405)?>"><?php _e('CONTACT', 'foundationpress')?></a>
			<a href="https://www.smithfieldfoods.com/careers" target="_blank">CAREERS</a>
		</div>
	</div>

	<div class="row">
		<div class="column small-12 text-center">
	        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/logo_lg.png">
	        </a>
	        <div class="footer-social">
		        <a target="_blank" href="http://facebook.com/farmerjohn">
		            <i class="fa fa-facebook"></i>
		        </a>
		        <a target="_blank" href="http://pinterest.com/farmerjohnLA">
		            <i class="fa fa-pinterest-p"></i>
		        </a>
		        <a target="_blank" href="http://instagram.com/farmerjohnla">
		            <i class="fa fa-instagram"></i>
		        </a>
		        <a target="_blank" href="https://www.linkedin.com/company/clougherty-packing-llc">
		            <i class="fa fa-linkedin"></i>
		        </a>
		        <a target="_blank" href="https://twitter.com/FarmerJohnLA">
		            <i class="fa fa-twitter"></i>
		        </a>
		        <a target="_blank" href="http://www.youtube.com/user/FarmerJohnLA">
		            <i class="fa fa-youtube"></i>
		        </a>
		        <a target="_blank" href="https://www.tumblr.com/tagged/farmerjohn">
		            <i class="fa fa-tumblr"></i>
		        </a>
	        </div>
	        <div class="copyright">&copy; <?php echo date("Y"); ?> Farmer John, LLC</div>
		</div>
	</div>
</footer>

<a class="exit-off-canvas"></a>

	<?php do_action( 'foundationpress_layout_end' ); ?>

	</div>
</div>

<?php wp_footer(); ?>
<?php do_action( 'foundationpress_before_closing_body' ); ?>
<!-- Google Code for Remarketing Tag -->
	<!---
	Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
	--------------------------------------------------->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 803318264;
	var google_custom_params = window.google_tag_params;
	var google_remarketing_only = true;
	/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/803318264/?guid=ON&amp;script=0"/>
	</div>
	</noscript>
</body>
</html>
