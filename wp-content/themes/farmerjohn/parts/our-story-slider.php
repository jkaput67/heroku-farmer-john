<?php
/**
 * The History slider template
 */
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'history_sliders',
	'orderby' => 'menu_order',
	'order' => 'ASC',
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {?>
<div class="our_story_slider_container">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post(); ?>
	<div class="our_story_slide">
		<header class="text-center light-blue-bg">
			<div class="our_story_slide_title_top"><?php the_field('title_top'); ?></div>
			<div class="our_story_slide_title_bottom"><?php the_field('title_bottom'); ?></div>
		</header>
		<div class="our_story_slide_content text-center">
			<div class="row" data-equalizer data-equalizer-mq="large-up">
				<div class="column small-12 large-4 our_story_slide_image_container" data-equalizer-watch>
					<img src="<?php the_field('slider_image'); ?>">
				</div>
				<div class="column small-12 large-8 our_story_slide_copy_container" data-equalizer-watch>
					<div class="our_story_slide_copy"><?php the_field('body_copy'); ?></div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
</div>
<div class="clearfix"></div>
<?php } 
/* Restore original Post Data */
wp_reset_postdata();
?>