<?php

if (!defined('ABSPATH')) exit;

class d4pcetWidget_terms_list extends d4p_widget_core {
    public $widget_base = 'd4p_cet_terms_list';
    public $widget_domain = 'd4p_cet_widgets';
    public $cache_prefix = 'd4pcet';

    public $defaults = array(
        'title' => 'Terms List',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'post_types' => 'any',
        'taxonomy' => 'category',
        'hide_empty' => true,
        'mark_current' => true,
        'number' => 0,
        'orderby' => 'name',
        'order' => 'asc',
        'exclude' => '',
        'render' => 'list',
        'hierarchical' => true,
        'show_count' => true,
        'before' => '',
        'after' => ''
    );

    function __construct($id_base = false, $name = "", $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Display list of terms.", "gd-content-tools");
        $this->widget_name = 'GD Content Tools: '.__("Terms List", "gd-content-tools");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    function form($instance) {
        d4p_include('functions', 'admin', GDCET_D4PLIB);

        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-content-tools"), 'include' => array('shared-global', 'shared-display', 'shared-cache')),
            'content' => array('name' => __("Content", "gd-content-tools"), 'include' => array('terms-list-content')),
            'display' => array('name' => __("Display", "gd-content-tools"), 'include' => array('terms-list-display')),
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

//        $instance['exclude'] = d4p_sanitize_basic($new_instance['exclude']);
        $instance['post_types'] = d4p_sanitize_basic($new_instance['post_types']);
        $instance['taxonomy'] = d4p_sanitize_basic($new_instance['taxonomy']);
        $instance['orderby'] = d4p_sanitize_basic($new_instance['orderby']);
        $instance['order'] = d4p_sanitize_basic($new_instance['order']);
        $instance['render'] = d4p_sanitize_basic($new_instance['render']);

        $instance['hide_empty'] = isset($new_instance['hide_empty']);
        $instance['mark_current'] = isset($new_instance['mark_current']);
        $instance['hierarchical'] = isset($new_instance['hierarchical']);
        $instance['show_count'] = isset($new_instance['show_count']);

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

        gdcet_widget_render_header($instance, 'gdcet-widget-terms-list');

        if ($instance['post_types'] == 'any') {
            $instance['post_types'] = '';
        }

        unset($instance['title']);
        unset($instance['_class']);
        unset($instance['_tab']);
        unset($instance['_hook']);
        unset($instance['_display']);
        unset($instance['_cached']);

        include(gdcet_get_template_part('gdcet-widget-terms-list.php'));

        gdcet_widget_render_footer($instance);
    }
}
