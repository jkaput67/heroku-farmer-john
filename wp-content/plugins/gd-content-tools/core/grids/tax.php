<?php

if (!defined('ABSPATH')) exit;

class gdcet_tax_grid extends d4p_grid {
    public $_table_class_name = 'gdcet-grid-tax';

    function __construct($args = array()) {
        parent::__construct(array(
            'singular'=> 'tax',
            'plural' => 'taxs',
            'ajax' => false
        ));
    }

    protected function display_tablenav($which) {}

    private function _self($args, $getback = false) {
        $url = 'admin.php?page=gd-content-tools-tax&'.$args;

        if ($getback) {
            $url.= '&gdcet_handler=getback';
            $url.= '&_wpnonce='.wp_create_nonce('gdcet-admin-panel');
            $url.= '&_wp_http_referer='.wp_unslash($_SERVER['REQUEST_URI']);
        }

        return self_admin_url($url);
    }

    public function single_row($item) {
        $classes = $this->get_row_classes($item);

        echo '<tr data-tax="'.$item->id().'" class="gdcet-row-custom-taxonomy '.join(' ', $classes).'">';
        $this->single_row_columns($item);
        echo '</tr>';
    }

    public function get_columns() {
	$columns = array(
            'icon' => '&nbsp;',
            'taxonomy' => __("Taxonomy", "gd-content-tools"),
            'features' => __("Features", "gd-content-tools"),
            'rewriter' => __("Rewrite & Query", "gd-content-tools"),
            'post_types' => __("Post Types", "gd-content-tools"),
            'items' => __("Terms", "gd-content-tools")
	);

        return $columns;
    }

    public function column_icon($item) {
        return '<i class="fa fa-'.($item->hierarchical ? 'tags' : 'tag').'"></i>';
    }

    public function column_taxonomy($item) {
        $actions = array(
            'edit' => '<a href="'.$this->_self('panel=edit&id='.$item->id()).'">'.__("Edit", "gd-content-tools").'</a>',
            'duplicate' => '<a href="'.$this->_self('panel=edit&copy='.$item->id()).'">'.__("Duplicate", "gd-content-tools").'</a>',
            'function' => '<a href="'.$this->_self('panel=function&id='.$item->id()).'">'.__("Function", "gd-content-tools").'</a>',
            'templates' => '<a href="'.$this->_self('panel=templates&id='.$item->id()).'">'.__("Templates", "gd-content-tools").'</a>',
            'delete' => '<a class="gdcet-link-delete gdcet-action-delete-tax" href="'.$this->_self('single-action=delete&id='.$item->id(), true).'">'.__("Delete", "gd-content-tools").'</a>'
        );

        $render = '<strong style="color: #900">'.$item->taxonomy.'</strong>';
        $render.= '<br/><strong>'.$item->_labels_name.'</strong> ('.$item->_labels_singular_name.')';

        return $render.$this->row_actions($actions);
    }

    public function column_features($item) {
        $actions = array(
            'labels' => '<a href="'.$this->_self('panel=labels&id='.$item->id()).'">'.__("Labels", "gd-content-tools").'</a>',
            'visibility' => '<a href="'.$this->_self('panel=visibility&id='.$item->id()).'">'.__("Visibility", "gd-content-tools").'</a>',
            'features' => '<a href="'.$this->_self('panel=features&id='.$item->id()).'">'.__("Features", "gd-content-tools").'</a>',
            'capabilities' => '<a href="'.$this->_self('panel=capabilities&id='.$item->id()).'">'.__("Capabilities", "gd-content-tools").'</a>'
        );

        $render = __("Visibility", "gd-content-tools").': <strong>'.$item->display_visibility().'</strong><br/>';

        return $render.$this->row_actions($actions);
    }

    public function column_rewriter($item) {
        $actions = array(
            'rewrite' => '<a href="'.$this->_self('panel=rewrite&id='.$item->id()).'">'.__("Rewriter", "gd-content-tools").'</a>',
            // 'permalinks' => '<a href="'.$this->_self('panel=permalinks&id='.$item->id()).'">'.__("Custom Permalinks", "gd-content-tools").'</a>'
        );

        $render = __("Archive", "gd-content-tools").': <strong>'.$item->display_archive().'</strong><br/>';
        $render.= __("Query Var", "gd-content-tools").': <strong>'.$item->display_query_var().'</strong>';

        return $render.$this->row_actions($actions);
    }

    public function column_post_types($item) {
        $actions = array(
            'post_types' => '<a href="'.$this->_self('panel=post_types&id='.$item->id()).'">'.__("Post Types", "gd-content-tools").'</a>'
        );

        $render = array();

        foreach ($item->_post_types as $post_type) {
            if (post_type_exists($post_type)) {
                $cpt = get_post_type_object($post_type);
                $render[] = '['.$post_type.'] '.$cpt->label;
            } else if ($post_type != '') {
                $render[] = '['.$post_type.'] <strong style="color: red">'.__("MISSING", "gd-content-tools").'</strong>';
            }
        }

        if (empty($render)) {
            $render[] = __("Nothing Selected", "gd-content-tools");
        }

        return join('<br/>', $render).$this->row_actions($actions);
    }

    public function column_items($item) {
        $render = $item->total_terms();

        return $render;
    }

    public function prepare_items() {
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        $this->items = array();

        foreach (gdcet_settings()->current['tax']['list'] as $item) {
            $this->items[] = new gdcet_base_tax($item);
        }
    }
}
