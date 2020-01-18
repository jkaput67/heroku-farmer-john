<?php

if (!defined('ABSPATH')) exit;

function gdcet_get_term_id($term, $taxonomy = '') {
    if (empty($term)) {
        return false;
    }

    if (is_numeric($term)) {
        return intval($term);
    } else if (is_object($term)) {
        return intval($term->term_id);
    } else if (is_string($term)) {
        $term = get_term_by('slug', $term, $taxonomy);

        if ($term) {
            return intval($term->term_id);
        } else {
            $term = get_term_by('name', $term, $taxonomy);

            if ($term) {
                return intval($term->term_id);
            } else {
                return false;
            }
        }
    }

    return false;
}

function gdcet_get_term_taxonomy($term) {
    if (empty($term)) {
        return false;
    }

    $obj = null;
    
    if (is_numeric($term) || is_object($term)) {
        $obj = get_term(intval($term));
    } else if (is_string($term)) {
        $obj = get_term_by('slug', $term);

        if (!$obj) {
            $obj = get_term_by('name', $term);
        }
    }

    if ($obj && !is_wp_error($obj)) {
        return $obj->taxonomy;
    }

    return false;
}

function gdcet_get_current_taxonomy() {
    global $wp_query;

    if (!isset($wp_query)) {
        return null;
    }

    if (is_any_tax()) {
        return $wp_query->get_queried_object();
    } else {
        return null;
    }
}

function gdcet_get_taxonomies($args = array(), $output = 'names') {
    $defaults = array('public' => null, 'hierarchical' => null, 'builtin' => null, 
        'show_tagcloud' => null, 'show_ui' => null, 'has_archive' => null);

    $args = wp_parse_args($args, $defaults);

    $list = array();

    global $wp_taxonomies;

    foreach ($wp_taxonomies as $tax => $taxonomy) {
        $add = true;

        if (isset($args['public']) && !is_null($args['public'])) {
            $add = $taxonomy->public === $args['public'];
        }

        if ($add && isset($args['hierarchical']) && !is_null($args['hierarchical'])) {
            $add = $taxonomy->hierarchical === $args['hierarchical'];
        }

        if ($add && isset($args['show_tagcloud']) && !is_null($args['show_tagcloud'])) {
            $add = $taxonomy->show_tagcloud === $args['show_tagcloud'];
        }

        if ($add && isset($args['builtin']) && !is_null($args['builtin'])) {
            $add = $taxonomy->_builtin === $args['builtin'];
        }

        if ($add && isset($args['show_ui']) && !is_null($args['show_ui'])) {
            $add = $taxonomy->show_ui === $args['show_ui'];
        }

        if ($add && isset($args['has_archive']) && !is_null($args['has_archive'])) {
            if ($args['has_archive']) {
                $add = $taxonomy->has_archive !== false;
            } else {
                $add = $taxonomy->has_archive === false;
            }
        }

        if ($add) {
            switch ($output) {
                case 'object':
                    $list[$tax] = $taxonomy;
                    break;
                case 'list':
                    $list[$tax] = $taxonomy->label;
                    break;
                default:
                case 'names':
                    $list[$tax] = $tax;
                    break;
            }
        }
    }

    return $list;
}

function gdcet_get_term_image($term, $taxonomy = '', $size = 'thumbnail', $get = 'img') {
    $image = '';

    $term_id = gdcet_get_term_id($term, $taxonomy);

    if (empty($taxonomy)) {
        $taxonomy = gdcet_get_term_taxonomy($term);
    }

    if (GDCET_WPV > 43) {
        $image = get_term_meta($term_id, '_gdcet_image', true);

        if ($image == '') {
            $image = gdcet_settings()->legacy_get_term_image($taxonomy, $term_id);
        }
    } else {
        $image = gdcet_settings()->legacy_get_term_image($taxonomy, $term_id);
    }

    if ($image != '' && $image !== false && $image > 0) {
        switch ($get) {
            case 'id':
                return $image;
            case 'url':
                $img = wp_get_attachment_image_src($image, $size);

                return $img[0];
            default:
            case 'img':
                return wp_get_attachment_image($image, $size);
        }
    }

    return false;
}

function gdcet_update_term_image($term, $taxonomy, $image_id) {
    $term_id = gdcet_get_term_id($term, $taxonomy = '');

    if (empty($taxonomy)) {
        $taxonomy = gdcet_get_term_taxonomy($term);
    }

    if (GDCET_WPV > 43) {
        update_term_meta($term_id, '_gdcet_image', $image_id);
    } else {
        gdcet_settings()->legacy_set_term_image($taxonomy, $term_id, $image_id);
    }
}

function gdcet_delete_term_image($term, $taxonomy) {
    $term_id = gdcet_get_term_id($term, $taxonomy);

    if (empty($taxonomy)) {
        $taxonomy = gdcet_get_term_taxonomy($term);
    }

    if (GDCET_WPV > 43) {
        delete_term_meta($term_id, '_gdcet_image');
    } else {
        gdcet_settings()->legacy_delete_term_image($taxonomy, $term_id);
    }
}
