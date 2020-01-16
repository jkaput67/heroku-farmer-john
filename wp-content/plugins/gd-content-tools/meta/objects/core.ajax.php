<?php

if (!defined('ABSPATH')) exit;

class gdcet_meta_ajax {
    public function __construct() {
        add_action('wp_ajax_gdcet-metabox-repeater-field', array($this, 'repeater_field'));
        add_action('wp_ajax_nopriv_gdcet-metabox-repeater-field', array($this, 'repeater_field'));

        add_action('wp_ajax_gdcet-metabox-wp-search', array($this, 'wp_search'));
        add_action('wp_ajax_nopriv_gdcet-metabox-wp-search', array($this, 'wp_search'));

        add_action('wp_ajax_gdcet-metabox-wp-search-enhanced', array($this, 'wp_search_enhanced'));
        add_action('wp_ajax_nopriv_gdcet-metabox-wp-search-enhanced', array($this, 'wp_search_enhanced'));

        add_action('wp_ajax_gdcet-metabox-select-remote', array($this, 'select_remote'));
        add_action('wp_ajax_nopriv_gdcet-metabox-select-remote', array($this, 'select_remote'));
    }

    public function check_nonce($nonce = '_ajax_nonce', $action = 'gdcet-admin-internal') {
        $check = wp_verify_nonce($_REQUEST[$nonce], $action);

        if ($check === false) {
            wp_die(-1);
        }
    }

    public function select_remote() {
        $input = array_map('d4p_sanitize_basic', $_REQUEST);
        $this->check_nonce('nonce', 'gdcet-metabox-'.$input['name'].'-'.$input['id'].'-'.$input['metabox']);

        $function = isset($input['call']) ? $input['call'] : '';
        $functions = apply_filters('gdcet_meta_select_remote_sources', array());

        if (empty($function) || !isset($functions[$function])) {
            return array();
        }

        $page = isset($input['page']) ? absint($input['page']) : 1;
        $pager = isset($input['pager']) ? absint($input['pager']) : 25;

        $data = call_user_func($function, $input['q'], $page, $pager);

        $data['items'] = array();

        foreach ($data['filtered'] as $key => $val) {
            $data['items'][] = array(
                'id' => $key,
                'text' => $val
            );
        }

        unset($data['filtered']);

        wp_send_json($data);
    }

    public function wp_search_enhanced() {
        $input = array_map('d4p_sanitize_basic', $_REQUEST);
        $this->check_nonce('nonce', 'gdcet-metabox-'.$input['name'].'-'.$input['id'].'-'.$input['metabox']);

        $items = $this->_search($input);
        $data = array(
            'total_count' => 25,
            'items' => array()
        );

        foreach ($items as $item) {
            $data['items'][] = array(
                'id' => $item['id'],
                'text' => $item['first']
            );
        }

        wp_send_json($data);
    }

    public function wp_search() {
        $input = array_map('d4p_sanitize_basic', $_POST);
        $this->check_nonce('nonce', 'gdcet-metabox-'.$input['name'].'-'.$input['id'].'-'.$input['metabox']);

        $render = array();
        $items = $this->_search($input);

        foreach ($items as $item) {
            $r = '<li data-item="'.$item['id'].'">';
            $r.= '<span class="dashicons dashicons-no-alt"></span>';

            if ($item['image'] != '') {
                $r.= '<img src="'.$item['image'].'" title="'.$item['first'].'" />';
            }

            $r.= '<strong>'.$item['first'].'</strong>'.$item['second'];

            $r.= '</li>';

            $render[] = $r;
        }

        wp_send_json(array('items' => $render));
    }

    public function repeater_field() {
        $input = array_map('d4p_sanitize_basic', $_POST);
        $this->check_nonce('nonce', 'gdcet-metabox-'.$input['name'].'-'.$input['id'].'-'.$input['metabox']);

        require_once(GDCET_PATH.'meta/forms/functions.php');

        $index = intval($input['index']);
        $metabox = intval($input['metabox']);
        $field = d4p_sanitize_basic($input['field']);

        $inner = d4p_sanitize_basic($input['inner']);

        $output = array('index' => $index + 1, 'html' => '');

        $_meta_box = gdcet_meta()->get_box($metabox);
        $_meta_field = $_meta_box->data[$field];

        $_id = 'gdcet-metabox-'.$metabox.'-fields-';
        $_name = 'gdcet-metabox['.$metabox.'][fields]';

        if ($inner == '') {
            $output['html'] = gdcet_field_render_wrap_repeater_open($index, true, false);
            $output['html'].= $_meta_field->form($_id, $_name, $index, false, true);
            $output['html'].= gdcet_field_render_wrap_repeater_close($index, true, false);
        } else {
            $parent = intval($input['parent']);

            $_inner_field = $_meta_field->fields[$_meta_field->mapped[$inner]];

            $_id.= '-'.$field.'-'.$parent.'-'.$inner.'-'.$index;
            $_name.= '['.$field.']['.$parent.']['.$inner.']['.$index.']';

            $output['html'] = gdcet_field_render_wrap_repeater_open($index, true, false);
            $output['html'].= $_inner_field->form($_id, $_name, $index, false, true);
            $output['html'].= gdcet_field_render_wrap_repeater_close($index, true, false);
        }

        wp_send_json($output);
    }

