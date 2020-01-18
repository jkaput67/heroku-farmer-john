<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_icon_fa extends gdcet_meta_core_field {
    public $icon = 'fort-awesome';

    public static function get_defaults() {
        return array(
            'default' => 'flag'
        );
    }

    protected function init() {
        $this->name = 'icon-fa';
        $this->label = __("Icon FontAwesome", "gd-content-tools");
        $this->category = 'content';
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
                $this->process[] = d4p_sanitize_basic($item);
            }
        }
    }
}

class gdcet_core_basefield_icon_fa extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '',
            'tag' => 'i', 'class' => '', 'default' => 'circle');

        $args = wp_parse_args($args, $defaults);

        $render = '<'.$args['tag'].' class="fa fa-'.$this->value.' '.$args['class'].'"></'.$args['tag'].'>';

        return $args['before'].$render.$args['after'];
    }
}
