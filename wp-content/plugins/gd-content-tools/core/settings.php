<?php

if (!defined('ABSPATH')) exit;

class gdcet_settings extends d4p_plugin_settings_core {
    public $base = 'gdcet';

    public $settings = array(
        'core' => array(
            'activated' => 0
        ),
        'cache' => array(
            'cpt' => array(),
            'tax' => array()
        ),
        'load' => array(),
        'addons' => array(),
        'cpt' => array(
            'id' => 1,
            'list' => array(),
            'override' => array()
        ),
        'tax' => array(
            'id' => 1,
            'list' => array(),
            'override' => array()
        ),
        'terms_images' => array(),
        'meta' => array(
            'boxes' => array(),
            'box_id' => 1,
            'fields' => array(),
            'field_id' => 1
        ),
        'tweaks' => array(
            'no_blocks_post' => false,
            'no_blocks_page' => false
        ),
        'settings' => array(
            'cronjob_hour_of_day' => 2,
            'templates_single' => true,
            'templates_date' => true,
            'templates_date_cpt' => true,
            'templates_intersect' => false,
            'widget_terms_list' => true,
            'widget_terms_cloud' => true,
            'widget_post_types_list' => true,
            'google_maps_api_key' => '',
            'meta_text_pattern' => true
        )
    );

    protected function constructor() {
        $this->info = new gdcet_core_info();

        add_action('gdcet_load_settings', array($this, 'init'), 2);
    }

    public function set($name, $value, $group = 'settings', $save = false) {
        $old = isset($this->current[$group][$name]) ? $this->current[$group][$name] : null;

        if ($old != $value) {
            do_action('gdcet_settings_value_changed', $name, $group, $old, $value);
        }

        parent::set($name, $value, $group, $save);
    }

    public function clear_cache() {
        $this->current['cache'] = array('cpt' => array(), 'tax' => array());

        $this->save('cache');
    }

    public function delete_box($id = 0) {
        if ($id > 0 && isset($this->current['meta']['boxes'][$id])) {
            unset($this->current['meta']['boxes'][$id]);

            $this->save('meta');

            return true;
        }

        return false;
    }

    public function save_box($data) {
        $id = $data['id'];

        if ($id == 0) {
            $id = $this->current['meta']['box_id'];

            $this->current['meta']['box_id']++;
        }

        $data['id'] = $id;

        $this->current['meta']['boxes'][$id] = $data;

        $this->save('meta');
    }

    public function delete_field($id = 0) {
        if ($id > 0 && isset($this->current['meta']['fields'][$id])) {
            unset($this->current['meta']['fields'][$id]);

            $this->save('meta');

            return true;
        }

        return false;
    }

    public function save_field($data) {
        $id = $data['id'];

        if ($id == 0) {
            $id = $this->current['meta']['field_id'];

            $this->current['meta']['field_id']++;
        }

        $data['id'] = $id;

        $this->current['meta']['fields'][$id] = $data;

        $this->save('meta');
    }

    public function delete_cpt($id) {
        if (isset($this->current['cpt']['list'][$id])) {
            unset($this->current['cpt']['list'][$id]);

            $this->save('cpt');

            return true;
        }

        return false;
    }

    public function save_cpt_override($data) {
        $this->current['cpt']['override'][$data['post_type']] = $data;

        $this->save('cpt');
    }

    public function save_cpt($data) {
        $id = $data['_id'];

        if ($id == 0) {
            $id = $this->current['cpt']['id'];

            $this->current['cpt']['id']++;
        }

        $data['_id'] = $id;

        $this->current['cpt']['list'][$id] = $data;

        $this->save('cpt');
    }

    public function delete_tax($id) {
        if (isset($this->current['tax']['list'][$id])) {
            unset($this->current['tax']['list'][$id]);

            $this->save('tax');

            return true;
        }

        return false;
    }

    public function save_tax_override($data) {
        $this->current['tax']['override'][$data['taxonomy']] = $data;

        $this->save('tax');
    }

    public function save_tax($data) {
        $id = $data['_id'];

        if ($id == 0) {
            $id = $this->current['tax']['id'];

            $this->current['tax']['id']++;
        }

        $data['_id'] = $id;

        $this->current['tax']['list'][$id] = $data;

        $this->save('tax');
    }

    public function legacy_set_term_image($taxonomy, $term, $image_id) {
        $term_id = gdcet_get_term_id($term);

        $this->current['terms_images'][$taxonomy][$term_id] = intval($image_id);

        $this->save('terms_images');
    }

    public function legacy_get_term_image($taxonomy, $term) {
        $term_id = gdcet_get_term_id($term);

        if (isset($this->current['terms_images'][$taxonomy][$term_id])) {
            return intval($this->current['terms_images'][$taxonomy][$term_id]);
        }

        return false;
    }

    public function legacy_delete_term_image($taxonomy, $term) {
        $term_id = gdcet_get_term_id($term);

        if (isset($this->current['terms_images'][$taxonomy][$term_id])) {
            unset($this->current['terms_images'][$taxonomy][$term_id]);
        }

        $this->save('terms_images');
    }

    public function legacy_convert_term_image($taxonomy, $term) {
        $term_id = gdcet_get_term_id($term);

        $image = $this->legacy_get_term_image($taxonomy, $term_id);

        if ($image !== false) {
            update_term_meta($term_id, '_gdcet_image', $image);

            $this->legacy_delete_term_image($taxonomy, $term_id);

            return $image;
        } else {
            return false;
        }
    }
}
