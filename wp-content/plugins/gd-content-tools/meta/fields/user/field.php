<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_core_field_user extends gdcet_meta_wp_field {
    public $icon = 'user';

    public static function get_defaults() {
        return array(
            'display' => 'classic',
            'limit' => 0,
            'type' => 'all',
            'roles' => array()
        );
    }

    protected function init() {
        $this->name = 'user';
        $this->label = __("User", "gd-content-tools");
        $this->category = 'content';
    }

    public function get_user_types() {
        return array(
            'all' => __("All Users", "gd-content-tools"),
            'authors' => __("Authors", "gd-content-tools"),
            'roles' => __("User by Roles", "gd-content-tools")
        );
    }

    public function get_user_roles() {
        global $wp_roles;

        $user_roles = array();

        foreach ($wp_roles->roles as $role => $obj) {
            $user_roles[$role] = $obj['name'];
        }

        return $user_roles;
    }
}

class gdcet_core_basefield_user extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'return' => 'ID', 'method' => 'list', 
            'sep' => ', ', 'list' => 'ul', 'class' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $items = array();

        foreach ($this->value as $_user_id) {
            if ($_user_id == 0) {
                return new WP_Error('invalid_value', __("User ID is invalid.", "gd-content-tools"));
            }

            $user = get_user_by('id', $_user_id);

            $item = $_user_id;

            if (isset($user->{$args['return']})) {
                $item = $user->{$args['return']};
            } else if ($args['return'] == 'author_url' || $args['return'] == 'url') {
                $item = get_author_posts_url($user->ID);
            } else if ($args['return'] == 'author_link' || $args['return'] == 'link') {
                $item = '<a href="'.get_author_posts_url($user->ID).'">'.$user->display_name.'</a>';
            } else if ($args['return'] == 'object') {
                $item = $user;
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
