<?php

if (!defined('ABSPATH')) exit;

class gdcet_wp_toolbar_menu {
    public function __construct() {
        add_action('admin_bar_menu', array($this, 'admin_bar_menu'), 100);

        add_action('admin_head', array($this, 'admin_bar_icon'));
        add_action('wp_head', array($this, 'admin_bar_icon'));
    }

    public function admin_bar_icon() { ?>
        <style type="text/css">
            .gdcet-toolbar-menu-icon > .ab-item {
                background-image: url("<?php echo gdcet()->svg_icon; ?>") !important;
                background-position: 10px center !important;
                background-repeat: no-repeat !important;
                background-size: 20px auto !important;
                padding: 0 10px 0 36px !important;
            }

            @media screen and ( max-width: 782px ) {
                #wpadminbar li#wp-admin-bar-gdcet-toolbar {
                    display: block;
                }

                .gdcet-toolbar-menu-icon > .ab-item {
                    width: 32px !important;
                    background-size: 32px auto !important;
                    padding: 0 10px !important;
                    text-indent: -1000px;
                }
            }
        </style>
    <?php }

    public function admin_bar_menu() {
        global $wp_admin_bar;

        $title = __("GD Content Tools", "gd-content-tools");

        $wp_admin_bar->add_menu(array(
            'id'     => 'gdcet-toolbar',
            'title'  => $title,
            'href'   => self_admin_url('admin.php?page=gd-content-tools-front'),
            'meta'   => array('class' => 'gdcet-toolbar-menu-icon')
        ));

        do_action('gdcet_wptoolbar_menu_items_top');

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar',
            'id'     => 'gdcet-cpt',
            'title'  => __("Post Types", "gd-content-tools"),
            'href'   => admin_url('admin.php?page=gd-content-tools-cpt')
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar',
            'id'     => 'gdcet-tax',
            'title'  => __("Taxonomies", "gd-content-tools"),
            'href'   => admin_url('admin.php?page=gd-content-tools-tax')
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar',
            'id'     => 'gdcet-boxes',
            'title'  => __("Meta Boxes", "gd-content-tools"),
            'href'   => admin_url('admin.php?page=gd-content-tools-boxes')
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar',
            'id'     => 'gdcet-fields',
            'title'  => __("Meta Fields", "gd-content-tools"),
            'href'   => admin_url('admin.php?page=gd-content-tools-fields')
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar',
            'id'     => 'gdcet-settings',
            'title'  => __("Settings", "gd-content-tools"),
            'href'   => admin_url('admin.php?page=gd-content-tools-settings')
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar',
            'id'     => 'gdcet-tools',
            'title'  => __("Tools", "gd-content-tools"),
            'href'   => admin_url('admin.php?page=gd-content-tools-tools')
        ));
            
        $wp_admin_bar->add_group(array(
            'parent' => 'gdcet-toolbar',
            'id'     => 'gdcet-toolbar-info',
            'meta'   => array('class' => 'ab-sub-secondary')
        ));

        do_action('gdcet_wptoolbar_menu_items_bottom');

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar-info',
            'id'     => 'gdcet-toolbar-info-links',
            'title'  => __("About and Help", "gd-content-tools")
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar-info-links',
            'id'     => 'gdcet-toolbar-about',
            'title'  => __("About", "gd-content-tools"),
            'href'   => admin_url('admin.php?page=gd-content-tools-about')
        ));

        $wp_admin_bar->add_group(array(
            'parent' => 'gdcet-toolbar-info-links',
            'id'     => 'gdcet-toolbar-info-links-web'
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar-info-links-web',
            'id'     => 'gdcet-toolbar-info-links-home',
            'title'  => __("Plugin Homepage", "gd-content-tools"),
            'href'   => 'https://plugins.dev4press.com/gd-content-tools/',
            'meta'   => array('target' => '_blank')
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar-info-links-web',
            'id'     => 'gdcet-toolbar-info-links-kb',
            'title'  => __("Knowledge Base", "gd-content-tools"),
            'href'   => 'https://support.dev4press.com/kb/product/gd-content-tools/',
            'meta'   => array('target' => '_blank')
        ));

        $wp_admin_bar->add_menu(array(
            'parent' => 'gdcet-toolbar-info-links-web',
            'id'     => 'gdcet-toolbar-info-links-forum',
            'title'  => __("Support Forum", "gd-content-tools"),
            'href'   => 'https://support.dev4press.com/forums/forum/plugins/gd-content-tools/',
            'meta'   => array('target' => '_blank')
        ));
    }
}
