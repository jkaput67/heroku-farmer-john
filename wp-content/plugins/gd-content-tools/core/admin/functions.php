<?php

if (!defined('ABSPATH')) exit;

function gdcet_array_to_string($a, $non_asc = array('supports', 'taxonomies'), $tab = '    ') {
    $p = array();

    foreach ($a as $name => $value) {
        if (is_array($value)) {
            $in = array();

            if (in_array($name, $non_asc)) {
                foreach ($value as $vl) {
                    $in[] = is_string($vl) ? "'".str_replace("'", "\'", $vl)."'" : $vl;
                }
            } else {
                foreach ($value as $code => $vl) {
                    if (is_bool($vl)) {
                        $v = $vl === false ? 'false' : 'true';
                    } else if (is_null($vl)) {
                        $v = 'null';
                    } else {
                        $v = is_string($vl) ? "'".str_replace("'", "\'", $vl)."'" : $vl;
                    }

                    $in[] = "'$code' => $v";
                }
            }

            if (empty($in)) {
                $p[] = sprintf("'%s' => array()", $name);
            } else {
                $p[] = sprintf("'%s' => array(%s%s)", $name, D4P_EOL.$tab.$tab, join(', '.D4P_EOL.$tab.$tab, $in));
            }
        } else {
            if (is_bool($value)) {
                $v = $value === false ? 'false' : 'true';
            } else if (is_null($value)) {
                $v = 'null';
            } else {
                $v = is_string($value) ? "'".str_replace("'", "\'", $value)."'" : $value;
            }

            $p[] = "'$name' => $v";
        }
    }

    return 'array('.D4P_EOL.$tab.join(', '.D4P_EOL.$tab, $p).')';
}

function gdcet_render_grouped_select($values, $args = array(), $attr = array()) {
    $defaults = array(
        'selected' => '', 'name' => '', 'id' => '', 'class' => '', 
        'style' => '', 'multi' => false, 'echo' => true, 'readonly' => false);
    $args = wp_parse_args($args, $defaults);
    extract($args);

    $render = '';
    $attributes = array();
    $selected = (array)$selected;
    $id = d4p_html_id_from_name($name, $id);

    if ($class != '') {
        $attributes[] = 'class="'.$class.'"';
    }

    if ($style != '') {
        $attributes[] = 'style="'.$style.'"';
    }

    if ($multi) {
        $attributes[] = 'multiple';
    }

    if ($readonly) {
        $attributes[] = 'readonly';
    }

    foreach ($attr as $key => $value) {
        $attributes[] = $key.'="'.esc_attr($value).'"';
    }

    $name = $multi ? $name.'[]' : $name;

    if ($id != '') {
        $attributes[] = 'id="'.$id.'"';
    }

    if ($name != '') {
        $attributes[] = 'name="'.$name.'"';
    }

    $render.= '<select '.join(' ', $attributes).'>';
    foreach ($values as $group) {
        $render.= '<optgroup label="'.$group['title'].'">';
        foreach ($group['values'] as $value => $el) {
            $sel = in_array($value, $selected) ? ' selected="selected"' : '';

            if (is_array($el)) {
                $display = $el['label'];

                foreach ($el as $el_name => $el_val) {
                    if ($el_name == 'label') { continue; }
                    $sel.= ' '.$el_name.'="'.$el_val.'"';
                }
            } else {
                $display = $el;
            }

            $render.= '<option value="'.esc_attr($value).'"'.$sel.'>'.$display.'</option>';
        }
        $render.= '</optgroup>';
    }
    $render.= '</select>';

    if ($echo) {
        echo $render;
    } else {
        return $render;
    }
}
