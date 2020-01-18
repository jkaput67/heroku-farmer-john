<?php

if (!defined('ABSPATH')) exit;

class gdcet_box_grid extends d4p_grid {
    public $_table_class_name = 'gdcet-grid-box';

    public $_type = '';

    function __construct($args = array()) {
        $this->_type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : '';

        parent::__construct(array(
            'singular'=> 'box',
            'plural' => 'boxs',
            'ajax' => false
        ));
    }

    protected function display_tablenav($which) {}

    private function _self($args, $getback = false) {
        $url = 'admin.php?page=gd-content-tools-meta-boxes&'.$args;

        if ($getback) {
            $url.= '&gdcet_handler=getback';
            $url.= '&_wpnonce='.wp_create_nonce('gdcet-admin-panel');
            $url.= '&_wp_http_referer='.wp_unslash($_SERVER['REQUEST_URI']);
        }

        return self_admin_url($url);
    }

    public function get_views() {
        $url = 'admin.php?page=gd-content-tools-meta-boxes';

        $views = array(
            'all' => '<a href="'.$url.'" class="'.($this->_type == '' ? 'current' : '').'">'.__("All", "gd-content-tools").'</a>',
            'meta' => '<a href="'.$url.'&type=meta" class="'.($this->_type == 'meta' ? 'current' : '').'">'.__("Meta", "gd-content-tools").'</a>',
            'legacy' => '<a href="'.$url.'&type=legacy" class="'.($this->_type == 'legacy' ? 'current' : '').'">'.__("Legacy", "gd-content-tools").'</a>'
        );

        return $views;
    }

    private function _post_types_labels($list) {
        global $wp_post_types;

        $out = array();

        foreach ($list as $cpt) {
            if (isset($wp_post_types[$cpt])) {
                $out[] = '<span title="'.$cpt.'">'.$wp_post_types[$cpt]->label.'</span>';
            } else {
                $out[] = '<span title="'.__("MISSING", "gd-content-tools").'">'.ucfirst($cpt).'</span>';
            }
        }

        return join(', ', $out);
    }

    private function _taxonomies_labels($list) {
        global $wp_taxonomies;

        $out = array();

        foreach ($list as $tax) {
            if (isset($wp_taxonomies[$tax])) {
                $out[] = '<span title="'.$tax.'">'.$wp_taxonomies[$tax]->label.'</span>';
            } else {
                $out[] = '<span title="'.__("MISSING", "gd-content-tools").'">'.ucfirst($tax).'</span>';
            }
        }

        return join(', ', $out);
    }

    private function _user_roles_labels($list) {
        global $wp_roles;

        $out = array();

        foreach ($list as $role) {
            if (isset($wp_roles->roles[$role])) {
                $out[] = '<span title="'.$role.'">'.$wp_roles->roles[$role]['name'].'</span>';
            } else {
                $out[] = '<span title="'.__("MISSING", "gd-content-tools").'">'.ucfirst($role).'</span>';
            }
        }

        return join(', ', $out);
    }

    public function single_row($item) {
        $classes = $this->get_row_classes($item);

        echo '<tr data-box="'.$item->id.'" class="gdcet-row-custom-box '.join(' ', $classes).'">';
        $this->single_row_columns($item);
        echo '</tr>';
    }

    public function get_columns() {
	$columns = array(
            'icon' => '&nbsp;',
            'box' => __("Box", "gd-content-tools"),
            'description' => __("Description", "gd-content-tools"),
            'fields' => __("Fields", "gd-content-tools"),
            'integration' => __("Integration", "gd-content-tools"),
            'settings' => __("Settings", "gd-content-tools")
	);

        return $columns;
    }

    public function column_icon($item) {
        switch ($item->type) {
            default:
            case 'legacy':
                return '<i class="fa fa-square fa-fw" title="'.__("Legacy Box", "gd-content-tools").'"></i>';
            case 'meta':
                return '<i class="fa fa-th-large fa-fw" title="'.__("Meta Box", "gd-content-tools").'"></i>';
        }
    }

    public function column_box($item) {
        $actions = array(
            'edit' => '<a href="'.$this->_self('panel='.$item->type.'&id='.$item->id).'">'.__("Edit", "gd-content-tools").'</a>',
            'duplicate' => '<a href="'.$this->_self('panel='.$item->type.'&copy='.$item->id).'">'.__("Duplicate", "gd-content-tools").'</a>',
            'delete' => '<a class="gdcet-link-delete gdcet-action-delete-box" href="'.$this->_self('single-action=delete&id='.$item->id, true).'">'.__("Delete", "gd-content-tools").'</a>',
            'php' => '<a href="'.$this->_self('panel=php&id='.$item->id).'">'.__("Code", "gd-content-tools").'</a>'
        );

        $render = '<strong style="color: #900">'.$item->get_label().'</strong>';
        $render.= '<br/><strong>'.$item->get_slug().'</strong>';

        return $render.$this->row_actions($actions);
    }

    public function column_description($item) {
        $render = $item->get_description();

        return $render;
    }

    public function column_integration($item) {
        $render = '';

        if (!empty($item->get_types('post_types'))) {
            $render.= '<i title="'.__("Post Types", "gd-content-tools").'" class="fa fa-thumb-tack"></i> ';
            $render.= $this->_post_types_labels($item->get_types('post_types'));
            $render.= '<br/>';
        }

        if (!empty($item->get_types('taxonomies'))) {
            $render.= '<i title="'.__("Taxonomies", "gd-content-tools").'" class="fa fa-tag"></i> ';
            $render.= $this->_taxonomies_labels($item->get_types('taxonomies'));
            $render.= '<br/>';
        }

        if (!empty($item->get_types('user_roles'))) {
            $render.= '<i title="'.__("User Roles", "gd-content-tools").'" class="fa fa-user"></i> ';
            $render.= $this->_user_roles_labels($item->get_types('user_roles'));
            $render.= '<br/>';
        }

        if (empty($render)) {
            $render = __("Nothing Selected", "gd-content-tools");
        }

        return $render;
    }

    public function column_fields($item) {
        $render = array();

        foreach ($item->fields as $field) {
            $id = $field['field_id'];
            $f = gdcet_meta()->get_field($id);

            $icon = '';
            switch ($f->type) {
                default:
                case 'simple':
                    $icon = '<i class="fa fa-sticky-note fa-fw" title="'.__("Simple Field", "gd-content-tools").'"></i>';
                    break;
                case 'custom':
                    $icon = '<i class="fa fa-ticket fa-fw" title="'.__("Custom Field", "gd-content-tools").'"></i>';
                    break;
            }

            $render[] = $icon.' '.$f->get_label();
        }

        return join('<br/>', $render);
    }

    public function column_settings($item) {
        $render = __("Repeater", "gd-content-tools").': <strong>'.($item->is_repeater() ? __("Yes", "gd-content-tools") : __("No", "gd-content-tools")).'</strong>';

        return $render;
    }

    public function prepare_items() {
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        $this->items = array();

        foreach (array_keys(gdcet_settings()->current['meta']['boxes']) as $id) {
            $box = gdcet_meta()->get_box($id);

            if ($this->_type == '' || ($this->_type == $box->type)) {
                $this->items[] = $box;
            }
        }
    }
}
