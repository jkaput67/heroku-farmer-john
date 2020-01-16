<?php

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'value="'.esc_attr($this->get_edit_value($index)).'"',
    'class="gdcet-control"',
    'placeholder="'.esc_attr($this->get_placeholder()).'"'
);

if ($this->is_required()) {
    $_input_properties[] = 'required';
}

?>
<input <?php echo join(' ', $_input_properties); ?> type="url" />