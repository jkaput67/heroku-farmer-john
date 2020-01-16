<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_year extends gdcet_meta_datetime_field {
    public $icon = 'calendar-minus-o';
    public $format = 'Y';

    public static function get_defaults() {
        return array(
            'custom' => true,
            'default' => '',
            'store' => ''
        );
    }

    protected function init() {
        $this->name = 'year';
        $this->label = __("Year", "gd-content-tools");
        $this->category = 'datetime';
    }

    public function process($input) {
        $this->process = array();

        foreach ($input as $item) {
            if (!empty($item)) {
                $this->process[] = intval(d4p_sanitize_basic($item));
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

class gdcet_core_basefield_year extends gdcet_core_basefield_simple { }
