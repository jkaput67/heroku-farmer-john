<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_metabox {
    public function __construct() {
        add_action('admin_init', array($this, 'grid'));
        add_action('add_meta_boxes', array($this, 'meta'));
        add_action('save_post', array($this, 'save_post'), 10, 3);

        add_action('restrict_manage_posts', array($this, 'posts_filter'), 10, 2);
        add_filter('parse_query', array($this, 'parse_query_filter'));
    }

    public function parse_query_filter($query) {
        global $pagenow;

        if ($pagenow == 'edit.php') {
            $qv = &$query->query_vars;

            foreach (gdcet_ctrl()->mod_tax_filter as $tax) {
                if (isset($qv[$tax]) && is_numeric($qv[$tax])) {
                    $term = get_term_by('id', $qv[$tax], $tax);
                    $qv[$tax] = $term ? $term->slug : '';
                }
            }
        }
    }

    public function posts_filter($post_type, $which) {
        if ($which == 'top') {
            $taxonomies = get_object_taxonomies($post_type, 'names');

            foreach (gdcet_ctrl()->mod_tax_filter as $tax) {
                if (in_array($tax, $taxonomies)) {
                    $this->terms_dropdown($tax);
                }
            }
        }
    }

    public function terms_dropdown($tax) {
        global $wp_query;

        $term = isset($wp_query->query[$tax]) ? $wp_query->query[$tax] : '';
        $term_id = !empty($term) && is_numeric($term) ? intval($term) : '';

        if ($term_id === '') {
            $term = get_term_by('slug', $term, $tax);
            $term_id = $term ? $term->term_id : 0;
        }

        $dropdown_options = array(
            'taxonomy' => $tax,
            'name' => $tax,
            'show_option_all' => get_taxonomy($tax)->labels->all_items,
            'hide_empty' => 0,
            'hierarchical' => 1,
            'selected' => $term_id,
            'show_count' => 0,
            'orderby' => 'name'
        );

        echo '<label class="screen-reader-text" for="'.$tax.'">'.sprintf(__("Filter by %s", "gd-content-tools"), get_taxonomy($tax)->labels->singular_name).'</label>';
        wp_dropdown_categories($dropdown_options);
    }

    public function grid() {
        if (!empty(gdcet_ctrl()->mod_tax_image)) {
            $this->grid_taxonomy_image();
        }
    }

    public function grid_taxonomy_image() {
        foreach (gdcet_ctrl()->mod_tax_image as $tax) {
            add_filter('manage_edit-'.$tax.'_columns', array($this, 'grid_taxonomy_image_column'), 10, 1);
            add_filter('manage_'.$tax.'_custom_column', array($this, 'grid_taxonomy_image_content'), 10, 3);
        }
    }

    public function grid_taxonomy_image_column($columns) {
        $columns['gdcet_image'] = __("Image", "gd-content-tools");

        return $columns;
    }

    public function grid_taxonomy_image_content($data, $column, $id) {
        if ($column == 'gdcet_image') {
            $taxonomy = gdcet_admin()->get_taxonomy();

            $image = gdcet_get_term_image($id, $taxonomy, array(64, 64));

            $data = '<div class="gdcet-term-image'.($image !== false ? ' gdcet-has-image' : '').'" data-term="'.$id.'" data-taxonomy="'.$taxonomy.'">';
            $data.= $image !== false ? $image : '';
            $data.= '<div class="gdcet-term-image-placeholder"><span class="dashicons dashicons-format-image"></span></div>';
            $data.= '</div>';
            $data.= '<div class="gdcet-term-controls">';
            $data.= '<div class="gdcet-assign-term" id="gdcet-set-image-'.$id.'" tabindex="-1" aria-label="'.__("Set Image", "gd-content-tools").'" aria-labelledby="gdcet-set-image-'.$id.'">';
            $data.= '<button role="presentation" tabindex="-1"><span class="dashicons dashicons-format-image"></span><span class="d4p-accessibility-show-for-sr">'.__("Set Image", "gd-content-tools").'</span></button>';
            $data.= '</div>';
            $data.= '<div class="gdcet-delete-term"'.($image === false ? ' style="display: none"' : '').' id="gdcet-delete-image-'.$id.'" tabindex="-1" aria-label="'.__("Remove Image", "gd-content-tools").'" aria-labelledby="gdcet-delete-image-'.$id.'">';
            $data.= '<button role="presentation" tabindex="-1"><span class="dashicons dashicons-no-alt"></span><span class="d4p-accessibility-show-for-sr">'.__("Remove Image", "gd-content-tools").'</span></button>';
            $data.= '</div>';
            $data.= '</div>';
        }

        return $data;
    }

    public function meta() {
        $is_post_type = gdcet_admin()->get_post_type();

        if ($is_post_type !== false) {
            do_action('gdcet_admin_meta_boxes', $is_post_type);

            do_action('gdcet_admin_meta_boxes_for_'.$is_post_type, $is_post_type);

            if (!empty(gdcet_ctrl()->mod_tax_metabox)) {
                $this->meta_taxonomy_mod($is_post_type);
            }
        }
    }

    public function save_post($post_id, $post, $update) {
        $data = isset($_REQUEST['gdcet_meta']) ? $_REQUEST['gdcet_meta'] : array();

        do_action('gdcet_admin_meta_boxes_save', $post->post_type, $data, $post_id, $post, $update);

        do_action('gdcet_admin_meta_boxes_for_'.$post->post_type.'_save', $post->post_type, $data, $post_id, $post, $update);
    }

    public function meta_taxonomy_mod($post_type) {
        global $wp_meta_boxes;

        foreach (gdcet_ctrl()->mod_tax_metabox as $tax => $box) {
            $metabox_name = is_taxonomy_hierarchical($tax) ? $tax.'div' : 'tagsdiv-'.$tax;

            if ($box == 'hide') {
                if (isset($wp_meta_boxes[$post_type]['side']['core'][$metabox_name])) {
                    unset($wp_meta_boxes[$post_type]['side']['core'][$metabox_name]);
                }
            } else if ($box == 'limited_single') {
                if (isset($wp_meta_boxes[$post_type]['side']['core'][$metabox_name])) {
                    $wp_meta_boxes[$post_type]['side']['core'][$metabox_name]['callback'] = array($this, 'meta_taxonomy_mod_form');
                    $wp_meta_boxes[$post_type]['side']['core'][$metabox_name]['args']['selection'] = 'single';
                }
            } else if ($box == 'limited_multi') {
                if (isset($wp_meta_boxes[$post_type]['side']['core'][$metabox_name])) {
                    $wp_meta_boxes[$post_type]['side']['core'][$metabox_name]['callback'] = array($this, 'meta_taxonomy_mod_form');
                    $wp_meta_boxes[$post_type]['side']['core'][$metabox_name]['args']['selection'] = 'multi';
                }
            }
        }
    }

    public function meta_taxonomy_mod_form($post, $args = array()) {
        $args = !isset($args['args']) || !is_array($args['args']) ? array() : $args['args'];
        $defaults = array('taxonomy' => 'category', 'selection' => 'multi');

        extract(wp_parse_args($args, $defaults), EXTR_SKIP);

        require_once(GDCET_PATH.'core/admin/classes.php');
        include(GDCET_PATH.'forms/metaboxes/taxonomy-limit.php');
    }

    public function meta_post_template($post_type) {
        add_meta_box('gdcet_post_template_metabox', __("Post Template", "gd-content-tools"), array($this, 'meta_post_template_form'), $post_type, 'side', 'default', array('post_type' => $post_type));
    }

    public function meta_post_template_form($post, $args = array()) {
        $_post_type = $args['args']['post_type'];
        $_post_template = get_post_meta($post->ID, '_wp_post_template', true);
        $_post_templates = gdcet_get_custom_post_templates();

        include(GDCET_PATH.'forms/metaboxes/post-template.php');
    }

    public function meta_post_template_save($post_type, $meta_data, $post_id, $post, $update) {
        $data = isset($meta_data['post_template']) ? $meta_data['post_template'] : array('_wpnonce' => '', 'template' => '');

        if (wp_verify_nonce($data['_wpnonce'], 'gdcet_meta_post_template_'.$post_id)) {
            $post_template = $data['template'];

            if ($post_template != '' && $post_template == sanitize_file_name($post_template)) {
                update_post_meta($post_id, '_wp_post_template', $post_template);
            } else {
                delete_post_meta($post_id, '_wp_post_template');
            }
        }
    }
}

global $_gdcet_metabox_admin;
$_gdcet_metabox_admin = new gdcet_admin_metabox();

function gdcet_admin_metabox() {
    global $_gdcet_metabox_admin;
    return $_gdcet_metabox_admin;
}
