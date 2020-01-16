<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_select extends gdcet_meta_select_field {
    public $icon = 'list-ul';
    public $mode = 'single';

    public static function get_defaults() {
        return array(
            'default' => array(),
            'mode' => 'normal',
            'display' => 'html',
            'source' => 'list',
            'list' => array(),
            'function' => '',
            'remote' => '',
            'hide_empty' => false
        );
    }

    protected function init() {
        $this->name = 'select';
        $this->label = __("Select", "gd-content-tools");
        $this->category = 'selection';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['hide_empty'] = $this->settings['hide_empty'] == 'on';

        return $errors;
    }
}

class gdcet_core_basefield_select extends gdcet_core_basefield_selection {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $_value = is_null($this->value) ? $args['default'] : $this->value;

        $render = $_value;

        if ($this->mode == 'associative' && isset($this->list[$_value])) {
            $render = $this->list[$_value];
        }

        return $args['before'].$render.$args['after'];
    }
}
