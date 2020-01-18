<?php

$_class = 'gdcet-control';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-id';
}

$_value = $this->get_edit_value($index);

$_input_properties_year = array(
    'id="'.$id_base.'-year"',
    'name="'.$name_base.'[year]"',
    'value="'.esc_attr($_value['year']).'"',
    'class="'.$_class.'"', 
    'step="1"', 'min="0"'
);

$_input_properties_month = array(
    'id="'.$id_base.'-month"',
    'name="'.$name_base.'[month]"',
    'value="'.esc_attr($_value['month']).'"',
    'class="'.$_class.'"', 
    'step="1"', 'min="0"'
);

$_input_properties_day = array(
    'id="'.$id_base.'-day"',
    'name="'.$name_base.'[day]"',
    'value="'.esc_attr($_value['day']).'"',
    'class="'.$_class.'"', 
    'step="1"', 'min="0"'
);

$_input_properties_hour = array(
    'id="'.$id_base.'-hour"',
    'name="'.$name_base.'[hour]"',
    'value="'.esc_attr($_value['hour']).'"',
    'class="'.$_class.'"', 
    'step="1"', 'min="0"'
);

$_input_properties_minute = array(
    'id="'.$id_base.'-minute"',
    'name="'.$name_base.'[minute]"',
    'value="'.esc_attr($_value['minute']).'"',
    'class="'.$_class.'"', 
    'step="1"', 'min="0"'
);

$_input_properties_second = array(
    'id="'.$id_base.'-second"',
    'name="'.$name_base.'[second]"',
    'value="'.esc_attr($_value['second']).'"',
    'class="'.$_class.'"', 
    'step="1"', 'min="0"'
);

?>

<div class="gdcet-multi-input-sixth">
    <span><?php _e("Years", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_year); ?> type="number" />
</div><div class="gdcet-multi-input-sixth">
    <span><?php _e("Months", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_month); ?> type="number" />
</div><div class="gdcet-multi-input-sixth">
    <span><?php _e("Days", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_day); ?> type="number" />
</div><div class="gdcet-multi-input-sixth">
    <span><?php _e("Hours", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_hour); ?> type="number" />
</div><div class="gdcet-multi-input-sixth">
    <span><?php _e("Minutes", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_minute); ?> type="number" />
</div><div class="gdcet-multi-input-sixth">
    <span><?php _e("Seconds", "gd-content-tools"); ?>:</span>
    <input <?php echo join(' ', $_input_properties_second); ?> type="number" />
</div>