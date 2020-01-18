<?php

if (!defined('ABSPATH')) exit;

class gdcet_base_cpt extends gdcet_data_class {
    public $_id = 0;
    public $_status = true;

    public $_icon = 'dashicon';
    public $_icon_dashicons = 'admin-post';
    public $_icon_sprite = 'book-open-text-image';
    public $_icon_url = '';
    public $_icon_image = 0;
    public $_icon_embed = '';

    public $_editor = 'classic';

    public $_extra_dashboard_glance = true;
    public $_extra_menu_archive = false;
    public $_extra_menu_draft = false;
    public $_extra_menu_future = false;
    public $_extra_remove_quick_edit = false;
    public $_extra_home_page = false;
    public $_extra_rss_feed = false;
    public $_extra_post_template = false;
    public $_extra_amp = false;

    public $_permalinks_single_active = false;
    public $_permalinks_single_structure = null;

    public $_permalinks_date_archives = false;
    public $_permalinks_author_archives = false;
    public $_permalinks_author_slug = 'author';

    public $_permalinks_intersect_archives = false;
    public $_permalinks_archive_intersection_simple = true;
    public $_permalinks_archive_intersection_custom = false;
    public $_permalinks_archive_intersection_structure = '';
    public $_permalinks_archive_intersection_partial = false;
    public $_permalinks_archive_intersection_baseless = '';

    public $_public = true;
    public $_public_override = false;
    public $_visibility = array('publicly_queryable', 'show_ui', 'show_in_nav_menus', 'show_in_menu', 'show_in_admin_bar');

    public $_capabilities = 'type';
    public $_capability_base = 'post';
    public $_capability_edit_post = '';
    public $_capability_read_post = '';
    public $_capability_delete_post = '';
    public $_capability_edit_posts = '';
    public $_capability_edit_others_posts = '';
    public $_capability_publish_posts = '';
    public $_capability_read_private_posts = '';

    public $_query_var = true;
    public $_query_var_slug = '';
    public $_archive = true;
    public $_archive_slug = '';

    public $_rewrite = true;
    public $_rewrite_slug = '';
    public $_rewrite_with_front = true;
    public $_rewrite_feeds = true;
    public $_rewrite_pages = true;

    public $_labels_name = '';
    public $_labels_singular_name = '';

    public $_labels_add_new = '';
    public $_labels_add_new_item = '';
    public $_labels_edit_item = ''; 
    public $_labels_new_item = '';
    public $_labels_view_item = ''; 
    public $_labels_search_items = '';
    public $_labels_not_found = ''; 
    public $_labels_not_found_in_trash = '';
    public $_labels_parent_item_colon = ''; 
    public $_labels_all_items = '';
    public $_labels_archives = '';
    public $_labels_name_admin_bar = '';
    public $_labels_menu_name = '';
    public $_labels_insert_into_item = '';
    public $_labels_uploaded_to_this_item = '';
    public $_labels_featured_image = '';
    public $_labels_set_featured_image = '';
    public $_labels_remove_featured_image = '';
    public $_labels_use_featured_image = '';
    public $_labels_filter_items_list = '';
    public $_labels_items_list_navigation = '';
    public $_labels_items_list = '';
    public $_labels_view_items = '';
    public $_labels_attributes = '';
    public $_labels_item_published = '';
    public $_labels_item_published_privately = '';
    public $_labels_item_reverted_to_draft = '';
    public $_labels_item_scheduled = '';
    public $_labels_item_updated = '';

    public $_menu_position = '__auto__';

    public $post_type = '';
    public $name = '';
    public $label = '';
    public $labels = array();
    public $description = '';

    public $public = null;
    public $exclude_from_search = null;
    public $publicly_queryable = null;
    public $show_ui = null;
    public $show_in_nav_menus = null;
    public $show_in_menu = null;
    public $show_in_admin_bar = null;

    public $menu_icon = null;
    public $menu_position = null;

    public $capability_type = 'post';
    public $capabilities = null;
    public $map_meta_cap = true;

    public $hierarchical = false;
    public $supports = array('title', 'editor', 'author', 'revisions', 'thumbnail');
    public $taxonomies = array();
    public $has_archive = false;
    public $rewrite = true;
    public $query_var = true;

    public $show_in_rest = true;
    public $rest_base = null;

