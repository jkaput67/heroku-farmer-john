<?php

if (!defined('ABSPATH')) exit;

function gdcet_terms_cloud($args = array()) {
    $defaults = array(
        'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'echo' => true, 'number' => 45, 
        'post_types' => '', 'order' => 'ASC', 'orderby' => 'name', 'format' => 'flat', 
        'separator' => "\n", 'exclude' => '', 'include' => '', 'link' => 'view', 
        'taxonomy' => 'post_tag', 'mark_current' => true
    );

    $args = wp_parse_args($args, $defaults);

    if (!taxonomy_exists($args['taxonomy'])) {
        return '';
    }

    $tags = gdcet_get_terms($args['taxonomy'], $args);
    $current = array();

    if (empty($tags)) {
        return;
    }

    if ($args['mark_current'] && is_singular()) {
        global $post;

        $_post_terms = wp_get_post_terms($post->ID, $args['taxonomy']);
        $current = wp_list_pluck($_post_terms, 'term_id');
    }

    foreach ($tags as $key => $tag) {
        $link = '';

        if ('edit' == $args['link']) {
            $link = get_edit_term_link($tag->term_id, $args['taxonomy']);
        } else {
            if ($args['post_types'] != '') {
                //if (gdtt_has_post_type_intersections($args['post_types'])) {
                //    $link = gdtt_get_intersection_link($args['post_types'], $tag->taxonomy, $tag);
                //} else {
                    $link = get_term_link($tag, $tag->taxonomy);
                    $link = add_query_arg('post_type', $args['post_types'], $link);
                //}
            } else {
                $link = get_term_link(absint($tag->term_id), $args['taxonomy']);
            }
        }

        if (is_wp_error($link)) {
            return false;
        }

        $tags[$key]->link = $link;
        $tags[$key]->id = $tag->term_id;
        $tags[$key]->class = in_array($tag->term_id, $current) ? 'current' : '';
    }

    $return = gdcet_generate_terms_cloud($tags, $args);

    if ('array' == $args['format'] || empty($args['echo'])) {
        return $return;
    } else {
        echo $return;
    }
}

function gdcet_terms_dropdown($args = '') {
    $defaults = array(
        'show_option_all' => '', 'show_option_none' => '', 'orderby' => 'id',
        'order' => 'ASC', 'show_count' => 0, 'hide_empty' => true, 'child_of' => 0,
        'exclude' => '', 'echo' => true, 'selected' => 0, 'hierarchical' => 0,
        'name' => 'cat', 'id' => '', 'class' => 'postform', 'depth' => 0,
        'tab_index' => 0, 'taxonomy' => 'category', 'hide_if_empty' => false, 
        'option_none_value' => -1, 'value_field' => 'term_id', 'walker' => null,
        'required' => false, 'post_types' => ''
    );

    $defaults['selected'] = is_category() ? get_query_var('cat') : 0;

    $r = wp_parse_args($args, $defaults);
    $option_none_value = $r['option_none_value'];

    if (!isset($r['pad_counts']) && $r['show_count'] && $r['hierarchical']) {
        $r['pad_counts'] = true;
    }

    $tab_index = $r['tab_index'];

    $tab_index_attribute = '';
    if ((int)$tab_index > 0) {
        $tab_index_attribute = " tabindex=\"$tab_index\"";
    }

    $get_terms_args = $r;
    unset($get_terms_args['name']);
    $categories = gdcet_get_terms($r['taxonomy'], $get_terms_args);

    $name = esc_attr($r['name']);
    $class = esc_attr($r['class']);
    $id = $r['id'] ? esc_attr($r['id']) : $name;
    $required = $r['required'] ? 'required' : '';

    if (!$r['hide_if_empty'] || ! empty($categories)) {
        $output = "<select $required name='$name' id='$id' class='$class' $tab_index_attribute>\n";
    } else {
        $output = '';
    }

    if (empty( $categories ) && !$r['hide_if_empty'] && !empty($r['show_option_none'])) {
        $output.= "\t<option value='".esc_attr($option_none_value)."' selected='selected'>".$r['show_option_none']."</option>\n";
    }

    if (!empty( $categories)) {
        if ($r['show_option_all']) {
            $selected = ('0' === strval($r['selected'])) ? " selected='selected'" : '';
            $output .= "\t<option value='0'$selected>".$r['show_option_all']."</option>\n";
        }

        if ( $r['show_option_none'] ) {
            $selected = selected( $option_none_value, $r['selected'], false );
            $output .= "\t<option value='".esc_attr($option_none_value)."'$selected>".$r['show_option_none']."</option>\n";
        }

        if ($r['hierarchical']) {
            $depth = $r['depth'];
        } else {
            $depth = -1;
        }

        if ($r['walker'] === null) {
            require_once(GDCET_PATH.'core/objects/walker.terms_dropdown.php');

            $r['walker'] = new gdcet_walker_terms_dropdown();
        }

        $output.= walk_category_dropdown_tree($categories, $depth, $r);
    }

    if (!$r['hide_if_empty'] || !empty($categories)) {
        $output .= "</select>\n";
    }

    if ($r['echo']) {
        echo $output;
    } else {
        return $output;
    }
}

