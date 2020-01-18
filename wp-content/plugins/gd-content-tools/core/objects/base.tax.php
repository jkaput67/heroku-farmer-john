<?php

if (!defined('ABSPATH')) exit;

class gdcet_base_tax extends gdcet_data_class {
    public $_id = 0;
    public $_status = true;

    public $_extra_assign_image = false;
    public $_extra_post_edit_filter = false;
    public $_extra_post_meta_box = 'auto';

    public $_permalinks_index = false;

    public $_post_types = array();
    public $_public = true;
    public $_public_override = false;
    public $_visibility = array('show_ui', 'show_in_nav_menus', 'show_in_menu', 'show_admin_column', 'show_tagcloud');
    public $_visibility_show_in_rest = true;

    public $_capability_manage_terms = 'manage_categories';
    public $_capability_edit_terms = 'manage_categories';
    public $_capability_delete_terms = 'manage_categories';
    public $_capability_assign_terms = 'edit_posts';

    public $_query_var = true;
    public $_query_var_slug = '';

    public $_rewrite = true;
    public $_rewrite_slug = '';
    public $_rewrite_with_front = true;
    public $_rewrite_hierarchical = true;

    public $_rest_rest_base = '';
    public $_rest_rest_controller_class = '';

    public $_labels_name = '';
    public $_labels_singular_name = '';
    public $_labels_menu_name = '';
    public $_labels_all_items = '';
    public $_labels_edit_item = '';
    public $_labels_view_item = '';
    public $_labels_update_item = '';
    public $_labels_add_new_item = '';
    public $_labels_new_item_name = '';
    public $_labels_parent_item = '';
    public $_labels_parent_item_colon = '';
    public $_labels_search_items = '';
    public $_labels_popular_items = '';
    public $_labels_separate_items_with_commas = '';
    public $_labels_add_or_remove_items = '';
    public $_labels_choose_from_most_used = '';
    public $_labels_not_found = '';
    public $_labels_no_terms = '';
    public $_labels_items_list_navigation = '';
    public $_labels_items_list = '';
    public $_labels_most_used = '';
    public $_labels_back_to_items = '';

    public $taxonomy = '';
    public $label = '';
    public $labels = array();
    public $description = '';

    public $public = true;
    public $show_ui = null;
    public $show_in_menu = null;
    public $show_in_nav_menus = null;
    public $show_tagcloud = null;
    public $show_in_quick_edit = null;
    public $publicly_queryable = null;
    public $show_admin_column = false;
    public $show_in_rest = false;

    public $hierarchical = false;
    public $query_var = true;
    public $rewrite = true;
    public $capabilities = null;
    public $sort = false;

    public function run() {
        if ($this->_status) {
            add_action('gdcet_init_register_taxonomies', array($this, 'register'));
            add_action('gdcet_init_rewriter_rules', array($this, 'rewriter_rules'));

            if (is_admin()) {
                if ($this->_extra_post_meta_box != 'auto') {
                    gdcet_ctrl()->mod_tax_metabox[$this->taxonomy] = $this->_extra_post_meta_box;
                }

                if ($this->_extra_assign_image) {
                    gdcet_ctrl()->mod_tax_image[] = $this->taxonomy;
                }

                if ($this->_extra_post_edit_filter) {
                    gdcet_ctrl()->mod_tax_filter[] = $this->taxonomy;
                }
            }
        }
    }

    public function rewriter_rules() {
        if ($this->_permalinks_index) {
            gdcet_ctrl()->rewriter->add('taxonomy', 'index', $this->taxonomy);
        }
    }

