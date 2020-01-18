<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_dimensions extends gdcet_meta_core_field {
    public $icon = 'arrows';

    public static function get_defaults() {
        return array(
            'x' => array('value' => 0, 'unit' => 'm'),
            'y' => array('value' => 0, 'unit' => 'm'),
            'z' => array('value' => 0, 'unit' => 'm'),
            'type' => '3d'
        );
    }

    protected function init() {
        $this->name = 'dimensions';
        $this->label = __("Dimensions", "gd-content-tools");
        $this->category = 'units';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['type'] = d4p_sanitize_basic($this->settings['type']);

        $this->settings['x'] = array('value' => absint($this->settings['x']['value']), 'unit' => d4p_sanitize_basic($this->settings['x']['unit']));
        $this->settings['y'] = array('value' => absint($this->settings['y']['value']), 'unit' => d4p_sanitize_basic($this->settings['y']['unit']));
        $this->settings['z'] = array('value' => absint($this->settings['z']['value']), 'unit' => d4p_sanitize_basic($this->settings['z']['unit']));

        return $errors;
    }

    public function get_default_value() {
        return array(
            'x' => $this->s('x'),
            'y' => $this->s('y'),
            'z' => $this->s('z')
        );
    }

    public function get_type() {
        return array(
            '2d' => '2D',
            '3d' => '3D'
        );
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $clean = array();

                foreach (array('x', 'y', 'z') as $axis) {
                    if (isset($item[$axis]) && isset($item[$axis]['value']) && isset($item[$axis]['unit'])) {
                        $clean[$axis] = array(
                            'value' => floatval($item[$axis]['value']),
                            'unit' => d4p_sanitize_basic($item[$axis]['unit'])
                        );
                    }
                }

                $this->process[] = $clean;
            }
        }
    }
}

class gdcet_core_basefield_dimensions extends gdcet_core_basefield {
    public function render($args = array()) {
        require_once(GDCET_PATH.'meta/objects/core.units.php');

        $defaults = array('before' => '', 'after' => '', 'return' => 'string', 
            'sep' => ' x ', 'format' => '%value% %sign%', 
            'decimals' => true, 'default' => '');

        $args = wp_parse_args($args, $defaults);

        if (is_null($this->value)) {
            return $this->value;
        }

        $parts = array(
            gdcet_unit_format('length', $this->value['x']['value'], $this->value['x']['unit'], $args),
            gdcet_unit_format('length', $this->value['y']['value'], $this->value['y']['unit'], $args)
        );

        if ($this->settings['type'] == '3d') {
            $parts[] = gdcet_unit_format('length', $this->value['z']['value'], $this->value['z']['unit'], $args);
        }
        
        $render = $args['return'] == 'string' ? join($args['sep'], $parts) : $parts;

        return $args['before'].$render.$args['after'];
    }
}
