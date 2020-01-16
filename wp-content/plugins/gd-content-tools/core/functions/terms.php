<?php

if (!defined('ABSPATH')) exit;

function gdcet_get_terms($taxonomies, $args = '') {
    global $wpdb;

    $single_taxonomy = false;

    if (!is_array($taxonomies)) {
        $single_taxonomy = true;
        $taxonomies = array($taxonomies);
    }

    foreach ((array)$taxonomies as $taxonomy) {
        if (!taxonomy_exists($taxonomy)) {
            return new WP_Error("invalid_taxonomy", __("Invalid Taxonomy", "gd-content-tools"));
        }
    }

    $defaults = array('orderby' => 'name', 'order' => 'ASC', 'post_types' => array(),
        'hide_empty' => true, 'exclude' => array(), 'exclude_tree' => array(), 
        'include' => array(), 'number' => '', 'fields' => 'all', 'slug' => '', 
        'parent' => '', 'hierarchical' => true, 'child_of' => 0, 'get' => '', 
        'name__like' => '', 'pad_counts' => false, 'offset' => '', 'search' => '');

    $args = wp_parse_args($args, $defaults);

    if (!is_array($args['post_types'])) {
        if (!empty($args['post_types'])) {
            $args['post_types'] = (array)$args['post_types'];
        } else {
            $args['post_types'] = array();
        }
    }

    $args['number'] = absint( $args['number'] );
    $args['offset'] = absint( $args['offset'] );

    if (!$single_taxonomy || !is_taxonomy_hierarchical($taxonomies[0]) || '' !== $args['parent'] ) {
        $args['child_of'] = 0;
        $args['hierarchical'] = false;
        $args['pad_counts'] = false;
    }

    if ('all' == $args['get']) {
        $args['child_of'] = 0;
        $args['hide_empty'] = 0;
        $args['hierarchical'] = false;
        $args['pad_counts'] = false;
    }

    extract($args, EXTR_SKIP);

    $in_post_types = "'".implode("', '", $post_types)."'";
    $in_taxonomies = "'".implode("', '", $taxonomies)."'";

    if ($child_of) {
        $hierarchy = _get_term_hierarchy($taxonomies[0]);

        if (!isset($hierarchy[$child_of])) {
            return array();
        }
    }

    if ($parent) {
        $hierarchy = _get_term_hierarchy($taxonomies[0]);

        if (!isset($hierarchy[$parent])) {
            return array();
        }
    }

    $key = md5(serialize(compact(array_keys($defaults))).serialize($taxonomies));
    $last_changed = wp_cache_get('last_changed', 'gdcet_terms');

    if (!$last_changed) {
        $last_changed = time();
        wp_cache_set('last_changed', $last_changed, 'gdcet_terms');
    }

    $cache_key = "gdcet_get_terms:$key:$last_changed";
    $cache = wp_cache_get($cache_key, 'gdcet_terms');

    if (false !== $cache) {
        $cache = apply_filters('gdcet_get_terms', $cache, $taxonomies, $args);

        return $cache;
    }

    $_orderby = strtolower($orderby);

    if ('count' == $_orderby && empty($post_types)) {
        $orderby = 'tt.count';
    }

    if ('count' == $_orderby && !empty($post_types)) {
        $orderby = 'count(*)';
    } else if ('name' == $_orderby) {
        $orderby = 't.name';
    } else if ('slug' == $_orderby) {
        $orderby = 't.slug';
    } else if ('term_group' == $_orderby) {
        $orderby = 't.term_group';
    } else if ('rand' == $_orderby) {
        $orderby = 'rand()';
        $order = '';
    } else if ('none' == $_orderby) {
        $orderby = '';
    } else if (empty($_orderby) || 'id' == $_orderby) {
        $orderby = 't.term_id';
    }

    $orderby = apply_filters('gdcet_get_terms_orderby', $orderby, $args);

    if (!empty($orderby)) {
        $orderby = 'ORDER BY '.$orderby;
    } else {
        $order = '';
    }

    $where = $group_by = $inclusions = '';
    if (!empty($post_types)) {
        $group_by = ' GROUP BY t.term_id';
    }

    if (!empty($include)) {
        $exclude = $exclude_tree = '';
        $interms = wp_parse_id_list($include);

        foreach ($interms as $interm) {
            if (empty($inclusions)) {
                $inclusions = ' AND (t.term_id = '.intval($interm).' ';
            } else {
                $inclusions.= ' OR t.term_id = '.intval($interm).' ';
            }
        }
    }

    if (!empty($inclusions)) {
        $inclusions.= ')';
    }

    $where.= $inclusions;
    $exclusions = '';

    if (!empty($exclude_tree)) {
        $excluded_trunks = wp_parse_id_list($exclude_tree);

        foreach ($excluded_trunks as $extrunk) {
            $excluded_children = (array)get_terms($taxonomies[0], array('child_of' => absint($extrunk), 'fields' => "ids"));
            $excluded_children[] = $extrunk;

            foreach($excluded_children as $exterm) {
                if (empty($exclusions)) {
                    $exclusions = ' AND ( t.term_id <> '.absint($exterm).' ';
                } else {
                    $exclusions.= ' AND t.term_id <> '.absint($exterm).' ';
                }
            }
        }
    }

    if (!empty($exclude)) {
        $exterms = wp_parse_id_list($exclude);

        foreach ($exterms as $exterm) {
            if (empty($exclusions)) {
                $exclusions = ' AND ( t.term_id <> '.absint($exterm).' ';
            } else {
                $exclusions.= ' AND t.term_id <> '.absint($exterm).' ';
            }
        }
    }

    if (!empty($exclusions)) {
        $exclusions.= ')';
    }

    $where.= $exclusions;

    if (!empty($slug)) {
        $slug = sanitize_title($slug);
        $where.= " AND t.slug = '$slug'";
    }

    if (!empty($name__like)) {
        $where.= " AND t.name LIKE '{$name__like}%'";
    }

    if ('' !== $parent) {
        $parent = (int) $parent;
        $where.= " AND tt.parent = '$parent'";
    }

    if ($hide_empty && !$hierarchical) {
        if (empty($post_types)) {
            $where.= ' AND tt.count > 0';
        } else {
            $group_by.= ' HAVING count(*) > 0';
        }
    }

    if (!empty($number) && !$hierarchical && empty($child_of) && "" === $parent) {
        if ($offset) {
            $limit = 'LIMIT '.$offset.', '.$number;
        } else {
            $limit = 'LIMIT '.$number;
        }
    } else {
        $limit = '';
    }

    if (!empty($search)) {
        $search = like_escape($search);
        $where.= " AND (t.name LIKE '%$search%')";
    }

    if (!empty($post_types)) {
        $where.= " AND p.post_type in ($in_post_types)";
    }

    $selects = array();
    switch ($fields) {
        case 'all':
            if (empty($post_types)) {
                $selects = array('t.*', 'tt.*');
            } else {
                $selects = array('t.*', 'tt.term_taxonomy_id', 'tt.taxonomy', 'tt.description', 'tt.parent', 'count(*) as count');
            }
            break;
        case 'ids':
        case 'id=>parent':
            if (empty($post_types)) {
                $selects = array('t.term_id', 'tt.parent', 'tt.count');
            } else {
                $selects = array('t.term_id', 'tt.parent', 'count(*) as count');
            }
            break;
        case 'names':
            if (empty($post_types)) {
                $selects = array('t.term_id', 'tt.parent', 'tt.count', 't.name');
            } else {
                $selects = array('t.term_id', 'tt.parent', 'count(*) as count', 't.name');
            }
            break;
        case 'count':
           $orderby = '';
           $order = '';
           $selects = array('COUNT(*)');
           break;
    }

    $select_this = implode(', ', apply_filters('get_terms_fields', $selects, $args));

    if (empty($post_types)) {
        $query = "SELECT $select_this FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ($in_taxonomies) $where $orderby $order $limit";
    } else {
        $query = "SELECT $select_this FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id INNER JOIN $wpdb->term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN $wpdb->posts AS p ON p.ID = tr.object_id WHERE tt.taxonomy IN ($in_taxonomies) $where $group_by $orderby $order $limit";
    }

    if ('count' == $fields) {
        return $wpdb->get_var($query);
    }

    $terms = $wpdb->get_results($query);

    if ('all' == $fields) {
        update_term_cache($terms);
    }

    if (empty($terms)) {
        wp_cache_add($cache_key, array(), 'gdcet_terms');

        return apply_filters('gdcet_get_terms', array(), $taxonomies, $args);
    }

    if ($child_of) {
        $children = _get_term_hierarchy($taxonomies[0]);

        if (!empty($children)) {
            $terms = & _get_term_children($child_of, $terms, $taxonomies[0]);
        }
    }

    if ($pad_counts && 'all' == $fields) {
        _pad_term_counts($terms, $taxonomies[0]);
    }

    if ($hierarchical && $hide_empty && is_array($terms)) {
        foreach ($terms as $k => $term) {
            if (!$term->count) {
                $children = _get_term_children($term->term_id, $terms, $taxonomies[0]);

                if (is_array($children)) {
                    foreach ($children as $child) {
                        if ($child->count) {
                            continue 2;
                        }
                    }
                }

                unset($terms[$k]);
            }
        }
    }

    reset($terms);

    $_terms = array();
    if ('id=>parent' == $fields) {
        while ($term = array_shift($terms)) {
            $_terms[$term->term_id] = $term->parent;
        }

        $terms = $_terms;
    } else if ('ids' == $fields) {
        while ($term = array_shift($terms)) {
            $_terms[] = $term->term_id;
        }

        $terms = $_terms;
    } else if ('names' == $fields) {
        while ($term = array_shift($terms)) {
            $_terms[] = $term->name;
        }

        $terms = $_terms;
    }

    if (0 < $number && intval(@count($terms)) > $number) {
        $terms = array_slice($terms, $offset, $number);
    }

    wp_cache_add($cache_key, $terms, 'gdcet_terms');

    return apply_filters('gdcet_get_terms', $terms, $taxonomies, $args);
}