    public function validate() {
        $errors = new d4p_errors();

        if (empty($this->taxonomy)) {
            $errors->add('name', __("Taxonomy name is missing.", "gd-content-tools"));
        } else {
            if (strlen($this->taxonomy) > 32) {
                $errors->add('name', __("Taxonomy name is too long (32 characters max).", "gd-content-tools"));
            }

            $exclude = $this->_id > 0 ? array($this->taxonomy) : array();

            $keywords = gdcet_admin_shared_data::restricted_keywords($exclude);
            if (in_array($this->taxonomy, $keywords)) {
                $errors->add('name', __("Taxonomy name keyword is already in use.", "gd-content-tools"));
            }
        }

        if (empty($this->_labels_name)) {
            $errors->add('label', __("Plural label is missing.", "gd-content-tools"));
        }

        if (empty($this->_labels_singular_name)) {
            $errors->add('label', __("Singular label is missing.", "gd-content-tools"));
        }

        return empty($errors->errors) ? true : $errors;
    }

    public function register() {
        $args = $this->build_registration();

        register_taxonomy($this->taxonomy, $this->_post_types, $args);
        gdcet_ctrl()->tax_activated[] = $this->taxonomy;
    }

    public function slug_archive() {
        if (!empty($this->_rewrite_slug)) {
            return $this->_rewrite_slug;
        }

        return $this->taxonomy;
    }

    public function slug_query_var() {
        if (!empty($this->_query_var_slug)) {
            return $this->_query_var_slug;
        }

        return $this->taxonomy;
    }

    public function id() {
        return $this->_id;
    }

    public function total_terms() {
        if (taxonomy_exists($this->taxonomy)) {
            return wp_count_terms($this->taxonomy);
        }

        return 0;
    }

    public function fill_capabilities() {
        $defaults = array(
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_posts'
        );

        foreach ($defaults as $key => $value) {
            $property = '_capability_'.$key;

            if ($this->$property == '') {
                $this->$property = $value;
            }
        }
    }

    public function fill_labels() {
        $defaults = array(
            'menu_name' => '{{plural}}',
            'all_items' => 'All {{plural}}',
            'edit_item' => 'Edit {{singular}}', 
            'view_item' => 'View {{singular}}', 
            'update_item' => 'Update {{singular}}',
            'add_new_item' => 'Add New {{singular}}', 
            'new_item_name' => 'New {{singular}} Name',
            'parent_item' => 'Parent {{singular}}', 
            'parent_item_colon' => 'Parent {{singular}}:', 
            'search_items' => 'Search {{plural}}',
            'popular_items' => 'Popular {{plural}}',
            'separate_items_with_commas' => 'Separate {{plural}} with commas',
            'add_or_remove_items' => 'Add or remove {{plural}}',
            'choose_from_most_used' => 'Choose from most used {{plural}}',
            'not_found' => 'No {{plural}} Found',
            'no_terms' => 'No {{plural}}',
            'items_list_navigation' => '{{plural}} list navigation',
            'items_list' => '{{plural}} list',
            'most_used' => 'Most Used',
            'back_to_items' => '&larr; Back to {{plural}}'
        );

        foreach ($defaults as $key => $value) {
            $property = '_labels_'.$key;

            if ($this->$property == '') {
                $value = str_replace('{{plural}}', $this->_labels_name, $value);
                $value = str_replace('{{singular}}', $this->_labels_singular_name, $value);

                $this->$property = $value;
            }
        }
    }

    public function display_visibility() {
        return $this->_public ? __("Public", "gd-content-tools") : __("Private", "gd-content-tools");
    }

    public function display_archive() {
        $display = '&minus;';

        if ($this->_rewrite) {
            $display = $this->slug_archive();
        }

        return $display;
    }

    public function display_query_var() {
        $display = '&minus;';

        if ($this->_query_var) {
            $display = $this->slug_query_var();
        }

        return $display;
    }

