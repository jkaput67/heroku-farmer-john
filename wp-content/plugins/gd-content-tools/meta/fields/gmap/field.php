<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_gmap extends gdcet_meta_core_field {
    public $icon = 'map';

    public static function get_defaults() {
        return array(
            'latitude' => 48.69,
            'longitude' => 2.18,
            'draggable' => true,
            'zoom' => 12,
            'zoomControl' => true,
            'height' => 300
        );
    }

    protected function init() {
        $this->name = 'gmap';
        $this->label = __("Google Map", "gd-content-tools");
        $this->category = 'maps';
    }

    public function validate($key) {
        $errors = parent::validate($key);

        $this->settings['latitude'] = floatval($this->settings['latitude']);
        $this->settings['longitude'] = floatval($this->settings['longitude']);

        $this->settings['draggable'] = $this->settings['draggable'] == 'on';
        $this->settings['zoomControl'] = $this->settings['zoomControl'] == 'on';
        $this->settings['zoom'] = absint($this->settings['zoom']);

        return $errors;
    }

    public function get_default_value() {
        return array(
            'latitude' => $this->s('latitude'),
            'longitude' => $this->s('longitude'),
            'zoom' => $this->s('zoom'),
            'zoomControl' => $this->s('zoomControl'),
            'height' => $this->s('height'),
            'draggable' => $this->s('draggable'),
            'note' => 'Map Marker'
        );
    }

    public function process($input) {
        parent::process($input);

        if (is_null($input)) {
            return;
        }

        foreach ($input as $item) {
            if (!empty($item)) {
                $this->process[] = array(
                    'latitude' => floatval($item['latitude']),
                    'longitude' => floatval($item['longitude']),
                    'zoom' => absint($item['zoom']),
                    'height' => absint($item['height']),
                    'note' => d4p_sanitize_extended($item['note'], wp_kses_allowed_html(), array(), true)
                );
            }
        }
    }
}

class gdcet_core_basefield_gmap extends gdcet_core_basefield {
    public function render($args = array()) {
        gdcet_meta()->enqueue_front();

        $defaults = array('before' => '', 'after' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $_settings = $this->value;

        $render = '<div class="gdcet-gmap-wrapper">';
        $render.= '<div class="gdcet-gmap-container" style="height: '.$_settings['height'].'px"></div>';
        $render.= '<script class="gdcet-gmap-settings" type="application/json">'.json_encode($_settings).'</script>';
        $render.= '</div>';

        return $args['before'].$render.$args['after'];
    }
}
