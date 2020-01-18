<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_navmenu {
    public function __construct() {
        add_action('admin_menu', array($this, 'admin_meta'));

        add_filter('wp_setup_nav_menu_item', array($this, 'setup_nav_menu_item'));
        add_filter('wp_nav_menu_objects', array($this, 'nav_menu_objects'));
    }

    function admin_meta() {
        add_meta_box('gdtt-custom-cpt', __("Post Types Archives", "gd-content-tools"), array($this, 'meta_box'), 'nav-menus', 'side', 'high');  
    }

    function meta_box() {
        include(GDCET_PATH.'forms/metaboxes/navmenu-archive.php');
    }

    public function setup_nav_menu_item($menu_item) {
        if ($menu_item->type == 'gdtt_cpt_archive') {
            $menu_item->type_label = __("Post Type Archive", "gd-content-tools");
            $menu_item->url = get_post_type_archive_link($menu_item->object);
        }

        return $menu_item;
    }

    public function nav_menu_objects($menu_items) {
        foreach ($menu_items as $item) {
            if ($item->type == 'gdtt_cpt_archive') {
                $post_type = $item->object;

                if (is_post_type_archive($post_type) || is_singular($post_type)) {
                    $item->current = true;
                    $item->classes[] = 'current-menu-item';
                }
            }
        }

        return $menu_items;
    }
}
