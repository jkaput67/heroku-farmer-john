
<?php
/**
 * The landing page template
 */
get_header();
get_template_part( 'parts/landing', 'hero' );
get_template_part('parts/landing', 'bresee');
//get_template_part('parts/landing', 'slider');
get_template_part( 'parts/landing', 'banner' );
get_template_part( 'parts/landing', 'video' );
get_template_part('parts/landing', 'schedule');
get_template_part('parts/landing', 'banner-hungry');
get_template_part('parts/landing', 'recipes');
get_template_part('parts/landing', 'all-recipe-btn');

get_footer();
?>