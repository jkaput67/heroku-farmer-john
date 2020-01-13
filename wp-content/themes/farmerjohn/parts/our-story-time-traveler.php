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
<div class="time-traveler-container">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post(); ?>
	<div class="time-traveler-slide<?php $title = get_the_title(); $pos = strpos( $title, "Late" ); if( $pos === false ){  } else { echo " late-decade"; } ?>">
		<div class="time-traveler-text-container">
			<h2><?php the_title(); ?></h2>
		</div>
		<div class="time-traveler-disc"></div>
	</div>
<?php } ?>
</div>
<div class="clearfix"></div>
<?php } 
/* Restore original Post Data */
wp_reset_postdata();
?>