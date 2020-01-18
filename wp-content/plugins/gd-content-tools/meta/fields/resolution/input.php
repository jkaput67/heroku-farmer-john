<?php

$_value = $this->get_edit_value($index);

$_class = 'gdcet-control';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-id';
}

$_input_properties_width = array(
    'id="'.$id_base.'-x"',
    'name="'.$name_base.'[x]"',
    'value="'.$_value['x'].'"',
    'class="'.$_class.'"',
    'min="0"', 'step="1"'
);

$_input_properties_height = array(
    'id="'.$id_base.'-y"',
    'name="'.$name_base.'[y]"',
    'value="'.$_value['y'].'"',
    'class="'.$_class.'"',
    'min="0"', 'step="1"'
);

?>

<div class="gdcet-multi-input-short">
    <span><?php _e("Width", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_width); ?> type="number" />
</div>
<div class="gdcet-multi-input-short">
    <span><?php _e("Height", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_height); ?> type="number" />
</div>