<?php

if (!defined('ABSPATH')) exit;

class d4pcetWidget_post_types_list extends d4p_widget_core {
    public $widget_base = 'd4p_cet_post_types_list';
    public $widget_domain = 'd4p_cet_widgets';
    public $cache_prefix = 'd4pcet';

    public $defaults = array(
        'title' => 'Post Types List',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'list' => array(),
        'counts' => true,
        'current' => true,
        'before' => '',
        'after' => ''
    );

    function __construct($id_base = false, $name = "", $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Display links list of post types.", "gd-content-tools");
        $this->widget_name = 'GD Content Tools: '.__("Post Types List", "gd-content-tools");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    function form($instance) {
        d4p_include('functions', 'admin', GDCET_D4PLIB);

        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-content-tools"), 'include' => array('shared-global', 'shared-display', 'shared-cache')),
            'content' => array('name' => __("Content", "gd-content-tools"), 'include' => array('post-types-list-content'), 'class' => 'gdcet-tab-post-types-list'),
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
        $instance['counts'] = isset($new_instance['counts']);
        $instance['current'] = isset($new_instance['current']);

        $instance['list'] = array();
        if (isset($new_instance['list'])) {
            $instance['list'] = (array)$new_instance['list'];
        }

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

        gdcet_widget_render_header($instance, 'gdcet-widget-post-types-list');

        include(gdcet_get_template_part('gdcet-widget-post-types-list.php'));

        gdcet_widget_render_footer($instance);
    }
}
