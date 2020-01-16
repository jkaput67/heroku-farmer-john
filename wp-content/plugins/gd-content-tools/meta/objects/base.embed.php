<?php

if (!defined('ABSPATH')) exit;

function _gdcet_embed_meta_field($args = array()) {
    $defaults = array(
        'metabox' => '', 
        'field' => '',
        'index' => 0,
        'raw' => false,
        'type' => 'post',
        'id' => 0
    );

    $atts = wp_parse_args($args, $defaults);

    $_box = gdcet_metabox($atts['metabox'], $atts['type'], $atts['id']);
    $_field = $_box->field($atts['field']);

    if (is_wp_error($_field)) {
        return $_field->get_error_message();
    }

    $_field->value($atts['index']);

    if ($atts['raw']) {
        return $_field->raw();
    } else {
        return $_field->render($atts);
    }
}

function _gdcet_embed_meta_subfield($args = array()) {
    $defaults = array(
        'metabox' => '', 
        'field' => '',
        'index' => 0,
        'sub_field' => '',
        'sub_index' => 0,
        'raw' => false,
        'type' => 'post',
        'id' => 0
    );

    $atts = wp_parse_args($args, $defaults);

    $_box = gdcet_metabox($atts['metabox'], $atts['type'], $atts['id']);
    $_field = $_box->field($atts['field']);

    if (is_wp_error($_field)) {
        return $_field->get_error_message();
    }

    $_field->value($atts['index']);

    $_sub_field = $_field->sub_field($atts['sub_field']);

    if (is_wp_error($_field)) {
        return $_field->get_error_message();
    }

    $_sub_field->value($atts['sub_index']);

    if ($atts['raw']) {
        return $_sub_field->raw();
    } else {
        return $_sub_field->render($atts);
    }
}

function _gdcet_render_metabox_template($args = array()) {
    $defaults = array(
        'template' => 'gdcet-metabox-render-default.php', 
        'metabox' => '',
        'type' => 'post',
        'id' => 0
    );

    $atts = wp_parse_args($args, $defaults);

    $metabox = gdcet_metabox($atts['metabox'], $atts['type'], $atts['id']);
    $template = gdcet_get_template_part($atts['template'], 'gdcet-metabox-render-default.php');

    ob_start();

    include($template);

    $render = ob_get_contents();

    ob_end_clean();

    return $render;
}