    public $can_export = true;

    public function run() {
        if ($this->_status) {
            add_action('gdcet_init_register_post_types', array($this, 'register'));
            add_action('gdcet_init_assign_taxonomies', array($this, 'assign_taxonomies'));

            if ($this->_permalinks_single_active) {
                add_filter('gdcet_rewriter_query_vars', array($this, 'rewriter_query_vars'));
                add_action('gdcet_init_register_permalinks', array($this, 'register_permalinks'));
            }

            if (GDCET_WPV > 49 && $this->_editor != 'default') {
                add_filter('use_block_editor_for_post_type', array($this, 'classic_editor'), 10, 2);
            }

            if (is_admin()) {
                if ($this->_extra_post_template) {
                    add_action('gdcet_admin_meta_boxes_for_'.$this->post_type, array(gdcet_admin_metabox(), 'meta_post_template'));
                    add_action('gdcet_admin_meta_boxes_for_'.$this->post_type.'_save', array(gdcet_admin_metabox(), 'meta_post_template_save'), 10, 5);
                }

                if ($this->_extra_menu_draft) {
                    add_action('admin_menu', array($this, 'admin_menu_draft'), 1000);
                }

                if ($this->_extra_menu_future) {
                    add_action('admin_menu', array($this, 'admin_menu_future'), 1010);
                }

                if ($this->_extra_menu_archive) {
                    add_action('admin_menu', array($this, 'admin_menu_archive'), 1020);
                }

                if ($this->_extra_dashboard_glance) {
                    add_action('dashboard_glance_items', array($this, 'dashboard_glance_items'));
                }

                if ($this->_extra_remove_quick_edit) {
                    add_filter('post_row_actions', array($this, 'post_row_actions'), 10, 2);
                    add_filter('page_row_actions', array($this, 'post_row_actions'), 10, 2);
                }
            } else {
                if ($this->_extra_home_page) {
                    gdcet_ctrl()->mod_cpt_expand_home[] = $this->post_type;
                }

                if ($this->_extra_rss_feed) {
                    gdcet_ctrl()->mod_cpt_expand_feed[] = $this->post_type;
                }
            }
        } else {
            add_action('gdcet_init_register_post_types', array($this, 'register_sprite'));
        }
    }

    public function register() {
        $args = $this->build_registration();

        $this->register_sprite();
        $this->rewriter_rules();

        register_post_type($this->post_type, $args);
        gdcet_ctrl()->cpt_activated[] = $this->post_type;

        if ($this->_extra_amp) {
            add_action('amp_init', array($this, 'amp'));
        }
    }

    public function classic_editor($use_block_editor, $post_type) {
        if ($this->post_type == $post_type) {
            $use_block_editor = false;
        }

        return $use_block_editor;
    }

    public function amp() {
        if (defined('AMP_QUERY_VAR')) {
            add_post_type_support($this->post_type, AMP_QUERY_VAR);
        }
    }

    public function register_sprite() {
        if ($this->_icon == 'sprite') {
            gdcet_ctrl()->sprites->add($this->_icon_sprite, $this->post_type);
        }
    }

    public function assign_taxonomies() {
        foreach ($this->taxonomies as $taxonomy) {
            register_taxonomy_for_object_type($taxonomy, $this->post_type);
        }
    }

    public function rewriter_rules() {
        if ($this->_permalinks_date_archives) {
            gdcet_ctrl()->rewriter->add('post_type', 'date_archives', $this->post_type);
        }

        if ($this->_permalinks_author_archives) {
            gdcet_ctrl()->rewriter->add('post_type', 'author_archives', $this->post_type, array(
                'slug' => $this->_permalinks_author_slug
            ));
        }

        if ($this->_permalinks_intersect_archives) {
            gdcet_ctrl()->rewriter->add('post_type', 'intersect_archives', $this->post_type, array(
                'simple' => $this->_permalinks_archive_intersection_simple,
                'custom' => $this->_permalinks_archive_intersection_custom,
                'partial' => $this->_permalinks_archive_intersection_partial,
                'structure' => $this->_permalinks_archive_intersection_structure,
                'baseless' => $this->_permalinks_archive_intersection_baseless
            ));
        }
    }

    public function rewriter_query_vars($qv) {
        $qv[] = 'cpt_postid_'.$this->post_type;

        return $qv;
    }

