<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_meta_box extends gdcet_meta_core_box {
    public $type = 'meta';

    protected function load() {
        foreach (array_keys($this->data) as $field) {
            if (isset($this->load['meta'][$field])) {
                $this->data[$field]->values = $this->load['meta'][$field];

                if ($this->data[$field]->type == 'simple') {
                    $this->data[$field]->fields[0]->values = $this->load['meta'][$field];
                }
            }
        }
    }

    public function prepare($type, $id) {
        if ($this->load['type'] != $type && $this->load['id'] != $id) {
            $_meta = gdcet_meta_box_data::instance($type, $id);

            $base_key = '['.$this->slug.']';

            foreach ($_meta as $key => $_data) {
                if (substr($key, 0, strlen($base_key)) == $base_key) {
                    $data = $_data[0];

                    $field_key = substr($key, strlen($base_key) + 1, strlen($key) - strlen($base_key) - 2);
                    $parts = explode('][', $field_key);

                    if (count($parts) == 2) {
                        $this->load['meta'][$parts[0]][$parts[1]] = $data;
                    } else {
                        $this->load['meta'][$parts[0]][$parts[1]][$parts[2]][$parts[3]] = $data;
                    }                    
                }
            }

            $this->load['type'] = $type;
            $this->load['id'] = $id;

            $this->load();
        }
    }

    public function save($type, $id) {
        $save = array(); 
        $add = array(); 
        $remove = array();
        $replace = array();

        $base = '['.$this->get_slug().']';

        foreach ($this->data as $key => $field) {
            foreach ($field->values as $j => $data) {
                $base_field = $base.'['.$field->get_slug().']['.$j.']';

                if ($field->type == 'simple') {
                    $save[$base_field]['old'] = $data;
                } else {
                    foreach ($data as $inner => $inner_data) {
                        $base_inner = $base_field.'['.$inner.']';

                        foreach ($inner_data as $i => $d) {
                            $save[$base_inner.'['.$i.']']['old'] = $d;
                        }
                    }
                }
            }

            foreach ($field->process as $j => $data) {
                $base_field = $base.'['.$field->get_slug().']['.$j.']';

                if ($field->type == 'simple') {
                    $save[$base_field]['new'] = $data;
                } else {
                    foreach ($data as $inner => $inner_data) {
                        $base_inner = $base_field.'['.$inner.']';

                        foreach ($inner_data as $i => $d) {
                            $save[$base_inner.'['.$i.']']['new'] = $d;
                        }
                    }
                }
            }
        }

        foreach ($save as $key => $data) {
            $new = isset($data['new']) ? $data['new'] : null;
            $old = isset($data['old']) ? $data['old'] : null;

            if (!is_null($new)) {
                if (!is_null($old)) {
                    if (maybe_serialize($old) != maybe_serialize($new)) {
                        $replace[$key] = array($new, $old);
                    }
                } else {
                    $add[$key] = $new;
                }
            } else {
                if (!is_null($old)) {
                    $remove[$key] = $old;
                }
            }
        }

        foreach ($add as $key => $item) {
            add_metadata($type, $id, $key, $item);
        }

        foreach ($remove as $key => $item) {
            delete_metadata($type, $id, $key, $item);
        }

        foreach ($replace as $key => $item) {
            update_metadata($type, $id, $key, $item[0], $item[1]);
        }
    }
}
