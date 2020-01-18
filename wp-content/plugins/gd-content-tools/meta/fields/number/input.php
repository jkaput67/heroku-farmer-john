<?php

$_class = 'gdcet-control';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-numerical';
}

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'value="'.esc_attr($this->get_edit_value($index)).'"',
    'class="'.$_class.'"',
    'placeholder="'.esc_attr($this->get_placeholder()).'"'
);

if ($this->is_required()) {
    $_input_properties[] = 'required';
}

if ($this->settings['has_min']) {
    $_input_properties[] = 'min="'.esc_attr($this->settings['min']).'"';
}

if ($this->settings['has_max']) {
    $_input_properties[] = 'max="'.esc_attr($this->settings['max']).'"';
}

if ($this->settings['allow_decimal']) {
    $_input_properties[] = 'step="any"';
} else if ($this->settings['has_step']) {
    $_input_properties[] = 'step="'.esc_attr($this->settings['step']).'"';
}

?>
<input <?php echo join(' ', $_input_properties); ?> type="number" />