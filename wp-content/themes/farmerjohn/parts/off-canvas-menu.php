<?php
/**
 * Template part for off canvas menu
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */
if (get_locale() == 'es_MX') {
  $products = '/es/productos';
  $ourstory = '/es/nuestra-historia/';
  $foodsafety = '/es/seguridad-de-alimentos/';
  $contact = '/es/contactenos/';
  $recipes = '/es/recetas/';
} else {
  $products = '/products';
  $ourstory = '/our-story';
  $foodsafety = '/food-safety';
  $contact = '/contact';
  $recipes = '/recipes';
}
?>
    <a class="left-off-canvas-toggle" href="#"></a>

    <!-- Off Canvas Menu -->
    <aside class="right-off-canvas-menu" aria-hidden="true">
      <ul class="off-canvas-list">
        <li class="logo text-center">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png">
          </a>
        </li>
        <li>
          <?php if ( function_exists( 'the_msls' ) ) the_msls(); ?>
        </li>
        <li>
          <a href="<?php echo $products?>"><?php _e('Products','foundationpress')?></a>
        </li>
        <li class="has-submenu">
          <a href="<?php echo $ourstory?>"><?php _e('About Us','foundationpress')?></a>
          <ul class="right-submenu">
            <li class="back"><a href="#"><?php _e('Back','foundationpress')?></a></li>
            <li><label><?php _e('About Us','foundationpress')?></label></li>
            <li><a href="<?php echo $ourstory?>"><?php _e('Our Story','foundationpress')?></a></li>
            <li><a href="<?php echo $foodsafety?>"><?php _e('Food Safety','foundationpress')?></a></li>
            <li><a href="https://www.smithfieldfoods.com/careers"><?php _e('Careers','foundationpress')?></a></li>
            <li><a href="<?php echo $contact?>"><?php _e('Contact','foundationpress')?></a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo $recipes?>"><?php _e('Recipes','foundationpress')?></a>
        </li>
        <li>
        <li>
          <a href="http://productlocator.infores.com/productlocator/keg/keg.pli?client_id=156&productfamilyid=RIOJ" target="_blank"><?php _e('Where To Buy','foundationpress')?></a>
        </li>
        <li>
          <ul class="social text-center">
              <li>
                  <a target="_blank" href="http://facebook.com/farmerjohn">
                      <i class="fa fa-facebook"></i>
                  </a>
              </li>
              <li>
                  <a target="_blank" href="http://pinterest.com/farmerjohnLA">
                      <i class="fa fa-pinterest-p"></i>
                  </a>
              </li>
              <li>
                  <a target="_blank" href="http://instagram.com/farmerjohnla">
                      <i class="fa fa-instagram"></i>
                  </a>
              </li>
          </ul>
        </li>
      </ul>
    </aside>
    <div class="clearfix"></div>
