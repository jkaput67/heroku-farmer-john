<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_meta {
    public $categories = array();
    public $fields = array();
    public $fields_names = array();

    public function __construct() {
        require_once(GDCET_PATH.'meta/functions/meta.php');
        require_once(GDCET_PATH.'meta/objects/core.data.php');
        require_once(GDCET_PATH.'meta/objects/base.field.php');

        require_once(GDCET_PATH.'meta/objects/base.field-meta.php');
        require_once(GDCET_PATH.'meta/objects/base.field-custom.php');
        require_once(GDCET_PATH.'meta/objects/base.field-simple.php');

        require_once(GDCET_PATH.'meta/objects/base.box.php');
        require_once(GDCET_PATH.'meta/objects/base.box-legacy.php');
        require_once(GDCET_PATH.'meta/objects/base.box-meta.php');

        require_once(GDCET_PATH.'meta/objects/core.field.php');
        require_once(GDCET_PATH.'meta/objects/core.box.php');
        require_once(GDCET_PATH.'meta/objects/core.shortcodes.php');
        require_once(GDCET_PATH.'meta/functions/data.php');

        add_action('gdcet_settings_loaded', array($this, 'settings'), 2);

        add_action('gdcet_admin_enqueue_scripts_content', array($this, 'enqueue'));

        if (D4P_AJAX) {
            require_once(GDCET_PATH.'meta/objects/core.ajax.php');
        }

        if (D4P_ADMIN) {
            require_once(GDCET_PATH.'meta/objects/core.admin.php');
        }
    }

    public function load_control() {
        require_once(GDCET_PATH.'meta/objects/core.control.php');
    }

    public function settings() {
        $this->_init_categories();
        $this->_init_basic_fields();
    }

    public function enqueue_datetime_picker($forced = false) {
        if ($forced || apply_filters('gdcet_meta_enqueue_flatpickr', true)) {
            wp_enqueue_style('d4p-flatpickr', GDCET_URL.'d4pjs/flatpickr/flatpickr.min.css', array(), D4P_VERSION.'.'.D4P_BUILD);
            wp_enqueue_style('d4p-flatpickr-months', GDCET_URL.'d4pjs/flatpickr/plugins/monthSelect/style.min.css', array('d4p-flatpickr'), D4P_VERSION.'.'.D4P_BUILD);
            wp_enqueue_script('d4p-flatpickr', GDCET_URL.'d4pjs/flatpickr/flatpickr.min.js', array('jquery'), D4P_VERSION.'.'.D4P_BUILD, true);
            wp_enqueue_script('d4p-flatpickr-months', GDCET_URL.'d4pjs/flatpickr/plugins/monthSelect/index.min.js', array('d4p-flatpickr'), D4P_VERSION.'.'.D4P_BUILD, true);

            $flatpickr_locale = gdcet()->locale_js_code('flatpickr');

            if ($flatpickr_locale !== false) {
                wp_enqueue_script('d4p-flatpickr-'.$flatpickr_locale, GDCET_URL.'d4pjs/flatpickr/l10n/'.$flatpickr_locale.'.min.js', array('d4p-flatpickr'), D4P_VERSION.'.'.D4P_BUILD, true);
            }

            return true;
        }

        return false;
    }

    public function enqueue_select2($forced = false) {
        if ($forced || apply_filters('gdcet_meta_enqueue_select2', true)) {
            wp_enqueue_style('d4p-select-two', GDCET_URL.'d4pjs/select2/select2.min.css', array(), D4P_VERSION.'.'.D4P_BUILD);
            wp_enqueue_script('d4p-select-two', GDCET_URL.'d4pjs/select2/select2.full.min.js', array('jquery'), D4P_VERSION.'.'.D4P_BUILD, true);

            $select2_locale = gdcet()->locale_js_code('select2');

            if ($select2_locale !== false) {
                wp_enqueue_script('d4p-select-two-'.$select2_locale, GDCET_URL.'d4pjs/select2/i18n/'.$select2_locale.'.min.js', array('d4p-select-two'), D4P_VERSION.'.'.D4P_BUILD, true);
            }

            return true;
        }

        return false;
    }

    public function enqueue_google_maps() {
        $the_key = gdcet_settings()->get('google_maps_api_key');

        if (!empty($the_key)){
            wp_enqueue_script('gdcet-google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$the_key, array(), gdcet_settings()->file_version());
            wp_enqueue_script('gdcet-meta-gmap3', GDCET_URL.'d4pjs/gmap3/gmap3.min.js', array('jquery', 'gdcet-google-maps'), gdcet_settings()->file_version(), true);

            return true;
        }

        return false;
    }

    public function enqueue() {
        global $pagenow;

        wp_enqueue_script('jquery');
        wp_enqueue_media();

        d4p_enqueue_color_picker();

        $depend_js = array('jquery', 'mask', 'limitkeypress');
        $depend_css = array('dashicons');

        if ($this->enqueue_datetime_picker()) {
            $depend_js[] = 'd4p-flatpickr';
            $depend_css[] = 'd4p-flatpickr';
        }

        if ($this->enqueue_select2()) {
            $depend_js[] = 'd4p-select-two';
            $depend_css[] = 'd4p-select-two';
        }

        if ($this->enqueue_google_maps()) {
            $depend_js[] = 'gdcet-meta-gmap3';
        }

        wp_enqueue_style('fontawesome', gdcet()->fontawesome);

        wp_enqueue_style('gdcet-meta', gdcet()->file('css', 'meta-core'), $depend_css, gdcet_settings()->file_version());

        wp_enqueue_script('mask', GDCET_URL.'d4pjs/mask/jquery.mask.min.js', array(), gdcet_settings()->file_version(), true);
        wp_enqueue_script('limitkeypress', GDCET_URL.'d4plib/resources/libraries/jquery.limitkeypress.min.js', array(), gdcet_settings()->file_version(), true);

        wp_enqueue_script('gdcet-meta', gdcet()->file('js', 'meta-core'), $depend_js, gdcet_settings()->file_version(), true);

        $_data = apply_filters('gdcet_meta_enqueue_settings', array(
            'ajax' => admin_url('admin-ajax.php'),
            'page' => $pagenow,
            'flatpickr_locale' => gdcet()->locale_js_code('flatpickr'),
            'select2_locale' => gdcet()->locale_js_code('select2'),
            'is_admin' => is_admin() ? 'yes' : 'no',
            'is_post_edit' => $pagenow == 'post-new.php' || $pagenow == 'post.php' ? 'yes' : 'no',
            'is_term_edit' => $pagenow == 'term.php' ? 'yes' : 'no',
            'is_user_edit' => $pagenow == 'user-edit.php' || $pagenow == 'profile.php' ? 'yes' : 'no',
            'string_are_you_sure' => __("Are you sure you want to do this?", "gd-content-tools"),
            'string_image_not_selected' => __("Image not selected.", "gd-content-tools"),
            'string_file_not_selected' => __("File not selected.", "gd-content-tools"),
            'string_image_title' => __("Select Image", "gd-content-tools"),
            'string_image_button' => __("Use Selected Image", "gd-content-tools"),
            'string_file_title' => __("Select File", "gd-content-tools"),
            'string_file_button' => __("Use Selected File", "gd-content-tools"),
            'toggler_open' => 'dashicons-arrow-up',
            'toggler_close' => 'dashicons-arrow-down',
            'repeater_plus' => 'dashicons-plus',
            'repeater_minus' => 'dashicons-minus',
            'repeater_up' => 'dashicons-arrow-up-alt2',
            'repeater_down' => 'dashicons-arrow-down-alt2'
        ));

        wp_localize_script('gdcet-meta', 'gdcet_metadata', $_data);

        do_action('gdcet_meta_load_enqueue_files');
    }

    public function enqueue_front() {
        $this->enqueue_google_maps();

        wp_enqueue_script('gdcet-meta-front', gdcet()->file('js', 'meta-front'), array('jquery', 'gdcet-meta-gmap3'), gdcet_settings()->file_version(), true);
    }

    public function register_category($category, $label) {
        $this->categories[$category] = array('label' => $label);
    }

    public function register_basic_field($category, $name, $label, $icon = 'square-o', $path = null) {
        $this->fields[$category][$name] = array('category' => $category, 'name' => $name, 'label' => $label, 'icon' => $icon, 'path' => $path);
        $this->fields_names[] = $name;
    }

    private function _init_categories() {
        $this->register_category('basic', __("Basic", "gd-content-tools"));
        $this->register_category('selection', __("Selection", "gd-content-tools"));
        $this->register_category('datetime', __("Date Time", "gd-content-tools"));
        $this->register_category('content', __("Content", "gd-content-tools"));
        $this->register_category('units', __("Units", "gd-content-tools"));
        $this->register_category('maps', __("Maps", "gd-content-tools"));
        $this->register_category('advanced', __("Advanced", "gd-content-tools"));
        $this->register_category('special', __("Special", "gd-content-tools"));
    }

    private function _init_basic_fields() {
        $this->register_basic_field('basic', 'text', __("Text", "gd-content-tools"), 'file-text');
        $this->register_basic_field('basic', 'html', __("Textarea", "gd-content-tools"), 'file-text-o');
        $this->register_basic_field('basic', 'boolean', __("Boolean", "gd-content-tools"), 'check');
        $this->register_basic_field('basic', 'number', __("Number", "gd-content-tools"), 'sort-numeric-asc');
        $this->register_basic_field('basic', 'link', __("Link", "gd-content-tools"), 'external-link');
        $this->register_basic_field('basic', 'email', __("Email", "gd-content-tools"), 'envelope');
        $this->register_basic_field('basic', 'color', __("Color", "gd-content-tools"), 'paint-brush');
        $this->register_basic_field('basic', 'editor', __("Editor", "gd-content-tools"), 'pencil-square-o');
        $this->register_basic_field('basic', 'listing', __("Listing", "gd-content-tools"), 'list-alt');

        $this->register_basic_field('selection', 'select', __("Select", "gd-content-tools"), 'list-ul');
        $this->register_basic_field('selection', 'multi-select', __("Multi Select", "gd-content-tools"), 'list');
        $this->register_basic_field('selection', 'radios', __("Radios", "gd-content-tools"), 'dot-circle-o');
        $this->register_basic_field('selection', 'checkboxes', __("Checkboxes", "gd-content-tools"), 'check-square');

        $this->register_basic_field('datetime', 'time', __("Time", "gd-content-tools"), 'clock-o');
        $this->register_basic_field('datetime', 'date', __("Date", "gd-content-tools"), 'calendar-o');
        $this->register_basic_field('datetime', 'datetime', __("Date Time", "gd-content-tools"), 'calendar');
        $this->register_basic_field('datetime', 'month', __("Month", "gd-content-tools"), 'calendar-check-o');
        $this->register_basic_field('datetime', 'year', __("Year", "gd-content-tools"), 'calendar-minus-o');
        $this->register_basic_field('datetime', 'period', __("Period", "gd-content-tools"), 'circle-o-notch');

        $this->register_basic_field('content', 'image', __("Image", "gd-content-tools"), 'picture-o');
        $this->register_basic_field('content', 'icon-fa', __("Icon: Fontawesome", "gd-content-tools"), 'fort-awesome');
        $this->register_basic_field('content', 'file', __("File", "gd-content-tools"), 'file');
        $this->register_basic_field('content', 'post', __("Post", "gd-content-tools"), 'thumb-tack');
        $this->register_basic_field('content', 'term', __("Term", "gd-content-tools"), 'tags');
        $this->register_basic_field('content', 'user', __("User", "gd-content-tools"), 'user');

        $this->register_basic_field('units', 'unit', __("Unit", "gd-content-tools"), 'lightbulb-o');
        $this->register_basic_field('units', 'dimensions', __("Dimensions", "gd-content-tools"), 'arrows');
        $this->register_basic_field('units', 'resolution', __("Resolution", "gd-content-tools"), 'desktop');
        $this->register_basic_field('units', 'currency', __("Currency", "gd-content-tools"), 'money');

        $this->register_basic_field('maps', 'gmap', __("Google Map", "gd-content-tools"), 'map');

        $this->register_basic_field('advanced', 'slug', __("Slug", "gd-content-tools"), 'external-link-square');

        $this->register_basic_field('special', 'info', __("Information", "gd-content-tools"), 'external-link-square');

        do_action('gdcet_meta_init_basic_fields');

        foreach ($this->fields as $fields) {
            foreach ($fields as $field => $data) {
                $path = is_null($data['path']) ? GDCET_PATH.'meta/fields/'.$field.'/' : 
                                                 trailingslashit($data['path']);

                require_once($path.'field.php');

                if (file_exists($path.'global.php')) {
                    require_once($path.'global.php');
                }
            }
        }
    }

    public function get_metaboxes_list() {
        $list = array();

        foreach (gdcet_settings()->current['meta']['boxes'] as $id => $_data) {
            $list[$id] = $_data['label'];
        }

        return $list;
    }

    public function get_box_name_by_id($id) {
        if (isset(gdcet_settings()->current['meta']['boxes'][$id])) {
            return gdcet_settings()->current['meta']['boxes'][$id]['slug'];
        }

        return null;
    }

    public function get_box_data_by_slug($slug) {
        foreach (gdcet_settings()->current['meta']['boxes'] as $_data) {
            if ($_data['slug'] == $slug) {
                return $_data;
            }
        }

        return null;
    }

    /** @return gdcet_meta_legacy_box|gdcet_meta_meta_box  */
    public function get_box($id = 0, $blank = 'meta') {
        if ($id > 0 && isset(gdcet_settings()->current['meta']['boxes'][$id])) {
            $_data = gdcet_settings()->current['meta']['boxes'][$id];

            switch ($_data['type']) {
                case 'legacy':
                    return new gdcet_meta_legacy_box($_data);
                case 'meta':
                    return new gdcet_meta_meta_box($_data);
            }
        }

        switch ($blank) {
            case 'legacy':
                return new gdcet_meta_legacy_box();
            case 'meta':
                return new gdcet_meta_meta_box();
        }

        return null;
    }

    /** @return gdcet_meta_custom_field|gdcet_meta_simple_field  */
    public function get_field($id = 0, $blank = 'custom') {
        if ($id > 0 && isset(gdcet_settings()->current['meta']['fields'][$id])) {
            $_data = gdcet_settings()->current['meta']['fields'][$id];

            switch ($_data['type']) {
                case 'custom':
                    return new gdcet_meta_custom_field($_data);
                case 'simple':
                    return new gdcet_meta_simple_field($_data);
            }
        }

        switch ($blank) {
            case 'custom':
                return new gdcet_meta_custom_field();
            case 'simple':
                return new gdcet_meta_simple_field();
        }

        return null;
    }

    /** @return gdcet_meta_custom_field|gdcet_meta_simple_field  */
    public function get_box_by_slug($slug) {
        $_data = $this->get_box_data_by_slug($slug);

        if (!is_null($_data)) {
            switch ($_data['type']) {
                case 'legacy':
                    return new gdcet_meta_legacy_box($_data);
                case 'meta':
                    return new gdcet_meta_meta_box($_data);
            }
        }

        return null;
    }

    /** @return gdcet_meta_custom_field|gdcet_meta_simple_field  */
    public function get_field_by_slug($slug) {
        foreach (gdcet_settings()->current['meta']['fields'] as $_data) {
            switch ($_data['type']) {
                case 'custom':
                    if ($_data['slug'] == $slug) {
                        return new gdcet_meta_custom_field($_data);
                    }
                    break;
                case 'simple':
                    if ($_data['fields'][0]['basic']['slug'] == $slug) {
                        return new gdcet_meta_simple_field($_data);
                    }
                    break;
            }
        }

        return null;
    }
}
