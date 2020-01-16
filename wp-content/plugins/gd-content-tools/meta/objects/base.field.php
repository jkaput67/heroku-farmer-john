<?php

if (!defined('ABSPATH')) exit;

abstract class gdcet_meta_core_field {
    public $icon = 'square-o';
    public $required = true;
    public $repeater = true;
    public $repeater_custom = true;

    public $name = '';
    public $label = '';
    public $category = '';

    public $basic = array();
    public $settings = array();
    public $values = array();
    public $process = array();

    public function __construct($args = null) {
        $this->init();

        $this->basic = $this->get_basics();
        $this->settings = $this->get_defaults();

        if (!is_null($args) && is_array($args) && !empty($args)) {
            $this->fill($args);
        }
    }

    abstract protected function init();

    public static function get_defaults() {
        return array();
    }

    protected function get_basics() {
        return array(
            'label' => '',
            'slug' => '',
            'description' => '',
            'class' => '',
            'type' => '',
            'required' => false,
            'repeater' => false,
            'repeater_limit' => 0,
            'conditions' => array()
        );
    }

    public function b($name, $default = null) {
        return isset($this->basic[$name]) ? $this->basic[$name] : $default;
    }

    public function s($name, $default = null) {
        return isset($this->settings[$name]) ? $this->settings[$name] : $default;
    }

    public function is_required() {
        return $this->b('required');
    }

    public function is_repeater() {
        return $this->b('repeater');
    }

    public function validate($key) {
        $errors = new d4p_errors();

        $this->basic['label'] = d4p_sanitize_basic($this->basic['label']);
        $this->basic['slug'] = gdcet_sanitize_field_slug($this->basic['slug']);
        $this->basic['description'] = d4p_sanitize_html($this->basic['description']);
        $this->basic['class'] = d4p_sanitize_html_classes($this->basic['class']);

        $this->basic['required'] = $this->required ? $this->basic['required'] == 'on' : false;
        $this->basic['repeater'] = $this->repeater ? $this->basic['repeater'] == 'on' : false;

        $this->basic['repeater_limit'] = $this->basic['repeater'] ? absint($this->basic['repeater_limit']) : 0;

        $this->basic['conditions'] = array();

        if (empty($this->basic['label'])) {
            $errors->add('basic-label.'.$key, __("Label is required.", "gd-content-tools"));
        }

        if (empty($this->basic['slug'])) {
            $errors->add('basic-slug.'.$key, __("Slug is required.", "gd-content-tools"));
        }

        return $errors;
    }

    public function controls($field_id, $echo = false) {
        ob_start();

        include(GDCET_PATH.'meta/fields/'.$this->name.'/form.php');

        $output = ob_get_clean();

        if (!$this->repeater) {
            $output = '<div class="gdcet-field-no-repeat">'.
                      __("Repeater option is not available for this field type.", "gd-content-tools").
                      '</div>'.$output;
        }

        if (!$this->required) {
            $output = '<div class="gdcet-field-no-repeat">'.
                      __("This field type can't be set as required.", "gd-content-tools").
                      '</div>'.$output;
        }

        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }

    public function render($field_id, $field_type = 'custom', $show_open = false, $echo = false) {
        ob_start();

        include(GDCET_PATH.'forms/meta/field.php');

        $output = ob_get_clean();

        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }

    public function store() {
        return array('basic' => $this->basic, 'settings' => $this->settings);
    }

    public function fill($args) {
        $defaults = array('basic' => array(), 'settings' => array());
        $args = wp_parse_args($args, $defaults);

        $this->basic = wp_parse_args($args['basic'], $this->basic);
        $this->settings = wp_parse_args($args['settings'], $this->settings);
    }

    public function __clone() {
        foreach ($this as $key => $val) {
            if (is_object($val) || (is_array($val))){
                $this->{$key} = unserialize(serialize($val));
            }
        }
    }

    public function get_placeholder() {
        return isset($this->settings['placeholder']) ? $this->settings['placeholder'] : '';
    }

    public function get_default_value() {
        return isset($this->settings['default']) ? $this->settings['default'] : null;
    }

    public function get_edit_value($index) {
        return $this->get_value($index);
    }

    public function get_value($index) {
        if (isset($this->values[$index])) {
            return $this->values[$index];
        } else {
            return $this->get_default_value();
        }
    }

    public function count_values() {
        return count($this->values);
    }

    public function form($id_base, $name_base, $index = 0, $echo = true, $ajax = false) {
        ob_start();

        $this->form_include($id_base, $name_base, $index, $ajax);

        $output = ob_get_clean();

        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }

