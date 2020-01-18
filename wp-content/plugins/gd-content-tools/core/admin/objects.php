<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_data_objects {
    public $data;

    private $settings;

    function __construct() { }

    public function get($panel, $group = '') {
        if ($group == '') {
            return $this->settings[$panel];
        } else {
            return $this->settings[$panel][$group];
        }
    }

    public function option($name) {
        return $this->data[$name];
    }

    public function settings($panel) {
        $list = array();

        foreach ($this->settings[$panel] as $obj) {
            foreach ($obj['settings'] as $o) {
                $list[] = $o;
            }
        }

        return $list;
    }

    public function cpt() {
        $allow_name_edit = true;
        $allow_message = '';

        if ($this->option('_id') > 0) {
            if (post_type_exists($this->option('post_type'))) {
                $counts = wp_count_posts($this->option('post_type'));

                foreach ($counts as $status => $count) {
                    if ($count > 0) {
                        $allow_name_edit = false;
                        $allow_message = ' <strong>'.__("Once you have items associated with this post type, post type can't be renamed any more.", "gd-content-tools").'</strong>';
                        break;
                    }
                }
            }
        }

        $this->settings = array(
            'edit' => array(
                'edit_basic' => array('name' => __("Name", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'post_type', __("Name", "gd-content-tools"), 
                            __("Post type name must be unique with maximum allowed length is 20 characters, it has to be all lowercase alphabet letters with use of dash. No spaces allowed. It will be checked against restricted WordPress keywords. Also, make sure that you don't use same name for other post types or other taxonomies.", "gd-content-tools").$allow_message, 
                            d4pSettingType::SLUG, $this->option('post_type'), '', '', array('readonly' => !$allow_name_edit))
                )),
                'edit_status' => array('name' => __("Activity", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_status', __("Status", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_status'))
                )),
                'edit_labels' => array('name' => __("Labels", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Post type needs singular and plural label for display purposes. They too should be unique (but plugin can't check for the uniqueness). Both values are required.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_labels_singular_name', __("Singular", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_singular_name')),
                    new d4pSettingElement('settings', '_labels_name', __("Plural", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_name')),
                )),
                'edit_description' => array('name' => __("Description", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'description', __("Description", "gd-content-tools"), __("Optional.", "gd-content-tools"), d4pSettingType::TEXTAREA, $this->option('description'))
                )),
                'edit_editor' => array('name' => __("Editor", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_editor', __("Editor Type", "gd-content-tools"), __("This option will be used only in WordPress 5.0 or newer.", "gd-content-tools").' '.__("To use Block Editor, post type has to have 'Editor' feature and REST API enabled. Without that, it will fall back to Classic Editor.", "gd-content-tools").' '.__("There are other methods and plugins to disabled Block Editor, regardless of the settings here.", "gd-content-tools"), d4pSettingType::RADIOS, $this->option('_editor'), 'array', gdcet_admin_shared_data::get_list_of_editors()),
                )),
                'edit_icon' => array('name' => __("Icon", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_icon', __("Icon Type", "gd-content-tools"), '', d4pSettingType::SELECT, $this->option('_icon'), 'array', gdcet_admin_shared_data::get_list_of_post_type_icons(), array('class' => 'gdcet-cpt-icon-type')),
                    new d4pSettingElement('settings', '_icon_dashicons', __("Dashicon", "gd-content-tools"), __("This list contains all dashicons from the latest version of WordPress. If you are using some older WordPress version, some of these icons can be missing.", "gd-content-tools"), d4pSettingType::SELECT, $this->option('_icon_dashicons'), 'array', gdcet_admin_shared_data::get_list_of_dashicons(), array('wrapper_class' => 'gdcet-cpt-icon gdcet-cpt-icon-dashicon'.($this->option('_icon') == 'dashicon' ? '' : ' gdcet-wrap-icon-hide'))),
                    new d4pSettingElement('settings', '_icon_sprite', __("Sprite", "gd-content-tools"), '', d4pSettingType::SELECT, $this->option('_icon_sprite'), 'array', gdcet_admin_shared_data::get_list_of_sprites(), array('wrapper_class' => 'gdcet-cpt-icon gdcet-cpt-icon-sprite'.($this->option('_icon') == 'sprite' ? '' : ' gdcet-wrap-icon-hide'))),
                    new d4pSettingElement('settings', '_icon_url', __("Image URL", "gd-content-tools"), __("This has to be image with size of 20x20 pixels. If the image is larger, it will be display incorrectly.", "gd-content-tools"), d4pSettingType::LINK, $this->option('_icon_url'), '', '', array('wrapper_class' => 'gdcet-cpt-icon gdcet-cpt-icon-url'.($this->option('_icon') == 'url' ? '' : ' gdcet-wrap-icon-hide'))),
                    new d4pSettingElement('settings', '_icon_image', __("Image", "gd-content-tools"), __("This has to be image with size of 20x20 pixels. If the image is larger, it will be display incorrectly.", "gd-content-tools"), d4pSettingType::IMAGE, $this->option('_icon_image'), '', '', array('wrapper_class' => 'gdcet-cpt-icon gdcet-cpt-icon-image'.($this->option('_icon') == 'image' ? '' : ' gdcet-wrap-icon-hide'))),
                    new d4pSettingElement('settings', '_icon_embed', __("Embed", "gd-content-tools"), __("Base64 encoded image string", "gd-content-tools"), d4pSettingType::TEXTAREA, $this->option('_icon_embed'), '', '', array('wrapper_class' => 'gdcet-cpt-icon gdcet-cpt-icon-embed'.($this->option('_icon') == 'embed' ? '' : ' gdcet-wrap-icon-hide')))
                )),
                'edit_tax' => array('name' => __("Taxonomies", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'taxonomies', __("Assign Taxonomies", "gd-content-tools"), __("Selected taxonomies will be assigened to the this post type.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $this->option('taxonomies'), 'array', gdcet_admin_shared_data::get_list_of_taxonomies())
                )),
                'edit_visibility' => array('name' => __("Visibility", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_public', __("Is Public", "gd-content-tools"), __("This will be used to setup many aspects of this post type features visibility. If you want to setup specific aspects, you can change them from the additional visibility panel.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_public')),
                )),
                'edit_structure' => array('name' => __("Structure", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'hierarchical', __("Is Hierarchical", "gd-content-tools"), __("If enabled, it will create post type that allows hierarchy similar to default Pages.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('hierarchical')),
                ))
            ),
            'labels' => array(
                'labels_main' => array('name' => __("Main Labels", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Post type needs singular and plural label for display purposes. They too should be unique (but plugin can't check for the uniqueness). Both values are required.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_labels_singular_name', __("Singular", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_singular_name')),
                    new d4pSettingElement('settings', '_labels_name', __("Plural", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_name')),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('', 'internal_ctrl_labels', __("Update", "gd-content-tools"), __("If you make changes to the main labels, or you want to start again with standard and additional labesl, you can use controls here to reset them. When you save this page, plugin will update missing labels automatically.", "gd-content-tools"), d4pSettingType::INFO)
                )),
                'labels_standard' => array('name' => __("Standard Labels", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_labels_add_new', __("Add New", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_add_new'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_add_new_item', __("Add New Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_add_new_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_edit_item', __("Edit Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_edit_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_new_item', __("New Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_new_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_view_item', __("View Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_view_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_search_items', __("Search Items", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_search_items'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_not_found', __("Not Found", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_not_found'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_not_found_in_trash', __("Not Found in Trash", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_not_found_in_trash'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_parent_item_colon', __("Parent Item Colon", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_parent_item_colon'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_all_items', __("All Items", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_all_items'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_archives', __("Archives", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_archives'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_name_admin_bar', __("Admin Bar Name", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_name_admin_bar'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_menu_name', __("Menu Name", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_menu_name'), '', '', array('class' => 'gdcet-input-text-label'))
                )),
                'labels_additional' => array('name' => __("Additional Labels", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_labels_insert_into_item', __("Insert Into Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_insert_into_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_uploaded_to_this_item', __("Uploaded To This Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_uploaded_to_this_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_featured_image', __("Featured Image", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_featured_image'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_set_featured_image', __("Set Featured Image", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_set_featured_image'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_remove_featured_image', __("Remove Featured Image", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_remove_featured_image'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_use_featured_image', __("Use Featured Image", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_use_featured_image'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_filter_items_list', __("Filter Items List", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_filter_items_list'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_items_list_navigation', __("Items List Navigation", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_items_list_navigation'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_items_list', __("Items List", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_items_list'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_view_items', __("View Items", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_view_items'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_attributes', __("Attributes", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_attributes'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_item_published', __("Item Published", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_item_published'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_item_published_privately', __("Item Published Privately", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_item_published_privately'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_item_reverted_to_draft', __("Item Reverted to Draft", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_item_reverted_to_draft'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_item_scheduled', __("Item Scheduled", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_item_scheduled'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_item_updated', __("Item Updated", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_item_updated'), '', '', array('class' => 'gdcet-input-text-label'))
                ))
            ),
            'visibility' => array(
                'visibility_public' => array('name' => __("Basic", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_public', __("Is Public", "gd-content-tools"), __("This will be used to setup many aspects of this post type features visibility. If you want to setup specific aspects, you need to enable override option bellow.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_public')),
                    new d4pSettingElement('settings', '_public_override', __("Override", "gd-content-tools"), __("Enable this to use the individual visibility options listed in the next block", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_public_override'))
                )),
                'visibility_fine' => array('name' => __("Visibility", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_visibility', __("Features", "gd-content-tools"), __("These settings will be ignored if the Override is disabled, and plugin will generate them automatically based only on Public value.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $this->option('_visibility'), 'array', gdcet_admin_shared_data::get_list_of_post_type_visibility())
                )),
                'visibility_position' => array('name' => __("Menu Position", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'menu_position', __("Menu Position", "gd-content-tools"), '', d4pSettingType::SELECT, $this->option('menu_position'), 'array', gdcet_admin_shared_data::get_list_of_post_types_menu_positions())
                )),
            ),
            'features' => array(
                'features_structure' => array('name' => __("Structure", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'hierarchical', __("Is Hierarchical", "gd-content-tools"), __("If enabled, it will create post type that allows hierarchy similar to default Pages.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('hierarchical')),
                )),
                'features_supports' => array('name' => __("Supports", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'supports', __("Supported Features", "gd-content-tools"), __("Standard post features.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $this->option('supports'), 'array', gdcet_admin_shared_data::get_list_of_post_types_supports())
                )),
                'features_gdcpt' => array('name' => __("Additional", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_extra_dashboard_glance', __("Dashboard: At a Glance", "gd-content-tools"), __("Add posts count into 'At a glance' dashboard widget.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_dashboard_glance')),
                    new d4pSettingElement('settings', '_extra_menu_archive', __("Admin Menu: Archive Link", "gd-content-tools"), __("Main WordPress menu for this post type will include extra link to post type archive on front end. It will be added only if post type supports archives.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_menu_archive')),
                    new d4pSettingElement('settings', '_extra_menu_draft', __("Admin Menu: Drafts", "gd-content-tools"), __("Main WordPress menu for this post type will include extra link to show draft posts.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_menu_draft')),
                    new d4pSettingElement('settings', '_extra_menu_future', __("Admin Menu: Future", "gd-content-tools"), __("Main WordPress menu for this post type will include extra link to show future posts.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_menu_future')),
                    new d4pSettingElement('settings', '_extra_remove_quick_edit', __("Remove Quick Edit", "gd-content-tools"), __("This will remove Quick Edit option available on the posts lists panel.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_remove_quick_edit')),
                    new d4pSettingElement('settings', '_extra_post_template', __("Post Templates", "gd-content-tools"), __("Implement special post templates similar to the page templates.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_post_template')),
                    new d4pSettingElement('settings', '_extra_home_page', __("In Home Page Posts list", "gd-content-tools"), __("Include posts from this post type inside the home page posts list.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_home_page')),
                    new d4pSettingElement('settings', '_extra_rss_feed', __("In main RSS feed", "gd-content-tools"), __("Include posts from this post type inside the main RSS feed.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_rss_feed'))
                )),
                'features_extras' => array('name' => __("Extra", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_extra_amp', __("AMP Support", "gd-content-tools"), __("Enable Google AMP support for this post type when used with AMP plugin.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_amp'))
                )),
                'features_rest' => array('name' => __("WP REST API", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'show_in_rest', __("Show in REST", "gd-content-tools"), __("If enabled, post type will be available through WP REST API.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('show_in_rest')),
                    new d4pSettingElement('settings', 'rest_base', __("REST base slug", "gd-content-tools"), __("Leave empty, and plugin will use post type name for this.", "gd-content-tools"), d4pSettingType::SLUG, $this->option('rest_base'))
                )),
                'features_advanced' => array('name' => __("Advanced", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'can_export', __("Can be exported", "gd-content-tools"), __("If enabled, post type will be available for data export.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('can_export'))
                ))
            ),
            'capabilities' => array(
                'capabilities_use' => array('name' => __("Generate Capabilities", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Capabilities are used to allow users to edit, read or delete posts belonging to this post type. By default, post type will use same capabilities as for the default Post post type. Do not make any changes here unless you understand how capabilities work or how to use them.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_capabilities', __("Use", "gd-content-tools"), '', d4pSettingType::SELECT, $this->option('_capabilities'), 'array', gdcet_admin_shared_data::get_list_of_capabilities_types())
                )),
                'capabilities_type' => array('name' => __("Capability Type", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_capability_base', __("Base Type", "gd-content-tools"), __("Base for the capabilities. It will be used to generate all needed capabilities. This will not assign them, just register in the system. If you use your own base, you need to assign generated capabilities on your own.", "gd-content-tools"), d4pSettingType::SLUG, $this->option('_capability_base'))
                )),
                'capabilities_caps' => array('name' => __("Custom Capabilities", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_capability_edit_post', __("Edit Post", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_edit_post')),
                    new d4pSettingElement('settings', '_capability_read_post', __("Read Post", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_read_post')),
                    new d4pSettingElement('settings', '_capability_delete_post', __("Delete Post", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_delete_post')),
                    new d4pSettingElement('settings', '_capability_edit_posts', __("Edit Posts", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_edit_posts')),
                    new d4pSettingElement('settings', '_capability_edit_others_posts', __("Edit Others Posts", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_edit_others_posts')),
                    new d4pSettingElement('settings', '_capability_publish_posts', __("Publish Posts", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_publish_posts')),
                    new d4pSettingElement('settings', '_capability_read_private_posts', __("Read Private Posts", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_read_private_posts')),
                ))
            ),
            'rewrite' => array(
                'rewrite_rewrite' => array('name' => __("Rewrite Rule", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Rewrite rules are used to create pretty permalinks for this post type. You can disable single post permalinks rewrite, or change the way they work. If you want to further customize structure of the permalinks, you can find settings for that on the Permalinks edit panel for each post type.", "gd-content-tools").' '.__("If permalinks are disabled in WordPress, these settings will have no effect.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_rewrite', __("Rewrite", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_rewrite')),
                    new d4pSettingElement('settings', '_rewrite_slug', __("Rewrite slug", "gd-content-tools"), __("Leave empty, and plugin will use post type name for this.", "gd-content-tools"), d4pSettingType::SLUG_SLASH, $this->option('_rewrite_slug')),
                    new d4pSettingElement('settings', '_rewrite_with_front', __("With front", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_rewrite_with_front')),
                    new d4pSettingElement('settings', '_rewrite_feeds', __("Feeds", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_rewrite_feeds')),
                    new d4pSettingElement('settings', '_rewrite_pages', __("Pages", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_rewrite_pages')),
                )),
                'rewrite_archive' => array('name' => __("Has Archive", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("By default, post type has archives and uses post type name for archive slug. You can disable archives, or you can change slug used in archive permalink.", "gd-content-tools").' '.__("If permalinks are disabled in WordPress, these settings will have no effect.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_archive', __("Archive", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_archive')),
                    new d4pSettingElement('settings', '_archive_slug', __("Archive slug", "gd-content-tools"), __("Leave empty, and plugin will use post type name for this.", "gd-content-tools"), d4pSettingType::SLUG_SLASH, $this->option('_archive_slug'))
                )),
                'rewrite_query_var' => array('name' => __("Has Query Var", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Query Var is used to identify the post type inside the URL (not using permalinks). If you disable it, you can't query this post type through URL.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_query_var', __("Query Variable", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_query_var')),
                    new d4pSettingElement('settings', '_query_var_slug', __("Query variable slug", "gd-content-tools"), __("Leave empty, and plugin will use post type name for this.", "gd-content-tools"), d4pSettingType::SLUG, $this->option('_query_var_slug'))
                ))
            ),
            'permalinks' => array(
                'permalinks_single' => array('name' => __("Custom Single Permalinks", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("These settings are used only if the permalinks are enabled.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_permalinks_single_active', __("Generate rules", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_permalinks_single_active')),
                    new d4pSettingElement('settings', '_permalinks_single_structure', __("Structure", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_permalinks_single_structure'))
                )),
                'permalinks_date' => array('name' => __("Date Based Archives", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("If post type has no archives enabled, these settings will not be used.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_permalinks_date_archives', __("Generate rules", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_permalinks_date_archives'))
                )),
                'permalinks_author' => array('name' => __("Author Archives", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("If post type has no archives enabled, these settings will not be used.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_permalinks_author_archives', __("Generate rules", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_permalinks_author_archives')),
                    new d4pSettingElement('settings', '_permalinks_author_slug', __("Author slug base", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_permalinks_author_slug')),
                ))
            ),
            'taxonomies' => array(
                'taxonomies_tax' => array('name' => __("Taxonomies", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'taxonomies', __("Assign Taxonomies", "gd-content-tools"), __("Selected taxonomies will be assigened to the this post type.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $this->option('taxonomies'), 'array', gdcet_admin_shared_data::get_list_of_taxonomies())
                ))
            )
        );

        $taxonomies = get_object_taxonomies($this->option('post_type'));
        if (!empty($taxonomies)) {
            $this->settings['permalinks']['permalinks_archive'] = array('name' => __("Archives Intersection", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("If post type has no taxonomies assigned, these settings will not be used.", "gd-content-tools"), d4pSettingType::INFO),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('settings', '_permalinks_intersect_archives', __("Generate rules", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_permalinks_intersect_archives')),
                new d4pSettingElement('settings', '_permalinks_archive_intersection_simple', __("Simple Intersections", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_permalinks_archive_intersection_simple')),
                new d4pSettingElement('settings', '_permalinks_archive_intersection_custom', __("Custom Intersections", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_permalinks_archive_intersection_custom')),
                new d4pSettingElement('settings', '_permalinks_archive_intersection_structure', __("Custom Structure", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_permalinks_archive_intersection_structure')),
                new d4pSettingElement('settings', '_permalinks_archive_intersection_partial', __("Partial Intersections", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_permalinks_archive_intersection_partial')),
                new d4pSettingElement('settings', '_permalinks_archive_intersection_baseless', __("Baseless Taxonomy", "gd-content-tools"), '', d4pSettingType::SELECT, $this->option('_permalinks_archive_intersection_baseless'), 'array', array_merge(array('' => '&nbsp;'), gdcet_admin_shared_data::get_list_of_taxonomies())),
            ));
        } else {
            $this->settings['permalinks']['permalinks_archive'] = array('name' => __("Archives Intersection", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Post type has no taxonomies assigned.", "gd-content-tools"), d4pSettingType::INFO)
            ));
        }

        $this->settings = apply_filters('gdcet_admin_objects_cpt_settings', $this->settings);
    }

    public function tax() {
        $this->settings = apply_filters('gdcet_admin_objects_tax_settings', array(
            'edit' => array(
                'edit_basic' => array('name' => __("Name", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'taxonomy', __("Name", "gd-content-tools"), __("Taxonomy name must be unique with maximum allowed length is 32 characters, it has to be all lowercase alphabet letters with use of dash. No spaces allowed. It will be checked against restricted WordPress keywords. Also, make sure that you don't use same name for other post types or other taxonomies.", "gd-content-tools"), d4pSettingType::SLUG, $this->option('taxonomy'))
                )),
                'edit_status' => array('name' => __("Activity", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_status', __("Status", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_status'))
                )),
                'edit_labels' => array('name' => __("Labels", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Taxonomy needs singular and plural label for display purposes. They too should be unique (but plugin can't check for the uniqueness). Both values are required.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_labels_singular_name', __("Singular", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_singular_name')),
                    new d4pSettingElement('settings', '_labels_name', __("Plural", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_name')),
                )),
                'edit_description' => array('name' => __("Description", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'description', __("Description", "gd-content-tools"), __("Optional.", "gd-content-tools"), d4pSettingType::TEXTAREA, $this->option('description'))
                )),
                'edit_tax' => array('name' => __("Post Types", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_post_types', __("Assign Post Types", "gd-content-tools"), __("Selected taxonomies will be assigened to the this post type.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $this->option('_post_types'), 'array', gdcet_admin_shared_data::get_list_of_post_types())
                )),
                'edit_visibility' => array('name' => __("Visibility", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_public', __("Is Public", "gd-content-tools"), __("This will be used to setup many aspects of this post type features visibility. If you want to setup specific aspects, you can change them from the additional visibility panel.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_public')),
                )),
                'edit_structure' => array('name' => __("Structure", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'hierarchical', __("Is Hierarchical", "gd-content-tools"), __("If enabled, it will create post type that allows hierarchy similar to default Pages.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('hierarchical')),
                ))
            ),
            'labels' => array(
                'labels_main' => array('name' => __("Main Labels", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Taxonomy needs singular and plural label for display purposes. They too should be unique (but plugin can't check for the uniqueness). Both values are required.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_labels_singular_name', __("Singular", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_singular_name')),
                    new d4pSettingElement('settings', '_labels_name', __("Plural", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_name')),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('', 'internal_ctrl_labels', __("Update", "gd-content-tools"), __("If you make changes to the main labels, or you want to start again with standard and additional labesl, you can use controls here to reset them. When you save this page, plugin will update missing labels automatically.", "gd-content-tools"), d4pSettingType::INFO)
                )),
                'labels_standard' => array('name' => __("Standard Labels", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_labels_menu_name', __("Menu Name", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_menu_name'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_all_items', __("All Items", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_all_items'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_edit_item', __("Edit Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_edit_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_view_item', __("View Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_view_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_update_item', __("Update Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_update_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_add_new_item', __("Add New Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_add_new_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_new_item_name', __("New Item Name", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_new_item_name'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_parent_item', __("Parent Item", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_parent_item'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_parent_item_colon', __("Parent Item Colon", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_parent_item_colon'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_search_items', __("Search Items", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_search_items'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_popular_items', __("Popular Items", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_popular_items'), '', '', array('class' => 'gdcet-input-text-label')),
                )),
                'labels_additional' => array('name' => __("Additional Labels", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_labels_separate_items_with_commas', __("Separate Items with Commans", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_separate_items_with_commas'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_add_or_remove_items', __("Add Or Remove Items", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_add_or_remove_items'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_choose_from_most_used', __("Choose From Most Used", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_choose_from_most_used'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_not_found', __("Not Found", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_not_found'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_no_terms', __("No Terms", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_no_terms'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_items_list_navigation', __("Items List Navigation", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_items_list_navigation'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_items_list', __("Items List", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_items_list'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_most_used', __("Most Used", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_most_used'), '', '', array('class' => 'gdcet-input-text-label')),
                    new d4pSettingElement('settings', '_labels_back_to_items', __("Back to Items", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_labels_back_to_items'), '', '', array('class' => 'gdcet-input-text-label'))
                ))
            ),
            'visibility' => array(
                'visibility_public' => array('name' => __("Basic", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_public', __("Is Public", "gd-content-tools"), __("This will be used to setup many aspects of this post type features visibility. If you want to setup specific aspects, you need to enable override option bellow.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_public')),
                    new d4pSettingElement('settings', '_public_override', __("Override", "gd-content-tools"), __("Enable this to use the individual visibility options listed in the next block", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_public_override'))
                )),
                'visibility_fine' => array('name' => __("Visibility", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_visibility', __("Features", "gd-content-tools"), __("These settings will be ignored if the Override is disabled, and plugin will generate them automatically based only on Public value.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $this->option('_visibility'), 'array', gdcet_admin_shared_data::get_list_of_taxonomy_visibility())
                )),
                'visibility_rest' => array('name' => __("WP REST API", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_visibility_show_in_rest', __("Show In Rest", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_visibility_show_in_rest'))
                ))
            ),
            'features' => array(
                'features_structure' => array('name' => __("Structure", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'hierarchical', __("Is Hierarchical", "gd-content-tools"), __("If enabled, it will create post type that allows hierarchy similar to default Pages.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('hierarchical')),
                )),
                'features_gdcpt' => array('name' => __("Additional", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_extra_assign_image', __("Assign image to terms", "gd-content-tools"), __("Enables assigning an image to each term for this taxonomy, and you can later use it in theme.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_assign_image')),
                    new d4pSettingElement('settings', '_extra_post_edit_filter', __("Post edit Filter", "gd-content-tools"), __("Add filter drop down on the post edit panel for every post type that has this taxonomy assigned.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_post_edit_filter')),
                    new d4pSettingElement('settings', '_extra_post_meta_box', __("Post Meta box Type", "gd-content-tools"), __("Change the why meta box for this taxonomy behaves, and if needed, limit the scope of terms adding through the meta box.", "gd-content-tools"), d4pSettingType::SELECT, $this->option('_extra_post_meta_box'), 'array', gdcet_admin_shared_data::get_list_of_taxonomy_meta_box())
                )),
                'features_advanced' => array('name' => __("Advanced", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'sort', __("Sort", "gd-content-tools"), __("If enabled, taxonomy will remember order in which terms are added to objects.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('sort'))
                )),
                'features_rest' => array('name' => __("WP REST API", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_rest_rest_base', __("REST Base", "gd-content-tools"), __("Leave empty, and plugin will use taxonomy name.", "gd-content-tools").'<br/><strong>'.__("Do not change, if you are not sure what this do.", "gd-content-tools").'</strong>', d4pSettingType::SLUG, $this->option('_rest_rest_base')),
                    new d4pSettingElement('settings', '_rest_rest_controller_class', __("REST Controller Class", "gd-content-tools"), __("Leave empty, and plugin will default class.", "gd-content-tools").'<br/><strong>'.__("Do not change, if you are not sure what this do.", "gd-content-tools").'</strong>', d4pSettingType::TEXT, $this->option('_rest_rest_controller_class'))
                ))
            ),
            'capabilities' => array(
                'capabilities_caps' => array('name' => __("Custom Capabilities", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_capability_manage_terms', __("Manage Terms", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_manage_terms')),
                    new d4pSettingElement('settings', '_capability_edit_terms', __("Edit Terms", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_edit_terms')),
                    new d4pSettingElement('settings', '_capability_delete_terms', __("Delete Terms", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_delete_terms')),
                    new d4pSettingElement('settings', '_capability_assign_terms', __("Assign Terms", "gd-content-tools"), '', d4pSettingType::SLUG, $this->option('_capability_assign_terms'))
                ))
            ),
            'rewrite' => array(
                'rewrite_rewrite' => array('name' => __("Rewrite Rule", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Rewrite rules are used to create pretty permalinks for this taxonomy terms.", "gd-content-tools").' '.__("If permalinks are disabled in WordPress, these settings will have no effect.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_rewrite', __("Rewrite", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_rewrite')),
                    new d4pSettingElement('settings', '_rewrite_slug', __("Rewrite slug", "gd-content-tools"), __("Leave empty, and plugin will use post type name for this.", "gd-content-tools"), d4pSettingType::SLUG_SLASH, $this->option('_rewrite_slug')),
                    new d4pSettingElement('settings', '_rewrite_with_front', __("With Front", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_rewrite_with_front')),
                    new d4pSettingElement('settings', '_rewrite_hierarchical', __("Hierarchical", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_rewrite_hierarchical')),
                )),
                'rewrite_query_var' => array('name' => __("Has Query Var", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("Query Var is used to identify the taxonomy inside the URL (not using permalinks). If you disable it, you can't query this taxonomy through URL.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_query_var', __("Query Variable", "gd-content-tools"), '', d4pSettingType::BOOLEAN, $this->option('_query_var')),
                    new d4pSettingElement('settings', '_query_var_slug', __("Query Variable slug", "gd-content-tools"), __("Leave empty, and plugin will use taxonomy name for this.", "gd-content-tools"), d4pSettingType::SLUG, $this->option('_query_var_slug'))
                ))
            ),
            'permalinks' => array(
                'permalinks_index' => array('name' => __("Terms Index Page", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("These settings are used only if the permalinks are enabled.", "gd-content-tools"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('settings', '_permalinks_index', __("Terms Index", "gd-content-tools"), '', d4pSettingType::TEXT, $this->option('_permalinks_index'))
                ))
            ),
            'post_types' => array(
                'post_types_cpt' => array('name' => __("Post Types", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_post_types', __("Assign Post Types", "gd-content-tools"), __("Selected taxonomies will be assigened to the this post type.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $this->option('_post_types'), 'array', gdcet_admin_shared_data::get_list_of_post_types())
                ))
            )
        ));
    }

    public function cpt_override() {
        $cpt = get_post_type_object($this->option('post_type'));

        $features = array(
            'features_gdcpt' => array('name' => __("Additional", "gd-content-tools"), 'settings' => array())
        );

        if ($cpt->public) {
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_menu_draft', __("Admin Menu: Drafts", "gd-content-tools"), __("Main WordPress menu for this post type will include extra link to show draft posts.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_menu_draft'));
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_menu_future', __("Admin Menu: Future", "gd-content-tools"), __("Main WordPress menu for this post type will include extra link to show future posts.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_menu_future'));
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_remove_quick_edit', __("Remove Quick Edit", "gd-content-tools"), __("This will remove Quick Edit option available on the posts lists panel.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_remove_quick_edit'));
        }

        if ($cpt->has_archive !== false) {
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_menu_archive', __("Admin Menu: Archive Link", "gd-content-tools"), __("Main WordPress menu for this post type will include extra link to post type archive on front end. It will be added only if post type supports archives.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_menu_archive'));
        }

        if ($cpt->public && !$cpt->_builtin) {
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_post_template', __("Post Templates", "gd-content-tools"), __("Implement special post templates similar to the page templates.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_post_template'));
        }

        if ($cpt->public && $cpt->name != 'post') {
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_home_page', __("In Home Page Posts list", "gd-content-tools"), __("Include posts from this post type inside the home page posts list.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_home_page'));
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_rss_feed', __("In main RSS feed", "gd-content-tools"), __("Include posts from this post type inside the main RSS feed.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_rss_feed'));
        }

        $this->settings = apply_filters('gdcet_admin_objects_cpt_override_settings', array(
            'features' => $features,
            'taxonomies' => array(
                'taxonomies_general' => array('name' => __("Set Taxonomies", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', '_override_taxonomies', __("Override Taxonomies", "gd-content-tools"), __("Assign taxonomies selected below. This is not removing taxonomies already assigned. To remove all other taxonomies first, use the next option.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_override_taxonomies')),
                    new d4pSettingElement('settings', '_clear_all_previous_taxonomies', __("Clear Taxonomies", "gd-content-tools"), __("This option will remove all taxonomies assigned to post type.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_clear_all_previous_taxonomies'))
                )),
                'taxonomies_tax' => array('name' => __("Taxonomies", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'taxonomies', __("Assign Taxonomies", "gd-content-tools"), __("Selected taxonomies will be assigened to the this post type.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $this->option('taxonomies'), 'array', gdcet_admin_shared_data::get_list_of_taxonomies())
                ))
            )
        ));

        if (empty($this->settings['features']['features_gdcpt']['settings'])) {
            $this->settings['features']['features_gdcpt']['settings'][] = new d4pSettingElement('', '', __("Important", "gd-content-tools"), __("There are no features available for this post type.", "gd-content-tools"), d4pSettingType::INFO);
        }
    }

    public function tax_override() {
        $tax = get_taxonomy($this->option('taxonomy'));

        $features = array('features_gdcpt' => array('name' => __("Additional", "gd-content-tools"), 'settings' => array()));

        if ($tax->public) {
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_assign_image', __("Assign image to terms", "gd-content-tools"), __("Enables assigning an image to each term for this taxonomy, and you can later use it in theme.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_assign_image'));
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_post_edit_filter', __("Post edit Filter", "gd-content-tools"), __("Add filter drop down on the post edit panel for every post type that has this taxonomy assigned.", "gd-content-tools"), d4pSettingType::BOOLEAN, $this->option('_extra_post_edit_filter'));
            $features['features_gdcpt']['settings'][] = new d4pSettingElement('settings', '_extra_post_meta_box', __("Post Meta box Type", "gd-content-tools"), __("Change the why meta box for this taxonomy behaves, and if needed, limit the scope of terms adding through the meta box.", "gd-content-tools"), d4pSettingType::SELECT, $this->option('_extra_post_meta_box'), 'array', gdcet_admin_shared_data::get_list_of_taxonomy_meta_box());
        }

        $this->settings = apply_filters('gdcet_admin_objects_tax_override_settings', array(
            'features' => $features
        ));
    }
}
