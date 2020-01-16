<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_info extends gdcet_meta_core_field {
    public $icon = 'info-circle';
    public $repeater = false;
    public $required = false;

    public static function get_defaults() {
        return array(
            'information' => ''
        );
    }

    protected function init() {
        $this->name = 'info';
        $this->label = __("Information", "gd-content-tools");
        $this->category = 'special';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['information'] = d4p_sanitize_html($this->settings['information'], d4p_kses_expanded_list_of_tags());

        return $errors;
    }
}

class gdcet_core_basefield_info extends gdcet_core_basefield {
    public function render($args = array()) {
        return '';
    }
}
