<?php

$_class = 'gdcet-control';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-textual';
}

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'class="'.$_class.'"',
    'placeholder="'.esc_attr($this->get_placeholder()).'"'
);

if ($this->is_required()) {
    $_input_properties[] = 'required';
}

$_value = $this->get_edit_value($index);
$_value = join("\r\n", $_value);

?>
<textarea <?php echo join(' ', $_input_properties); ?>><?php echo esc_textarea($_value); ?></textarea>