<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_admin_wp_toolbar extends gdcet_addon_admin {
    public $prefix = 'wp-toolbar';

    public function __construct() {
        parent::__construct();

        add_filter('gdcet_admin_settings_panels', array($this, 'panels'));
        add_filter('gdcet_admin_internal_settings', array($this, 'settings'));
        add_filter('gdcet_admin_icon_wp-toolbar', array($this, 'icon'));
    }

    public function icon($icon) {
        return 'bars';
    }

    public function panels($panels) {
        $panels['addon_wp-toolbar'] = array(
            'title' => __("WP Toolbar", "gd-content-tools"), 'icon' => 'bars', 'type' => 'addon', 
            'info' => __("Settings on this panel are for control over toolbar menu integration.", "gd-content-tools"));

        return $panels;
    }

    public function settings($settings) {
        $settings['addon_wp-toolbar'] = array(
            'addt_visibility' => array('name' => __("Accessibility", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('addons', gdcet_wp_toolbar()->key('for_super_admin'), __("Super Admin", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_wp_toolbar()->get('for_super_admin')),
                new d4pSettingElement('addons', gdcet_wp_toolbar()->key('for_administrator'), __("Administrators", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_wp_toolbar()->get('for_administrator'))
            ))
        );

        return $settings;
    }
}

global $_gdcet_addon_admin_wp_toolbar;
$_gdcet_addon_admin_wp_toolbar = new gdcet_addon_admin_wp_toolbar();

function gdcet_admin_wp_toolbar() {
    global $_gdcet_addon_admin_wp_toolbar;
    return $_gdcet_addon_admin_wp_toolbar;
}
