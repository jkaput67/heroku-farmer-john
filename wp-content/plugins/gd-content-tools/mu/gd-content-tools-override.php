<?php

if (!defined('ABSPATH')) exit;

// Override post type registration
add_filter('gdcet_post_type_registration', 'custom__gdcet_post_type_registration');
function custom__gdcet_post_type_registration($build, $post_type) {
    return $build;
}

// Override taxonomy registration
add_filter('gdcet_taxonomy_registration', 'custom__gdcet_taxonomy_registration');
function custom__gdcet_taxonomy_registration($build, $taxonomy) {
    return $build;
}

// Default list: Genders
add_filter('gdcet_data_list_genders', 'custom__gdcet_data_list_genders');
function custom__gdcet_data_list_genders($list) {
    return $list;
}

// Default list: Continets
add_filter('gdcet_data_list_continets', 'custom__gdcet_data_list_continets');
function custom__gdcet_data_list_continets($list) {
    return $list;
}

// Default list: Countries
add_filter('gdcet_data_list_countries', 'custom__gdcet_data_list_countries');
function custom__gdcet_data_list_countries($list) {
    return $list;
}

// Default list: US States
add_filter('gdcet_data_list_us_states', 'custom__gdcet_data_list_us_states');
function custom__gdcet_data_list_us_states($list) {
    return $list;
}

// Default list: Canada States
add_filter('gdcet_data_list_canada_states', 'custom__gdcet_data_list_canada_states');
function custom__gdcet_data_list_canada_states($list) {
    return $list;
}

// Default list: Months
add_filter('gdcet_data_list_months', 'custom__gdcet_data_list_months');
function custom__gdcet_data_list_months($list) {
    return $list;
}

// Default list: Days of the Week
add_filter('gdcet_data_list_daysweek', 'custom__gdcet_data_list_daysweek');
function custom__gdcet_data_list_daysweek($list) {
    return $list;
}

// Default list: Clothing Sizes
add_filter('gdcet_data_list_clothing_sizes', 'custom__gdcet_data_list_clothing_sizes');
function custom__gdcet_data_list_clothing_sizes($list) {
    return $list;
}

// Default list: Marital Status
add_filter('gdcet_data_list_marital_status', 'custom__gdcet_data_list_marital_status');
function custom__gdcet_data_list_marital_status($list) {
    return $list;
}
