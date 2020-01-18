<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_wp_toolbar extends gdcet_addon_load {
    public $prefix = 'wp-toolbar';

    public $menu = null;

    public function _load_admin() {
        require_once(GDCET_PATH.'addons/wp-toolbar/admin.php');
    }

    public function wp_init() {
        $show = (is_super_admin() && $this->get('for_super_admin')) || 
                (d4p_is_current_user_admin() && $this->get('for_administrator'));

        if (apply_filters('gdcet_wp_toolbar_show', $show)) {
            add_action('wp_head', array($this, 'wp_color_scheme_settings'));

            require_once(GDCET_PATH.'addons/wp-toolbar/menu.php');

            $this->menu = new gdcet_wp_toolbar_menu();
        }
    }

    public function enqueue_scripts() {
        if (!is_null($this->menu)) {
            wp_enqueue_script('svg-painter', '/wp-admin/js/svg-painter.js', array('jquery'), 1, true);
        }
    }

    function wp_color_scheme_settings() {
	$icon_colors = array('base' => '#999', 'focus' => '#00a0d2', 'current' => '#fff');

	echo '<script type="text/javascript">var _wpColorScheme = '.wp_json_encode(array('icons' => $icon_colors)).";</script>\n";
    }
}

global $_gdcet_addon_wp_toolbar;
$_gdcet_addon_wp_toolbar = new gdcet_addon_wp_toolbar();

function gdcet_wp_toolbar() {
    global $_gdcet_addon_wp_toolbar;
    return $_gdcet_addon_wp_toolbar;
}
