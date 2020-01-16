<?php

if (!defined('ABSPATH')) exit;

class gdcet_cpt_others_grid extends d4p_grid {
    public $_table_class_name = 'gdcet-grid-cpt-others';

    function __construct($args = array()) {
        parent::__construct(array(
            'singular'=> 'cpt-other',
            'plural' => 'cpts-other',
            'ajax' => false
        ));
    }

    protected function display_tablenav($which) {}

    private function _self($args, $getback = false) {
        $url = 'admin.php?page=gd-content-tools-cpt&'.$args;

        if ($getback) {
            $url.= '&gdcet_handler=getback';
            $url.= '&_wpnonce='.wp_create_nonce('gdcet-admin-panel');
            $url.= '&_wp_http_referer='.wp_unslash($_SERVER['REQUEST_URI']);
        }

        return self_admin_url($url);
    }

    public function single_row($item) {
        $classes = $this->get_row_classes($item);

        echo '<tr data-cpt="'.$item->name.'" class="gdcet-row-custom-post-type '.join(' ', $classes).'">';
        $this->single_row_columns($item);
        echo '</tr>';
    }

    public function get_columns() {
	$columns = array(
            'icon' => '&nbsp;',
            'post_type' => __("Post Type", "gd-content-tools"),
            'features' => __("Features", "gd-content-tools"),
            'rewriter' => __("Rewrite & Query", "gd-content-tools"),
            'taxonomies' => __("Taxonomies", "gd-content-tools"),
            'items' => __("Posts", "gd-content-tools")
	);

        return $columns;
    }

    public function column_icon($item) {
        $icon = '<span class="dashicons dashicons-admin-post"></span>';

        return $icon;
    }

    public function column_post_type($item) {
        $render = '<strong style="color: #900">'.$item->name.'</strong>';
        $render.= '<br/><strong>'.$item->labels->name.'</strong> ('.$item->labels->singular_name.')';

        return $render;
    }

    public function column_features($item) {
        $actions = array(
            'features' => '<a href="'.$this->_self('panel=features&mode=named&name='.$item->name).'">'.__("Features", "gd-content-tools").'</a>'
        );

        $_visibility = $item->public ? __("Public", "gd-content-tools") : __("Private", "gd-content-tools");

        $_supports = array();

        if (isset($item->supports) && !empty($item->supports)) {
            foreach (gdcet_admin_shared_data::get_list_of_post_types_supports() as $key => $name) {
                if (in_array($key, $item->supports)) {
                    $_supports[] = $name;
                }
            }
        } else {
            $_supports[] = '&minus;';
        }

        $render = __("Visibility", "gd-content-tools").': <strong>'.$_visibility.'</strong><br/>';
        $render.= __("Supports", "gd-content-tools").': <strong>'.join(', ', $_supports).'</strong><br/>';
        $render.= __("Built-in", "gd-content-tools").': <strong>'.(isset($item->_builtin) && $item->_builtin ? __("Yes", "gd-content-tools") : __("No", "gd-content-tools")).'</strong>';

        return $render.$this->row_actions($actions);
    }

    public function column_rewriter($item) {
        $_archive = '&minus;';
        $_single = '&minus;';
        $_query = '&minus;';

        if ($item->has_archive === true) {
            $_archive = $item->name;
        } else if ($item->has_archive !== false) {
            $_archive = $item->has_archive;
        }

        if ($item->rewrite === true) {
            $_single = $item->name;
        } else if ($item->rewrite !== false) {
            $_single = $item->rewrite['slug'];
        }

        if ($item->query_var === true) {
            $_query = $item->name;
        } else if ($item->query_var !== false) {
            $_query = $item->query_var;
        }

        $render = __("Archive", "gd-content-tools").': <strong>'.$_archive.'</strong><br/>';
        $render.= __("Single", "gd-content-tools").': <strong>'.$_single.'</strong><br/>';
        $render.= __("Query Var", "gd-content-tools").': <strong>'.$_query.'</strong>';

        return $render;
    }

    public function column_taxonomies($item) {
        $actions = array(
            'taxonomies' => '<a href="'.$this->_self('panel=taxonomies&mode=named&name='.$item->name).'">'.__("Taxonomies", "gd-content-tools").'</a>'
        );

        $render = array();

        foreach (get_object_taxonomies($item->name, 'names') as $taxonomy) {
            if (taxonomy_exists($taxonomy)) {
                $tax = get_taxonomy($taxonomy);
                $render[] = $tax->label.' ['.$taxonomy.']';
            } else {
                $render[] = '&minus; ['.$taxonomy.']';
            }
        }

        if (empty($render)) {
            $render[] = __("Nothing Selected", "gd-content-tools");
        }

        return join('<br/>', $render).$this->row_actions($actions);
    }

    public function column_items($item) {
        $actions = array(
            'list' => '<a href="'.admin_url('edit.php?post_type='.$item->name).'">'.__("List", "gd-content-tools").'</a>',
            'new' => '<a href="'.admin_url('post-new.php?post_type='.$item->name).'">'.__("New", "gd-content-tools").'</a>'
        );

        $total = 0;
        $published = 0;

        foreach (wp_count_posts($item->name) as $key => $cnt) {
            if ($key != 'auto-draft') {
                $total+= $cnt;
            }

            if ($key == 'publish') {
                $published += $cnt;
            }
        }

        $render = __("Published", "gd-content-tools").': <strong>'.$published.'</strong><br/>';
        $render.= __("Total", "gd-content-tools").': <strong>'.$total.'</strong><br/>';

        return $render.$this->row_actions($actions);
    }

    public function prepare_items() {
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        $pluginitems = array();
        $this->items = array();

        foreach (gdcet_settings()->current['cpt']['list'] as $item) {
            $pluginitems[] = $item['post_type'];
        }

        global $wp_post_types;

        foreach ($wp_post_types as $name => $post_type) {
            if (!in_array($name, $pluginitems)) {
                $this->items[] = $post_type;
            }
        }
    }
}
