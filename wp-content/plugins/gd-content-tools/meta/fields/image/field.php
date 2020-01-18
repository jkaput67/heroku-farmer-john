<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_image extends gdcet_meta_core_field {
    public $icon = 'picture-o';

    public static function get_defaults() {
        return array();
    }

    protected function init() {
        $this->name = 'image';
        $this->label = __("Image", "gd-content-tools");
        $this->category = 'basic';
    }

    public function validate($key) {
        return parent::validate($key);
    }

    public function get_default_value() {
        return 0;
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

class gdcet_core_basefield_image extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '',
            'return' => 'image_link', 'size' => 'thumbnail', 'class', 
            'alt' => '', 'srcset' => '', 'sizes' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $id = absint($this->value);

        if ($id == 0) {
            return new WP_Error('invalid_value', __("Image ID is invalid.", "gd-content-tools"));
        }

        $render = '';

        $atts = array(
            'srcset' => $args['srcset'],
            'sizes' => $args['sizes']
        );

        if (!empty($args['alt'])) {
            $atts['alt'] = $args['alt'];
        }

        switch ($args['return']) {
            default:
            case 'id':
                $render = $id;
                break;
            case 'path':
                $render = get_attached_file($id);
                break;
            case 'url':
                $img = wp_get_attachment_image_src($id, $args['size']);

                if ($img === false) {
                    return new WP_Error('invalid_value', __("Image ID is invalid.", "gd-content-tools"));
                }

                $render = $img[0];
                break;
            case 'permalink':
                $render = get_attachment_link($id);
                break;
            case 'link':
                $img = wp_get_attachment_image_src($id, $args['size']);

                if ($img === false) {
                    return new WP_Error('invalid_value', __("Image ID is invalid.", "gd-content-tools"));
                }

                $render = '<a href="'.$img[0].'">'.get_the_title($id).'</a>';
                break;
            case 'image':
                $render = wp_get_attachment_image($id, $args['size'], true, $atts);
                break;
            case 'image_link':
                $img = wp_get_attachment_image_src($id, 'full');

                if ($img === false) {
                    return new WP_Error('invalid_value', __("Image ID is invalid.", "gd-content-tools"));
                }

                $render = '<a href="'.$img[0].'">'.wp_get_attachment_image($id, $args['size'], true, $atts).'</a>';
                break;
        }

        return $args['before'].$render.$args['after'];
    }
}
