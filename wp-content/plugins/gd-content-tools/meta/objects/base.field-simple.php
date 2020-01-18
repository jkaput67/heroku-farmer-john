<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_simple_field extends gdcet_meta_meta_field {
    public $type = 'simple';

    protected function init() {
        if (empty($this->fields)) {
            $this->fields[] = new gdcet_meta_core_field_text();
        }
    }

    public function prime($index) {}

    public function get_label() {
        return $this->field()->basic['label'];
    }

    public function get_slug() {
        return $this->field()->basic['slug'];
    }

    public function get_description() {
        return $this->field()->basic['description'];
    }

    public function get_class() {
        return $this->field()->basic['class'];
    }

    public function is_required() {
        return $this->field()->basic['required'];
    }

    public function is_repeater() {
        return $this->field()->repeater && $this->field()->basic['repeater'];
    }

    public function get_repeater_limit() {
        return $this->is_repeater() ? $this->field()->basic['repeater_limit'] : 0;
    }

    public function form($id_base, $name_base, $index = 0, $echo = true, $ajax = false) {
        $id_base.= $this->get_slug().'-'.$index;
        $name_base.= '['.$this->get_slug().']['.$index.']';

        $output = $this->field()->form($id_base, $name_base, $index, false, $ajax);

        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }

    public function process($input) {
        $this->field()->process($input);

        $this->process = $this->field()->process;
    }
}
