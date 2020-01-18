<?php

$_class = 'gdcet-control gdcet-control-month';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-textual';
}

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'value="'.esc_attr($this->get_edit_value($index)).'"',
    'class="'.$_class.'"'
);

if ($this->is_required()) {
    $_input_properties[] = 'required';
}

?>
<input <?php echo join(' ', $_input_properties); ?> type="text" />
