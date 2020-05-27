<?php
/**
 * The home page template
 */
get_header();
get_template_part( 'parts/homepage', 'slider' );
get_template_part( 'parts/homepage', 'products' );
get_template_part( 'parts/homepage', 'recipes' );
get_template_part( 'parts/homepage', 'our-story' );
get_template_part( 'parts/tips' );
get_template_part( 'parts/homepage', 'lafc' );
get_template_part( 'parts/homepage', 'dodgers' );
get_footer();
?>