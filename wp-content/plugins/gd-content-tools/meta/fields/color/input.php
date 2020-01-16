<?php

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'value="'.esc_attr($this->get_edit_value($index)).'"',
    'class="gdcet-control gdcet-control-color"'
);

?>
<input <?php echo join(' ', $_input_properties); ?> type="text" />
