<?php
/**
 * The homepage tips template
 */
?>
	<section class="tips">
		<div class="column small-12 large-6 tip green-bg">
			<div class="tip_icon_bg absolute-block" style="background:url(<?php echo get_template_directory_uri(); ?>/assets/img/home/tip-left.png);">
				<h2><?php _e('COOKING TIP','foundationpress')?></h2>
				<div class="homepage-tip-divider"></div>
				<p><?php _e('Meal prep is a key ingredient to artful cooking. Always set aside all equipment, utensils, ingredients and spices before you start cooking.','foundationpress')?></p>
			</div>
		</div>
		<div class="column small-12 large-6 tip peach-bg">
			<div class="tip_icon_bg absolute-block" style="background:url(<?php echo get_template_directory_uri(); ?>/assets/img/home/tip-right.png);">
				<h2><?php _e('HEALTH TIP','foundationpress')?></h2>
				<div class="homepage-tip-divider"></div>
				<p><?php _e('Spice it up! Even eating just one meal with the compound capsaicin, commonly found in hot sauce, can reduce levels of the hunger-inducing hormone ghrelin.','foundationpress')?></p>
			</div>
		</div>
	</section>
	<div class="clearfix"></div>
<?php ?>