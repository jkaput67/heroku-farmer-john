<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_plugin extends d4p_plugin_core {
    public $svg_icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxOS4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9Ii0xNTYgMjQ3LjEgMjk4LjkgMjk4LjkiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgLTE1NiAyNDcuMSAyOTguOSAyOTguOTsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2ZpbGw6IzlDQTJBNzt9DQo8L3N0eWxlPg0KPHBhdGggaWQ9IlhNTElEXzE1XyIgY2xhc3M9InN0MCIgZD0iTS00OS40LDM4NGMtNy03LTE4LjMtNy0yNS40LDBsLTQwLDQwLjFjLTcsNy03LDE4LjQsMCwyNS40bDY3LjcsNzQuM2gxNC43bC00Mi4yLTQ2LjQNCgljLTUuNy01LjctNS43LTE1LDAtMjAuOGwzMi43LTMyLjhjNS43LTUuNywxNS01LjcsMjAuNywwbDExMS42LDk5LjloMTYuMkwtNDkuNCwzODR6IE0tNjguNyw0MzEuOGMtNC4yLDQuMi0xMSw0LjItMTUuMywwDQoJYy00LjItNC4yLTQuMi0xMS4xLDAtMTUuM2M0LjItNC4yLDExLTQuMiwxNS4zLDBDLTY0LjUsNDIwLjctNjQuNSw0MjcuNi02OC43LDQzMS44eiIvPg0KPHBhdGggaWQ9IlhNTElEXzEyXyIgY2xhc3M9InN0MCIgZD0iTTEwMi4xLDM2M2wtODEuNC05MS4xSDYuNUw2Mi45LDMzNWM1LjYsNS43LDUuNiwxNC44LDAsMjAuNWwtMzIuMywzMi4zDQoJYy01LjYsNS43LTE0LjgsNS43LTIwLjUsMGwtMTI3LjEtMTE2aC05LjdjLTEuNywwLTMuMywwLjUtNC43LDEuNGwxNjksMTU0LjJjNi45LDYuOSwxOC4xLDYuOSwyNSwwbDM5LjQtMzkuNQ0KCUMxMDksMzgxLjEsMTA5LDM2OS45LDEwMi4xLDM2M3ogTTcwLjEsMzk3LjFjLTQuMiw0LjItMTAuOSw0LjItMTUsMGMtNC4yLTQuMi00LjItMTAuOSwwLTE1LjFjNC4yLTQuMiwxMC45LTQuMiwxNSwwDQoJQzc0LjIsMzg2LjIsNzQuMiwzOTIuOSw3MC4xLDM5Ny4xeiIvPg0KPGcgaWQ9IlhNTElEXzFfIj4NCgk8Zz4NCgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTExNS40LDI2NS40aC0yNDQuM2MtNC44LDAtOC44LDMuOS04LjgsOC44djI0My40YzAsNC44LDUsMTAsOS45LDEwaDI0MS42YzQuOCwwLDEwLjQtNS4yLDEwLjQtMTAuMVYyNzQuMg0KCQkJQzEyNC4yLDI2OS40LDEyMC4zLDI2NS40LDExNS40LDI2NS40eiBNMTE2LjUsNTEwLjVjMCw0LjYtNS4yLDkuNS05LjgsOS41aC0yMjcuNGMtNC42LDAtOS4zLTQuOS05LjMtOS40VjI4MS40DQoJCQljMC00LjYsMy43LTguMyw4LjMtOC4zaDIzMGM0LjYsMCw4LjMsMy43LDguMyw4LjNWNTEwLjV6Ii8+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=';
    public $fontawesome = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
    public $fontawesome_version = '4.7';
    public $cron_job = 'gdcet_cron_daily_maintenance_job';

    public $cap = 'gd-content-tools-standard';
    public $plugin = 'gd-content-tools';

    public $addons = array();
    public $loaded = array();

    public $js_locale = array(
        'flatpickr' => array('da', 'de', 'es', 'fr', 'it', 'nl', 'pl', 'pt', 'ru', 'sr'),
        'select2' => array('da', 'de', 'es', 'fr', 'it', 'nl', 'pl', 'pt', 'ru', 'sr')
    );

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('plugins_loaded', array($this, 'plugins_loaded'), 0);
        add_action('after_setup_theme', array($this, 'after_setup_theme'));
        add_action('widgets_init', array($this, 'widgets_init'));

        $this->url = GDCET_URL;

        add_action('gdcet_plugin_init', array($this, 'core_plugin_init'), 100000);

        if (!defined('GDCET_SALT')) {
            define('GDCET_SALT', NONCE_SALT);
        }
    }

    public function plugins_loaded() {
        parent::plugins_loaded();

        define('GDCET_WPV', intval($this->wp_version));
        define('GDCET_WPV_MAJOR', substr($this->wp_version, 0, 3));

        add_action('gdcet_cron_daily_maintenance_job', array($this, 'maintenance_job'));

        do_action('gdcet_register_addons');

        foreach ($this->addons as $addon => $obj) {
            gdcet_settings()->register('load', $addon, $obj['autoload']);
        }

        do_action('gdcet_load_settings');

        $load = gdcet_settings()->group_get('load');

        foreach ($load as $key => $do) {
            if ($do) {
                $this->loaded[] = $key;

                do_action('gdcet_load_addon_'.$key);
            }
        }

        do_action('gdcet_populate_settings');

        do_action('gdcet_plugin_init');

        add_action('init', array($this, 'init'), 20);

        if (is_admin()) {
            add_action('admin_enqueue_scripts', array($this, 'wp'), 20);
        } else {
            add_action('wp', array($this, 'wp'), 20);
        }
    }

    public function load_textdomain() {
        load_plugin_textdomain($this->plugin, false, $this->plugin.'/languages');
        load_plugin_textdomain('d4plib', false, $this->plugin.'/d4plib/languages');
        load_plugin_textdomain('d4punits', false, $this->plugin.'/d4punits/languages');
    }

    public function locale() {
        return apply_filters('plugin_locale', get_user_locale(), $this->plugin);
    }

    public function locale_js_code($script) {
        $locale = $this->locale();

        if (!empty($locale) && isset($this->js_locale[$script])) {
            $code = strtolower(substr($locale, 0, 2));

            if (in_array($code, $this->js_locale[$script])) {
                return $code;
            }
        }

        return false;
    }

    public function maintenance_job() {
        @ini_set('memory_limit', '256M');
        @set_time_limit(0);

        do_action('gdcet_daily_maintenance_job_start');

        

        do_action('gdcet_daily_maintenance_job_end');
    }

    public function init() {
        do_action('gdcet_wp_init');

        if (isset($_GET['gdcet_handler']) && $_GET['gdcet_handler'] == 'action') {
            $action = isset($_GET['gdcet_action']) ? d4p_sanitize_key_expanded($_GET['gdcet_action']) : '';

            if ($action != '') {
                do_action('gdcet_getback_handler_action_'.$action);
            }
        }

        $this->scheduler();
    }

    public function scheduler() {
        if (!wp_next_scheduled($this->cron_job)) {
            $cron_hour = intval(gdcet_settings()->get('cronjob_hour_of_day'));
            $cron_time = mktime($cron_hour, 0, 0, date('m'), date('d') + 1, date('Y'));

            wp_schedule_event($cron_time, 'daily', $this->cron_job);
        }
    }

    public function wp() {
        do_action('gdcet_wp_ready');
    }

    public function core_plugin_init() {
        
    }

    public function widgets_init() {
        if (gdcet_settings()->get('widget_post_types_list')) {
            require_once(GDCET_PATH.'widgets/post-types-list.php');

            register_widget('d4pcetWidget_post_types_list');
        }

        if (gdcet_settings()->get('widget_terms_cloud')) {
            require_once(GDCET_PATH.'widgets/terms-cloud.php');

            register_widget('d4pcetWidget_terms_cloud');
        }

        if (gdcet_settings()->get('widget_terms_list')) {
            require_once(GDCET_PATH.'widgets/terms-list.php');

            register_widget('d4pcetWidget_terms_list');
        }
    }

    public function file($type, $name, $d4p = false, $min = true, $base_url = null) {
        $get = is_null($base_url) ? $this->url : $base_url;

        if ($d4p) {
            $get.= 'd4plib/resources/';
        }

        if ($name == 'font') {
            $get.= 'font/styles.css';
        } else {
            $get.= $type.'/'.$name;

            if (!$this->is_debug && $type != 'font' && $min) {
                $get.= '.min';
            }

            $get.= '.'.$type;
        }

        return $get;
    }

    public function enqueue_scripts() {
        do_action('gdcet_plugin_enqueue_scripts');
    }

    public function recommend($panel = 'update') {
        d4p_include('four', 'classes', GDCET_D4PLIB);

        $four = new d4p_core_four('plugin', 'gd-content-tools', gdcet_settings()->info_version, gdcet_settings()->info_build);
        $four->ad();

        return $four->ad_render($panel);
    }

    public function load_embed() {
        require_once(GDCET_PATH.'meta/objects/base.embed.php');
    }
}
