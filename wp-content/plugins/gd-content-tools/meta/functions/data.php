<?php

if (!defined('ABSPATH')) exit;

/** @return gdcet_core_metabox  */
function gdcet_metabox($meta_box, $type = 'post', $id = 0) {
    return gdcet_core_metabox::instance($meta_box, $type, $id);
}

function gdcet_metabox_by_id($meta_box_id, $type = 'post', $id = 0) {
    $meta_box = gdcet_meta()->get_box_name_by_id($meta_box_id);
    return gdcet_core_metabox::instance($meta_box, $type, $id);
}

/** @global gdcet_core_metafield_custom|gdcet_core_metafield_simple $_gdcet_field */
function gdcet_the_field() {
    global $_gdcet_field;

    return $_gdcet_field;
}

/** @global gdcet_core_metafield_custom|gdcet_core_metafield_simple $_gdcet_field */
function gdcet_get_the_field_slug() {
    global $_gdcet_field;

    return $_gdcet_field->slug;
}

function gdcet_the_field_slug() {
    echo gdcet_get_the_field_slug();
}

/** @global gdcet_core_metafield_custom|gdcet_core_metafield_simple $_gdcet_field */
function gdcet_get_the_field_label($args = array()) {
    global $_gdcet_field;

    return $_gdcet_field->get_label($args);
}

function gdcet_the_field_label($args = array()) {
    echo gdcet_get_the_field_label($args);
}

/** @global gdcet_core_metafield_custom|gdcet_core_metafield_simple $_gdcet_field */
function gdcet_get_the_field_description($args = array()) {
    global $_gdcet_field;

    return $_gdcet_field->get_description($args);
}

function gdcet_the_field_description($args = array()) {
    echo gdcet_get_the_field_description($args);
}

/** @global gdcet_core_basefield $_gdcet_sub_field */
function gdcet_the_sub_field() {
    global $_gdcet_sub_field;

    return $_gdcet_sub_field;
}

/** @global gdcet_core_basefield $_gdcet_sub_field */
function gdcet_get_the_sub_field_slug() {
    global $_gdcet_sub_field;

    return $_gdcet_sub_field->slug;
}

function gdcet_the_sub_field_slug() {
    echo gdcet_get_the_sub_field_slug();
}

/** @global gdcet_core_basefield $_gdcet_sub_field */
function gdcet_get_the_sub_field_label($args = array()) {
    global $_gdcet_sub_field;

    return $_gdcet_sub_field->get_label($args);
}

function gdcet_the_sub_field_label($args = array()) {
    echo gdcet_get_the_sub_field_label($args);
}

/** @global gdcet_core_basefield $_gdcet_sub_field */
function gdcet_get_the_sub_field_description($args = array()) {
    global $_gdcet_sub_field;

    return $_gdcet_sub_field->get_description($args);
}

function gdcet_the_sub_field_description($args = array()) {
    echo gdcet_get_the_sub_field_description($args);
}
