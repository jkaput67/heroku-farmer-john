<?php
/**
 * The Contact page template
 */
get_header();
get_template_part( 'parts/contact', 'hero' );
get_template_part( 'parts/contact', 'content' ); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/custom/contact.js"></script>
<?php get_footer();
?>