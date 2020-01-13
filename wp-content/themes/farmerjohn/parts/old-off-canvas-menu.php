<?php
/**
 * Template part for off canvas menu
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

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
          <a href="/products">Products</a>
        </li>
        <li class="has-submenu">
          <a href="/our-story">About Us</a>
          <ul class="right-submenu">
            <li class="back"><a href="#">Back</a></li>
            <li><label>About Us</label></li>
            <li><a href="/our-story">Our Story</a></li>
            <li><a href="/food-safety">Food Safety</a></li>
            <li><a href="/careers">Careers</a></li>
            <li><a href="/contact">Contact</a></li>
          </ul>
        </li>
        <li>
          <a href="/recipes">Recipes</a>
        </li>
        <li>
          <a href="/social">Social Media</a>
        </li>
        <li>
        <li>
          <a href="/where-to-buy">Where To Buy</a>
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
