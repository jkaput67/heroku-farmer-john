<?php

gdcet_load_units();

$_units = d4p_units();
$_length = $_units->get_unit_type_values('length');

$_value = $this->get_edit_value($index);

$_class = 'gdcet-control';
$_el_class = 'gdcet-multi-input-half';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-numerical';
}

$_input_properties_width = array(
    'id="'.$id_base.'-x-value"',
    'name="'.$name_base.'[x][value]"',
    'value="'.$_value['x']['value'].'"',
    'class="'.$_class.'"',
    'step="any"'
);

$_input_properties_height = array(
    'id="'.$id_base.'-y-value"',
    'name="'.$name_base.'[y][value]"',
    'value="'.$_value['y']['value'].'"',
    'class="'.$_class.'"',
    'step="any"'
);

$_input_properties_depth = array();

if ($this->s('type') == '3d') {
    $_el_class = 'gdcet-multi-input-third';

    $_input_properties_depth = array(
        'id="'.$id_base.'-z-value"',
        'name="'.$name_base.'[z][value]"',
        'value="'.$_value['z']['value'].'"',
        'class="'.$_class.'"',
        'step="any"'
    );
}

if ($this->is_required()) {
    $_input_properties_width[] = 'required';
    $_input_properties_height[] = 'required';

    if ($this->s('type') == '3d') {
        $_input_properties_depth[] = 'required';
    }
}

?>

<div class="<?php echo $_el_class; ?> gdcet-input-unit-based">
    <span><?php _e("Width", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_width); ?> type="number" /><?php 
    gdcet_render_select($_length, array('selected' => $_value['x']['unit'], 'id' => $id_base.'-x-value', 'name' => $name_base.'[x][unit]', 'class' => 'gdcet-control')); ?>
</div><div class="<?php echo $_el_class; ?> gdcet-input-unit-based">
    <span><?php _e("Height", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_height); ?> type="number" /><?php 
    gdcet_render_select($_length, array('selected' => $_value['y']['unit'], 'id' => $id_base.'-y-value', 'name' => $name_base.'[y][unit]', 'class' => 'gdcet-control')); ?>
</div><?php if ($this->s('type') == '3d') { ?><div class="<?php echo $_el_class; ?> gdcet-input-unit-based">
    <span><?php _e("Depth", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_depth); ?> type="number" /><?php 
    gdcet_render_select($_length, array('selected' => $_value['z']['unit'], 'id' => $id_base.'-z-value', 'name' => $name_base.'[z][unit]', 'class' => 'gdcet-control')); ?>
</div><?php }
