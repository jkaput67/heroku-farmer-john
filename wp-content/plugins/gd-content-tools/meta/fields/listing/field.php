<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_listing extends gdcet_meta_core_field {
    public $icon = 'list-alt';
    public $repeater = false;

    public static function get_defaults() {
        return array(
            'limit' => 0,
            'allow_html' => false,
            'allow_shortcodes' => false
        );
    }

    protected function init() {
        $this->name = 'listing';
        $this->label = __("Listing", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['limit'] = absint($this->settings['limit']);

        $this->settings['allow_html'] = $this->settings['allow_html'] == 'on';
        $this->settings['allow_shortcodes'] = $this->settings['allow_shortcodes'] == 'on';

        return $errors;
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $allowed_tags = $this->s('allow_html') ? wp_kses_allowed_html() : array();
                $strip_shortcodes = !$this->s('allow_shortcodes');

                $listing = d4p_sanitize_extended($item, $allowed_tags, array(), $strip_shortcodes);
                $listing = d4p_split_textarea_to_list($listing);

                $this->process[] = $listing;
            }
        }
    }

    public function get_default_value() {
        return array();
    }
}

class gdcet_core_basefield_listing extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'method' => 'list', 'sep' => ', ', 
            'list' => 'ul', 'class' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $values = array();

        if ($this->mode == 'associative') {
            foreach ($this->value as $v) {
                $values[] = $this->list[$v];
            }
        } else {
            $values = $this->value;
        }

        $render = '';

        switch ($args['method']) {
            case 'list':
                $render = '<'.$args['list'].' class="'.$args['class'].'">';
                $render.= '<li>'.join('</li><li>', $values).'</li>';
                $render.= '</'.$args['list'].'>';
                break;
            case 'string':
                $render = join($args['sep'], $values);
                break;
        }

        return $args['before'].$render.$args['after'];
    }
}
