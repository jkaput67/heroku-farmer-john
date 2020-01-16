<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_getback {
    public function __construct() {
        if (gdcet_admin()->page === 'tools') {
            if (isset($_GET['run']) && $_GET['run'] == 'export') {
                $this->tools_export();
            }
        }

        if (gdcet_admin()->page === 'cpt') {
            if (isset($_GET['single-action']) && $_GET['single-action'] == 'duplicate') {
                $this->cpt_duplicate();
            }

            if (isset($_GET['single-action']) && $_GET['single-action'] == 'delete') {
                $this->cpt_delete();
            }
        }

        if (gdcet_admin()->page === 'tax') {
            if (isset($_GET['single-action']) && $_GET['single-action'] == 'duplicate') {
                $this->tax_duplicate();
            }

            if (isset($_GET['single-action']) && $_GET['single-action'] == 'delete') {
                $this->tax_delete();
            }
        }

        do_action('gdcet_admin_getback_handler', gdcet_admin()->page);
    }

    private function _load_maintenance() {
        require_once(GDCET_PATH.'core/admin/maintenance.php');
    }

    private function tools_export() {
        @ini_set('memory_limit', '128M');
        @set_time_limit(360);

        check_ajax_referer('dev4press-plugin-export');

        if (!d4p_is_current_user_admin()) {
            wp_die(__("Only administrators can use export features.", "gd-content-tools"));
        }

        $export_date = date('Y-m-d-H-m-s');

        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename="gd_content_tools_settings_'.$export_date.'.gdcet"');

        die(gdcet_settings()->serialized_export());
    }

    private function cpt_duplicate() {
        check_ajax_referer('gdcet-admin-panel');
    }

    private function cpt_delete() {
        check_ajax_referer('gdcet-admin-panel');

        $cpt_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        $msg = 'cpt-delete-failed';

        if ($cpt_id > 0) {
            $status = gdcet_settings()->delete_cpt($cpt_id);

            $msg = $status ? 'cpt-deleted' : 'cpt-delete-failed';
        }

        $url = gdcet_admin()->current_url().'&message='.$msg;

        wp_redirect($url);
        exit;
    }

    private function tax_duplicate() {
        check_ajax_referer('gdcet-admin-panel');
    }

    private function tax_delete() {
        check_ajax_referer('gdcet-admin-panel');

        $tax_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        $msg = 'tax-delete-failed';

        if ($tax_id > 0) {
            $status = gdcet_settings()->delete_tax($tax_id);

            $msg = $status ? 'tax-deleted' : 'tax-delete-failed';
        }

        $url = gdcet_admin()->current_url().'&message='.$msg;

        wp_redirect($url);
        exit;
    }
}
