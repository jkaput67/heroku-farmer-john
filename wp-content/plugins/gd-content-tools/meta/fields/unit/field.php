<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_unit extends gdcet_meta_core_field {
    public $icon = 'lightbulb-o';

    public static function get_defaults() {
        return array(
            'type' => 'length'
        );
    }

    protected function init() {
        $this->name = 'unit';
        $this->label = __("Unit", "gd-content-tools");
        $this->category = 'unit';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        return $errors;
    }

    public function get_unit_types() {
        gdcet_load_units();

        $units = d4p_units();
        
        return $units->get_no_currency_types();
    }

    public function get_default_value() {
        return array(
            'value' => 0,
            'unit' => ''
        );
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                if (isset($item['value']) && isset($item['unit'])) {
                    $this->process[] = array('value' => floatval($item['value']), 'unit' => d4p_sanitize_basic($item['unit']));
                }
            }
        }
    }
}

class gdcet_core_basefield_unit extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        require_once(GDCET_PATH.'meta/objects/core.units.php');

        $render = gdcet_unit_format($this->settings['type'], $this->value['value'], $this->value['unit'], $args);

        return $args['before'].$render.$args['after'];
    }
}
