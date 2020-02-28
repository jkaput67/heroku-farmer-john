<?php
/**
 * The homepage Our Story template
 */
?>
	<section class="homepage_our_story text-center">
		<?php if (get_locale() == 'es_MX'): ?>
			<img src="/es/wp-content/uploads/sites/2/2020/02/our-story-brand-ES.png">
		<?php else: ?>
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/our-story-brand.png">
		<?php endif; ?>
		<p class="show-for-large-up"><?php _e('Pioneering a revolution in the supply of locally flavorful meats,<br>FARMER JOHN has been a Southern California staple since practically forever.<br>See how the Clougherty Family’s commitment to high-quality MEATS<br>transformed their humble Vernon farm into the farm of the West.','foundationpress')?></p>
		<a class="show-for-large-up button dark-grey-button" href="/our-story"><?php _e('READ MORE','foundationpress')?></a>
	</section>
	<section class="hide-for-large-up text-center homepage_our_story_yellow">
		<p><?php _e('Pioneering a revolution in the supply of locally flavorful meats, FARMER JOHN has been a Southern California staple since practically forever.','foundationpress')?></p>
		<p><?php _e('See how the Clougherty Family’s commitment to high-quality MEATS transformed their humble Vernon farm into the farm of the West.','foundationpress')?></p>
		<br>
		<a class="button dark-grey-button" href="/our-story"><?php _e('READ MORE','foundationpress')?></a>
	</section>
	<div class="clearfix"></div>
<?php ?>