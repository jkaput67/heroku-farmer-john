<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_boolean extends gdcet_meta_core_field {
    public $icon = 'check';
    public $required = false;
    public $repeater = false;

    public static function get_defaults() {
        return array(
            'label' => __("Enabled", "gd-content-tools")
        );
    }

    public function get_default_value() {
        return null;
    }

    protected function init() {
        $this->name = 'boolean';
        $this->label = __("Boolean", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['label'] = d4p_sanitize_basic($this->settings['label']);

        return $errors;
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            $this->process[] = false;
        } else {
            foreach ($input as $value) {
                $this->process[] = $value == 'on';
            }
        }
    }
}

class gdcet_core_basefield_boolean extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '',
            'true' => __("True", "gd-content-tools"), 
            'false' => __("False", "gd-content-tools"),
            'default' => false);

        $args = wp_parse_args($args, $defaults);

        $_value = is_null($this->value) ? $args['default'] : $this->value;

        $render = $_value ? $args['true'] : $args['false'];

        return $args['before'].$render.$args['after'];
    }

    public function is($is = true, $default = false) {
        $_value = is_null($this->value) ? $default : $this->value;

        return (bool)$is === (bool)$_value;
    }
}
