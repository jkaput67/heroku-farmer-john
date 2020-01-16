<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_admin {
    public function __construct() {
        add_action('gdcet_admin_postback_handler', array($this, 'postback'));
        add_action('gdcet_admin_getback_handler', array($this, 'getback'));

        add_action('gdcet_metabox_user', array($this, 'metabox_user'));
        add_action('gdcet_metabox_term', array($this, 'metabox_term'), 10, 2);
        add_action('gdcet_metabox_post', array($this, 'metabox_post'), 10, 2);

        add_action('save_post', array($this, 'post_save'), 10, 2);
        add_action('gdcet_term_save', array($this, 'term_save'), 10, 1);
        add_action('gdcet_user_save', array($this, 'user_save'), 10, 1);
    }

    public function metabox_user($user_id) {
        $user = get_user_by('id', $user_id);
        $user_roles = (array)$user->roles;

        foreach (gdcet_settings()->current['meta']['boxes'] as $_data) {
            $add = isset($_data['types']['user_roles']) && array_intersect($user_roles, $_data['types']['user_roles']);

            if (apply_filters('gdcet_add_metabox_to_user_editor', $add, $_data, $user_roles, $user_id)) {
                gdcet_admin()->meta_boxes['users'][] = array(
                    'label' => $_data['label'],
                    'roles' => $_data['types']['user_roles'],
                    'callback' => array($this, 'user_metabox'), 
                    'args' => array(
                        'meta_box' => $_data['id']
                    )
                );
            }
        }
    }

    public function metabox_term($taxonomy, $term_id = 0) {
        foreach (gdcet_settings()->current['meta']['boxes'] as $_data) {
            $add = isset($_data['types']['taxonomies']) && in_array($taxonomy, $_data['types']['taxonomies']);

            if (apply_filters('gdcet_add_metabox_to_term_editor', $add, $_data, $taxonomy, $term_id)) {
                gdcet_admin()->meta_boxes['terms'][] = array(
                    'label' => $_data['label'],
                    'taxonomies' => $_data['types']['taxonomies'],
                    'callback' => array($this, 'term_metabox'), 
                    'args' => array(
                        'meta_box' => $_data['id']
                    )
                );
            }
        }
    }

    public function metabox_post($post_type, $post_id = 0) {
        foreach (gdcet_settings()->current['meta']['boxes'] as $_data) {
            $add = isset($_data['types']['post_types']) && in_array($post_type, $_data['types']['post_types']);

            if (apply_filters('gdcet_add_metabox_to_post_editor', $add, $_data, $post_type, $post_id)) {
                add_meta_box('gdcet-metabox-'.$_data['slug'], 
                    $_data['label'], 
                    array($this, 'post_metabox'), 
                    $post_type, 
                    $_data['location'], 
                    $_data['priority'],
                    array(
                        'meta_box' => $_data['id']
                    )
                );
            }
        }
    }

    public function getback($page) {
        if ($page == 'meta-fields') {
            if (isset($_GET['single-action']) && $_GET['single-action'] == 'delete') {
                $this->field_delete();
            }
        }

        if ($page == 'meta-boxes') {
            if (isset($_GET['single-action']) && $_GET['single-action'] == 'delete') {
                $this->box_delete();
            }
        }
    }

    public function field_delete() {
        check_ajax_referer('gdcet-admin-panel');

        $field_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        $msg = 'field-delete-failed';

        if ($field_id > 0) {
            $status = gdcet_settings()->delete_field($field_id);

            $msg = $status ? 'field-deleted' : 'field-delete-failed';
        }

        $url = gdcet_admin()->current_url().'&message='.$msg;

        wp_redirect($url);
        exit;
    }

    public function box_delete() {
        check_ajax_referer('gdcet-admin-panel');

        $box_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        $msg = 'box-delete-failed';

        if ($box_id > 0) {
            $status = gdcet_settings()->delete_box($box_id);

            $msg = $status ? 'box-deleted' : 'box-delete-failed';
        }

        $url = gdcet_admin()->current_url().'&message='.$msg;

        wp_redirect($url);
        exit;
    }

    public function postback() {
        if (isset($_POST['option_page']) && $_POST['option_page'] == 'gd-content-tools-meta-fields' && isset($_POST['gdcet']['field'])) {
            switch ($_POST['gdcettools']['panel']) {
                case 'index':
                    break;
                case 'simple':
                    $this->save_simple_field($_POST['gdcet']['field']);
                    break;
                case 'custom':
                    $this->save_custom_field($_POST['gdcet']['field']);
                    break;
            }
        }

        if (isset($_POST['option_page']) && $_POST['option_page'] == 'gd-content-tools-meta-boxes' && isset($_POST['gdcet']['box'])) {
            switch ($_POST['gdcettools']['panel']) {
                case 'index':
                    break;
                case 'meta':
                case 'legacy':
                    $this->save_meta_box($_POST['gdcet']['box']);
                    break;
            }
        }
    }

    public function save_meta_box($input) {
        $box = new gdcet_meta_legacy_box($input);

        $errors = $box->validate();

        if (!empty($errors->errors)) {
            gdcet_admin()->feedback = array(
                'errors' => $errors,
                'object' => $box->store()
            );
        } else {
            gdcet_admin()->feedback = false;

            $msg = $box->id == 0 ? 'box-created' : 'box-saved';

            gdcet_settings()->save_box($box->store());

            wp_redirect(gdcet_admin()->current_url(false).'&message='.$msg);
            exit;
        }
    }

    public function save_simple_field($input) {
        $field = new gdcet_meta_simple_field();
        $field->id = intval($input['id']);

        $data = $input['fields'][0];
        $type = $data['basic']['type'];

        $errors = new d4p_errors();

        if (gdcet_meta_is_basic_field_registered($type)) {
            $field->fields[0] = gdcet_meta_get_basic_field($type, $data);

            $errors = $field->fields[0]->validate(0);
        } else {
            $errors->add('invalid_type', __("Field type is invalid.", "gd-content-tools"));
        }

        if (!empty($errors->errors)) {
            gdcet_admin()->feedback = array(
                'errors' => $errors,
                'object' => $field->store()
            );
        } else {
            gdcet_admin()->feedback = false;

            $msg = $field->id == 0 ? 'field-created' : 'field-saved';

            gdcet_settings()->save_field($field->store());

            wp_redirect(gdcet_admin()->current_url(false).'&message='.$msg);
            exit;
        }
    }

    public function save_custom_field($input) {
        $field = new gdcet_meta_custom_field($input);

        $errors = $field->validate();

        if (!empty($errors->errors)) {
            gdcet_admin()->feedback = array(
                'errors' => $errors,
                'object' => $field->store()
            );
        } else {
            gdcet_admin()->feedback = false;

            $msg = $field->id == 0 ? 'field-created' : 'field-saved';

            gdcet_settings()->save_field($field->store());

            wp_redirect(gdcet_admin()->current_url(false).'&message='.$msg);
            exit;
        }
    }

    public function post_save($post_id, $post) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        gdcet_meta()->load_control();

        gdcet_control_meta()->save(array(
            'id' => absint($post->ID),
            'type' => 'post',
            'name' => $post->post_type
        ));
    }

    public function term_save($term_id) {
        $term = get_term(intval($term_id));

        gdcet_meta()->load_control();

        gdcet_control_meta()->save(array(
            'id' => absint($term_id),
            'type' => 'term',
            'name' => $term->taxonomy
        ));
    }

    public function user_save($user_id) {
        gdcet_meta()->load_control();

        gdcet_control_meta()->save(array(
            'id' => absint($user_id),
            'type' => 'user',
            'name' => 'user'
        ));
    }

    public function post_metabox($post, $callback_args) {
        gdcet_meta()->load_control();

        gdcet_control_meta()->render(array(
            'id' => intval($post->ID),
            'type' => 'post',
            'name' => $post->post_type,
            'metabox' => intval($callback_args['args']['meta_box']),
            'nonce' => wp_create_nonce('gdcet-metabox-'.$post->post_type.'-'.$post->ID.'-'.$callback_args['args']['meta_box']),
            'scope' => 'admin'
        ));
    }

    public function term_metabox($term, $callback_args) {
        gdcet_meta()->load_control();

        gdcet_control_meta()->render(array(
            'id' => intval($term->term_id),
            'type' => 'term',
            'name' => $term->taxonomy,
            'metabox' => intval($callback_args['args']['meta_box']),
            'nonce' => wp_create_nonce('gdcet-metabox-'.$term->taxonomy.'-'.$term->term_id.'-'.$callback_args['args']['meta_box']),
            'scope' => 'admin'
        ));
    }

    public function user_metabox($user, $callback_args) {
        gdcet_meta()->load_control();

        gdcet_control_meta()->render(array(
            'id' => intval($user->ID),
            'type' => 'user',
            'name' => 'user',
            'metabox' => intval($callback_args['args']['meta_box']),
            'nonce' => wp_create_nonce('gdcet-metabox-user-'.$user->ID.'-'.$callback_args['args']['meta_box']),
            'scope' => 'admin'
        ));
    }
}

global $_gdcet_meta_admin;

$_gdcet_meta_admin = new gdcet_meta_admin();

function gdcet_admin_meta() {
    global $_gdcet_meta_admin;
    return $_gdcet_meta_admin;
}
