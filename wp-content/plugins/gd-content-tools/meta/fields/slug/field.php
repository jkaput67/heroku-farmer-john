<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_slug extends gdcet_meta_core_field {
    public $icon = 'external-link-square';

    public static function get_defaults() {
        return array(
            'limit' => 0,
            'default' => '',
            'placeholder' => ''
        );
    }

    protected function init() {
        $this->name = 'slug';
        $this->label = __("Slug", "gd-content-tools");
        $this->category = 'advanced';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['limit'] = absint($this->settings['limit']);

        $this->settings['default'] = d4p_sanitize_slug($this->settings['default']);
        $this->settings['placeholder'] = d4p_sanitize_basic($this->settings['placeholder']);

        return $errors;
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $this->process[] = d4p_sanitize_slug($item);
            }
        }
    }
}

class gdcet_core_basefield_slug extends gdcet_core_basefield_simple { }
