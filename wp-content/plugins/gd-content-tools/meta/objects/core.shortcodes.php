<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_shortcodes extends d4p_shortcodes_core {
    public $prefix = 'gdcet';
    public $shortcake_title = 'GD Content Tools Pro';

    public function init() {
        $this->shortcodes = array(
            'metabox_template' => array(
                'name' => __("Metabox with Template", "gd-content-tools"),
                'atts' => array('template' => 'gdcet-metabox-render-default.php', 'type' => 'post', 'id' => 0, 'metabox' => '', 'wrapper_class' => '')
            ),
            'meta_field' => array(
                'name' => __("Meta Field", "gd-content-tools"),
                'atts' => array('wrapper_tag' => '', 'wrapper_class' => '', 'type' => 'post', 'id' => 0, 'metabox' => '', 'field' => '')
            ),
            'meta_sub_field' => array(
                'name' => __("Meta Subfield", "gd-content-tools"),
                'atts' => array('wrapper_tag' => '', 'wrapper_class' => '', 'type' => 'post', 'id' => 0, 'metabox' => '', 'field' => '', 'sub_field' => '')
            )
        );
    }

    public function _base_atts($code, $atts = array()) {
        $defaults = $this->shortcodes[$code]['atts'];

        return wp_parse_args($atts, $defaults);
    }

    public function shortcode_metabox_template($atts) {
        $name = 'metabox_template';

        if ($this->in_shortcake_preview($name)) {
            return $this->shortcake_preview($atts, $name);
        }

        $atts = $this->_base_atts($name, $atts);

        gdcet()->load_embed();

        $value = _gdcet_render_metabox_template($atts);

        return $this->_wrapper($value, $name, $atts['wrapper_class'], 'div');
    }

    public function shortcode_meta_field($atts) {
        $name = 'meta_field';

        if ($this->in_shortcake_preview($name)) {
            return $this->shortcake_preview($atts, $name);
        }

        $atts = $this->_base_atts($name, $atts);

        gdcet()->load_embed();

        $value = _gdcet_embed_meta_field($atts);

        if ($atts['wrapper_tag'] == '') {
            return $value;
        } else {
            return $this->_wrapper($value, $name, $atts['wrapper_class'], $atts['wrapper_tag']);
        }
    }

    public function shortcode_meta_sub_field($atts) {
        $name = 'meta_sub_field';

        if ($this->in_shortcake_preview($name)) {
            return $this->shortcake_preview($atts, $name);
        }

        $atts = $this->_base_atts($name, $atts);

        gdcet()->load_embed();

        $value = _gdcet_embed_meta_subfield($atts);

        if ($atts['wrapper_tag'] == '') {
            return $value;
        } else {
            return $this->_wrapper($value, $name, $atts['wrapper_class'], $atts['wrapper_tag']);
        }
    }
}

global $_gdcet_shortcodes;

$_gdcet_shortcodes = new gdcet_core_shortcodes();
