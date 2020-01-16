<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_data_options {
    private $settings;

    function __construct() {
        $this->init();
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

    private function init() {
        $extensions = array(
            'addons' => array('name' => __("Addons", "gd-content-tools"), 'settings' => array())
        );

        foreach (gdcet()->addons as $addon => $obj) {
            $info = apply_filters('gdcet_info_addon_'.$addon, array('icon' => '', 'description' => ''));
            $label = ($info['icon'] != '' ? '<i class="'.d4p_get_icon_class($info['icon'], 'fw').'"></i> ' : '').$obj['label'];

            $key = substr($addon, 0, 8) == 'storage-' ? 'storages' : 'addons';

            $extensions[$key]['settings'][] =
                    new d4pSettingElement('load', $addon, $label, $info['description'], d4pSettingType::BOOLEAN, gdcet_settings()->get($addon, 'load'));
        }

        $this->settings = apply_filters('gdcet_admin_internal_settings', array(
            'addons' => $extensions,
            'global' => array(
                'global_background_job' => array('name' => __("Background Maintenance Job", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'cronjob_hour_of_day', __("Hour of the day to run", "gd-content-tools"), __("Maintenance job will run once a day at the specified hour. Set the time of day when you have smallest number of visitors (usually night time). Based on the server time.", "gd-content-tools"), d4pSettingType::SELECT, gdcet_settings()->get('cronjob_hour_of_day'), 'array', $this->data_list_cronjob_hours())
                ))
            ),
            'meta' => array(
                'meta_text' => array('name' => __("Text Field", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'meta_text_pattern', __("Pattern attribute", "gd-content-tools"), __("Use HTML5 pattern attribute, instead of the built in regular expression limiter.", "gd-content-tools"), d4pSettingType::BOOLEAN, gdcet_settings()->get('meta_text_pattern'))
                )),
                'meta_gapi' => array('name' => __("Google Maps", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'google_maps_api_key', __("API Key", "gd-content-tools"), __("To use Google Maps meta fields, you need to provide valid API Key.", "gd-content-tools").'<br/><a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">'.__("Instruction on how to get the API Key", "gd-content-tools").'</a>', d4pSettingType::TEXT, gdcet_settings()->get('google_maps_api_key'))
                ))
            ),
            'tweaks' => array(
                'tweaks_block' => array('name' => __("Block Editor", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('tweaks', 'no_blocks_post', __("For Posts", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('no_blocks_post', 'tweaks'), '', '', array('label' => __("Disable Block Editor", "gd-content-tools"))),
                    new d4pSettingElement('tweaks', 'no_blocks_page', __("For Pages", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('no_blocks_page', 'tweaks'), '', '', array('label' => __("Disable Block Editor", "gd-content-tools")))
                ))
            ),
            'templates' => array(
                'templates_single' => array('name' => __("Single posts templates", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'templates_single', __("Single templates", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('templates_single'))
                )),
                'templates_dates' => array('name' => __("Date archives templates", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'templates_date', __("Extra date templates", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('templates_date')),
                    new d4pSettingElement('settings', 'templates_date_cpt', __("Date templates for Post Types", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('templates_date_cpt'))
                )),
                'templates_intersect' => array('name' => __("Archives intersect templates", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'templates_intersect', __("Intersect templates", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('templates_intersect'))
                ))
            ),
            'widgets' => array(
                'widgets_extra' => array('name' => __("Extra Widgets", "gd-content-tools"), 'settings' => array(
                    new d4pSettingElement('settings', 'widget_terms_list', __("Terms List", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('widget_terms_list')),
                    new d4pSettingElement('settings', 'widget_terms_cloud', __("Terms Cloud", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('widget_terms_cloud')),
                    new d4pSettingElement('settings', 'widget_post_types_list', __("Post Types List", "gd-content-tools"), '', d4pSettingType::BOOLEAN, gdcet_settings()->get('widget_post_types_list'))
                ))
            )
        ));
    }

    private function data_list_cronjob_hours() {
        $hours = array();

        for ($i = 0; $i < 24; $i++) {
            $hours[$i] = $i;
        }

        return $hours;
    }
}