function gdcet_terms_list($args = '') {
    $defaults = array(
        'child_of' => 0, 'current_category' => 0, 'depth' => 0, 'echo' => true,
        'exclude' => '', 'exclude_tree' => '', 'feed' => '', 'feed_image' => '', 
        'feed_type' => '', 'hide_empty' => true, 'hide_title_if_empty' => false,
        'order' => 'ASC', 'orderby' => 'name', 'style' => 'list', 'show_count' => 0,
        'hierarchical' => true, 'separator' => '<br />', 'taxonomy' => 'category',
        'show_option_all' => '', 'show_option_none' => __("No categories", "gd-content-tools"),
        'title_li' => '', 'use_desc_for_title' => true, 'walker' => null, 
        'post_types' => '', 'class' => ''
    );

    $r = wp_parse_args($args, $defaults);

    if (!isset($r['pad_counts']) && $r['show_count'] && $r['hierarchical']) {
        $r['pad_counts'] = true;
    }

    if (true == $r['hierarchical']) {
        $exclude_tree = array();

        if ($r['exclude_tree']) {
            $exclude_tree = array_merge($exclude_tree, wp_parse_id_list($r['exclude_tree']));
        }

        if ($r['exclude']) {
            $exclude_tree = array_merge($exclude_tree, wp_parse_id_list($r['exclude']));
        }

        $r['exclude_tree'] = $exclude_tree;
        $r['exclude'] = '';
        $r['hide_empty'] = false;
    }

    if (!taxonomy_exists($r['taxonomy'])) {
        return false;
    }

    $show_option_all = $r['show_option_all'];
    $show_option_none = $r['show_option_none'];

    $terms = gdcet_get_terms($r['taxonomy'], $r);

    $output = '<ul>';
    if ($r['title_li'] && 'list' == $r['style'] && (!empty($terms) || ! $r['hide_title_if_empty'])) {
        $output = '<li class="'.esc_attr($r['class']).'">'.$r['title_li'].'<ul>';
    }

    if (empty($terms)) {
        if (!empty($show_option_none)) {
            if ('list' == $r['style']) {
                $output.= '<li class="cat-item-none">'.$show_option_none.'</li>';
            } else {
                $output.= $show_option_none;
            }
        }
    } else {
        if (!empty($show_option_all)) {
            $posts_page = '';

            $taxonomy_object = get_taxonomy($r['taxonomy']);
            if (!in_array('post', $taxonomy_object->object_type) && !in_array('page', $taxonomy_object->object_type)) {
                foreach ($taxonomy_object->object_type as $object_type) {
                    $_object_type = get_post_type_object($object_type);

                    if (!empty($_object_type->has_archive)) {
                        $posts_page = get_post_type_archive_link($object_type);
                        break;
                    }
                }
            }

            if (!$posts_page) {
                if ('page' == get_option('show_on_front' ) && get_option('page_for_posts')) {
                    $posts_page = get_permalink( get_option('page_for_posts'));
                } else {
                    $posts_page = home_url('/');
                }
            }

            $posts_page = esc_url($posts_page);

            if ('list' == $r['style']) {
                $output.= "<li class='cat-item-all'><a href='$posts_page'>$show_option_all</a></li>";
            } else {
                $output.= "<a href='$posts_page'>$show_option_all</a>";
            }
        }

        if (empty($r['current_category']) && (is_category() || is_tax() || is_tag())) {
            $current_term_object = get_queried_object();

            if ($current_term_object && $r['taxonomy'] === $current_term_object->taxonomy) {
                $r['current_category'] = get_queried_object_id();
            }
        }

        if ($r['hierarchical']) {
            $depth = $r['depth'];
        } else {
            $depth = -1;
        }

        if ($r['walker'] === null) {
            require_once(GDCET_PATH.'core/objects/walker.terms_list.php');

            $r['walker'] = new gdcet_walker_terms_list();
        }

        $output.= walk_category_tree($terms, $depth, $r);
    }

    if ($r['title_li'] && 'list' == $r['style']) {
        $output.= '</ul></li>';
    }

    $output.= '</ul>';

    if ($r['echo']) {
        echo $output;
    } else {
        return $output;
    }
}
