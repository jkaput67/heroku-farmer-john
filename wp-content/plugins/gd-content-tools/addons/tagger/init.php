<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_tagger_init extends gdcet_addon_init {
    public $prefix = 'tagger';

    public function __construct() {
        parent::__construct();

        add_action('gdcet_load_addon_tagger', array($this, 'load'), 2);
        add_filter('gdcet_info_addon_tagger', array($this, 'info'));
    }

    public function register() {
        gdcet_register_addon('tagger', __("Tagger", "gd-content-tools"));
    }

    public function settings() {
        $this->register_option('internal_active', false);
        $this->register_option('opencalais_active', false);
        $this->register_option('opencalais_api_token', '');
        $this->register_option('dandelion_active', false);
        $this->register_option('dandelion_app_id', '');
        $this->register_option('dandelion_app_key', '');
        $this->register_option('dandelion_token', '');

        $this->register_option('metabox_taxonomies', array('post_tag'));
        $this->register_option('metabox_clearall', false);
        $this->register_option('metabox_maximum_tags_to_show', 48);
        $this->register_option('metabox_change_case', 'no_change');
        $this->register_option('metabox_terms_priority', true);
    }

    public function info($info = array()) {
        return array('icon' => 'tags', 'description' => __("Generate terms for selected taxonomies for posts.", "gd-content-tools"));
    }

    public function load() {
        require_once(GDCET_PATH.'addons/tagger/load.php');
    }
}

$__gdcet_addon_tagger = new gdcet_addon_tagger_init();
