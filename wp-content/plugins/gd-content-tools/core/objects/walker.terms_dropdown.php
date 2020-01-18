<?php

if (!defined('ABSPATH')) exit;

class gdcet_walker_terms_dropdown extends Walker_CategoryDropdown {
    function start_el(&$output, $term, $depth = 0, $args = array(), $id = 0) {
        $pad = str_repeat('&nbsp;', $depth * 3);

        if (is_array($args['post_types'])) {
            $args['post_types'] = $args['post_types'][0];
        }

        $term_name = apply_filters('list_term_name', $term->name, $term);

        $term_url = '';
        if ($args['post_types'] != '') {
            if (gdtt_has_post_type_intersections($args['post_types'])) {
                $term_url = gdtt_get_intersection_link($args['post_types'], $term->taxonomy, $term);
            } else {
                $term_url = get_term_link($term, $term->taxonomy);
                $term_url = add_query_arg('post_type', $args['post_types'], $term_url);
            }
        } else {
            $term_url = get_term_link($term, $term->taxonomy);
        }

        $output.= "\t<option class=\"level-$depth\" value=\"".$term_url."\"";

        if ($term->term_id == $args['selected']) {
            $output.= ' selected="selected"';
        }

        $output.= '>';
        $output.= $pad.$term_name;

        if (isset($args['show_count']) && $args['show_count']) {
            $output.= '&nbsp;&nbsp;('.$term->count.')';
        }

        if (isset($args['show_last_update']) && $args['show_last_update']) {
            $format = 'Y-m-d';
            $output.= '&nbsp;&nbsp;'.gmdate($format, $term->last_update_timestamp);
        }

        $output.= "</option>\n";
    }
}
