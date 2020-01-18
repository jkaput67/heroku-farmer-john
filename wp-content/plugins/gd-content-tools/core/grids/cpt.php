<?php

if (!defined('ABSPATH')) exit;

class gdcet_cpt_grid extends d4p_grid {
    public $_table_class_name = 'gdcet-grid-cpt';

    function __construct($args = array()) {
        parent::__construct(array(
            'singular'=> 'cpt',
            'plural' => 'cpts',
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

        echo '<tr data-cpt="'.$item->id().'" class="gdcet-row-custom-post-type '.join(' ', $classes).'">';
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
        $icon = '';

        switch ($item->_icon) {
            case 'dashicon':
                $icon = '<span class="dashicons dashicons-'.$item->_icon_dashicons.'"></span>';
                break;
            case 'embed':
                $icon = '<div class="gdcet-icon-embed" style="background-image:url('.$item->_icon_embed.') !important;">';
                break;
            case 'image':
                $icon = '<div class="gdcet-icon-embed" style="background-image:url('.wp_get_attachment_url($item->_icon_image).') !important; background-size: 20px 20px;">';
                break;
            case 'url':
                $icon = '<div class="gdcet-icon-embed" style="background-image:url('.$item->_icon_url.') !important; background-size: 20px 20px;">';
                break;
            case 'sprite':
                $icon = '<div id="gdcet-menu-icon-'.$item->post_type.'" class="gdcet-icon-sprite"></div>';
                break;
        }

        return $icon;
    }

    public function column_post_type($item) {
        $actions = array(
            'edit' => '<a href="'.$this->_self('panel=edit&id='.$item->id()).'">'.__("Edit", "gd-content-tools").'</a>',
            'duplicate' => '<a href="'.$this->_self('panel=edit&copy='.$item->id()).'">'.__("Duplicate", "gd-content-tools").'</a>',
            'function' => '<a href="'.$this->_self('panel=function&id='.$item->id()).'">'.__("Function", "gd-content-tools").'</a>',
            'templates' => '<a href="'.$this->_self('panel=templates&id='.$item->id()).'">'.__("Templates", "gd-content-tools").'</a>',
            'delete' => '<a class="gdcet-link-delete gdcet-action-delete-cpt" href="'.$this->_self('single-action=delete&id='.$item->id(), true).'">'.__("Delete", "gd-content-tools").'</a>'
        );

        $render = '<strong style="color: #900">'.$item->post_type.'</strong>';
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
        $render.= __("Editor", "gd-content-tools").': <strong>'.$item->display_editor().'</strong><br/>';
        $render.= __("Supports", "gd-content-tools").': <strong>'.$item->display_supports().'</strong>';

        return $render.$this->row_actions($actions);
    }

    public function column_rewriter($item) {
        $actions = array(
            'rewrite' => '<a href="'.$this->_self('panel=rewrite&id='.$item->id()).'">'.__("Rewriter", "gd-content-tools").'</a>',
            'permalinks' => '<a href="'.$this->_self('panel=permalinks&id='.$item->id()).'">'.__("Custom Permalinks", "gd-content-tools").'</a>'
        );

        $render = __("Archive", "gd-content-tools").': <strong>'.$item->display_archive().'</strong><br/>';
        $render.= __("Single", "gd-content-tools").': <strong>'.$item->display_single().'</strong><br/>';
        $render.= __("Query Var", "gd-content-tools").': <strong>'.$item->display_query_var().'</strong>';

        return $render.$this->row_actions($actions);
    }

    public function column_taxonomies($item) {
        $actions = array(
            'taxonomies' => '<a href="'.$this->_self('panel=taxonomies&id='.$item->id()).'">'.__("Taxonomies", "gd-content-tools").'</a>'
        );

        $render = array();

        foreach ($item->taxonomies as $taxonomy) {
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
            'list' => '<a href="'.admin_url('edit.php?post_type='.$item->post_type).'">'.__("List", "gd-content-tools").'</a>',
            'new' => '<a href="'.admin_url('post-new.php?post_type='.$item->post_type).'">'.__("New", "gd-content-tools").'</a>'
        );

        $total = 0;
        $published = 0;

        foreach (wp_count_posts($item->post_type) as $key => $cnt) {
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

        $this->items = array();

        foreach (gdcet_settings()->current['cpt']['list'] as $item) {
            $this->items[] = new gdcet_base_cpt($item);
        }
    }
}
