<?php
/**
 * The Health page template
 */
get_header(); ?>
<section class="page-health">
<?php
get_template_part( 'parts/health', 'hero' );
get_template_part( 'parts/health', 'content' );
get_template_part( 'parts/health', 'slider' ); ?>
</section>
<?php get_footer(); ?>