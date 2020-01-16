<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_bbpress_init extends gdcet_addon_init {
    public $prefix = 'bbpress';

    public function __construct() {
        parent::__construct();

        add_action('gdcet_load_addon_bbpress', array($this, 'load'), 2);
        add_filter('gdcet_info_addon_bbpress', array($this, 'info'));
    }

    public function register() {
        gdcet_register_addon('bbpress', __("bbPress", "gd-content-tools"), false);
    }

    public function settings() {
        if (!gdcet_has_bbpress()) {
            return;
        }

        $this->register_option('boxes', array());
        $this->register_option('boxid', 1);

        $this->register_option('embed', true);
    }

    public function info($info = array()) {
        return array('icon' => 'd4p-logo-bbpress', 'description' => __("Integrate meta boxes into topics and replies.", "gd-content-tools"));
    }

    public function load() {
        if (!gdcet_has_bbpress()) {
            return;
        }

        require_once(GDCET_PATH.'addons/bbpress/load.php');
    }
}

$__gdcet_addon_bbpress = new gdcet_addon_bbpress_init();
