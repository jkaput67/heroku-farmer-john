<?php

if (!defined('ABSPATH')) exit;

abstract class gdcet_meta_core_box {
    public $icon = 'th-list';

    public $id = 0;
    public $type = '';
    public $slug = '';
    public $label = '';
    public $description = '';
    public $class = '';

    public $fields = array();
    public $types = array(
        'post_types' => array(),
        'taxonomies' => array(),
        'user_roles' => array()
    );

    public $repeater = true;
    public $location = 'advanced';
    public $priority = 'high';
    public $layout = 'left';
    public $information = 'label';

    public $data = array();
    public $mapped = array();
    public $load = array(
        'type' => '',
        'id' => 0,
        'meta' => array()
    );

    public function __construct($args = array()) {
        $this->init();

        if (!is_null($args) && is_array($args) && !empty($args)) {
            $this->fill($args);
        }
    }

    public function __clone() {
        foreach ($this as $key => $val) {
            if (is_object($val) || (is_array($val))){
                $this->{$key} = unserialize(serialize($val));
            }
        }
    }

    protected function init() {}

    protected function load() {}

    public function prepare($type, $id) {}

    public function validate() {
        $errors = new d4p_errors();

        $this->id = intval($this->id);

        $this->label = d4p_sanitize_basic($this->label);
        $this->slug = d4p_sanitize_slug($this->slug);
        $this->description = d4p_sanitize_html($this->description);
        $this->class = d4p_sanitize_html_classes($this->class);
        $this->priority = d4p_sanitize_html_classes($this->priority);
        $this->location = d4p_sanitize_html_classes($this->location);

        $this->repeater = $this->repeater === 'on';

        if (empty($this->label)) {
            $errors->add('basic-label.field', __("Label is required.", "gd-content-tools"));
        }

        if (empty($this->slug)) {
            $errors->add('basic-slug.field', __("Slug is required.", "gd-content-tools"));
        }

        $unique = array();
        $fields = array();

        foreach ($this->fields as $key => $data) {
            if ($key !== '%id%') {
                $data['open_tab'] = isset($data['open_tab']);
                $data['tab_label'] = d4p_sanitize_basic($data['tab_label']);
                $data['field_id'] = intval($data['field_id']);

                if (!in_array($data['field_id'], $unique)) {
                    $fields[] = $data;
                    $unique[] = $data['field_id'];
                }
            }
        }

        $this->fields = $fields;

        return $errors;
    }

    public function store() {
        $data = (array)$this;

        unset($data['data']);
        unset($data['load']);
        unset($data['mapped']);

        return $data;
    }

    public function fill($args) {
        foreach ($args as $key => $value) {
            $this->$key = $value;
        }

        $this->data = array();

        foreach ($this->fields as $data) {
            $field = gdcet_meta()->get_field($data['field_id']);

            $this->data[$field->get_slug()] = $field;
            $this->mapped[$field->get_id()] = $field->get_slug();
        }
    }

    public function get_id() {
        return $this->id;
    }

    public function get_label() {
        return $this->label;
    }

    public function get_slug() {
        return $this->slug;
    }

    public function get_description() {
        return $this->description;
    }

    public function get_class() {
        return $this->class;
    }

    public function get_types($name) {
        if (isset($this->types[$name])) {
            return $this->types[$name];
        }

        return array();
    }

    public function is_repeater() {
        return $this->repeater;
    }

    public function is_valid() {
        return $this->type != 'error' && $this->type != '';
    }

    public function is_legacy() {
        return $this->type == 'legacy';
    }

    public function field_exists($name) {
        return isset($this->data[$name]);
    }

    public function field($name) {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return null;
    }

    public function field_by_index($index) {
        $all = array_keys($this->data);

        if (isset($all[$index])) {
            return $this->data[$all[$index]];
        }

        return null;
    }
}

class gdcet_meta_error_box extends gdcet_meta_core_box {
    public $type = 'error';
}

class gdcet_meta_box_data {
    public static function instance($type, $id, $fields = array()) {
        static $_gdcet_meta_data = array();

        if (!isset($_gdcet_meta_data[$type][$id])) {
            $_gdcet_meta_data[$type][$id] = array();

            $found = false;
            switch ($type) {
                case 'post':
                    $found = is_string(get_post_status($id));
                    break;
                case 'term':
                    $found = term_exists($id);
                    break;
                case 'user':
                    $found = get_userdata($id) !== false;
                    break;
            }

            if ($found) {
                $_raw = get_metadata($type, $id);

                foreach ($_raw as &$data) {
                    foreach ($data as &$item) {
                        $item = maybe_unserialize($item);
                    }
                }

                $_gdcet_meta_data[$type][$id] = $_raw;
            }
        }

        if (empty($fields)) {
            return $_gdcet_meta_data[$type][$id];
        } else {
            return array_intersect_key($_gdcet_meta_data[$type][$id], array_flip($fields));
        }
    }
}
