<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_transfer {
    public $repeaterless = array('google_map', 'editor');

    public function __construct() {
        if (gdcet_admin()->panel == 'transfer-objects') {
            $this->objects();
        } else if (gdcet_admin()->panel == 'transfer-meta') {
            $this->meta();
        } else if (gdcet_admin()->panel == 'transfer-misc') {
            $this->misc();
        }
    }

    private function misc() {
        if (isset($_POST['gdcettools']['transfer']['imgterm'])) {
            $tax = (array)$_POST['gdcettools']['transfer']['imgterm'];

            $old_imtax = get_option('gd-taxonomy-tools-im-tax');

            foreach ($old_imtax as $obj => $data) {
                if (in_array($obj, $tax)) {
                    $current = isset(gdcet_settings()->current['terms_images'][$obj]) ?  gdcet_settings()->current['terms_images'][$obj] : array();
                    gdcet_settings()->current['terms_images'][$obj] = $current + $data;
                }
            }

            gdcet_settings()->save('terms_images');
        }
    }

    private function objects() {
        if (isset($_POST['gdcettools']['transfer']['cpt'])) {
            $cpt = (array)$_POST['gdcettools']['transfer']['cpt'];

            $old_cpt = get_option('gd-taxonomy-tools-cpt');

            foreach ($old_cpt as $obj) {
                if (in_array($obj['id'], $cpt)) {
                    $this->_transfer_cpt($obj);
                }
            }
        }

        if (isset($_POST['gdcettools']['transfer']['tax'])) {
            $tax = (array)$_POST['gdcettools']['transfer']['tax'];

            $old_tax = get_option('gd-taxonomy-tools-tax');
            
            foreach ($old_tax as $obj) {
                if (in_array($obj['id'], $tax)) {
                    $this->_transfer_tax($obj);
                }
            }
        }

        flush_rewrite_rules();
    }

    private function _transfer_cpt($input) {
        $cpt = new gdcet_base_cpt();

        $cpt->post_type = $input['name'];

        $cpt->_menu_position = $input['menu_position'];

        $cpt->_status = false;
        $cpt->_icon = 'sprite';
        $cpt->_icon_sprite = $input['icon'];

        $cpt->_extra_menu_archive = in_array('menu_archive', $input['special']);
        $cpt->_extra_menu_draft = in_array('menu_drafts', $input['special']);
        $cpt->_extra_menu_future = in_array('menu_futures', $input['special']);
        $cpt->_extra_remove_quick_edit = in_array('disable_quickedit', $input['special']);
        $cpt->_extra_home_page = in_array('home_page', $input['special']);
        $cpt->_extra_rss_feed = in_array('rss_feed', $input['special']);
        $cpt->_extra_post_template = in_array('post_template', $input['special']);

        $cpt->_permalinks_single_active = $input['permalinks_active'] == 'yes';
        $cpt->_permalinks_single_structure = $input['permalinks_structure'];

        $cpt->_permalinks_date_archives = $input['date_archives'] == 'yes';

        $cpt->_permalinks_intersect_archives = $input['intersections'] == 'yes';
        $cpt->_permalinks_archive_intersection_simple = $input['intersections'] == 'yes' || $input['intersections'] == 'max';
        $cpt->_permalinks_archive_intersection_custom = $input['intersections'] == 'adv' || $input['intersections'] == 'max';
        $cpt->_permalinks_archive_intersection_structure = $input['intersections_structure'];
        $cpt->_permalinks_archive_intersection_partial = $input['intersections_partial'] == 'yes';
        $cpt->_permalinks_archive_intersection_baseless = $input['intersections_baseless'];

        $cpt->_labels_name = $input['labels']['name'];
        $cpt->_labels_singular_name = $input['labels']['singular_name'];

        $cpt->_labels_add_new = $input['labels']['add_new'];
        $cpt->_labels_add_new_item = $input['labels']['add_new_item'];
        $cpt->_labels_edit_item = $input['labels']['edit_item'];
        $cpt->_labels_new_item = $input['labels']['new_item'];
        $cpt->_labels_view_item = $input['labels']['view_item'];
        $cpt->_labels_search_items = $input['labels']['search_items'];
        $cpt->_labels_not_found = $input['labels']['not_found'];
        $cpt->_labels_not_found_in_trash = $input['labels']['not_found_in_trash'];
        $cpt->_labels_parent_item_colon = $input['labels']['parent_item_colon'];
        $cpt->_labels_all_items = $input['labels']['all_items'];
        $cpt->_labels_menu_name = $input['labels']['menu_name'];

        $cpt->_public = $input['public'] == 'yes';
        $cpt->_public_override = true;
        $cpt->_visibility = array();

        if ($input['exclude_from_search'] == 'yes') {
            $cpt->_visibility[] = 'exclude_from_search';
        }

        if ($input['publicly_queryable'] == 'yes') {
            $cpt->_visibility[] = 'publicly_queryable';
        }

        if ($input['ui'] == 'yes') {
            $cpt->_visibility[] = 'show_ui';
        }

        if ($input['show_in_menu'] == 'yes') {
            $cpt->_visibility[] = 'show_in_menu';
        }

        if ($input['nav_menus'] == 'yes') {
            $cpt->_visibility[] = 'show_in_nav_menus';
        }

        if ($input['show_in_admin_bar'] == 'yes') {
            $cpt->_visibility[] = 'show_in_admin_bar';
        }

        $cpt->_capabilities = $input['capabilites'] == 'type' ? 'type' : 'caps';
        $cpt->_capability_base = $input['caps_type'];
        $cpt->_capability_edit_post = $input['caps']['edit_post'];
        $cpt->_capability_read_post = $input['caps']['read_post'];
        $cpt->_capability_delete_post = $input['caps']['delete_post'];
        $cpt->_capability_edit_posts = $input['caps']['edit_posts'];
        $cpt->_capability_edit_others_posts = $input['caps']['edit_others_posts'];
        $cpt->_capability_publish_posts = $input['caps']['publish_posts'];
        $cpt->_capability_read_private_posts = $input['caps']['read_private_posts'];

        $cpt->_query_var = $input['query'] != 'no';

        if ($input['query'] == 'yes_custom') {
            $cpt->_query_var_slug = $input['query_slug'];
        }

        $cpt->_archive = $input['archive'] != 'no';

        if ($input['archive'] == 'yes_custom') {
            $cpt->_archive_slug = $input['archive_slug'];
        }

        $cpt->_rewrite = $input['rewrite'] != 'no';
        $cpt->_rewrite_feeds = $input['rewrite_feeds'] == 'yes';
        $cpt->_rewrite_pages = $input['rewrite_pages'] == 'yes';
        $cpt->_rewrite_with_front = $input['rewrite_front'] == 'yes';

        if ($input['rewrite'] == 'yes_custom') {
            $cpt->_rewrite_slug = $input['rewrite_slug'];
        }

        $cpt->fill_labels();
        $cpt->fill_capabilities();

        gdcet_settings()->save_cpt($cpt->get());
    }

    private function _transfer_tax($input) {
        $tax = new gdcet_base_tax();

        $tax->taxonomy = $input['name'];

        $tax->_status = false;

        $tax->_extra_assign_image = in_array('term_image', $input['special']);
        $tax->_extra_post_edit_filter = in_array('term_image', $input['special']);
        $tax->_extra_post_meta_box = $input['metabox'];

        $tax->_post_types = !empty($input['domain']) ? explode(',', $input['domain']) : array();

        $tax->_labels_name = $input['labels']['name'];
        $tax->_labels_singular_name = $input['labels']['singular_name'];

        $tax->_labels_search_items = $input['labels']['search_items'];
        $tax->_labels_popular_items = $input['labels']['popular_items'];
        $tax->_labels_all_items = $input['labels']['all_items'];
        $tax->_labels_parent_item = $input['labels']['parent_item'];
        $tax->_labels_parent_item_colon = $input['labels']['parent_item_colon'];
        $tax->_labels_menu_name = $input['labels']['menu_name'];
        $tax->_labels_edit_item = $input['labels']['edit_item'];
        $tax->_labels_view_item = $input['labels']['view_item'];
        $tax->_labels_update_item = $input['labels']['update_item'];
        $tax->_labels_add_new_item = $input['labels']['add_new_item'];
        $tax->_labels_new_item_name = $input['labels']['new_item_name'];
        $tax->_labels_separate_items_with_commas = $input['labels']['separate_items_with_commas'];
        $tax->_labels_add_or_remove_items = $input['labels']['add_or_remove_items'];
        $tax->_labels_choose_from_most_used = $input['labels']['choose_from_most_used'];

        $tax->_public = $input['public'] == 'yes';
        $tax->_public_override = true;
        $tax->_visibility = array();

        if ($input['ui'] == 'yes') {
            $tax->_visibility[] = 'show_ui';
            $tax->_visibility[] = 'show_in_menu';
            $tax->_visibility[] = 'show_in_quick_edit';
        }

        if ($input['nav_menus'] == 'yes') {
            $tax->_visibility[] = 'show_in_nav_menus';
        }

        if ($input['cloud'] == 'yes') {
            $tax->_visibility[] = 'show_tagcloud';
        }

        if ($input['show_admin_column'] == 'yes') {
            $tax->_visibility[] = 'show_admin_column';
        }

        $tax->_capability_manage_terms = $input['caps']['manage_terms'];
        $tax->_capability_edit_terms = $input['caps']['edit_terms'];
        $tax->_capability_assign_terms = $input['caps']['assign_terms'];
        $tax->_capability_delete_terms = $input['caps']['delete_terms'];

        $tax->_query_var = $input['query'] != 'no';

        if ($input['query'] == 'yes_custom') {
            $tax->_query_var_slug = $input['query_slug'];
        }

        $tax->_rewrite = $input['rewrite'] != 'no';
        $tax->_rewrite_with_front = $input['rewrite_front'] == 'yes';
        $tax->_rewrite_hierarchical = true;

        if ($input['rewrite'] == 'yes_custom') {
            $tax->_rewrite_slug = $input['rewrite_custom'];
        }

        $tax->fill_labels();
        $tax->fill_capabilities();

        gdcet_settings()->save_tax($tax->get());
    }

    private function meta() {
        $old_meta = get_option('gd-taxonomy-tools-meta');

        if (isset($_POST['gdcettools']['transfer']['fields'])) {
            $fields = (array)$_POST['gdcettools']['transfer']['fields'];

            $old_fields = $old_meta['fields'];

            foreach ($old_fields as $obj) {
                if (in_array($obj['code'], $fields)) {
                    $this->_transfer_field($obj);
                }
            }
        }

        if (isset($_POST['gdcettools']['transfer']['boxes'])) {
            $boxes = (array)$_POST['gdcettools']['transfer']['boxes'];

            $old_boxes = $old_meta['boxes'];

            foreach ($old_boxes as $obj) {
                if (in_array($obj['code'], $boxes)) {
                    $this->_transfer_box($obj, $old_meta['map']);
                }
            }
        }
    }

    private function _transfer_field($input) {
        $field = new gdcet_meta_simple_field();
        $basic = array(
            'label' => $input['name'],
            'slug' => $input['code'],
            'description' => $input['description'],
            'class' => '',
            'required' => $input['required'],
            'repeater' => !in_array($input['type'], $this->repeaterless),
            'repeater_limit' => 0,
            'conditions' => array()
        );

        switch ($input['type']) {
            case 'text':
                $field = $this->_transfer_meta_text($field, $basic, $input);
                break;
            case 'number':
                $field = $this->_transfer_meta_number($field, $basic, $input);
                break;
            case 'boolean':
                $field = $this->_transfer_meta_boolean($field, $basic, $input);
                break;
            case 'editor':
                $field = $this->_transfer_meta_html($field, $basic, $input);
                break;
            case 'listing':
                $field = $this->_transfer_meta_listing($field, $basic, $input);
                break;
            case 'select':
                $field = $this->_transfer_meta_select($field, $basic, $input);
                break;
            case 'link':
                $field = $this->_transfer_meta_link($field, $basic, $input);
                break;
            case 'email':
                $field = $this->_transfer_meta_email($field, $basic, $input);
                break;
            case 'date':
                $field = $this->_transfer_meta_date($field, $basic, $input);
                break;
            case 'time':
                $field = $this->_transfer_meta_time($field, $basic, $input);
                break;
            case 'date_time':
                $field = $this->_transfer_meta_datetime($field, $basic, $input);
                break;
            case 'month':
                $field = $this->_transfer_meta_month($field, $basic, $input);
                break;
            case 'period':
                $field = $this->_transfer_meta_period($field, $basic, $input);
                break;
            case 'color':
                $field = $this->_transfer_meta_color($field, $basic, $input);
                break;
            case 'editor':
                $field = $this->_transfer_meta_editor($field, $basic, $input);
                break;
            case 'image':
                $field = $this->_transfer_meta_image($field, $basic, $input);
                break;
            case 'rewrite':
                $field = $this->_transfer_meta_rewrite($field, $basic, $input);
                break;
            case 'google_map':
                $field = $this->_transfer_meta_google_map($field, $basic, $input);
                break;
            case 'unit':
                $field = $this->_transfer_meta_unit($field, $basic, $input);
                break;
            case 'currency':
                $field = $this->_transfer_meta_currency($field, $basic, $input);
                break;
            case 'resolution':
                $field = $this->_transfer_meta_resolution($field, $basic, $input);
                break;
            case 'dimensions':
                $field = $this->_transfer_meta_dimensions($field, $basic, $input);
                break;
            case 'term':
                $field = $this->_transfer_meta_term($field, $basic, $input);
                break;
            case 'post':
                $field = $this->_transfer_meta_post($field, $basic, $input);
                break;
            case 'user':
                $field = $this->_transfer_meta_user($field, $basic, $input);
                break;
        }

        gdcet_settings()->save_field($field->store());
    }

    private function _transfer_box($input, $map) {
        $box = new gdcet_meta_legacy_box();

        $box->slug = $input['code'];
        $box->label = $input['name'];
        $box->description = $input['description'];
        $box->location = $input['location'];
        $box->repeater = $input['repeater'] == 'yes';
        $box->types['post_types'] = $map[$input['code']];

        foreach ($input['fields'] as $field) {
            $f = gdcet_meta()->get_field_by_slug($field);

            if (!is_null($f)) {
                $box->fields[] = array('field_id' => $f->get_id(), 'open_tab' => false, 'tab_label' => '');
            }
        }

        gdcet_settings()->save_box($box->store()); 
    }

    private function _transfer_meta_text($field, $basic, $input) {
        $basic['type'] = 'text';

        $settings = gdcet_meta_core_field_text::get_defaults();
        $settings['limit'] = $input['limit'];
        $settings['regex'] = $input['regex_custom'];
        $settings['mask'] = $input['mask_custom'];

        if ($input['regex'] == '__none__') {
            if ($input['regex'] == '__custom__') {
                $settings['restriction'] = '__regex__';
            } else if ($input['regex'] == '__custom_mask__') {
                $settings['restriction'] = '__mask__';
            } else {
                $settings['restriction'] = str_replace('gdCPTData', 'gdcet_meta_predefined_data', $input['regex']);
            }
        }

        $field->fields[0] = new gdcet_meta_core_field_text(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_number($field, $basic, $input) {
        $basic['type'] = 'number';

        $settings = gdcet_meta_core_field_number::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_number(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_boolean($field, $basic, $input) {
        $basic['type'] = 'boolean';

        $settings = gdcet_meta_core_field_boolean::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_boolean(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_html($field, $basic, $input) {
        $basic['type'] = 'html';

        $settings = gdcet_meta_core_field_html::get_defaults();
        $settings['limit'] = $input['limit'];

        $field->fields[0] = new gdcet_meta_core_field_html(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_listing($field, $basic, $input) {
        $basic['type'] = 'listing';

        $settings = gdcet_meta_core_field_listing::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_listing(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_select($field, $basic, $input) {
        $_selection = $input['selection'];
        $_method = $input['selmethod'];
        $_values = $input['values'];
        $_associated = $input['assoc_values'];

        $mode = 'normal';
        $values = array();
        $source = $_method == 'function' ? 'function' : 'list';

        if ($_method != 'function') {
            if ($_method == 'associative') {
                $mode = 'associative';
                $values = $_associated;
            } else {
                $values = $_values;
            }
        }

        $settings = array(
            'default' => '',
            'mode' => $mode,
            'source' => $source,
            'list' => $values,
            'function' => $input['fnc_name'] == '__none__' ? '' : $input['fnc_name']
        );

        if ($settings['function'] != '') {
            $settings['function'] = str_replace('gdCPTData', 'gdcet_meta_predefined_data', $settings['function']);
        }
        
        if ($_selection == 'checkbox') {
            $basic['type'] = 'checkboxes';

            $field->fields[0] = new gdcet_meta_core_field_checkboxes(array('basic' => $basic, 'settings' => $settings));
        } else if ($_selection == 'radio') {
            $basic['type'] = 'radios';

            $field->fields[0] = new gdcet_meta_core_field_radios(array('basic' => $basic, 'settings' => $settings));
        } else if ($_selection == 'select') {
            $basic['type'] = 'select';

            $field->fields[0] = new gdcet_meta_core_field_select(array('basic' => $basic, 'settings' => $settings));
        } else if ($_selection == 'multi') {
            $basic['type'] = 'multi-select';

            $field->fields[0] = new gdcet_meta_core_field_multi_select(array('basic' => $basic, 'settings' => $settings));
        }

        return $field;
    }

    private function _transfer_meta_link($field, $basic, $input) {
        $basic['type'] = 'link';

        $settings = gdcet_meta_core_field_link::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_link(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_email($field, $basic, $input) {
        $basic['type'] = 'email';

        $settings = gdcet_meta_core_field_email::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_email(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_date($field, $basic, $input) {
        $basic['type'] = 'date';

        $settings = gdcet_meta_core_field_date::get_defaults();
        $settings['store'] = $input['datesave'];

        $field->fields[0] = new gdcet_meta_core_field_date(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_time($field, $basic, $input) {
        $basic['type'] = 'time';

        $settings = gdcet_meta_core_field_time::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_time(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_datetime($field, $basic, $input) {
        $basic['type'] = 'datetime';

        $settings = gdcet_meta_core_field_datetime::get_defaults();
        $settings['store'] = $input['datesave'];

        $field->fields[0] = new gdcet_meta_core_field_datetime(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_month($field, $basic, $input) {
        $basic['type'] = 'month';

        $settings = gdcet_meta_core_field_month::get_defaults();
        $settings['store'] = $input['datesave'];

        $field->fields[0] = new gdcet_meta_core_field_month(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_period($field, $basic, $input) {
        $basic['type'] = 'period';

        $settings = gdcet_meta_core_field_period::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_period(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_color($field, $basic, $input) {
        $basic['type'] = 'color';

        $settings = gdcet_meta_core_field_color::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_color(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_editor($field, $basic, $input) {
        $basic['type'] = 'editor';

        $settings = gdcet_meta_core_field_editor::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_editor(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_image($field, $basic, $input) {
        $basic['type'] = 'image';

        $settings = gdcet_meta_core_field_image::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_image(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_rewrite($field, $basic, $input) {
        $basic['type'] = 'slug';

        $settings = gdcet_meta_core_field_slug::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_slug(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_google_map($field, $basic, $input) {
        $basic['type'] = 'gmap';

        $settings = gdcet_meta_core_field_gmap::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_gmap(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_unit($field, $basic, $input) {
        $basic['type'] = 'unit';

        $settings = gdcet_meta_core_field_unit::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_unit(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_currency($field, $basic, $input) {
        $basic['type'] = 'currency';

        $settings = gdcet_meta_core_field_currency::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_currency(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_resolution($field, $basic, $input) {
        $basic['type'] = 'resolution';

        $settings = gdcet_meta_core_field_resolution::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_resolution(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_dimensions($field, $basic, $input) {
        $basic['type'] = 'dimensions';

        $settings = gdcet_meta_core_field_dimensions::get_defaults();

        $field->fields[0] = new gdcet_meta_core_field_dimensions(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_term($field, $basic, $input) {
        $basic['type'] = 'term';

        $settings = gdcet_meta_core_field_term::get_defaults();
        $settings['taxonomy'] = $input['values'];

        $field->fields[0] = new gdcet_meta_core_field_term(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_post($field, $basic, $input) {
        $basic['type'] = 'post';

        $settings = gdcet_meta_core_field_post::get_defaults();
        $settings['post_type'] = $input['values'];

        $field->fields[0] = new gdcet_meta_core_field_post(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }

    private function _transfer_meta_user($field, $basic, $input) {
        $basic['type'] = 'user';

        $settings = gdcet_meta_core_field_user::get_defaults();

        if ($input['values'] != 'misc_all') {
            if ($input['values'] != 'misc_authors') {
                $settings['type'] = 'authors';
            } else {
                $settings['roles'] = array(substr($input['values'], 5));
            }
        }

        $field->fields[0] = new gdcet_meta_core_field_user(array('basic' => $basic, 'settings' => $settings));

        return $field;
    }
}

$_gdcet_transfer_object = new gdcet_admin_transfer();
