<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_metabox {
    /** @var gdcet_core_metafield Meta Field Object **/
    public $field = null;

    public $fields = array();
    public $index = array();

    public $meta_box = '';
    public $id = 0;
    public $type = '';
    public $label = '';
    public $slug = '';
    public $description = '';

    public $object_type = 'post';
    public $object_id = 0;

    public $in_the_loop = false;
    public $current_field = -1;

    public function __construct($meta_box, $type = 'post', $id = 0) {
        if ($type == 'post') {
            if ($id == 0) {
                global $post;

                if (isset($post->ID)) {
                    $id = $post->ID;
                }
            }
        }

        $this->meta_box = $meta_box;

        $this->object_type = $type;
        $this->object_id = absint($id);

        if (!is_null($this->object_id) && $this->object_id > 0 && in_array($this->object_type, array('post', 'term', 'user'))) {
            $this->load_metabox();
        }
    }

    private function load_metabox() {
        $_box = null;
        $_data = gdcet_meta()->get_box_data_by_slug($this->meta_box);

        if (!is_null($_data) && $_data['type'] == 'legacy') {
            $_box = new gdcet_meta_legacy_box($_data);
        } else if (!is_null($_data) && $_data['type'] == 'meta') {
            $_box = new gdcet_meta_meta_box($_data);
        }

        if (!is_null($_box)) {
            $_box->prepare($this->object_type, $this->object_id);

            $this->id = $_box->id;
            $this->type = $_box->type;
            $this->label = $_box->label;
            $this->slug = $_box->slug;
            $this->description = $_box->description;

            foreach ($_box->data as $key => $f) {
                $_the_field = $f->expose();

                if ($_the_field !== false) {
                    $this->fields[$key] = $_the_field;
                }
            }

            $this->index = array_keys($this->fields);
        }
    }

    public static function instance($meta_box, $type = 'post', $id = 0) {
        static $_gdcet_meta_boxes_data = array();

        if (!isset($_gdcet_meta_boxes_data[$meta_box][$type][$id])) {
            $_gdcet_meta_boxes_data[$meta_box][$type][$id] = new gdcet_core_metabox($meta_box, $type, $id);
        }

        return $_gdcet_meta_boxes_data[$meta_box][$type][$id];
    }

    public function field_exists($name) {
        return isset($this->fields[$name]);
    }

    /** @return gdcet_core_metafield_simple|gdcet_core_metafield_custom */
    public function field($name) {
        if ($this->field_exists($name)) {
            return $this->fields[$name];
        }

        return new WP_Error('field_missing', __("This field is not found in this metabox", "gd-content-tools"));
    }

    public function list_fields() {
        return array_keys($this->fields);
    }

    public function count_fields() {
        return count($this->fields);
    }

    public function have_fields() {
        if ($this->current_field + 1 < $this->count_fields()) {
            return true;
        } else if ($this->current_field + 1 == $this->count_fields() && $this->count_fields() > 0) {
            $this->rewind_fields();
        }

        $this->in_the_loop = false;

        return false;
    }

    public function rewind_fields() {
        $this->current_field = -1;
    }

    public function field_index() {
        return $this->current_field;
    }

    public function the_field() {
        global $_gdcet_field;

        $this->in_the_loop = true;

        $_gdcet_field = $this->next_field();

        $this->setup_field($_gdcet_field);
    }

    public function next_field() {
        $this->current_field++;

        $this->field = $this->fields[$this->index[$this->current_field]];

        return $this->field;
    }

    public function setup_field($field) { }
}
