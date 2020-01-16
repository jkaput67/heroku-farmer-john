<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_custom_field extends gdcet_meta_meta_field {
    public $type = 'custom';

    public $label = '';
    public $slug = '';
    public $description = '';
    public $class = '';
    public $required = false;
    public $repeater = false;
    public $repeater_limit = 0;

    protected function init() {
        if (empty($this->fields)) {
            $this->fields[] = new gdcet_meta_core_field_text();
            $this->fields[] = new gdcet_meta_core_field_text();
        }
    }

    public function validate() {
        $errors = parent::validate();

        $this->label = d4p_sanitize_basic($this->label);
        $this->slug = gdcet_sanitize_field_slug($this->slug);
        $this->description = d4p_sanitize_html($this->description);
        $this->class = d4p_sanitize_html_classes($this->slug);

        $this->required = $this->required === 'on';
        $this->repeater = $this->repeater === 'on';
        $this->repeater_limit = $this->repeater ? absint($this->repeater_limit) : 0;

        if (empty($this->label)) {
            $errors->add('basic-label.field', __("Label is required.", "gd-content-tools"));
        }

        if (empty($this->slug)) {
            $errors->add('basic-slug.field', __("Slug is required.", "gd-content-tools"));
        }

        foreach ($this->fields as $key => $field) {
            if (!is_null($field)) {
                $_e = $field->validate($key);

                if (!$field->repeater_custom) {
                    $this->repeater = false;
                }

                if ($_e->has_errors()) {
                    $errors->merge_errors($_e->errors);
                }
            } else {
                unset($this->fields[$key]);
            }
        }

        $this->fields = array_values($this->fields);

        return $errors;
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

    public function is_required() {
        return $this->required;
    }

    public function is_repeater() {
        return $this->repeater;
    }

    public function get_repeater_limit() {
        return $this->repeater_limit;
    }

    public function prime($index = 0) {
        foreach ($this->fields as $field) {
            $field->values = array();
        }

        if (isset($this->values[$index])) {
            foreach ($this->values[$index] as $key => $values) {
                $mod = $this->mapped[$key];

                $this->fields[$mod]->values = $values;
            }
        }
    }

    public function form($id_base, $name_base, $index = 0, $echo = true) {
        $_parent_index = $index;

        $id_base.= $this->get_slug().'-'.$index;
        $name_base.= '['.$this->get_slug().']['.$index.']';

        $this->prime($index);

        ob_start();

        foreach ($this->fields as $_inner) {
            $_inner_id_base = $id_base.'-'.$_inner->b('slug');
            $_inner_name_base = $name_base.'['.$_inner->b('slug').']';

            include(GDCET_PATH.'meta/forms/inner.php');
        }

        $output = ob_get_clean();

        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }

    public function process($input) {
        $this->process = array();

        foreach ($input as $item) {
            $new = array();

            foreach ($item as $field => $values) {
                $this->fields[$this->mapped[$field]]->process($values);

                $new[$field] = $this->fields[$this->mapped[$field]]->process;
            }

            foreach ($this->fields as $field) {
                if (!isset($new[$field->basic['slug']]) && $field->name == 'boolean') {
                    $new[$field->basic['slug']] = array('0');
                }
            }

            $this->process[] = $new;
        }
    }
}
