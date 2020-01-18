<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_number extends gdcet_meta_core_field {
    public $icon = 'sort-numeric-asc';

    public static function get_defaults() {
        return array(
            'allow_decimal' => false,
            'has_min' => false,
            'min' => 0,
            'has_max' => false,
            'max' => 0,
            'has_step' => false,
            'step' => 0,
            'default' => '0',
            'placeholder' => ''
        );
    }

    protected function init() {
        $this->name = 'number';
        $this->label = __("Number", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['min'] = floatval($this->settings['min']);
        $this->settings['max'] = floatval($this->settings['max']);
        $this->settings['step'] = floatval($this->settings['step']);

        $this->settings['default'] = floatval($this->settings['default']);
        $this->settings['placeholder'] = d4p_sanitize_basic($this->settings['placeholder']);

        $this->settings['has_min'] = $this->settings['has_min'] == 'on';
        $this->settings['has_max'] = $this->settings['has_max'] == 'on';
        $this->settings['has_step'] = $this->settings['has_step'] == 'on';

        $this->settings['allow_decimal'] = $this->settings['allow_decimal'] == 'on';

        return $errors;
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $this->process[] = floatval($item);
            }
        }
    }
}

class gdcet_core_basefield_number extends gdcet_core_basefield_simple { }
