<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_date extends gdcet_meta_datetime_field {
    public $icon = 'calendar-o';
    public $format = 'Y-m-d';
    public $stores = array(
        'colon' => 'Y:m:d',
        'dotted' => 'Y.m.d',
        'dashed' => 'Y-m-d'
    );

    public static function get_defaults() {
        return array(
            'custom' => true,
            'default' => '',
            'store' => 'mysql'
        );
    }

    protected function init() {
        $this->name = 'date';
        $this->label = __("Date", "gd-content-tools");
        $this->category = 'datetime';
    }
}

class gdcet_core_basefield_date extends gdcet_core_basefield_dates {
    protected $default_format = 'Y-m-d';
}
