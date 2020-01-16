<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_control {
    public function __construct() { }

    public function render($args) {
        $defaults = array(
            'id' => null, 'type' => null, 'name' => null, 
            'metabox' => null, 'nonce' => null, 'scope' => null
        );

        $_render_args = wp_parse_args($args, $defaults);

        include(GDCET_PATH.'meta/forms/metabox.php');
    }

    public function save($args) {
        $defaults = array(
            'id' => null, 'type' => null, 'name' => null, 'real_id' => null
        );

        $_save_args = wp_parse_args($args, $defaults);

        $request = isset($_REQUEST['gdcet-metabox']) ? (array)$_REQUEST['gdcet-metabox'] : array();

        if (!empty($request)) {
            foreach ($request as $data) {
                if ($data['init']['type'] == $_save_args['type'] && $data['init']['name'] == $_save_args['name'] && $data['init']['id'] == $_save_args['id']) {
                    $_nonce_value = $data['init']['nonce'];
                    $_nonce_action = 'gdcet-metabox-'.$data['init']['name'].'-'.$data['init']['id'].'-'.$data['init']['metabox'];

                    if (wp_verify_nonce($_nonce_value, $_nonce_action)) {
                        if (!is_null($_save_args['real_id'])) {
                            $data['init']['id'] = $_save_args['real_id'];
                        }

                        $this->save_metabox($data);
                    }
                }
            }
        }
    }

    private function save_metabox($data) {
        $_meta_box = gdcet_meta()->get_box($data['init']['metabox']);
        $_meta_box->prepare($data['init']['type'], $data['init']['id']);

        foreach ($_meta_box->data as $key => $field) {
            $_to_process = isset($data['fields'][$key]) ? $data['fields'][$key] : array();

            $field->process($_to_process);
        }

        $_meta_box->save($data['init']['type'], $data['init']['id']);
    }
}

global $_gdcet_meta_control;

$_gdcet_meta_control = new gdcet_meta_control();

function gdcet_control_meta() {
    global $_gdcet_meta_control;
    return $_gdcet_meta_control;
}
