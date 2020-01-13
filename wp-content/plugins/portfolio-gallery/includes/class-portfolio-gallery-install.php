<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Portfolio_Gallery_Install
{

    /**
     * Install Portfolio Gallery.
     */
    public static function install()
    {
        if (!defined('PORTFOLIO_GALLERY_INSTALLING')) {
            define('PORTFOLIO_GALLERY_INSTALLING', true);
        }
        self::create_tables();
        self::install_options();
        // Trigger action
        do_action('portfolio_gallery_installed');
    }

    private static function create_tables()
    {
        global $wpdb;
        $charset = $wpdb->get_charset_collate();

        $sql_huge_itportfolio_images = "
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "huge_itportfolio_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `portfolio_id` varchar(200) DEFAULT NULL,
  `description` text,
  `image_url` text,
  `sl_url` text DEFAULT NULL,
  `sl_type` text NOT NULL,
  `link_target` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(4) unsigned DEFAULT NULL,
  `published_in_sl_width` tinyint(4) unsigned DEFAULT NULL,
  `category` text NOT NULL,
  PRIMARY KEY (`id`)
  ) " . $charset . " AUTO_INCREMENT=5";

        $sql_huge_itportfolio_portfolios = "
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "huge_itportfolio_portfolios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `sl_height` int(11) unsigned DEFAULT NULL,
  `sl_width` int(11) unsigned DEFAULT NULL,
  `pause_on_hover` text,
  `portfolio_list_effects_s` text,
  `description` text,
  `param` text,
  `sl_position` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` text,
  `categories` text NOT NULL,
  `ht_show_sorting` varchar(3) NOT NULL DEFAULT 'off',
  `ht_show_filtering` varchar(3) NOT NULL DEFAULT 'off',
  `autoslide` varchar(5) NOT NULL DEFAULT 'on',
  `show_loading` varchar(3) NOT NULL DEFAULT 'on',
  `loading_icon_type` int(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) " . $charset . " AUTO_INCREMENT=2";

        $table_name = $wpdb->prefix . "huge_itportfolio_images";
        $sql_2 = "
INSERT INTO 

`" . $table_name . "` (`id`, `name`, `portfolio_id`, `description`, `image_url`, `sl_url`, `sl_type`, `link_target`, `ordering`, `published`, `published_in_sl_width`, `category` ) VALUES
(1, 'Cutthroat & Cavalier', '1', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/1.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/1.1.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/1.2.jpg" . ";', 'http://huge-it.com/wordpress-plugins-portfolio-gallery-demo/#plugin_demo_wrapper', 'image', 'on', 0, 1, NULL,'My_First_Category,My_Third_Category,'),
(2, 'Nespresso', '1', '<h6>Lorem Ipsum </h6><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><ul><li>lorem ipsum</li><li>dolor sit amet</li><li>lorem ipsum</li><li>dolor sit amet</li></ul>', '" . "https://vimeo.com/76602135" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/9.1.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/9.2.jpg" . ";', 'http://huge-it.com/wordpress-portfolio-gallery-demo-2-full-height-block/#plugin_demo_wrapper', 'video', 'on', 1, 1, NULL,'My_Second_Category,'),
(3, 'Nexus', '1', '<h6>Lorem Ipsum </h6><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrudexercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><ul><li>lorem ipsum</li><li>dolor sit amet</li><li>lorem ipsum</li><li>dolor sit amet</li></ul>', '" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/3.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/3.1.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/3.2.jpg" . ":" . "https://www.youtube.com/watch?v=YMQdfGFK5XQ" . ";', 'http://huge-it.com/wordpress-portfolio-gallery-demo-3-gallery-content-popup/#plugin_demo_wrapper', 'image', 'on', 2, 1, NULL,'My Third Category,'),
(4, 'De7igner', '1', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p><h7>Dolor sit amet</h7><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/4.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/4.1.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/4.2.jpg" . ";', 'http://huge-it.com/wordpress-portfolio-gallery-demo-4-full-width-block/#plugin_demo_wrapper', 'image', 'on', 3, 1, NULL,'My First Category,My Second Category,'),
(5, 'Autumn / Winter Collection', '1', '<h6>Lorem Ipsum</h6><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/2.jpg" . ";', 'http://huge-it.com/wordpress-portfolio-gallery-demo-5-faq-toggle-updown/#plugin_demo_wrapper', 'image', 'on', 4, 1, NULL,'My Second Category,My Third Category,'),
(6, 'Retro Headphones', '1', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/6.jpg" . ";" . "https://vimeo.com/80514062" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/6.1.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/6.2.jpg" . ";', 'http://huge-it.com/wordpress-portfolio-gallery-demo-6-content-slider/#plugin_demo_wrapper', 'image', 'on', 5, 1, NULL,'My Third Category,'),
(7, 'Take Fight', '1', '<h6>Lorem Ipsum</h6><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p><p>Excepteur sint occaecat cupidatat non proident , sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/7.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/7.2.jpg" . ";" . "https://www.youtube.com/watch?v=SP3Dgr9S4pM" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/7.3.jpg" . ";', 'http://huge-it.com/wordpress-portfolio-gallery-demo-7-lightbox-gallery/#plugin_demo_wrapper', 'image', 'on', 6, 1, NULL,'My Second Category,'),
(8, 'The Optic', '1', '<h6>Lorem Ipsum </h6><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><ul><li>lorem ipsum</li><li>dolor sit amet</li><li>lorem ipsum</li><li>dolor sit amet</li></ul>', '" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/8.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/8.1.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/8.3.jpg" . ";', 'http://huge-it.com/wordpress-plugins/', 'image', 'on', 7, 1, NULL,'My First Category,'),
(9, 'Cone Music', '1', '<ul><li>lorem ipsumdolor sit amet</li><li>lorem ipsum dolor sit amet</li></ul><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/5.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/5.1.jpg" . ";" . Portfolio_Gallery()->plugin_url() . "/assets/images/Front_images/projects/5.2.jpg" . ";', 'http://huge-it.com/portfolio-gallery/', 'image', 'on', 8, 1, NULL,'')";


        $table_name = $wpdb->prefix . "huge_itportfolio_portfolios";
        $wpdb->query($sql_huge_itportfolio_images);
        $wpdb->query($sql_huge_itportfolio_portfolios);

        if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "huge_itportfolio_images")) {
            $wpdb->query($sql_2);
        }
        if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "huge_itportfolio_portfolios")) {
            $wpdb->insert(
                $table_name,
                array(
                    'id' => 1,
                    'name' => 'My First Portfolio',
                    'sl_height' => 375,
                    'sl_width' => 600,
                    'pause_on_hover' => 'on',
                    'portfolio_list_effects_s' => '2',
                    'description' => '4000',
                    'param' => '1000',
                    'sl_position' => 'center',
                    'ordering' => 1,
                    'published' => '300',
                    'categories' => 'My_First_Category,My_Second_Category,My_Third_Category,',
                )
            );
        }
        $table_name = $wpdb->prefix . "huge_itportfolio_images";

        if (!self::isset_table_column($table_name, "huge_it_loadDate")) {
            $wpdb->query("ALTER TABLE `" . $table_name . "` ADD `huge_it_loadDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ");
        }


    }

    private static function isset_table_column($table_name, $column_name)
    {
        global $wpdb;
        $columns = $wpdb->get_results("SHOW COLUMNS FROM  " . $table_name, ARRAY_A);
        foreach ($columns as $column) {
            if ($column['Field'] == $column_name) {
                return true;
            }
        }

        return false;
    }

    public static function install_options()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'huge_itportfolio_params';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
            $query = "SELECT name,value FROM " . $table_name;
            $portfolio_gallery_table_params = $wpdb->get_results($query);
        }
        $portfolio_gallery_default_params = portfolio_gallery_get_default_general_options();


        $portfolio_options_exist = $wpdb->get_var('SELECT count(option_id) FROM ' . $wpdb->prefix . 'options WHERE `option_name` LIKE "portfolio_gallery_ht_view0%"');

        if (!$portfolio_options_exist) {
            if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
                if (count($portfolio_gallery_table_params) > 0) {
                    foreach ($portfolio_gallery_table_params as $portfolio_gallery_table_param) {
                        update_option('portfolio_gallery_' . $portfolio_gallery_table_param->name, $portfolio_gallery_table_param->value);
                    }
                }
            } else {
                foreach ($portfolio_gallery_default_params as $name => $value) {
                    update_option($name, $value);
                }
            }
        }

        if (!get_option('portfolio_gallery_admin_image_hover_preview')) {
            add_option('portfolio_gallery_admin_image_hover_preview', 'on');
        }

        $portfolio_new_columns = array(
            array('categories', 'varchar(200)', 'My_First_Category,My_Second_Category,My_Third_Category,'),
            array('ht_show_sorting', 'varchar(3)', 'off'),
            array('ht_show_filtering', 'varchar(3)', 'off'),
            array('autoslide', 'varchar(3)', 'on'),
            array('show_loading', 'varchar(3)', 'on'),
            array('loading_icon_type', 'int(2)', '1')
        );
        global $wpdb;
        $table_name = $wpdb->prefix . "huge_itportfolio_portfolios";
        foreach ($portfolio_new_columns as $portfolio_new_column) {
            if (!portfolio_gallery_isset_table_column($table_name, $portfolio_new_column[0])) {
                $query = "ALTER TABLE " . $table_name . " ADD " . $portfolio_new_column[0] . " " . $portfolio_new_column[1] . " DEFAULT '" . $portfolio_new_column[2] . "'";
                $wpdb->query($query);
            }
        }

        $store_view_options = array(
            'portfolio_gallery_ht_view8_title_font_size' => '16',
            'portfolio_gallery_ht_view8_title_font_color' => '0074A2',
            'portfolio_gallery_ht_view8_title_font_hover_color' => '2EA2CD',
            'portfolio_gallery_ht_view8_title_background_color' => '000000',
            'portfolio_gallery_ht_view8_hide_title' => 'off',
            'portfolio_gallery_ht_view8_title_background_transparency' => '80',
            'portfolio_gallery_ht_view8_border_width' => '0',
            'portfolio_gallery_ht_view8_element_background_color' => 'f9f9f9',
            'portfolio_gallery_ht_view8_border_color' => 'eeeeee',
            'portfolio_gallery_ht_view8_border_radius' => '0',
            'portfolio_gallery_ht_view8_width' => '275',
            'portfolio_gallery_ht_view8_image_title_font_size' => '16',
            'portfolio_gallery_ht_view8_image_title_font_color' => '0074A2',
            'portfolio_gallery_ht_view8_desc_font_size' => '20',
            'portfolio_gallery_ht_view8_desc_font_color' => '0074A2',
            'portfolio_gallery_ht_view8_show_sorting' => 'on',
            'portfolio_gallery_ht_view8_sortbutton_font_size' => '14',
            'portfolio_gallery_ht_view8_sortbutton_font_color' => '555555',
            'portfolio_gallery_ht_view8_sortbutton_hover_font_color' => 'ffffff',
            'portfolio_gallery_ht_view8_sortbutton_background_color' => 'F7F7F7',
            'portfolio_gallery_ht_view8_sortbutton_hover_background_color' => 'FF3845',
            'portfolio_gallery_ht_view8_sortbutton_border_width' => '0',
            'portfolio_gallery_ht_view8_sortbutton_border_padding' => '3',
            'portfolio_gallery_ht_view8_sorting_float' => 'top',
            'portfolio_gallery_ht_view8_sorting_name_by_default' => 'Default',
            'portfolio_gallery_ht_view8_sorting_name_by_id' => 'Date',
            'portfolio_gallery_ht_view8_sorting_name_by_name' => 'Title',
            'portfolio_gallery_ht_view8_sorting_name_by_random' => 'Random',
            'portfolio_gallery_ht_view8_sorting_name_by_asc' => 'Ascending',
            'portfolio_gallery_ht_view8_sorting_name_by_desc' => 'Descending',
            'portfolio_gallery_ht_view8_cat_all' => 'all',
            'portfolio_gallery_ht_view8_show_filtering' => 'on',
            'portfolio_gallery_ht_view8_filterbutton_font_size' => '14',
            'portfolio_gallery_ht_view8_filterbutton_font_color' => '555555',
            'portfolio_gallery_ht_view8_filterbutton_hover_font_color' => 'ffffff',
            'portfolio_gallery_ht_view8_filterbutton_background_color' => 'F7F7F7',
            'portfolio_gallery_ht_view8_filterbutton_hover_background_color' => 'FF3845',
            'portfolio_gallery_ht_view8_filterbutton_width' => '180',
            'portfolio_gallery_ht_view8_filterbutton_border_radius' => '0',
            'portfolio_gallery_ht_view8_filterbutton_border_padding' => '3',
            'portfolio_gallery_ht_view8_filterbutton_margin' => '',
            'portfolio_gallery_ht_view8_filtering_float' => 'left',

        );
        if (!get_option('portfolio_gallery_ht_view8_image_title_font_size')) {
            foreach ($store_view_options as $name => $value) {
                update_option($name, $value);
            }
        }
        $elastic_view_options = array(
            'portfolio_gallery_ht_view7_image_behaviour' => 'crop',
            'portfolio_gallery_ht_view7_element_width' => '250',
            'portfolio_gallery_ht_view7_element_height' => '150',
            'portfolio_gallery_ht_view7_element_margin' => '10',
            'portfolio_gallery_ht_view7_element_border_width' => '0',
            'portfolio_gallery_ht_view7_element_border_color' => 'DEDEDE',
            'portfolio_gallery_ht_view7_element_overlay_background_color_' => '484848',
            'portfolio_gallery_ht_view7_element_overlay_opacity' => '70',
            'portfolio_gallery_ht_view7_element_hover_effect' => 'true',
            'portfolio_gallery_ht_view7_filter_all_text' => 'All',
            'portfolio_gallery_ht_view7_filter_effect' => 'popup',
            'portfolio_gallery_ht_view7_hover_effect_delay' => '0',
            'portfolio_gallery_ht_view7_hover_effect_inverse' => 'false',
            'portfolio_gallery_ht_view7_expanding_speed' => '500',
            'portfolio_gallery_ht_view7_expand_block_height' => '500',
            'portfolio_gallery_ht_view7_element_title_font_size' => '16',
            'portfolio_gallery_ht_view7_element_title_font_color' => 'FFFFFF',
            'portfolio_gallery_ht_view7_element_title_align' => 'center',
            'portfolio_gallery_ht_view7_element_title_border_width' => '1',
            'portfolio_gallery_ht_view7_element_title_border_color' => 'FFFFFF',
            'portfolio_gallery_ht_view7_element_title_margin_top' => '40',
            'portfolio_gallery_ht_view7_element_title_padding_top_bottom' => '10',
            'portfolio_gallery_ht_view7_expand_block_background_color' => '222222',
            'portfolio_gallery_ht_view7_expand_block_opacity' => '100',
            'portfolio_gallery_ht_view7_expand_block_title_color' => 'd6d6d6',
            'portfolio_gallery_ht_view7_expand_block_title_font_size' => '35',
            'portfolio_gallery_ht_view7_expand_block_description_font_size' => '13',
            'portfolio_gallery_ht_view7_expand_block_description_font_color' => '999',
            'portfolio_gallery_ht_view7_expand_block_description_font_hover_color' => '999',
            'portfolio_gallery_ht_view7_expand_block_description_text_align' => 'left',
            'portfolio_gallery_ht_view7_expand_block_button_background_color' => '454545',
            'portfolio_gallery_ht_view7_expand_block_button_background_hover_color' => '454545',
            'portfolio_gallery_ht_view7_expand_block_button_text_color' => '9f9f9f',
            'portfolio_gallery_ht_view7_expand_block_button_font_size' => '11',
            'portfolio_gallery_ht_view7_expand_block_button_text' => 'View More',
            'portfolio_gallery_ht_view7_filter_button_font_hover_color' => 'fff',
            'portfolio_gallery_ht_view7_filter_button_background_color' => 'F7F7F7',
            'portfolio_gallery_ht_view7_filter_button_background_hover_color' => 'FF3845',
            'portfolio_gallery_ht_view7_filter_button_border_radius' => '0',
            'portfolio_gallery_ht_view7_expand_width' => '100',
            'portfolio_gallery_ht_view7_thumbnail_width' => '100',
            'portfolio_gallery_ht_view7_thumbnail_height' => '100',
            'portfolio_gallery_ht_view7_thumbnail_bg_color' => '313131',
            'portfolio_gallery_ht_view7_thumbnail_block_box_shadow' => 'on',
            'portfolio_gallery_ht_view7_filter_button_text' => 'All',
            'portfolio_gallery_ht_view7_filter_button_font_size' => '16',
            'portfolio_gallery_ht_view7_filter_button_font_color' => '444444',
            'portfolio_gallery_ht_view7_filter_button_bg_color_active' => '666',
            'portfolio_gallery_ht_view7_filter_button_padding' => '8',
            'portfolio_gallery_ht_view7_filter_button_radius' => '4',
            'portfolio_gallery_ht_view7_filter_button_font_active_color' => 'fff',
            'portfolio_gallery_ht_view7_show_all_filter_button' => 'on'
        );
        if (!get_option('portfolio_gallery_ht_view7_show_all_filter_button')) {
            foreach ($elastic_view_options as $name => $value) {
                update_option($name, $value);
            }
        }

        $lightbox_options = array(
            'portfolio_gallery_lightbox_slideAnimationType' => 'effect_1',
            'portfolio_gallery_lightbox_lightboxView' => 'view1',
            'portfolio_gallery_lightbox_speed_new' => '600',
            'portfolio_gallery_lightbox_width_new' => '100',
            'portfolio_gallery_lightbox_height_new' => '100',
            'portfolio_gallery_lightbox_videoMaxWidth' => '790',
            'portfolio_gallery_lightbox_overlayDuration' => '150',
            'portfolio_gallery_lightbox_overlayClose_new' => 'true',
            'portfolio_gallery_lightbox_loop_new' => 'true',
            'portfolio_gallery_lightbox_escKey_new' => 'true',
            'portfolio_gallery_lightbox_keyPress_new' => 'true',
            'portfolio_gallery_lightbox_arrows' => 'true',
            'portfolio_gallery_lightbox_mouseWheel' => 'true',
            'portfolio_gallery_lightbox_download' => 'false',
            'portfolio_gallery_lightbox_showCounter' => 'true',
            'portfolio_gallery_lightbox_nextHtml' => '',     //not used
            'portfolio_gallery_lightbox_prevHtml' => '',     //not used
            'portfolio_gallery_lightbox_sequence_info' => 'image',
            'portfolio_gallery_lightbox_sequenceInfo' => 'of',
            'portfolio_gallery_lightbox_slideshow_new' => 'true',
            'portfolio_gallery_lightbox_slideshow_auto_new' => 'false',
            'portfolio_gallery_lightbox_slideshow_speed_new' => '2500',
            'portfolio_gallery_lightbox_slideshow_start_new' => '',     //not used
            'portfolio_gallery_lightbox_slideshow_stop_new' => '',     //not used
            'portfolio_gallery_lightbox_watermark' => 'false',
            'portfolio_gallery_lightbox_socialSharing' => 'true',
            'portfolio_gallery_lightbox_facebookButton' => 'true',
            'portfolio_gallery_lightbox_twitterButton' => 'true',
            'portfolio_gallery_lightbox_googleplusButton' => 'true',
            'portfolio_gallery_lightbox_pinterestButton' => 'false',
            'portfolio_gallery_lightbox_linkedinButton' => 'false',
            'portfolio_gallery_lightbox_tumblrButton' => 'false',
            'portfolio_gallery_lightbox_redditButton' => 'false',
            'portfolio_gallery_lightbox_bufferButton' => 'false',
            'portfolio_gallery_lightbox_diggButton' => 'false',
            'portfolio_gallery_lightbox_vkButton' => 'false',
            'portfolio_gallery_lightbox_yummlyButton' => 'false',
            'portfolio_gallery_lightbox_watermark_text' => 'WaterMark',
            'portfolio_gallery_lightbox_watermark_textColor' => 'ffffff',
            'portfolio_gallery_lightbox_watermark_textFontSize' => '30',
            'portfolio_gallery_lightbox_watermark_containerBackground' => '000000',
            'portfolio_gallery_lightbox_watermark_containerOpacity' => '90',
            'portfolio_gallery_lightbox_watermark_containerWidth' => '300',
            'portfolio_gallery_lightbox_watermark_position_new' => '9',
            'portfolio_gallery_lightbox_watermark_opacity' => '70',
            'portfolio_gallery_lightbox_watermark_margin' => '10',
            'portfolio_gallery_lightbox_watermark_img_src_new' => PORTFOLIO_GALLERY_IMAGES_URL . '/admin_images/No-image-found.jpg',
            'portfolio_gallery_lightbox_type' => 'old_type'
        );

        if (!get_option('portfolio_gallery_lightbox_watermark_img_src_new')) {
            foreach ($lightbox_options as $name => $value) {
                update_option($name, $value);
            }
        }

        if (!get_option('portfolio_gallery_disable_right_click')) {
            update_option('portfolio_gallery_disable_right_click', 'off');
        }

    }
}