<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_bbpress extends gdcet_addon_load {
    public $prefix = 'bbpress';

    public function __construct() {
        parent::__construct();

        add_action('bbp_enqueue_scripts', array($this, 'bbpress_enqueue_scripts'));
    }

    public function _load_admin() {
        require_once(GDCET_PATH.'addons/bbpress/admin.php');
        require_once(GDCET_PATH.'addons/bbpress/code/functions.php');
    }

    public function plugin_init() {
        require_once(GDCET_PATH.'addons/bbpress/code/bbpress.php');
    }

    public function get_rule($id = 0) {
        if (isset($this->_settings['boxes'][$id])) {
            return $this->_settings['boxes'][$id];
        }

        return array(
            'id' => 0,
            'label' => __("New metabox rule", "gd-content-tools"),
            'wrapper' => 'default',
            'style' => 'default',
            'metabox' => '',
            'location' => '',
            'priority' => 10,
            'roles' => null,
            'scope' => 'all',
            'forums' => array(),
            'type' => 'topic'
        );
    }

    public function delete_rule($rule) {
        if (isset($this->_settings['boxes'][$rule])) {
            unset($this->_settings['boxes'][$rule]);

            $this->_save_settings();
        }
    }

    public function save_rule($rule) {
        $id = $rule['id'];

        if ($id == 0) {
            $id = $this->_settings['boxid'];
            $rule['id'] = $id;

            $this->_settings['boxid']++;
        }

        $this->_settings['boxes'][$id] = $rule;

        $this->_save_settings();
    }

    public function bbpress_enqueue_scripts() {
        wp_enqueue_style('gdcet-meta-bbpress', gdcet()->file('css', 'meta-bbpress', false, true, GDCET_URL.'addons/bbpress/'), array('gdcet-meta'), gdcet_settings()->file_version());
    }
}

global $_gdcet_addon_bbpress;
$_gdcet_addon_bbpress = new gdcet_addon_bbpress();

function gdcet_bbpress() {
    global $_gdcet_addon_bbpress;
    return $_gdcet_addon_bbpress;
}
