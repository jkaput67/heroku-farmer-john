<?php

if (!defined('ABSPATH')) exit;

class gdcet_bbpress_data_options {
    private $settings;

    function __construct($settings) {
        $this->init($settings);
    }

    public function get($panel, $group = '') {
        if ($group == '') {
            return $this->settings[$panel];
        } else {
            return $this->settings[$panel][$group];
        }
    }

    public function settings($panel) {
        $list = array();

        foreach ($this->settings[$panel] as $obj) {
            foreach ($obj['settings'] as $o) {
                $list[] = $o;
            }
        }

        return $list;
    }

    private function init($settings) {
        $this->settings = apply_filters('gdcet_bbpress_meta_rule', array(
            'rule' => array(
                'rule_basic' => array('name' => __("Basic settings", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('rule', 'id', '', '', d4pSettingType::HIDDEN, $settings['id']),
                    new d4pSettingElement('rule', 'label', __("Label", "gd-content-tools"), __("Used for descriptive purposes only.", "gd-content-tools"), d4pSettingType::TEXT, $settings['label'])
                )),
                'rule_metabox' => array('name' => __("Metabox", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('rule', 'metabox', __("Metabox", "gd-content-tools"), '', d4pSettingType::SELECT, $settings['metabox'], 'array', gdcet_meta()->get_metaboxes_list())
                )),
                'rule_forum' => array('name' => __("Forums", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('rule', 'scope', __("Scope", "gd-content-tools"), '', d4pSettingType::SELECT, $settings['scope'], 'array', array('all' => __("All Forums", "gd-content-tools"), 'forums' => __("Selected Forums", "gd-content-tools")), array('wrapper_class' => 'gdcet-bbpress-forums-scope')),
                    new d4pSettingElement('rule', 'forums', __("Forums", "gd-content-tools"), '', d4pSettingType::CHECKBOXES_HIERARCHY, $settings['forums'], 'array', gdcet_bbpress_forums_list(), array('wrapper_class' => 'gdcet-bbpress-forums-list'.($settings['scope'] == 'all' ? ' gdcet-hide' : '')))
                )),
                'rule_forms' => array('name' => __("Form Integration", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('rule', 'type', __("Forms Type", "gd-content-tools"), '', d4pSettingType::SELECT, $settings['type'], 'array', array('both' => __("Topic and Reply", "gd-content-tools"), 'topic' => __("Topic", "gd-content-tools"), 'reply' => __("Reply", "gd-content-tools"))),
                    new d4pSettingElement('rule', 'location', __("Location", "gd-content-tools"), '', d4pSettingType::SELECT, $settings['location'], 'array', array('before_content' => __("Before Content", "gd-content-tools"), 'after_content' => __("After Content", "gd-content-tools"), 'form_end' => __("Form End", "gd-content-tools"))),
                    new d4pSettingElement('rule', 'priority', __("Priority", "gd-content-tools"), '', d4pSettingType::INTEGER, $settings['priority']),
                    new d4pSettingElement('rule', 'roles', __("User Roles", "gd-content-tools"), __("Only users from selected roles will be able to see and fill meta fields.", "gd-content-tools"), d4pSettingType::CHECKBOXES, $settings['roles'], 'array', d4p_list_user_roles())
                )),
                'rule_style' => array('name' => __("Extra Styling", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('rule', 'wrapper', __("Wrapper", "gd-content-tools"), '', d4pSettingType::SELECT, $settings['wrapper'], 'array', array('default' => __("Default", "gd-content-tools"), 'fieldset' => __("Fieldset", "gd-content-tools"))),
                    new d4pSettingElement('rule', 'style', __("Style", "gd-content-tools"), '', d4pSettingType::SELECT, $settings['style'], 'array', array('default' => __("Default", "gd-content-tools"), 'light' => __("Light", "gd-content-tools")))
                ))
            )
        ));
    }
}
