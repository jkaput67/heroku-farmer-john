<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_term extends gdcet_meta_wp_field {
    public $icon = 'tags';

    public static function get_defaults() {
        return array(
            'display' => 'classic',
            'limit' => 0,
            'taxonomy' => 'category'
        );
    }

    protected function init() {
        $this->name = 'term';
        $this->label = __("Term", "gd-content-tools");
        $this->category = 'content';
    }

    public function get_taxonomies() {
        global $wp_taxonomies;

        $taxonomies = array();

        foreach ($wp_taxonomies as $tax => $obj) {
            $taxonomies[$tax] = $obj->label;
        }

        return $taxonomies;
    }
}

class gdcet_core_basefield_term extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'return' => 'ID', 'method' => 'list', 
            'sep' => ', ', 'list' => 'ul', 'class' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $items = array();

        foreach ($this->value as $_term_id) {
            if ($_term_id == 0) {
                return new WP_Error('invalid_value', __("Term ID is invalid.", "gd-content-tools"));
            }

            $term = get_term($_term_id);

            $item = $_term_id;

            if (isset($term->{$args['return']})) {
                $item = $term->{$args['return']};
            } else if ($args['return'] == 'archive_url' || $args['return'] == 'url') {
                $item = get_term_link($term->ID);
            } else if ($args['return'] == 'archive_link' || $args['return'] == 'link') {
                $item = '<a href="'.get_term_link($term->ID).'">'.$term->name.'</a>';
            } else if ($args['return'] == 'object') {
                $item = $term;
            }

            $items[] = $item;
        }

        if (count($items) == 1) {
            $items = $items[0];

            if ($args['return'] == 'object') {
                return $items;
            }
        } else {
            if ($args['return'] == 'object') {
                return $items;
            }

            switch ($args['method']) {
                case 'list':
                    $render = '<'.$args['list'].' class="'.$args['class'].'">';
                    $render.= '<li>'.join('</li><li>', $items).'</li>';
                    $render.= '</'.$args['list'].'>';
                    break;
                case 'string':
                    $render = join($args['sep'], $items);
                    break;
            }
        }

        return $args['before'].$render.$args['after'];
    }
}
