<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_resolution extends gdcet_meta_core_field {
    public $icon = 'desktop';

    public static function get_defaults() {
        return array(
            'x' => 0,
            'y' => 0
        );
    }

    protected function init() {
        $this->name = 'resolution';
        $this->label = __("Resolution", "gd-content-tools");
        $this->category = 'units';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['x'] = absint($this->settings['x']);
        $this->settings['y'] = absint($this->settings['y']);

        return $errors;
    }

    public function get_default_value() {
        return array('x' => $this->settings['x'], 'y' => $this->settings['y']);
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            $this->process[] = array(
                'x' => absint($item['x']),
                'y' => absint($item['y'])
            );
        }
    }
}

class gdcet_core_basefield_resolution extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 
            'sep' => 'x', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $render = $this->value['x'].$args['sep'].$this->value['y'];

        return $args['before'].$render.$args['after'];
    }
}
