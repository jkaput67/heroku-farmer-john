<?php
/**
 * The careers slider template
 */
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'careers_sliders',
	'orderby' => 'menu_order',
	'order' => 'ASC',
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {?>
	<section class="careers_slider_container">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post();
		if( get_field('employee_image') ){ ?>
		<div class="careers_slider_slide text-center">
			<img class="careers_slider" src="<?php the_field('employee_image'); ?>">
		</div>
<?php 	}
	} ?>
	</section>
<?php } ?>
<div class="clearfix"></div>
<?php
if ( $the_query->have_posts() ) {?>
	<section class="careers_slider_quote_container">
<?php while ( $the_query->have_posts() ) {
		$the_query->the_post(); ?>
		<div class="careers_quote_slide">
<?php	if( get_field('employee_quote') ){ ?>
		<div class="employee_quote">&ldquo;<?php the_field('employee_quote'); ?>&rdquo;</div>
<?php 	} ?>
<?php	if( get_field('employee_quote_attribution') ){ ?>
		<div class="employee_quote_attribution">&dash;<?php the_field('employee_quote_attribution'); ?></div>
<?php 	} ?>
<?php	if( get_field('employee_job_title') ){ ?>
		<div class="employee_job_title"><?php the_field('employee_job_title'); ?></div>
<?php 	} ?>
		</div>
<?php } ?>
	</section>
<?php } ?>
<div class="clearfix"></div>
<?php wp_reset_postdata(); ?>