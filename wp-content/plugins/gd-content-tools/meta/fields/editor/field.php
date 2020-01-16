<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_editor extends gdcet_meta_core_field {
    public $icon = 'pencil-square-o';
    public $repeater = false;
    public $repeater_custom = false;

    public function __construct($args = null) {
        if (GDCET_WPV > 47) {
            $this->repeater = true;
            $this->repeater_custom = true;
        }

        parent::__construct($args);
    }

    protected function form_include($id_base, $name_base, $index = 0, $ajax = false) {
        if ($ajax) {
            include(GDCET_PATH.'meta/fields/'.$this->name.'/input_ajax.php');
        } else {
            parent::form_include($id_base, $name_base, $index, $ajax);
        }
    }

    public static function get_defaults() {
        return array(
            'default' => '',
            'editor_class' => '',
            'editor_height' => 0,
            'textarea_rows' => 10,
            'teeny' => false,
            'wpautop' => true,
            'media_buttons' => true
        );
    }

    protected function init() {
        $this->name = 'editor';
        $this->label = __("Editor", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['default'] = d4p_sanitize_basic($this->settings['default']);
        $this->settings['editor_class'] = d4p_sanitize_html_classes($this->settings['editor_class']);
        $this->settings['editor_height'] = intval($this->settings['editor_height']);
        $this->settings['textarea_rows'] = intval($this->settings['textarea_rows']);

        $this->settings['teeny'] = $this->settings['teeny'] === 'on';
        $this->settings['wpautop'] = $this->settings['wpautop'] === 'on';
        $this->settings['media_buttons'] = $this->settings['media_buttons'] === 'on';

        return $errors;
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $this->process[] = d4p_sanitize_extended($item);
            }
        }
    }
}

class gdcet_core_basefield_editor extends gdcet_core_basefield_content { }
