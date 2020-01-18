<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_multi_select extends gdcet_meta_select_field {
    public $icon = 'check-square';
    public $mode = 'multi';

    public static function get_defaults() {
        return array(
            'default' => '',
            'mode' => 'normal',
            'display' => 'html',
            'source' => 'list',
            'limit' => 0,
            'list' => array(),
            'function' => '',
            'remote' => ''
        );
    }

    protected function init() {
        $this->name = 'multi-select';
        $this->label = __("Multi Select", "gd-content-tools");
        $this->category = 'selection';
    }
}

class gdcet_core_basefield_multi_select extends gdcet_core_basefield_list { }
