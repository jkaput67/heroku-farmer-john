<?php

function gdcet_render_select($values, $args = array()) {
    $defaults = array('selected' => '', 'name' => '', 'id' => '', 'class' => '', 'style' => '', 'echo' => true);
    $args = wp_parse_args($args, $defaults);
    extract($args);

    $render = '';
    $attributes = array();
    $selected = (array)$selected;

    if ($class != '') {
        $attributes[] = 'class="'.$class.'"';
    }

    if ($style != '') {
        $attributes[] = 'style="'.$style.'"';
    }

    if ($id != '') {
        $attributes[] = 'id="'.$id.'"';
    }

    if ($name != '') {
        $attributes[] = 'name="'.$name.'"';
    }

    $render.= '<select '.join(' ', $attributes).'>';
    foreach ($values as $value => $display) {
        $sel = in_array($value, $selected) ? ' selected="selected"' : '';
        $render.= '<option value="'.$value.'"'.$sel.'>'.$display.'</option>';
    }
    $render.= '</select>';

    if ($echo) {
        echo $render;
    } else {
        return $render;
    }
}

function gdcet_field_render_wrap_repeater_open($id = 0, $open = false, $echo = true) {
    $output = '<div class="gdcet-field-repeater'.($open ? ' gdcet-field-repeater-open' : '').'">
               <div class="gdcet-field-repeater-header">
               <span class="gdcet-field-repeater-id">'.$id.'</span>
               <div class="gdcet-field-repeater-buttons">
               <i class="dashicons dashicons-plus"></i><i 
                class="dashicons dashicons-minus"></i><i 
                class="dashicons dashicons-arrow-up-alt2"></i><i 
                class="dashicons dashicons-arrow-down-alt2"></i><i 
                class="dashicons dashicons-arrow-'.($open ? 'up' : 'down').'"></i>
               </div>
               </div>
               <div class="gdcet-field-repeater-inner">';

    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

function gdcet_field_render_wrap_repeater_close($id = 0, $open = false, $echo = true) {
    $output = '</div></div>';

    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}
