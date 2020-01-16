<?php

if (!defined('ABSPATH')) exit;

abstract class gdcet_meta_meta_field {
    public $id = 0;
    public $type = '';

    public $fields = array();
    public $process = array();
    public $values = array();

    public $mapped = array();

    public function __construct($args = null) {
        if (!is_null($args) && is_array($args) && !empty($args)) {
            $this->fill($args);
        }

        $this->init();
    }

    public function __clone() {
        foreach ($this as $key => $val) {
            if (is_object($val) || (is_array($val))){
                $this->{$key} = unserialize(serialize($val));
            }
        }
    }

    public function store() {
        $data = (array)$this;
        $data['fields'] = array();

        foreach ($this->fields as $field) {
            $data['fields'][] = $field->store();
        }

        unset($data['process']);
        unset($data['values']);
        unset($data['map']);

        return $data;
    }

    public function fill($args) {
        foreach ($args as $key => $value) {
            $this->$key = $value;
        }

        foreach ($this->fields as $_key => $_data) {
            $type = isset($_data['name']) ? $_data['name'] : $_data['basic']['type'];
            $this->fields[$_key] = gdcet_meta_get_basic_field($type, $_data);
            $this->mapped[$_data['basic']['slug']] = $_key;
        }
    }

    public function render($show_open = false, $echo = false) {
        $output = array();

        $field_id = 0;
        foreach ($this->fields as $field) {
            $output[] = $field->render($field_id, $this->type, $show_open, false);

            $field_id++;
        }

        if ($echo) {
            echo join('', $output);
        } else {
            return $output;
        }
    }

    public function validate() {
        $errors = new d4p_errors();

        $this->id = intval($this->id);

        return $errors;
    }

    public function get_id() {
        return $this->id;
    }

    public function field($index = 0) {
        return $this->fields[$index];
    }

    public function count_values() {
        return count($this->values);
    }

    public function is_simple() {
        return $this->type == 'simple';
    }

    public function expose() {
        $field = $this->type == 'custom' ? new gdcet_core_metafield_custom() :
                                           new gdcet_core_metafield_simple();

        $field->id = $this->id;
        $field->slug = $this->get_slug();
        $field->label = $this->get_label();
        $field->description = $this->get_description();
        $field->is_repeater = $this->is_repeater();
        $field->is_required = $this->is_required();

        $field->values = array_values($this->values);

        foreach ($this->fields as $base) {
            $sub = $base->expose();

            if ($sub !== false) {
                $field->fields[$sub->slug] = $sub;
            }
        }

        if (empty($field->fields)) {
            return false;
        }

        $field->index = array_keys($field->fields);

        if (!empty($field->values)) {
            $field->setup_value($field->values[0]);
        }

        return $field;
    }

    abstract protected function init();

    abstract public function form($id_base, $name_base, $index = 0, $echo = true);
    abstract public function process($input);
    abstract public function prime($index);

    abstract public function get_label();
    abstract public function get_slug();
    abstract public function get_description();
    abstract public function is_required();
    abstract public function is_repeater();
    abstract public function get_repeater_limit();
}
