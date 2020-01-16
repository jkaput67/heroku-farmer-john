<?php

if (!defined('ABSPATH')) exit;

abstract class gdcet_data_class {
    public function __construct($args = array()) {
        if (is_array($args) && !empty($args)) {
            $this->from_array($args);
        }
    }

    public function into_array() {
        return (array)$this;
    }

    public function from_array($args) {
        foreach ($args as $key => $value) {
            $this->$key = $value;
        }
    }

    public function get($what = 'settings') {
        if ($what == 'settings') {
            return $this->into_array();
        } else if ($what == 'object') {
            return $this;
        }
    }

    function __clone() {
        foreach ($this as $key => $val) {
            if (is_object($val) || (is_array($val))){
                $this->{$key} = unserialize(serialize($val));
            }
        }
    }
}

abstract class gdcet_addon_init {
    public $prefix = '';

    public function __construct() {
        add_action('gdcet_settings_init', array($this, 'settings'));
        add_action('gdcet_register_addons', array($this, 'register'));
        add_action('gdcet_admin_ajax', array($this, 'ajax'));
    }

    public function key($name, $prekey = '') {
        $prekey = empty($prekey) ? $this->prefix : $prekey;

        return $prekey.'_'.$name;
    }

    public function register_option($name, $value) {
        gdcet_settings()->register('addons', $this->key($name), $value);
    }

    abstract public function settings();
    abstract public function register();

    abstract public function load();

    public function ajax() {}
}

abstract class gdcet_addon_load {
    public $prefix = '';

    public $_settings = array();

    public function __construct() {
        add_action('gdcet_admin_load_addons', array($this, '_load_admin'));
        add_action('gdcet_populate_settings', array($this, '_load_settings'));

        add_action('gdcet_plugin_init', array($this, 'plugin_init'));
        add_action('gdcet_wp_init', array($this, 'wp_init'));
        add_action('gdcet_wp_ready', array($this, 'wp_ready'));
        add_action('gdcet_plugin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function plugin_init() { }

    public function wp_init() { }

    public function wp_ready() { }

    public function enqueue_scripts() { }

    public function get($name, $prefix = '', $prekey = '') {
        if ($prefix != '' && $prekey != '') {
            $override = gdcet_settings()->get($prekey.'_'.$name, $prefix);

            if (!is_null($override)) {
                return $override;
            }
        }

        return $this->_settings[$name];
    }

    public function key($name, $prekey = '') {
        $prekey = empty($prekey) ? $this->prefix : $prekey;

        return $prekey.'_'.$name;
    }

    public function file($type, $name, $min = true) {
        $path = $type.'/'.$name;

        if (!gdcet()->is_debug && $min) {
            $path.= '.min';
        }

        $path.= '.'.$type;

        return $this->_url($path);
    }

    public function addon_name() {
        return $this->prefix;
    }

    protected function _path($path = '') {
        $base = GDCET_PATH.'addons/'.$this->addon_name().'/';

        if ($path != '') {
            $base.= $path;
        }

        return $path;
    }

    protected function _url($path = '') {
        $base = GDCET_URL.'addons/'.$this->addon_name().'/';

        if ($path != '') {
            $base.= $path;
        }

        return $base;
    }

    public function _load_settings() {
        $this->_settings = gdcet_settings()->prefix_get($this->prefix.'_', 'addons');
    }

    public function _save_settings() {
        foreach ($this->_settings as $name => $value) {
            gdcet_settings()->set($this->key($name), $value, 'addons');
        }

        gdcet_settings()->save('addons');
    }

    abstract public function _load_admin();
}

abstract class gdcet_addon_admin {
    public function __construct() {
        add_filter('gdcet_admin_menu_items', array($this, 'menu_items'));
        add_action('gdcet_admin_init', array($this, 'admin_init'));
    }

    public function menu_items($items) {
        return $items;
    }

    public function admin_init() { }
}
