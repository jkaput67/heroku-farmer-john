<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_core extends d4p_admin_core {
    public $plugin = 'gd-content-tools';
    public $post_type = '';
    public $taxonomy = '';
    public $term = 0;
    public $user_roles = array();
    public $feedback = false;

    public $meta_boxes = array(
        'terms' => array(),
        'users' => array()
    );

    public function __construct() {
        parent::__construct();

        $this->url = GDCET_URL;

        add_action('gdcet_plugin_init', array($this, 'core'));

        add_action('admin_menu', array($this, 'admin_menu_update'), 99999);

        $this->meta();
    }

    public function meta() {
        $this->taxonomy = isset($_GET['taxonomy']) ? d4p_sanitize_key_expanded($_GET['taxonomy']) : '';
        $this->term = isset($_GET['tag_ID']) ? absint($_GET['tag_ID']) : 0;

        add_action('load-term.php', array($this, 'admin_meta_term'));
        add_action('load-profile.php', array($this, 'admin_meta_user'));
        add_action('load-user-edit.php', array($this, 'admin_meta_user'));

        add_action('personal_options_update', array($this, 'admin_meta_user_save'));
        add_action('edit_user_profile_update', array($this, 'admin_meta_user_save'));

        add_action('edited_term', array($this, 'admin_meta_term_save'));
    }

    public function admin_menu_update() {
        global $submenu;

        foreach ($submenu as &$_menu) {
            foreach ($_menu as &$single) {
                if (substr($single[2], 0, 14) == 'gdcet-archive=') {
                    $single[2] = urldecode(substr($single[2], 14));
                }
            }
        }
    }

    public function admin_meta() {
        global $pagenow;

        if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
            global $post;

            do_action('gdcet_metabox_post', $this->post_type, $post->ID);
            do_action('gdcet_metabox_post_'.$this->post_type, $post->ID);
        }
    }

    public function admin_meta_term() {
        if (!empty($this->taxonomy)) {
            do_action('gdcet_metabox_term', $this->taxonomy, $this->term);
            do_action('gdcet_metabox_term_'.$this->taxonomy, $this->term);

            add_action($this->taxonomy.'_edit_form_fields', array($this, 'metabox_term'), 10, 2);
        }
    }

    public function admin_meta_term_save($term_id) {
        do_action('gdcet_term_save', $term_id);
    }

    public function metabox_term($term, $taxonomy) {
        foreach ($this->meta_boxes['terms'] as $_meta_term) {
            if (in_array($taxonomy, $_meta_term['taxonomies'])) {
                echo '</table>';

                echo '<div class="poststuff">';
                    echo '<h2>'.$_meta_term['label'].'</h2>';
                    echo '<div class="inside">';
                        echo '<div class="gdcet-admin-metabox-wrapper">';

                        call_user_func($_meta_term['callback'], $term, array('args' => $_meta_term['args']));

                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                echo '<table class="form-table">';
            }
        }
    }

    public function admin_meta_user() {
        global $pagenow;

        $user_id = 0;
        if ($pagenow == 'profile.php') {
            $user_id = get_current_user_id();
        } else if ($pagenow == 'user-edit.php' && isset($_GET['user_id'])) {
            $user_id = absint($_GET['user_id']);
        }

        if ($user_id > 0) {
            do_action('gdcet_metabox_user', $user_id);

            add_action('show_user_profile', array($this, 'metabox_user'));
            add_action('edit_user_profile', array($this, 'metabox_user'));
        }
    }

    public function admin_meta_user_save($user_id) {
        do_action('gdcet_user_save', $user_id);
    }

    public function metabox_user($user) {
        $user_roles = (array)$user->roles;

        foreach ($this->meta_boxes['users'] as $_meta_user) {
            if (array_intersect($user_roles, $_meta_user['roles'])) {
                echo '<div class="poststuff">';
                    echo '<h2>'.$_meta_user['label'].'</h2>';
                    echo '<div class="inside">';
                        echo '<div class="gdcet-admin-metabox-wrapper">';

                        call_user_func($_meta_user['callback'], $user, array('args' => $_meta_user['args']));

                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        }
    }

    public function file($type, $name, $d4p = false, $min = true, $url = null) {
        $get = is_null($url) ? $this->url : $url;

        if ($d4p) {
            $get.= 'd4plib/resources/';
        }

        if ($name == 'font') {
            $get.= 'font/styles.css';
        } else if ($name == 'flags') {
            $get.= 'flags/flags.css';
        } else {
            $get.= $type.'/'.$name;

            if (!$this->is_debug && $type != 'font' && $min) {
                $get.= '.min';
            }

            $get.= '.'.$type;
        }

        return $get;
    }

    public function get_taxonomy() {
        if (isset($_GET['taxonomy'])) {
            return trim($_GET['taxonomy']);
        } else if ($this->taxonomy != '') {
            return $this->taxonomy;
        }

        return false;
    }

    public function get_post_type() {
        if (isset($_GET['post_type'])) {
            return trim($_GET['post_type']);
        } else if ($this->post_type != '') {
            return $this->post_type;
        } else {
            global $post;

            if ($post) {
                return $post->post_type;
            }
        }

        return false;
    }

    public function current_url($with_panel = true) {
        $page = 'admin.php?page='.$this->plugin.'-';

        $page.= $this->page;

        if ($with_panel && $this->panel !== false && $this->panel != '') {
            $page.= '&panel='.$this->panel;
        }

        return self_admin_url($page);
    }

    public function title() {
        return 'GD Content Tools Pro';
    }

    public function core() {
        parent::core();

        add_action('admin_menu', array($this, 'admin_menu'));

        $this->init_ready();

        if (gdcet_settings()->is_install()) {
            add_action('admin_notices', array($this, 'install_notice'));
        }

        if (gdcet_settings()->is_update()) {
            add_action('admin_notices', array($this, 'update_notice'));
        }
    }

    public function install_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            echo '<div class="updated"><p>';
            echo __("GD Content Tools Pro is activated and it needs to finish installation.", "gd-content-tools");
            echo ' <a href="admin.php?page=gd-content-tools-front">'.__("Click Here", "gd-content-tools").'</a>.';
            echo '</p></div>';
        }
    }

    public function update_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            echo '<div class="updated"><p>';
            echo __("GD Content Tools Pro is updated, and you need to review the update process.", "gd-content-tools");
            echo ' <a href="admin.php?page=gd-content-tools-front">'.__("Click Here", "gd-content-tools").'</a>.';
            echo '</p></div>';
        }
    }

    public function init_ready() {
        do_action('gdcet_admin_load_addons');

        $this->menu_items = array(
            'front' => array('title' => __("Overview", "gd-content-tools"), 'icon' => 'home'),
            'about' => array('title' => __("About", "gd-content-tools"), 'icon' => 'info-circle')
        );

        $this->menu_items['cpt'] = array('title' => __("Post Types", "gd-content-tools"), 'icon' => 'file-text-o');
        $this->menu_items['tax'] = array('title' => __("Taxonomies", "gd-content-tools"), 'icon' => 'tags');

        $this->menu_items['meta-boxes'] = array('title' => __("Meta Boxes", "gd-content-tools"), 'icon' => 'th-large');
        $this->menu_items['meta-fields'] = array('title' => __("Meta Fields", "gd-content-tools"), 'icon' => 'th-list');

        $this->menu_items = apply_filters('gdcet_admin_menu_items', $this->menu_items);

        $this->menu_items['settings'] = array('title' => __("Settings", "gd-content-tools"), 'icon' => 'cogs');
        $this->menu_items['tools'] = array('title' => __("Tools", "gd-content-tools"), 'icon' => 'wrench');
    }

    public function admin_init() {
        d4p_includes(array(
            array('name' => 'grid', 'directory' => 'admin')
        ), GDCET_D4PLIB);

        do_action('gdcet_admin_init');
    }

    public function admin_menu() {
        $parent = 'gd-content-tools-front';

        $this->page_ids[] = add_menu_page(
                        'GD Content Tools', 
                        'Content Tools', 
                        gdcet()->cap, 
                        $parent, 
                        array($this, 'panel_general'), 
                        gdcet()->svg_icon);

        foreach($this->menu_items as $item => $data) {
            $this->page_ids[] = add_submenu_page($parent, 
                            'GD Content Tools: '.$data['title'], 
                            $data['title'], 
                            gdcet()->cap, 
                            'gd-content-tools-'.$item, 
                            array($this, 'panel_general'));
        }

        $this->admin_load_hooks();
    }

    public function enqueue_scripts($hook) {
        $load_admin_data = false;

        if ($this->page !== false) {
            d4p_admin_enqueue_defaults();

            wp_enqueue_script('jquery-form');
            wp_enqueue_script('jquery-ui-sortable');

            wp_enqueue_style('fontawesome', gdcet()->fontawesome);

            wp_enqueue_style('d4plib-font', $this->file('css', 'font', true), array(), D4P_VERSION.'.'.D4P_BUILD);
            wp_enqueue_style('d4plib-shared', $this->file('css', 'shared', true), array(), D4P_VERSION.'.'.D4P_BUILD);
            wp_enqueue_style('d4plib-admin', $this->file('css', 'admin', true), array('d4plib-shared'), D4P_VERSION.'.'.D4P_BUILD);

            wp_enqueue_script('d4plib-shared', $this->file('js', 'shared', true), array('jquery', 'wp-color-picker'), D4P_VERSION.'.'.D4P_BUILD, true);
            wp_enqueue_script('d4plib-admin', $this->file('js', 'admin', true), array('d4plib-shared'), D4P_VERSION.'.'.D4P_BUILD, true);

            wp_enqueue_style('gdcet-admin', $this->file('css', 'admin-core'), array('d4plib-admin'), gdcet_settings()->file_version());
            wp_enqueue_script('gdcet-admin', $this->file('js', 'admin-core'), array('d4plib-admin', 'jquery-form', 'jquery-ui-sortable'), gdcet_settings()->file_version(), true);

            if ($this->page == 'about') {
                wp_enqueue_style('d4plib-grid', $this->file('css', 'grid', true), array(), D4P_VERSION.'.'.D4P_BUILD);
            }

            do_action('gdcet_admin_enqueue_scripts', $this->page);

            $_data = array(
                'nonce' => wp_create_nonce('gdcet-admin-internal'),
                'wp_version' => GDCET_WPV,
                'page' => $this->page,
                'panel' => $this->panel,
                'spinner' => '<i class="fa fa-spinner fa-spin"></i> ',
                'button_icon_ok' => '<i class="fa fa-check fa-fw" aria-hidden="true"></i> ',
                'button_icon_cancel' => '<i class="fa fa-times fa-fw" aria-hidden="true"></i> ',
                'button_icon_delete' => '<i class="fa fa-trash fa-fw" aria-hidden="true"></i> ',
                'dialog_button_ok' => __("OK", "gd-content-tools"),
                'dialog_button_cancel' => __("Cancel", "gd-content-tools"),
                'dialog_button_delete' => __("Delete", "gd-content-tools"),
                'dialog_title_areyousure' => __("Are you sure you want to do this?", "gd-content-tools"),
                'dialog_content_pleasewait' => __("Please Wait...", "gd-content-tools"),
                'events_show_details' => __("Show Details", "gd-content-tools"),
                'events_hide_details' => __("Hide Details", "gd-content-tools")
            );

            wp_localize_script('gdcet-admin', 'gdcet_data', $_data);

            $load_admin_data = true;
            $load_prism = $this->page == 'cpt' && $this->panel == 'function';

            if ($this->page == 'meta-fields' || $this->page == 'meta-boxes') {
                if ($this->page == 'meta-boxes' && $this->panel == 'php') {
                    $load_prism = true;
                }

                gdcet_meta()->enqueue_datetime_picker(true);

                wp_enqueue_style('gdcet-admin-meta', $this->file('css', 'admin-meta'), array('gdcet-admin'), gdcet_settings()->file_version());

                wp_enqueue_script('mask', GDCET_URL.'d4pjs/mask/jquery.mask.min.js', array(), gdcet_settings()->file_version(), true);
                wp_enqueue_script('limitkeypress', GDCET_URL.'d4plib/resources/libraries/jquery.limitkeypress.min.js', array(), gdcet_settings()->file_version(), true);
                wp_enqueue_script('gdcet-admin-meta', $this->file('js', 'admin-meta'), array('d4p-flatpickr', 'gdcet-admin', 'mask', 'limitkeypress'), gdcet_settings()->file_version(), true);

                $_data_meta = array(
                    'toggler_open' => 'fa-plus-square',
                    'toggler_close' => 'fa-minus-square',
                    'flatpickr_locale' => gdcet()->locale_js_code('flatpickr'),
                    'validation_label_slug' => __("Both Label and Slug are required!", "gd-content-tools"),
                    'validation_label_slug_fields' => __("Both Label and Slug are required for all fields!", "gd-content-tools"),
                    'validation_meta_fields' => __("There are no fields included!", "gd-content-tools")
                );

                wp_localize_script('gdcet-admin-meta', 'gdcet_data_meta', $_data_meta);
            }

            if ($load_prism) {
                wp_enqueue_script('d4plib-clipboard', GDCET_URL.'d4pjs/clipboard/clipboard.min.js', array(), D4P_VERSION.'.'.D4P_BUILD, true);
                wp_enqueue_style('gdcet-prism', GDCET_URL.'d4pjs/prism/prism.min.css', array(), gdcet_settings()->file_version());
                wp_enqueue_script('gdcet-prism', GDCET_URL.'d4pjs/prism/prism.min.js', array('jquery'), gdcet_settings()->file_version(), true);
            }

            do_action('gdcet_admin_enqueue_scripts_plugin', $this->page);
        }

        if (in_array($hook, array('widgets.php'))) {
            wp_enqueue_script('jquery-ui-sortable');

            wp_enqueue_style('d4plib-widgets', $this->file('css', 'widgets', true), array(), D4P_VERSION.'.'.D4P_BUILD);
            wp_enqueue_script('d4plib-widgets', $this->file('js', 'widgets', true), array('jquery'), D4P_VERSION.'.'.D4P_BUILD, true);

            wp_enqueue_script('gdcet-widgets', $this->file('js', 'admin-widgets'), array('d4plib-widgets', 'jquery-ui-sortable'), gdcet_settings()->file_version(), true);
        }

        if (in_array($hook, array('index.php', 'nav-menus.php', 'post.php', 'post-new.php', 'edit-tags.php', 'term.php', 'user-edit.php', 'profile.php'))) {
            d4p_admin_enqueue_defaults();

            wp_enqueue_style('d4plib-shared', $this->file('css', 'shared', true), array(), D4P_VERSION.'.'.D4P_BUILD);
            wp_enqueue_script('d4plib-shared', $this->file('js', 'shared', true), array('jquery', 'wp-color-picker'), D4P_VERSION.'.'.D4P_BUILD, true);
            wp_enqueue_style('d4plib-metabox', $this->file('css', 'meta', true), array('d4plib-shared'), D4P_VERSION.'.'.D4P_BUILD);
            wp_enqueue_script('d4plib-metabox', $this->file('js', 'meta', true), array('d4plib-shared'), D4P_VERSION.'.'.D4P_BUILD, true);

            wp_enqueue_style('gdcet-wp', $this->file('css', 'admin-wp'), array('d4plib-metabox'), gdcet_settings()->file_version());
            wp_enqueue_script('gdcet-wp', $this->file('js', 'admin-wp'), array('d4plib-metabox'), gdcet_settings()->file_version(), true);

            $_data = array(
                'nonce' => wp_create_nonce('gdcet-admin-internal'),
                'wp_version' => GDCET_WPV,
                'hook' => $hook
            );

            wp_localize_script('gdcet-wp', 'gdcet_wp_data', $_data);

            $load_admin_data = true;

            do_action('gdcet_admin_enqueue_scripts_content', $hook);
        }

        if ($load_admin_data) {
            wp_localize_script('d4plib-shared', 'd4plib_admin_data', array(
                'string_media_image_title' => __("Select Image", "gd-content-tools"),
                'string_media_image_button' => __("Use Selected Image", "gd-content-tools"),
                'string_are_you_sure' => __("Are you sure you want to do this?", "gd-content-tools"),
                'string_image_not_selected' => __("Image not selected.", "gd-content-tools")
            ));
        }

        do_action('gdcet_admin_enqueue_scripts');
    }

    public function admin_load_hooks() {
        foreach ($this->page_ids as $id) {
            add_action('load-'.$id, array($this, 'load_admin_page'));
        }
    }

    public function current_screen($screen) {
        if (isset($screen->post_type) && !empty($screen->post_type)) {
            $this->post_type = $screen->post_type;
        }

        if (isset($_GET['panel']) && $_GET['panel'] != '') {
            $this->panel = d4p_sanitize_slug($_GET['panel']);
        }

        $id = $screen->id;

        if ($id == 'toplevel_page_gd-content-tools-front') {
            $this->page = 'front';
        } else if (substr($id, 0, 36) == 'content-tools_page_gd-content-tools-') {
            $this->page = substr($id, 36);
        }

        if (isset($_POST['gdcet_handler']) && $_POST['gdcet_handler'] == 'postback') {
            require_once(GDCET_PATH.'core/admin/postback.php');

            $postback = new gdcet_admin_postback();
        } else if (isset($_GET['gdcet_handler']) && $_GET['gdcet_handler'] == 'getback') {
            require_once(GDCET_PATH.'core/admin/getback.php');

            $getback = new gdcet_admin_getback();
        }
    }

    public function load_admin_page() {
        $this->help_tab_sidebar();

        do_action('gdcet_load_admin_page_'.$this->page);

        if ($this->panel !== false && $this->panel != '') {
            do_action('gdcet_load_admin_page_'.$this->page.'_'.$this->panel);
        }

        $this->help_tab_getting_help();
    }

    public function help_tab_getting_help() {
        parent::help_tab_getting_help();

        require_once(GDCET_PATH.'core/admin/help.php');

        if ($this->page == 'cpt') {
            gdcet_admin_shared_help::post_type();
        }

        if ($this->page == 'meta-boxes') {
            gdcet_admin_shared_help::meta_boxes();
        }

        if ($this->page == 'meta-fields') {
            gdcet_admin_shared_help::meta_fields();
        }
    }

    public function install_or_update() {
        $install = gdcet_settings()->is_install();
        $update = gdcet_settings()->is_update();

        if ($install) {
            include(GDCET_PATH.'forms/install.php');
        } else if ($update) {
            include(GDCET_PATH.'forms/update.php');
        }

        return $install || $update;
    }

    public function panel_general() {
        if (!$this->install_or_update()) {
            $panel_based = array();
            $form_based = array('cpt', 'tax');

            if ($this->page == 'cpt') {
                add_action('gdcet_admin_panel_bottom', array($this, 'load_dialogs_cpt'));
            }

            if ($this->page == 'tax') {
                add_action('gdcet_admin_panel_bottom', array($this, 'load_dialogs_tax'));
            }

            if ($this->page == 'meta-fields') {
                add_action('gdcet_admin_panel_bottom', array($this, 'load_dialogs_meta_fields'));
            }

            if ($this->page == 'meta-boxes') {
                add_action('gdcet_admin_panel_bottom', array($this, 'load_dialogs_meta_boxes'));
            }

            $_current_page = $this->page;
            $_current_panel = $this->panel;

            $path = GDCET_PATH.'forms/shared/invalid.php';

            if (in_array($_current_page, $panel_based) && $_current_panel != '') {
                $path = GDCET_PATH.'forms/'.$_current_page.'/'.$_current_panel.'.php';
                $path = apply_filters('gdcet_admin_panel_'.$_current_page.'_'.$_current_panel, $path);
            } else if (in_array($_current_page, $form_based) && $_current_panel != '') {
                $mode = isset($_GET['mode']) ? $_GET['mode'] : '';

                if ($mode == 'named') {
                    if (in_array($_current_panel, array('templates', 'features', 'taxonomies'))) {
                        $path = GDCET_PATH.'forms/'.$_current_page.'/form.override.php';
                    }
                } else {
                    $path = GDCET_PATH.'forms/'.$_current_page.'/form.php';
                }

                $path = apply_filters('gdcet_admin_panel_'.$_current_page.'_'.$_current_panel, $path);
            } else {
                $path = GDCET_PATH.'forms/'.$_current_page.'.php';
                $path = apply_filters('gdcet_admin_panel_'.$_current_page, $path);
            }

            include($path);
        }
    }

    public function load_dialogs_cpt() {
        include(GDCET_PATH.'forms/cpt/dialogs.php');
    }

    public function load_dialogs_tax() {
        include(GDCET_PATH.'forms/tax/dialogs.php');
    }

    public function load_dialogs_meta_fields() {
        include(GDCET_PATH.'forms/meta/dialogs.php');
    }

    public function load_dialogs_meta_boxes() {
        include(GDCET_PATH.'forms/meta/dialogs.php');
    }
}

global $_gdcet_core_admin;
$_gdcet_core_admin = new gdcet_admin_core();

function gdcet_admin() {
    global $_gdcet_core_admin;
    return $_gdcet_core_admin;
}
