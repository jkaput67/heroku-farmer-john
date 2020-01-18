<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_currency extends gdcet_meta_core_field {
    public $icon = 'money';

    public static function get_defaults() {
        return array(
            'default' => 0,
            'currency' => 'USD'
        );
    }

    protected function init() {
        $this->name = 'currency';
        $this->label = __("Currency", "gd-content-tools");
        $this->category = 'unit';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['default'] = floatval($this->settings['default']);
        $this->settings['currency'] = d4p_sanitize_basic($this->settings['currency']);

        return $errors;
    }

    public function get_currencies() {
        gdcet_load_units();

        $units = d4p_units();
        $units->load('currency_google');
        
        return $units->get_unit_type_values('currency_google');
    }

    public function get_default_value() {
        return array(
            'value' => $this->s('default'),
            'currency' => $this->s('currency')
        );
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                if (isset($item['value']) && isset($item['currency'])) {
                    $this->process[] = array('value' => floatval($item['value']), 'currency' => d4p_sanitize_basic($item['currency']));
                }
            }
        }
    }
}

class gdcet_core_basefield_currency extends gdcet_core_basefield {
    public function render($args = array()) {
        require_once(GDCET_PATH.'meta/objects/core.units.php');

        $defaults = array('before' => '', 'after' => '', 'format' => '%sign% %value%', 
            'decimals' => 2, 'convert' => false, 'default' => '');

        $args = wp_parse_args($args, $defaults);

        if (is_null($this->value)) {
            return $this->value;
        }

        $value = $this->value['value'];
        $unit = $this->value['currency'];

        if ($args['convert'] !== false) {
            $to = $args['convert'];

            if (gdcet_units()->is_unit_available('currency_google', $to)) {
                $value = gdcet_units()->convert('currency_google', $value, $unit, $to);
                $unit = $to;
            }
        }

        $render = gdcet_unit_format('currency_google', $value, $unit, $args);

        return $args['before'].$render.$args['after'];
    }
}
