<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_legacy_box extends gdcet_meta_core_box {
    public $type = 'legacy';

    protected function load() {
        foreach (array_keys($this->data) as $field) {
            if (isset($this->load['meta'][$field])) {
                $this->data[$field]->values = $this->load['meta'][$field];
                $this->data[$field]->fields[0]->values = $this->load['meta'][$field];
            }
        }
    }

    public function prepare($type, $id) {
        if ($this->load['type'] != $type && $this->load['id'] != $id) {
            $this->load['meta'] = gdcet_meta_box_data::instance($type, $id, array_keys($this->data));

            $this->load['type'] = $type;
            $this->load['id'] = $id;

            $this->load();
        }
    }

    public function save($type, $id) {
        $save = array(); 
        $add = array(); 
        $remove = array();

        foreach ($this->data as $key => $field) {
            $save[$key] = array(
                'old' => $field->field()->values, 
                'new' => $field->field()->process);
        }

        foreach ($save as $key => $data) {
            foreach ($data['new'] as $new) {
                $is_new = true;

                foreach ($data['old'] as $old) {
                    if (maybe_serialize($old) == maybe_serialize($new)) {
                        $is_new = false;
                        break;
                    }
                }

                if ($is_new) {
                    $add[$key][] = $new;
                }
            }

            foreach ($data['old'] as $old) {
                $is_gone = true;

                foreach ($data['new'] as $new) {
                    if (maybe_serialize($old) == maybe_serialize($new)) {
                        $is_gone = false;
                        break;
                    }
                }

                if ($is_gone) {
                    $remove[$key][] = $old;
                }
            }
        }

        foreach ($add as $key => $items) {
            foreach ($items as $item) {
                add_metadata($type, $id, $key, $item);
            }
        }

        foreach ($remove as $key => $items) {
            foreach ($items as $item) {
                delete_metadata($type, $id, $key, $item);
            }
        }
    }
}
