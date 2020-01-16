<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_ajax {
    public function __construct() {
        add_action('wp_ajax_gdcet-change-objects-order', array($this, 'change_object_order'));
        add_action('wp_ajax_gdcet-update-term-image', array($this, 'update_term_image'));
        add_action('wp_ajax_gdcet-meta-change-field-type', array($this, 'meta_change_field_type'));
        add_action('wp_ajax_gdcet-meta-add-basic-field', array($this, 'meta_add_basic_field'));
        add_action('wp_ajax_gdcet-navmenus-post-type-archives', array($this, 'navmenus_post_type_archives'));
    }

    function navmenus_post_type_archives() {
        if (current_user_can('edit_theme_options')) {
            $this->check_nonce();

            require_once(ABSPATH.'wp-admin/includes/nav-menu.php');

            $list = (array)$_POST['list'];

            $items = array();
            foreach ($list as $post_type) {
                $post_type_obj = get_post_type_object($post_type);

                if (!$post_type_obj) continue;

                $menu_item = array(
                    'menu-item-title' => esc_attr($post_type_obj->labels->name),
                    'menu-item-type' => 'gdtt_cpt_archive',
                    'menu-item-object' => esc_attr($post_type)
                );

                $items[] = wp_update_nav_menu_item(0, 0, $menu_item);  
            }

            $menu_items = array();
            foreach ($items as $item) {
                $menu = get_post($item);

                if (!empty($menu->ID)) {
                    $menu = wp_setup_nav_menu_item($menu);
                    $menu->label = $menu->title;
                    $menu_items[] = $menu;
                }
            }

            if (!empty($menu_items)) {
                $args = array(
                    'after' => '', 
                    'before' => '',
                    'link_after' => '',
                    'link_before' => '',
                    'walker' => new Walker_Nav_Menu_Edit()
                );

                die(walk_nav_menu_tree($menu_items, 0, (object)$args));
            }

            die('');
        }
    }

    public function check_nonce($nonce = '_ajax_nonce', $action = 'gdcet-admin-internal') {
        $check = wp_verify_nonce($_REQUEST[$nonce], $action);

        if ($check === false) {
            wp_die(-1);
        }
    }

    public function change_object_order() {
        if (d4p_is_current_user_admin()) {
            $this->check_nonce();

            $list = (array)$_REQUEST['list'];
            $list = array_map('intval', $list);
            $list = array_unique($list);
            $type = $_REQUEST['type'];

            if (!empty($list) && in_array($type, array('cpt', 'tax'))) {
                $new = array();

                foreach ($list as $id) {
                    if (isset(gdcet_settings()->current[$type]['list'][$id])) {
                        $new[$id] = gdcet_settings()->current[$type]['list'][$id];
                    }
                }

                foreach (gdcet_settings()->current[$type]['list'] as $id => $obj) {
                    if (!isset($new[$id])) {
                        $new[$id] = $obj;
                    }
                }

                gdcet_settings()->current[$type]['list'] = $new;
                gdcet_settings()->save($type);
            }
        }

        die('');
    }

    public function update_term_image() {
        if (current_user_can('manage_categories')) {
            $this->check_nonce();

            $taxonomy = $_REQUEST['taxonomy'];
            $term_id = intval($_REQUEST['term']);
            $image = intval($_REQUEST['image']);

            if (taxonomy_exists($taxonomy) && $term_id > 0) {
                if ($image == 0) {
                    gdcet_delete_term_image($term_id, $taxonomy);
                } else {
                    gdcet_update_term_image($term_id, $taxonomy, $image);
                }
            }
        }
    }

    public function meta_add_basic_field() {
        if (d4p_is_current_user_admin()) {
            $this->check_nonce();

            $field_id = intval($_REQUEST['id']);

            $field = gdcet_meta_get_basic_field();

            die($field->render($field_id, 'custom', true));
        }
    }

    public function meta_change_field_type() {
        if (d4p_is_current_user_admin()) {
            $this->check_nonce();

            $field_id = intval($_REQUEST['id']);
            $field_type = $_REQUEST['type'];

            if (gdcet_meta_is_basic_field_registered($field_type)) {
                $field = gdcet_meta_get_basic_field($field_type);

                die($field->controls($field_id));
            }

            die('0');
        }
    }
}

global $_gdcet_admin_ajax;

$_gdcet_admin_ajax = new gdcet_admin_ajax();

function gdcet_ajax_admin() {
    global $_gdcet_admin_ajax;
    return $_gdcet_admin_ajax;
}
