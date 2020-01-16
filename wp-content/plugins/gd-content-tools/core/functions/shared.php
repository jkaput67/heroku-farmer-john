<?php

if (!defined('ABSPATH')) exit;

function gdcet_register_addon($name, $label, $autoload = true) {
    if (!isset(gdcet()->addons[$name])) {
        gdcet()->addons[$name] = array(
            'name' => $name, 
            'label' => $label, 
            'autoload' => $autoload);
    }
}

function gdcet_is_addon_valid($addon) {
    return isset(gdcet()->addons[$addon]);
}

function gdcet_is_addon_loaded($name) {
    return in_array($name, gdcet()->loaded);
}

function gdcet_widget_render_header($instance, $base_class = '') {
    $class = array('gdcet-widget-wrapper', $base_class);

    if ($instance['_class'] != '') {
        $class[] = $instance['_class'];
    }

    $render = '<div class="'.join(' ', $class).'">'.D4P_EOL;

    if ($instance['before'] != '') {
        $render.= '<div class="gdcet-widget-before">'.$instance['before'].'</div>';
    }

    echo $render;
}

function gdcet_widget_render_footer($instance) {
    $render = '';

    if ($instance['after'] != '') {
        $render.= '<div class="gdcet-widget-after">'.$instance['after'].'</div>';
    }

    $render.= '</div>';

    echo $render;
}

function gdcet_get_template_part($name, $fallback = '') {
    $found = false;

    foreach (array(STYLESHEETPATH, TEMPLATEPATH) as $path) {
        if (file_exists(trailingslashit($path).$name)) {
            $found = trailingslashit($path).$name;
            break;
        }
    }

    if ($found === false) {
        if (file_exists(GDCET_PATH.'theme/'.$name)) {
            $found = GDCET_PATH.'theme/'.$name;
        } else if (!empty($fallback)) {
            $found = GDCET_PATH.'theme/'.$fallback;
        }
    }

    return $found;
}

function gdcet_has_bbpress() {
    if (function_exists('bbp_version')) {
        $version = bbp_get_version();
        $version = intval(substr(str_replace('.', '', $version), 0, 2));

        return $version > 22;
    } else {
        return false;
    }
}

function gdcet_registered_post_types() {
    return gdcet_ctrl()->cpt_activated;
}

function gdcet_registered_taxonomies() {
    return gdcet_ctrl()->tax_activated;
}

function gdcet_load_units() {
    require_once(GDCET_PATH.'d4punits/d4p.units.php');
}

function gdcet_sort_terms_by_ID($a, $b) {
	if ( $a->term_id > $b->term_id )
		return 1;
	elseif ( $a->term_id < $b->term_id )
		return -1;
	else
		return 0;
}