    public function build_registration() {
        $include = array('taxonomy', 'label', 'labels', 'description', 'public', 'show_ui', 'show_in_menu', 'show_in_rest', 'show_in_nav_menus', 'show_tagcloud', 'show_in_quick_edit', 'show_admin_column', 'hierarchical', 'query_var', 'rewrite', 'capabilities', 'sort');

        $this->name = $this->taxonomy;

        $this->_build_labels();
        $this->_build_visibility();
        $this->_build_query_var();
        $this->_build_rewrite();
        $this->_build_caps();

        $build = array();

        foreach ($include as $key) {
            $build[$key] = $this->{$key};
        }

        if (!empty($this->_rest_rest_base)) {
            $build['rest_base'] = $this->_rest_rest_base;
        }

        if (!empty($this->_rest_rest_controller_class)) {
            $build['rest_controller_class'] = $this->_rest_rest_controller_class;
        }

        $build = apply_filters('gdcet_taxonomy_registration', $build, $this->taxonomy);
        $build = apply_filters('gdcet_taxonomy_registration_'.$this->taxonomy, $build);

        return $build;
    }

    private function _build_labels() {
        $labels = array('name', 'singular_name', 'menu_name', 'all_items', 'edit_item', 'view_item', 'update_item', 'add_new_item', 'new_item_name', 'parent_item', 'parent_item_colon', 'search_items', 'popular_items', 'separate_items_with_commas', 'add_or_remove_items', 'choose_from_most_used', 'not_found', 'no_terms', 'items_list_navigation', 'items_list', 'most_used', 'back_to_items');
        
        $this->label = $this->_labels_name;

        foreach ($labels as $l) {
            $this->labels[$l] = $this->{'_labels_'.$l};
        }
    }

    private function _build_visibility() {
        $this->public = $this->_public;

        if ($this->_public_override) {
            $this->show_ui = in_array('show_ui', $this->_visibility);
            $this->show_in_menu = in_array('show_in_menu', $this->_visibility);
            $this->show_in_nav_menus = in_array('show_in_nav_menus', $this->_visibility);
            $this->show_tagcloud = in_array('show_tagcloud', $this->_visibility);
            $this->show_in_quick_edit = in_array('show_in_quick_edit', $this->_visibility);
            $this->show_admin_column = in_array('show_admin_column', $this->_visibility);
            $this->publicly_queryable = in_array('publicly_queryable', $this->_visibility);
        } else {
            $this->show_ui = $this->public;
            $this->show_in_menu = $this->show_ui;
            $this->show_in_nav_menus = $this->show_ui;
            $this->show_tagcloud = $this->show_ui;
            $this->show_in_quick_edit = $this->show_ui;
            $this->show_admin_column = $this->show_ui;
            $this->publicly_queryable = $this->show_ui;
        }

        $this->show_in_rest = $this->_visibility_show_in_rest;
    }

    private function _build_query_var() {
        $this->query_var = false;

        if ($this->_query_var) {
            $this->query_var = $this->_query_var_slug == '' ? true : $this->_query_var_slug;
        }
    }

    private function _build_rewrite() {
        $this->rewrite = false;

        if ($this->_rewrite) {
            if (!empty($this->_rewrite_slug)) {
                $this->rewrite = array(
                    'slug' => $this->_rewrite_slug,
                    'with_front' => $this->_rewrite_with_front,
                    'hierarchical' => $this->_rewrite_hierarchical
                );
            } else {
                $this->rewrite = true;
            }
        }
    }

    private function _build_caps() {
        $caps = array('manage_terms', 'edit_terms', 'delete_terms', 'assign_terms');

        foreach ($caps as $cap) {
            $this->capabilities[$cap] = $this->{'_capability_'.$cap};
        }
    }
}

class gdcet_base_tax_override extends gdcet_data_class {
    public $_extra_assign_image = false;
    public $_extra_post_edit_filter = false;
    public $_extra_post_meta_box = 'auto';

    public $taxonomy = '';

    public function run() {
        if (is_admin()) {
            if ($this->_extra_post_meta_box != 'auto') {
                gdcet_ctrl()->mod_tax_metabox[$this->taxonomy] = $this->_extra_post_meta_box;
            }

            if ($this->_extra_assign_image) {
                gdcet_ctrl()->mod_tax_image[] = $this->taxonomy;
            }

            if ($this->_extra_post_edit_filter) {
                gdcet_ctrl()->mod_tax_filter[] = $this->taxonomy;
            }
        }
    }
}
