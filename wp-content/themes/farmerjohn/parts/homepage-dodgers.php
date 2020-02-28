<?php
/**
 * The homepage Dodgers template
 */
?>
	<section class="homepage_dodgers text-center">
	<?php if (get_locale() == 'es_MX'): ?>
		<img src="/es/wp-content/uploads/sites/2/2020/02/dodger-dog-content-ES.png">
	<?php else: ?>
		<img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/dodger-dog-content.png">
	<?php endif; ?>
		<div>
			<a class="button dark-grey-button" href="/partners/#dodgers"><?php _e('READ MORE','foundationpress')?></a>
		</div>
		<div class="clearfix"></div>
	</section>
	<div class="clearfix"></div>
<?php ?>