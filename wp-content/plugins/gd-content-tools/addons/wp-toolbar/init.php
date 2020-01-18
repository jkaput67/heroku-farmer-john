<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_wp_toolbar_init extends gdcet_addon_init {
    public $prefix = 'wp-toolbar';

    public function __construct() {
        parent::__construct();

        add_action('gdcet_load_addon_wp-toolbar', array($this, 'load'), 2);
        add_filter('gdcet_info_addon_wp-toolbar', array($this, 'info'));
    }

    public function register() {
        gdcet_register_addon('wp-toolbar', __("WP Toolbar", "gd-content-tools"));
    }

    public function settings() {
        $this->register_option('for_super_admin', true);
        $this->register_option('for_administrator', true);
    }

    public function info($info = array()) {
        return array('icon' => 'bars', 'description' => __("Plugin related menu for WordPress toolbar.", "gd-content-tools"));
    }

    public function load() {
        require_once(GDCET_PATH.'addons/wp-toolbar/load.php');
    }
}

$__gdcet_addon_wp_toolbar = new gdcet_addon_wp_toolbar_init();
