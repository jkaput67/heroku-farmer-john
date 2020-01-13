<?php
/**
 * Template part for top bar menu
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<div class="top-bar-container contain-to-grid">
    <nav class="tab-bar hide-for-large-up">
        <section class="right-small">
            <a class="right-off-canvas-toggle menu-icon" aria-expanded="false"><span></span></a>
        </section>
        <section class="text-center">
            <div class="top-bar-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/logo_lg.png">
                </a>
            </div>
        </section>
    </nav>
    <nav class="top-bar show-for-large-up" data-topbar role="navigation">
        <section class="text-center top-bar-logo-container">
            <ul>
                <li class="top-bar-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/logo_lg.png">
                    </a>
                </li>
            </ul>
        </section>
        <section class="top-bar-section show-for-large-up">
            <!-- Right Nav Section -->
            <ul class="right">
                <li<?php if ( is_page('Where To Buy') ) { echo ' class="active"'; } ?>>
                    <a href="/where-to-buy">Where To Buy</a>
                </li>
		<li class="has-dropdown<?php if ( is_page( array('Social Media', 'Partners' ) ) ) { echo ' active'; } ?>">
                    <a href="/social">Social Media</a>
                </li>
                <li>
                    <ul class="social">
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

            <!-- Left Nav Section -->
            <ul class="left">
                <li<?php if ( is_post_type_archive( 'products' ) || is_singular( 'products' ) ) { echo ' class="active"'; } ?>>
                    <a href="/products">Products</a>
                </li>
                <li class="has-dropdown<?php if ( is_page( array('Our Story','Food Safety', 'Careers', 'Contact' ) ) ) { echo ' active'; } ?>">
                    <a>About Us</a>
                    <ul class="dropdown">
                        <li class="first-child"><a href="/our-story">Our Story</a></li>
                        <li><a href="/food-safety">Food Safety</a></li>
                        <li><a href="https://www.smithfieldfoods.com/careers" target="_blank">Careers</a></li>
                        <li><a href="/contact">Contact</a></li>
                    </ul>
                </li>
                <li<?php if ( is_post_type_archive( 'recipes' ) || is_single( 'recipes' ) ) { echo ' class="active"'; } ?>>
                    <a href="/recipes">Recipes</a>
                </li>
            </ul>
        </section>
    </nav>
</div>
<div class="clearfix"></div>
