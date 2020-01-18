<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_admin_bbpress extends gdcet_addon_admin {
    public $prefix = 'bbpress';

    public function __construct() {
        parent::__construct();

        add_filter('gdcet_admin_settings_panels', array($this, 'panels'));
        add_filter('gdcet_admin_internal_settings', array($this, 'settings'));

        add_filter('gdcet_admin_icon_bbpress', array($this, 'icon'));
        add_filter('gdcet_admin_menu_items_post_meta', array($this, 'menu_items'));
        add_filter('gdcet_admin_panel_meta-bbpress', array($this, 'menu_item_path'));

        add_action('gdcet_admin_enqueue_scripts_plugin', array($this, 'admin_enqueue_scripts'));

        add_action('gdcet_admin_getback_handler', array($this, 'getback'));
        add_action('gdcet_admin_postback_handler', array($this, 'postback'));
    }

    public function getback($page) {
        if ($page === 'meta-bbpress') {
            if (isset($_GET['single-action']) && $_GET['single-action'] == 'delete') {
                check_ajax_referer('gdcet-admin-panel');

                $rule = isset($_GET['rule']) ? absint($_GET['rule']) : 0;

                gdcet_bbpress()->delete_rule($rule);

                wp_redirect(gdcet_admin()->current_url());
                exit;
            }
        }
    }

    public function postback($page) {
        if ($page == 'gd-content-tools-bbpress') {
            if (isset($_POST['gdcetbbpmeta']) && isset($_POST['gdcetbbpmeta']['rule']) && $_POST['gdcetbbpmeta']['panel'] == 'bbpress-rule') {
                $input = $_POST['gdcetbbpmeta']['rule'];

                if (!isset($input['roles'])) {
                    $input['roles'] = array();
                }

                if (!isset($input['forums'])) {
                    $input['forums'] = array();
                }

                $rule = array(
                    'id' => intval($input['id']),
                    'label' => d4p_sanitize_basic($input['label']),
                    'wrapper' => d4p_sanitize_basic($input['wrapper']),
                    'style' => d4p_sanitize_basic($input['style']),
                    'metabox' => d4p_sanitize_basic($input['metabox']),
                    'location' => d4p_sanitize_basic($input['location']),
                    'priority' => intval($input['priority']),
                    'roles' => d4p_sanitize_basic_array($input['roles']),
                    'scope' => d4p_sanitize_basic($input['scope']),
                    'forums' => d4p_sanitize_basic_array($input['forums']),
                    'type' => d4p_sanitize_basic($input['type']));

                gdcet_bbpress()->save_rule($rule);

                wp_redirect(gdcet_admin()->current_url());
                exit;
            }
        }
    }

    public function icon($icon) {
        return 'd4p-bbpress';
    }

    public function admin_enqueue_scripts($page) {
        if ($page == 'meta-bbpress') {
            $base_url = GDCET_URL.'addons/bbpress/';

            wp_enqueue_style('gdcet-bbpress', gdcet_admin()->file('css', 'admin-bbpress', false, true, $base_url), array('gdcet-admin'), gdcet_settings()->file_version());
            wp_enqueue_script('gdcet-bbpress', gdcet_admin()->file('js', 'admin-bbpress', false, true, $base_url), array('gdcet-admin'), gdcet_settings()->file_version(), true);
        }
    }

    public function menu_items($menu_items) {
        $menu_items['meta-bbpress'] = array('title' => __("Meta bbPress", "gd-content-tools"), 'icon' => 'd4p-logo-bbpress');

        return $menu_items;
    }

    public function menu_item_path($path) {
        if (isset($_GET['rule'])) {
            return GDCET_PATH.'addons/bbpress/forms/rule.php';
        } else {
            add_action('gdcet_admin_panel_bottom', array($this, 'load_dialogs'));

            return GDCET_PATH.'addons/bbpress/forms/rules.php';
        }
    }

    public function load_dialogs() {
        include(GDCET_PATH.'addons/bbpress/forms/dialogs.php');
    }

    public function panels($panels) {
        $panels['addon_bbpress'] = array(
            'title' => __("bbPress", "gd-content-tools"), 'icon' => 'd4p-logo-bbpress', 'type' => 'addon', 
            'info' => __("Settings on this panel are for control over the bbPress integration.", "gd-content-tools"));

        return $panels;
    }

    public function settings($settings) {
        $settings['addon_bbpress'] = array(
            'addon_bbpress_embed' => array('name' => __("Metadata auto embed", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('addons', gdcet_bbpress()->key('embed'), __("Auto embed", "gd-content-tools"), __("Plugin will use simple integration template to display data from metaboxes attached to the topics or replies. This is the basic template that displays all available values without any context. If you need to have specific layout, location, and additional settings to display the data, you need to create your own template for displaying values from meta box.", "gd-content-tools"), d4pSettingType::BOOLEAN, gdcet_bbpress()->get('embed'))
            ))
        );

        return $settings;
    }
}

global $_gdcet_addon_admin_bbpress;
$_gdcet_addon_admin_bbpress = new gdcet_addon_admin_bbpress();

function gdcet_admin_bbpress() {
    global $_gdcet_addon_admin_bbpress;
    return $_gdcet_addon_admin_bbpress;
}
