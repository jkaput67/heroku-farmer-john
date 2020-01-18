<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_month extends gdcet_meta_core_field {
    public $icon = 'calendar-check-o';
    public $format = 'Y-m';
    public $stores = array(
        'colon' => 'Y:m',
        'dotted' => 'Y.m',
        'dashed' => 'Y-m'
    );

    public static function get_defaults() {
        return array(
            'custom' => true,
            'default' => '',
            'store' => 'dashed'
        );
    }

    protected function init() {
        $this->name = 'month';
        $this->label = __("Month", "gd-content-tools");
        $this->category = 'datetime';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['custom'] = isset($this->settings['custom']);
        $this->settings['default'] = trim($this->settings['default']);

        if ($this->settings['custom'] && !empty($this->settings['default'])) {
            $control = DateTime::createFromFormat($this->format, $this->settings['default']);

            if ($control->format($this->format) != $this->settings['default']) {
                $this->settings['default'] = '';
            }
        } else {
            $this->settings['default'] = '';
        }

        $this->settings['store'] = d4p_sanitize_basic($this->settings['store']);

        return $errors;
    }

    public function get_store_formats() {
        return array(
            'mysql' => __("MySQL DateTime", "gd-content-tools"),
            'colon' => __("Colons separated", "gd-content-tools"),
            'dotted' => __("Dots separated", "gd-content-tools"),
            'dashed' => __("Dashes separated", "gd-content-tools")
        );
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $date = d4p_sanitize_basic($item);
                $control = DateTime::createFromFormat($this->format, $date);

                if ($control->format($this->format) == $date) {
                    $timestamp = $control->getTimestamp();

                    switch ($this->s('store')) {
                        default:
                        case 'timestamp':
                            $date = $timestamp;
                            break;
                        case 'mysql':
                            $date = date('Y-m-d H:i:s', $timestamp);
                            break;
                        case 'colon':
                            $date = date($this->stores['colon'], $timestamp);
                            break;
                        case 'dotted':
                            $date = date($this->stores['dotted'], $timestamp);
                            break;
                        case 'dashed':
                            $date = date($this->stores['dashed'], $timestamp);
                            break;
                    }

                    $this->process[] = $date;
                }
            }
        }
    }

    public function get_default_value() {
        return isset($this->settings['default']) && !empty($this->settings['default']) ? $this->settings['default'] : '';
    }

    public function get_edit_value($index) {
        if (isset($this->values[$index])) {
            $current = $this->values[$index];

            $year = absint(substr($current, 0, 4));
            $month = absint(substr($current, 5, 2)) + 1;

            $timestamp = mktime(0, 0, 0, $month, 0, $year);

            return date($this->format, $timestamp);
        } else {
            return $this->get_default_value();
        }
    }
}

class gdcet_core_basefield_month extends gdcet_core_basefield_dates {
    protected $default_format = 'F Y';
}
