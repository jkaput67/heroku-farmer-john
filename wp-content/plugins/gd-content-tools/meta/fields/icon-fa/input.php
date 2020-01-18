<input type="hidden" name="<?php echo esc_attr($name_base); ?>" id="<?php echo esc_attr($id_base); ?>" value="<?php echo esc_attr($this->get_edit_value($index)); ?>" />
<?php

$_current_icon_selected = $this->get_edit_value($index);

include(GDCET_PATH.'meta/forms/select-fontawesome.php');
