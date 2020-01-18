<?php

gdcet_load_units();

$_units = d4p_units();
$_units->load('currency_google');
$_currencies = $_units->get_unit_type_values('currency_google');

$_value = $this->get_edit_value($index);
$_class = 'gdcet-control';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-numerical';
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
    gdcet_render_select($_currencies, array('selected' => $_value['currency'], 'id' => $id_base.'-currency', 'name' => $name_base.'[currency]', 'class' => 'gdcet-control')); ?>
</div>