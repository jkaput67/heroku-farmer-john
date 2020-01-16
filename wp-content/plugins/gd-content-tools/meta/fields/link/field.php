<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_link extends gdcet_meta_core_field {
    public $icon = 'external-link';

    public static function get_defaults() {
        return array(
            'default' => '',
            'placeholder' => ''
        );
    }

    protected function init() {
        $this->name = 'link';
        $this->label = __("Link", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['default'] = esc_url_raw($this->settings['default']);
        $this->settings['placeholder'] = d4p_sanitize_basic($this->settings['placeholder']);

        return $errors;
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $link = esc_url_raw($item);

                if (!empty($link)) {
                    $this->process[] = $link;
                }
            }
        }
    }
}

class gdcet_core_basefield_link extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'title' => '', 'return' => 'url', 
            'class' => '', 'rel' => '', 'target' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $render = '';

        switch ($args['return']) {
            default:
            case 'url_clean':
                $render = str_replace(array('http://', 'https://'), '', $this->value);
                $render = untrailingslashit($render);
                break;
            case 'url':
                $render = $this->value;
                break;
            case 'link':
                $render = '<a href="'.$this->value.'" rel="'.$args['rel'].'" title="'.$args['title'].'" target="'.$args['target'].'" class="'.$args['class'].'">'.$this->value.'</a>';
                break;
        }

        return $args['before'].$render.$args['after'];
    }
}
