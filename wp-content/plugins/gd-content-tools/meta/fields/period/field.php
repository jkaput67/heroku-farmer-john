<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_period extends gdcet_meta_core_field {
    public $icon = 'circle-o-notch';

    public static function get_defaults() {
        return array(
            'year' => 0,
            'month' => 0,
            'day' => 0,
            'hour' => 0,
            'minute' => 0,
            'second' => 0
        );
    }

    protected function init() {
        $this->name = 'period';
        $this->label = __("Period", "gd-content-tools");
        $this->category = 'datetime';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['year'] = absint($this->settings['year']);
        $this->settings['month'] = absint($this->settings['month']);
        $this->settings['day'] = absint($this->settings['day']);
        $this->settings['hour'] = absint($this->settings['hour']);
        $this->settings['minute'] = absint($this->settings['minute']);
        $this->settings['second'] = absint($this->settings['second']);

        return $errors;
    }

    public function get_default_value() {
        return array(
            'year' => $this->s('year'),
            'month' => $this->s('month'),
            'day' => $this->s('day'),
            'hour' => $this->s('hour'),
            'minute' => $this->s('minute'),
            'second' => $this->s('second')
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

                foreach (array('year', 'month', 'day', 'hour', 'minute', 'second') as $key) {
                    $clean[$key] = isset($item[$key]) ? absint($item[$key]) : 0;
                }

                $this->process[] = $clean;
            }
        }
    }
}

class gdcet_core_basefield_period extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '',
            'return' => 'string', 'default' => '', 
            'year' => array('year', 'years'),
            'month' => array('month', 'months'),
            'day' => array('day', 'days'),
            'hour' => array('hour', 'hours'),
            'minute' => array('minute', 'minutes'),
            'second' => array('second', 'seconds'));

        $args = wp_parse_args($args, $defaults);

        $parts = array();
        foreach ($this->value as $key => $value) {
            if ($value > 0) {
                $parts[] = $value.' '._n($args[$key][0], $args[$key][1], $value, "gd-content-tools");
            }
        }

        $render = $args['return'] == 'string' ? join(' ', $parts) : $parts;

        return $args['before'].$render.$args['after'];
    }
}
