<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_radios extends gdcet_meta_radio_field {
    public $icon = 'dot-circle-o';
    public $mode = 'single';

    public static function get_defaults() {
        return array(
            'default' => '',
            'mode' => 'normal',
            'source' => 'list',
            'list' => array(),
            'function' => ''
        );
    }

    protected function init() {
        $this->name = 'radios';
        $this->label = __("Radios", "gd-content-tools");
        $this->category = 'selection';
    }
}

class gdcet_core_basefield_radios extends gdcet_core_basefield_selection {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '');

        $args = wp_parse_args($args, $defaults);

        $render = $this->value;

        if ($this->mode == 'associative') {
            $render = $this->list[$this->value];
        }

        return $args['before'].$render.$args['after'];
    }
}
