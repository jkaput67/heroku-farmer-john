<?php

if (!defined('ABSPATH')) exit;

class gdcet_field_grid extends d4p_grid {
    public $_table_class_name = 'gdcet-grid-field';

    public $_type = '';

    function __construct($args = array()) {
        $this->_type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : '';

        parent::__construct(array(
            'singular'=> 'field',
            'plural' => 'fields',
            'ajax' => false
        ));
    }

    protected function display_tablenav($which) {}

    private function _self($args, $getback = false) {
        $url = 'admin.php?page=gd-content-tools-meta-fields&'.$args;

        if ($getback) {
            $url.= '&gdcet_handler=getback';
            $url.= '&_wpnonce='.wp_create_nonce('gdcet-admin-panel');
            $url.= '&_wp_http_referer='.wp_unslash($_SERVER['REQUEST_URI']);
        }

        return self_admin_url($url);
    }

    public function get_views() {
        $url = 'admin.php?page=gd-content-tools-meta-fields';

        $views = array(
            'all' => '<a href="'.$url.'" class="'.($this->_type == '' ? 'current' : '').'">'.__("All", "gd-content-tools").'</a>',
            'simple' => '<a href="'.$url.'&type=simple" class="'.($this->_type == 'simple' ? 'current' : '').'">'.__("Simple", "gd-content-tools").'</a>',
            'custom' => '<a href="'.$url.'&type=custom" class="'.($this->_type == 'custom' ? 'current' : '').'">'.__("Custom", "gd-content-tools").'</a>'
        );

        return $views;
    }

    public function single_row($item) {
        $classes = $this->get_row_classes($item);

        echo '<tr data-field="'.$item->id.'" class="gdcet-row-custom-field '.join(' ', $classes).'">';
        $this->single_row_columns($item);
        echo '</tr>';
    }

    public function get_columns() {
	$columns = array(
            'icon' => '&nbsp;',
            'field' => __("Field", "gd-content-tools"),
            'description' => __("Description", "gd-content-tools"),
            'elements' => __("Elements", "gd-content-tools"),
            'settings' => __("Setttings", "gd-content-tools")
	);

        return $columns;
    }

    public function column_icon($item) {
        switch ($item->type) {
            default:
            case 'simple':
                return '<i class="fa fa-sticky-note fa-fw" title="'.__("Simple Field", "gd-content-tools").'"></i>';
            case 'custom':
                return '<i class="fa fa-ticket fa-fw" title="'.__("Custom Field", "gd-content-tools").'"></i>';
        }
    }

    public function column_field($item) {
        $actions = array(
            'edit' => '<a href="'.$this->_self('panel='.$item->type.'&id='.$item->id).'">'.__("Edit", "gd-content-tools").'</a>',
            'duplicate' => '<a href="'.$this->_self('panel='.$item->type.'&copy='.$item->id).'">'.__("Duplicate", "gd-content-tools").'</a>',
            'delete' => '<a class="gdcet-link-delete gdcet-action-delete-field" href="'.$this->_self('single-action=delete&id='.$item->id, true).'">'.__("Delete", "gd-content-tools").'</a>'
        );

        $render = '<strong style="color: #900">'.$item->get_label().'</strong>';
        $render.= '<br/><strong>'.$item->get_slug().'</strong>';

        return $render.$this->row_actions($actions);
    }

    public function column_settings($item) {
        $render = __("Required", "gd-content-tools").': <strong>'.($item->is_required() ? __("Yes", "gd-content-tools") : __("No", "gd-content-tools")).'</strong><br/>';
        $render.= __("Repeater", "gd-content-tools").': <strong>'.($item->is_repeater() ? __("Yes", "gd-content-tools") : __("No", "gd-content-tools")).'</strong>';

        return $render;
    }

    public function column_description($item) {
        $render = $item->get_description();

        return $render;
    }

    public function column_elements($item) {
        $render = array();

        foreach ($item->fields as $field) {
            $render[] = '<i class="fa fa-'.$field->icon.' fa-fw" title="'.
                        $field->label.'"></i> '.$field->label.
                        ' - <strong>'.$field->basic['label'].'</strong>';
        }

        return join('<br/>', $render);
    }

    public function prepare_items() {
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        $this->items = array();

        foreach (array_keys(gdcet_settings()->current['meta']['fields']) as $id) {
            $field = gdcet_meta()->get_field($id);

            if ($this->_type == '' || ($this->_type == $field->type)) {
                $this->items[] = $field;
            }
        }
    }
}
