<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_color extends gdcet_meta_core_field {
    public $icon = 'paint-brush';

    public static function get_defaults() {
        return array(
            'default' => '#FF0000'
        );
    }

    protected function init() {
        $this->name = 'color';
        $this->label = __("Color", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['default'] = d4p_sanitize_basic($this->settings['default']);

        if (!empty($this->settings['default']) && !$this->validate_color($this->settings['default'])) {
            $errors->add('settings-default', __("Color is not proper HEX format", "gd-content-tools"));
        }

        return $errors;
    }

    public function validate_color($color) {
        return preg_match('/^#[a-f0-9]{6}$/i', $color) || preg_match('/^#[a-f0-9]{3}$/i', $color);
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $color = d4p_sanitize_basic($item);

                if ($this->validate_color($color)) {
                    $this->process[] = $color;
                } else {
                    $this->process[] = $this->s('default');
                }
            }
        }
    }
}

class gdcet_core_basefield_color extends gdcet_core_basefield_simple { }
