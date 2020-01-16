<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_shared_help {
    public static function post_type() {
        $screen = get_current_screen();

        $screen->add_help_tab(
            array(
                'id' => 'gdseo-help-cpt',
                'title' => __("Post Type", "gd-content-tools"),
                'content' => '<p>'.__("Post type settings are split into various panels. Make sure you read information provided for each option. Here are some additional resources you need to check out for setting up and using custom post types.", "gd-content-tools").'</p>'
                            .'<ul><li>WordPress.org: <a target="_blank" href="https://codex.wordpress.org/Function_Reference/register_post_type">Function - register_post_type</a></li>'
                            .'<li>Dev4Press.com: <a target="_blank" href="#">Setting up custom post type</a></li>'
                            .'</ul>'
            )
        );
    }

    public static function meta_boxes() {
        $screen = get_current_screen();

        $screen->add_help_tab(
            array(
                'id' => 'gdseo-help-boxes',
                'title' => __("Meta Boxes", "gd-content-tools"),
                'content' => '<p>'.__("There are two types of meta boxes supported by the plugin: Legacy and Meta. Here are some important things you need to know about them.", "gd-content-tools").'</p>'
                            .'<ul>'
                            .'<li>'.__("Legacy boxes are made for old GD Custom Posts and Taxonomies Tools Pro plugin compatibility purposes. They can contain only simple meta fields.", "gd-content-tools").'</li>'
                            .'<li>'.__("Each legacy or meta box can contain one or more fields. But, each field can be used only once. Make sure you don't use same field twice, or you will not be able to save the box.", "gd-content-tools").'</li>'
                            .'</ul>'
            )
        );

        $screen->add_help_tab(
            array(
                'id' => 'gdseo-help-code',
                'title' => __("Code Examples", "gd-content-tools"),
                'content' => '<p>'.__("For each meta box you can open 'Code' panel to see some example of the code for using meta box fields values in themes or other plugins.", "gd-content-tools").'</p>'
                            .'<ul>'
                            .'<li>'.__("Code integration requires basic PHP and WordPress knowledge, and if you are not sure what are you doing, do not try using the code on your own.", "gd-content-tools").'</li>'
                            .'<li>'.__("Examples don't include every possible way to use the code, it shows some common practices for handling meta boxes and data stored.", "gd-content-tools").'</li>'
                            .'<li>'.__("Examples don't include HTML layout and styling that you will need to format the data, that depends on your theme, layout you want to create, and you need to expand examples with that on your own.", "gd-content-tools").'</li>'
                            .'</ul>'
            )
        );
    }

    public static function meta_fields() {
        $screen = get_current_screen();

        $screen->add_help_tab(
            array(
                'id' => 'gdseo-help-fields',
                'title' => __("Meta Fields", "gd-content-tools"),
                'content' => '<p>'.__("Plugin includes more than 20 basic fields: text, number, select, image... These basic fields can't be used directly, they can be used to create meta fields.", "gd-content-tools").'</p>'
                            .'<p>'.__("There are two types of meta fields supported by the plugin: Simple and Custom. Here are some important things you need to know about them.", "gd-content-tools").'</p>'
                            .'<ul>'
                            .'<li>'.__("If you need a meta field with only one basic field, use the Simple Field. Custom Field can contain one or more basic fields.", "gd-content-tools").'</li>'
                            .'<li>'.__("Once a field is created, you can't change Custom field into Simple field, or Simple field into Custom field.", "gd-content-tools").'</li>'
                            .'<li>'.__("Changing basic field type is not recommended if you have data associated with the field. If you change the basic type, data associated with previous type can be lost due to the different data format most basic fields have.", "gd-content-tools").'</li>'
                            .'</ul>'
            )
        );
    }
}
