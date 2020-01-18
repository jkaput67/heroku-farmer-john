<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_postback {
    public $id = 0;
    public $name = '';
    public $object = null;

    public function __construct() {
        $page = isset($_POST['option_page']) ? $_POST['option_page'] : false;

        if ($page !== false) {
            if ($page == 'gd-content-tools-tools') {
                $this->tools();
            }

            if ($page == 'gd-content-tools-settings') {
                $this->settings();
            }

            if ($page == 'gd-content-tools-cpt') {
                $this->cpt();
            }

            if ($page == 'gd-content-tools-tax') {
                $this->tax();
            }

            do_action('gdcet_admin_postback_handler', $page);
        }
    }

    private function save_settings($panel) {
        d4p_includes(array(
            array('name' => 'walkers', 'directory' => 'admin'),
            array('name' => 'settings', 'directory' => 'admin')
        ), GDCET_D4PLIB);

        require_once(GDCET_PATH.'core/admin/options.php');

        $options = new gdcet_admin_data_options();
        $settings = $options->settings($panel);

        $processor = new d4pSettingsProcess($settings);
        $processor->base = 'gdcetvalue';

        $data = $processor->process();

        foreach ($data as $group => $values) {
            if (!empty($group)) {
                foreach ($values as $name => $value) {
                    $value = apply_filters('gdcet_settings_save_settings_value', $value, $name, $group);

                    gdcet_settings()->set($name, $value, $group);
                }

                gdcet_settings()->save($group);
            }
        }
    }

    private function tools() {
        check_admin_referer('gd-content-tools-tools-options');

        if (gdcet_admin()->panel == 'transfer-objects' || gdcet_admin()->panel == 'transfer-meta' || gdcet_admin()->panel == 'transfer-misc') {
            require_once(GDCET_PATH.'core/admin/transfer.php');
        } else if (gdcet_admin()->panel == 'remove') {
            $this->remove();
        } else if (gdcet_admin()->panel == 'import') {
            $this->import();
        }
    }

    private function import() {
        $url = gdcet_admin()->current_url(true);

        $message = 'import-failed';

        if (is_uploaded_file($_FILES['import_file']['tmp_name'])) {
            $raw = file_get_contents($_FILES['import_file']['tmp_name']);
            $data = maybe_unserialize($raw);

            if (is_object($data)) {
                gdcet_settings()->import_from_object($data);

                $message = 'imported';
            }
        }

        wp_redirect($url.'&message='.$message);
        exit;
    }

    private function remove() {
        $data = $_POST['gdcettools'];

        $remove = isset($data['remove']) ? (array)$data['remove'] : array();

        if (empty($remove)) {
            $message = '&message=nothing-removed';
        } else {
            if (isset($remove['settings']) && $remove['settings'] == 'on') {
                gdcet_settings()->remove_plugin_settings_by_group('info');
                gdcet_settings()->remove_plugin_settings_by_group('core');
                gdcet_settings()->remove_plugin_settings_by_group('cache');
                gdcet_settings()->remove_plugin_settings_by_group('load');
                gdcet_settings()->remove_plugin_settings_by_group('settings');
            }

            if (isset($remove['addons']) && $remove['addons'] == 'on') {
                gdcet_settings()->remove_plugin_settings_by_group('addons');
            }

            if (isset($remove['cpt']) && $remove['cpt'] == 'on') {
                gdcet_settings()->remove_plugin_settings_by_group('cpt');
            }

            if (isset($remove['tax']) && $remove['tax'] == 'on') {
                gdcet_settings()->remove_plugin_settings_by_group('tax');
            }

            if (isset($remove['meta']) && $remove['meta'] == 'on') {
                gdcet_settings()->remove_plugin_settings_by_group('meta');
            }

            if (isset($remove['disable']) && $remove['disable'] == 'on') {
                deactivate_plugins('gd-content-tools/gd-content-tools.php', false, false);

                wp_redirect(admin_url('plugins.php'));
                exit;
            }
        }

        wp_redirect(gdcet_admin()->current_url().$message);
        exit;
    }

    private function settings() {
        check_admin_referer('gd-content-tools-settings-options');

        $this->save_settings(gdcet_admin()->panel);

        wp_redirect(gdcet_admin()->current_url().'&message=saved');
        exit;
    }

    private function tax() {
        check_admin_referer('gd-content-tools-tax-options');

        d4p_includes(array(
            array('name' => 'walkers', 'directory' => 'admin'),
            array('name' => 'settings', 'directory' => 'admin')
        ), GDCET_D4PLIB);

        require_once(GDCET_PATH.'core/admin/objects.php');

        if (isset($_POST['gdcettax']) && isset($_POST['gdcettax']['mode']) && $_POST['gdcettax']['mode'] == 'named') {
            if (isset($_POST['gdcettax']['name'])) {
                $this->name = $_POST['gdcettax']['name'];
            }

            if (!taxonomy_exists($this->name)) {
                wp_redirect(gdcet_admin()->current_url(false));
                exit;
            }

            switch (gdcet_admin()->panel) {
                case 'features':
                    $this->tax_override_edit();
                    break;
                default:
                    wp_redirect(gdcet_admin()->current_url(false));
                    exit;
            }
        } else {
            if (isset($_POST['gdcettax']['id'])) {
                $this->id = intval($_POST['gdcettax']['id']);
            }

            switch (gdcet_admin()->panel) {
                case 'edit':
                case 'labels':
                case 'post_types':
                case 'features':
                case 'visibility':
                case 'rewrite':
                case 'capabilities':
                case 'permalinks':
                    $this->tax_edit();
                    break;
                default:
                    wp_redirect(gdcet_admin()->current_url(false));
                    exit;
            }
        }
    }

    private function tax_override_edit() {
        $options = new gdcet_admin_data_objects();
        $options->data = gdcet_ctrl()->get_tax_override($this->name);
        $options->tax_override();

        $settings = $options->settings(gdcet_admin()->panel);

        $processor = new d4pSettingsProcess($settings);
        $processor->base = 'gdcettax';

        $data = $processor->process();
        $data['settings']['taxonomy'] = $this->name;

        $merge = wp_parse_args($data['settings'], $options->data);
        $this->object = new gdcet_base_tax_override($merge);

        gdcet_admin()->feedback = false;

        gdcet_settings()->save_tax_override($this->object->get());

        wp_redirect(gdcet_admin()->current_url(false).'&message=tax-saved');
        exit;
    }

    private function tax_edit() {
        $options = new gdcet_admin_data_objects();
        $options->data = gdcet_ctrl()->get_tax($this->id);
        $options->tax();

        $settings = $options->settings(gdcet_admin()->panel);

        $processor = new d4pSettingsProcess($settings);
        $processor->base = 'gdcettax';

        $data = $processor->process();
        $data['settings']['_id'] = $this->id;

        $merge = wp_parse_args($data['settings'], $options->data);
        $this->object = new gdcet_base_tax($merge);

        $validation = $this->object->validate(gdcet_admin()->panel);

        if (d4p_is_wp_error($validation)) {
            gdcet_admin()->feedback = array(
                'errors' => $validation,
                'object' => $this->object->get()
            );
        } else {
            gdcet_admin()->feedback = false;

            $this->object->fill_labels();
            $this->object->fill_capabilities();

            gdcet_settings()->save_tax($this->object->get());

            flush_rewrite_rules();

            $msg = $this->id == 0 ? 'tax-created' : 'tax-saved';

            wp_redirect(gdcet_admin()->current_url(false).'&message='.$msg);
            exit;
        }
    }

    private function cpt() {
        check_admin_referer('gd-content-tools-cpt-options');

        d4p_includes(array(
            array('name' => 'walkers', 'directory' => 'admin'),
            array('name' => 'settings', 'directory' => 'admin')
        ), GDCET_D4PLIB);

        require_once(GDCET_PATH.'core/admin/objects.php');

        if (isset($_POST['gdcetcpt']) && isset($_POST['gdcetcpt']['mode']) && $_POST['gdcetcpt']['mode'] == 'named') {
            if (isset($_POST['gdcetcpt']['name'])) {
                $this->name = $_POST['gdcetcpt']['name'];
            }

            if (!post_type_exists($this->name)) {
                wp_redirect(gdcet_admin()->current_url(false));
                exit;
            }

            switch (gdcet_admin()->panel) {
                case 'taxonomies':
                case 'features':
                    $this->cpt_override_edit();
                    break;
                default:
                    wp_redirect(gdcet_admin()->current_url(false));
                    exit;
            }
        } else {
            if (isset($_POST['gdcetcpt']['id'])) {
                $this->id = intval($_POST['gdcetcpt']['id']);
            }

            switch (gdcet_admin()->panel) {
                case 'edit':
                case 'labels':
                case 'taxonomies':
                case 'features':
                case 'visibility':
                case 'rewrite':
                case 'capabilities':
                case 'permalinks':
                    $this->cpt_edit();
                    break;
                default:
                    wp_redirect(gdcet_admin()->current_url(false));
                    exit;
            }
        }
    }

    private function cpt_override_edit() {
        $options = new gdcet_admin_data_objects();
        $options->data = gdcet_ctrl()->get_cpt_override($this->name);
        $options->cpt_override();

        $settings = $options->settings(gdcet_admin()->panel);

        $processor = new d4pSettingsProcess($settings);
        $processor->base = 'gdcetcpt';

        $data = $processor->process();
        $data['settings']['post_type'] = $this->name;

        $merge = wp_parse_args($data['settings'], $options->data);
        $this->object = new gdcet_base_cpt_override($merge);

        gdcet_admin()->feedback = false;

        gdcet_settings()->save_cpt_override($this->object->get());

        wp_redirect(gdcet_admin()->current_url(false).'&message=cpt-saved');
        exit;
    }

    private function cpt_edit() {
        $options = new gdcet_admin_data_objects();
        $options->data = gdcet_ctrl()->get_cpt($this->id);
        $options->cpt();

        $settings = $options->settings(gdcet_admin()->panel);

        $processor = new d4pSettingsProcess($settings);
        $processor->base = 'gdcetcpt';

        $data = $processor->process();
        $data['settings']['_id'] = $this->id;

        $merge = wp_parse_args($data['settings'], $options->data);
        $this->object = new gdcet_base_cpt($merge);

        $validation = $this->object->validate(gdcet_admin()->panel);

        if (d4p_is_wp_error($validation)) {
            gdcet_admin()->feedback = array(
                'errors' => $validation,
                'object' => $this->object->get()
            );
        } else {
            gdcet_admin()->feedback = false;

            $this->object->fill_labels();
            $this->object->fill_capabilities();

            gdcet_settings()->save_cpt($this->object->get());

            flush_rewrite_rules();

            $msg = $this->id == 0 ? 'cpt-created' : 'cpt-saved';

            wp_redirect(gdcet_admin()->current_url(false).'&message='.$msg);
            exit;
        }
    }
}