    public function register_permalinks() {
        global $wp_rewrite;

        $wp_rewrite->add_rewrite_tag('%'.$this->post_type.'_id%', '([0-9]+)', 'cpt_postid_'.$this->post_type.'=');

        $wp_rewrite->extra_permastructs[$this->post_type]['struct'] = $this->_permalinks_single_structure;
    }

    public function validate($panel = '') {
        $errors = new d4p_errors();

        $this->_permalinks_single_structure = trim($this->_permalinks_single_structure);
        $this->_permalinks_archive_intersection_structure = trim($this->_permalinks_archive_intersection_structure);

        if (empty($this->_permalinks_single_structure)) {
            $this->_permalinks_single_active = false;
        }

        if (empty($this->_permalinks_archive_intersection_structure)) {
            $this->_permalinks_archive_intersection_custom = false;
        }

        if (empty($this->post_type)) {
            $errors->add('post_type', __("Post type name is missing.", "gd-content-tools"));
        } else {
            if (strlen($this->post_type) > 20) {
                $errors->add('post_type', __("Post type name is too long (20 characters max).", "gd-content-tools"));
            }

            $exclude = $this->_id > 0 ? array($this->post_type) : array();

            $keywords = gdcet_admin_shared_data::restricted_keywords($exclude);
            if (in_array($this->post_type, $keywords)) {
                $errors->add('post_type', __("Post type name keyword is already in use.", "gd-content-tools"));
            }
        }

        if (empty($this->_labels_name)) {
            $errors->add('_labels_name', __("Plural label is missing.", "gd-content-tools"));
        }

        if (empty($this->_labels_singular_name)) {
            $errors->add('_labels_singular_name', __("Singular label is missing.", "gd-content-tools"));
        }

        return empty($errors->errors) ? true : $errors;
    }

    public function archive_link() {
        return get_post_type_archive_link($this->post_type);
    }

    public function slug_single() {
        if (!empty($this->_rewrite_slug)) {
            return $this->_rewrite_slug;
        }

        return $this->post_type;
    }

    public function slug_archive() {
        if (!empty($this->_archive_slug)) {
            return $this->_archive_slug;
        }

        return $this->post_type;
    }

    public function slug_query_var() {
        if (!empty($this->_query_var_slug)) {
            return $this->_query_var_slug;
        }

        return $this->post_type;
    }
    
    public function id() {
        return $this->_id;
    }

    public function allow_name_edit() {
        return $this->total_posts() == 0;
    }

    public function posts_counts() {
        if (post_type_exists($this->post_type)) {
            return wp_count_posts($this->post_type);
        }

        return array();
    }

    public function total_posts() {
        $count = 0;

        foreach ($this->posts_counts() as $key => $cnt) {
            if ($key != 'auto-draft') {
                $count+= $cnt;
            }
        }

        return $count;
    }

    public function fill_capabilities() {
        $defaults = array(
            'edit_post' => 'edit_{{cap}}',
            'read_post' => 'read_{{cap}}',
            'delete_post' => 'delete_{{cap}}',
            'edit_posts' => 'edit_{{cap}}s',
            'edit_others_posts' => 'edit_others_{{cap}}s',
            'publish_posts' => 'publish_{{cap}}s',
            'read_private_posts' => 'read_private_{{cap}}s'
        );

        foreach ($defaults as $key => $value) {
            $property = '_capability_'.$key;

            if ($this->$property == '') {
                $value = str_replace('{{cap}}', $this->_capability_base, $value);

                $this->$property = $value;
            }
        }
    }

