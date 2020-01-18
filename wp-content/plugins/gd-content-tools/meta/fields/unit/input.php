<?php

gdcet_load_units();

$_units = d4p_units();
$_units->load($this->s('type'));
$_list_units = $_units->get_unit_type_values($this->s('type'));

$_value = $this->get_edit_value($index);

$_class = 'gdcet-control';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-id';
}

$_input_properties = array(
    'id="'.$id_base.'-value"',
    'name="'.$name_base.'[value]"',
    'value="'.$_value['value'].'"',
    'class="'.$_class.'"'
);

if ($this->is_required()) {
    $_input_properties[] = 'required';
}

?>

<div class="gdcet-multi-input-half gdcet-input-unit-based">
    <input <?php echo join(' ', $_input_properties); ?> type="number" /><?php 
    gdcet_render_select($_list_units, array('selected' => $_value['unit'], 'id' => $id_base.'-unit', 'name' => $name_base.'[unit]', 'class' => 'gdcet-control')); ?>
</div>