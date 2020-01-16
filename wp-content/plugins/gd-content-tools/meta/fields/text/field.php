<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_text extends gdcet_meta_core_field {
    public $icon = 'file-text';

    public static function get_defaults() {
        return array(
            'limit' => 0,
            'restriction' => '__none__',
            'regex' => '',
            'mask' => '',
            'default' => '',
            'placeholder' => ''
        );
    }

    protected function init() {
        $this->name = 'text';
        $this->label = __("Text", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['limit'] = absint($this->settings['limit']);

        $this->settings['restriction'] = d4p_sanitize_basic($this->settings['restriction']);
        $this->settings['default'] = d4p_sanitize_basic($this->settings['default']);
        $this->settings['placeholder'] = d4p_sanitize_basic($this->settings['placeholder']);
        $this->settings['regex'] = d4p_sanitize_basic($this->settings['regex']);
        $this->settings['mask'] = d4p_sanitize_basic($this->settings['mask']);

        return $errors;
    }

    public function get_restriction_methods() {
        return array(
            array('title' => __("General", "gd-content-tools"), 'values' => array(
                '__none__' => __("No restrictions", "gd-content-tools"),
                '__regex__' => __("Custom Regular Expression", "gd-content-tools"),
                '__mask__' => __("Custom Mask", "gd-content-tools")
            )),
            array('title' => __("Predefined Masks", "gd-content-tools"), 'values' => apply_filters('gdcet_meta_text_restriction_methods_mask', array())),
            array('title' => __("Predefined Regular Expressions", "gd-content-tools"), 'values' => apply_filters('gdcet_meta_text_restriction_methods_regex', array()))
        );
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $this->process[] = d4p_sanitize_basic($item);
            }
        }
    }
}

class gdcet_core_basefield_text extends gdcet_core_basefield_simple { }
