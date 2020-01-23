<?php
/**
 * The History page template
 */
get_header(); ?>
<div class="row">
<?php
get_template_part( 'parts/our', 'story-hero' );
get_template_part( 'parts/our', 'story-time-traveler' );
get_template_part( 'parts/our', 'story-slider' ); ?>
	<div class="black-horizontal-divider"></div>
</div>
<?php
get_footer();
?>