<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_file extends gdcet_meta_core_field {
    public $icon = 'file';

    public static function get_defaults() {
        return array();
    }

    protected function init() {
        $this->name = 'file';
        $this->label = __("File", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        return parent::validate($key);
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $this->process[] = absint($item);
            }
        }
    }
}

class gdcet_core_basefield_file extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '',
            'return' => 'link', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $id = absint($this->value);

        if ($id == 0) {
            return new WP_Error('invalid_value', __("File ID is invalid.", "gd-content-tools"));
        }

        $render = '';

        switch ($args['return']) {
            default:
            case 'id':
                $render = $id;
                break;
            case 'path':
                $render = get_attached_file($id);
                break;
            case 'url':
                $render = wp_get_attachment_url($id);
                break;
            case 'permalink':
                $render = get_attachment_link($id);
                break;
            case 'link':
                $render = '<a href="'.wp_get_attachment_url($id).'">'.get_the_title($id).'</a>';
                break;
        }

        return $args['before'].$render.$args['after'];
    }
}