function gdcet_generate_terms_cloud($terms, $args = '') {
    $defaults = array(
        'format' => 'flat', 'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 0,
        'orderby' => 'name', 'order' => 'ASC', 'topic_count_text_callback' => null,
        'ignore_font_sizes' => false, 'topic_count_text' => null, 'separator' => "\n",
        'topic_count_scale_callback' => 'default_topic_count_scale'
    );

    $args = wp_parse_args($args, $defaults);

    $return = 'array' === $args['format'] ? array() : '';

    if (empty($terms)) {
        return $return;
    }

    if (isset($args['topic_count_text'])) {
        $translate_nooped_plural = $args['topic_count_text'];
    } else if (!empty($args['topic_count_text_callback'])) {
        if ($args['topic_count_text_callback'] === 'default_topic_count_text') {
            $translate_nooped_plural = _n_noop('%s topic', '%s topics');
        } else {
            $translate_nooped_plural = false;
        }
    } else if (isset($args['single_text']) && isset($args['multiple_text'])) {
        $translate_nooped_plural = _n_noop($args['single_text'], $args['multiple_text']);
    } else {
        $translate_nooped_plural = _n_noop('%s topic', '%s topics');
    }

    if ('RAND' === $args['order']) {
        shuffle( $terms );
    } else {
        if ('name' === $args['orderby']) {
            uasort($terms, '_wp_object_name_sort_cb');
        } else {
            uasort($terms, '_wp_object_count_sort_cb');
        }

        if ('DESC' === $args['order']) {
            $terms = array_reverse($terms, true);
        }
    }

    if ($args['number'] > 0 && count($terms) > $args['number']) {
        $terms = array_slice($terms, 0, $args['number']);
    }

    $counts = array();
    $real_counts = array();

    foreach ((array)$terms as $key => $tag) {
        $real_counts[$key] = $tag->count;
        $counts[$key] = call_user_func($args['topic_count_scale_callback'], $tag->count);
    }

    $min_count = min($counts);
    $spread = max($counts) - $min_count;

    if ($spread <= 0) {
        $spread = 1;
    }

    $font_spread = $args['largest'] - $args['smallest'];

    if ($font_spread < 0) {
        $font_spread = 1;
    }

    $font_step = $font_spread / $spread;

    $tags_data = array();

    foreach ($terms as $key => $tag) {
        $tag_id = isset($tag->id) ? $tag->id : $key;

        $count = $counts[$key];
        $real_count = $real_counts[$key];

        if ($translate_nooped_plural) {
            $title = sprintf(translate_nooped_plural($translate_nooped_plural, $real_count), number_format_i18n($real_count));
        } else {
            $title = call_user_func($args['topic_count_text_callback'], $real_count, $tag, $args);
        }

        $tags_data[] = array(
            'id'         => $tag_id,
            'url'        => '#' != $tag->link ? $tag->link : '#',
            'name'	     => $tag->name,
            'title'      => $title,
            'slug'       => $tag->slug,
            'real_count' => $real_count,
            'class'	     => trim($tag->class.' tag-link-'.$tag_id),
            'font_size'  => $args['smallest'] + ($count - $min_count) * $font_step,
        );
    }

    $a = array();

    foreach ($tags_data as $key => $tag_data) {
        $class = $tag_data['class'].' tag-link-position-'.($key + 1);
        $style = '';

        if ($args['ignore_font_sizes'] === false) {
            $style = 'font-size: '.esc_attr(str_replace(',', '.', $tag_data['font_size']).$args['unit']).';';
        }

        $a[] = "<a href='".esc_url($tag_data['url'])."' class='".esc_attr($class)."' title='".esc_attr($tag_data['title'])."' style='".$style."'>".esc_html($tag_data['name'])."</a>";
    }

    switch ($args['format']) {
        case 'array':
            $return = &$a;
            break;
        case 'list':
            $return = "<ul class='wp-tag-cloud'>\n\t<li>";
            $return.= join("</li>\n\t<li>", $a);
            $return.= "</li>\n</ul>\n";
            break;
        default:
            $return = join($args['separator'], $a);
            break;
    }

    return $return;
}

function gdcet_get_the_term_list($id, $taxonomy, $before = '', $sep = '', $after = '') {
    $terms = get_the_terms($id, $taxonomy);
    $post_type = get_post_type($id);

    if (is_wp_error($terms)) {
        return $terms;
    }

    if (empty($terms)) {
        return false;
    }

    $links = array();

    foreach ($terms as $term) {
        $link = gdcet_get_intersection_link($post_type, $taxonomy, $term);

        if (is_wp_error($link)) {
            return $link;
        }

        $links[] = '<a href="'.esc_url($link).'" rel="tag">' . $term->name . '</a>';
    }

    $term_links = apply_filters( "gdcet_term_links-{$post_type}-{$taxonomy}", $links);

    return $before.join($sep, $term_links).$after;
}