    protected function form_include($id_base, $name_base, $index = 0, $ajax = false) {
        include(GDCET_PATH.'meta/fields/'.$this->name.'/input.php');
    }

    public function process($input) {
        $this->process = array();
    }

    public function expose() {
        if ($this->name == 'info') {
            return false;
        }

        $_class_name = 'gdcet_core_basefield_'.str_replace('-', '_', $this->name);

        $field = new $_class_name();

        $field->type = $this->name;
        $field->values = $this->values;
        $field->settings = array_merge($this->settings, $this->basic);

        $field->init();

        return $field;
    }
}

abstract class gdcet_meta_datetime_field extends gdcet_meta_core_field {
    public $format = '';
    public $stores = array(
        'colon' => 'Y:m:d H:i:s',
        'dotted' => 'Y.m.d H.i.s',
        'dashed' => 'Y-m-d H-i-s'
    );

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
            'timestamp' => __("Timestamp", "gd-content-tools"),
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
                $timestamp = strtotime($date);

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

    public function get_default_value() {
        return isset($this->settings['default']) && !empty($this->settings['default']) ? $this->settings['default'] : '';
    }

    public function get_edit_value($index) {
        if (isset($this->values[$index]) && !empty($this->values[$index])) {
            $date_time = $this->values[$index];
            $timestamp = strtotime($date_time);

            return date($this->format, $timestamp);
        } else {
            return $this->get_default_value();
        }
    }

    public function get_time_modes() {
        return array(
            '12h' => __("12 hours mode, with AM/PM selection", "gd-content-tools"),
            '24h' => __("24 hours mode", "gd-content-tools")
        );
    }
}

abstract class gdcet_meta_select_field extends gdcet_meta_core_field {
    public $mode = 'single';
    public $repeater = false;

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['mode'] = d4p_sanitize_basic($this->settings['mode']);
        $this->settings['source'] = d4p_sanitize_basic($this->settings['source']);
        $this->settings['display'] = d4p_sanitize_basic($this->settings['display']);

        if (isset($this->settings['limit'])) {
            $this->settings['limit'] = absint($this->settings['limit']);
        }

        $id = 0;
        $map = array();
        $list = array();
        $defaults = array();

        if ($this->settings['mode'] == 'normal') {
            foreach ($this->settings['list'] as $key => $item) {
                if ($key !== '%id%') {
                    $label = d4p_sanitize_basic($item['label']);

                    if ($label != '') {
                        $list[$id] = $label;
                        $map[$key] = $label;

                        $id++;
                    }
                }
            }
        } else {
            foreach ($this->settings['list'] as $key => $item) {
                if ($key !== '%id%') {
                    $value = d4p_sanitize_basic($item['value']);
                    $label = d4p_sanitize_basic($item['label']);

                    if ($value != '' && $label != '') {
                        $list[$value] = $label;
                        $map[$key] = $value;
                    }
                }
            }
        }

        $this->settings['list'] = $list;

        if ($this->settings['source'] == 'list') {
            $this->settings['function'] = '';
            $this->settings['remote'] = '';
            $this->settings['default'] = (array)$this->settings['default'];

            foreach ($this->settings['default'] as $key) {
                if (isset($map[$key])) {
                    $defaults[] = $map[$key];
                }
            }

            $this->settings['default'] = $defaults;
        } else if ($this->settings['source'] == 'remote') {
            $this->settings['default'] = array();
            $this->settings['display'] = 'select2';
            $this->settings['function'] = '';
            $this->settings['remote'] = d4p_sanitize_basic($this->settings['remote']);
        } else {
            $this->settings['default'] = array();
            $this->settings['remote'] = '';
            $this->settings['function'] = d4p_sanitize_basic($this->settings['function']);
        }

