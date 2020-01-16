<?php

if (!defined('ABSPATH')) exit;

/* Conditions */
function gdcet_is_archive_intersection($post_type = '') {
    global $wp_query;

    if (isset($wp_query->is_cpt_archive_intersection) && $wp_query->is_cpt_archive_intersection) {
        if (empty($post_type) || $post_type == get_query_var('post_type')) {
            return true;
        }
    }

    return false;
}

function gdcet_is_date_intersection($post_type = '') {
    global $wp_query;

    if (isset($wp_query->is_cpt_date_intersection) && $wp_query->is_cpt_date_intersection) {
        if (empty($post_type) || $post_type == get_query_var('post_type')) {
            return true;
        }
    }

    return false;
}

function gdcet_is_author_intersection($post_type = '') {
    global $wp_query;

    if (isset($wp_query->is_cpt_author_intersection) && $wp_query->is_cpt_author_intersection) {
        if (empty($post_type) || $post_type == get_query_var('post_type')) {
            return true;
        }
    }

    return false;
}

function gdcet_get_archive_intersections() {
    global $wp_query;

    if (isset($wp_query->is_cpt_archive_intersection) && $wp_query->is_cpt_archive_intersection) {
        return (object)$wp_query->cpt_intersection;
    }

    return false;
}

/* Checks */
function gdcet_has_post_type_date_archives($post_type) {
    return isset(gdcet_ctrl()->rewriter->rules['post_type']['date_archives'][$post_type]);
}

function gdcet_has_post_type_author_archives($post_type) {
    return isset(gdcet_ctrl()->rewriter->rules['post_type']['author_archives'][$post_type]);
}

function gdcet_has_post_type_intersections($post_type, $type = null) {
    if (isset(gdcet_ctrl()->rewriter->rules['post_type']['intersect_archives'][$post_type])) {
        if ($type == 'custom') {
            return gdcet_ctrl()->rewriter->rules['post_type']['intersect_archives'][$post_type]['custom'];
        } else if ($type == 'simple') {
            return gdcet_ctrl()->rewriter->rules['post_type']['intersect_archives'][$post_type]['simple'];
        }

        return true;
    } else {
        return false;
    }
}

function gdcet_post_type_baseless_taxonomy($post_type) {
    if (isset(gdcet_ctrl()->rewriter->rules['post_type']['intersect_archives'][$post_type])) {
        return gdcet_ctrl()->rewriter->rules['post_type']['intersect_archives'][$post_type]['baseless'];
    }

    return false;
}

function gdcet_post_type_custom_intersection($post_type) {
    if (isset(gdcet_ctrl()->rewriter->rules['post_type']['intersect_archives'][$post_type])) {
        return gdcet_ctrl()->rewriter->rules['post_type']['intersect_archives'][$post_type]['custom'];
    }

    return false;
}

function gdcet_post_type_author_intersection_slug($post_type) {
    if (isset(gdcet_ctrl()->rewriter->rules['post_type']['author_archives'][$post_type])) {
        return gdcet_ctrl()->rewriter->rules['post_type']['author_archives'][$post_type]['slug'];
    }

    return false;
}

/* Links */
function gdcet_get_date_archive_link($post_type, $year = 0, $month = 0, $day = 0) {
    $url = get_post_type_archive_link($post_type);

    if (d4p_permalinks_enabled()) {
        $url = trailingslashit($url);

        if ($year > 0) {
            $url.= $year.'/';

            if ($month > 0) {
                $url.= str_pad($month, 2, '0', STR_PAD_LEFT).'/';

                if ($day > 0) {
                    $url.= str_pad($day, 2, '0', STR_PAD_LEFT).'/';
                }
            }
        }
    } else {
        if ($year > 0) {
            $url = add_query_arg('year', $year, $url);

            if ($month > 0) {
                $url = add_query_arg('monthnum', $month, $url);

                if ($day > 0) {
                    $url = add_query_arg('day', $day, $url);
                }
            }
        }
    }

    return $url;
}

function gdcet_get_author_archive_link($post_type, $author_name) {
    $url = get_post_type_archive_link($post_type);

    if (d4p_permalinks_enabled()) {
        $slug = gdcet_post_type_author_intersection_slug($post_type);

        $url = trailingslashit($url).$slug.'/'.$author_name.'/';
    } else {
        $url = add_quotes('author_name', $author_name, $url);
    }

    return $url;
}

function gdcet_get_intersection_link($post_type, $taxonomy, $term) {
    $url = get_post_type_archive_link($post_type);

    if (!gdcet_has_post_type_intersections($post_type)) {
        return $url;
    }

    $term = get_term($term, $taxonomy);

    if (!($term instanceof WP_Term)) {
        $term = new WP_Error('invalid_term', __("Empty Term", "gd-content-tools"));
    }

    if (is_wp_error($term)) {
        return $term;
    }

    if ($url === false) {
        return get_term_link($term, $taxonomy);
    } else {
        if (d4p_permalinks_enabled()) {
            $slug = '';

            if (gdcet_post_type_baseless_taxonomy($post_type) != $taxonomy) {
                $tax = get_taxonomy($taxonomy);
                $slug = isset($tax->rewrite['slug']) ? $tax->rewrite['slug'] : '';
                $_list = explode('/', $slug);
                $slug = end($_list).'/';
            }

            return trailingslashit($url).$slug.$term->slug.'/';
        } else {
            return add_query_arg($taxonomy, $term->slug, $url);
        }
    }
}

function gdcet_get_advanced_intersection_link($post_type, $terms) {
    $url = get_post_type_archive_link($post_type);

    if (!gdcet_has_post_type_intersections($post_type)) {
        return $url;
    }

    $rule = gdcet_post_type_custom_intersection($post_type);

    if ($rule == '') {
        return $url;
    }

    $error = false;
    foreach ($terms as $taxonomy => $term) {
        if (is_int($term)) {
            $terms[$taxonomy] = get_term($term, $taxonomy);
        } else {
            $terms[$taxonomy] = get_term_by('slug', $term, $taxonomy);
        }

        if (!is_object($terms[$taxonomy])) {
            $terms[$taxonomy] = new WP_Error('invalid_term', __("Empty Term", "gd-content-tools"));
        }

        if (is_wp_error($terms[$taxonomy])) {
            $error = true;
        }
    }

    if ($error) {
        return $terms;
    }

    $parts = explode('/', trim($rule, '/'));
    $elements = array();

    foreach ($parts as $part) {
        $elements[] = trim($part, '%');
    }

    if (get_option('permalink_structure')) {
        $url = trailingslashit($url);

        foreach ($elements as $tax) {
            $url.= $terms[$tax]->slug.'/';
        }
    } else {
        foreach ($elements as $tax) {
            $url = add_query_arg($tax, $terms[$tax]->slug, $url);
        }
    }

    return $url;
}
