<?php

if (!defined('ABSPATH')) exit;

function gdcet_post_type_has_archives($post_type) {
    $cpt = get_post_type_object($post_type);

    if (is_null($cpt)) {
        return false;
    }

    return $cpt->has_archive === false ? false : true;
}

function gdcet_get_custom_post_templates() {
    $theme = wp_get_theme();
    $templates = $theme->get_files('php', 1, true);

    $post_templates = array();

    $base = array(trailingslashit(get_template_directory()), trailingslashit(get_stylesheet_directory()));

    foreach ((array)$templates as $template) {
        $template = WP_CONTENT_DIR.str_replace(WP_CONTENT_DIR, '', $template);
        $basename = str_replace($base, '', $template);

        if (false !== strpos($basename, '/')) continue;

        $template_data = implode('', file( $template ));

        $name = '';
        if (preg_match( '|Post Template:(.*)$|mi', $template_data, $name)) {
            $name = _cleanup_header_comment($name[1]);
        }

        if (!empty($name)) {
            if(basename($template) != basename(__FILE__)) {
                $post_templates[$basename] = trim($name);
            }
        }
    }

    return $post_templates;
}

function gdcet_get_current_post_type() {
    global $wp_query;

    if (!isset($wp_query)) {
        return null;
    }

    if (is_post_type_archive()) {
        return $wp_query->get_queried_object();
    } else if (is_singular()) {
        $post_obj = $wp_query->get_queried_object();

        return get_post_type_object($post_obj->post_type);
    } else {
        return null;
    }
}

function gdcet_get_post_types($args = array(), $output = 'names') {
    $defaults = array('public' => null, 'hierarchical' => null, 'builtin' => null, 
        'show_ui' => null, 'has_archive' => null, 'has_taxonomies' => null);

    $args = wp_parse_args($args, $defaults);

    $list = array();

    global $wp_post_types;

    foreach ($wp_post_types as $cpt => $post_type) {
        $add = true;

        if (isset($args['public']) && !is_null($args['public'])) {
            $add = $args['public'] === true && $post_type->public === true;
        }

        if ($add && isset($args['hierarchical']) && !is_null($args['hierarchical'])) {
            $add = $args['hierarchical'] === true && $post_type->hierarchical === true;
        }

        if ($add && isset($args['builtin']) && !is_null($args['builtin'])) {
            $add = $args['builtin'] === true && $post_type->_builtin === true;
        }

        if ($add && isset($args['show_ui']) && !is_null($args['show_ui'])) {
            $add = $args['show_ui'] === true && $post_type->show_ui === true;
        }

        if ($add && isset($args['has_archive']) && !is_null($args['has_archive'])) {
            $add = $args['has_archive'] === true && $post_type->has_archive !== false;
        }

        if ($add && isset($args['has_taxonomies']) && !is_null($args['has_taxonomies'])) {
            $tax = get_object_taxonomies($cpt);
            $add = $args['has_taxonomies'] === true && !empty($tax);
        }

        if ($add) {
            switch ($output) {
                case 'object':
                    $list[$cpt] = $post_type;
                    break;
                case 'list':
                    $list[$cpt] = $post_type->label;
                    break;
                default:
                case 'names':
                    $list[$cpt] = $cpt;
                    break;
            }
        }
    }

    return $list;
}
