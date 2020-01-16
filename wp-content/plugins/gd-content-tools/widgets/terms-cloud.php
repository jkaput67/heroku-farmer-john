<?php

if (!defined('ABSPATH')) exit;

class d4pcetWidget_terms_cloud extends d4p_widget_core {
    public $widget_base = 'd4p_cet_terms_cloud';
    public $widget_domain = 'd4p_cet_widgets';
    public $cache_prefix = 'd4pcet';

    public $defaults = array(
        'title' => 'Terms Cloud',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'post_types' => 'any',
        'taxonomy' => 'post_tag',
        'hide_empty' => true,
        'mark_current' => true,
        'orderby' => 'name',
        'order' => 'asc',
        'exclude' => '',
        'number' => 45,
        'smallest' => 8,
        'largest' => 22,
        'unit' => 'pt',
        'before' => '',
        'after' => ''
    );

    function __construct($id_base = false, $name = "", $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Display cloud of terms.", "gd-content-tools");
        $this->widget_name = 'GD Content Tools: '.__("Terms Cloud", "gd-content-tools");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    function form($instance) {
        d4p_include('functions', 'admin', GDCET_D4PLIB);

        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-content-tools"), 'include' => array('shared-global', 'shared-display', 'shared-cache')),
            'content' => array('name' => __("Content", "gd-content-tools"), 'include' => array('terms-cloud-content')),
            'display' => array('name' => __("Display", "gd-content-tools"), 'include' => array('terms-cloud-display')),
            'extra' => array('name' => __("Extra", "gd-content-tools"), 'include' => array('shared-wrapper'))
        );

        include(GDCET_PATH.'forms/widgets/shared-loader.php');
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        d4p_include('functions', 'admin', GDCET_D4PLIB);

        $instance['title'] = d4p_sanitize_basic($new_instance['title']);
        $instance['_display'] = d4p_sanitize_basic($new_instance['_display']);
        $instance['_class'] = d4p_sanitize_basic($new_instance['_class']);
        $instance['_tab'] = d4p_sanitize_basic($new_instance['_tab']);
        $instance['_hook'] = d4p_sanitize_extended($new_instance['_hook']);
        $instance['_cached'] = absint($new_instance['_cached']);

        $instance['number'] = absint($new_instance['number']);
        $instance['smallest'] = absint($new_instance['smallest']);
        $instance['largest'] = absint($new_instance['largest']);

        $instance['unit'] = d4p_sanitize_basic($new_instance['unit']);
//        $instance['exclude'] = d4p_sanitize_basic($new_instance['exclude']);
        $instance['post_types'] = d4p_sanitize_basic($new_instance['post_types']);
        $instance['taxonomy'] = d4p_sanitize_basic($new_instance['taxonomy']);
        $instance['orderby'] = d4p_sanitize_basic($new_instance['orderby']);
        $instance['order'] = d4p_sanitize_basic($new_instance['order']);

        $instance['hide_empty'] = isset($new_instance['hide_empty']);
        $instance['mark_current'] = isset($new_instance['mark_current']);

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['before'])));
            $instance['after'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['after'])));
        }

        return $instance;
    }

    function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        gdcet_widget_render_header($instance, 'gdcet-widget-terms-cloud');

        if ($instance['post_types'] == 'any') {
            $instance['post_types'] = '';
        }

        unset($instance['title']);
        unset($instance['_class']);
        unset($instance['_tab']);
        unset($instance['_hook']);
        unset($instance['_display']);
        unset($instance['_cached']);

        include(gdcet_get_template_part('gdcet-widget-terms-cloud.php'));

        gdcet_widget_render_footer($instance);
    }
}
