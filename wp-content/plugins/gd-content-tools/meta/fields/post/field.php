<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_post extends gdcet_meta_wp_field {
    public $icon = 'thumb-tack';

    public static function get_defaults() {
        return array(
            'display' => 'classic',
            'limit' => 0,
            'post_type' => 'post'
        );
    }

    protected function init() {
        $this->name = 'post';
        $this->label = __("Post", "gd-content-tools");
        $this->category = 'content';
    }

    public function get_post_types() {
        global $wp_post_types;

        $post_types = array();

        foreach ($wp_post_types as $cpt => $obj) {
            $post_types[$cpt] = $obj->label;
        }

        return $post_types;
    }
}

class gdcet_core_basefield_post extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'return' => 'ID', 'method' => 'list', 
            'sep' => ', ', 'list' => 'ul', 'class' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $items = array();

        foreach ($this->value as $_post_id) {
            if ($_post_id == 0) {
                return new WP_Error('invalid_value', __("Post ID is invalid.", "gd-content-tools"));
            }

            $post = get_post($_post_id);

            if (!$post) {
                return new WP_Error('invalid_value', __("Post ID is invalid.", "gd-content-tools"));
            }

            $item = $_post_id;

            if (isset($post->{$args['return']})) {
                $item = $post->{$args['return']};
            } else if ($args['return'] == 'permalink' || $args['return'] == 'url') {
                $item = get_permalink($post->ID);
            } else if ($args['return'] == 'link') {
                $item = '<a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
            } else if ($args['return'] == 'object') {
                $item = $post;
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
