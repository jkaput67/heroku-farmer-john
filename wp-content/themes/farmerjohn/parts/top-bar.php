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
            <ul class="right" style="width: calc(50% - 117px); display: -webkit-box;  display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; justify-content: flex-start; -webkit-justify-content: flex-start;">
                <li<?php if ( is_page('Where To Buy') ) { echo ' class="active"'; } ?>>
                    <a target="_blank" href="http://productlocator.infores.com/productlocator/keg/keg.pli?client_id=156&productfamilyid=RIOJ"><?php _e('Where To Buy','foundationpress')?></a>
                </li>
                <!-- <li class="has-dropdown<?php //if ( is_page( array('Social Media', 'Partners' ) ) ) { echo ' active'; } ?>">
                    <a href="/social">Social Media</a>
                </li> -->
                <li class="has-dropdown<?php if ( is_page( array('Our Story','Food Safety', 'Careers', 'Contact' ) ) ) { echo ' active'; } ?>">
                    <a>About Us</a>
                    <ul class="dropdown">
                        <li class="first-child"><a href="/our-story"><?php _e('Our Story','foundationpress')?></a></li>
                        <li><a href="/food-safety"><?php _e('Food Safety','foundationpress')?></a></li>
                        <li><a href="https://www.smithfieldfoods.com/careers" target="_blank"><?php _e('Careers','foundationpress')?></a></li>
                        <li><a href="/contact"><?php _e('Contact','foundationpress')?></a></li>
                    </ul>
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
            <ul class="left" style="width: calc(50% - 117px); display: -webkit-box;  display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; justify-content: flex-end; -webkit-justify-content: flex-end;">
                <li<?php if ( is_post_type_archive( 'products' ) || is_singular( 'products' ) ) { echo ' class="active"'; } ?>>
                    <a href="/products"><?php _e('Products','foundationpress')?></a>
                </li>
            
                <li<?php if ( is_post_type_archive( 'recipes' ) || is_single( 'recipes' ) ) { echo ' class="active"'; } ?>>
                    <a href="/recipes"<?php _e('Recipes','foundationpress')?></a>
                </li>
            </ul>
        </section>
    </nav>
</div>
<div class="clearfix"></div>

