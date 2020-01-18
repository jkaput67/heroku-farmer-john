<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_sprites {
    public $icons = array('address-book-blue', 'address-book', 'alarm-clock', 'android', 'application-monitor', 'asterisk', 'auction-hammer', 'balance', 'bank', 'battery-charge', 'bauble', 'bean', 'bell', 'binocular', 'block', 'blog-blue', 'blog-posterous', 'blog', 'blogs', 'book-open-text-image', 'book', 'bookmark', 'books-brown', 'books', 'box', 'brain', 'briefcase', 'broom', 'bug', 'burn', 'calculator', 'calendar-blue', 'cards-bind-address', 'chain', 'chart-pie', 'chart', 'clapperboard', 'clipboard-task', 'database', 'disc-blue', 'envelope', 'film', 'flag-black', 'flag-blue', 'flag-green', 'flag-pink', 'flag-purple', 'flag-white', 'flag-yellow', 'flag', 'gear', 'globe', 'guitar', 'hammer-left', 'headphone', 'heart', 'home', 'hourglass', 'ice', 'image-select', 'images-flickr', 'jar', 'key', 'keyboard', 'leaf', 'lifebuoy', 'luggage', 'mail-open-table', 'mail-open', 'map', 'marker', 'music-beam-16', 'newspaper', 'palette', 'paper-clip', 'pencil', 'photo-album-blue', 'photo-album', 'piano', 'piggy-bank', 'pill', 'pin', 'pipette', 'playing-card', 'plug-disconnect', 'plug', 'present', 'price-tag-label', 'puzzle', 'spray', 'stamp', 'star', 'store', 'target', 'umbrella', 'users', 'wand', 'weather-cloudy', 'wooden-box', 'wrench');
    public $insert = array();

    public $url_types = '';

    public function __construct() {
        $this->url_types = GDCET_URL.'gfx/sprites/icons.png';

        if (is_admin()) {
            add_action('admin_head', array($this, 'admin_head'));
        }
    }

    public function add($icon, $post_type) {
        $this->insert[$post_type] = $icon;
    }

    public function admin_head() {
        if (!empty($this->insert)) {
            echo '<style type="text/css">';

            foreach ($this->insert as $post_type => $icon) {
                echo $this->css($icon, $post_type);
            }

            echo '</style>'.D4P_EOL;
        }
    }

    private function css($icon, $post_type) {
        $css = D4P_EOL.'/* '.$post_type.': '.$icon.' */'.D4P_EOL;

        $id = array_search($icon, $this->icons);
        $location = -$id * 30 + 3;

        $css.= '#gdcet-menu-icon-'.$post_type.'.gdcet-icon-sprite,'.D4P_EOL;
        $css.= '#menu-posts-'.$post_type.' .wp-menu-image,'.D4P_EOL;
        $css.= '#menu-posts-'.$post_type.':hover .wp-menu-image,'.D4P_EOL;
        $css.= '#menu-posts-'.$post_type.'.wp-has-current-submenu .wp-menu-image { ';
        $css.= 'background: url('.$this->url_types.') !important; background-repeat: no-repeat !important; background-color: transparent !important; }'.D4P_EOL;
        $css.= '#gdcet-menu-icon-'.$post_type.'.gdcet-icon-sprite {';
        $css.= 'background-position: '.($location - 9).'px -7px !important; }'.D4P_EOL.D4P_EOL;
        $css.= '#menu-posts-'.$post_type.' .wp-menu-image { ';
        $css.= 'background-position: '.$location.'px -33px !important; }'.D4P_EOL.D4P_EOL;

        $css.= '#menu-posts-'.$post_type.':hover .wp-menu-image,'.D4P_EOL;
        $css.= '#menu-posts-'.$post_type.'.wp-has-current-submenu .wp-menu-image { ';
        $css.= 'background-position: '.$location.'px -1px !important; }'.D4P_EOL;

        $css.= '#menu-posts-'.$post_type.' .wp-menu-image:before { display: none; }'.D4P_EOL;
        $css.= '#menu-posts-'.$post_type.' .wp-menu-image { height: 28px !important; margin-top: 3px !important; }'.D4P_EOL;

        return $css;
    }
}