    public function fill_labels() {
        $defaults = array(
            'add_new' => 'Add New',
            'add_new_item' => 'Add New {{singular}}',
            'edit_item' => 'Edit {{singular}}', 
            'new_item' => 'New {{singular}}',
            'view_item' => 'View {{singular}}', 
            'search_items' => 'Search {{plural}}',
            'not_found' => 'No {{plural}} found', 
            'not_found_in_trash' => 'No {{plural}} found in Trash',
            'parent_item_colon' => 'Parent {{singular}}:', 
            'all_items' => 'All {{plural}}',
            'archives' => '{{singular}} Archives',
            'name_admin_bar' => '{{singular}}',
            'menu_name' => '{{plural}}',
            'insert_into_item' => 'Insert into {{singular}}',
            'uploaded_to_this_item' => 'Uploaded to this {{singular}}',
            'featured_image' => 'Featured Image',
            'set_featured_image' => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image' => 'Use featured image',
            'filter_items_list' => 'Filter {{plural}} list',
            'items_list_navigation' => '{{plural}} list navigation',
            'items_list' => '{{plural}} list',
            'view_items' => 'View {{plural}}',
            'attributes' => '{{singular}} Attributes',
            'item_published' => '{{singular}} published',
            'item_published_privately' => '{{singular}} published privately',
            'item_reverted_to_draft' => '{{singular}} reverted to draft',
            'item_scheduled' => '{{singular}} scheduled',
            'item_updated' => '{{singular}} updated'
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

    public function build_registration() {
        $include = array('name', 'label', 'labels', 'description', 'public', 'exclude_from_search', 'publicly_queryable', 'show_ui', 'show_in_nav_menus', 'show_in_menu', 'show_in_admin_bar', 'menu_icon', 'menu_position', 'capability_type', 'capabilities', 'map_meta_cap', 'hierarchical', 'supports', 'has_archive', 'rewrite', 'query_var', 'show_in_rest', 'rest_base', 'can_export');

        $this->name = $this->post_type;

        if ($this->_menu_position != '__auto__') {
            if ($this->_menu_position != '__block__') {
                $this->menu_position = absint($this->_menu_position);
            }
        }

        if ($this->rest_base == '') {
            $this->rest_base = $this->post_type;
        }

        $this->_build_icon();
        $this->_build_labels();
        $this->_build_visibility();
        $this->_build_archive();
        $this->_build_query_var();
        $this->_build_rewrite();
        $this->_build_caps();

        $build = array();

        foreach ($include as $key) {
            $build[$key] = $this->{$key};
        }

        $build = apply_filters('gdcet_post_type_registration', $build, $this->post_type);
        $build = apply_filters('gdcet_post_type_registration_'.$this->post_type, $build);
        
        return $build;
    }

    public function get_taxonomies() {
        if (post_type_exists($this->post_type)) {
            return get_object_taxonomies($this->post_type, 'names');
        } else {
            return $this->taxonomies;
        }
    }

    private function _build_icon() {
        switch ($this->_icon) {
            case 'dashicon':
                $this->menu_icon = 'dashicons-'.$this->_icon_dashicons;
                break;
            case 'embed':
                $this->menu_icon = $this->_icon_embed;
                break;
            case 'image':
                $this->menu_icon = wp_get_attachment_url($this->_icon_image);
                break;
            case 'url':
                $this->menu_icon = $this->_icon_url;
                break;
            case 'sprite':
                $this->menu_icon = null;
                break;
        }
    }

    private function _build_labels() {
        $labels = array('name', 'singular_name', 'add_new', 'add_new_item', 'edit_item', 'new_item', 'view_item', 'search_items', 'not_found', 'not_found_in_trash', 'parent_item_colon', 'all_items', 'archives', 'name_admin_bar', 'menu_name', 'insert_into_item', 'uploaded_to_this_item', 'featured_image', 'set_featured_image', 'remove_featured_image', 'use_featured_image', 'filter_items_list', 'items_list_navigation', 'items_list', 'view_items', 'attributes', 'item_published', 'item_published_privately', 'item_reverted_to_draft', 'item_scheduled', 'item_updated');

        $this->label = $this->_labels_name;

        foreach ($labels as $l) {
            $this->labels[$l] = $this->{'_labels_'.$l};
        }
    }

    private function _build_visibility() {
        $this->public = $this->_public;

        if ($this->_public_override) {
            $this->exclude_from_search = in_array('exclude_from_search', $this->_visibility);
            $this->publicly_queryable = in_array('publicly_queryable', $this->_visibility);
            $this->show_ui = in_array('show_ui', $this->_visibility);
            $this->show_in_menu = in_array('show_in_menu', $this->_visibility);
            $this->show_in_nav_menus = in_array('show_in_nav_menus', $this->_visibility);
            $this->show_in_admin_bar = in_array('show_in_admin_bar', $this->_visibility);
        } else {
            $this->exclude_from_search = !$this->public;
            $this->publicly_queryable = $this->public;
            $this->show_ui = $this->public;
            $this->show_in_menu = $this->show_ui;
            $this->show_in_nav_menus = $this->show_ui;
            $this->show_in_admin_bar = $this->show_ui;
        }
    }

    private function _build_archive() {
        $this->has_archive = false;

        if ($this->_archive) {
            $this->has_archive = $this->_archive_slug == '' ? true : $this->_archive_slug;
        }
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
                    'pages' => $this->_rewrite_pages,
                    'feeds' => $this->_rewrite_feeds
                );
            } else {
                $this->rewrite = true;
            }
        }
    }

    private function _build_caps() {
        $this->capabilities = array();

        if ($this->_capabilities == 'type') {
            $this->capability_type = $this->_capability_base;
        } else if ($this->_capabilities == 'caps') {
            $caps = array('edit_post', 'read_post', 'delete_post', 'edit_posts', 'edit_others_posts', 'publish_posts', 'read_private_posts');

            foreach ($caps as $cap) {
                $this->capabilities[$cap] = $this->{'_capability_'.$cap};
            }
        }
    }

    public function display_editor() {
        return $this->_editor == 'classic' ? __("Classic", "gd-content-tools") : __("Block", "gd-content-tools");
    }

    public function display_archive() {
        $display = '&minus;';

        if ($this->_archive) {
            if ($this->_status) {
                $display = '<a href="'.get_post_type_archive_link($this->post_type).'" target="_blank">'.$this->slug_archive().'</a>';
            } else {
                $display = $this->slug_archive();
            }
        }

        return $display;
    }

    public function display_single() {
        $display = '&minus;';

        if ($this->_rewrite) {
            $display = $this->slug_single();
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

    public function display_visibility() {
        return $this->_public ? __("Public", "gd-content-tools") : __("Private", "gd-content-tools");
    }

    public function display_supports() {
        $display = array();

        foreach (gdcet_admin_shared_data::get_list_of_post_types_supports() as $key => $name) {
            if (in_array($key, $this->supports)) {
                $display[] = $name;
            }
        }

        return join(', ', $display);
    }

    public function dashboard_glance_items($items = array()) {
        $num_posts = wp_count_posts($this->post_type);

        if ($num_posts && $num_posts->publish) {
            $_singular = "%s ".$this->_labels_singular_name;
            $_plural = "%s ".$this->_labels_name;

            $text = _n($_singular, $_plural, $num_posts->publish, "gd-content-tools");

            $text = sprintf($text, number_format_i18n( $num_posts->publish ) );
            $post_type_object = get_post_type_object($this->post_type);

            if ($this->_icon == 'dashicon') {
                $text = '<i class="dashicons dashicons-'.$this->_icon_dashicons.'"></i> '.$text;
            } else {
                $text = '<i class="dashicons dashicons-marker"></i> '.$text;
            }

            if ($post_type_object && current_user_can($post_type_object->cap->edit_posts)) {
                $items[] = sprintf('<a class="gdcet-glance-type" href="edit.php?post_type=%1$s">%2$s</a>', $this->post_type, $text);
            } else {
                $items[] = sprintf('<span class="gdcet-glance-type">%2$s</span>', $this->post_type, $text);
            }
        }

        return $items;
    }

    public function admin_menu_archive() {
        if (post_type_exists($this->post_type)) {
            $post_type = get_post_type_object($this->post_type);

            if ($post_type->has_archive) {
                $parent_url = 'edit.php';

                if ($this->post_type != 'post') {
                    $parent_url.= '?post_type='.$this->post_type;
                }

                $menu_url = 'gdcet-archive='.urlencode(get_post_type_archive_link($this->post_type));

                add_submenu_page($parent_url, __("Archive", "gd-content-tools"), __("Archive", "gd-content-tools"), $post_type->cap->edit_posts, $menu_url);
            }
        }
    }

    public function admin_menu_draft() {
        $this->_menu_item_status('draft', __("Drafts", "gd-content-tools"));
    }

    public function admin_menu_future() {
        $this->_menu_item_status('future', __("Scheduled", "gd-content-tools"));
    }

    public function post_row_actions($actions, $post) {
        if ($post->post_type == $this->post_type) {
            unset($actions['inline hide-if-no-js']);
        }

        return $actions;
    }

    private function _menu_item_status($status_name = 'draft', $status_label = 'Drafts') {
        $status = get_post_status_object($status_name);

        if (post_type_exists($this->post_type)) {
            $counts = wp_count_posts($this->post_type, 'readable');
            $drafts = intval($counts->{$status_name});

            if ($drafts > 0) {
                $post_type = get_post_type_object($this->post_type);

                $parent_url = 'edit.php';

                if ($this->post_type != 'post') {
                    $parent_url.= '?post_type='.$this->post_type;
                }

                $menu_url = add_query_arg('post_status', $status_name, $parent_url);

                add_submenu_page($parent_url, $post_type->labels->view_item.': '.$status_label, 
                                    sprintf(translate_nooped_plural($status->label_count, $drafts), $drafts), 
                                    $post_type->cap->edit_posts, $menu_url);
            }
        }
    }
}

class gdcet_base_cpt_override extends gdcet_data_class {
    public $_override_taxonomies = false;
    public $_clear_all_previous_taxonomies = false;

    public $_extra_menu_archive = false;
    public $_extra_menu_draft = false;
    public $_extra_menu_future = false;
    public $_extra_remove_quick_edit = false;
    public $_extra_home_page = false;
    public $_extra_rss_feed = false;
    public $_extra_post_template = false;

    public $post_type = '';

    public $taxonomies = array();

    public function run() {
        if ($this->_override_taxonomies) {
            add_action('gdcet_init_late_register_post_types', array($this, 'assign_taxonomies'));
        }

        if (is_admin()) {
            if ($this->_extra_post_template) {
                add_action('gdcet_admin_meta_boxes_for_'.$this->post_type, array(gdcet_admin_metabox(), 'meta_post_template'));
                add_action('gdcet_admin_meta_boxes_for_'.$this->post_type.'_save', array(gdcet_admin_metabox(), 'meta_post_template_save'), 10, 5);
            }

            if ($this->_extra_menu_draft) {
                add_action('admin_menu', array($this, 'admin_menu_draft'), 1000);
            }

            if ($this->_extra_menu_future) {
                add_action('admin_menu', array($this, 'admin_menu_future'), 1010);
            }

            if ($this->_extra_menu_archive) {
                add_action('admin_menu', array($this, 'admin_menu_archive'), 1020);
            }

            if ($this->_extra_remove_quick_edit) {
                add_filter('post_row_actions', array($this, 'post_row_actions'), 10, 2);
                add_filter('page_row_actions', array($this, 'post_row_actions'), 10, 2);
            }
        } else {
            if ($this->_extra_home_page) {
                gdcet_ctrl()->mod_cpt_expand_home[] = $this->post_type;
            }

            if ($this->_extra_rss_feed) {
                gdcet_ctrl()->mod_cpt_expand_feed[] = $this->post_type;
            }
        }
    }

    public function assign_taxonomies() {
        if ($this->_clear_all_previous_taxonomies) {
            $all = get_object_taxonomies($this->post_type, 'names');

            foreach ($all as $taxonomy) {
                unregister_taxonomy_for_object_type($taxonomy, $this->post_type);
            }
        }

        foreach ($this->taxonomies as $taxonomy) {
            register_taxonomy_for_object_type($taxonomy, $this->post_type);
        }
    }

    public function admin_menu_archive() {
        if (post_type_exists($this->post_type)) {
            $post_type = get_post_type_object($this->post_type);

            if ($post_type->has_archive) {
                $parent_url = 'edit.php';

                if ($this->post_type != 'post') {
                    $parent_url.= '?post_type='.$this->post_type;
                }

                $menu_url = get_post_type_archive_link($this->post_type);

                add_submenu_page($parent_url, __("Archive", "gd-content-tools"), __("Archive", "gd-content-tools"), $post_type->cap->edit_posts, $menu_url);
            }
        }
    }

    public function admin_menu_draft() {
        $this->_menu_item_status('draft', __("Drafts", "gd-content-tools"));
    }

    public function admin_menu_future() {
        $this->_menu_item_status('future', __("Scheduled", "gd-content-tools"));
    }

    function post_row_actions($actions, $post) {
        if ($post->post_type == $this->post_type) {
            unset($actions['inline hide-if-no-js']);
        }

        return $actions;
    }
}
