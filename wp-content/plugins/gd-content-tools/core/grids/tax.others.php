<?php

if (!defined('ABSPATH')) exit;

class gdcet_tax_others_grid extends d4p_grid {
    public $_table_class_name = 'gdcet-grid-tax-others';

    function __construct($args = array()) {
        parent::__construct(array(
            'singular'=> 'tax-other',
            'plural' => 'taxs-other',
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

        echo '<tr data-tax="'.$item->name.'" class="gdcet-row-custom-taxonomy '.join(' ', $classes).'">';
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
        $render = '<strong style="color: #900">'.$item->name.'</strong>';
        $render.= '<br/><strong>'.$item->labels->name.'</strong> ('.$item->labels->singular_name.')';

        return $render;
    }

    public function column_features($item) {
        $actions = array(
            'features' => '<a href="'.$this->_self('panel=features&mode=named&name='.$item->name).'">'.__("Features", "gd-content-tools").'</a>'
        );

        $_visibility = $item->public ? __("Public", "gd-content-tools") : __("Private", "gd-content-tools");

        $render = __("Visibility", "gd-content-tools").': <strong>'.$_visibility.'</strong><br/>';
        $render.= __("Built-in", "gd-content-tools").': <strong>'.(isset($item->_builtin) && $item->_builtin ? __("Yes", "gd-content-tools") : __("No", "gd-content-tools")).'</strong>';

        return $render.$this->row_actions($actions);
    }

    public function column_rewriter($item) {
        $_archive = '&minus;';
        $_query = '&minus;';

        if ($item->rewrite === true) {
            $_archive = $item->name;
        } else if ($item->rewrite !== false) {
            $_archive = $item->rewrite['slug'];
        }

        if ($item->query_var === true) {
            $_query = $item->name;
        } else if ($item->query_var !== false) {
            $_query = $item->query_var;
        }

        $render = __("Archive", "gd-content-tools").': <strong>'.$_archive.'</strong><br/>';
        $render.= __("Query Var", "gd-content-tools").': <strong>'.$_query.'</strong>';

        return $render;
    }

    public function column_post_types($item) {
        $render = array();

        foreach ($item->object_type as $post_type) {
            if (post_type_exists($post_type)) {
                $cpt = get_post_type_object($post_type);
                $render[] = '['.$post_type.'] '.$cpt->label;
            } else {
                $render[] = '['.$post_type.'] <strong style="color: red">'.__("MISSING", "gd-content-tools").'</strong>';
            }
        }

        if (empty($render)) {
            $render[] = __("Nothing Selected", "gd-content-tools");
        }

        return join('<br/>', $render);
    }

    public function column_items($item) {
        $render = wp_count_terms($item->name);

        return $render;
    }

    public function prepare_items() {
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        $pluginitems = array();
        $this->items = array();

        foreach (gdcet_settings()->current['tax']['list'] as $item) {
            $pluginitems[] = $item['taxonomy'];
        }

        global $wp_taxonomies;

        foreach ($wp_taxonomies as $name => $taxonomy) {
            if (!in_array($name, $pluginitems)) {
                $this->items[] = $taxonomy;
            }
        }
    }
}