        return $errors;
    }

    public function get_modes() {
        return array(
            'normal' => __("Plain list", "gd-content-tools"),
            'associative' => __("Associative list", "gd-content-tools")
        );
    }

    public function get_display() {
        return array(
            'html' => __("Normal - HTML control", "gd-content-tools"),
            'select2' => __("Enhanced - Select2 control", "gd-content-tools")
        );
    }

    public function get_sources() {
        return array(
            'list' => __("Items list", "gd-content-tools"),
            'function' => __("Function", "gd-content-tools"),
            'remote' => __("Remote", "gd-content-tools")
        );
    }

    public function get_functions() {
        return apply_filters('gdcet_meta_select_predefined_lists', array());
    }

    public function get_remote() {
        return apply_filters('gdcet_meta_select_remote_sources', array());
    }

    public function get_list($selected = array()) {
        if ($this->settings['source'] == 'list') {
            return $this->settings['list'];
        } else if ($this->settings['source'] == 'function') {
            return call_user_func($this->settings['function']);
        } else if ($this->settings['source'] == 'remote') {
            return call_user_func($this->settings['remote'], $selected);
        }
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        $list = $this->get_list();
        $associative = $this->s('mode') == 'associative';

        foreach ($input as $item) {
            $item = (array)$item;

            $selected = array();

            if ($associative) {
                foreach ($item as $v) {
                    if (isset($list[$v])) {
                        $selected[] = $v;
                    }
                }
            } else {
                foreach ($item as $v) {
                    if (in_array($v, $list)) {
                        $selected[] = $v;
                    }
                }
            }

            if (count($selected) == 0) {
                $selected = '';
            } else if (count($selected) == 1) {
                $selected = $selected[0];
            }

            $this->process[] = $selected;
        }
    }
}

abstract class gdcet_meta_radio_field extends gdcet_meta_core_field {
    public $mode = 'single';
    public $repeater = false;

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['mode'] = d4p_sanitize_basic($this->settings['mode']);
        $this->settings['source'] = d4p_sanitize_basic($this->settings['source']);

        if (isset($this->settings['limit'])) {
            $this->settings['limit'] = absint($this->settings['limit']);
        }

        $id = 0;
        $map = array();
        $list = array();
        $defaults = array();

        if ($this->settings['mode'] == 'normal') {
            foreach ($this->settings['list'] as $key => $item) {
                if ($key !== '%id%') {
                    $label = d4p_sanitize_basic($item['label']);

                    if ($label != '') {
                        $list[$id] = $label;
                        $map[$key] = $label;

                        $id++;
                    }
                }
            }
        } else {
            foreach ($this->settings['list'] as $key => $item) {
                if ($key !== '%id%') {
                    $value = d4p_sanitize_basic($item['value']);
                    $label = d4p_sanitize_basic($item['label']);

                    if ($value != '' && $label != '') {
                        $list[$value] = $label;
                        $map[$key] = $value;
                    }
                }
            }
        }

        $this->settings['list'] = $list;

        if ($this->settings['source'] == 'list') {
            $this->settings['function'] = '';
            $this->settings['default'] = (array)$this->settings['default'];

            foreach ($this->settings['default'] as $key) {
                if (isset($map[$key])) {
                    $defaults[] = $map[$key];
                }
            }

            $this->settings['default'] = $defaults;
        } else {
            $this->settings['default'] = array();
            $this->settings['function'] = d4p_sanitize_basic($this->settings['function']);
        }

        return $errors;
    }

    public function get_modes() {
        return array(
            'normal' => __("Plain list", "gd-content-tools"),
            'associative' => __("Associative list", "gd-content-tools")
        );
    }

    public function get_sources() {
        return array(
            'list' => __("Items list", "gd-content-tools"),
            'function' => __("Function", "gd-content-tools")
        );
    }

    public function get_functions() {
        return apply_filters('gdcet_meta_select_predefined_lists', array());
    }

    public function get_list() {
        if ($this->settings['source'] == 'list') {
            return $this->settings['list'];
        } else if ($this->settings['source'] == 'function') {
            return call_user_func($this->settings['function']);
        }
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        $list = $this->get_list();
        $associative = $this->s('mode') == 'associative';

        foreach ($input as $item) {
            $item = (array)$item;

            $selected = array();

            if ($associative) {
                foreach ($item as $v) {
                    if (isset($list[$v])) {
                        $selected[] = $v;
                    }
                }
            } else {
                foreach ($item as $v) {
                    if (in_array($v, $list)) {
                        $selected[] = $v;
                    }
                }
            }

            if (count($selected) == 0) {
                $selected = '';
            } else if (count($selected) == 1) {
                $selected = $selected[0];
            }

            $this->process[] = $selected;
        }
    }
}

abstract class gdcet_meta_wp_field extends gdcet_meta_core_field {
    public $repeater = false;

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['display'] = d4p_sanitize_basic($this->settings['display']);

        if (isset($this->settings['limit'])) {
            $this->settings['limit'] = absint($this->settings['limit']);
        }

        return $errors;
    }

    public function get_display() {
        return array(
            'classic' => __("Classic", "gd-content-tools"),
            'select2' => __("Enhanced - Select2 control", "gd-content-tools")
        );
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $list = explode(',', $item);
                $list = array_map('absint', $list);
                $list = array_filter($list);

                $this->process[] = $list;
            }
        }
    }
}
