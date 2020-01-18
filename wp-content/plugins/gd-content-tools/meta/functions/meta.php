<?php

if (!defined('ABSPATH')) exit;

function gdcet_meta_register_category($category, $label) {
    gdcet_meta()->register_category($category, $label);
}

function gdcet_meta_register_basic_field($category, $name, $label, $path = null) {
    gdcet_meta()->register_basic_field($category, $name, $label, $path);
}

function gdcet_meta_is_basic_field_registered($name) {
    return in_array($name, gdcet_meta()->fields_names);
}

function gdcet_meta_get_basic_field($type = 'text', $data = array()) {
    if (gdcet_meta_is_basic_field_registered($type)) {
        $class_name = 'gdcet_meta_core_field_'.str_replace('-', '_', $type);

        return new $class_name($data);
    }

    return null;
}

function gdcet_meta_basic_fields_select_list() {
    $list = array();

    foreach (gdcet_meta()->fields as $category => $fields) {
        if (!isset($list[$category])) {
            $list[$category] = array(
                'title' => gdcet_meta()->categories[$category]['label'],
                'values' => array()
            );
        }

        foreach ($fields as $field) {
            $list[$category]['values'][$field['name']] = array('label' => $field['label'], 'data-icon' => $field['icon']);
        }
    }

    return $list;
}

function gdcet_sanitize_field_slug($text) {
    return trim(sanitize_title_with_dashes(stripslashes($text)), "- \t\n\r\0\x0B");
}
