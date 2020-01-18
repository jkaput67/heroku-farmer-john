<?php

if (!defined('ABSPATH')) exit;


class gdcet_rule_grid extends d4p_grid {
    public $_table_class_name = 'gdcet-grid-rule';

    function __construct($args = array()) {
        parent::__construct(array(
            'singular'=> 'rule',
            'plural' => 'rules',
            'ajax' => false
        ));
    }

    protected function display_tablenav($which) {}

    private function _self($args, $getback = false) {
        $url = 'admin.php?page=gd-content-tools-meta-bbpress&'.$args;

        if ($getback) {
            $url.= '&gdcet_handler=getback';
            $url.= '&_wpnonce='.wp_create_nonce('gdcet-admin-panel');
            $url.= '&_wp_http_referer='.wp_unslash($_SERVER['REQUEST_URI']);
        }

        return self_admin_url($url);
    }

    public function single_row($item) {
        $classes = $this->get_row_classes($item);

        echo '<tr data-rule="'.$item->id.'" class="gdcet-row-custom-post-type '.join(' ', $classes).'">';
        $this->single_row_columns($item);
        echo '</tr>';
    }

    public function get_columns() {
	$columns = array(
            'label' => __("Rule", "gd-content-tools"),
            'forums' => __("Forums", "gd-content-tools"),
            'metabox' => __("Metabox", "gd-content-tools"),
            'roles' => __("User Roles", "gd-content-tools"),
	);

        return $columns;
    }

    public function column_label($item) {
        $actions = array(
            'edit' => '<a href="'.$this->_self('rule='.$item->id).'">'.__("Edit", "gd-content-tools").'</a>',
            'delete' => '<a class="gdcet-action-delete-bbpress" href="'.$this->_self('single-action=delete&rule='.$item->id, true).'">'.__("Delete", "gd-content-tools").'</a>'
        );

        return '<strong>'.$item->label.'</strong>'.$this->row_actions($actions);
    }

    public function column_forums($item) {
        $render = '';

        if ($item->scope == 'all') {
            $render.= __("All Forums.", "gd-content-tools");
        } else {
            $render.= __("Selected Forums.", "gd-content-tools");
        }

        $render.= ' ';

        if ($item->type == 'both') {
            $render.= __("For topic and reply forms.", "gd-content-tools");
        } else if ($item->type == 'topic') {
            $render.= __("For topic forms.", "gd-content-tools");
        } else if ($item->type == 'reply') {
            $render.= __("For reply forms.", "gd-content-tools");
        }

        $render.= '<br/>';

        if ($item->location == 'before_content') {
            $render.= __("Embed before content field.", "gd-content-tools");
        } else if ($item->location == 'after_content') {
            $render.= __("Embed after content field.", "gd-content-tools");
        } else if ($item->location == 'form_end') {
            $render.= __("Embed at the end of the form.", "gd-content-tools");
        }

        return $render;
    }

    public function column_metabox($item) {
        $metabox = gdcet_meta()->get_box($item->metabox);

        $render = $metabox->label;

        return $render;
    }

    public function column_roles($item) {
        $render = '';

        if (is_null($item->roles)) {
            $render.= __("All roles.", "gd-content-tools");
        } else if (empty($item->roles)) {
            $render.= __("No roles selected.", "gd-content-tools");
        } else {
            global $wp_roles;

            $out = array();

            foreach ($item->roles as $role) {
                if (isset($wp_roles->roles[$role])) {
                    $out[] = $wp_roles->roles[$role]['name'];
                }
            }

            $render.= join(', ', $out);
        }

        return $render;
    }

    public function prepare_items() {
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        $this->items = array();

        foreach (gdcet_bbpress()->get('boxes') as $item) {
            $this->items[] = (object)$item;
        }
    }
}
