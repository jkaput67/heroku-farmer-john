<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_checkboxes extends gdcet_meta_radio_field {
    public $icon = 'check-square';
    public $mode = 'multi';

    public static function get_defaults() {
        return array(
            'default' => array(),
            'mode' => 'normal',
            'source' => 'list',
            'limit' => 0,
            'list' => array(),
            'function' => ''
        );
    }

    protected function init() {
        $this->name = 'checkboxes';
        $this->label = __("Checkboxes", "gd-content-tools");
        $this->category = 'selection';
    }
}

class gdcet_core_basefield_checkboxes extends gdcet_core_basefield_list { }
