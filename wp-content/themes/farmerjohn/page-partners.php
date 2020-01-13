<?php
/**
 * The Partners page template
 */
get_header(); ?>
<section class="page-partners">
<?php /*
// This code contains the full-width page within the grid
	<div class="row">
		<div class="column small-12">
*/ ?>
<?php get_template_part( 'parts/partners', 'hero' ); ?>
<?php get_template_part( 'parts/partners', 'content' ); ?>
<?php /*
		</div>
	</div>
*/ ?>
</section>
<?php
get_footer();
?>