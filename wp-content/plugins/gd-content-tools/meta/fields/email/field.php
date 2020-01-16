<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_email extends gdcet_meta_core_field {
    public $icon = 'envelope';

    public static function get_defaults() {
        return array(
            'default' => '',
            'placeholder' => ''
        );
    }

    protected function init() {
        $this->name = 'email';
        $this->label = __("Email", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['default'] = sanitize_email($this->settings['default']);
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
                $email = sanitize_email($item);

                if (!empty($email)) {
                    $this->process[] = $email;
                }
            }
        }
    }
}

class gdcet_core_basefield_email extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'return' => 'email', 
            'class' => '', 'rel' => '', 'antispam' => false, 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $email = $args['antispam'] ? antispambot($this->value) : $this->value;

        $render = '';

        switch ($args['return']) {
            default:
            case 'url':
                $render = $email;
                break;
            case 'link':
                $render = '<a href="mailto:'.$email.'" rel="'.$args['rel'].'" class="'.$args['class'].'">'.$email.'</a>';
                break;
        }

        return $args['before'].$render.$args['after'];
    }
}
