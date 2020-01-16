<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_templates {
    public function __construct() {
        add_filter('single_template', array($this, 'single_template'));

        if (gdcet_settings()->get('templates_date')) {
            add_filter('date_template', array($this, 'date_template'));
        }

        if (gdcet_settings()->get('templates_intersect')) {
            add_filter('taxonomy_template', array($this, 'intersect_template'));
            add_filter('category_template', array($this, 'intersect_template'));
            add_filter('tag_template', array($this, 'intersect_template'));
            add_filter('archive_template', array($this, 'intersect_template'));
        }
    }

    public function intersect_template($template) {
        $templates = array();

        if (empty($templates)) {
            return $template;
        } else {
            return locate_template($templates);
        }
    }

    public function date_template($template) {
        $templates = array();

        $_permalinks = d4p_permalinks_enabled();
        $_post_type = gdcet_settings()->get('templates_date_cpt') ? get_query_var('post_type', '') : '';

        if (is_year()) {
            $year = intval(get_query_var('year'));
            if (empty($year) || $year == 0) {
                $year = intval(substr(get_query_var('m'), 0, 4));
            }

            if (!empty($_post_type)) {
                $templates[] = "archive-{$_post_type}-year-{$year}.php";
                $templates[] = "archive-{$_post_type}-{$year}.php";
                $templates[] = "archive-{$_post_type}-year.php";
            }

            $templates[] = "date-year-{$year}.php";
            $templates[] = "date-{$year}.php";
            $templates[] = "date-year.php";
        }

        if (is_month()) {
            if ($_permalinks) {
                $month = intval(get_query_var('monthnum'));
                $year = intval(get_query_var('year'));
            } else {
                $month = intval(substr(get_query_var('m'), 4, 2));
                $year = intval(substr(get_query_var('m'), 0, 4));
            }

            if (!empty($_post_type)) {
                $templates[] = "archive-{$_post_type}-month-{$year}-{$month}.php";
                $templates[] = "archive-{$_post_type}-month-{$month}.php";
                $templates[] = "archive-{$_post_type}-{$year}-{$month}.php";
                $templates[] = "archive-{$_post_type}-{$month}.php";
                $templates[] = "archive-{$_post_type}-month.php";
            }

            $templates[] = "date-month-{$year}-{$month}.php";
            $templates[] = "date-month-{$month}.php";
            $templates[] = "date-{$year}-{$month}.php";
            $templates[] = "date-{$month}.php";
            $templates[] = "date-month.php";
        }

        if (is_day()) {
            if ($_permalinks) {
                $day = intval(get_query_var('day'));
                $month = intval(get_query_var('monthnum'));
                $year = intval(get_query_var('year'));
            } else {
                $day = intval(substr(get_query_var('m'), 6, 2));
                $month = intval(substr(get_query_var('m'), 4, 2));
                $year = intval(substr(get_query_var('m'), 0, 4));
            }

            if (!empty($_post_type)) {
                $templates[] = "archive-{$_post_type}-day-{$year}-{$month}-{$day}.php";
                $templates[] = "archive-{$_post_type}-day-{$day}.php";
                $templates[] = "archive-{$_post_type}-{$year}-{$month}-{$day}.php";
                $templates[] = "archive-{$_post_type}-{$day}.php";
                $templates[] = "archive-{$_post_type}-day.php";
            }

            $templates[] = "date-day-{$year}-{$month}-{$day}.php";
            $templates[] = "date-day-{$day}.php";
            $templates[] = "date-{$year}-{$month}-{$day}.php";
            $templates[] = "date-{$day}.php";
            $templates[] = "date-day.php";
        }

        if (!empty($_post_type)) {
            $template[] = "archive-{$_post_type}.php";
        }

        $templates[] = "date.php";
        $templates[] = "archive.php";
        $templates[] = "index.php";

        if (empty($templates)) {
            return $template;
        } else {
            return locate_template($templates);
        }
    }

    public function single_template($template) {
        $object = get_queried_object();

        $templates = array();

        $post_template = get_post_meta($object->ID, '_wp_post_template', true);
        if ($post_template != '') {
            $templates[] = $post_template;
        }

        if (gdcet_settings()->get('templates_single')) {
            $templates[] = "single-{$object->post_type}-{$object->post_name}.php";
            $templates[] = "single-{$object->post_type}-{$object->ID}.php";
            $templates[] = "single-{$object->post_name}.php";
            $templates[] = "single-{$object->ID}.php";
            $templates[] = "single-{$object->post_type}.php";
            $templates[] = "single.php";
            $templates[] = "index.php";
        }

        if (empty($templates)) {
            return $template;
        } else {
            return locate_template($templates);
        }
    }
}
