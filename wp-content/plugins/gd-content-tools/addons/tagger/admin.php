<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_admin_tagger extends gdcet_addon_admin {
    public $prefix = 'tagger';

    public function __construct() {
        parent::__construct();

        add_filter('gdcet_admin_settings_panels', array($this, 'panels'));
        add_filter('gdcet_admin_internal_settings', array($this, 'settings'));
        add_filter('gdcet_admin_icon_tagger', array($this, 'icon'));

        add_action('gdcet_admin_enqueue_scripts_content', array($this, 'admin_enqueue_scripts_content'));

        add_action('wp_ajax_gdcet_tagger_search_tags', array($this, 'metabox_ajax'));
    }

    public function metabox_ajax() {
        check_ajax_referer('gdcet-admin-tagger');

        require_once(GDCET_PATH.'addons/tagger/api/tagger.php');

        $tags = array('tags' => array());
        $_tags = array();

        $api = d4p_sanitize_key_expanded($_POST['api']);
        $taxonomy = d4p_sanitize_key_expanded($_POST['taxonomy']);
        $content = d4p_sanitize_basic($_POST['content']);
        $title = d4p_sanitize_basic($_POST['title']);
        $url = d4p_sanitize_basic($_POST['url']);

        $tagger_core = new gdcet_tagger_api();

        switch ($api) {
            default:
            case 'internal':
                $_tags = (array)$tagger_core->get_tags_from_internal($title, $content);
                break;
            case 'dandelion':
                $_tags = (array)$tagger_core->get_tags_from_dandelion($title, $content, 60, gdcet_tagger()->get('dandelion_token'), gdcet_tagger()->get('dandelion_app_id'), gdcet_tagger()->get('dandelion_app_key'));
                break;
            case 'opencalais':
                $_tags = (array)$tagger_core->get_tags_from_opencalais($title, $content, 60, gdcet_tagger()->get('opencalais_api_token'));
                break;
        }

        $_tags = array_unique(array_filter($_tags));

        if (gdcet_tagger()->get('metabox_change_case') != 'no_change') {
            switch (gdcet_tagger()->get('metabox_change_case')) {
                case 'lowercase':
                    $_tags = array_map('strtolower', $_tags);
                    break;
                case 'uppercase':
                    $_tags = array_map('strtoupper', $_tags);
                    break;
                case 'sentencecase':
                    $_tags = array_map('ucfirst', $_tags);
                    break;
                case 'titlecase':
                    $_tags = array_map('ucwords', $_tags);
                    break;
            }
        }

        if (gdcet_tagger()->get('metabox_terms_priority')) {
            $_found = array();
            $_not_found = array();

            foreach ($_tags as $tag) {
                $term = get_term_by('name', $tag, $taxonomy);

                if ($term === false) {
                    $_not_found[] = $tag;
                } else {
                    $_found[] = array('name' => $tag, 'count' => intval($term->count));
                }
            }

            uasort($_found, array(&$this, 'sort_by_count'));

            $_tags = array();

            foreach ($_found as $tag) {
                $_tags[] = $tag['name'];
            }

            $_tags = array_merge($_tags, $_not_found);
        }

        $tags['tags'] = array_slice($_tags, 0, gdcet_tagger()->get('metabox_maximum_tags_to_show'));

        $response = json_encode($tags);

        die($response);
    }

    public function icon($icon) {
        return 'tags';
    }

    public function panels($panels) {
        $panels['addon_tagger'] = array(
            'title' => __("Tagger", "gd-content-tools"), 'icon' => 'tags', 'type' => 'addon', 
            'info' => __("Settings on this panel are for control over the Tagger.", "gd-content-tools"));

        return $panels;
    }

    public function settings($settings) {
        $settings['addon_tagger'] = array(
            'addt_metabox' => array('name' => __("Metabox integration", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('addons', gdcet_tagger()->key('metabox_taxonomies'), __("For taxonomies", "gd-content-tools"), __("Only public and non hierarchical taxonomies can be used for tagger.", "gd-content-tools"), d4pSettingType::CHECKBOXES, gdcet_tagger()->get('metabox_taxonomies'), 'array', gdcet_get_taxonomies(array('show_ui' => true, 'public' => true, 'hierarchical' => false), 'list')),
                new d4pSettingElement('addons', gdcet_tagger()->key('metabox_clearall'), __("Button: Clear All", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_tagger()->get('metabox_clearall'))
            )),
            'addt_metabox_terms' => array('name' => __("Metabox generating terms", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('addons', gdcet_tagger()->key('metabox_change_case'), __("Change terms case", "gd-content-tools"), '', d4pSettingType::SELECT, gdcet_tagger()->get('metabox_change_case'), 'array', array('no_change' => __("Don't change", "gd-content-tools"), 'lowercase' => __("Convert to lowercase", "gd-content-tools"), 'uppercase' => __("Convert to upercase", "gd-content-tools"), 'sentencecase' => __("Convert to sentence case", "gd-content-tools"), 'titlecase' => __("Convert to title case", "gd-content-tools"))),
                new d4pSettingElement('addons', gdcet_tagger()->key('metabox_maximum_tags_to_show'), __("Maximum terms to generate", "gd-content-tools"), '', d4pSettingType::INTEGER, gdcet_tagger()->get('metabox_maximum_tags_to_show'), '', '', array('min' => 0, 'max' => 1024)),
                new d4pSettingElement('addons', gdcet_tagger()->key('metabox_terms_priority'), __("Existing terms have priority", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_tagger()->get('metabox_terms_priority'))
            )),
            'addt_api_internal' => array('name' => __("Generator: Internal", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('addons', gdcet_tagger()->key('internal_active'), __("Status", "gd-content-tools"), __("Simple, internal terms extraction processor will generate plain terms from the text.", "gd-content-tools"), d4pSettingType::BOOLEAN, gdcet_tagger()->get('internal_active'))
            )),
            'addt_api_opencalais' => array('name' => __("Generator: OpenCalais", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('addons', gdcet_tagger()->key('opencalais_active'), __("Status", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_tagger()->get('opencalais_active')),
                new d4pSettingElement('addons', gdcet_tagger()->key('opencalais_api_token'), __("API Token", "gd-content-tools"), $this->_api_opencalais_info(), d4pSettingType::PASSWORD, gdcet_tagger()->get('opencalais_api_token'))
            )),
            'addt_api_dandelion' => array('name' => __("Generator: Dandelion", "gd-content-tools"), 'settings' => array(
                new d4pSettingElement('addons', gdcet_tagger()->key('dandelion_active'), __("Status", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_tagger()->get('dandelion_active')),
                new d4pSettingElement('addons', gdcet_tagger()->key('dandelion_token'), __("API Token", "gd-content-tools"), __("If your Dandelion account lists API access token, enter the token here. For old accounts, use API ID and API Key.", "gd-content-tools"), d4pSettingType::PASSWORD, gdcet_tagger()->get('dandelion_token')),
                new d4pSettingElement('addons', gdcet_tagger()->key('dandelion_app_id'), __("API ID", "gd-content-tools"), '', d4pSettingType::PASSWORD, gdcet_tagger()->get('dandelion_app_id')),
                new d4pSettingElement('addons', gdcet_tagger()->key('dandelion_app_key'), __("API Key", "gd-content-tools"), $this->_api_dandelion_info(), d4pSettingType::PASSWORD, gdcet_tagger()->get('dandelion_app_key'))
            ))
        );

        return $settings;
    }

    private function _api_opencalais_info() {
        return __("This must be valid API Token.", "gd-content-tools").'<br/><a target="_blank" href="http://new.opencalais.com/opencalais-api/">http://new.opencalais.com/opencalais-api/</a>';
    }

    private function _api_dandelion_info() {
        return __("These must be valid API ID and Key.", "gd-content-tools").'<br/><a target="_blank" href="https://dandelion.eu/">https://dandelion.eu/</a>';
    }

    public function admin_enqueue_scripts_content($hook) {
        if ($hook == 'post.php' || $hook == 'post-new.php') {
            global $post;

            $base_url = GDCET_URL.'addons/tagger/';

            wp_enqueue_style('gdcet-tagger', gdcet_admin()->file('css', 'tagger', false, true, $base_url), array('d4plib-metabox'), gdcet_settings()->file_version());
            wp_enqueue_script('gdcet-tagger', gdcet_admin()->file('js', 'tagger', false, true, $base_url), array('d4plib-metabox'), gdcet_settings()->file_version(), true);

            $_data = array(
                'nonce' => wp_create_nonce('gdcet-admin-tagger'),
                'wp_version' => GDCET_WPV,
                'url' => get_permalink($post->ID),
                'taxonomies' => gdcet_tagger()->get('metabox_taxonomies'),
                'clear_tags' => gdcet_tagger()->get('metabox_clearall') ? 1 : 0,
                'suggest_internal' => gdcet_tagger()->get('internal_active') ? 1 : 0, 
                'suggest_dandelion' => gdcet_tagger()->get('dandelion_active') && (gdcet_tagger()->get('dandelion_token') || (gdcet_tagger()->get('dandelion_app_key') && gdcet_tagger()->get('dandelion_app_id'))) != '' ? 1 : 0,
                'suggest_opencalais' => gdcet_tagger()->get('opencalais_active') && gdcet_tagger()->get('opencalais_api_token') != '' ? 1 : 0,
                'text_close' => __("Close", "gd-content-tools"),
                'text_refresh' => __("Refresh", "gd-content-tools"),
                'text_add_all' => __("Add All", "gd-content-tools"),
                'text_assigned_tags' => __("Currently assigned terms", "gd-content-tools"),
                'text_clear_all' => __("Clear", "gd-content-tools"),
                'text_internal' => __("Internal", "gd-content-tools"),
                'text_suggest' => __("Suggest terms from content", "gd-content-tools"),
                'text_no_tags_found' => __("No terms found", "gd-content-tools"),
                'text_getting_tags' => __("Please wait, getting terms...", "gd-content-tools"),
                'text_are_you_sure' => __("Are you sure?", "gd-content-tools")
            );

            wp_localize_script('gdcet-tagger', 'gdcet_tagger_data', $_data);
        }
    }
}

global $_gdcet_addon_admin_tagger;
$_gdcet_addon_admin_tagger = new gdcet_addon_admin_tagger();

function gdcet_admin_tagger() {
    global $_gdcet_addon_admin_tagger;
    return $_gdcet_addon_admin_tagger;
}