    private function _search($input) {
        $method = $input['method'];
        $keyword = $input['keyword'];
        $filter = $input['filter'];
        $attr = $input['attr'];
        $pager = isset($input['pager']) ? absint($input['pager']) : 25;
        $page = isset($input['page']) ? absint($input['page']) : 1;

        $items = array();

        switch ($method) {
            case 'user':
                $items = $this->_data_user($keyword, $filter, $attr, $page, $pager);
                break;
            case 'term':
                $items = $this->_data_term($keyword, $filter, $attr, $page, $pager);
                break;
            case 'post':
                $items = $this->_data_post($keyword, $filter, $attr, $page, $pager);
                break;
        }

        return $items;
    }

    private function _data_user($keyword, $filter, $attr = null, $page = 1, $pager = 25) {
        $search = array('number' => $pager, 'orderby' => 'registered', 'order' => 'ASC', 'fields' => 'all');

        $page = $page - 1;

        if ($page >= 0) {
            $search['offset'] = $page * $pager;
        }

        if ($filter == 'authors') {
            $search['who'] = 'authors';
        } else if ($filter == 'roles') {
            $search['role'] = explode(',', $attr);
        }

        if ($keyword != '') {
            $search['search'] = '*'.$keyword.'*';
            $search['search_columns'] = array('user_login', 'user_nicename', 'user_email', 'user_url', 'ID');
        }

        $query = new WP_User_Query($search);
        $users = $query->get_results();

        $items = array();

        foreach ($users as $user) {
            $items[] = array(
                'id' => $user->ID,
                'first' => $user->display_name,
                'second' => $user->user_email,
                'image' => get_avatar_url($user->user_email, array('size' => 64))
            );
        }

        return $items;
    }

    private function _data_term($keyword, $filter, $attr = null, $page = 1, $pager = 25) {
        $search = array('number' => $pager, 'orderby' => 'name', 'order' => 'ASC', 'fields' => 'all', 'hide_empty' => false);

        $page = $page - 1;

        if ($page >= 0) {
            $search['offset'] = $page * $pager;
        }

        if ($keyword != '') {
            $search['search'] = $keyword;
        }

        if ($filter != '') {
            $search['taxonomy'] = $filter;
        }

        $terms = get_terms($search);

        $items = array();

        foreach ($terms as $term) {
            $items[] = array(
                'id' => $term->term_id,
                'first' => $term->name,
                'second' => $term->slug,
                'image' => ''
            );
        }

        return $items;
    }

    private function _data_post($keyword, $filter, $attr = null, $page = 1, $pager = 25) {
        $search = array('posts_per_page' => $pager, 'orderby' => 'date', 'order' => 'ASC', 'fields' => 'all');

        $page = $page - 1;

        if ($page >= 0) {
            $search['offset'] = $page * $pager;
        }

        if ($keyword != '') {
            $search['s'] = $keyword;
        }

        if ($filter != '') {
            $search['post_type'] = $filter;
        }

        $query = new WP_Query($search);
        $posts = $query->get_posts();

        $items = array();

        foreach ($posts as $post) {
            $item = array(
                'id' => $post->ID,
                'first' => $post->post_title,
                'second' => get_the_date('', $post),
                'image' => ''
            );

            if (has_post_thumbnail($post)) {
                $item['image'] = wp_get_attachment_thumb_url(get_post_thumbnail_id($post));
            }

            $items[] = $item;
        }

        return $items;
    }
}

global $_gdcet_meta_ajax;

$_gdcet_meta_ajax = new gdcet_meta_ajax();

function gdcet_ajax_meta() {
    global $_gdcet_meta_ajax;
    return $_gdcet_meta_ajax;
}
