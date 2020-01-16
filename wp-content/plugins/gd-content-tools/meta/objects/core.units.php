<?php

if (!defined('ABSPATH')) exit;

gdcet_load_units();

global $_gdcet_core_units;
$_gdcet_core_units = d4pLib_Units::instance();

function gdcet_units() {
    global $_gdcet_core_units;
    return $_gdcet_core_units;
}

function gdcet_unit_format($type, $value, $unit, $args = array()) {
    $defaults = array('format' => '%value% %sign%', 'decimals' => true);
    $args = wp_parse_args($args, $defaults);

    $sign = gdcet_units()->get_unit_type_display($type, $unit);

    if ($args['decimals'] === false) {
        $value = number_format($value, 0);
    } else if ($args['decimals'] !== true) {
        $value = number_format($value, $args['decimals']);
    }

    return str_replace(array('%value%', '%sign%', '%unit%'), array($value, $sign, $unit), $args['format']);
}