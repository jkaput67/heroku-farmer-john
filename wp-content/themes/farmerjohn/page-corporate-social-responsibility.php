<?php
/**
 * The Corporate Social Responsibility template
 */
get_header(); ?>
<section class="page-csr">
<?php
get_template_part( 'parts/csr', 'hero' );
get_template_part( 'parts/csr', 'content' );
?>
</section>
<?php get_footer(); ?>