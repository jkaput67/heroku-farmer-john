<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_html extends gdcet_meta_core_field {
    public $icon = 'file-text-o';

    public static function get_defaults() {
        return array(
            'limit' => 0,
            'default' => '',
            'placeholder' => '',
            'allow_html' => true,
            'allow_html_restricted' => false,
            'allow_shortcodes' => true
        );
    }

    protected function init() {
        $this->name = 'html';
        $this->label = __("Textarea", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['limit'] = absint($this->settings['limit']);

        $this->settings['default'] = d4p_sanitize_basic($this->settings['default']);
        $this->settings['placeholder'] = d4p_sanitize_basic($this->settings['placeholder']);

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
                $allowed_tags = array();

                if ($this->s('allow_html')) {
                    $allowed_tags = wp_kses_allowed_html('post');

                    if ($this->s('allow_html_restricted')) {
                        $allowed_tags['script'] = array(
                            'type' => true,
                            'src' => true,
                            'name' => true
                        );

                        $allowed_tags['iframe'] = array(
                            'src' => true,
                            'name' => true,
                            'frameborder' => true,
                            'width' => true,
                            'height' => true,
                            'class' => true
                        );
                    }

                    $allowed_tags = apply_filters('gdcet_field_textarea_allowed_html_tags', $allowed_tags, $this->s('allow_html_restricted'));
                }

                $strip_shortcodes = !$this->s('allow_shortcodes');

                $this->process[] = d4p_sanitize_extended($item, $allowed_tags, array(), $strip_shortcodes);
            }
        }
    }
}

class gdcet_core_basefield_html extends gdcet_core_basefield_content {
    public $_defaults = array('before' => '', 'after' => '', 'wptexturize' => false,
            'smilies' => true, 'wpautop' => false, 'shortcodes' => true, 'default' => '');
}
