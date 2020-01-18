<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_datetime extends gdcet_meta_datetime_field {
    public $icon = 'calendar';
    public $format = 'Y-m-d H:i:s';

    public static function get_defaults() {
        return array(
            'custom' => true,
            'default' => '',
            'store' => 'mysql',
            'time_seconds' => true,
            'time_mode' => '12hr'
        );
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['time_seconds'] = isset($this->settings['time_seconds']) && $this->settings['time_seconds'] === 'on';
        $this->settings['time_mode'] = $this->settings['time_mode'] == '12h' ? '12h' : '24h';

        return $errors;
    }
    
    protected function init() {
        $this->name = 'datetime';
        $this->label = __("Date Time", "gd-content-tools");
        $this->category = 'datetime';
    }
}

class gdcet_core_basefield_datetime extends gdcet_core_basefield_dates {
    protected $default_format = 'Y-m-d H:i:s';
}
