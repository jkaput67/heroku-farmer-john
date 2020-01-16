<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_time extends gdcet_meta_datetime_field {
    public $icon = 'clock-o';
    public $format = 'H:i:s';

    public static function get_defaults() {
        return array(
            'custom' => true,
            'default' => '',
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
        $this->name = 'time';
        $this->label = __("Time", "gd-content-tools");
        $this->category = 'datetime';
    }

    public function process($input) {
        $this->process = array();

        foreach ($input as $item) {
            if (!empty($item)) {
                $this->process[] = d4p_sanitize_basic($item);
            }
        }
    }

    public function get_edit_value($index) {
        if (isset($this->values[$index])) {
            return $this->values[$index];
        } else {
            return $this->get_default_value();
        }
    }
}

class gdcet_core_basefield_time extends gdcet_core_basefield_dates {
    protected $default_format = 'H:i:s';
}
